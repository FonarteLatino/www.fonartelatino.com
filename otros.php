<?php require_once('Connections/conexion.php'); ?>
<?php



include_once("zebra_pagination/Zebra_Pagination.php");

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

// paso 1/7 generas query
mysql_select_db($database_conexion, $conexion);
$query_QueryPaginacion = "SELECT * FROM productos_otros where prendido=1";
$QueryPaginacion = mysql_query($query_QueryPaginacion, $conexion) or die(mysql_error());
$row_QueryPaginacion = mysql_fetch_assoc($QueryPaginacion);
$totalRows_QueryPaginacion = mysql_num_rows($QueryPaginacion);
// paso 2/7 asignas cuatos resultados se veran por pagina
$resultados=12;
//paso 3/7 creamos una instancia del objeto Zebra_Pagination
$paginacion= new Zebra_Pagination();
//paso 4/7 asignamos cuantos registros totales existen
$paginacion->records($totalRows_QueryPaginacion);
//paso 5/7 asignamos la variale del paso 2 para decirle cuantos registros por pagina
$paginacion->records_per_page($resultados);
$inicio=(($paginacion->get_page()-1)*$resultados);
$fin=$resultados;


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
INNER JOIN cat_otros ON productos_otros.tipo = cat_otros.id
INNER JOIN precios ON productos_otros.clave_precio = precios.clave

where productos_otros.prendido=1 limit ".$inicio.",".$fin;
$Otros = mysql_query($query_Otros, $conexion) or die(mysql_error());
$row_Otros = mysql_fetch_assoc($Otros);
$totalRows_Otros = mysql_num_rows($Otros);
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

    <title>Merchandisign | Fonarte Latino </title>
  
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
                    <p class="page-header">Merchandising<small>&nbsp;</small></p>
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




<!-- =========================== inicio de muestra catalogo =========================== -->  
<h4 class="tipografia2">Resultados: <?php echo $totalRows_QueryPaginacion; ?></h4>

<div class="row">
<?php
do
{
?>


<div class="col-md-2 img-portfolio" style="min-height:230px;">
	<!-- muesta la imagen -->
	<?php
    //si no tiene imagen le asigna una de base
	
    if($row_Otros['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_Otros['ruta_img']; }
    ?> 
    
    <?php
	//inicio de genera URL SEO
	$artista=strtolower($row_Otros['artista']);//convierte la cadena en minusculas
	$album=strtolower($row_Otros['nombre']);//convierte la cadena en minusculas
	$url=$artista."-".$album;//une las dos con un guion medio
	$quita_esp=str_replace(" ","_",$url);//remplaza espacios por guion bajo
	$quita_a_acento=str_replace("á","a",$quita_esp);//remplaza á por a
	$quita_e_acento=str_replace("é","e",$quita_a_acento);//remplaza é por e
	$quita_i_acento=str_replace("í","i",$quita_e_acento);//remplaza í por i
	$quita_o_acento=str_replace("ó","o",$quita_i_acento);//remplaza ó por o
	$quita_u_acento=str_replace("ú","u",$quita_o_acento);//remplaza ú por u
	$quita_n_acento=str_replace("ñ","n",$quita_u_acento);//remplaza ñ por n

	$url_seo_final=$quita_n_acento;//url final
	//fin de genera URL SEO
	?>
    
    <a href="producto_detalle_otro/<?php echo $row_Otros['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>"   alt="" ></a>

    	
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_Otros['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_Otros['nombre'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>


<?php	
}while($row_Otros = mysql_fetch_assoc($Otros));

?>
</div>

 <!-- =========================== fin de muestra catalogo =========================== -->

 <center> 
<?php 
// paso 7/7 con la siguiente funcion, genera la paginacion abajo de la tabla
$paginacion->render(); 
?>
</center>

               
               
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
mysql_free_result($QueryPaginacion);

mysql_free_result($Otros);
?>
