// Dadas la division que contiene todas las pestañas y la de la pestaña que se 
// quiere mostrar, la funcion oculta todas las pestañas a excepcion de esa.
function cambiarPestanna(pestannas,pestanna) {
    
    // Obtiene los elementos con los identificadores pasados.
    pestanna = document.getElementById(pestanna.id);
    listaPestannas = document.getElementById(pestannas.id);
    
    // Obtiene las divisiones que tienen el contenido de las pestañas.
    cpestanna = document.getElementById('c'+pestanna.id);
    listacPestannas = document.getElementById('contenido'+pestannas.id);
    
    i=0;
    // Recorre la lista ocultando todas las pestañas y restaurando el
    // padding de las pestañas.
  while (typeof listacPestannas.getElementsByTagName('section')[i] != 'undefined'){
    $(document).ready(function(){
            $(listacPestannas.getElementsByTagName('section')[i]).css('display','none');
            $(listaPestannas.getElementsByTagName('li')[i]).css('padding-bottom','');
            $(listaPestannas.getElementsByTagName('li')[i]).css('background','');



        });
        i += 1;
    }

    $(document).ready(function(){
        // Muestra el contenido de la pestaña pasada como parametro a la funcion
        // y aumenta el padding para que tape el borde superior del contenido que
        // esta juesto debajo y se vea de este modo que esta seleccionada.
        $(cpestanna).css('display','');
        $(pestanna).css('padding-bottom','2px'); 
        $(pestanna).css('background','#000000'); 

    });

}