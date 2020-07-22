<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'configuraciones_email.php';
require_once 'rutas_absolutas.php';



//tomamos los productos de su compra
mysqli_select_db($conexion,$database_conexion);
$query_ProductosPedido2 = "SELECT
pedido_productos.id,
pedido_productos.id_pedido,
pedido_productos.id_producto,
pedido_productos.cantidad,
pedido_productos.fecha_hora,
pedido_productos.precio_final,
productos.sku,
productos.id_fonarte,
productos.clave_precio,
productos.artista,
productos.album,
productos.genero,
productos.genero2,
productos.genero3,
productos.categoria,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.ruta_img,
productos.ruta_img_2,
productos.descripcion,
productos.fecha_alta,
productos.hora_alta,
productos.prendido,
productos.estatus,
precios.precio
FROM
pedido_productos
INNER JOIN productos ON pedido_productos.id_producto = productos.id
INNER JOIN precios ON productos.clave_precio = precios.clave
where id_pedido=".$_SESSION['PEDIDO_NUEVO'];
$ProductosPedido2 = mysqli_query($conexion,$query_ProductosPedido2) or die(mysqli_error($conexion));
$row_ProductosPedido2 = mysqli_fetch_assoc($ProductosPedido2);
$totalRows_ProductosPedido2 = mysqli_num_rows($ProductosPedido2);

 
//tomamos los datos del pedido
mysqli_select_db($conexion,$database_conexion);
$query_DatosPedido = "SELECT * FROM pedido where id=".$_SESSION['PEDIDO_NUEVO'];
$DatosPedido = mysqli_query($conexion,$query_DatosPedido) or die(mysqli_error($conexion));
$row_DatosPedido = mysqli_fetch_assoc($DatosPedido);
$totalRows_DatosPedido = mysqli_num_rows($DatosPedido);


//tomamos los datos del usuario
mysqli_select_db($conexion,$database_conexion);
$query_DatosUsuario = "SELECT * FROM usuarios_ecommerce where id=".$row_DatosPedido['id_usuario'];
$DatosUsuario = mysqli_query($conexion,$query_DatosUsuario) or die(mysqli_error($conexion));
$row_DatosUsuario = mysqli_fetch_assoc($DatosUsuario);
$totalRows_DatosUsuario = mysqli_num_rows($DatosUsuario);

//tomamos los datos del direccion de envio
mysqli_select_db($conexion,$database_conexion);
$query_DatosEnvio = "SELECT * FROM direcciones where id=".$row_DatosPedido['id_direccion'];
$DatosEnvio = mysqli_query($conexion,$query_DatosEnvio) or die(mysqli_error($conexion));
$row_DatosEnvio = mysqli_fetch_assoc($DatosEnvio);
$totalRows_DatosEnvio = mysqli_num_rows($DatosEnvio);

//¿utilizo un cupon de descuento
if($row_DatosPedido['cupon_aplicado']!='')//si uso cupon de descuento
{
	mysqli_select_db($conexion,$database_conexion);
	$query_DatosCupon = "SELECT * FROM cupon where codigo='".$row_DatosPedido['cupon_aplicado']."'";
	$DatosCupon = mysqli_query($conexion,$query_DatosCupon) or die(mysqli_error($conexion));
	$row_DatosCupon = mysqli_fetch_assoc($DatosCupon);
	$totalRows_DatosCupon = mysqli_num_rows($DatosCupon);
	
}
if(isset($row_DatosCupon['descuento']))
{
	if($row_DatosCupon['descuento']=='PESOS')
	{
		$descuento='- $'.$row_DatosCupon['descuento'];
	}
	else
	{
		$descuento='- %'.$row_DatosCupon['descuento'];
	}
	
}



 
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;

$mail->Debugoutput = 'html';

$mail->Host = $protocolo;

$mail->Port = $puerto;

$mail->SMTPSecure = 'ssl';

$mail->SMTPAuth = true;

$mail->Username = $de;

$mail->Password = $psw_de;

$mail->setFrom($de, $de_mascara);


$mail->addAddress($_SESSION['USUARIO_ECOMMERCE']['email'], '');

$mail->Subject = $asunto2;




$foo = '
<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 5px; padding-bottom: 5px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
<h4>&#161;GRACIAS POR TU COMPRA!</h4>
</div>
  
    
<div class="col-sm-12" style="text-align:justify; padding-top: 5px; padding-bottom: 5px;">
<br><br>
<p>Tu pedido se encuentra en espera hasta que hayamos confirmado que se ha recibido tu pago. Los datos de tu pedido se encuentran abajo para mayor referencia:</p>
<p>Realiza tu pago directamente en nuestra cuenta bancaria. Por favor env&iacute;a la copia de tu ficha de dep&oacute;sito al siguiente correo: ventas@fonartelatino.com o fer.ramirez@fonartelatino.com.mx </p>
</div>

<div class="col-sm-12 table tipografia2">    
<br><br>      
<table class="table">

<tr>
<td colspan="2" style="text-align:center;">Los datos para realizar tu dep&oacute;sito o transferencia bancaria se detallan a continuaci&oacute;n:</td>
</tr>

<tr>
<td>Transferencia Electronica</td>
<td>Dep&oacute;sito Bancario</td>
</tr>

<tr>
<td>Banco: BBVA Bancomer</td>
<td>Banco: BBVA Bancomer</td>
</tr>

<tr>
<td>Nombre: Fonarte Latino, SA de CV</td>
<td>Nombre: Fonarte Latino, SA de CV</td>
</tr>

<tr>
<td>Clabe: 012180004435353715</td>
<td>Clabe: 0443535371</td>
</tr>

<tr>
<td>RFC: FLA830620360</td>
<td>RFC: FLA830620360</td>
</tr>

<tr>
<td colspan="2" style="text-align:center;"><br />NOTA: Es importante que al realizar tu pago incluyas como referencia tu n&uacute;mero de pedido y que una vez realizado el pago nos env&iacute;es un correo de confirmaci&oacute;n para agilizar tu env&iacute;o a ventas@fonartelatino.com o fer.ramirez@fonartelatino.com.mx</td>
</tr>

</table>
</div>
  
  <h3>Pedido #'.$_SESSION['PEDIDO_NUEVO'].'</h3>

		
  ';
  
 do
 {
	 $foo .= '<br />**************************************';
	 $foo .= '<br /><strong>Producto: </strong>'.$row_ProductosPedido2['artista'].', '.$row_ProductosPedido2['album'];
	 $foo .= '<br /><strong>Cantidad: </strong>'.$row_ProductosPedido2['cantidad'];
	 $foo .= '<br /><strong>Precio: </strong>$'.$row_ProductosPedido2['precio'].'.00';
 }while($row_ProductosPedido2 = mysqli_fetch_assoc($ProductosPedido2));
  
 
	//SUBTOTAL
	$foo .='<br /><br /><strong>Subtotal:</strong> $'.$row_DatosPedido['subtotal_productos'].'.00';
	
	//PRECIO DE ENVIO
	$foo .='<br /><strong>Precio de envio:</strong> $'.$row_DatosPedido['precio_envio'].'.00';
 
	//SI EXISTE DESCUENTO
	if(isset($row_DatosCupon['descuento']))
	{
		$foo .='<br /><strong>Descuento:</strong>- $'.$row_DatosCupon['descuento'];
	}
	
	//PRECIO TOTAL
	$foo .='<br /><strong>Total:</strong> $'.$row_DatosPedido['total'].'.00';
	
	//DATOS DE USUARIO
	$foo .='<br /><h3>Datos del cleinte</h3> '.$row_DatosUsuario['nombre'].' '.$row_DatosUsuario['apepat'].' '.$row_DatosUsuario['apemat'].' <br />'.$row_DatosUsuario['email'];
	
	
	//DATOS DE ENVIO
	$foo .='<br /><h3>Datos de envio</h3> '.$row_DatosEnvio['nombre_recibe']."<br />".$row_DatosEnvio['tel_recibe']."<br />".$row_DatosEnvio['calle'].' N/E '.$row_DatosEnvio['n_ext'].' N/I '.$row_DatosEnvio['n_int'].' '.$row_DatosEnvio['colonia'].' '.$row_DatosEnvio['muni_dele'].', '.$row_DatosEnvio['estado'].', '.$row_DatosEnvio['pais'].', C.P. '.$row_DatosEnvio['cp'].'<br />ENTRE LA CALLE'.$row_DatosEnvio['entre_calle_1'].' Y'.$row_DatosEnvio['entre_calle_2'];




$mail->MsgHTML($foo);
//send the message, check for errors
if (!$mail->send()) {
	echo "error al enviar ";
    return false;
} else {
     return true;
}
   




?>



