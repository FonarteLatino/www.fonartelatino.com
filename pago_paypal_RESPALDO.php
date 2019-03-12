<?php
if (!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['USUARIO_ECOMMERCE']))//SI NO EXISTE UNA SESION REDIRECCIONA
{
	?>
<script type="text/javascript">window.location="index";</script><?php
}

if(!isset($_SESSION['PEDIDO_NUEVO']))//SI NO EXISTE UNA SESION REDIRECCIONA
{
	?><script type="text/javascript">window.location="index";</script><?php
}


require_once('Connections/conexion.php'); 

require_once('rutas_absolutas.php'); 



if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// 2.-modificamos el NA por VENTANILLA y el estatus de 1 a 2 y le asignamos el numero de pedido
$updateSQL = sprintf("UPDATE pedido SET forma_pago=%s, estatus=%s, descripcion_estatus=%s WHERE id=%s",
GetSQLValueString('PAYPAL', "text"),
GetSQLValueString(3, "int"),
GetSQLValueString('PAGO', "text"),
GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


//3.- Borramos los productos que tenia este usuario en la tabla de CARRITO 
$deleteSQL = sprintf("DELETE FROM carrito WHERE id_usr=%s",
GetSQLValueString($_SESSION['USUARIO_ECOMMERCE']['id'], "int"));
mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());


 



mysql_select_db($database_conexion, $conexion);
 $query_Pedido = "SELECT
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
pedido_productos.id_producto,
pedido_productos.cantidad,
pedido_productos.precio,
pedido_productos.precio_final,
pedido_productos.fecha_hora,
productos.artista,
productos.album
FROM
pedido
LEFT JOIN pedido_productos ON pedido.id = pedido_productos.id_pedido
LEFT JOIN productos ON productos.id = pedido_productos.id_producto
WHERE  pedido.id=".$_SESSION['PEDIDO_NUEVO'];
$Pedido = mysql_query($query_Pedido, $conexion) or die(mysql_error());
$row_Pedido = mysql_fetch_assoc($Pedido);
$totalRows_Pedido = mysql_num_rows($Pedido);
 
 
 //datos del usuario
mysql_select_db($database_conexion, $conexion);
 $query_UsuarioEcommerce = "SELECT * FROM usuarios_ecommerce WHERE id=".$row_Pedido['id_usuario'];
$UsuarioEcommerce = mysql_query($query_UsuarioEcommerce, $conexion) or die(mysql_error());
$row_UsuarioEcommerce = mysql_fetch_assoc($UsuarioEcommerce);
$totalRows_UsuarioEcommerce = mysql_num_rows($UsuarioEcommerce);


//toma datos el descuento si es que lo tiene
if($row_Pedido['cupon_aplicado']!='')
{
	//datos del descuento(si existiera)
	mysql_select_db($database_conexion, $conexion);
	$query_cupon = "SELECT * FROM cupon WHERE codigo='".$row_Pedido['cupon_aplicado']."'";
	$cupon = mysql_query($query_cupon, $conexion) or die(mysql_error());
	$row_cupon = mysql_fetch_assoc($cupon);
	$totalRows_cupon = mysql_num_rows($cupon);
	
	if($row_cupon['medida']=='PORCENTAJE')
	{
		$d=".".$row_cupon['descuento'];
		$desc21=$row_Pedido['subtotal_productos']-($row_Pedido['subtotal_productos']*$d);
	}
	else
	{
		$desc21=$row_Pedido['subtotal_productos']-$row_cupon['descuento'];
	}
}






  //le avisa al admin de FONARTE que hay un nuevo pedido
$tipo='PAYPAL';
include_once("mail_nuevo_pedido_admin.php");

$correo_comprador=$row_UsuarioEcommerce['email'];
include_once("mail_confirmacion_pago.php");



?>
 <script src="js/jquery.js"></script>
<script>

// JavaScript Document
$(document).on("ready", inicio);


function inicio()
{
	//alert("si entro");
	document.formulario1.submit() 
}

</script>


<!-- ====================== inicio de pago a paypal ============================== -->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formulario1">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<!--input type="hidden" name="business" value="diegoavila@fonartelatino.com.mx"-->
<input type="hidden" name="business" value="diegoavila@fonartelatino.com.mx">
<!--input type="hidden" name="item_name" value="Item Name"-->
<input type="hidden" name="currency_code" value="MXN">
<!--input type="hidden" name="amount" value="0.00"-->
<!--input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"-->
<input type="hidden" name="shipping_1" value="<?php echo $row_Pedido['precio_envio']; ?>">


<?php
$x=1;
do{
	
	?>
<!-- campos para desucneto -->    
<input type="hidden" name="item_name_<?php echo $x; ?>" value="<?php echo $row_Pedido['artista'].", ".$row_Pedido['album']; ?>">
<input type="hidden" name="quantity_<?php echo $x; ?>" value="<?php echo $row_Pedido['cantidad']; ?>">
<input type="hidden" name="amount_<?php echo $x; ?>" value="<?php echo $row_Pedido['precio']; ?>">


	<?php
	$x=$x+1;
}while($row_Pedido = mysql_fetch_assoc($Pedido));


?>




<!--input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" id="btn_submit_paypal" alt=""-->

</form>
<!-- ====================== fin de pago a paypal ============================== -->

 <!-- jQuery -->
   

<?php

// ***inicio de  matamos las sesiones temporales

$_SESSION['CARRITO_TEMP'] = NULL;
$_SESSION['PEDIDO_NUEVO'] = NULL;

unset($_SESSION['CARRITO_TEMP']);
unset($_SESSION['PEDIDO_NUEVO']);

// ***fin de  matamos las sesiones temporales


mysql_free_result($Pedido);
?>