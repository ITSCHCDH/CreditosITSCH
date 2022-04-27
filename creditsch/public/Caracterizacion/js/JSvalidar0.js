// JavaScript Document 
// Validar campos vacios
function validarForm(form1,nombre,f){
	for(var j=1; j<f; j++) {
		if(!ValidarRadio(nombre, j)){
			return false;
		}
	}
	return true;
}
// *********************************************************
function ValidarRadio(id, flag){
	opciones = document.getElementsByName(id+flag);
	ultima = 0;
	var seleccionado = false;
	for(var i=0; i<opciones.length; i++) {    
	  if(opciones[i].checked) {
		  seleccionado = true;
		  break;
	  }
	}
	if(!seleccionado) {
		alert('No se selecciono opción en la pregunta '+ flag);
		opciones[0].focus();
		return false;
    }
	return true;
}