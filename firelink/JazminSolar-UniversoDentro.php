<!DOCTYPE html>
<html>
    <?php 
    header('Location: https://www.fonartelatino.com/firelink/411/Jazm%EF%BF%BDn_Solar-Universo_Dentro');
    $ruta_imagen = "../img/caratulas/CDDP-7310.jpg";
     $nombreArtista = "Jazmín Solar";
     $Album = "Universo Dentro";
     $fonarte = "https://www.fonartelatino.com/producto_detalle/411/jazmin_solar-universo_dentro"; 
     $spotify = "https://open.spotify.com/album/315TAYMkuiLXxVaplNEa3G?si=XLNs0z-6TgKaHvWV7MygJg"; 
     $appleItunes = "https://itunes.apple.com/mx/album/id899231983"; 
     $youtube = "https://music.youtube.com/playlist?list=OLAK5uy_mpHav3C-k0fxyOkKnxzv8hUCJAvN1-R_U"; 
     $google = "https://play.google.com/store/music/album/Jazm%C3%ADn_Solar_Universo_Dentro?id=B6o6pe47cml6zhy6gor43s7k4v4"; 
     $claro = "https://www.claromusica.com/album/760353"; 
     $amazon = "https://www.amazon.com/Universo-Dentro-Jazm%C3%ADn-Solar/dp/B00LVSIM00/ref=sr_1_5?s=dmusic&ie=UTF8&qid=1485544070&sr=1-5-mp3-albums-bar-strip-0&keywords=Jazm%C3%ADn+Solar";
     $deezer = "https://www.deezer.com/en/album/8447343"; 
     $video = "https://www.youtube.com/watch?v=jMXV2xSSPuY";?>
<head>
    <link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
    <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fonarte es uno de los sellos l&iacute;deres independientes de distribuci&oacute;n f&iacute;sica y digital, as&iacute; como uno de los referentes de la m&uacute;sica independiente de M&eacute;xico.">
    <meta name="author" content="">
    <title>Fonarte Latino | <?php echo $nombreArtista; ?></title>
  
    <link href="../css/estilo.css" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    
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

<?php include_once("../estilos.php"); ?>
<?php include_once("../rutas_absolutas.php"); ?>



<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57590021-2', 'auto');
  ga('send', 'pageview');

</script> -->

 <div style="margin-top: -30px">   


    
    
    <!-- /.container -->
    <div class="container" >
        <div class="row">
            <div class="col-xs-0 col-sm-3 col-md-3 col-lg-4"></div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4" style="background-color: white; display:inline-block; opacity: 0.8; filter: alpha(opacity=80);">
                <div class="row" >
                   
                    <div class="row" style="border:solid 1.5px #000; border-radius:15px; box-shadow: 8px 8px 10px 0px #818181; margin: 16px;">
                        <br>
                        <div class="col-xs-6 col-md-5">
                            <center><img class="img-rounded" width="120" height="120" class="img-responsive  " src=<?php echo $ruta_imagen; ?> ></center>
                            <br>
                        </div>
                        <div class="col-xs-6 col-md-7">
                            <center><h4><?php echo $nombreArtista; ?></h4></center>
                            <center><p><?php echo $Album; ?></p></center>
                            <?php if ($fonarte != "") {
                                echo "<center><a class=\"img-btn redirect\" href=\"".$fonarte."\" target=\"_blank\" data-player=\"fonartelatino\" data-servicetype=\"play\" data-apptype=\"manual\">Disponible Aquì</a></center>";
                            } ?>
                            
                        </div>
                        
                    </div>
                    
                </div>
               
                <div style="border:solid 1.5px #000; border-radius:15px; box-shadow: 8px 8px 10px 0px #818181;">
                    <br>
                    <?php if ($spotify != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$spotify."\" target=\"_blank\" data-player=\"spotify\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=../img/spoti.jpeg alt=\"spotify\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($appleItunes != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$appleItunes."?app=itunes\" target=\"_blank\" data-player=\"itunes\" data-servicetype=\"play\" data-apptype=\"manual\">
                                    <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"../img/itunes.jpeg\" alt=\"itunes\"></span>
                                </a></center>
                            </div>";
                   
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$appleItunes."\" target=\"_blank\" data-player=\"applemusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"../img/apple.jpeg\" alt=\"applemusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($youtube != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$youtube."\" target=\"_blank\" data-player=\"youtube\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"../img/you.jpeg\" alt=\"youtube\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($google != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$google."\" target=\"_blank\" data-player=\"googlemusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"../img/google.jpeg\" alt=\"googlemusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($claro != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$claro."\" target=\"_blank\" data-player=\"claromusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\" src=\"../img/claro.jpeg\" alt=\"claromusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($amazon != "") {
                        echo "<div class=\"row div-img\">
                                <center><a class=\"img-btn redirect\" href=\"".$amazon."\" target=\"_blank\" data-player=\"amazonmusic\" data-servicetype=\"play\" data-apptype=\"manual\">
                                <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"../img/amazon.jpeg\" alt=\"amazonmusic\"></span>
                                
                                </a></center>
                            </div>";
                    } ?>
                    
                    <?php if ($deezer != "") {
                        echo "<div class=\"row div-img\">
                        <center><a class=\"img-btn redirect\" href=\"".$deezer."\" target=\"_blank\" data-player=\"deezer\" data-servicetype=\"play\" data-apptype=\"manual\">
                        <span><img class=\"img img-rounded\" width=\"250\" height=\"63\"  src=\"../img/deezer.jpeg\" alt=\"deezer\"></span>
                        
                        </a></center>
                    </div>";
                    } ?>
                    <br>
                </div>
                <br>
                <?php if ($video != "") {
                    $aux = explode("?v=", $video);
                    
                    echo "<div class=\"row\">
                            <center><iframe width=\"250\" height=\"150\" src=\"https://www.youtube.com/embed/".$aux[1]."\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe></center>
                        </div>";
                } ?>
                <!--<div class="row">
                    <center><iframe src="https://open.spotify.com/embed/user/fonarte/playlist/5iYSEofDjIleYgUtTIjv09" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe></center>
                </div>-->
                
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
    <script src="../js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>