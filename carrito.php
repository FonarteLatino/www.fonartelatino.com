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


mysql_select_db($database_conexion, $conexion);
$query_UpdateCant = "SELECT * FROM carrito";
$UpdateCant = mysql_query($query_UpdateCant, $conexion) or die(mysql_error());
$row_UpdateCant = mysql_fetch_assoc($UpdateCant);
$totalRows_UpdateCant = mysql_num_rows($UpdateCant);

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
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

	?><script type="text/javascript">window.location="carrito.php";</script><?php
}
//fin de modifica cantidad













//SI EXISTE LA SESION TEMPORAL
if(isset($_SESSION['CARRITO_TEMP']))
{
	mysql_select_db($database_conexion, $conexion);
	$query_Carrito = "SELECT * from carrito where id_usr=".$_SESSION['CARRITO_TEMP'];
	$Carrito = mysql_query($query_Carrito, $conexion) or die(mysql_error());
	$row_Carrito = mysql_fetch_assoc($Carrito);
	$totalRows_Carrito = mysql_num_rows($Carrito);
}
//SI EXISTE LA SESION DEL USUARIO(AL CREARSE ESTA, SE ELIMINA LA TEMPORAL)
else if(isset($_SESSION['USUARIO_ECOMMERCE']))
{
	mysql_select_db($database_conexion, $conexion);
	$query_Carrito = "SELECT * from carrito where  id_usr=".$_SESSION['USUARIO_ECOMMERCE']['id'];
	$Carrito = mysql_query($query_Carrito, $conexion) or die(mysql_error());
	$row_Carrito = mysql_fetch_assoc($Carrito);
	$totalRows_Carrito = mysql_num_rows($Carrito);
}

else if(isset($totalRows_Carrito) and ($totalRows_Carrito==0))
{
	?><script type="text/javascript">window.location="catalogo.php?categoria=1";</script><?php
}


}


//borra producto del carrito
if(isset($_GET['borra_prod']) and ($_GET['borra_prod']==1))
{
	$deleteSQL = sprintf("DELETE FROM carrito WHERE id=%s",
	GetSQLValueString($_GET['id'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
	?><script type="text/javascript">window.location="carrito.php";</script><?php
}




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

    <title>Fonarte Latino | Carrito</title>
  
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
    
		
         <?php include("pinta_alerta.php"); ?>
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Carrito<small>&nbsp;</small></p>
                </div>
            </div>
        </div>
        </div>
        <!-- Fin de titulo de la pagina -->

<div class="container">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->

              
               
   <br><br>
  
<!-- ======================== INICIO DE PASOS ======================================== -->
<div class="row tipografia2">

<div class="col-sm-3">
<button type="button" class="btn btn-default" style=" text-align:center; color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px;border:2px solid #ffffff; width:100%;"><i class="fa fa-shopping-cart  fa-1x" aria-hidden="true"></i>&nbsp;Carrito</button>
</div>

<div class="col-sm-3" >
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px; background-color:#D8D8D8; border:2px solid #ffffff; width:100%;"><i class="fa fa-lock fa-1x" aria-hidden="true"></i>&nbsp;Iniciar Sesi&oacute;n</button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px;  background-color:#D8D8D8; border:2px solid #ffffff; width:100%;"><i class="fa fa-share fa-1x" aria-hidden="true"></i>&nbsp;Direcci&oacute;n de Env&iacute;o</button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px; background-color:#D8D8D8;  border:2px solid #ffffff; width:100%;"><i class="fa fa-usd fa-1x" aria-hidden="true"></i>&nbsp;Pago</button>
</div>
  
</div>
<!-- ======================== FIN DE PASOS ======================================== -->


<br><br><br>
       
<?php 
$contador=1;
$total=0;
do{

	?>
    
    
    
<div class="row tipografia2" style="border:1px solid #eee" >

    <div class="col-sm-1"  >#&nbsp;<?php echo $contador; ?></div>

    <div class="col-sm-5" ><?php echo utf8_encode($row_Carrito['artista']).", ".utf8_encode($row_Carrito['album']); ?></div>
    
    <div class="col-sm-3" >
    <span style="font-size:10px;font-weight: bold;">Cantidad</span>
    <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
    <input type="number" name="cantidad" id="" min="1" max="50"  style="width:50px; text-align:center;"  value="<?php echo $row_Carrito['cantidad']; ?>" >&nbsp;&nbsp;
    <input type="hidden" name="MM_update" value="form2">
    <input type="hidden" name="id" value="<?php echo $row_Carrito['id']; ?>">
    <button type="submit" class="btn btn-default"><i class="fa fa-refresh" aria-hidden="true"></i></button>
    </form>
    </div>
    
    <div class="col-sm-1" ><span style="font-size:10px;font-weight: bold;">Precio: </span><?php echo "$".$row_Carrito['precio'].".00"; ?></div>
    
    <?php
    $subtotal=$row_Carrito['precio']*$row_Carrito['cantidad'];
    ?>
    
    <div class="col-sm-1"  ><span style="font-size:10px;font-weight: bold;">Sub-Total: </span><?php echo "$".$subtotal.".00"; ?></div>
    <?php
    $total=$total+$subtotal;
    $contador=$contador+1;
    ?>
    
    <!-- ====== boton de borra produto del carrito =========== -->
    <div class="col-sm-1"  ><a href="carrito.php?borra_prod=1&id=<?php echo $row_Carrito['id']; ?>"><button type="button" class="btn btn-default"><i class="fa fa-times" aria-hidden="true"></i></button></a></div>
</div>
 
 
<?php
}while($row_Carrito = mysql_fetch_assoc($Carrito)); 
?>

    
<div class="row tipografia2" style="border:1px solid #eee; margin-top: 1%;padding-top: 1%;padding-bottom: 1%;" >
    
    <div class="col-sm-10" style="text-align:right;">&nbsp;</div>
    <div class="col-sm-2"  ><?php echo "$".$total.".00"; ?></div>
    
</div>
 

  <br><br>
  <div style="text-align:right;">
  <button type="button"  class="btn btn-default tipografia2"  onClick="location.href='<?php echo $ruta_absoluta; ?>cuenta.php'" >Siguiente&nbsp;<i class="fa fa-step-forward  fa-1x" aria-hidden="true"></i></button>
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
mysql_free_result($UpdateCant);



//mysql_free_result($DatosProducto);

mysql_free_result($Carrito);
?>