<?php require_once('Connections/conexion.php'); ?>
<?php
include_once("zebra_pagination/Zebra_Pagination.php");
include_once("rutas_absolutas.php");

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

mysqli_select_db($conexion,$database_conexion);
$query_Genero = "SELECT * FROM genero where id=".$_GET['genero'];
$Genero = mysqli_query($conexion,$query_Genero) or die(mysqli_error($conexion));
$row_Genero = mysqli_fetch_assoc($Genero);
$totalRows_Genero = mysqli_num_rows($Genero);



// paso 1/7 generas query
mysqli_select_db($conexion,$database_conexion);
$query_ProductosPagination = "SELECT * FROM productos where genero=".$_GET['genero'];
$ProductosPagination = mysqli_query($conexion,$query_ProductosPagination) or die(mysqli_error($conexion));
$row_ProductosPagination = mysqli_fetch_assoc($ProductosPagination);
$totalRows_ProductosPagination = mysqli_num_rows($ProductosPagination);
// paso 2/7 asignas cuatos resultados se veran por pagina
$resultados=30;
//paso 3/7 creamos una instancia del objeto Zebra_Pagination
$paginacion= new Zebra_Pagination();
//paso 4/7 asignamos cuantos registros totales existen
$paginacion->records($totalRows_ProductosPagination);
//paso 5/7 asignamos la variale del paso 2 para decirle cuantos registros por pagina
$paginacion->records_per_page($resultados);
$inicio=(($paginacion->get_page()-1)*$resultados);
$fin=$resultados;
		
		
mysqli_select_db($conexion,$database_conexion);
$query_ProductosPorGeneros = "SELECT
productos.id,
productos.sku,
productos.id_fonarte,
productos.artista,
productos.album,
productos.genero,
genero.nombre as gen_nombre,
productos.categoria,
categoria.nombre as cat_nombre,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.ruta_img,
productos.clave_precio,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
productos.prendido
FROM
productos
INNER JOIN categoria ON categoria.id = productos.categoria
INNER JOIN genero ON genero.id = productos.genero
WHERE productos.prendido=1
AND productos.genero=".$_GET['genero']."  order by productos.artista
limit ".$inicio.",".$fin;
$ProductosPorGeneros = mysqli_query($conexion,$query_ProductosPorGeneros) or die(mysqli_error($conexion));
$row_ProductosPorGeneros = mysqli_fetch_assoc($ProductosPorGeneros);
$totalRows_ProductosPorGeneros = mysqli_num_rows($ProductosPorGeneros);



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

    <title>Fonarte Latino | G&eacute;neros</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $ruta_absoluta; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $ruta_absoluta; ?>css/modern-business.css" rel="stylesheet">

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
                    <p class="page-header"><?php echo utf8_encode($row_Genero['nombre']); ?><small>&nbsp;</small></p>
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
               
               
<?php
if($totalRows_ProductosPorGeneros==0)//no existen resultados
{
   ?><h4 class="tipografia2">No se encontraron resultados de "<?php echo utf8_encode($row_Genero['nombre']); ?>"</h4><br><br><br><br><br><br><br><?php
}
else//si existen resultados
{
?>


<!-- =========================== inicio de muestra catalogo =========================== -->    
<h4 class="tipografia2">Resultados: <?php echo $totalRows_ProductosPagination; ?></h4>
<div class="row">
<?php
do
{
?>


<div class="col-md-2 img-portfolio" style="min-height:230px;">
	<!-- muesta la imagen -->
	<?php
    //si no tiene imagen le asigna una de base
	
    if($row_ProductosPorGeneros['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_ProductosPorGeneros['ruta_img']; }
    ?> 

    <?php
	//inicio de genera URL SEO
	$artista=strtolower($row_ProductosPorGeneros['artista']);//convierte la cadena en minusculas
	$album=strtolower($row_ProductosPorGeneros['album']);//convierte la cadena en minusculas
	$url=utf8_encode($artista)."-".utf8_encode($album);//une las dos con un guion medio
	$quita_esp=str_replace(" ","_",$url);//remplaza espacios por guion bajo
	$sustituye1=str_replace("á","a",$quita_esp);//remplaza á por a
	$sustituye2=str_replace("é","e",$sustituye1);//remplaza é por e
	$sustituye3=str_replace("í","i",$sustituye2);//remplaza í por i
	$sustituye4=str_replace("ó","o",$sustituye3);//remplaza ó por o
	$sustituye5=str_replace("ú","u",$sustituye4);//remplaza ú por u
	$sustituye6=str_replace("Á","A",$sustituye5);//remplaza Á por A
	$sustituye7=str_replace("É","E",$sustituye6);//remplaza É por E
	$sustituye8=str_replace("Í","I",$sustituye7);//remplaza Í por I
	$sustituye9=str_replace("Ó","O",$sustituye8);//remplaza Ó por O
	$sustituye10=str_replace("Ú","U",$sustituye9);//remplaza Ú por U
	$sustituye11=str_replace("ñ","n",$sustituye10);//remplaza ñ por n
	$sustituye11=str_replace("Ñ","N",$sustituye10);//remplaza Ñ por N
	$sustituye12=str_replace(",","",$sustituye11);//remplaza , por nada
	$sustituye13=str_replace(".","",$sustituye12);//remplaza . por nada
	$sustituye14=str_replace("(","",$sustituye13);//remplaza ( por nada
	$sustituye15=str_replace(")","",$sustituye14);//remplaza ) por nada
	$url_seo_final=$sustituye15;//url final
	//fin de genera URL SEO
	?>
    <a href="producto_detalle/<?php echo $row_ProductosPorGeneros['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_absoluta ?><?php echo $ruta_caratula; ?>"   alt="" ></a>

    	
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_ProductosPorGeneros['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_ProductosPorGeneros['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>


<?php	
}while($row_ProductosPorGeneros = mysqli_fetch_assoc($ProductosPorGeneros));

?>
	
</div>

 <!-- =========================== fin de muestra catalogo =========================== -->  
 <center> 
<?php 
// paso 7/7 con la siguiente funcion, genera la paginacion abajo de la tabla
$paginacion->render(); 
?>
</center>

<?php   
}
?>

 
               
               
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
mysqli_free_result($Genero);

mysqli_free_result($ProductosPorGeneros);
?>
