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
$id_producto=145;//$_GET['id_producto'];







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
  //$fonarte = "https://www.fonartelatino.com/producto_detalle".$fi[1];
  $fonarte = "https://www.fonartelatino.com/producto_detalle/145/Carlos_Macz�as-Las_Joyas_del_Prz�ncipe";
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
<!-- saved from url=(0030)https://orcd.co/katylaorugapre -->
<html class="wf-montserrat-n4-active wf-montserrat-n7-active wf-montserrat-n1-active wf-montserrat-n2-active wf-montserrat-n3-active wf-montserrat-n8-active wf-montserrat-n6-active wf-montserrat-n5-active wf-active">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Katy la Oruga (Pre Save)</title>
    <meta data-n-head="ssr" name="viewport" content="width=device-width, initial-scale=1">
    
    <meta data-n-head="ssr" property="twitter:card" content="">
    <meta data-n-head="ssr" property="twitter:url" content="">
    <meta data-n-head="ssr" property="twitter:title" content="">
    <meta data-n-head="ssr" property="twitter:description" content="">
    <meta data-n-head="ssr" property="twitter:image" content="">
   
    
    <link href="./css/estiloFirelink1.css" rel="stylesheet" type="text/css">
    <link href="./css/estiloFirelink2.css" rel="stylesheet" type="text/css">
    <link href="./css/estiloFirelink3.css" rel="stylesheet" type="text/css">
      
  </head>

  <body>
    <div id="__nuxt"><!---->
      <div id="__layout">
        <div class="slug-index" data-v-7cfaac94="">
          
          
          <div class="page" style="" data-v-7c7e10c6="" data-v-7cfaac94="">
            <div class="page-container" data-v-7c7e10c6="">
              <div class="player-container" data-v-7c7e10c6="">
                <div class="page-background" style="background-image:linear-gradient( rgba(0, 0, 0, 0.6), rgba(0, 0, 0, .2) ), url(<?php echo $ruta_imagen; ?>);" data-v-7c7e10c6=""></div>
                <div class="player-container box-shadow" style="opacity:1;" data-v-7c7e10c6="">
                  


                  <div class="container-for-player playlist" style="height:320px;" data-v-4429322e="" data-v-7c7e10c6="">
                    <div class="song-player-bg player-content dimmed" style="background-image:url(<?php echo $ruta_imagen; ?>);" data-v-4429322e=""></div> 
                  </div> 
                    
                      <div class="song-info" data-v-7c7e10c6="">
                        <h4 data-v-7c7e10c6=""><?php echo $Album; ?></h4> 
                        <p class="choose-service" data-v-7c7e10c6="">Elija su servicio de música preferido</p>
                      </div> 
                      <div class="music-services-section" data-v-5038608e="" data-v-7c7e10c6=""> 
                        <ul class="services" data-v-5038608e="">
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="spotify" target="_blank" href="<?php echo $spotify; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Spotify.png\""?> class="logo" data-v-5038608e=""> <!----> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Play</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="apple" target="_blank" href="<?php echo $youtube; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Youtube.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Play</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="apple" target="_blank" href="<?php echo $appleItunes; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Apple.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Play</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="itunes" target="_blank" href="<?php echo $appleItunes."?app=itunes"; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/itunes.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Download</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="amazonstore" target="_blank" href="<?php echo $amazon_mu; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Amazon Music.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Play</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="amazon" target="_blank" href="<?php echo $amazon; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Amazon-MP3.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Download</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="deezer" target="_blank" href="<?php echo $deezer; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Deezer.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Play</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="tidal" target="_blank" href="<?php echo $tidal; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Tidal.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Play</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="tidal" target="_blank" href="<?php echo $google; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Amazon Fisico.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Buy</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                          <li data-v-5038608e="">
                            <div class="service" data-v-5038608e="">
                              <a service="tidal" target="_blank" href="<?php echo $fonarte; ?>" class="service service-link" data-v-5038608e=""><img src=<?php echo"\"".$ruta_absoluta."img/Fonarte Store.png\""?> class="logo" data-v-5038608e=""> 
                                <div class="music-service-cta" data-v-78022448="" data-v-5038608e="">
                                  <div class="tooltip-container" data-v-3147eada="" data-v-78022448="">
                                    <div class="tooltip-item" data-v-3147eada="">
                                      <div data-v-3147eada="" data-v-78022448="">
                                        <div class="music-service-cta-text" data-v-0b73c378="" data-v-78022448="" data-v-3147eada="">
                                          <div class="music-service-cta-text__overflow" data-v-0b73c378="">Buy</div>
                                        </div>
                                      </div> 
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                          </li>
                        </ul>
                      </div>
                    </div> 
                    
                    <div class="footer-disclaimer" data-v-7c7e10c6="">
                      <p class="footer-policy" data-v-7c7e10c6="">Derechos reservados Fonarte Latino </p> 
                      <br>
                    </div>
                  </div>
                </div> 
                
              </div> 
              
              
            </div>
          </div>
        </div>
        
  

</body>
</html>