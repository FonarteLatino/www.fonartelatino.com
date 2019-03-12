<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); ?>
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

?>
<?php include_once("estilos.php"); ?>
<?php include_once("rutas_absolutas.php"); ?>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-49841128-1', 'auto');
  ga('send', 'pageview');
 
</script>


<nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation" style="background-color: #ffffff;border-color: #ffffff;">
<!-- **************************** inicio de redes sociales FRANJA NEGRA********************** -->
<div class="container" style="background-color:#000; width:100%;">

    <div class="row espacio_redessociales">
        
        <div class="col-sm-6 tipografia2" style="color:#FFF; font-size:12px;">
        
           <?php
		   
		   if(isset($_SESSION['USUARIO_ECOMMERCE']))
			{
				echo "Bienvenido: ".$_SESSION['USUARIO_ECOMMERCE']['nombre'];
			}
		   
		   ?>
        
        </div>
        
        
        
        
        <div class="col-sm-6" style="color:#FFF;">
            <!--a href=""  class="tipografia" style="color:#ffffff;"> Mi cuenta </a>
            <span class="glyphicon glyphicon-shopping-cart fa-1x" aria-hidden="true"></span-->
             <?php
		if(isset($_SESSION['CARRITO_TEMP']) or isset($_SESSION['USUARIO_ECOMMERCE']))
		{
			?><a href="<?php echo $ruta_absoluta; ?>carrito.php"  class="tipografia" style="color:#ffffff;"><span class="glyphicon glyphicon-shopping-cart fa-1x" aria-hidden="true"></span> <?php echo "(".$totalRows_Carrito.")" ?></a><?php
			
			

		}

		
		?>

            
            
             
          <a href="https://twitter.com/Fonarte" target="new"  style="color:#FFF"><span class="fa fa-twitter fa-1x"></span></a>
            &nbsp;&nbsp;<a href="https://www.instagram.com/fonarte/" target="new"  style="color:#FFF"><span class="fa fa-instagram fa-1x"></span></a>
            
            &nbsp;&nbsp;<a href="https://www.youtube.com/user/fonartelatino" target="new"  style="color:#FFF"><span class="fa fa-youtube fa-1x"></span></a>
            
            &nbsp;&nbsp;<a href="https://www.facebook.com/Fonarte/" target="new"  style="color:#FFF"><span class="fa fa-facebook fa-1x"></span></a>   
            
            
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
                <li>
                    <a href="<?php echo $ruta_absoluta; ?>catalogo"  class="tipografia_menu">CAT&Aacute;LOGO</a>
                </li>
                

                
                
<!-- ====no llevan el .php por que tienen una regla de SEO en .htaccess -->
<!-- inicio de  Opcion2 desplegable-->
<li class="dropdown" >

    <a href="#" class="dropdown-toggle tipografia_menu" data-toggle="dropdown">G&Eacute;NEROS <b class="caret"></b></a>
<ul class="dropdown-menu" style=" max-height:300px; overflow:auto;">


    <?php
        do
        {
            ?><li><a href="<?php echo $ruta_absoluta; ?>generos.php?genero=<?php echo $row_Generos['id']; ?>"><?php echo $row_Generos['nombre'];  ?></a></li><?php
        }while($row_Generos = mysql_fetch_assoc($Generos));
    ?>
    
</ul>
</li>
                <!-- fin de  Opcion2 desplegable-->
                
                
                
                
                <li>
                    <a href="<?php echo $ruta_absoluta; ?>contacto"  class="tipografia_menu">CONTACTO</a>
                </li>
                
                
				
    
     <div class="col-sm-3 col-md-3">
                <form class="navbar-form" role="" >

		  		<script  src="http://www.fonartelatino.com/jquery.js"></script>

                <!--  INICIO PARTE 2   -->
                <script type="text/javascript">
                $(document).ready(function()
                {
                $('#id_buscar').keyup(function()
                {
                var buscar=$('#id_buscar').val(); //declaramos las variables que vamos a mandar al siguiente php
                
                $('#search').load('<?php echo $ruta_absoluta; ?>js_despliega_art.php?buscar='+buscar);//enviamos las 2 variables
                });    
                });
                </script>  
                <!--    FIN PARTE 2   -->
        
                
                <div class="input-group">
                <input type="text" class="form-control" placeholder="Buscar" name="buscar" id="id_buscar"> 
                </div> 
                
               <div id="search" style=" max-height:200px; min-width: 160px; overflow:auto;position: absolute; background-color:#ffffff;"></div>
                
                </form>
                </div> 
          		
              
				
        
               
                
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
                
                
                
              	<!-- inicio de  USUARIO -->
                <?php
				if(isset($_SESSION['USUARIO']))
				{
				?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print_r($_SESSION['USUARIO']['nombre']); ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="salir.php">Cerrar Sesion</a>
                        </li>
                    </ul>
                </li>
                <?php	
				}
				?>
                

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
