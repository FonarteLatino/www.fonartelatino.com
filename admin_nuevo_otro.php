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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


mysqli_select_db($conexion,$database_conexion);
$query_Precios = "SELECT * FROM precios order by clave ASC";
$Precios = mysqli_query($conexion,$query_Precios) or die(mysqli_error($conexion));
$row_Precios = mysqli_fetch_assoc($Precios);
$totalRows_Precios = mysqli_num_rows($Precios);

mysqli_select_db($conexion,$database_conexion);
$query_Generos = "SELECT * FROM genero order by nombre ASC";
$Generos = mysqli_query($conexion,$query_Generos) or die(mysqli_error($conexion));
$row_Generos = mysqli_fetch_assoc($Generos);
$totalRows_Generos = mysqli_num_rows($Generos);

mysqli_select_db($conexion,$database_conexion);
$query_Categoria = "SELECT * FROM categoria where id=4  order by nombre ASC";
$Categoria = mysqli_query($conexion,$query_Categoria) or die(mysqli_error($conexion));
$row_Categoria = mysqli_fetch_assoc($Categoria);
$totalRows_Categoria = mysqli_num_rows($Categoria);

mysqli_select_db($conexion,$database_conexion);
$query_Artistas = "SELECT DISTINCT(artista) FROM productos order by artista ASC";
$Artistas = mysqli_query($conexion,$query_Artistas) or die(mysqli_error($conexion));
$row_Artistas = mysqli_fetch_assoc($Artistas);
$totalRows_Artistas = mysqli_num_rows($Artistas);

mysqli_select_db($conexion,$database_conexion);
$query_ProductosOtros = "SELECT * FROM cat_otros order by nombre ASC";
$ProductosOtros = mysqli_query($conexion,$query_ProductosOtros) or die(mysqli_error($conexion));
$row_ProductosOtros = mysqli_fetch_assoc($ProductosOtros);
$totalRows_ProductosOtros = mysqli_num_rows($ProductosOtros);


if(isset($_POST['inserta']) and ($_POST['inserta']==1))
{
	
	//print_r($_POST);
	
	
	
	/******************************* valida imagen de portada */
	if($_FILES['ruta_img']['name']==''){ $ruta_img='img/caratula/muestra.jpg'; }
	else{
		include_once("sube_foto_portada.php");
		$ruta_img="img/caratulas/".$nuevo_nombre_ruta_img;//esta variable viene del archivo sube_foto_portada.php
	}
	/******************************* valida imagen secundaria*/
	if($_FILES['ruta_img_2']['name']==''){ $ruta_img_2='img/caratula/muestra.jpg'; }
	/* si agrego imagen secundaria, se la asigna a la variable*/
	else{
		include_once("sube_foto_secundaria.php");
		$ruta_img_2="img/caratulas/".$nuevo_nombre_ruta_img_2;//esta variable viene del archivo sube_foto_secundaria.php
	}
	/******************************* valida artista */
	if($_POST['artista']=='otro'){ $artista=$_POST['artista2']; }
	else{ $artista=$_POST['artista']; }
	
	/******************************* genero2  */
	if(isset($_POST['s']))
	{ 
		$s=$_POST['s']; 
	}
	else
	{ 
		$s=0; 
	}
	if(isset($_POST['m']))
	{ 
		$m=$_POST['m']; 
	}
	else
	{ 
		$m=0; 
	}
	if(isset($_POST['l']))
	{ 
		$l=$_POST['l']; 
	}
	else
	{ 
		$l=0; 
	}
	
	$sku=$_POST['sku'];
	$id_fonarte=$_POST['id_fonarte'];
	$clave_precio=$_POST['clave_precio'];
	$artista;
	$tipo=$_POST['select_tipo'];
	$ruta_img;
	$ruta_img_2;	
	$descripcion=$_POST['descripcion'];
	$fecha_alta=$_POST['fecha_alta'];
	$hora_alta=$_POST['hora_alta'];
	$prendido=$_POST['prendido'];
	$estatus=$_POST['estatus'];

	$insertSQL = sprintf("INSERT INTO productos_otros (sku, id_fonarte, clave_precio, artista, tipo, s, m, l, ruta_img, ruta_img_2, descripcion, fecha_alta, hora_alta, prendido, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString($sku, "text"),
	GetSQLValueString($id_fonarte, "text"),
	GetSQLValueString($clave_precio, "text"),
	GetSQLValueString(utf8_decode($artista), "text"),
	GetSQLValueString($tipo, "int"),
	GetSQLValueString($s, "int"),
	GetSQLValueString($m, "int"),
	GetSQLValueString($l, "int"),
	GetSQLValueString($ruta_img, "text"),
	GetSQLValueString($ruta_img_2, "text"),
	GetSQLValueString(utf8_decode($descripcion), "text"),
	GetSQLValueString($fecha_alta, "date"),
	GetSQLValueString($hora_alta, "date"),
	GetSQLValueString($prendido, "int"),
	GetSQLValueString($estatus, "text"));
	
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));

	?><script type="text/javascript">window.location="admin_nuevo_otro.php?alerta=5";</script><?php
	
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
                    <small><?php echo $row_Categoria['nombre']; ?></small>
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
	<!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">SKU:</label>
    <div class="col-sm-4">
    <input type="text" name="sku" class="form-control" id="" value=""  required>
    </div>
    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Id Interno:</label>
    <div class="col-sm-4">
    <input type="text" name="id_fonarte" class="form-control" id="" value=""  required>
    </div>
   
</div>


<div class="form-group">
 <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Clave Precio:</label>
    <div class="col-sm-4">
    <select class="form-control"  name="clave_precio" id="sel1">
    <?php
    do {  
    ?>
    <option value="<?php echo $row_Precios['clave']?>"><?php echo $row_Precios['clave']." - $".$row_Precios['precio'].".00"; ?></option>
    <?php
    } while ($row_Precios = mysqli_fetch_assoc($Precios));
    $rows = mysqli_num_rows($Precios);
    if($rows > 0) {
    mysqli_data_seek($Precios, 0);
    $row_Precios = mysqli_fetch_assoc($Precios);
    }
    ?>
    </select>
    </div>
	<!-- *********************************************** -->
    <label class="control-label col-sm-2" for="" >Categor&iacute;a:</label>
    <div class="col-sm-4">
    
    <select class="form-control" id="id_categoria" name="categoria" >
    <?php
    do {  
    ?><option value="<?php echo $row_Categoria['id']?>"><?php echo $row_Categoria['nombre']?></option><?php
    } while ($row_Categoria = mysqli_fetch_assoc($Categoria));
    $rows = mysqli_num_rows($Categoria);
    if($rows > 0) 
    {
    mysqli_data_seek($Categoria, 0);
    $row_Categoria = mysqli_fetch_assoc($Categoria);
    }
    ?>
    </select>
    </div>

   
</div>
        


 
  

   
<div class="form-group">
  <!-- *********************************************** -->
  <script type="text/javascript" src="jquery.js"></script>   
        
    <!--  INICIO PARTE 2   -->
    <script type="text/javascript">
    $(document).ready(function()
    {
    $('#id_artista').change(function()
    {
    var artista=$('#id_artista').val(); //declaramos las variables que vamos a mandar al siguiente php
    
    $('#variable1').load('js_nombre_artista.php?artista='+artista);//enviamos las 2 variables
    });    
    });
    </script>
    <!--    FIN PARTE 2   -->   
    
    <label class="control-label col-sm-2" for="">Artista:</label>
    <div class="col-sm-4">
    <select class="form-control" id="id_artista" name="artista" required >
    <option value=""></option>
    <option value="otro">Otro</option>
    <?php
    do {  
    ?>
    <option value="<?php echo utf8_encode($row_Artistas['artista']); ?>"><?php echo utf8_encode($row_Artistas['artista']); ?></option>
    <?php
    } while ($row_Artistas = mysqli_fetch_assoc($Artistas));
    $rows = mysqli_num_rows($Artistas);
    if($rows > 0) {
    mysqli_data_seek($Artistas, 0);
    $row_Artistas = mysqli_fetch_assoc($Artistas);
    }
    ?>
    </select>
    </div>
    
    
    <div id="variable1"> 
    </div>
    
</div>




<div class="form-group">
  <!-- *********************************************** -->
  <script type="text/javascript" src="jquery.js"></script>   
        
    <!--  INICIO PARTE 2   -->
    <script type="text/javascript">
    $(document).ready(function()
    {
    $('#id_select_tipo').change(function()
    {
    var select_tipo=$('#id_select_tipo').val(); //declaramos las variables que vamos a mandar al siguiente php
    
    $('#variable2').load('js_tipo_otro.php?select_tipo='+select_tipo);//enviamos las 2 variables
    });    
    });
    </script>
    <!--    FIN PARTE 2   -->   
    
    <label class="control-label col-sm-2" for="">Tipo:</label>
    <div class="col-sm-4">
    <select class="form-control" id="id_select_tipo" name="select_tipo" required >
      <option value=""></option>
		<?php
        do {  
        ?>
        <option value="<?php echo $row_ProductosOtros['id']?>"><?php echo $row_ProductosOtros['nombre']?></option>
        <?php
        } while ($row_ProductosOtros = mysqli_fetch_assoc($ProductosOtros));
        $rows = mysqli_num_rows($ProductosOtros);
        if($rows > 0) {
        mysqli_data_seek($ProductosOtros, 0);
        $row_ProductosOtros = mysqli_fetch_assoc($ProductosOtros);
        }
        ?>
    </select>
    </div>
    
    
    <div id="variable2"> 
    </div>
    
</div>


   

  <div class="form-group">
<!-- *********************************************** -->
     <label class="control-label col-sm-2" for="">Imagen de Portada:</label>
    <div class="col-sm-4">
      <input type="file" name="ruta_img" class="form-control" id="id_ruta_img" value="" >
    </div>
    <!-- *********************************************** -->
   <label class="control-label col-sm-2" for="">Imagen Secundaria:</label>
    <div class="col-sm-4">
      <input type="file" name="ruta_img_2" class="form-control" id="id_ruta_img_2" value="" >
    </div>
   

</div>



  <div class="form-group">

    <!-- *********************************************** -->
    <label class="control-label col-sm-2" for="">Descripci&oacute;n:</label>
    <div class="col-sm-4">
    <textarea class="form-control" rows="3" id="comment" name="descripcion" ></textarea>
    </div>
    
    <label class="control-label col-sm-2" for="">Estatus:</label>
    <div class="col-sm-4">
        <select class="form-control" id="" name="estatus">
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
            <option value="DIGITAL">DIGITAL</option>
        </select>
    </div>
    
    
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
mysqli_free_result($Precios);

mysqli_free_result($Generos);

mysqli_free_result($Categoria);

mysqli_free_result($Artistas);

mysqli_free_result($ProductosOtros);
?>
