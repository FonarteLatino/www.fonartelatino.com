<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); ?>
<?php

include_once("rutas_absolutas.php");


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
$id_producto=$_GET['id_producto'];







mysqli_select_db($conexion,$database_conexion);
$query_DetalleProducto = "SELECT
productos.id,
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
productos.amazon_mu,
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
productos.prendido,
precios.precio,
precios.id
FROM
productos
INNER JOIN categoria ON categoria.id = productos.categoria
INNER JOIN genero ON genero.id = productos.genero
INNER JOIN precios ON precios.clave = productos.clave_precio WHERE productos.id=".$id_producto;
/*$query_DetalleProducto = "SELECT
productos.id,
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
productos.prendido,
precios.precio,
precios.id
FROM
productos
INNER JOIN categoria ON categoria.id = productos.categoria
INNER JOIN genero ON genero.id = productos.genero
INNER JOIN precios ON precios.clave = productos.clave_precio WHERE productos.id=".$id_producto;*/
$DetalleProducto = mysqli_query($conexion,$query_DetalleProducto) or die(mysql_error());
$row_DetalleProducto = mysqli_fetch_assoc($DetalleProducto);
$totalRows_DetalleProducto = mysqli_num_rows($DetalleProducto);


/* ******************** inicio de te puede interesar *************************** */
mysqli_select_db($conexion,$database_conexion);
$query_TePuedeInteresar = "SELECT
productos.id as id_prod,
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
productos.amazon_mu,
productos.youtube,
productos.deezer,
productos.tidal,
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
WHERE productos.prendido=1 and productos.genero=".$row_DetalleProducto['genero']."
ORDER BY RAND()
limit 7";
/*$query_TePuedeInteresar = "SELECT
productos.id as id_prod,
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
productos.claro,
productos.youtube,
productos.deezer,
productos.tidal,
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
WHERE productos.prendido=1 and productos.genero=".$row_DetalleProducto['genero']."
ORDER BY RAND()
limit 7";*/
$TePuedeInteresar = mysqli_query($conexion,$query_TePuedeInteresar) or die(mysql_error());
$row_TePuedeInteresar = mysqli_fetch_assoc($TePuedeInteresar);
$totalRows_TePuedeInteresar = mysqli_num_rows($TePuedeInteresar);
/* ******************** fin de te puede interesar *************************** */


/* ******************** inicio de agrega al carrito *************************** */

if(isset($_GET['add_carrito']) and ($_GET['add_carrito']==1))
{

	if(isset($_SESSION['USUARIO_ECOMMERCE']))//si ya existe un usuario logueado se lo asigna a el 
	{
		$usuario_activo=$_SESSION['USUARIO_ECOMMERCE']['id'];	
	}
	else//no existe usuario logueado se lo asigna a la sesion temporal
	{
		$usuario_activo=$_SESSION['CARRITO_TEMP'];
	}
	$insertSQL = sprintf("INSERT INTO carrito (id_usr, id_producto, id_producto_fonarte, tipo, artista, album, precio, cantidad, fecha, hora) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString($usuario_activo, "int"),
	GetSQLValueString($_GET['id_producto'], "int"),
	GetSQLValueString($_GET['id_producto_fonarte'], "text"),
	GetSQLValueString('DISCOS', "text"),
	GetSQLValueString(utf8_decode($_GET['artista']), "text"),
	GetSQLValueString(utf8_decode($_GET['album']), "text"),
	GetSQLValueString($_GET['precio'], "int"),
	GetSQLValueString(1, "int"),
	GetSQLValueString(date("Y-m-d"), "date"),
	GetSQLValueString(date("H:i:d"), "date"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysql_error());
	
	$redirecciona="producto_detalle/".$_GET['id_producto']."/".$_GET['url_seo'];
	?><script type="text/javascript">window.location="<?php echo $redirecciona; ?>";</script><?php
	
	//header("Location: producto_detalle/".$_GET['id_producto']."/".$_GET['url_seo']);
	
	
}
/* ******************** fin de agrega al carrito *************************** */


?>
 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="es">

<head>
<link rel="icon" type="image/png" href="https://www.fonartelatino.com/img/favicon.png" />
	<?php //include_once("estilos_producto_detalle.php"); 
	
	?>  
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo utf8_encode($row_DetalleProducto['artista']); ?> | <?php echo utf8_encode($row_DetalleProducto['album']); ?> | Fonarte Latino</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $ruta_absoluta; ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo $ruta_absoluta; ?>css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo $ruta_absoluta; ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
                    <p class="page-header"><?php echo utf8_encode($row_DetalleProducto['artista']); ?><small> &nbsp;&nbsp; <?php echo utf8_encode($row_DetalleProducto['album']); ?></small></p>
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

//===============creamos una variable sesion temporal para asignarle los productos a alguien, la variable sesion se crea con el valor de horaminutosegundo
//SOLO SE CREA SI NO EXISTE
if(!isset($_SESSION['CARRITO_TEMP']))
{
	$_SESSION['CARRITO_TEMP']  = date("His"); 
}

?>               
               <!-- Projects Row -->
        <div class="row">
            <div class="col-md-6 img-portfolio">
                <!-- muesta la imagen -->
                <?php
                //si no tiene imagen le asigna una de base
                if($row_DetalleProducto['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
                else{ $ruta_caratula=$row_DetalleProducto['ruta_img']; }
                ?>
                 <center><img class="img-responsive  " src="<?php echo $ruta_absoluta; ?><?php echo $ruta_caratula; ?>" ></center>
                 <!-- ============== inicio de descripcion====================== -->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="tipografia2"><?php echo utf8_encode($row_DetalleProducto['album']); ?></h3>
                        <h4 class="tipografia2"><?php echo utf8_encode($row_DetalleProducto['artista']); ?></h4>
                    </div>
                    <div class="col-sm-6">
                    <?php
					if($row_DetalleProducto['estatus']=='ACTIVO')
					{
						?> <h3 class="tipografia2" style="text-align:right;"><?php echo "$".$row_DetalleProducto['precio'].".00"; ?></h3><?php
					}
					?>
                    	
                    </div>                
                </div>
                <!-- ============== fin de descripcion====================== -->
                
            </div>
            
            
            <div class="col-md-6 img-portfolio">
            	<?php //no tiene spotify pone la imagen secundaria
				if($row_DetalleProducto['spotify']=='')
				{
					?>
                    <center><img class="img-responsive  " src="<?php echo $ruta_absoluta; ?><?php echo $row_DetalleProducto['ruta_img_2']; ?>" ></center>
                    <?php
				}
				else
				{   
                    $saux="";
                    $ssaux="";

                    if (count(explode("?si=", $row_DetalleProducto['spotify'])) == 1) {
                        $a=explode("embed", $row_DetalleProducto['spotify']);
                        
                        if ((count($a[1])) == 0) {
                             
                            $b = str_replace("https://open.spotify.com", "https://open.spotify.com/embed", $row_DetalleProducto['spotify']);
                            echo "<center><iframe src=\"".$b."\" class=\"size_spoty\"  frameborder=\"0\" allowtransparency=\"true\"></iframe></center>";
                         } 
                         else
                         {
                            echo "<center><iframe src=\"".$row_DetalleProducto['spotify']."\" class=\"size_spoty\"  frameborder=\"0\" allowtransparency=\"true\"></iframe></center>";
                         }
                        
                    
					?>
                    
                    
                    <?php
                    }
                    else
                    {
                        $saux = explode("?si=", $row_DetalleProducto['spotify']);
                        if (count(explode("/album/", $row_DetalleProducto['spotify'])) == 1) {
                            $ssaux = explode("/track/", $saux[0]);
                            $ssaux[1] = "https://open.spotify.com/embed/track/".$ssaux[1];
                            echo "<div class=\"row\">
                                    <center><iframe src=\"".$ssaux[1]."\" class=\"size_spoty\"  frameborder=\"0\" allowtransparency=\"true\" ></iframe></center>
                                </div>";
                        }
                        else{
                            $ssaux = explode("/album/", $saux[0]);
                            $ssaux[1] = "https://open.spotify.com/embed/album/".$ssaux[1];
                            
                            echo "<div class=\"row\">
                                <center><iframe src=\"".$ssaux[1]."\" class=\"size_spoty\"  frameborder=\"0\" allowtransparency=\"true\" ></iframe></center>
                            </div>";
                                
                            
                            
                        }
                        
                    }
				}
				?>
            	
              

                <!-- ============== inicio de tiendas digitales escritorio====================== -->
                <div class="row digitales_escritorio" style="margin-top:5px;line-height: 34px;" >
                
                <?php  
					
					if($row_DetalleProducto['estatus']=='ACTIVO')//
					{
						
						//inicio de genera URL SEO

						$url=$row_DetalleProducto['artista']."-".$row_DetalleProducto['album'];//une las dos con un guion medio
						
						$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
						$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
						$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
						
						//fin de genera URL SEO

						
						?><div class="col-xs-6 col-sm-3"><center><button type="button" onClick="location.href='<?php echo $ruta_absoluta; ?>producto_detalle.php?add_carrito=1&id_producto=<?php echo $id_producto; ?>&url_seo=<?php echo $url_seo_final; ?>&artista=<?php echo utf8_encode($row_DetalleProducto['artista']); ?>&album=<?php echo utf8_encode($row_DetalleProducto['album']); ?>&precio=<?php echo $row_DetalleProducto['precio']; ?>&id_producto_fonarte=<?php echo $row_DetalleProducto['id_fonarte']; ?>'" class="tipografia2" style="width:100px; height:33px; margin-left: -14px; background-color:transparent; border:#ffffff;   font-size:11px;"><img src="<?php echo $ruta_absoluta; ?>img/carrito.jpeg" width="100" height="31" alt="carrito"></button></center></div> <?php
						
					}
					if($row_DetalleProducto['itunes']!='')//tiene link de itunes
					{
						?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['itunes'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/apple-mini.jpeg" width="100" height="31" alt="itunes"></a></center></div>
<?php
					}
					if($row_DetalleProducto['google']!='')//tiene link de google
					{
						?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['google'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/google-mini.jpeg" width="100" height="31" alt="google"></a></center></div>    <?php
					}
					if($row_DetalleProducto['amazon']!='')//tiene link de amazon
					{
						?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['amazon'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/amazon-mini.png" width="100" height="31" alt="amazon"></a></center></div><?php
					}
                    if($row_DetalleProducto['amazon_mu']!='')//tiene link de amazon
                    {
                        ?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['amazon_mu'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/amazon_mu-mini.png" width="100" height="31" alt="amazon_mu"></a></center></div>
                        <!--<div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['claro'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/claro-mini.jpeg" width="100" height="31" alt="claro"></a></center></div>--><?php
                    }
                    if($row_DetalleProducto['youtube']!='')//tiene link de amazon
                    {
                        ?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['youtube'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/you-mini.jpeg" width="100" height="31" alt="youtube"></a></center></div><?php
                    }
                    if($row_DetalleProducto['deezer']!='')//tiene link de amazon
                    {
                        ?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['deezer'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/deezer-mini.jpeg" width="100" height="31" alt="deezer"></a></center></div><?php
                    }
                    if($row_DetalleProducto['tidal']!='')//tiene link de amazon
                    {
                        ?><div class="col-xs-6 col-sm-3"><center><a href="<?php echo $row_DetalleProducto['tidal'] ?>" target="new"><img src="<?php echo $ruta_absoluta; ?>img/tidal-mini.jpeg" width="100" height="31" alt="tidal"></a></center></div><?php
                    }
				?>           
                </div>
                <?php
				if($row_DetalleProducto['estatus']=='DIGITAL')
				{
					?><h5 class="tipografia2">No disponible en formato f&iacute;sico</h5><?php	
				}
				
				?>
               
            </div>
             <!-- ============== fin de tiendas digitales escritorio====================== -->
            
         
            
            
            
        </div>
        <!-- /.row -->    
<!-- ====================== inicio de tabs ============================== -->        
<ul class="nav nav-tabs tipografia_tabs">
    <li class="active"><a data-toggle="tab" href="#desc">Descripci&oacute;n</a></li>
    <!--li><a data-toggle="tab" href="#coment">Comentarios</a></li-->
</ul>

<div class="tab-content tipografia_tabs" style="border:1px solid #ddd; padding:20px;">
    <div id="desc" class="tab-pane fade in active">
    <br>
        <p><?php echo utf8_encode($row_DetalleProducto['descripcion']) ?></p>
    </div>
    
    <!--div id="coment" class="tab-pane fade">
    <br>
        <p>Comentarios de ejemplo</p>
    </div-->
</div>
<!-- ====================== inicio de tabs ============================== -->  



 <!-- =========================== inicio te puede interesar =========================== -->   
 
 <p class="subtitulo_carrusel_index subtitulo_lanzamientos">TE PUEDE INTERESAR</p> 
<div class="carrusel_index" >
<?php
do
{
?>


<div class="img-portfolio"  style="display:inline-block !important; width:160px;">

	<!-- muesta la imagen -->
    <?php
    //si no tiene imagen le asigna una de base
    if($row_TePuedeInteresar['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_TePuedeInteresar['ruta_img']; }
    ?>
    <?php

	
	//inicio de genera URL SEO

	$url=$row_TePuedeInteresar['artista']."-".$row_TePuedeInteresar['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO

	?>
  
    <a href="<?php echo $ruta_absoluta ?>producto_detalle/<?php echo $row_TePuedeInteresar['id_prod']; ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_absoluta; ?><?php echo $ruta_caratula; ?>"  style="width:165px !important; height:165px !important;" alt="" ></a>
    
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_TePuedeInteresar['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_TePuedeInteresar['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>

<?php	
}while($row_TePuedeInteresar = mysqli_fetch_assoc($TePuedeInteresar));
?>
</div>

 <!-- =========================== fin te puede interesar =========================== --> 




 
 
 
 

               
              <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    
   
    <?php include_once("pie.php"); ?>
 


    <!-- jQuery -->
    <script src="<?php echo $ruta_absoluta; ?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $ruta_absoluta; ?>js/bootstrap.min.js"></script>
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
mysqli_free_result($TePuedeInteresar);

mysqli_free_result($DetalleProducto);
?>
