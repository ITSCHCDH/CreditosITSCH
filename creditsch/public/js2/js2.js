
var band=0;
var band2=0;
var bandSub=0;
var obj;

/*Abre el menu al dar click en cualquier link del menu*/
$('.botMen').click(function() {
    //Abre el menu
    if(band==0 ){
        $('#check').prop('checked',true);//Abre el menu
        $('.spaMenu').css('visibility', 'visible');//Muestra el texto de los menus
        $('.flesub').css('visibility', 'visible');//Muestra las flechas de los menus que tienen submenus
        band=1;  //Menu abierto
        return false;
    }
    else
    {
        //Si ya esta abierto el menu
        if($(this).find("li").length && bandSub==0)
        {
            //Si damos click en un elemento que tenga subMenus lo abre en forma de acordeon
            $(this).children('ul').fadeToggle();//Abre los submenus en caso de que el elemento los tenga
            $('.etSubMenu').css('visibility', 'visible');//Muetra el texto de los submenus
            bandSub=1; //SubMenu abierto
            obj=this;
            return false;
        }
        else if($(this).find("li").length && bandSub==1)
        {
            //Si damos click en un elemento subMenu abierto, lo cierra
            $(this).children('ul').fadeToggle();//Cierra los submenus en caso de que el elemento los tenga
            bandSub=0; //SubMenu cerrado
            return false;
        }
        else
        {
            $('#check').prop('checked',false);//Cierra el menu
            $('.spaMenu').css('visibility', 'hidden');//Oculta el texto de los menus
            $('.flesub').css('visibility', 'hidden');//Oculta las flechas de los menus que tienen submenus
            $(this).children('ul').fadeToggle();//Cierra los submenus en caso de que el elemento los tenga
            band=0; //Menu cerrado
            bandSub=0;
            window.open($(this).children('a').prop('href'),'_self');
            return false;
        }
    }
});

//Esta funcion evalua cuando se le da un click a un hijo para abrir la pagina y cerrar el menu
$('li li').click(function() {
    if (bandSub == 1) {
        //Si esta abierto y damos click en un subMenu
        $('#check').prop('checked', false);//Cierra el menu
        $('.etSubMenu').css('visibility', 'hidden');//Oculta el texto de los submenus
        $('.spaMenu').css('visibility', 'hidden');//Oculta el texto de los menus
        $('.flesub').css('visibility', 'hidden');//Oculta las flechas de los menus que tienen submenus
        $(this).parent().fadeToggle();//Contrae los submenus en caso de que el elemento los tenga
        band = 0;
        bandSub = 0;
        window.open($(this).children('a').prop('href'),'_self');
        return false;
    }
});

//Verifica el boton de menu para abrir o cerrar y acomoda bandeeras
$('#menu').click(function() {
    if (band == 0)
    {
        $('#check').prop('checked',true);
        $('.spaMenu').css('visibility', 'visible');//Muestra el texto de los menus
        $('.flesub').css('visibility', 'visible');//Muestra las flechas de los menus que tienen submenus
        band=1;
        return false;
    }
    else
    {
        $('.etSubMenu').css('visibility', 'hidden');//Oculta el texto de los submenus
        $('.spaMenu').css('visibility', 'hidden');//Oculta el texto de los menus
        $('.flesub').css('visibility', 'hidden');//Oculta las flechas de los menus que tienen submenus
        band=0;
        bandSub=0;
    }

});

//Verifica el click y si es en la pagina, cierra el menu
$('#cuerpo').click(function(){
    $('#check').prop('checked', false);//Cierra el menu
    $('.etSubMenu').css('visibility', 'hidden');//Oculta el texto de los submenus
    $('.spaMenu').css('visibility', 'hidden');//Oculta el texto de los menus
    $('.flesub').css('visibility', 'hidden');//Oculta las flechas de los menus que tienen submenus
    if (bandSub==1)
        $(obj).children('ul').fadeToggle();//Contrae los submenus en caso de que el elemento los tenga
    band=0;
    bandSub=0;
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

$(document).click(function(evt){
    //Cerramos el menu, dando clic en todo menos en los links,botones,submits,etc...
    if(evt.target.id=="idMenu" || evt.target.if=="menu" || $(evt.target).closest('a').length || $(evt.target).closest('button').length || $(evt.target).closest('input').length){
        return;
    }
    $('#check').prop('checked',false);//Cierra el menu
    $('.spaMenu').css('visibility', 'hidden');//Oculta el texto de los menus
    $('.flesub').css('visibility', 'hidden');//Oculta las flechas de los menus que tienen submenus
    $(this).children('ul').fadeToggle();//Cierra los submenus en caso de que el elemento los tenga
    $('.botMen .subMenu').fadeOut(); //Ocultamos todos los menus y submenus
    band=0; //Menu cerrado
    bandSub=0;
    window.open($(this).children('a').prop('href'),'_self');
    return false;
});