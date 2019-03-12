<?php

require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'configuraciones_email.php';
require_once 'rutas_absolutas.php';



//tomamos los productos de su compra
mysql_select_db($database_conexion, $conexion);
$query_ProductosPedido2 = "SELECT
pedido.id,
pedido.id_usuario,
pedido.id_direccion,
pedido.forma_pago,
pedido.subtotal_productos,
pedido.precio_envio,
pedido.total,
pedido.cupon_aplicado,
pedido.estatus,
pedido.descripcion_estatus,
pedido.fecha,
pedido.hora,
pedido_productos.id,
pedido_productos.id_pedido,
pedido_productos.id_producto,
pedido_productos.tipo,
pedido_productos.artista,
pedido_productos.album,
pedido_productos.cantidad,
pedido_productos.precio,
pedido_productos.precio_final,
pedido_productos.fecha_hora
FROM
pedido
INNER JOIN pedido_productos ON pedido.id = pedido_productos.id_pedido
where pedido_productos.id_pedido=".$_SESSION['PEDIDO_NUEVO'];
$ProductosPedido2 = mysql_query($query_ProductosPedido2, $conexion) or die(mysql_error());
$row_ProductosPedido2 = mysql_fetch_assoc($ProductosPedido2);
$totalRows_ProductosPedido2 = mysql_num_rows($ProductosPedido2);

 
//tomamos los datos del pedido
mysql_select_db($database_conexion, $conexion);
$query_DatosPedido = "SELECT * FROM pedido where id=".$_SESSION['PEDIDO_NUEVO'];
$DatosPedido = mysql_query($query_DatosPedido, $conexion) or die(mysql_error());
$row_DatosPedido = mysql_fetch_assoc($DatosPedido);
$totalRows_DatosPedido = mysql_num_rows($DatosPedido);


//tomamos los datos del usuario
mysql_select_db($database_conexion, $conexion);
$query_DatosUsuario = "SELECT * FROM usuarios_ecommerce where id=".$row_DatosPedido['id_usuario'];
$DatosUsuario = mysql_query($query_DatosUsuario, $conexion) or die(mysql_error());
$row_DatosUsuario = mysql_fetch_assoc($DatosUsuario);
$totalRows_DatosUsuario = mysql_num_rows($DatosUsuario);

//tomamos los datos del direccion de envio
mysql_select_db($database_conexion, $conexion);
$query_DatosEnvio = "SELECT * FROM direcciones where id=".$row_DatosPedido['id_direccion'];
$DatosEnvio = mysql_query($query_DatosEnvio, $conexion) or die(mysql_error());
$row_DatosEnvio = mysql_fetch_assoc($DatosEnvio);
$totalRows_DatosEnvio = mysql_num_rows($DatosEnvio);

//¿utilizo un cupon de descuento
if($row_DatosPedido['cupon_aplicado']!='')//si uso cupon de descuento
{
	mysql_select_db($database_conexion, $conexion);
	$query_DatosCupon = "SELECT * FROM cupon where codigo='".$row_DatosPedido['cupon_aplicado']."'";
	$DatosCupon = mysql_query($query_DatosCupon, $conexion) or die(mysql_error());
	$row_DatosCupon = mysql_fetch_assoc($DatosCupon);
	$totalRows_DatosCupon = mysql_num_rows($DatosCupon);
	
	if($row_DatosCupon['medida']=='PESOS')
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

//$mail->SMTPSecure = 'ssl';

$mail->SMTPAuth = true;

$mail->Username = $de;

$mail->Password = $psw_de;

$mail->setFrom($de, $de_mascara);


$mail->addAddress($respaldo_mail_usuario, '');

$mail->Subject = "Pedido #".$_SESSION['PEDIDO_NUEVO']." - ".$asunto2;




$foo = '
<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 5px; padding-bottom: 5px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
<h4>&#161;GRACIAS POR TU COMPRA!</h4>
</div>
  
    
<div class="col-sm-12" style="text-align:justify; padding-top: 5px; padding-bottom: 5px;">
<br><br>
<p style="font-size:10px;">Tu pedido se encuentra en espera hasta que hayamos confirmado que se ha recibido tu pago. Los datos de tu pedido se encuentran abajo para mayor referencia:</p>
<p style="font-size:10px;">Realiza tu pago directamente en nuestra cuenta bancaria. Por favor env&iacute;a la copia de tu ficha de dep&oacute;sito al siguiente correo: ventas@fonartelatino.com.mx. </p>
</div>

<div class="col-sm-12 table tipografia2">    
<br><br>      
<table  BORDER CELLPADDING=10 CELLSPACING=0 style="font-size:10px;">

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
<td colspan="2" style="text-align:center;"><br />NOTA: Es importante que al realizar tu pago incluyas como referencia tu n&uacute;mero de pedido y que una vez realizado el pago nos envies un correo de confirmaci&oacute;n para agilizar tu env&iacute;o a ventas@fonartelatino.com.mx</td>
</tr>

</table>
</div>
  <br /><br />
  <h3>Pedido #'.$_SESSION['PEDIDO_NUEVO'].'</h3>

	<table BORDER CELLPADDING=10 CELLSPACING=0 width="100%"  style="font-size:10px;">
	<tr>
		<th style="background-color:#eee">Producto</th>
		<th style="background-color:#eee">Cantidad</th>
		<th style="background-color:#eee">Precio</th>
	</tr/>	
  ';
  
 do
 {
	 $foo .='<tr>';
	 $foo .= '<td>'.$row_ProductosPedido2['artista'].', '.$row_ProductosPedido2['album'].'</td>';
	 $foo .= '<td ><center>'.$row_ProductosPedido2['cantidad'].'</center></td>';
	 $foo .= '<td style="text-align:right">$'.$row_ProductosPedido2['precio'].'.00</td>';
	 $foo .='</tr>';
 }while($row_ProductosPedido2 = mysql_fetch_assoc($ProductosPedido2));
  
 $foo .='<tr>
			<td colspan="2" style="text-align:right">Subtotal</td>
			<td style="text-align:right">$'.$row_DatosPedido['subtotal_productos'].'.00</td>
		<tr>';



//SI EXISTE DESCUENTO
if(isset($row_DatosCupon['descuento']))
{
	$foo .='<tr>
				<td colspan="2" style="text-align:right" >Descuento</td>
				<td style="text-align:right">'.$descuento.'</td>
			<tr>';

}


$foo .='<tr>
			<td colspan="2" style="text-align:right" >Precio de Envio</td>
			<td style="text-align:right">$'.$row_DatosPedido['precio_envio'].'.00</td>
		<tr>';



//PRECIO TOTAL
$foo .='<tr>
			<td colspan="2" style="text-align:right" ><h3><strong>Total</strong></h3></td>
			<td style="text-align:right"><h3><strong>$'.$row_DatosPedido['total'].'.00</strong></h3></td>
		<tr>';		
		
		
 $foo .='</table>';
 
	


	
	
	
	//DATOS DE USUARIO
	$foo .='<br /><h3>Datos del cleinte</h3> <label style="font-size:10px;">'.$row_DatosUsuario['nombre'].' '.$row_DatosUsuario['apepat'].' '.$row_DatosUsuario['apemat'].' <br />'.$row_DatosUsuario['email'].'</label>';
	
	
	//DATOS DE ENVIO
	$foo .='<br /><h3>Datos de envio</h3> <label style="font-size:10px;">'.$row_DatosEnvio['nombre_recibe']."<br />".$row_DatosEnvio['tel_recibe']."<br />".$row_DatosEnvio['calle'].' N/E '.$row_DatosEnvio['n_ext'].' N/I '.$row_DatosEnvio['n_int'].' '.$row_DatosEnvio['colonia'].' '.$row_DatosEnvio['muni_dele'].', '.$row_DatosEnvio['estado'].', '.$row_DatosEnvio['pais'].', C.P. '.$row_DatosEnvio['cp'].'<br />ENTRE LA CALLE'.$row_DatosEnvio['entre_calle_1'].' Y'.$row_DatosEnvio['entre_calle_2'].'</label>';




$mail->MsgHTML($foo);
//send the message, check for errors
if (!$mail->send()) {
	echo "error al enviar ";
    return false;
} else {
     return true;
}
   




?>



