from __future__ import with_statement
from time import time

from fabric.api import cd, run, env, roles
from fabric.decorators import task
from fabric.contrib.files import exists

env.use_ssh_config = True


releases_dir = "/home/deploy/issadmin/releases"
git_branch = "master"
git_repo = "https://github.com/wgerez/iss-dashboard.git"
repo_dir = "/home/deploy/issadmin/repo"
persist_dir = "/home/deploy/issadmin/persist"
next_release = "%(time).0f" % {'time': time()}
current_release = "/home/deploy/issadmin/current"

env.roledefs = {
    'test': ['issqa'],
    'production': ['iss']
} 

@task
def deploy(migrate='no'):
    init()
    update_git()
    create_release()
    build_site()

    if migrate=='yes':
        migrate_from = "%s/%s" % (releases_dir, next_release)
        migrate_forward(migrate_from)

    swap_symlinks()

@task
def migrate():
    migrate_forward()

@task
def migrate_back():
    migrate_backward()

def migrate_forward(release_dir=None, env='production'):
    if not release_dir:
        release_dir=current_release
    with cd(release_dir):
        run('php artisan migrate --env=%s' % env)

def migrate_backward(release_dir=None, env='production'):
    if not release_dir:
        release_dir = current_release
    with cd(release_dir):
        run('php artisan migrate:rollback --env=%s' % env)

def init():
    if not exists(releases_dir):
        run("mkdir -p %s" % releases_dir)

    if not exists(repo_dir):
        run("git clone -b %s %s %s" % (git_branch, git_repo, repo_dir) )

    if not exists("%s/storage" % persist_dir):
        run("mkdir -p %s/storage/cache" % persist_dir)
        run("mkdir -p %s/storage/fonts" % persist_dir)
        run("mkdir -p %s/storage/logs" % persist_dir)
        run("mkdir -p %s/storage/meta" % persist_dir)
        run("mkdir -p %s/storage/sessions" % persist_dir)
        run("mkdir -p %s/storage/views" % persist_dir)

def update_git():
    with cd(repo_dir):
        run("git checkout %s" % git_branch)
        run("git pull origin %s" % git_branch)

def create_release():
    release_into = "%s/%s" % (releases_dir, next_release)
    run("mkdir -p %s" % release_into)
    with cd(repo_dir):
        run("git archive --worktree-attributes %s | tar -x -C %s" % (git_branch, release_into))

def build_site():
    with cd("%s/%s" % (releases_dir, next_release)):
        run("rm composer.lock")
        run("composer install")

def swap_symlinks():
    release_into = "%s/%s" % (releases_dir, next_release)

    run("ln -nfs %s/database.php %s/app/config/database.php" % (persist_dir, release_into))
    run("rm -rf %s/app/storage" % release_into)

    run("rm -rf %s/public/alumnos" % release_into)
    run("rm -rf %s/public/docentes" % release_into)

    run("ln -nfs %s/storage %s/app/storage" % (persist_dir, release_into))
    run("ln -nfs %s/alumnos %s/public/alumnos" % (persist_dir, release_into))
    run("ln -nfs %s/docentes %s/public/docentes" % (persist_dir, release_into))


    run("ln -nfs %s %s" % (release_into, current_release))

    run("sudo service php7.0-fpm reload")
