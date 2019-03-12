<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); ?>
<?php

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php?alerta=3";
if (!((isset($_SESSION['MM_Username_Panel'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username_Panel'], $_SESSION['MM_UserGroup_Panel'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);

  ?><script type="text/javascript">window.location="<?php echo $MM_restrictGoTo; ?>";</script><?php
  exit;
}

mysql_select_db($database_conexion, $conexion);
$query_Otros = "SELECT
productos_otros.id,
productos_otros.sku,
productos_otros.id_fonarte,
productos_otros.clave_precio,
productos_otros.artista,
productos_otros.tipo,
productos_otros.s,
productos_otros.m,
productos_otros.l,
productos_otros.ruta_img,
productos_otros.ruta_img_2,
productos_otros.descripcion,
productos_otros.fecha_alta,
productos_otros.hora_alta,
productos_otros.prendido,
productos_otros.estatus,
cat_otros.nombre,

precios.precio
FROM
productos_otros
INNER JOIN cat_otros ON cat_otros.id = productos_otros.tipo
INNER JOIN precios ON productos_otros.clave_precio = precios.clave

where productos_otros.prendido=1 and productos_otros.id=".$_GET['id_producto_otro'];
$Otros = mysql_query($query_Otros, $conexion) or die(mysql_error());
$row_Otros = mysql_fetch_assoc($Otros);
$totalRows_Otros = mysql_num_rows($Otros);


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

mysql_select_db($database_conexion, $conexion);
$query_Precios = "SELECT * FROM precios where clave!='".$row_Otros['clave_precio']."'";
$Precios = mysql_query($query_Precios, $conexion) or die(mysql_error());
$row_Precios = mysql_fetch_assoc($Precios);
$totalRows_Precios = mysql_num_rows($Precios);

mysql_select_db($database_conexion, $conexion);
$query_Tipo = "SELECT * FROM cat_otros where id!=".$row_Otros['tipo'];
$Tipo = mysql_query($query_Tipo, $conexion) or die(mysql_error());
$row_Tipo = mysql_fetch_assoc($Tipo);
$totalRows_Tipo = mysql_num_rows($Tipo);



/*=================================inicio de modifica un producto ===========================*/
if(isset($_POST['modifica']) and ($_POST['modifica']==1))
{
	
		/* no agrego imagen de portada, deja la misma*/
	if($_FILES['ruta_img']['name']=='')
	{
		$ruta_img=$_POST['ruta_img_default'];
	}
	/* si agrego imagen de portada, se la asigna a la variable*/
	else
	{
		include_once("sube_foto_portada.php");
		$ruta_img="img/caratulas/".$nuevo_nombre_ruta_img;//esta variable viene del archivo sube_foto_portada.php
	}
	
	
	/* no agrego imagen secundaria, deja la misma*/
	if($_FILES['ruta_img_2']['name']=='')
	{
		$ruta_img_2=$_POST['ruta_img_2_default'];
	}
	/* si agrego imagen secundaria, se la asigna a la variable*/
	else
	{
		include_once("sube_foto_secundaria.php");
		$ruta_img_2="img/caratulas/".$nuevo_nombre_ruta_img_2;//esta variable viene del archivo sube_foto_secundaria.php
	}
	
 $updateSQL = sprintf("UPDATE productos_otros SET sku=%s, id_fonarte=%s, clave_precio=%s, artista=%s, tipo=%s, s=%s, m=%s, l=%s, ruta_img=%s, ruta_img_2=%s, descripcion=%s, fecha_alta=%s, hora_alta=%s, prendido=%s, estatus=%s WHERE id=%s",
	GetSQLValueString($_POST['sku'], "text"),
	GetSQLValueString($_POST['id_fonarte'], "text"),
	GetSQLValueString($_POST['clave_precio'], "text"),
	GetSQLValueString(utf8_decode($_POST['artista']), "text"),
	GetSQLValueString(utf8_decode($_POST['tipo']), "int"),
	GetSQLValueString($_POST['s'], "int"),
	GetSQLValueString($_POST['m'], "int"),
	GetSQLValueString($_POST['l'], "int"),
	GetSQLValueString($ruta_img, "text"),
	GetSQLValueString($ruta_img_2, "text"),
	GetSQLValueString(utf8_decode($_POST['descripcion']), "text"),
	GetSQLValueString($_POST['fecha_alta'], "date"),
	GetSQLValueString($_POST['hora_alta'], "date"),
	GetSQLValueString($_POST['prendido'], "int"),
	GetSQLValueString($_POST['estatus'], "text"),
	GetSQLValueString($_POST['id'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


	?><script type="text/javascript">window.location="admin_ver_producto_otro.php?alerta=6&id_producto_otro=<?php echo $_POST['id'] ?>";</script><?php
	
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

    <title>Fonarte Latino | Ver Producto</title>
  
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

    <?php include("menu_admin.php"); ?>

    <!-- Page Content -->
    <div class="container">
		
         <?php include("pinta_alerta.php"); ?>
        <!-- Inicio de titulo de la pagina -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?php echo utf8_encode($row_Otros['artista']); ?>
                    <small><?php echo utf8_encode($row_Otros['nombre']); ?></small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               <br>
                            
<div class="row">
  <div class="col-sm-4 tipografia2">
  	<center>
  	<h4>Imagen de portada</h4>
  	<img src="<?php echo $row_Otros['ruta_img'] ?>" class="img-rounded" alt="" width="80%" height="80%"><br><br>
    <h4>Imagen secundaria</h4>
    <img src="<?php echo $row_Otros['ruta_img_2'] ?>" class="img-rounded" alt="" width="80%" height="80%">
    </center>
  </div>
  <div class="col-sm-8">
  
  
  <form class="form-horizontal tipografia_admin_ver_prod"  enctype="multipart/form-data"  method="post" action="admin_ver_producto_otro.php?id_producto_otro=<?php echo $_GET['id_producto_otro'];  ?>" name="form1" >
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">#:</label>
    <div class="col-sm-10">
      <input type="text" name="id" class="form-control" id="" value="<?php echo $row_Otros['id']; ?>"  required readonly>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">SKU:</label>
    <div class="col-sm-10">
      <input type="text" name="sku" class="form-control" id="" value="<?php echo $row_Otros['sku']; ?>"  required>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Clave:</label>
    <div class="col-sm-10">
      <input type="text" name="id_fonarte" class="form-control" id="" value="<?php echo $row_Otros['id_fonarte']; ?>"  required>
    </div>
  </div>
  
  
   <?php 
    mysql_select_db($database_conexion, $conexion);
    $query_Precio2 = "SELECT * FROM precios where clave='".$row_Otros['clave_precio']."'";
    $Precio2 = mysql_query($query_Precio2, $conexion) or die(mysql_error());
    $row_Precio2 = mysql_fetch_assoc($Precio2);
    $totalRows_Precio2= mysql_num_rows($Precio2); 
    ?>
   <div class="form-group">
    <label class="control-label col-sm-2" for="">Clave Precio:</label>
    <div class="col-sm-10">
    <select class="form-control"  name="clave_precio" id="sel1">
      <option value="<?php echo $row_Precio2['clave']; ?>"><?php echo $row_Precio2['clave']." - $".$row_Precio2['precio'].".00"; ?></option>
      <?php
do {  
?>
      <option value="<?php echo $row_Precios['clave']?>"><?php echo $row_Precios['clave']." - $".$row_Precios['precio'].".00"?></option>
      <?php
} while ($row_Precios = mysql_fetch_assoc($Precios));
  $rows = mysql_num_rows($Precios);
  if($rows > 0) {
      mysql_data_seek($Precios, 0);
	  $row_Precios = mysql_fetch_assoc($Precios);
  }
?>
    </select>

    </div>
  </div>
  

  
	<?php 
    mysql_select_db($database_conexion, $conexion);
    $query_Tipo2 = "SELECT * FROM cat_otros where id=".$row_Otros['tipo'];
    $Tipo2 = mysql_query($query_Tipo2, $conexion) or die(mysql_error());
    $row_Tipo2 = mysql_fetch_assoc($Tipo2);
    $totalRows_Tipo2= mysql_num_rows($Tipo2); 
    ?>
    
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Tipo:</label>
    <div class="col-sm-10">
      <select class="form-control" id="sel1" name="tipo">

        <option value="<?php echo $row_Tipo2['id']; ?>"><?php echo utf8_encode($row_Tipo2['nombre']); ?></option> 
        <?php
do {   
?>
        <option value="<?php echo $row_Tipo['id']?>"><?php echo utf8_encode($row_Tipo['nombre']); ?></option>
        <?php
} while ($row_Tipo = mysql_fetch_assoc($Tipo));
  $rows = mysql_num_rows($Tipo);
  if($rows > 0) {
      mysql_data_seek($Tipo, 0);
	  $row_Tipo = mysql_fetch_assoc($Tipo);
  }
?>
      </select>
    </div>
  </div>
  
  

  <div class="form-group">
    <label class="control-label col-sm-2" for="">Artista:</label>
    <div class="col-sm-10">
      <input type="text" name="artista" class="form-control" id="" value="<?php echo utf8_encode($row_Otros['artista']); ?>"  required>
    </div>
  </div>
  
  <?php
  if($row_Otros['tipo']==2 or $row_ProductosOtros['tipo']==3)//es playera o sudadera, muestra tallas
  {
	  ?>
      <div class="form-group">
    <label class="control-label col-sm-2" for="" >Talla:</label>
    <div class="col-sm-10">
        <div class="checkbox">
        <label><input type="checkbox" value="1" name="s" <?php if($row_Otros['s']==1){ ?>checked<?  } ?>>S</label>
        </div>
        <div class="checkbox">
        <label><input type="checkbox" value="1" name="m" <?php if($row_Otros['m']==1){ ?>checked<?  } ?>>M</label>
        </div>
        <div class="checkbox disabled">
        <label><input type="checkbox" value="1" name="l" <?php if($row_Otros['l']==1){ ?>checked<?  } ?>>L</label>
        </div>
    </div>
</div>
      
      <?php
  }
  else//no es playera ni sudadera
  {
	  ?>
      <input type="hidden" value="0" name="s">
      <input type="hidden" value="0" name="m">
      <input type="hidden" value="0" name="l">
      <?php
  }
  ?>
  


  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Descripcion:</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="5" id="comment" name="descripcion"><?php echo utf8_encode($row_Otros['descripcion']); ?></textarea>
    </div>
  </div>
  
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Imagen de Portada:</label>
    <div class="col-sm-10">
      <input type="file" name="ruta_img" class="form-control" id="id_ruta_img" value="" >
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Imagen Secundaria:</label>
    <div class="col-sm-10">
      <input type="file" name="ruta_img_2" class="form-control" id="id_ruta_img_2" value="" >
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Estatus:</label>
    <div class="col-sm-10">
      <select class="form-control" id="" name="estatus">
            <option value="<?php echo $row_Otros['estatus']; ?>"><?php echo $row_Otros['estatus']; ?></option>
            <?php
			if($row_Otros['estatus']=='ACTIVO')
			{
				?>
                <option value="INACTIVO">INACTIVO</option>
                <option value="DIGITAL">DIGITAL</option>
                <?php
			}
			if($row_Otros['estatus']=='INACTIVO')
			{
				?>
                <option value="ACTIVO">ACTIVO</option>
                <option value="DIGITAL">DIGITAL</option>
                <?php
			}
			if($row_Otros['estatus']=='DIGITAL')
			{
				?>
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
                <?php
			}
			
			?>
           
        </select>
    </div>
  </div>
  
   
  
  
    <input type="hidden" name="fecha_alta" value="<?php echo date("Y-m-d");  ?>" >
    <input type="hidden" name="hora_alta" value="<?php echo date("H:i:s");  ?>" >
    
    <input type="hidden" name="ruta_img_default" value="<?php echo $row_Otros['ruta_img'];   ?>" >
    <input type="hidden" name="ruta_img_2_default" value="<?php echo $row_Otros['ruta_img_2']; ?>  " >

    <input type="hidden" name="prendido" value="1" >


    <input type="hidden" name="modifica" value="1" >

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" style="background-color:#244e58; color:#ffffff;"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Editar</button>
    </div>
  </div>
</form>
  
  
  
  </div>
</div>

               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->

        <hr>

       

    </div>
    <!-- /.container -->


<?php include("pie_admin.php"); ?>


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
mysql_free_result($Precios);

mysql_free_result($Tipo);


?>
