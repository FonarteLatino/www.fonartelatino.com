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

  #$theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
GetSQLValueString(2, "int"),
GetSQLValueString('TERMINO DE COMPRAR - SELECCIONO FORMA DE PAGO', "text"),
GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
mysqli_select_db($conexion,$database_conexion);
$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));


//3.- Borramos los productos que tenia este usuario en la tabla de CARRITO 
$deleteSQL = sprintf("DELETE FROM carrito WHERE id_usr=%s",
GetSQLValueString($_SESSION['USUARIO_ECOMMERCE']['id'], "int"));
mysqli_select_db($conexion,$database_conexion);
$Result1 = mysqli_query($conexion,$deleteSQL) or die(mysqli_error($conexion));


 //le aparta este cupon a este pedido
$updateSQL = sprintf("UPDATE cupon SET estatus=%s WHERE usado_por_pedido=%s",
GetSQLValueString('USADO', "text"),
GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
 
mysqli_select_db($conexion,$database_conexion);
$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));




mysqli_select_db($conexion,$database_conexion);
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
pedido_productos.id_pedido,
pedido_productos.id_producto,
pedido_productos.id_producto_fonarte,
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
WHERE  pedido.id=".$_SESSION['PEDIDO_NUEVO'];
$Pedido = mysqli_query($conexion,$query_Pedido) or die(mysqli_error($conexion));
$row_Pedido = mysqli_fetch_assoc($Pedido);
$totalRows_Pedido = mysqli_num_rows($Pedido);
 
 

 
 
 //datos del usuario
mysqli_select_db($conexion,$database_conexion);
 $query_UsuarioEcommerce = "SELECT * FROM usuarios_ecommerce WHERE id=".$row_Pedido['id_usuario'];
$UsuarioEcommerce = mysqli_query($conexion,$query_UsuarioEcommerce) or die(mysqli_error($conexion));
$row_UsuarioEcommerce = mysqli_fetch_assoc($UsuarioEcommerce);
$totalRows_UsuarioEcommerce = mysqli_num_rows($UsuarioEcommerce);


//toma datos el descuento si es que lo tiene
if($row_Pedido['cupon_aplicado']!='')
{
	//datos del descuento(si existiera)
	mysqli_select_db($conexion,$database_conexion);
	$query_cupon = "SELECT * FROM cupon WHERE codigo='".$row_Pedido['cupon_aplicado']."'";
	$cupon = mysqli_query($conexion,$query_cupon) or die(mysqli_error($conexion));
	$row_cupon = mysqli_fetch_assoc($cupon);
	$totalRows_cupon = mysqli_num_rows($cupon);
	
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
else
{
	$desc21=$row_Pedido['subtotal_productos'];	
}






  //le avisa al admin de FONARTE que hay un nuevo pedido
$tipo='PAYPAL';
include_once("mail_nuevo_pedido_admin.php");

$correo_comprador=$row_UsuarioEcommerce['email'];
//include_once("mail_confirmacion_pago.php");
include_once("mail_confirmacion_pago_2.php");



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
<!--form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="formulario1"-->
<form action="https://www.paypal.com/cgi-bin/webscr" method="get" name="formulario1">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="diegoavila@fonartelatino.com.mx">
<!--input type="hidden" name="item_name" value="Item Name"-->
<input type="hidden" name="currency_code" value="MXN">
<!--input type="hidden" name="amount" value="0.00"-->
<!--input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"-->
<input type="hidden" name="shipping_1" value="<?php echo $row_Pedido['precio_envio']; ?>">


<?php
$x=1;
$wer='';
do{
	
	$wer .=$row_Pedido['artista'].", ".$row_Pedido['album']." --- ";
	$x=$x+1;
	
}while($row_Pedido = mysqli_fetch_assoc($Pedido));
?>

<input type="hidden" name="item_name_1" value="<?php echo $wer; ?>">
<input type="hidden" name="quantity_1" value="1">
<input type="hidden" name="amount_1" value="<?php echo $desc21; ?>">


<!--input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" id="btn_submit_paypal" alt=""-->

</form>
<!-- ====================== fin de pago a paypal ============================== -->

 <!-- jQuery -->
   

<?php

// ***inicio de  matamos las sesiones temporales
/*
$_SESSION['CARRITO_TEMP'] = NULL;
$_SESSION['PEDIDO_NUEVO'] = NULL;

unset($_SESSION['CARRITO_TEMP']);
unset($_SESSION['PEDIDO_NUEVO']);
*/
// ***fin de  matamos las sesiones temporales


mysqli_free_result($Pedido);
?>