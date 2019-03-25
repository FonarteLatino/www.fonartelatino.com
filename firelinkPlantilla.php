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







mysql_select_db($database_conexion, $conexion);
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
productos.claro,
productos.youtube,
productos.deezer,
productos.tidal,
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
$DetalleProducto = mysql_query($query_DetalleProducto, $conexion) or die(mysql_error());
$row_DetalleProducto = mysql_fetch_assoc($DetalleProducto);






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
$claro = ""; 
$amazon = "";
$deezer = ""; 
$tidal = "";
$video = "";
$play = 0;
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

if($row_DetalleProducto['claro']!='')//tiene link de itunes
{
  $claro = $row_DetalleProducto['claro']; 
}

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
<html lang="en">

<head>
<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
  
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
    <div class="container" >
        <div class="row">
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-4"></div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" style="background-color: white; display:inline-block; opacity: 0.8; filter: alpha(opacity=80);">
                <div class="row" >
                   
                   <div class="row" style="border:solid 1.5px #000; border-radius:15px; box-shadow: 8px 8px 10px 0px #818181; margin: 16px;">
                        
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
                                echo "<br>
                                        <div class=\"col-xs-6 col-md-5\">
                                            <center><img class=\"img-rounded\" width=\"120\" height=\"120\" class=\"img-responsive  \" src=".$ruta_imagen."></center>
                                            <br>
                                        </div>
                                        <div class=\"col-xs-6 col-md-7\">
                                            <center><h4>".$nombreArtista."</h4></center>
                                            <center><p>".$Album."</p></center>";
                                            if ($fonarte != "") {
                                                echo "<center><a class=\"img-btn redirect\" href=\"".$fonarte."\" target=\"_blank\" data-player=\"fonartelatino\" data-servicetype=\"play\" data-apptype=\"manual\">Disponible Aqui</a></center>";
                                            } 
                                            
                                        echo "</div>";
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
               
                <div style="border:solid 1.5px #000; border-radius:15px; box-shadow: 8px 8px 10px 0px #818181;">
                    <br>
                    <?php if ($spotify != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$spotify."\" target=\"_blank\" data-player=\"spotify\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/spoti.jpeg\" alt=\"spotify\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($appleItunes != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$appleItunes."?app=itunes\" target=\"_blank\" data-player=\"itunes\" data-servicetype=\"play\" data-apptype=\"manual\">
                                    <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/itunes.jpeg\" alt=\"itunes\"></span>
                                </a></center>
                            </div>";
                   
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$appleItunes."\" target=\"_blank\" data-player=\"applemusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/apple.jpeg\" alt=\"applemusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($youtube != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$youtube."\" target=\"_blank\" data-player=\"youtube\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/you.jpeg\" alt=\"youtube\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($google != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$google."\" target=\"_blank\" data-player=\"googlemusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/google.jpeg\" alt=\"googlemusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($claro != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$claro."\" target=\"_blank\" data-player=\"claromusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\" src=\"".$ruta_absoluta."img/claro.jpeg\" alt=\"claromusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($amazon != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$amazon."\" target=\"_blank\" data-player=\"amazonmusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/amazon.jpeg\" alt=\"amazonmusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($deezer != "") {
                        echo "<div class=\"row div-img\">
                        <center><a class=\"img-btn redirect\" href=\"".$deezer."\" target=\"_blank\" data-player=\"deezer\" data-servicetype=\"play\" data-apptype=\"manual\">
                        <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/deezer.jpeg\" alt=\"deezer\"></span>
                        
                        </a></center>
                    </div>";
                    } ?>

                    <?php if ($tidal != "") {
                        echo "<div class=\"row div-img\">
                        <center><a class=\"img-btn redirect\" href=\"".$tidal."\" target=\"_blank\" data-player=\"tidal\" data-servicetype=\"play\" data-apptype=\"manual\">
                        <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"".$ruta_absoluta."img/tidal.jpeg\" alt=\"tidal\"></span>
                        
                        </a></center>
                    </div>";
                    } ?>
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

