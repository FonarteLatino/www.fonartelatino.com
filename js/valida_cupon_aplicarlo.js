// JavaScript Document
$(document).on("ready", inicio);

$("span.help-block").hide();//ocultamos las etiquetas de ayuda

function inicio()
{
	
	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_cupon").keyup(valida_cupon);


	//cuando preciona un atecla en cada caja de texto, ejecuta su fucion de validacion
	$("#id_btn_cupon").click(valida_cupon);


}


/*==============================================================================================================*/
function valida_cupon()
{
	var cupon = document.getElementById("id_cupon").value;

	if( cupon == null || cupon.length == 0 || /^\s+$/.test(cupon) ) //valida que no sea nulo
	{
		$("#id_cupon").parent().attr("class","form-group has-success");//cambia de color la caja de texto
		$("#id_cupon").parent().children("span").text("Si no tienes un cupon, selecciona tu forma de pago").show();//muestra el texto de ayuda
  		return false;
	}
	else
	{
		$("#id_cupon").parent().attr("class","form-group has-info");//cambia de color la caja de texto
		$("#id_cupon").parent().children("span").text("Campo requerido").hide();//muestra el texto de ayuda
  		return true;
	}
}

