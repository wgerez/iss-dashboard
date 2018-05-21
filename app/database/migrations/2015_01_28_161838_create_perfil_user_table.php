<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('perfil_user', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('perfil_id')->unsigned();
			$table->foreign('perfil_id')->references('id')->on('perfiles');
			$table->integer('user_id')->nullable()->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('usuario_alta',50)->nullable();
			$table->timestamp('fecha_alta')->nullable();
			$table->string('usuario_modi',50)->nullable();
			$table->timestamp('fecha_modi')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('perfil_user');
	}

}
