var abierto = document.getElementById('check').checked;

function clickMenuLabel(){
    $('#labMen').click(function(event){
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


function mostrarMenu(){
    $('.spaMenu').css('visibility','visible');
    $('.flesub').css('visibility','visible');
    $('.menu').css({opacity:0.9});
    $('.menu').css({ 'width':'300px'});
  
}

function cerrarMenu(){
    $('.botMen ul').fadeOut();
    $('.spaMenu').css('visibility','hidden');
    $('.flesub').css('visibility','hidden');
    $('.menu').css({opacity:1});
    $('.menu').css({ 'width':'60px'});
}

$(document).ready(function(){
    clickMenuLabel();
    clickMenu();
    if(abierto){
        $(window).trigger('click');
    }
});