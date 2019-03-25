<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php require_once('Connections/conexion.php'); ?>
<?php


//header('Content-type: text/html; charset=utf-8');



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
$query_Precios = "SELECT * FROM precios";
$Precios = mysql_query($query_Precios, $conexion) or die(mysql_error());
$row_Precios = mysql_fetch_assoc($Precios);
$totalRows_Precios = mysql_num_rows($Precios);

mysql_select_db($database_conexion, $conexion);
$query_Generos = "SELECT * FROM genero";
$Generos = mysql_query($query_Generos, $conexion) or die(mysql_error());
$row_Generos = mysql_fetch_assoc($Generos);
$totalRows_Generos = mysql_num_rows($Generos);

mysql_select_db($database_conexion, $conexion);
$query_Categoria = "SELECT * FROM categoria";
$Categoria = mysql_query($query_Categoria, $conexion) or die(mysql_error());
$row_Categoria = mysql_fetch_assoc($Categoria);
$totalRows_Categoria = mysql_num_rows($Categoria);

mysql_select_db($database_conexion, $conexion);
$query_UpdateProducto = "SELECT * FROM productos";
$UpdateProducto = mysql_query($query_UpdateProducto, $conexion) or die(mysql_error());
$row_UpdateProducto = mysql_fetch_assoc($UpdateProducto);
$totalRows_UpdateProducto = mysql_num_rows($UpdateProducto);



mysql_select_db($database_conexion, $conexion);
$query_DetalleProducto = "SELECT
productos.id as id_bd,
productos.sku,
productos.id_fonarte,
productos.artista,
productos.album,
productos.genero,
genero.nombre AS gen_nombre,
productos.genero2,
productos.genero3,
productos.categoria,
productos.play,
categoria.nombre AS cat_nombre,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.claro,
productos.youtube,
productos.deezer,
productos.tidal,
productos.ruta_img,
productos.ruta_img_2,
productos.descripcion,
productos.clave_precio,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
productos.video,
productos.firelink,
productos.prendido,
precios.precio,
precios.id
FROM
productos
LEFT JOIN categoria ON categoria.id = productos.categoria
LEFT JOIN genero ON genero.id = productos.genero
LEFT JOIN precios ON precios.clave = productos.clave_precio WHERE productos.id=".$_GET['id_producto'];
$DetalleProducto = mysql_query($query_DetalleProducto, $conexion) or die(mysql_error());
$row_DetalleProducto = mysql_fetch_assoc($DetalleProducto);
$totalRows_DetalleProducto = mysql_num_rows($DetalleProducto);



/*=================================inicio de modifica un producto ===========================*/
if(isset($_POST['modifica']) and ($_POST['modifica']==1))
{
	/*
	print_r($_POST);
	print_r( $_FILES['ruta_img']['name']);
	print_r ($_FILES['ruta_img_2']['name']);
	*/
	
	
	/* no agrego imagen de portada, deja la misma*/
	if($_FILES['ruta_img']['name']=='')
	{
		$ruta_img=$_POST['ruta_img'];
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
		$ruta_img_2=$_POST['ruta_img_2'];
	}
	/* si agrego imagen secundaria, se la asigna a la variable*/
	else
	{
		include_once("sube_foto_secundaria.php");
		$ruta_img_2="img/caratulas/".$nuevo_nombre_ruta_img_2;//esta variable viene del archivo sube_foto_secundaria.php
	}
	
		$updateSQL = sprintf("UPDATE productos SET sku=%s, id_fonarte=%s, clave_precio=%s, artista=%s, album=%s, genero=%s, genero2=%s, genero3=%s, categoria=%s, play=%s, spotify=%s, itunes=%s, amazon=%s, google=%s, claro=%s, youtube=%s, deezer=%s, tidal=%s, ruta_img=%s, ruta_img_2=%s, descripcion=%s, fecha_alta=%s, hora_alta=%s, prendido=%s, estatus=%s, video=%s, firelink=%s WHERE id=%s",
	GetSQLValueString($_POST['sku'], "text"),
	GetSQLValueString($_POST['id_fonarte'], "text"),
	GetSQLValueString($_POST['clave_precio'], "text"),
	GetSQLValueString(utf8_decode($_POST['artista']), "text"),
	GetSQLValueString(utf8_decode($_POST['album']), "text"),
	GetSQLValueString(utf8_decode($_POST['genero']), "int"),
	GetSQLValueString(utf8_decode($_POST['genero2']), "int"),
	GetSQLValueString(utf8_decode($_POST['genero3']), "int"),
	GetSQLValueString(utf8_decode($_POST['categoria']), "int"),
  GetSQLValueString($_POST['play'], "text"),
	GetSQLValueString($_POST['spotify'], "text"),
	GetSQLValueString($_POST['itunes'], "text"),
	GetSQLValueString($_POST['amazon'], "text"),
	GetSQLValueString($_POST['google'], "text"),
  GetSQLValueString($_POST['claro'], "text"),
  GetSQLValueString($_POST['youtube'], "text"),
  GetSQLValueString($_POST['deezer'], "text"),
  GetSQLValueString($_POST['tidal'], "text"),
	GetSQLValueString($ruta_img, "text"),
	GetSQLValueString($ruta_img_2, "text"),
	GetSQLValueString(utf8_decode($_POST['descripcion']), "text"),
	GetSQLValueString($_POST['fecha_alta'], "date"),
	GetSQLValueString($_POST['hora_alta'], "date"),
	GetSQLValueString($_POST['prendido'], "int"),
	GetSQLValueString($_POST['estatus'], "text"),
  GetSQLValueString($_POST['video'], "text"),
  GetSQLValueString($_POST['firelink'], "text"),
	GetSQLValueString($_POST['id'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());


	?><script type="text/javascript">window.location="admin_ver_producto.php?alerta=6&id_producto=<?php echo $_POST['id'] ?>";</script><?php

}
/*=================================fin de modifica un producto ===========================*/
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
                <h1 class="page-header tipografia2"><?php echo utf8_encode($row_DetalleProducto['artista']); ?>
                    <small><?php echo utf8_encode($row_DetalleProducto['album']); ?></small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
                
               
<div class="row">
  <div class="col-sm-4 tipografia2">
  	<center>
  	<h4>Imagen de portada</h4>
  	<img src="<?php echo $row_DetalleProducto['ruta_img'] ?>" class="img-rounded" alt="" width="80%" height="80%"><br><br>
    <h4>Imagen secundaria</h4>
    <img src="<?php echo $row_DetalleProducto['ruta_img_2'] ?>" class="img-rounded" alt="" width="80%" height="80%">
    </center>
  </div>
  <div class="col-sm-8">
  
  
  <form class="form-horizontal tipografia_admin_ver_prod"  enctype="multipart/form-data"  method="post" action="admin_ver_producto.php?id_producto=<?php echo $_GET['id_producto'];  ?>" name="form1" >
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">#:</label>
    <div class="col-sm-10">
      <input type="text" name="id" class="form-control" id="" value="<?php echo $row_DetalleProducto['id_bd']; ?>"  required readonly>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">SKU:</label>
    <div class="col-sm-10">
      <input type="text" name="sku" class="form-control" id="" value="<?php echo $row_DetalleProducto['sku']; ?>"  required>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Id Interno:</label>
    <div class="col-sm-10">
      <input type="text" name="id_fonarte" class="form-control" id="" value="<?php echo $row_DetalleProducto['id_fonarte']; ?>"  required>
    </div>
  </div>
  
   <div class="form-group">
    <label class="control-label col-sm-2" for="">Clave Precio:</label>
    <div class="col-sm-10">
    <select class="form-control"  name="clave_precio" id="sel1">
      <option value="<?php echo $row_DetalleProducto['clave_precio']; ?>"><?php echo $row_DetalleProducto['clave_precio']." - $".$row_DetalleProducto['precio'].".00"; ?></option>
      <?php
		do 
		{  
			?><option value="<?php echo $row_Precios['clave']?>"><?php echo $row_Precios['clave']." - $".$row_Precios['precio'].".00"; ?></option><?php
        }while ($row_Precios = mysql_fetch_assoc($Precios));
		
        $rows = mysql_num_rows($Precios);
        if($rows > 0) 
		{
			mysql_data_seek($Precios, 0);
			$row_Precios = mysql_fetch_assoc($Precios);
        }
        ?>
    </select>

    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Artista:</label>
    <div class="col-sm-10">
      <input type="text" name="artista" class="form-control" id="" value="<?php echo utf8_encode($row_DetalleProducto['artista']); ?>"  required>
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Album:</label>
    <div class="col-sm-10">
      <input type="text" name="album" class="form-control" id="" value="<?php echo utf8_encode($row_DetalleProducto['album']); ?>" required>
    </div>
  </div>
  
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">G&eacute;nero 1:</label>
    <div class="col-sm-10">
        <select class="form-control" id="sel1" name="genero">
        <?php
		
		mysql_select_db($database_conexion, $conexion);
		$query_GenerosSelect = "SELECT * FROM genero where id=".$row_DetalleProducto['genero'];
		$GenerosSelect = mysql_query($query_GenerosSelect, $conexion) or die(mysql_error());
		$row_GenerosSelect = mysql_fetch_assoc($GenerosSelect);
		$totalRows_GenerosSelect = mysql_num_rows($GenerosSelect);
		?>
            <option value="<?php echo $row_GenerosSelect['id'];?>"><?php echo utf8_encode($row_GenerosSelect['nombre']);?></option>
            <?php
            do {  
            	?><option value="<?php echo $row_Generos['id']?>"><?php echo utf8_encode($row_Generos['nombre']); ?></option><?php
            } while ($row_Generos = mysql_fetch_assoc($Generos));
            $rows = mysql_num_rows($Generos);
            if($rows > 0) 
			{
				mysql_data_seek($Generos, 0);
				$row_Generos = mysql_fetch_assoc($Generos);
            }
            ?>
        </select>
    </div>
  </div>
  
  
   <div class="form-group">
    <label class="control-label col-sm-2" for="">G&eacute;nero 2:</label>
    <div class="col-sm-10">
        <select class="form-control" id="sel1" name="genero2">
        	 <?php
		
		mysql_select_db($database_conexion, $conexion);
		$query_GenerosSelect2 = "SELECT * FROM genero where id=".$row_DetalleProducto['genero2'];
		$GenerosSelect2 = mysql_query($query_GenerosSelect2, $conexion) or die(mysql_error());
		$row_GenerosSelect2 = mysql_fetch_assoc($GenerosSelect2);
		$totalRows_GenerosSelect2 = mysql_num_rows($GenerosSelect2);
		?>
            <option value="<?php echo $row_GenerosSelect2['id'];?>"><?php echo utf8_encode($row_GenerosSelect2['nombre']);?></option>
            <?php
            do {  
            	?><option value="<?php echo $row_Generos['id']?>"><?php echo utf8_encode($row_Generos['nombre']); ?></option><?php
            } while ($row_Generos = mysql_fetch_assoc($Generos));
            $rows = mysql_num_rows($Generos);
            if($rows > 0) 
			{
				mysql_data_seek($Generos, 0);
				$row_Generos = mysql_fetch_assoc($Generos);
            }
            ?>

        </select>
        
    </div>
  </div>
  
  
   <div class="form-group">
    <label class="control-label col-sm-2" for="">G&eacute;nero 3:</label>
    <div class="col-sm-10">
        <select class="form-control" id="sel1" name="genero3">
        <?php
		
		mysql_select_db($database_conexion, $conexion);
		$query_GenerosSelect3 = "SELECT * FROM genero where id=".$row_DetalleProducto['genero3'];
		$GenerosSelect3 = mysql_query($query_GenerosSelect3, $conexion) or die(mysql_error());
		$row_GenerosSelect3 = mysql_fetch_assoc($GenerosSelect3);
		$totalRows_GenerosSelect3 = mysql_num_rows($GenerosSelect3);
		?>
            <option value="<?php echo $row_GenerosSelect3['id'];?>"><?php echo utf8_encode($row_GenerosSelect3['nombre']);?></option>
            <?php
            do {  
            	?><option value="<?php echo $row_Generos['id']?>"><?php echo utf8_encode($row_Generos['nombre']); ?></option><?php
            } while ($row_Generos = mysql_fetch_assoc($Generos));
            $rows = mysql_num_rows($Generos);
            if($rows > 0) 
			{
				mysql_data_seek($Generos, 0);
				$row_Generos = mysql_fetch_assoc($Generos);
            }
            ?>

        </select>
    </div>
  </div>
  
   <div class="form-group">
    <label class="control-label col-sm-2" for="" >Categor&iacute;a:</label>
    <div class="col-sm-10">

    <select class="form-control" id="sel1" name="categoria">
    	<option value="<?php echo $row_DetalleProducto['categoria']; ?>"><?php echo utf8_encode($row_DetalleProducto['cat_nombre']); ?></option>
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
    <label class="control-label col-sm-2" for="">Spotify:</label>
    <div class="col-sm-10">
      <input type="text" name="spotify" class="form-control" id="" value="<?php echo $row_DetalleProducto['spotify']; ?>" >
    </div>
  </div>
  
    <div class="form-group">
    <label class="control-label col-sm-2" for="">iTunes:</label>
    <div class="col-sm-10">
      <input type="text" name="itunes" class="form-control" id="" value="<?php echo $row_DetalleProducto['itunes']; ?>" >
    </div>
  </div>
  
    <div class="form-group">
    <label class="control-label col-sm-2" for="">Amazon:</label>
    <div class="col-sm-10">
      <input type="text" name="amazon" class="form-control" id="" value="<?php echo $row_DetalleProducto['amazon']; ?>" >
    </div>
  </div>
  
    <div class="form-group">
    <label class="control-label col-sm-2" for="">Google:</label>
    <div class="col-sm-10">
      <input type="text" name="google" class="form-control" id="" value="<?php echo $row_DetalleProducto['google']; ?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="">Claro Music:</label>
    <div class="col-sm-10">
      <input type="text" name="claro" class="form-control" id="" value="<?php echo $row_DetalleProducto['claro']; ?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="">YouTube:</label>
    <div class="col-sm-10">
      <input type="text" name="youtube" class="form-control" id="" value="<?php echo $row_DetalleProducto['youtube']; ?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="">Deezer:</label>
    <div class="col-sm-10">
      <input type="text" name="deezer" class="form-control" id="" value="<?php echo $row_DetalleProducto['deezer']; ?>" >
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="">Tidal:</label>
    <div class="col-sm-10">
      <input type="text" name="tidal" class="form-control" id="" value="<?php echo $row_DetalleProducto['tidal']; ?>" >
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Descripcion:</label>
    <div class="col-sm-10">
      <textarea class="form-control" rows="5" id="comment" name="descripcion"><?php echo utf8_encode($row_DetalleProducto['descripcion']); ?></textarea>
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
    <label class="control-label col-sm-2" for="">Video:</label>
    <div class="col-sm-10">
      <input type="text" name="video" class="form-control" id="" value="<?php echo $row_DetalleProducto['video']; ?>" >
    </div>
  </div>
  
  <div class="form-group">
    <label class="control-label col-sm-2" for="">Estatus:</label>
    <div class="col-sm-10">
      <select class="form-control" id="" name="estatus">
            <option value="<?php echo $row_DetalleProducto['estatus']; ?>"><?php echo $row_DetalleProducto['estatus']; ?></option>
            <?php
			if($row_DetalleProducto['estatus']=='ACTIVO')
			{
				?>
                <option value="INACTIVO">INACTIVO</option>
                <option value="DIGITAL">DIGITAL</option>
                <?php
			}
			if($row_DetalleProducto['estatus']=='INACTIVO')
			{
				?>
                <option value="ACTIVO">ACTIVO</option>
                <option value="DIGITAL">DIGITAL</option>
                <?php
			}
			if($row_DetalleProducto['estatus']=='DIGITAL')
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

  <div class="form-group">
    <label class="control-label col-sm-2" for="">Activar Firelink:</label>
    <div class="col-sm-10">
      
      <select class="form-control" id="" name="firelink">
        <option value="<?php echo $row_DetalleProducto['firelink']; ?>"><?php echo $row_DetalleProducto['firelink']; ?></option>
                <?php
                  if($row_DetalleProducto['firelink']=='Si')
                  {
                    ?>
                            <option value="No">No</option>
                            
                            <?php
                  }
                  else if($row_DetalleProducto['firelink']=='No')
                  {
                    ?>
                            <option value="Si">Si</option>
                            
                            <?php
                  }
                  else
                  {
                  
                ?>
                  <option value="No">No</option>
                  <option value="Si">Si</option>
                            
                            <?php
                  }
                 ?>
                
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label col-sm-2" for="">Activar player de Spotify en Firelink:</label>
    <div class="col-sm-10">
      
      <select class="form-control" id="" name="play">
        <option value="<?php echo $row_DetalleProducto['play']; ?>"><?php echo $row_DetalleProducto['play']; ?></option>
                <?php
                  if($row_DetalleProducto['play']=='Si')
                  {
                    ?>
                            <option value="No">No</option>
                            
                            <?php
                  }
                  else if($row_DetalleProducto['play']=='No')
                  {
                    ?>
                            <option value="Si">Si</option>
                            
                            <?php
                  }
                  else
                  {
                  
                ?>
                  <option value="No">No</option>
                  <option value="Si">Si</option>
                            
                            <?php
                  }
                 ?>
      </select>
    </div>
  </div>


  
  
   
  
  
    <input type="hidden" name="fecha_alta" value="<?php echo date("Y-m-d");  ?>" >
    <input type="hidden" name="hora_alta" value="<?php echo date("H:i:s");  ?>" >
    <input type="hidden" name="ruta_img" value="<?php echo $row_DetalleProducto['ruta_img']; ?>" >
    <input type="hidden" name="ruta_img_2" value="<?php echo $row_DetalleProducto['ruta_img_2']; ?>" >
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

mysql_free_result($Generos);

mysql_free_result($Categoria);

mysql_free_result($UpdateProducto);

mysql_free_result($GenerosSelect);

mysql_free_result($DetalleProducto);
?>
