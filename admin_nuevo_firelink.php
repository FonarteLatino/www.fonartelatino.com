<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php require_once('Connections/conexion.php'); ?>
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

  ?><script type="text/javascript">window.location="<?php echo $MM_restrictGoTo ?>";</script><?php
  exit;
}
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysql_select_db($database_conexion, $conexion);
$query_Precios = "SELECT * FROM precios order by clave ASC";
$Precios = mysql_query($query_Precios, $conexion) or die(mysql_error());
$row_Precios = mysql_fetch_assoc($Precios);
$totalRows_Precios = mysql_num_rows($Precios);

mysql_select_db($database_conexion, $conexion);
$query_Generos = "SELECT * FROM genero order by nombre ASC";
$Generos = mysql_query($query_Generos, $conexion) or die(mysql_error());
$row_Generos = mysql_fetch_assoc($Generos);
$totalRows_Generos = mysql_num_rows($Generos);


//muestra todas las categorias que no sean merchandisign 
mysql_select_db($database_conexion, $conexion);
$query_Categoria = "SELECT * FROM categoria WHERE id!=4  order by nombre ASC";
$Categoria = mysql_query($query_Categoria, $conexion) or die(mysql_error());
$row_Categoria = mysql_fetch_assoc($Categoria);
$totalRows_Categoria = mysql_num_rows($Categoria);

//muestra todas las categorias que no sean merchandisign  PARA EL SUBTITULO
mysql_select_db($database_conexion, $conexion);
$query_CategoriaSub = "SELECT * FROM categoria WHERE id!=4  order by nombre ASC";
$CategoriaSub = mysql_query($query_CategoriaSub, $conexion) or die(mysql_error());
$row_CategoriaSub = mysql_fetch_assoc($CategoriaSub);
$totalRows_CategoriaSub = mysql_num_rows($CategoriaSub);


if(isset($_POST['inserta']) and ($_POST['inserta']==1))
{
	/*
	print_r($_POST);
	echo "<br>";
	print_r($_FILES['ruta_img']['name']);
	echo "<br>";
	print_r($_FILES['ruta_img_2']['name']);
	*/
	
	
	/* no agrego imagen de portada, deja la misma*/
	if($_FILES['ruta_img']['name']=='')
	{
		$ruta_img='';
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
		$ruta_img_2='';
	}
	/* si agrego imagen secundaria, se la asigna a la variable*/
	else
	{
		include_once("sube_foto_secundaria.php");
		$ruta_img_2="img/caratulas/".$nuevo_nombre_ruta_img_2;//esta variable viene del archivo sube_foto_secundaria.php
	}
	
	$insertSQL = sprintf("INSERT INTO productos (sku, id_fonarte, clave_precio, artista, album, genero, genero2, genero3, categoria, spotify, itunes, amazon, google, ruta_img, ruta_img_2, descripcion, fecha_alta, hora_alta, prendido, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString($_POST['sku'], "text"),
	GetSQLValueString($_POST['id_fonarte'], "text"),
	GetSQLValueString($_POST['clave_precio'], "text"),
	GetSQLValueString(utf8_decode($_POST['artista']), "text"),
	GetSQLValueString(utf8_decode($_POST['album']), "text"),
	GetSQLValueString(utf8_decode($_POST['genero']), "text"),
	GetSQLValueString(utf8_decode($_POST['genero2']), "text"),
	GetSQLValueString(utf8_decode($_POST['genero3']), "text"),
	GetSQLValueString($_POST['categoria'], "int"),
	GetSQLValueString($_POST['spotify'], "text"),
	GetSQLValueString($_POST['itunes'], "text"),
	GetSQLValueString($_POST['amazon'], "text"),
	GetSQLValueString($_POST['google'], "text"),
	GetSQLValueString($ruta_img, "text"),
	GetSQLValueString($ruta_img_2, "text"),
	GetSQLValueString(utf8_decode($_POST['descripcion']), "text"),
	GetSQLValueString($_POST['fecha_alta'], "date"),
	GetSQLValueString($_POST['hora_alta'], "date"),
	GetSQLValueString($_POST['prendido'], "int"),
	GetSQLValueString($_POST['estatus'], "text"));
	
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
	
	?><script type="text/javascript">window.location="admin_nuevo_producto.php?alerta=5";</script><?php
	
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
                <h1 class="page-header tipografia2"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nuevo
                    <small>Firelink</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
        
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
                
         <br>      

<form class="form-horizontal tipografia_form_admin"  enctype="multipart/form-data"  method="post" action="" name="form1" >


<div class="form-group">
    <label class="control-label col-sm-2" for="" >Album/Single:</label>
    <div class="col-sm-4">
    
      <select class="form-control" id="id_categoria" name="categoria" >
      <?php
      do {  
      ?><option value="<?php echo $row_Categoria['id']?>"><?php echo $row_Categoria['nombre']?></option><?php
      } while ($row_Categoria = mysql_fetch_assoc($Categoria));
      $rows = mysql_num_rows($Categoria);
      if($rows > 0) 
      {
      mysql_data_seek($Categoria, 0);
      $row_Categoria = mysql_fetch_assoc($Categoria);
      }
      ?>
      </select>
    </div>
</div>

<div class="form-group">
 <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Spotify:</label>
    <div class="col-sm-4">
    <input type="url" name="spotify" class="form-control" id="" value="" >
    </div>
    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">iTunes:</label>
    <div class="col-sm-4">
    <input type="url" name="itunes" class="form-control" id="" value="" >
    </div>
   
</div>


<div class="form-group">
 <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Amazon:</label>
    <div class="col-sm-4">
    <input type="url" name="amazon" class="form-control" id="" value="" >
    </div>
    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Google:</label>
    <div class="col-sm-4">
      <input type="url" name="google" class="form-control" id="" value="" >
    </div>
    
</div>

<div class="form-group">
 <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Claro:</label>
    <div class="col-sm-4">
    <input type="url" name="claro" class="form-control" id="" value="" >
    </div>
    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Youtube:</label>
    <div class="col-sm-4">
      <input type="url" name="youtube" class="form-control" id="" value="" >
    </div>
    
</div>

<div class="form-group">
 <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Deezer:</label>
    <div class="col-sm-4">
    <input type="url" name="amazon" class="form-control" id="" value="" >
    </div>
    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Tidal:</label>
    <div class="col-sm-4">
      <input type="url" name="google" class="form-control" id="" value="" >
    </div>
    
</div>

  <div class="form-group">
 <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="" >Video Youtube:</label>
    <div class="col-sm-4">
      <input type="url" name="vYou" class="form-control" id="" value="" >
    </div>
    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Descripci&oacute;n:</label>
    <div class="col-sm-4">
    <textarea class="form-control" rows="3" id="comment" name="descripcion" ></textarea>
    </div>
</div>
  


  <div class="form-group">
<!-- *********************************************** -->
     <label class="control-label col-sm-2" for="">Imagen de Portada:</label>
    <div class="col-sm-4">
      <input type="file" name="ruta_img" class="form-control" id="id_ruta_img" value="" >
    </div>
    <!-- *********************************************** -->
   <label class="control-label col-sm-2" for="">Mostrar Video:</label>
    <div class="col-sm-4">
      <input type="checkbox" name="mostrarVideo" class="form-control" id="mostrar_video" value="" >
    </div>
   

</div>

<div class="form-group">
<!-- *********************************************** -->
     <label class="control-label col-sm-2" for="">Estatus:</label>
    <div class="col-sm-4">
        <select class="form-control" id="" name="estatus">
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
            <option value="DIGITAL">DIGITAL</option>
        </select>
    </div>
    <!-- *********************************************** -->  

</div>


  




  
  
    <input type="hidden" name="fecha_alta" value="<?php echo date("Y-m-d");  ?>" >
    <input type="hidden" name="hora_alta" value="<?php echo date("H:i:s");  ?>" >

    <input type="hidden" name="prendido" value="1" >
    <input type="hidden" name="inserta" value="1" >

  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" style="background-color:#244e58; color:#ffffff;"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar</button>
    </div>
  </div>
</form>
  
  
  


               
               
               
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

mysql_free_result($Generos);

mysql_free_result($Categoria);
?>
