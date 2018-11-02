var abierto = document.getElementById('check').checked;

function clickMenuLabel(){
    $('#menu').click(function(event){
        event.stopPropagation();
        if(abierto){
            abierto = !abierto;
            cerrarMenu();
        }else{
            abierto = !abierto;
            mostrarMenu();
        }
    });
    $('#check').click(function(event){
        event.stopPropagation();
    });
}

function clickMenu(){
    $(window).click(function() {
        if(abierto){
            $('#check').prop('checked',false);
            abierto = !abierto;
            cerrarMenu();
        }
    });
    $('.tamSubMenu').data('clicked',false);
    $('.tamSubMenu').click(function(){
        $('.tamSubMenu').data('clicked',true);
    });
    
    $('.botMen').click(function(event){
        event.stopPropagation();
        if(!abierto){
            event.preventDefault();
            $('#check').prop('checked',true);
            abierto = !abierto;
            mostrarMenu();
        }else{
            if ($('.tamSubMenu').data('clicked')) {
                $('.tamSubMenu').data('clicked',false);
            }else{
                var elementos = $(this).children;
                $(this).children().each(function(){
                    if($(this).is('ul')){
                        event.preventDefault();
                    }
                });
                $(this).children('ul').fadeToggle();
            }
        }
    });
}

function mostrarMenu(){
    $('.spaMenu').css('visibility','visible');
    $('.flesub').css('visibility','visible');
    $('.menu').css({opacity:0.9});
}

function cerrarMenu(){
    $('.botMen ul').fadeOut();
    $('.spaMenu').css('visibility','hidden');
    $('.flesub').css('visibility','hidden');
    $('.menu').css({opacity:1});
}

$(document).ready(function(){
    clickMenuLabel();
    clickMenu();
});