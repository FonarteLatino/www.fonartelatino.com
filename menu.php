<?php 
/*
if (!isset($_SESSION)) 
{
  session_start();
}
*/
require_once('Connections/conexion.php');


 ?>

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

mysql_select_db($database_conexion, $conexion);
$query_Generos = "SELECT * FROM genero order by nombre ASC";
$Generos = mysql_query($query_Generos, $conexion) or die(mysql_error());
$row_Generos = mysql_fetch_assoc($Generos);
$totalRows_Generos = mysql_num_rows($Generos);

//SI EXISTE LA SESION TEMPORAL
if(isset($_SESSION['CARRITO_TEMP']))
{
	mysql_select_db($database_conexion, $conexion);
	$query_Carrito = "SELECT * FROM carrito where id_usr=".$_SESSION['CARRITO_TEMP'];
	$Carrito = mysql_query($query_Carrito, $conexion) or die(mysql_error());
	$row_Carrito = mysql_fetch_assoc($Carrito);
	$totalRows_Carrito = mysql_num_rows($Carrito);
}
//SI EXISTE LA SESION DEL USUARIO(AL CREARSE ESTA, SE ELIMINA LA TEMPORAL)
if(isset($_SESSION['USUARIO_ECOMMERCE']))
{
	mysql_select_db($database_conexion, $conexion);
	$query_Carrito = "SELECT * FROM carrito where id_usr=".$_SESSION['USUARIO_ECOMMERCE']['id'];
	$Carrito = mysql_query($query_Carrito, $conexion) or die(mysql_error());
	$row_Carrito = mysql_fetch_assoc($Carrito);
	$totalRows_Carrito = mysql_num_rows($Carrito);
}


//muestra todas las categorias que no sean merchandisign  PARA EL SUBTITULO
mysql_select_db($database_conexion, $conexion);
$query_CategoriaSub = "SELECT * FROM categoria WHERE id!=4  order by nombre ASC";
$CategoriaSub = mysql_query($query_CategoriaSub, $conexion) or die(mysql_error());
$row_CategoriaSub = mysql_fetch_assoc($CategoriaSub);
$totalRows_CategoriaSub = mysql_num_rows($CategoriaSub);



?>
<?php include_once("estilos.php"); ?>
<?php include_once("rutas_absolutas.php"); ?>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57590021-2', 'auto');
  ga('require', 'linkid');
  ga('send', 'pageview');

</script>



<nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation" style="background-color: #ffffff;border-color: #ffffff;">
<!-- **************************** inicio de redes sociales FRANJA NEGRA********************** -->
<div class="container" >

    <div class="row espacio_redessociales">
        
        <div class="col-sm-6 tipografia2" style="color:#FFF; ">
       
        
           <?php
		   
		   if(isset($_SESSION['USUARIO_ECOMMERCE']))
			{
				//echo "Bienvenido: ".$_SESSION['USUARIO_ECOMMERCE']['nombre'];
			}
		   
		   ?>
        
        </div>
        
        
        
        
        <div class="col-sm-6" style="color:#FFF; ">
            <!--a href=""  class="tipografia" style="color:#ffffff;"> Mi cuenta </a>
            <span class="glyphicon glyphicon-shopping-cart fa-1x" aria-hidden="true"></span-->
             <?php
		if(isset($_SESSION['CARRITO_TEMP']) or isset($_SESSION['USUARIO_ECOMMERCE']))
		{
			?><a href="<?php echo $ruta_absoluta; ?>carrito.php"  class="tipografia" style="color:#ffffff;"><span class="glyphicon glyphicon-shopping-cart fa-1x" aria-hidden="true"></span> <?php echo "(".$totalRows_Carrito.")" ?></a><?php
			
			

		}

		
		?>

            
         <!--   
             
          <a href="https://twitter.com/Fonarte" target="new"  style="color:#FFF"><span class="fa fa-twitter fa-1x"></span></a>
            &nbsp;&nbsp;<a href="https://www.instagram.com/fonarte/" target="new"  style="color:#FFF"><span class="fa fa-instagram fa-1x"></span></a>
            
            &nbsp;&nbsp;<a href="https://www.youtube.com/user/fonartelatino" target="new"  style="color:#FFF"><span class="fa fa-youtube fa-1x"></span></a>
            
            &nbsp;&nbsp;<a href="https://www.facebook.com/Fonarte/" target="new"  style="color:#FFF"><span class="fa fa-facebook fa-1x"></span></a>   -->
            
            
        </div>
        
    
    </div>

</div>
 <!-- **************************** fin de redes sociales FRANJA NEGRA********************** -->   
    
    <div class="container">
    
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header" style="margin-top:3px;margin-bottom: 3px;">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" style="margin-top: 4%;">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="" href="<?php echo $ruta_absoluta; ?>index"><img src="<?php echo $ruta_absoluta; ?>img/fonarte-logo.png" width="95" height="80" alt="fonarte" /></a>
            <!--a class="navbar-brand" href="index.php">Fonartelatino</a-->
        </div>
        
        
        
        <!-- inicio de menu -->
        <div class="collapse navbar-collapse tipografia" id="bs-example-navbar-collapse-1" >
            <ul class="nav navbar-nav navbar-right color_menu" style="margin-top: 25px;" >
            
<!-- ====no llevan el .php por que tienen una regla de SEO en .htaccess -->
<?php
//echo $_SERVER["PHP_SELF"] ;
?>
                <li>
                    <a href="<?php echo $ruta_absoluta; ?>index"  class="tipografia_menu">HOME</a>
                </li>
               
               
               <li>
                    <a href="<?php echo $ruta_absoluta; ?>otros"  class="tipografia_menu">MERCHANDISING</a>
                </li>
                          
               <!-- ====no llevan el .php por que tienen una regla de SEO en .htaccess -->
               <li>
                    <a href="<?php echo $ruta_absoluta; ?>fonarte_latino"  class="tipografia_menu">FONARTE LATINO</a> 
                </li>
                
                <!-- ====no llevan el .php por que tienen una regla de SEO en .htaccess -->
                <!--li>
                    <a href="<?php echo $ruta_absoluta; ?>catalogo"  class="tipografia_menu">CAT&Aacute;LOGO</a>
                </li-->
                
    
<!-- inicio de  Opcion2 catalogo-->  
<li class="dropdown" >

    <a href="#" class="dropdown-toggle tipografia_menu" data-toggle="dropdown">CAT&Aacute;LOGO <b class="caret"></b></a>
<ul class="dropdown-menu" style=" max-height:300px; overflow:auto;">


    <?php
        do
        {
          if ($row_CategoriaSub['nombre'] != "Firelink") {
            
          
            ?><li><a href="<?php echo $ruta_absoluta; ?>catalogo.php?categoria=<?php echo $row_CategoriaSub['id']; ?>"><?php echo $row_CategoriaSub['nombre'];  ?></a></li><?php
          }
        }while($row_CategoriaSub = mysql_fetch_assoc($CategoriaSub) );
    ?>
    
</ul>
</li>
<!-- fin de  Opcion2 catalogo-->

                
                
<!-- ====no llevan el .php por que tienen una regla de SEO en .htaccess -->
<!-- inicio de  Opcion2 desplegable-->
<li class="dropdown" >

    <a href="#" class="dropdown-toggle tipografia_menu" data-toggle="dropdown">G&Eacute;NEROS <b class="caret"></b></a>
<ul class="dropdown-menu" style=" max-height:300px; overflow:auto;">


    <?php
        do
        {
            ?><li><a href="<?php echo $ruta_absoluta; ?>generos.php?genero=<?php echo $row_Generos['id']; ?>"><?php echo utf8_encode($row_Generos['nombre']);  ?></a></li><?php
        }while($row_Generos = mysql_fetch_assoc($Generos));
    ?>
    
</ul>
</li>
                <!-- fin de  Opcion2 desplegable-->
     
         
             
                
<li>
	<a href="<?php echo $ruta_absoluta; ?>contacto"  class="tipografia_menu">CONTACTO</a>
</li>

                    
<li>
    <form class="navbar-form" role="" action="<?php echo $ruta_absoluta; ?>busqueda.php" method="get">
    <input type="text" class="form-control" placeholder="Buscar artista" name="artista" id="id_buscar" style="width:70%" required="required"> 
    <button type="submit" class="btn btn-default"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
</li>           
				
        
               
                
                <!-- inicio de  Opcion2 desplegable-->
                <!--li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Menu <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#">Opcion 1</a>
                        </li>
                        <li>
                            <a href="#">Opcion 2</a>
                        </li>
                        <li>
                            <a href="#">Opcion 3t</a>
                        </li>
                    </ul>
                </li-->
                <!-- fin de  Opcion2 desplegable-->
                
                
                
              	
                

               <!-- fin de  USUARIO-->
               
               
            </ul>
        </div>
        <!-- fin de menu -->
        
        
    </div>
    <!-- /.container -->
</nav>
<?php
mysql_free_result($Generos);

?>
