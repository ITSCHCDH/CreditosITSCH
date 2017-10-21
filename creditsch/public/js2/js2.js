
var band;
var band2=0;

/*Abre el menu al dar click en cualquier link del menu*/
$('.botMen').click(function() {
    if(band!=0){
        $('#check').prop('checked',true);
        $('.etSubMenu').css('visibility', 'visible');
        $('.spaMenu').css('visibility', 'visible');
        $('.flesub').css('visibility', 'visible');
    }else band=1;

    $(this).children('ul').fadeToggle();

    return true;
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

/*Expande la tabla de las alertas*/
$('.dropdown').click(function() {

    if(band2==0){
        $('.alertas').css('height', '100%');
        $('.alertas').css('z-index', '1000');
        band2=1;
    }
    else{
        $('.alertas').css('height', 'auto');
        $('.alertas').css('z-index', '0');
        band2=0;
    }
});

