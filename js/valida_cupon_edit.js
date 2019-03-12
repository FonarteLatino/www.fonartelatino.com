// JavaScript Document
$(document).on("ready", inicio);

$("span.help-block").hide();//ocultamos las etiquetas de ayuda

function inicio()
{
	
	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_codigo").keyup(valida_codigo);
	$("#id_medida").change(valida_medida);
	$("#id_descuento").keyup(valida_descuento);
	$("#id_vencimiento").change(valida_vencimiento);
	$("#id_mas_de").keyup(valida_mas_de);
	$("#id_disponibles").keyup(valida_disponibles);

	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_btn_crear").click(valida_codigo);
	$("#id_btn_crear").click(valida_medida);
	$("#id_btn_crear").click(valida_descuento);
	$("#id_btn_crear").click(valida_vencimiento);
	$("#id_btn_crear").click(valida_mas_de);
	$("#id_btn_crear").click(valida_disponibles);
	

}

/*==============================================================================================================*/
function valida_codigo()
{
	var codigo = document.getElementById("id_codigo").value;

	if( codigo == null || codigo.length == 0 || /^\s+$/.test(codigo) ) //valida que no sea nulo
	{
		$("#id_codigo").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_codigo").parent().children("span").text("Codigo es un campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_codigo").parent().attr("class","col-sm-4 has-success");//cambia de color la caja de texto
		$("#id_codigo").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function valida_medida()
{
	var medida = document.getElementById("id_medida").value;

	if( medida == null || medida == 0 ) 
	{
		$("#id_medida").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_medida").parent().children("span").text("Medida es un campo requerido").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_medida").parent().attr("class","col-sm-4 has-success");//cambia de color la caja de texto
		$("#id_medida").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function valida_descuento()
{
	var descuento = document.getElementById("id_descuento").value;

	if( descuento == null || descuento.length == 0 || /^\s+$/.test(descuento) ) //valida que no sea nulo
	{
		$("#id_descuento").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_descuento").parent().children("span").text("Descuento es obligatorio").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_descuento").parent().attr("class","col-sm-4 has-success");//cambia de color la caja de texto
		$("#id_descuento").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function valida_vencimiento()
{
	var vencimiento = document.getElementById("id_vencimiento").value;

	if( vencimiento == null || vencimiento.length == 0 || /^\s+$/.test(vencimiento) ) //valida que no sea nulo
	{
		$("#id_vencimiento").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_vencimiento").parent().children("span").text("Fecha de vencimiento es obligatorio").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_vencimiento").parent().attr("class","col-sm-4 has-success");//cambia de color la caja de texto
		$("#id_vencimiento").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

/*==============================================================================================================*/
function valida_mas_de()
{
	var mas_de = document.getElementById("id_mas_de").value;

	if( mas_de == null || mas_de.length == 0 || /^\s+$/.test(mas_de) ) //valida que no sea nulo
	{
		$("#id_mas_de").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_mas_de").parent().children("span").text("Campo obligatorio").show();//muestra el texto de ayuda
  		return false;
	}
	else if( isNaN(mas_de) ) 
	{
		$("#id_mas_de").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_mas_de").parent().children("span").text("Solo permite numeros").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_mas_de").parent().attr("class","col-sm-4 has-success");//cambia de color la caja de texto
		$("#id_mas_de").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}


/*==============================================================================================================*/
function valida_disponibles()
{
	var disponibles = document.getElementById("id_disponibles").value;

	if( disponibles == null || disponibles.length == 0 || /^\s+$/.test(disponibles) ) //valida que no sea nulo
	{
		$("#id_disponibles").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_disponibles").parent().children("span").text("Campo obligatorio").show();//muestra el texto de ayuda
  		return false;
	}
	else if( isNaN(disponibles) ) 
	{
		$("#id_disponibles").parent().attr("class","col-sm-4 has-error");//cambia de color la caja de texto
		$("#id_disponibles").parent().children("span").text("Solo permite numeros").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_disponibles").parent().attr("class","col-sm-4 has-success");//cambia de color la caja de texto
		$("#id_disponibles").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}
