<?php require_once('Connections/conexion.php'); ?>
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

/*=============================== INICIO DE LANZAMIENTOS ===========================*/
mysql_select_db($database_conexion, $conexion);
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
$lanzamientos = mysql_query($query_lanzamientos, $conexion) or die(mysql_error());
$row_lanzamientos = mysql_fetch_assoc($lanzamientos);
$totalRows_lanzamientos = mysql_num_rows($lanzamientos);
/*=============================== FIN DE LANZAMIENTOS ===========================*/


/*=============================== INICIO DE NOVEDADES ===========================*/
mysql_select_db($database_conexion, $conexion);
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
$novedades = mysql_query($query_novedades, $conexion) or die(mysql_error());
$row_novedades = mysql_fetch_assoc($novedades);
$totalRows_novedades = mysql_num_rows($novedades);
/*=============================== FIN DE NOVEDADES ===========================*/

/*=============================== INICIO DE DISCO DE LA SEMANA ===========================*/
mysql_select_db($database_conexion, $conexion);
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
$disco_semana = mysql_query($query_disco_semana, $conexion) or die(mysql_error());
$row_disco_semana = mysql_fetch_assoc($disco_semana);
$totalRows_disco_semana = mysql_num_rows($disco_semana);
/*=============================== FIN DE DISCO DE LA SEMANA ===========================*/

/*=============================== INICIO DE EN DETALLE ===========================*/
mysql_select_db($database_conexion, $conexion);
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
$endetalle = mysql_query($query_endetalle, $conexion) or die(mysql_error());
$row_endetalle = mysql_fetch_assoc($endetalle);
$totalRows_endetalle = mysql_num_rows($endetalle);
/*=============================== FIN DE EN DETALLE ===========================*/


?>
 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
    <meta charset="ISO-8859-1" />
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
       
        <div class="row franja" >
            <!--div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Home<small>&nbsp;</small></p>
                </div>
            </div-->
        </div>
       
        <!-- Fin de titulo de la pagina -->
        
        
        
        <!-- =============================== inicio de slider =================================== -->   
        <br><br><br>
   
<div id="myCarousel" class="carousel slide" data-ride="carousel">
<!-- Indicators -->
<!--ol class="carousel-indicators">
<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
<li data-target="#myCarousel" data-slide-to="1"></li>
<li data-target="#myCarousel" data-slide-to="2"></li>

</ol-->

<!-- Wrapper for slides -->
<div class="carousel-inner" role="listbox">


<div class="item active">
<img src="img/slider/banner_logos.jpg" width="100%" alt="slider-1">
</div>


<!--div class="item">
<a href="https://www.fonartelatino.com/generos.php?genero=15"><img src="img/slider/banner_fusion.jpg" width="100%" alt="slider-1"></a>
</div-->



</div>

<!-- Left and right controls -->
<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
<span class="sr-only">Previous</span>
</a>
<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
<span class="sr-only">Next</span>
</a>
</div>
   <!-- =============================== fin de slider =================================== -->    
        
        

<div class="container">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
 
 
 <!-- ====================== inicio de botones ====================== -->              
<div class="container size_contenedor_botones">
<center>
<div class="row">

<div class="col-sm-4" style="text-align:center;"><a href="catalogo.php?categoria=2"><img src="img/Colecciones.png"  alt="Colecciones" class="size_botones_index"></a></div>
<div class="col-sm-4"  ><a href="catalogo.php?categoria=1"><img src="img/Discos_DVD.png" alt="Discos_DVD" class="size_botones_index"></a></div>
<div class="col-sm-4"  style="text-align:center;"><a href="catalogo.php?categoria=3"><img src="img/Vinil.png" alt="Vinil" class="size_botones_index"></a></div>
</div>
</center>
</div>  
   <!-- ====================== fin de botones ====================== -->  
   
   
   
   
   
 <!-- =========================== inicio de muestra lanzamientos =========================== -->   
 
 <p class="subtitulo_carrusel_index subtitulo_lanzamientos">LANZAMIENTOS</p> 
<div class="carrusel_index" >
<?php
do
{
?>


<div class="img-portfolio"  style="display:inline-block !important; width:160px;">

	<!-- muesta la imagen -->
    <?php
    //si no tiene imagen le asigna una de base
    if($row_lanzamientos['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_lanzamientos['ruta_img']; }
    ?>
    <?php

	
	//inicio de genera URL SEO

	$url=$row_lanzamientos['artista']."-".$row_lanzamientos['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO
	
	
	?>
    <a href="<?php echo $ruta_absoluta ?>producto_detalle/<?php echo $row_lanzamientos['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>" style="width:165px !important; height:165px !important;"  alt="" ></a>
    
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_lanzamientos['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_lanzamientos['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>

<?php	
}while($row_lanzamientos = mysql_fetch_assoc($lanzamientos));
?>
</div>

 <!-- =========================== fin de muestra lanzamientos =========================== --> 
 
 
 
 
  <!-- =========================== inicio de muestra novedades =========================== -->   
 <p class="subtitulo_carrusel_index subtitulo_novedades">NOVEDADES</p> 
<div class="carrusel_index" >
<?php
do
{
?>


<div class="img-portfolio"  style="display:inline-block !important; width:160px;">
    <!-- muesta la imagen -->
    <?php
    //si no tiene imagen le asigna una de base
    if($row_novedades['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_novedades['ruta_img']; }
    ?>
   <?php

	
	//inicio de genera URL SEO

	$url=$row_novedades['artista']."-".$row_novedades['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO
	?>
    <a href="<?php echo $ruta_absoluta ?>producto_detalle/<?php echo $row_novedades['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>" style="width:165px !important; height:165px !important;"  alt="" ></a>
    
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_novedades['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_novedades['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>

<?php	
}while($row_novedades = mysql_fetch_assoc($novedades));
?>
</div>

 <!-- =========================== fin de muestra novedades =========================== --> 
 
 
 

 
 
 
 
  <!-- =========================== inicio de DISCO DE LA SEMANA =========================== -->   
 
 <p class="subtitulo_carrusel_index subtitulo_discoDeLaSemana">DISCO DE LA SEMANA</p> 
<div class="carrusel_index" >
<?php
do
{
?>


<div class="img-portfolio"  style="display:inline-block !important; width:160px;">
<!-- muesta la imagen -->
    <?php
    //si no tiene imagen le asigna una de base
    if($row_disco_semana['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_disco_semana['ruta_img']; }
    ?>
    <?php
	
	//inicio de genera URL SEO

	$url=$row_disco_semana['artista']."-".$row_disco_semana['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO
	?>
    <a href="<?php echo $ruta_absoluta ?>producto_detalle/<?php echo $row_disco_semana['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>" style="width:165px !important; height:165px !important;"  alt="" ></a>
    
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_disco_semana['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_disco_semana['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>

<?php	
}while($row_disco_semana = mysql_fetch_assoc($disco_semana))
?>
</div>

 <!-- =========================== fin de muestra DISCO DE LA SEMANA =========================== --> 
 
 
   <!-- =========================== inicio de DISCO DE LA SEMANA =========================== -->   
 
 <p class="subtitulo_carrusel_index subtitulo_enDetalle" style="text-transform:uppercase">EN DETALLE <?php echo utf8_encode($row_endetalle['artista']); ?></p> 
<div class="carrusel_index" >
<?php
do
{
?>


<div class="img-portfolio"  style="display:inline-block !important; width:160px;">
    <!-- muesta la imagen -->
    <?php
    //si no tiene imagen le asigna una de base
    if($row_endetalle['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_endetalle['ruta_img']; }
    ?>
   <?php  

	//inicio de genera URL SEO 

	$url=$row_endetalle['artista']."-".$row_endetalle['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO
	
	?>
    <a href="<?php echo $ruta_absoluta ?>producto_detalle/<?php echo $row_endetalle['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>" style="width:165px !important; height:165px !important;"  alt="" ></a>
    
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_endetalle['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_endetalle['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>

<?php	
}while($row_endetalle = mysql_fetch_assoc($endetalle));
?>
</div>

 <!-- =========================== fin de muestra DISCO DE LA SEMANA =========================== --> 
 
 
 <!-- ======================== inicio de pinta cuadros de redes sociales ======================== -->
 

 <div class="row home-socialMediaDiv">
   <!-- ======================== inicio de pinta facebook ======================== -->
 <center>
  <div class="col-sm-6">
  <br><span style="color:#244e58;" class="fa fa-facebook fa-2x"></span><br>

<script>
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="fb-like-box" data-href="https://www.facebook.com/Fonarte" data-width="250" data-height="250" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>

  
  </div>
</center>
<!-- ======================== fin de pinta facebook ======================== -->


<!-- ======================== inicio de pinta twitter ======================== -->
<center>
  <div class="col-sm-6">
  <br><span style="color:#244e58;"  class="fa fa-twitter fa-2x"></span><br>
   
</style>
<script>!function(d,s,id){
var js, fjs=d.getElementsByTagName(s)[0],
p=/^http:/.test(d.location)?'http':'https';
if(!d.getElementById(id)){
js=d.createElement(s);
js.id=id;
js.src=p+"://platform.twitter.com/widgets.js";
fjs.parentNode.insertBefore(js,fjs);
}
}(document,"script","twitter-wjs");
</script>
<a class="twitter-timeline" data-width="250" data-height="250" href="https://twitter.com/Fonarte" data-widget-id="441648121303425024">Tweets por @Fonarte</a>
</div>

  </div>
</center>
 <!-- ======================== fin de pinta twitter ======================== -->
 

</div>
 
 <!-- ======================== fin de pinta cuadros de redes sociales ======================== -->

 

 
 
   
               
               
               
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
mysql_free_result($lanzamientos);
?>

