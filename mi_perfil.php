<?php
if (!isset($_SESSION)) {
  session_start();
  
 require_once('Connections/conexion.php'); ?>
<?php
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

mysqli_select_db($conexion,$database_conexion);
$query_UpdateCant = "SELECT * FROM carrito";
$UpdateCant = mysqli_query($conexion,$query_UpdateCant) or die(mysqli_error($conexion));
$row_UpdateCant = mysqli_fetch_assoc($UpdateCant);
$totalRows_UpdateCant = mysqli_num_rows($UpdateCant);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}




//inicio de modifica cantidad
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) 
{
	$updateSQL = sprintf("UPDATE carrito SET cantidad=%s WHERE id=%s",
	GetSQLValueString($_POST['cantidad'], "int"),
	GetSQLValueString($_POST['id'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	header("Location: mi_perfil.php");
}
//fin de modifica cantidad








mysqli_select_db($conexion,$database_conexion);
$query_Carrito = "SELECT * from carrito where id_usr=".$_SESSION['USUARIO_ECOMMERCE']['id'];
$Carrito = mysqli_query($conexion,$query_Carrito) or die(mysqli_error($conexion));
$row_Carrito = mysqli_fetch_assoc($Carrito);
$totalRows_Carrito = mysqli_num_rows($Carrito);


/* =========================== inicio query de pago para paypa ================================= */
mysqli_select_db($conexion,$database_conexion);
$query_Paypal = "SELECT * from carrito where id_usr=".$_SESSION['USUARIO_ECOMMERCE']['id'];
$Paypal = mysqli_query($conexion,$query_Paypal) or die(mysqli_error($conexion));
$row_Paypal = mysqli_fetch_assoc($Paypal);
$totalRows_Paypal = mysqli_num_rows($Paypal);
/* =========================== fin query de pago para paypa ================================= */


}


?>
 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonartelatino | Mi Perfil</title>
  
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

</head>

<body>

<?php include("menu.php"); ?>

    <!-- Page Content -->
    
		
         <?php include("pinta_alerta.php"); ?>
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Perfil<small>&nbsp;</small></p>
                </div>
            </div>
        </div>
        </div>
        <!-- Fin de titulo de la pagina -->

<div class="container tipografia2" >
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
               <br><br>
               
               <h3><?php print_r($_SESSION['USUARIO_ECOMMERCE']['nombre']." ".$_SESSION['USUARIO_ECOMMERCE']['apepat']." ".$_SESSION['USUARIO_ECOMMERCE']['apemat']); ?></h3>
               <span><a href="salir_ecommerce.php">Cerrar Sesion &nbsp;<span class="glyphicon glyphicon-log-out"></span></a></span>
               
   <br><br>            
<table class="table tipografia2">
<thead>
<tr>
<th>&nbsp;#&nbsp;</th>
<th>&nbsp;</th>
<th>Descripcion</th>
<th>Cantidad</th>
<th>Precio</th>
<th>Subtotal</th>
</tr>
</thead>
<tbody>   
       
<?php 
$contador=1;
$total=0;
do{
	//toma datos del producto
	mysqli_select_db($conexion,$database_conexion);
	$query_DatosProducto = "SELECT
	productos.id as id_producto,
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
	precios.precio,
	genero.nombre AS nombre_genero,
	categoria.nombre as nombre_categoria
	FROM
	productos
	INNER JOIN precios ON productos.clave_precio = precios.clave
	INNER JOIN genero ON productos.genero = genero.id
	INNER JOIN categoria ON productos.categoria = categoria.id where productos.id=".$row_Carrito['id_producto'];
	$DatosProducto = mysqli_query($conexion,$query_DatosProducto) or die(mysqli_error($conexion));
	$row_DatosProducto = mysqli_fetch_assoc($DatosProducto);
	$totalRows_DatosProducto = mysqli_num_rows($DatosProducto);
	
	
	
	?>
	
	<tr>
	<td><?php echo $contador; ?></td>
	<td><img src="<?php echo $row_DatosProducto['ruta_img']; ?>" class="img-rounded" alt="" width="40" height="40"></td>
	<td><?php echo $row_DatosProducto['artista'].", ".$row_DatosProducto['album']; ?></td>
	<td>
	<form method="post" name="form2" action="<?php echo $editFormAction; ?>">
	<input type="number" name="cantidad" id="" min="1" max="50"  style="width:50px; text-align:center;"  value="<?php echo $row_Carrito['cantidad']; ?>" >&nbsp;&nbsp;
	<input type="hidden" name="MM_update" value="form2">
	<input type="hidden" name="id" value="<?php echo $row_Carrito['id']; ?>">
	<button type="submit" class="btn btn-default"><i class="fa fa-refresh" aria-hidden="true"></i></button>
	</form>
	
	</td> 
	<td><?php echo "$".$row_DatosProducto['precio'].".00"; ?></td>  
	<?php
	$subtotal=$row_DatosProducto['precio']*$row_Carrito['cantidad'];
	?>
	<td><?php echo "$".$subtotal.".00"; ?></td>
	<?php
	$total=$total+$subtotal;
	?>
	</tr>
	
	<?php 
	$contador=$contador+1;
	?>
	
	<?php
}while($row_Carrito = mysqli_fetch_assoc($Carrito)); 
?>

	<tr>
        <td colspan="5" style="text-align:right;">Total:</td>
         <td><?php echo "$".$total.".00"; ?></td>

    </tr>
</tbody>
</table>
  
  
  
 





<!-- ====================== inicio de pago a paypal ============================== -->
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="business" value="j.garcia.e1987@gmail.com">
<!--input type="hidden" name="item_name" value="Item Name"-->
<input type="hidden" name="currency_code" value="MXN">
<!--input type="hidden" name="amount" value="0.00"-->
<!--input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"-->


<?php
$x=1;
do{	

//toma datos del producto
	mysqli_select_db($conexion,$database_conexion);
	$query_DatosProductoPaypal = "SELECT
	productos.id as id_producto,
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
	precios.precio,
	genero.nombre AS nombre_genero,
	categoria.nombre as nombre_categoria
	FROM
	productos
	INNER JOIN precios ON productos.clave_precio = precios.clave
	INNER JOIN genero ON productos.genero = genero.id
	INNER JOIN categoria ON productos.categoria = categoria.id where productos.id=".$row_Paypal['id_producto'];
	$DatosProductoPaypal = mysqli_query($conexion,$query_DatosProductoPaypal) or die(mysqli_error($conexion));
	$row_DatosProductoPaypal = mysqli_fetch_assoc($DatosProductoPaypal);
	$totalRows_DatosProductoPaypal = mysqli_num_rows($DatosProductoPaypal);
	
?>
    <input type="hidden" name="item_name_<?php echo $x; ?>" value="<?php echo $row_DatosProductoPaypal['artista'].", ".$row_DatosProductoPaypal['album']; ?>">
    <input type="hidden" name="quantity_<?php echo $x; ?>" value="<?php echo $row_Paypal['cantidad']; ?>">
    <input type="hidden" name="amount_<?php echo $x; ?>" value="<?php echo $row_DatosProductoPaypal['precio']; ?>">
<?php	
$x=$x+1;
}while($row_Paypal = mysqli_fetch_assoc($Paypal));
?>
<input type="image" src="http://www.paypal.com/es_XC/i/btn/x-click-but01.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">

</form>
<!-- ====================== fin de pago a paypal ============================== -->




  

              <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->

        <hr>

      

    </div>
    <!-- /.container -->
    
    
    <?php include("pie.php"); ?>
 


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<?php
/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>

</body>

</html>

<?php
mysqli_free_result($UpdateCant);



mysqli_free_result($DatosProducto);

mysqli_free_result($Carrito);
?>