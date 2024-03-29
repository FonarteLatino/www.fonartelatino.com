<?php 


require_once('Connections/conexion.php'); ?>
<?php

include_once("rutas_absolutas.php");
include_once("estilos.php"); 


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
$id_producto=$_GET['id_producto'];







mysqli_select_db($conexion,$database_conexion);
$query_DetalleProducto = "SELECT
productos.id,
productos.sku,
productos.id_fonarte,
productos.clave_precio,
productos.artista,
productos.album,
productos.genero,
genero.nombre AS gen_nombre,
productos.categoria,
categoria.nombre AS cat_nombre,
productos.play,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.amazon_mu,
productos.youtube,
productos.deezer,
productos.tidal,
productos.promo,
productos.p,
productos.ruta_img,
productos.ruta_img_2,
productos.video,
productos.descripcion,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
productos.prendido,
productos.estatus,
productos.firelink,
precios.precio,
precios.id
FROM
productos
INNER JOIN categoria ON categoria.id = productos.categoria
INNER JOIN genero ON genero.id = productos.genero
INNER JOIN precios ON precios.clave = productos.clave_precio WHERE productos.estatus != \"INACTIVO\" and productos.firelink = \"Si\" and productos.id=".$id_producto;
/*$query_DetalleProducto = "SELECT
productos.id,
productos.sku,
productos.id_fonarte,
productos.clave_precio,
productos.artista,
productos.album,
productos.genero,
genero.nombre AS gen_nombre,
productos.categoria,
categoria.nombre AS cat_nombre,
productos.play,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.claro,
productos.youtube,
productos.deezer,
productos.tidal,
productos.promo,
productos.p,
productos.ruta_img,
productos.ruta_img_2,
productos.video,
productos.descripcion,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
productos.prendido,
productos.estatus,
productos.firelink,
precios.precio,
precios.id
FROM
productos
INNER JOIN categoria ON categoria.id = productos.categoria
INNER JOIN genero ON genero.id = productos.genero
INNER JOIN precios ON precios.clave = productos.clave_precio WHERE productos.estatus != \"INACTIVO\" and productos.firelink = \"Si\" and productos.id=".$id_producto;*/
$DetalleProducto = mysqli_query($conexion,$query_DetalleProducto) or die(mysqli_error($conexion));
$row_DetalleProducto = mysqli_fetch_assoc($DetalleProducto);






/* ******************** inicio de agrega al carrito *************************** */

$tipo = 0;
$ruta_imagen = "";
$nombreArtista = "";
$description = "";
$Album = "";
$fonarte = ""; 
$spotify = ""; 
$appleItunes = ""; 
$youtube = "";
$google = ""; 
$amazon_mu = ""; 
//$claro = ""; 
$amazon = "";
$deezer = ""; 
$tidal = "";
$video = "";
$play = 0;
$p = utf8_encode($row_DetalleProducto['p']);
$promo = utf8_encode($row_DetalleProducto['promo']);
if (($row_DetalleProducto['estatus']) == "ACTIVO" || ($row_DetalleProducto['estatus']) == "DIGITAL") {
    $tipo = 2;
}

if ($row_DetalleProducto['categoria'] == 5) {
    $tipo = 1;
}



    if($row_DetalleProducto['ruta_img']==''){ $ruta_imagen=$ruta_absoluta."img/caratulas/muestra.jpg"; }

    else{ $ruta_imagen=$ruta_absoluta.$row_DetalleProducto['ruta_img']; }




$nombreArtista = utf8_encode($row_DetalleProducto['artista']);

$Album = utf8_encode($row_DetalleProducto['album']);

if($row_DetalleProducto['spotify']!='')
{
  $spotify = $row_DetalleProducto['spotify']; 
}

if($row_DetalleProducto['estatus']!='DIGITAL')
{
  $fi = explode("firelink", $_SERVER["REQUEST_URI"]);
  $fonarte = "https://www.fonartelatino.com/producto_detalle".$fi[1];
} 
else {$fonarte = "";}

if($row_DetalleProducto['itunes']!='')//tiene link de itunes
{
  $appleItunes = $row_DetalleProducto['itunes']; 
}

if($row_DetalleProducto['youtube']!='')//tiene link de itunes
{
  $youtube = $row_DetalleProducto['youtube']; 
}

if($row_DetalleProducto['google']!='')//tiene link de itunes
{
  $google = $row_DetalleProducto['google']; 
}

if($row_DetalleProducto['amazon_mu']!='')//tiene link de itunes
{
  $amazon_mu = $row_DetalleProducto['amazon_mu']; 
}
//if($row_DetalleProducto['claro']!='')//tiene link de itunes
//{
  //$claro = $row_DetalleProducto['claro']; 
//}

if($row_DetalleProducto['amazon']!='')//tiene link de itunes
{
  $amazon = $row_DetalleProducto['amazon']; 
}

if($row_DetalleProducto['deezer']!='')//tiene link de itunes
{
  $deezer = $row_DetalleProducto['deezer']; 
}

if($row_DetalleProducto['tidal']!='')//tiene link de itunes
{
  $tidal = $row_DetalleProducto['tidal']; 
}

if($row_DetalleProducto['video']!='')//tiene link de itunes
{
  $video = $row_DetalleProducto['video']; 
}

if($row_DetalleProducto['play']!='')//tiene link de itunes
{
  if ($row_DetalleProducto['play']=='Si') {
      $play = 1; 
  }
  else{
      $play = 0; 
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
<link rel="icon" type="image/png" href="https://www.fonartelatino.com/img/favicon.png" />
  
  <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php if ($tipo == 2) { ?>
    <title><?php echo utf8_encode($row_DetalleProducto['artista']); ?> | <?php echo utf8_encode($row_DetalleProducto['album']); ?> | Fonarte Latino</title>
    <?php
    }
    else if ($tipo == 1) { 
    ?>
    <title><?php echo utf8_encode($row_DetalleProducto['album']); ?> | Fonarte Latino</title>
    <?php
    }
    else if ($tipo == 0) { 
    ?>
    <title><?php echo utf8_encode($row_DetalleProducto['artista']); ?> | Fonarte Latino</title>
    <?php } ?>
    <link href="<?php echo $ruta_absoluta; ?>css/estilo.css" rel="stylesheet" type="text/css">
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
 <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-57590021-2', 'auto');
      ga('send', 'pageview');

    </script>
    <style type="text/css">
      hr {
        margin-top: 10px;
        margin-bottom: 10px;
        border: none;
        border-top: 1px solid #eee;
        height:1px;
      }
      
      
    </style>
</head>

<body  >
    
    <div style="background: url(<?php echo $ruta_imagen; ?>); 
 
    -webkit-filter: blur(10px); 
 
    -moz-filter: blur(10px); 
 
    -o-filter: blur(10px); 
 
    -ms-filter: blur(10px); 
 
    filter: blur(10px); 
 
    position: fixed; 

    background-size: cover;

    background-position: 50% 50%;
 
    width: 100%; 
 
    height: 100%; 
 
    top: 0; 
 
    left: 0; 
 
    z-index: -1; ">
        
    </div>

    

    <!-- Page Content -->
    
    
         
        
  

           


     <div style="margin-top: -30px">   


  
    
    <!-- /.container -->
    <div class="container">
        <div class="row" style="">
            <div class="col-xs-0 col-sm-3 col-md-4 col-lg-4"></div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4" style="box-shadow: 0px 0px 0px 5px rgba(0,0,0,0.50); background-color: white; display:inline-block; opacity: 0.8; filter: alpha(opacity=80);">
                <div class="row" >
                   
                   <div class="row" style="margin: 1px;">
                        
                        <?php  
                            if ($tipo == 0) {
                               echo "<div class=\"col-xs-12 col-md-12\">
                                    <center><h4>".$nombreArtista."</h4></center>
                                    
                                </div>
                                <div class=\"col-xs-12 col-md-12\">
                                    <center><img class=\"img-rounded\" width=\"270\" height=\"270\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                    <br>
                                </div> ";
                            }
                            else if ($tipo == 1) {
                               echo "
                                <div class=\"col-xs-12 col-md-12\">
                                    <center><img class=\"img-rounded\" width=\"270\" height=\"270\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                    <br>
                                </div> ";
                            }
                            else
                            {
                                echo "
                                <div class=\"row hidden-sm hidden-md hidden-lg\">        
                                  <div class=\"col-xs-12\">
                                    <center><img class=\"img-rounded\" width=\"280\" height=\"280\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                    
                                  </div>
                                </div>
                                <div class=\"row hidden-xs hidden-md hidden-lg\">        
                                  <div class=\"col-xs-12\">
                                    <center><img class=\"img-rounded\" width=\"100%\" height=\"373\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                    
                                  </div>
                                </div>
                                <div class=\"row hidden-xs hidden-sm hidden-lg\">        
                                  <div class=\"col-xs-12\">
                                    <center><img class=\"img-rounded\" width=\"387\" height=\"387\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                    
                                  </div>
                                </div>
                                <div class=\"row hidden-xs hidden-sm hidden-md\">        
                                  <div class=\"col-xs-12\">
                                    <center><img class=\"img-rounded\" width=\"387\" height=\"387\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                    
                                  </div>
                                </div>

                                <center><div class=\"row hidden-sm hidden-md hidden-lg\" style=\"background-color:black; color: white; width:280px; margin-left:-15px;\">
                                  <div class=\"col-xs-12\">
                                    <center><h4>".$nombreArtista."</h4></center>
                                    <center><p>".$Album."</p></center>
                                  </div> 
                                </div> </center> 
                                <div class=\"row hidden-xs hidden-md hidden-lg\" style=\"background-color:black; color: white; width:373px; margin-left:0px;\">
                                  <div class=\"col-xs-12\">
                                    <center><h4>".$nombreArtista."</h4></center>
                                    <center><p>".$Album."</p></center>
                                  </div> 
                                </div>  
                                <div class=\"row hidden-xs hidden-sm hidden-lg\" style=\"background-color:black; color: white; width:388px; margin-left:8px;\">
                                  <div class=\"col-xs-12\">
                                    <center><h4>".$nombreArtista."</h4></center>
                                    <center><p>".$Album."</p></center>
                                  </div> 
                                </div>   
                                <div class=\"row hidden-xs hidden-sm hidden-md\" style=\"background-color:black; color: white; width:388px; margin-left:-0.5px;\">
                                  <div class=\"col-xs-12\">
                                    <center><h4>".$nombreArtista."</h4></center>
                                    <center><p>".$Album."</p></center>
                                  </div> 
                                </div> 
                                            ";
                            }
                        ?>
                        
                        
                        
                        
                    </div>
                    
                </div>

                <?php  
                    if ($tipo == 0) {
                        echo "<div class=\"row\" style=\"border:solid 1.5px #000; border-radius:15px; box-shadow: 8px 8px 10px 0px #818181; margin: 1px;\" align=\"justify\">
                                <div class=\"col-xs-1\"></div>
                                <div class=\"col-xs-10\">

                                    <p style=\"line-height:100%; margin-top: 8px;\">".$description."</p>
                                </div>
                                <div class=\"col-xs-1\"></div>
                            </div>
                            <br>";
                    }
                ?>
               
                <div style="">
                    
                    <?php if (($row_DetalleProducto['sku'] == '7509841317702')||($row_DetalleProducto['sku'] == '7509841277372')) { ?>

                      <?php if ($amazon != "") {
                        
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Amazon', 'LinkAmazon');\" class=\"img-btn redirect\" href=\"".$amazon."\" target=\"_blank\" data-player=\"amazonmusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/amazon.jpeg\" alt=\"amazonmusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>

                    <?php if ($amazon_mu != "") {
                      $aux1 = str_replace("music.amazon.com.mx", "music.amazon.com", $amazon_mu);
                        
                        $aux = str_replace("musicTerritory=MX", "musicTerritory=US", $aux1);
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Amazon_music', 'LinkAmazon_Music');\" class=\"img-btn redirect\" href=\"".$aux."\" target=\"_blank\" data-player=\"amazonmmusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/amazon_mu.jpeg\" alt=\"amazonmmusic\"></span>
                                
                                </a></center>
                            </div>";
                    } 
                    ?>

                    <?php if ($amazon_mu != "") {
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Amazon_music', 'LinkAmazon_Music');\" class=\"img-btn redirect\" href=\"".$amazon_mu."\" target=\"_blank\" data-player=\"amazonmmusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/amazon_mu_mx.jpeg\" alt=\"amazonmmusic\"></span>
                                
                                </a></center>
                            </div>";
                    } 
                    ?>

                      <?php if ($appleItunes != "") {
                       
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Itunes', 'LinkItunes');\" class=\"img-btn redirect\" href=\"".$appleItunes."?app=itunes\" target=\"_blank\" data-player=\"itunes\" data-servicetype=\"play\" data-apptype=\"manual\">
                                    <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/itunes.jpeg\" alt=\"itunes\"></span>
                                </a></center>
                            </div>"; 
                   
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Apple', 'LinkApple');\" class=\"img-btn redirect\" href=\"".$appleItunes."\" target=\"_blank\" data-player=\"applemusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/apple.jpeg\" alt=\"applemusic\"></span>
                                
                                </a></center>
                            </div>";

                        
                    } ?>

                      

                   
                      <?php if ($google != "") {
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Google', 'LinkGoogle');\" class=\"img-btn redirect\" href=\"".$google."\" target=\"_blank\" data-player=\"googlemusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/google.jpeg\" alt=\"googlemusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    
                      <?php if ($spotify != "") {
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'Spotify', 'LinkSpotify');\" class=\"img-btn redirect\" href=\"".$spotify."\" target=\"_blank\" data-player=\"spotify\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/spoti.jpeg\" alt=\"spotify\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>

                    <?php if ($youtube != "") {
                        echo "<div class=\"row div-img\">
                                <center><a onclick=\"ga('send', 'event', 'Firelink', 'YouTube', 'LinkYouTube');\" class=\"img-btn redirect\" href=\"".$youtube."\" target=\"_blank\" data-player=\"youtube\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/you.jpeg\" alt=\"youtube\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
    
                    
                    <?php if ($deezer != "") {
                        echo "<div class=\"row div-img\">
                        <center><a onclick=\"ga('send', 'event', 'Firelink', 'Deezer', 'LinkDeezer');\" class=\"img-btn redirect\" href=\"".$deezer."\" target=\"_blank\" data-player=\"deezer\" data-servicetype=\"play\" data-apptype=\"manual\">
                        <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/deezer.jpeg\" alt=\"deezer\"></span>
                        
                        </a></center>
                    </div>";
                    } ?>

                    <?php if ($tidal != "") {
                        echo "<div class=\"row div-img\">
                        <center><a onclick=\"ga('send', 'event', 'Firelink', 'Tidal', 'LinkTidal');\" class=\"img-btn redirect\" href=\"".$tidal."\" target=\"_blank\" data-player=\"tidal\" data-servicetype=\"play\" data-apptype=\"manual\">
                        <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/tidal.jpeg\" alt=\"tidal\"></span>
                        
                        </a></center>
                    </div>";
                    } ?>
                    <?php } else {?>
                      <br>
                    <?php if ($spotify != "") {
                        echo "
                        <div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                                <center>
                                <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Spotify.png\" alt=\"spotify\"></span>
                                
                                <a onclick=\"ga('send', 'event', 'Firelink', 'Spotify', 'LinkSpotify');\" class=\"img-btn redirect\" href=\"".$spotify."\" target=\"_blank\" data-player=\"spotify\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" hover class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                            </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                                <center>
                                <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Spotify.png\" alt=\"spotify\"></span>
                                
                                <a onclick=\"ga('send', 'event', 'Firelink', 'Spotify', 'LinkSpotify');\" class=\"img-btn redirect\" href=\"".$spotify."\" target=\"_blank\" data-player=\"spotify\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" hover class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                            </div>
                            <hr/>";
                    } ?>
        
                    <?php if ($youtube != "") {
                        echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Youtube.png\" alt=\"youtube\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'YouTube', 'LinkYouTube');\" class=\"img-btn redirect\" href=\"".$youtube."\" target=\"_blank\" data-player=\"youtube\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Youtube.png\" alt=\"youtube\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'YouTube', 'LinkYouTube');\" class=\"img-btn redirect\" href=\"".$youtube."\" target=\"_blank\" data-player=\"youtube\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <hr/>";
                    } ?>
                    
                    <?php if ($appleItunes != "") {
                        echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/itunes.png\" alt=\"itunes\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Itunes', 'LinkItunes');\" class=\"img-btn redirect\" href=\"".$appleItunes."?app=itunes\" target=\"_blank\" data-player=\"itunes\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Download</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/itunes.png\" alt=\"itunes\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Itunes', 'LinkItunes');\" class=\"img-btn redirect\" href=\"".$appleItunes."?app=itunes\" target=\"_blank\" data-player=\"itunes\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Download</button></a></center>
                        </div>
                        <hr/>";
                        
                        echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Apple.png\" alt=\"applemusic\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Apple', 'LinkApple');\" class=\"img-btn redirect\" href=\"".$appleItunes."\" target=\"_blank\" data-player=\"applemusic\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Apple.png\" alt=\"applemusic\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Apple', 'LinkApple');\" class=\"img-btn redirect\" href=\"".$appleItunes."\" target=\"_blank\" data-player=\"applemusic\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <hr/>";
                        
                    } ?>
                    
                    
                    <?php if ($amazon_mu != "") {
                        echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Amazon Music.png\" alt=\"amazonmmusic\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Amazon_music', 'LinkAmazon_Music');\" class=\"img-btn redirect\" href=\"".$amazon_mu."\" target=\"_blank\" data-player=\"amazonmmusic\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Amazon Music.png\" alt=\"amazonmmusic\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Amazon_music', 'LinkAmazon_Music');\" class=\"img-btn redirect\" href=\"".$amazon_mu."\" target=\"_blank\" data-player=\"amazonmmusic\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <hr/>";
                        
                    } 
                    ?>
                    
                    <?php if ($amazon != "") {
                        echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Amazon-MP3.png\" alt=\"amazonmusic\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Amazon', 'LinkAmazon');\" class=\"img-btn redirect\" href=\"".$amazon."\" target=\"_blank\" data-player=\"amazonmusic\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Download</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Amazon-MP3.png\" alt=\"amazonmusic\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Amazon', 'LinkAmazon');\" class=\"img-btn redirect\" href=\"".$amazon."\" target=\"_blank\" data-player=\"amazonmusic\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Download</button></a></center>
                        </div>
                        <hr/>";
                        
                    } ?>
                    
                    <?php if ($deezer != "") {
                      echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                          <center>
                          <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Deezer.png\" alt=\"deezer\"></span>
                          
                          <a onclick=\"ga('send', 'event', 'Firelink', 'Deezer', 'LinkDeezer');\" class=\"img-btn redirect\" href=\"".$deezer."\" target=\"_blank\" data-player=\"deezer\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                      </div>
                      <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                          <center>
                          <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Deezer.png\" alt=\"deezer\"></span>
                          
                          <a onclick=\"ga('send', 'event', 'Firelink', 'Deezer', 'LinkDeezer');\" class=\"img-btn redirect\" href=\"".$deezer."\" target=\"_blank\" data-player=\"deezer\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                      </div>
                      <hr/>";
                        
                    } ?>

                    <?php if ($tidal != "") {
                        echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Tidal.png\" alt=\"tidal\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Tidal', 'LinkTidal');\" class=\"img-btn redirect\" href=\"".$tidal."\" target=\"_blank\" data-player=\"tidal\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Tidal.png\" alt=\"tidal\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Tidal', 'LinkTidal');\" class=\"img-btn redirect\" href=\"".$tidal."\" target=\"_blank\" data-player=\"tidal\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Play</button></a></center>
                        </div>
                        <hr/>";
                        
                    } ?>
                    
                    <?php 
                        if ($google != "") {
                          echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Amazon Fisico.png\" alt=\"amazonstore\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'AmazonS', 'LinkAmazonS');\" class=\"img-btn redirect\" href=\"".$google."\" target=\"_blank\" data-player=\"amazonstore\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Buy</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Amazon Fisico.png\" alt=\"amazonstore\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'AmazonS', 'LinkAmazonS');\" class=\"img-btn redirect\" href=\"".$google."\" target=\"_blank\" data-player=\"amazonstore\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Buy</button></a></center>
                        </div>
                        <hr/>";
                         }
                        if ($fonarte != ""){
                          echo "<div class=\"hidden-sm hidden-md hidden-lg\" style=\"margin-left:-130px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Fonarte Store.png\" alt=\"fonarte\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Fonarte', 'LinkFonarte');\" class=\"img-btn redirect\" href=\"".$fonarte."\" target=\"_blank\" data-player=\"fonarte\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:300px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Buy</button></a></center>
                        </div>
                        <div class=\"hidden-xs\" style=\"margin-left:-210px;\" class=\"row div-img\">
                            <center>
                            <span><img class=\"img img-rounded\" width=\"125\" height=\"61\"  src=\"".$ruta_absoluta."img/Fonarte Store.png\" alt=\"fonarte\"></span>
                            
                            <a onclick=\"ga('send', 'event', 'Firelink', 'Fonarte', 'LinkFonarte');\" class=\"img-btn redirect\" href=\"".$fonarte."\" target=\"_blank\" data-player=\"fonarte\" data-servicetype=\"play\" data-apptype=\"manual\"><button style=\"margin-top:-52px;margin-left:445px; width:100px; height:44px;\" class=\"btn btn-default\" type=\"button\">Buy</button></a></center>
                        </div>
                        <hr/>";
                        }
                        
                     ?>
  

                    <?php } ?>
                    <br>
                    <?php if ($play != 0) {
                        
                        if ($tipo == 0) {
                            $saux = explode("?si=", $spotify);
                            $ssaux = explode("/artist/", $saux[0]);
                            $ssaux[1] = "artist/".$ssaux[1];
                          } 
                          elseif ($tipo == 1) {
                            $saux = explode("?si=", $spotify);
                            $ssaux = explode("/playlist/", $saux[0]);
                            $ssaux[1] = "user/fonarte/playlist/".$ssaux[1];
                          }
                          elseif ($tipo == 2) {
                            $saux = explode("?si=", $spotify);
                            if (count(explode("/album/", $spotify)) == 1) {
                                $ssaux = explode("/track/", $saux[0]);
                                $ssaux[1] = "track/".$ssaux[1];
                                
                            }
                            else{
                                $ssaux = explode("/album/", $saux[0]);
                                $ssaux[1] = "album/".$ssaux[1];

                                
                            }
                          }
                        
                        
                        
                        
                        echo "<div class=\"row\">
                                <center><iframe src=\"https://open.spotify.com/embed/".$ssaux[1]."\" width=\"250\" height=\"243\" frameborder=\"0\" allowtransparency=\"true\" allow=\"encrypted-media\"></iframe></center>
                            </div> <br>";
                    } ?>
                   

                    <?php if ($p != "" && $p != "No") {
                        
                        
                        echo "<div class=\"row\" style=\"margin: 1px;\" align=\"justify\">
                                <div class=\"col-xs-1\"></div>
                                <div class=\"col-xs-10\">
                                    <center>
                                    <h4 style=\"color:#D9221E; line-height:100%; margin-top: 8px;\">".$promo."</h4>
                                    </center>
                                </div>
                                <div class=\"col-xs-1\"></div>
                            </div>
                            <br>";
                    } ?>

                    <?php if ($video != "") {
                        $aux = explode("?v=", $video);
                        
                        echo "<div class=\"row\">
                                <center><iframe width=\"250\" height=\"150\" src=\"https://www.youtube.com/embed/".$aux[1]."\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></center>
                            </div>";
                    } ?>
                    <br>
                </div>
                
                <div class="row" style="background-color: #000">
                   <div class="col-sm-6" style="color:#FFF; ">
            
             

            
            
             
                      <a href="https://twitter.com/Fonarte" target="new"  style="color:#FFF"><span class="fa fa-twitter fa-1x"></span></a>
                        &nbsp;&nbsp;<a href="https://www.instagram.com/fonarte/" target="new"  style="color:#FFF"><span class="fa fa-instagram fa-1x"></span></a>
                        
                        &nbsp;&nbsp;<a href="https://www.youtube.com/user/fonartelatino" target="new"  style="color:#FFF"><span class="fa fa-youtube fa-1x"></span></a>
                        
                        &nbsp;&nbsp;<a href="https://www.facebook.com/Fonarte/" target="new"  style="color:#FFF"><span class="fa fa-facebook fa-1x"></span></a>   
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-4"></div>
        </div>
        
    </div>

  


    
      
</div>
    
   
   
 


    <!-- jQuery -->
    <script src="<?php echo $ruta_absoluta; ?>js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo $ruta_absoluta; ?>js/bootstrap.min.js"></script>

</body>

</html>

