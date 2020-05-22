<?php 
if (!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['USUARIO_ECOMMERCE']))//SI NO EXISTE UNA SESION REDIRECCIONA
{
	?><script type="text/javascript">window.location="index";</script><?php
}

if(!isset($_SESSION['PEDIDO_NUEVO']))//SI NO EXISTE UNA SESION REDIRECCIONA
{
	?><script type="text/javascript">window.location="index";</script><?php
}


require_once('Connections/conexion.php'); 

require_once('rutas_absolutas.php'); 


?>
<?php
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




//juego de registros para hacer update a esta tabla
mysql_select_db($database_conexion, $conexion);
$query_PedidoFinal = "SELECT * FROM pedido WHERE id=".$_SESSION['PEDIDO_NUEVO'];
$PedidoFinal = mysql_query($query_PedidoFinal, $conexion) or die(mysql_error());
$row_PedidoFinal = mysql_fetch_assoc($PedidoFinal);
$totalRows_PedidoFinal = mysql_num_rows($PedidoFinal);

if($row_PedidoFinal['cupon_aplicado']!='')//si el pedido tiene un cupon aplicado
{
	
	//detalle del cupon de descuento 
	mysql_select_db($database_conexion, $conexion);
	$query_DetalleCupon = "SELECT * FROM cupon WHERE codigo='".$row_PedidoFinal['cupon_aplicado']."'";
	$DetalleCupon = mysql_query($query_DetalleCupon, $conexion) or die(mysql_error());
	$row_DetalleCupon = mysql_fetch_assoc($DetalleCupon);
	$totalRows_DetalleCupon = mysql_num_rows($DetalleCupon);
	
	if($row_DetalleCupon['medida']=='PESOS')
	{ 
		$signo='$'; 
	}
	else
	{ 
		$signo='%'; 
	}

}

// 2.-modificamos el NA por VENTANILLA y el estatus de 1 a 2 y le asignamos el numero de pedido
$updateSQL = sprintf("UPDATE pedido SET forma_pago=%s, estatus=%s, descripcion_estatus=%s WHERE id=%s",
GetSQLValueString('VENTANILLA', "text"),
GetSQLValueString(2, "int"),
GetSQLValueString('TERMINO DE COMPRAR - SELECCIONO FORMA DE PAGO', "text"),
GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


//3.- Borramos los productos que tenia este usuario en la tabla de CARRITO 
$deleteSQL = sprintf("DELETE FROM carrito WHERE id_usr=%s",
GetSQLValueString($_SESSION['USUARIO_ECOMMERCE']['id'], "int"));
mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

//tomamos los productos de su compra
mysql_select_db($database_conexion, $conexion);
$query_ProductosPedido = "SELECT
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
$UpdateProductosPedido = mysql_query($query_ProductosPedido, $conexion) or die(mysql_error());
$row_ProductosPedido = mysql_fetch_assoc($UpdateProductosPedido);
$totalRows_ProductosPedido = mysql_num_rows($UpdateProductosPedido);

//direccion de envio
mysql_select_db($database_conexion, $conexion);
$query_DireccionEnvio = "SELECT
pedido.id,
pedido.id_usuario,
pedido.id_direccion,
pedido.forma_pago,
pedido.estatus,
pedido.descripcion_estatus,
pedido.fecha,
pedido.hora,
direcciones.id_usr,
direcciones.calle,
direcciones.colonia,
direcciones.muni_dele,
direcciones.cp,
direcciones.n_ext,
direcciones.n_int,
direcciones.pais,
direcciones.estado,
direcciones.entre_calle_1,
direcciones.entre_calle_2,
direcciones.nombre_recibe,
direcciones.tel_recibe,
direcciones.estatus
FROM
pedido
LEFT JOIN direcciones ON pedido.id_direccion = direcciones.id
where pedido.id=".$_SESSION['PEDIDO_NUEVO'];
$DireccionEnvio = mysql_query($query_DireccionEnvio, $conexion) or die(mysql_error());
$row_DireccionEnvio = mysql_fetch_assoc($DireccionEnvio);
$totalRows_DireccionEnvio = mysql_num_rows($DireccionEnvio);


//le aparta este cupon a este pedido
$updateSQL = sprintf("UPDATE cupon SET estatus=%s WHERE usado_por_pedido=%s",
GetSQLValueString('USADO', "text"),
GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
 
mysql_select_db($database_conexion, $conexion);
$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

include_once("mail_confirmacion_compra.php");//confirma su pedido al comprador
include_once("mail_confirmacion_compra_respaldo.php");//envia una copia del detalle de la compra a usuariostienda@fonartelatino.com


//le avisa al admin de FONARTE que hay un nuevo pedido
$tipo='DEPOSITO BANCARIO';
include_once("mail_nuevo_pedido_admin.php");

	
?>

 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
   <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Confirmacion</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i, 900" rel="stylesheet">
</head>

<body>

    <?php include("menu.php"); ?>

    <!-- Page Content -->
    
		
        
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Confirmaci&oacute;n<small>&nbsp;</small></p>
                </div>
            </div>
        </div>
        </div>
        <!-- Fin de titulo de la pagina -->
<br><br>
<div class="container size_gracias_compra" >
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->

              
                 <?php include("pinta_alerta.php"); ?>
               

<div class="row tipografia2">

  <div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 5px; padding-bottom: 5px;">
  <img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
  <h4>&#161;GRACIAS POR TU COMPRA!</h4>
  </div>
  
    
  <div class="col-sm-12" style="text-align:justify; padding-top: 5px; padding-bottom: 5px;">
  <br><br>
  <p>Tu pedido se encuentra en espera hasta que hayamos confirmado que se ha recibido tu pago. Los datos de tu pedido se encuentran abajo para mayor referencia:</p>
  <p>Realiza tu pago directamente en nuestra cuenta bancaria. Por favor env&iacute;a la copia de tu ficha de dep&oacute;sito al siguiente corre: ventas@fonartelatino.com o fer.ramirez@fonartelatino.com.mx </p>
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
    	<td colspan="2" style="text-align:center;">NOTA: Es importante que al realizar tu pago incluyas como referencia tu n&uacute;mero de orden y que una vez realizado el pago nos env&aacute;es un correo de confirmaci&oacute;n para agilizar tu env&iacute;o a ventas@fonartelatino.com o fer.ramirez@fonartelatino.com.mx</td>
    </tr>

</table>
  </div>
  
  <div class="col-sm-12 tipografia2" >
  <h3>Pedido #<?php print_r($_SESSION['PEDIDO_NUEVO']); ?></h3>
  
  
  <table class="table table-bordered" style="width:100%">

    <tr style="background-color:#eee;">
      <td style="width:50%;"><strong>Producto</strong></td>
      <td style="width:20%;text-align:right;"><strong>Cantidad</strong></td>
      <td style="width:30%;text-align:right;"><strong>Precio</strong></td>
    </tr>
    <?php
	$subtotal=0;
	do{
	?>
	<tr>
		<td><?php echo utf8_encode($row_ProductosPedido['artista']).", ".utf8_encode($row_ProductosPedido['album']); ?></td>
		<td align="right"><?php echo $row_ProductosPedido['cantidad']; ?></td>
		<td align="right"><?php echo "$".$row_ProductosPedido['precio_final'].".00"; ?></td>
        <?php $subtotal=$subtotal+($row_ProductosPedido['precio_final']* $row_ProductosPedido['cantidad']); ?>
	</tr>
	<?php
	}while($row_ProductosPedido = mysql_fetch_assoc($UpdateProductosPedido));
	
	?>
    
    <tr>
      <td colspan="2"><strong>Subtotal:</strong></td>
      <td align="right"><?php echo "$".$row_PedidoFinal['subtotal_productos'].".00"; ?></td>
    </tr>
    <tr>
      <td colspan="2"><strong>Envio:</strong></td>
      <td align="right"><?php echo "$".$row_PedidoFinal['precio_envio'].".00"; ?></td>
    </tr>
    <?php
	
	if(isset($row_DetalleCupon['descuento']))
	{
$signo
	?>
    
    <tr>
      <td colspan="2"><strong>Descuento:</strong></td>
      <td style="text-align:right;"><?php echo "-".$signo." ".$row_DetalleCupon['descuento'] ?></td>
    </tr>
    <?php	
	}
	
	?>
    <tr>
      <td colspan="2"><strong>Forma de pago:</strong></td>
      <td style="text-align:right;">Transferencia Bancaria</td>
    </tr>
    <tr>
      <td colspan="2"><strong>Total</strong></td>
      <td align="right"><?php echo "$".$row_PedidoFinal['total'].".00"; ?></td>
    </tr>
  </table>
  </div>
  
  
  <div class="col-sm-6 tipografia2" >
  <h3>Datos del cliente</h3>
	<ul>
    	<li><?php print_r($_SESSION['USUARIO_ECOMMERCE']['nombre']." ".$_SESSION['USUARIO_ECOMMERCE']['apepat']." ".$_SESSION['USUARIO_ECOMMERCE']['apemat']); ?></li>
        <li><?php print_r($_SESSION['USUARIO_ECOMMERCE']['email']); ?></li>
    </ul>
  </div>
  
  
  <div class="col-sm-6 tipografia2" >
  <h3>Enviar a</h3>
  <p class="tipografia2" style="font-size:12px;">
  
  	<?php echo utf8_encode($row_DireccionEnvio['nombre_recibe']); ?>	<br>
    <?php echo $row_DireccionEnvio['tel_recibe']; ?> <br>
    <?php echo utf8_encode($row_DireccionEnvio['calle']); ?>	
    <?php echo utf8_encode($row_DireccionEnvio['n_ext']); ?>	
    <?php echo utf8_encode($row_DireccionEnvio['n_int']); ?>	<br>
    <?php echo utf8_encode($row_DireccionEnvio['colonia']); ?>	<br>
    <?php echo utf8_encode($row_DireccionEnvio['muni_dele']).", ".utf8_encode($row_DireccionEnvio['estado']); ?>	<br>
    <?php echo utf8_encode($row_DireccionEnvio['pais'])." C.P.".$row_DireccionEnvio['cp']; ?>	<br>
    <?php echo "Entre la calle ".utf8_encode($row_DireccionEnvio['entre_calle_1']); ?><br>
	<?php echo " y la calle ".utf8_encode($row_DireccionEnvio['entre_calle_2']); ?>	

  </p>

  </div>
  
  <div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 5px; padding-bottom: 5px;">
  <h4>FONARTE LATINO</h4>
  </div>
  
  
  
</div>





</div>

               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    
     
    <?php include("pie.php"); ?>



    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/valida_registro.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
<?php



// ***inicio de  matamos las sesiones temporales

$_SESSION['CARRITO_TEMP'] = NULL;
$_SESSION['PEDIDO_NUEVO'] = NULL;

unset($_SESSION['CARRITO_TEMP']);
unset($_SESSION['PEDIDO_NUEVO']);

// ***fin de  matamos las sesiones temporales






/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>
</body>

</html>
