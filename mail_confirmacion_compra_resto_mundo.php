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


$mail->addAddress($_SESSION['USUARIO_ECOMMERCE']['email'], '');

$mail->Subject = $asunto2;




$foo = '
<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 5px; padding-bottom: 5px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
<h4>&#161;GRACIAS POR TU COMPRA!</h4>
</div>
  
    
<div class="col-sm-12" style="text-align:justify; padding-top: 5px; padding-bottom: 5px;">
<br><br>
<p style="font-size:10px;">Tu pedido se encuentra en espera hasta que hayamos confirmado que se ha recibido tu pago. Los datos de tu pedido se encuentran abajo para mayor referencia:</p>

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
 }while($row_ProductosPedido2 = mysqli_fetch_assoc($ProductosPedido2));
  
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

//costo de envio
$foo .='<tr>
			<td colspan="2" style="text-align:right;color:#F00;" >Envio: (Se acuerda con el vendedor)</td>
			<td style="text-align:right;color:#F00;">Pendiente</td>
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



