<?php require_once('Connections/conexion.php'); ?>
<?php

include_once("rutas_absolutas.php");

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







$a=utf8_decode($_GET['artista']);
//$a='cañ';


mysqli_select_db($conexion,$database_conexion);
$query_DetalleProducto = "SELECT
productos.id as id_producto,
productos.sku,
productos.id_fonarte,
productos.artista,
productos.album,
productos.genero,
genero.nombre AS gen_nombre,
productos.categoria,
categoria.nombre AS cat_nombre,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.ruta_img,
productos.ruta_img_2,
productos.descripcion,
productos.clave_precio,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
productos.prendido,
precios.precio,
precios.id
FROM
productos
INNER JOIN categoria ON categoria.id = productos.categoria
INNER JOIN genero ON genero.id = productos.genero
INNER JOIN precios ON precios.clave = productos.clave_precio 
WHERE productos.prendido and  (productos. `artista` LIKE '%".$a."%' or productos. album LIKE '%".$a."%' ) order by productos.artista ASC";
$DetalleProducto = mysqli_query($conexion,$query_DetalleProducto) or die(mysqli_error($conexion));
$row_DetalleProducto = mysqli_fetch_assoc($DetalleProducto);
$totalRows_DetalleProducto = mysqli_num_rows($DetalleProducto);



mysqli_select_db($conexion,$database_conexion);
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
where productos_otros.prendido=1 and productos_otros.artista like '%".$a."%' order by productos_otros.artista ASC";
$Otros = mysqli_query($conexion,$query_Otros) or die(mysqli_error($conexion));
$row_Otros = mysqli_fetch_assoc($Otros);
$totalRows_Otros = mysqli_num_rows($Otros);

?>
 <?php include("alertas.php"); ?>
<!DOCTYPE html>  
<html lang="en">

<head>

    <!--meta charset="ISO-8859-1" /-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $_GET['artista']; ?> | Fonarte Latino </title>
  
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
                
                    <p class="page-header"><?php echo $_GET['artista']; ?><small></small></p>
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
		  if($totalRows_DetalleProducto==0)//no encontro resultados
		  {
			  ?><h5 class="tipografia2">No se encontraron resultados de discos </h5><?php
		  }
		  else//si encontro resultados
		  {
			?>
            
<!-- =========================== inicio de muestra catalogo =========================== -->  
<h4 class="tipografia2">Resultados de Discos: <?php echo $totalRows_DetalleProducto; ?></h4>

<div class="row">
<?php
do
{
?>


<div class="col-md-2 img-portfolio" style="min-height:230px;">
	<!-- muesta la imagen -->
	<?php
    //si no tiene imagen le asigna una de base
	
    if($row_DetalleProducto['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_DetalleProducto['ruta_img']; }
    ?> 
    

    <?php
	//inicio de genera URL SEO

	$url=$row_DetalleProducto['artista']."-".$row_DetalleProducto['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO

	?>
    
    <a href="producto_detalle/<?php echo $row_DetalleProducto['id_producto']; ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>"   alt="" ></a>

    	
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_DetalleProducto['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_DetalleProducto['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>


<?php	
}while($row_DetalleProducto = mysqli_fetch_assoc($DetalleProducto));

?>
</div>

 <!-- =========================== fin de muestra catalogo =========================== --> 
            <?php  
		  }
		  ?>
          
          
          
          
 <!-- ****************************************** RESULTADOS MERCHANDISING -->         

          <?php
		  if($totalRows_Otros==0)//no encontro resultados
		  {
			  ?><h5 class="tipografia2">No se encontraron resultados de resultados de merchandising </h5><?php
		  }
		  else//si encontro resultados
		  {
			?>
            
<!-- =========================== inicio de muestra catalogo =========================== -->  
<h4 class="tipografia2">Resultados de Merchandising: <?php echo $totalRows_Otros; ?></h4>

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
    
    <a href="producto_detalle_otro/<?php echo $row_Otros['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>"   alt="" ></a>

    	
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_Otros['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_Otros['nombre'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo $artista_2; ?></strong><br><?php echo $album_2; ?></p>
    
</div>


<?php	
}while($row_Otros = mysqli_fetch_assoc($Otros));

?>
</div>

 <!-- =========================== fin de muestra catalogo =========================== --> 



            
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
