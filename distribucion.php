<?php require_once('Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  #$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

/*=============================== INICIO DE LANZAMIENTOS ===========================*/
mysqli_select_db($conexion, $database_conexion);
$query_lanzamientos = "SELECT
productos.id,
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
lanzamientos.id_producto

FROM
productos
INNER JOIN lanzamientos ON productos.id = lanzamientos.id_producto

WHERE productos.prendido=1
ORDER BY RAND()";
$lanzamientos = mysqli_query($conexion, $query_lanzamientos) or die(mysqli_error($conexion));
$row_lanzamientos = mysqli_fetch_assoc($lanzamientos);
$totalRows_lanzamientos = mysqli_num_rows($lanzamientos);
/*=============================== FIN DE LANZAMIENTOS ===========================*/


/*=============================== INICIO DE NOVEDADES ===========================*/
mysqli_select_db($conexion, $database_conexion);
$query_novedades = "SELECT
productos.id,
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
novedades.id_producto

FROM
productos
INNER JOIN novedades ON productos.id = novedades.id_producto

WHERE productos.prendido=1
ORDER BY RAND()";
$novedades = mysqli_query($conexion, $query_novedades) or die(mysqli_error($conexion));
$row_novedades = mysqli_fetch_assoc($novedades);
$totalRows_novedades = mysqli_num_rows($novedades);
/*=============================== FIN DE NOVEDADES ===========================*/

/*=============================== INICIO DE DISCO DE LA SEMANA ===========================*/
mysqli_select_db($conexion, $database_conexion);
$query_disco_semana = "SELECT
productos.id,
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
d_semana.id_producto

FROM
productos
INNER JOIN d_semana ON productos.id = d_semana.id_producto

WHERE productos.prendido=1
ORDER BY RAND()";
$disco_semana = mysqli_query($conexion,$query_disco_semana) or die(mysqli_error($conexion));
$row_disco_semana = mysqli_fetch_assoc($disco_semana);
$totalRows_disco_semana = mysqli_num_rows($disco_semana);
/*=============================== FIN DE DISCO DE LA SEMANA ===========================*/

/*=============================== INICIO DE EN DETALLE ===========================*/
mysqli_select_db($conexion, $database_conexion);
$query_endetalle = "SELECT
productos.id,
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
en_detalle.id_producto

FROM
productos
INNER JOIN en_detalle ON productos.id = en_detalle.id_producto

WHERE productos.prendido=1
ORDER BY RAND()";
$endetalle = mysqli_query($conexion,$query_endetalle) or die(mysqli_error($conexion));
$row_endetalle = mysqli_fetch_assoc($endetalle);
$totalRows_endetalle = mysqli_num_rows($endetalle);
/*=============================== FIN DE EN DETALLE ===========================*/


?>
 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fonarte es uno de los sellos l&iacute;deres independientes de distribuci&oacute;n f&iacute;sica y digital, as&iacute; como uno de los referentes de la m&uacute;sica independiente de M&eacute;xico.">
    <meta name="author" content="">

    <title>Fonarte Latino | Home</title>
  
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

        <?php include("./Plantillas/Fonarte-free-charity-website-template/index.html"); ?>
       
        
    
    <?php include("pie.php"); ?>
      


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
<?php
mysql_free_result($lanzamientos);
?>

