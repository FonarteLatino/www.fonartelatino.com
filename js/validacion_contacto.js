// JavaScript Document
$(document).on("ready", inicio2);

$("span.help-block").hide();//ocultamos las etiquetas de ayuda

function inicio2()
{
	
	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_nombre").keyup(validar_nombre2);
	$("#id_email").keyup(validar_email2);
	$("#id_telefono").keyup(validar_tel2);


	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_btn_contacto").click(validar_nombre2);
	$("#id_btn_contacto").click(validar_email2);
	$("#id_btn_contacto").click(validar_tel2);
	/*$("#id_btn_contacto").click(validar_leido);*/
	
}

/*==============================================================================================================*/
function validar_nombre2()
{
	var nombre = document.getElementById("id_nombre").value;

	if( nombre == null || nombre.length == 0 || /^\s+$/.test(nombre) ) //valida que no sea nulo
	{
		$("#id_nombre").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_nombre").parent().children("span").text("Nombre requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_nombre").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_nombre").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}
/*==============================================================================================================*/
function validar_email2()
{

	var email = document.getElementById("id_email").value;
	
	if( email == null || email.length == 0 || /^\s+$/.test(email) ) //valida que no sea nulo
	{
		$("#id_email").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_email").parent().children("span").text("Email requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else if( !(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w/.test(email)) ) 
	{
		$("#id_email").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_email").parent().children("span").text("Email invalido").show();//muestra el texto de ayuda
	  	return false;
	}
	else
	{
		$("#id_email").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_email").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function validar_tel2()
{
	var tel = document.getElementById("id_telefono").value;

	if( tel == null || tel.length == 0 || /^\s+$/.test(tel) ) //valida que no sea nulo
	{
		$("#id_telefono").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_telefono").parent().children("span").text("Telefono requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else if( !(/^\d{10}$/.test(tel)) ) 
	{
		$("#id_telefono").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_telefono").parent().children("span").text("Ingresa 10 digitos numericos").show();//muestra el texto de ayud
		return false;
	}
	else
	{
		$("#id_telefono").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_telefono").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
/*==============================================================================================================*/
//leido = document.getElementById("id_leido");
 
 /*
function validar_leido()
{
	//var leido = document.getElementById("id_leido").value;
	leido = document.getElementById("id_leido");
	if( !leido.checked ) //valida que no sea nulo
	{
		$("#id_leido").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_leido").parent().children("span").text("Selecciona la casilla").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_leido").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_leido").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}
*/


