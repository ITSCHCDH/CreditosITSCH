
var band;

/*Abre el menu al dar click en cualquier link del menu*/
$('.botMen').click(function() {
    if(band!=0){
        $('#check').prop('checked',true);
        $('.etSubMenu').css('visibility', 'visible');
        $('.spaMenu').css('visibility', 'visible');
        $('.flesub').css('visibility', 'visible');
    }else band=1;

    $(this).children('ul').fadeToggle();

    return false;
});

/*Cundo damos click a los submenu, compacta la vista del menu*/
$('li li').click(function() {
    $('#check').prop('checked',false);
    $('.etSubMenu').css('visibility', 'hidden');
    $('.spaMenu').css('visibility', 'hidden');
    $('.flesub').css('visibility', 'hidden');

    band=0;
});

/*Verifica el check y hace visible o invisible las etiquetas del menu*/
$('input[type=checkbox]').on('change', function() {
    if ($(this).is(':checked') ) {
        $('.etSubMenu').css('visibility', 'visible');
        $('.spaMenu').css('visibility', 'visible');
        $('.flesub').css('visibility', 'visible');
    } else {
        $('.etSubMenu').css('visibility', 'hidden');
        $('.spaMenu').css('visibility', 'hidden');
        $('.flesub').css('visibility', 'hidden');
    }
});