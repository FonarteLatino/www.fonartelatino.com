$(document).on("ready", inicio);

function inicio()
{
	$("span.help-block").hide();//ocultamos las etiquetas de ayuda
	
	//cuando preciona un atecla en cada caja de texto, ejecuta su validacion
	$("#id_nombre").keyup(validar_nombre);
	$("#id_apepat").keyup(validar_apepat);
	$("#id_apemat").keyup(validar_apemat);
	$("#id_email").keyup(validar_email);
	$("#id_email2").keyup(validar_email2);
	$("#id_psw").keyup(validar_psw);
	$("#id_psw2").keyup(validar_psw2);
	//$("#id_check_captcha").onlcick(validar_check_captcha);
	
	
	
	if(validar_nombre==true && validar_apepat==true && validar_apemat==true && validar_email==true && validar_email2==true && validar_psw==true && validar_psw2==true && valida_check_captcha==true)
	{
		$("#id_btn_registrar").click.submit();
	}
	else
	{		
		//si al dar click al boton todas las validaciones de campos estan en false, ejecuta sus validaciones
		$("#id_btn_registrar").click(validar_nombre);
		$("#id_btn_registrar").click(validar_apepat);
		$("#id_btn_registrar").click(validar_apemat);
		$("#id_btn_registrar").click(validar_email);
		$("#id_btn_registrar").click(validar_email2);
		$("#id_btn_registrar").click(validar_psw);
		$("#id_btn_registrar").click(validar_psw2);

	}
	
	
			
	

}



	
	
function validar_nombre()
{
	var nombre = document.getElementById("id_nombre").value;
	
	if( nombre == null || nombre.length == 0 || /^\s+$/.test(nombre) ) //valida que no sea nulo
	{
		$("#id_nombre").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_nombre").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else 
	{
		$("#id_nombre").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_nombre").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

function validar_apepat()
{
	var apepat = document.getElementById("id_apepat").value;
	
	
	if( apepat == null || apepat.length == 0 || /^\s+$/.test(apepat) ) //valida que no sea nulo
	{
		$("#id_apepat").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_apepat").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}	
	else
	{
		$("#id_apepat").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_apepat").parent().children("span").text("Campo requeridoj").hide();//muestra el texto de ayuda
  		return true;	
	}
}


function validar_apemat()
{
	var apemat = document.getElementById("id_apemat").value;

	/*============================= valida  campo apellido materno ===================================*/
	if( apemat == null || apemat.length == 0 || /^\s+$/.test(apemat) ) //valida que no sea nulo
	{
		$("#id_apemat").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_apemat").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_apemat").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_apemat").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}

}



function validar_email()
{

	var email = document.getElementById("id_email").value;
	
	if( email == null || email.length == 0 || /^\s+$/.test(email) ) //valida que no sea nulo
	{
		$("#id_email").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_email").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	
	else
	{
		$("#id_email").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_email").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}



function validar_email2()
{
	var email = document.getElementById("id_email").value;
	var email2 = document.getElementById("id_email2").value;
	//valida que no este nullo
	if( email2 == null || email2.length == 0 || /^\s+$/.test(email2) ) //valida que no sea nulo
	{
		$("#id_email2").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_email2").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	//valida que los email sean iguales
	else if(email!=email2)
	{
		$("#id_email2").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_email2").parent().children("span").text("Los email no coinciden").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_email2").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_email2").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}

}


function validar_psw()
{

	var psw = document.getElementById("id_psw").value;
	
	
	if( psw == null || psw.length == 0 || /^\s+$/.test(psw) ) //valida que no sea nulo
	{
		$("#id_psw").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_psw").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_psw").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_psw").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;	
	}


}


function validar_psw2()
{

	var psw = document.getElementById("id_psw").value;
	var psw2 = document.getElementById("id_psw2").value;
	
	/*============================= valida  campo psw 2 ===================================*/
	if( psw2 == null || psw2.length == 0 || /^\s+$/.test(psw2) ) //valida que no sea nulo
	{
		$("#id_psw2").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_psw2").parent().children("span").text("Campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else if(psw!=psw2)
	{
		$("#id_psw2").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_psw2").parent().children("span").text("Las contraseñas no coinciden").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_psw2").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_psw2").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
	
}

