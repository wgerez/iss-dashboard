// Llamado cuando se cargue la página
posicionarMenu();

$(this).scroll(function() {
    posicionarMenu();
});

function posicionarMenu() {

    var altura_del_header = 116;
    var altura_del_menu = $('.actions').outerHeight(true);

    if ($(window).scrollTop() >= altura_del_header){
        $('.actions').addClass('fixed');
        $('.page-content').css('margin-top', (altura_del_menu) + 'px');
    } else {
        $('.actions').removeClass('fixed');
        $('.page-content').css('margin-top', '0');
    }
};