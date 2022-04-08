<?php
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); 

?>
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
$id_producto_otro=$_GET['id_producto_otro'];







mysqli_select_db($conexion,$database_conexion);
$query_DetalleProducto = "SELECT
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
cat_otros.id as id_cat_otros,
precios.precio
FROM
productos_otros
INNER JOIN cat_otros ON productos_otros.tipo = cat_otros.id
INNER JOIN precios ON productos_otros.clave_precio = precios.clave
 WHERE productos_otros.id=".$id_producto_otro;
$DetalleProducto = mysqli_query($conexion,$query_DetalleProducto) or die(mysqli_error($conexion));
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
WHERE productos.prendido=1 and productos.genero=1
ORDER BY RAND()
limit 6";
$TePuedeInteresar = mysqli_query($conexion,$query_TePuedeInteresar) or die(mysqli_error($conexion));
$row_TePuedeInteresar = mysqli_fetch_assoc($TePuedeInteresar);
$totalRows_TePuedeInteresar = mysqli_num_rows($TePuedeInteresar);
/* ******************** fin de te puede interesar *************************** */





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

where productos_otros.id=".$id_producto_otro;
$Otros = mysqli_query($conexion,$query_Otros) or die(mysqli_error($conexion));
$row_Otros = mysqli_fetch_assoc($Otros);
$totalRows_Otros = mysqli_num_rows($Otros);






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
	GetSQLValueString('OTRO', "text"),
	GetSQLValueString(utf8_decode($_GET['artista']), "text"),
	GetSQLValueString(utf8_decode($_GET['album']." - ".$_POST['talla']), "text"),
	GetSQLValueString($_GET['precio'], "int"),
	GetSQLValueString(1, "int"),
	GetSQLValueString(date("Y-m-d"), "date"),
	GetSQLValueString(date("H:i:d"), "date"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	
	$redirecciona="producto_detalle_otro/".$_GET['id_producto']."/".$_GET['url_seo'];
	?><script type="text/javascript">window.location="<?php echo $redirecciona; ?>";</script><?php
	
	//header("Location: producto_detalle/".$_GET['id_producto']."/".$_GET['url_seo']);
	
}
/* ******************** fin de agrega al carrito *************************** */




?>
 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php //include_once("estilos_producto_detalle.php"); 
	
	?> 
    <link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Producto Detalle</title>
  
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
                    <p class="page-header">Detalle de Producto<small>&nbsp;</small></p>
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

                
            </div>
            
            
       <div class="col-md-6 img-portfolio">
            	
            	
        <div class="row tipografia2" style="background-color: #eee;">
            <div class="col-sm-6">
            <p style="font-size:22px; margin-top:10px;"><?php echo $row_DetalleProducto['nombre']; ?></p>
            <p style="font-size:18px;"><?php echo $row_DetalleProducto['artista']; ?></p>
            </div>
            <div class="col-sm-6">
            <?php
            if($row_DetalleProducto['estatus']=='ACTIVO')
            {
            ?> <h3 class="tipografia2" style="text-align:right; margin-top:15px;"><?php echo "$".$row_DetalleProducto['precio'].".00"; ?></h3><?php
            }
            ?>
        
            </div>
        </div>
        
        
		<?php
		//echo $row_DetalleProducto['id_cat_otros'];
		 
		if($row_DetalleProducto['tipo']==2 or $row_DetalleProducto['tipo']=='3')//es playera o sudadera
		{
			
				
			//inicio de genera URL SEO
			
			$artista=strtolower($row_Otros['artista']);//convierte la cadena en minusculas
			$album=strtolower($row_Otros['nombre']);//convierte la cadena en minusculas
			$url=$artista."-".$album;//une las dos con un guion medio
			$quita_esp=str_replace(" ","_",$url);//remplaza espacios por guion bajo
			$quita_a_acento=str_replace("�","a",$quita_esp);//remplaza � por a
			$quita_e_acento=str_replace("�","e",$quita_a_acento);//remplaza � por e
			$quita_i_acento=str_replace("�","i",$quita_e_acento);//remplaza � por i
			$quita_o_acento=str_replace("�","o",$quita_i_acento);//remplaza � por o
			$quita_u_acento=str_replace("�","u",$quita_o_acento);//remplaza � por u
			$quita_n_acento=str_replace("�","n",$quita_u_acento);//remplaza � por n
		
			$url_seo_final=$quita_n_acento;//url final
			
			//fin de genera URL SEO
		?>
		<form method="post" action="<?php echo $ruta_absoluta; ?>producto_detalle_otro.php?add_carrito=1&id_producto=<?php echo $row_DetalleProducto['id']; ?>&id_producto_otro=<?php echo $row_DetalleProducto['id']; ?>&url_seo=<?php echo $url_seo_final; ?>&artista=<?php echo utf8_encode(utf8_decode($row_Otros['artista'])); ?>&album=<?php echo utf8_encode(utf8_decode($row_Otros['nombre'])); ?>&precio=<?php echo $row_DetalleProducto['precio']; ?>&id_producto_fonarte=<?php echo $row_DetalleProducto['id_fonarte']; ?>">
        
		<div class="form-group tipografia2" style="margin-top:12px;">
		<label for="sel1">Talla:</label>
		<select class="form-control" id="sel1" name="talla">
		<?php
		if($row_DetalleProducto['s']==1){ ?><option value="S">S</option><?php	}
		if($row_DetalleProducto['m']==1){ ?><option value="M">M</option><?php }
		if($row_DetalleProducto['l']==1){ ?><option value="L">L</option><?php }
		?>
		</select>
		</div>
        <input type="submit" value="Agregar al carrito"  style="width:100px; height:33px; border:#244e58; background-color:#244e58; color:#ffffff; font-size:11px;"> 
		</form>
		<?php
		}
		?>

                <!-- ============== inicio de tiendas digitales====================== -->
                <div class="row" style="margin-top:5px;">
                
                <?php
					
					if($row_DetalleProducto['estatus']=='ACTIVO' and ($row_DetalleProducto['id_cat_otros']!=2 or $row_DetalleProducto['id_cat_otros']!=3) )//
					{
							
						//inicio de genera URL SEO
						
						$artista=strtolower($row_Otros['artista']);//convierte la cadena en minusculas
						$album=strtolower($row_Otros['nombre']);//convierte la cadena en minusculas
						$url=$artista."-".$album;//une las dos con un guion medio
						$quita_esp=str_replace(" ","_",$url);//remplaza espacios por guion bajo
						$quita_a_acento=str_replace("�","a",$quita_esp);//remplaza � por a
						$quita_e_acento=str_replace("�","e",$quita_a_acento);//remplaza � por e
						$quita_i_acento=str_replace("�","i",$quita_e_acento);//remplaza � por i
						$quita_o_acento=str_replace("�","o",$quita_i_acento);//remplaza � por o
						$quita_u_acento=str_replace("�","u",$quita_o_acento);//remplaza � por u
						$quita_n_acento=str_replace("�","n",$quita_u_acento);//remplaza � por n
					
						$url_seo_final=$quita_n_acento;//url final
						
						//fin de genera URL SEO
								
						if($row_DetalleProducto['id_cat_otros']!=3 and $row_DetalleProducto['id_cat_otros']!=2)
						{
							?>
      <div class="col-sm-3"><center><button type="button" onClick="location.href='<?php echo $ruta_absoluta; ?>producto_detalle_otro.php?add_carrito=1&id_producto=<?php echo $row_DetalleProducto['id']; ?>&id_producto_otro=<?php echo $row_DetalleProducto['id']; ?>&url_seo=<?php echo $url_seo_final; ?>&artista=<?php echo utf8_encode(utf8_decode($row_Otros['artista'])); ?>&album=<?php echo utf8_encode(utf8_decode($row_Otros['nombre'])); ?>&precio=<?php echo $row_DetalleProducto['precio']; ?>&id_producto_fonarte=<?php echo $row_DetalleProducto['id_fonarte']; ?>'" class="tipografia2" style="width:100px; height:33px; border:#244e58; background-color:#244e58; color:#ffffff; font-size:11px;">Agregar al carrito</button></center></div> <?php
						}
						
						
						
					}
					
				
				?>           
                </div>

                <!-- ============== fin de tiendas digitales====================== -->
            </div>
        </div>
        <!-- /.row -->
        
        
        
        
        
<!-- ====================== inicio de tabs ============================== -->        
<ul class="nav nav-tabs tipografia_tabs" style="margin-top:15px;">
    <li class="active"><a data-toggle="tab" href="#desc">Descripci&oacute;n</a></li>
    <!--li><a data-toggle="tab" href="#coment">Comentarios</a></li-->
</ul>

<div class="tab-content tipografia_tabs" style="border:1px solid #ddd; padding:20px;">
    <div id="desc" class="tab-pane fade in active">
        <p><?php echo $row_DetalleProducto['descripcion'] ?></p>
    </div>
    
    <!--div id="coment" class="tab-pane fade">
    <br>
        <p>Comentarios de ejemplo</p>
    </div-->
</div>
<!-- ====================== inicio de tabs ============================== -->  



<!-- ====================== inicio de te puede interesar ============================== --> 

<p class="subtitulo_carrusel_index" style="margin-top:25px;">TE PUEDE INTERESAR</p>
<div class="row">
<?php
do
{
	?>
	
	
<div class="col-md-2 img-portfolio">
	<!-- muesta la imagen -->
	<?php
    //si no tiene imagen le asigna una de base
	
    if($row_TePuedeInteresar['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_TePuedeInteresar['ruta_img']; }
    ?> 
    
      <?php
	//inicio de genera URL SEO
	$artista=strtolower($row_TePuedeInteresar['artista']);//convierte la cadena en minusculas
	$album=strtolower($row_TePuedeInteresar['album']);//convierte la cadena en minusculas
	$url=$artista."-".$album;//une las dos con un guion medio
	$quita_esp=str_replace(" ","_",$url);//remplaza espacios por guion bajo
	$sustituye1=str_replace("�","a",$quita_esp);//remplaza � por a
	$sustituye2=str_replace("�","e",$sustituye1);//remplaza � por e
	$sustituye3=str_replace("�","i",$sustituye2);//remplaza � por i
	$sustituye4=str_replace("�","o",$sustituye3);//remplaza � por o
	$sustituye5=str_replace("�","u",$sustituye4);//remplaza � por u
	$sustituye6=str_replace("�","A",$sustituye5);//remplaza � por A
	$sustituye7=str_replace("�","E",$sustituye6);//remplaza � por E
	$sustituye8=str_replace("�","I",$sustituye7);//remplaza � por I
	$sustituye9=str_replace("�","O",$sustituye8);//remplaza � por O
	$sustituye10=str_replace("�","U",$sustituye9);//remplaza � por U
	$sustituye11=str_replace("�","n",$sustituye10);//remplaza � por n
	$sustituye11=str_replace("�","N",$sustituye10);//remplaza � por N
	$sustituye12=str_replace(",","",$sustituye11);//remplaza , por nada
	$sustituye13=str_replace(".","",$sustituye12);//remplaza . por nada
	$sustituye14=str_replace("(","",$sustituye13);//remplaza ( por nada
	$sustituye15=str_replace(")","",$sustituye14);//remplaza ) por nada
	$url_seo_final=$sustituye15;//url final
	//fin de genera URL SEO
	?>
    
    <a href="<?php echo $ruta_absoluta ?>producto_detalle/<?php echo $row_TePuedeInteresar['id_prod']; ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_absoluta; ?><?php echo $ruta_caratula; ?>"  alt="" ></a>

    	
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_TePuedeInteresar['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_TePuedeInteresar['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo $artista_2; ?></strong><br><?php echo $album_2; ?></p>
    
</div>

	
	<?php
}while($row_TePuedeInteresar = mysqli_fetch_assoc($TePuedeInteresar));
?>
</div>

<!-- ====================== fin de te puede interesar ============================== --> 



               
              <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    
    
    <?php include("pie.php"); ?>
 


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
