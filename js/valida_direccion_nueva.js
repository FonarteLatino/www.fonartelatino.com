// JavaScript Document
$(document).on("ready", inicio);

$("span.help-block").hide();//ocultamos las etiquetas de ayuda

function inicio()
{
	
	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	
	$("#id_calle").keyup(validar_calle);
	$("#id_colonia").keyup(validar_colonia);
	$("#id_muni_dele").keyup(validar_muni_dele);
	$("#id_cp").keyup(validar_cp);
	$("#id_n_ext").keyup(validar_n_ext);
	$("#id_n_int").keyup(validar_n_int);
	$("#id_pais").change(validar_pais);
	$("#id_estado").change(validar_estado);
	$("#id_entre_calle_1").keyup(validar_entre_calle_1);
	$("#id_entre_calle_2").keyup(validar_entre_calle_2);
	$("#id_nombre_recibe").keyup(validar_nombre_recibe);
	$("#id_tel_recibe").keyup(validar_tel_recibe);

	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_btn_enviar").click(validar_calle);
	$("#id_btn_enviar").click(validar_colonia);
	$("#id_btn_enviar").click(validar_muni_dele);
	$("#id_btn_enviar").click(validar_cp);
	$("#id_btn_enviar").click(validar_n_ext);
	$("#id_btn_enviar").click(validar_n_int);
	$("#id_btn_enviar").click(validar_pais);
	$("#id_btn_enviar").click(validar_estado);
	$("#id_btn_enviar").click(validar_entre_calle_1);
	$("#id_btn_enviar").click(validar_entre_calle_2);
	$("#id_btn_enviar").click(validar_nombre_recibe);
	$("#id_btn_enviar").click(validar_tel_recibe);
	

}

/*==============================================================================================================*/
function validar_calle()
{
	var calle = document.getElementById("id_calle").value;

	if( calle == null || calle.length == 0 || /^\s+$/.test(calle) ) //valida que no sea nulo
	{
		$("#id_calle").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_calle").parent().children("span").text("Calle es un campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_calle").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_calle").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function validar_colonia()
{
	var colonia = document.getElementById("id_colonia").value;

	if( colonia == null || colonia.length == 0 || /^\s+$/.test(colonia) ) //valida que no sea nulo
	{
		$("#id_colonia").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_colonia").parent().children("span").text("Colonia es un campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_colonia").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_colonia").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}


/*==============================================================================================================*/
function validar_muni_dele()
{
	var muni_dele = document.getElementById("id_muni_dele").value;

	if( muni_dele == null || muni_dele.length == 0 || /^\s+$/.test(muni_dele) ) //valida que no sea nulo
	{
		$("#id_muni_dele").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_muni_dele").parent().children("span").text("Municipio/Delegacion es un campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_muni_dele").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_muni_dele").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}


/*==============================================================================================================*/
function validar_cp()
{
	var cp = document.getElementById("id_cp").value;

	if( cp == null || cp.length == 0 || /^\s+$/.test(cp) ) //valida que no sea nulo
	{
		$("#id_cp").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_cp").parent().children("span").text("CP es un campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else if( isNaN(cp) ) 
	{
		$("#id_cp").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_cp").parent().children("span").text("El valor debe ser numerico").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_cp").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_cp").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}


/*==============================================================================================================*/
function validar_n_ext()
{
	var n_ext = document.getElementById("id_n_ext").value;

	if( n_ext == null || n_ext.length == 0 || /^\s+$/.test(n_ext) ) //valida que no sea nulo
	{
		$("#id_n_ext").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_n_ext").parent().children("span").text("En caso de no tener, poner NA").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_n_ext").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_n_ext").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function validar_n_int()
{
	var n_int = document.getElementById("id_n_int").value;

	if( n_int == null || n_int.length == 0 || /^\s+$/.test(n_int) ) //valida que no sea nulo
	{
		$("#id_n_int").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_n_int").parent().children("span").text("En caso de no tener, poner NA").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_n_int").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_n_int").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}



/*==============================================================================================================*/
function validar_pais()
{
	var pais = document.getElementById("id_pais").value;


	if( pais == null || pais == 0 ) 
	{
		$("#id_pais").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_pais").parent().children("span").text("Seleccione una opcion de la lista").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_pais").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_pais").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}


/*==============================================================================================================*/
function validar_estado()
{
	var estado = document.getElementById("id_estado").value;


	if( estado == null || estado == 0 ) 
	{
		$("#id_estado").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_estado").parent().children("span").text("Seleccione una opcion de la lista").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_estado").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_estado").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function validar_entre_calle_1()
{
	var entre_calle_1 = document.getElementById("id_entre_calle_1").value;

	if( entre_calle_1 == null || entre_calle_1.length == 0 || /^\s+$/.test(entre_calle_1) ) //valida que no sea nulo
	{
		$("#id_entre_calle_1").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_entre_calle_1").parent().children("span").text("En caso de no tener, poner NA").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_entre_calle_1").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_entre_calle_1").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function validar_entre_calle_2()
{
	var entre_calle_2 = document.getElementById("id_entre_calle_2").value;

	if( entre_calle_2 == null || entre_calle_2.length == 0 || /^\s+$/.test(entre_calle_2) ) //valida que no sea nulo
	{
		$("#id_entre_calle_2").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_entre_calle_2").parent().children("span").text("En caso de no tener, poner NA").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_entre_calle_2").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_entre_calle_2").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function validar_nombre_recibe()
{
	var nombre_recibe = document.getElementById("id_nombre_recibe").value;

	if( nombre_recibe == null || nombre_recibe.length == 0 || /^\s+$/.test(nombre_recibe) ) //valida que no sea nulo
	{
		$("#id_nombre_recibe").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_nombre_recibe").parent().children("span").text("Este campo es obligatorio").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_nombre_recibe").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_nombre_recibe").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}


/*==============================================================================================================*/
function validar_tel_recibe()
{
	var tel_recibe = document.getElementById("id_tel_recibe").value;

	if( tel_recibe == null || tel_recibe.length == 0 || /^\s+$/.test(tel_recibe) ) //valida que no sea nulo
	{
		$("#id_tel_recibe").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_tel_recibe").parent().children("span").text("Este campo es obligatorio").show();//muestra el texto de ayuda
  		return false;
	}
	else if( !(/^\d{10}$/.test(tel_recibe)) ) 
	{
		$("#id_tel_recibe").parent().attr("class","form-group has-error");//cambia de color la caja de texto
		$("#id_tel_recibe").parent().children("span").text("Ingresa 10 digitos numericos").show();//muestra el texto de ayud
		return false;
	}
	else
	{
		$("#id_tel_recibe").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_tel_recibe").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}
