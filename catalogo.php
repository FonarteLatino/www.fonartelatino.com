 <?php require_once('Connections/conexion.php'); ?>
<?php

include_once("zebra_pagination/Zebra_Pagination.php");



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
 


//si existe una busqueda por letra
if(isset($_GET['letra']))
{
	// paso 1/7 generas query
	mysql_select_db($database_conexion, $conexion);
	$query_ProductosPagination = "SELECT * FROM productos where prendido=1 and artista like '".$_GET['letra']."%'";
	$ProductosPagination = mysql_query($query_ProductosPagination, $conexion) or die(mysql_error());
	$row_ProductosPagination = mysql_fetch_assoc($ProductosPagination);
	$totalRows_ProductosPagination = mysql_num_rows($ProductosPagination);
	// paso 2/7 asignas cuatos resultados se veran por pagina
	$resultados=30;
	//paso 3/7 creamos una instancia del objeto Zebra_Pagination
	$paginacion= new Zebra_Pagination();
	//paso 4/7 asignamos cuantos registros totales existen
	$paginacion->records($totalRows_ProductosPagination);
	//paso 5/7 asignamos la variale del paso 2 para decirle cuantos registros por pagina
	$paginacion->records_per_page($resultados);
	$inicio=(($paginacion->get_page()-1)*$resultados);
	$fin=$resultados;



	mysql_select_db($database_conexion, $conexion);
	$query_Productos = "SELECT
	productos.id,
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
	WHERE productos.prendido=1 and artista like '".$_GET['letra']."%'
	 ORDER BY `productos`.`artista` ASC
	limit ".$inicio.",".$fin;
	$Productos = mysql_query($query_Productos, $conexion) or die(mysql_error());
	$row_Productos = mysql_fetch_assoc($Productos);
	$totalRows_Productos = mysql_num_rows($Productos);
}
if(isset($_GET['categoria']) or $_GET['letra']==1)
{
	   if(!isset($_GET['categoria']))
       {
            $_GET['categoria']=1;
       }
		// paso 1/7 generas query
		mysql_select_db($database_conexion, $conexion);
		$query_ProductosPagination = "SELECT * FROM productos where categoria=".$_GET['categoria']." and prendido=1";
		$ProductosPagination = mysql_query($query_ProductosPagination, $conexion) or die(mysql_error());
		$row_ProductosPagination = mysql_fetch_assoc($ProductosPagination);
		$totalRows_ProductosPagination = mysql_num_rows($ProductosPagination);
		// paso 2/7 asignas cuatos resultados se veran por pagina
		$resultados=30;
		//paso 3/7 creamos una instancia del objeto Zebra_Pagination
		$paginacion= new Zebra_Pagination();
		//paso 4/7 asignamos cuantos registros totales existen
		$paginacion->records($totalRows_ProductosPagination);
		//paso 5/7 asignamos la variale del paso 2 para decirle cuantos registros por pagina
		$paginacion->records_per_page($resultados);
		$inicio=(($paginacion->get_page()-1)*$resultados);
		$fin=$resultados;



	mysql_select_db($database_conexion, $conexion);
	$query_Productos = "SELECT
	productos.id,
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
	WHERE productos.categoria=".$_GET['categoria']." and productos.prendido=1
	 ORDER BY `productos`.`artista` ASC
	limit ".$inicio.",".$fin;  
	$Productos = mysql_query($query_Productos, $conexion) or die(mysql_error());
	$row_Productos = mysql_fetch_assoc($Productos);
	$totalRows_Productos = mysql_num_rows($Productos);
}
?>
 <?php include("alertas.php"); ?>

<!DOCTYPE html>
<html lang="es">

<head>
 	<link rel="icon" type="image/png" href="https://www.fonartelatino.com/img/favicon.png" />
    <meta charset="ISO-8859-1" />


    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

                
    <title>C&aacute;talogo | Fonarte Latino </title>
  
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
                <?php
				if(isset($_GET['letra']))
				{
					?><p class="page-header">C&aacute;talogo&nbsp;<small>&nbsp;</small></p><?php
				}
				else
				{
					//muestra categoria correspondiente
					mysql_select_db($database_conexion, $conexion);
					$query_CategoriaSub = "SELECT * FROM categoria WHERE id=".$_GET['categoria'];
					$CategoriaSub = mysql_query($query_CategoriaSub, $conexion) or die(mysql_error());
					$row_CategoriaSub = mysql_fetch_assoc($CategoriaSub);
					$totalRows_CategoriaSub = mysql_num_rows($CategoriaSub);
					?><p class="page-header">C&aacute;talogo&nbsp;&nbsp;<small><i><?php echo $row_CategoriaSub['nombre']; ?></i></small></p><?php
				}
				
				?>
                
                    
                </div>
            </div> 
        </div>
        </div>
        <!-- Fin de titulo de la pagina -->

<div class="container">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12" style="margin-top:20px;">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
              
               

		<?php include_once("busca_alfabeto.php"); ?>
               
               
       
          
          <?php
		  if($totalRows_Productos==0)//no encontro resultados
		  {
			  ?><h4 class="tipografia2">No se encontraron resultados.</h4><?php
		  }
		  else//si encontro resultados
		  {
			?>
            
<!-- =========================== inicio de muestra catalogo =========================== -->  
<h4 class="tipografia2" style="margin-top:15px;">Resultados: <?php echo $totalRows_ProductosPagination; ?></h4>

<div class="row">
<?php
do
{
?>


<div class="col-md-2 img-portfolio" style="min-height:230px;"> 
	<!-- muesta la imagen -->
	<?php
    //si no tiene imagen le asigna una de base
	
    if($row_Productos['ruta_img']==''){ $ruta_caratula="img/caratulas/muestra.jpg"; }
    else{ $ruta_caratula=$row_Productos['ruta_img']; }
    ?> 
    

    <?php

	//inicio de genera URL SEO

	$url=$row_Productos['artista']."-".$row_Productos['album'];//une las dos con un guion medio
	
	$para_buscar = " AÀÁÂÃÄÅàáâãäåOÒÓÔÕÖØòóôõöøEÈÉÊËèéêëÇçIÌÍÎÏìíîïUÙÚÛÜùúûüÿÑñBCDFGHJKLMNPQRSTVWXYZ";
	$para_remplazar   = "_aaaaaaaaaaaaaoooooooooooooeeeeeeeeeCciiiiiiiiiuuuuuuuuuynnbcdfghjklmnpqrstvwxyz";
	$url_seo_final = strtr($url,$para_buscar,$para_remplazar);
	
	//fin de genera URL SEO
						
						
	?>
    
    <a href="producto_detalle/<?php echo $row_Productos['id'] ?>/<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>"   alt="" ></a>
	 <!--a href="producto_detalle.php?id_producto=<?php echo $row_Productos['id'] ?>&url=<?php echo $url_seo_final; ?>"> <img class="img-responsive img-hover img-rounded" src="<?php echo $ruta_caratula; ?>"   alt="" ></a-->
    	
    <!-- muestra la descripcion del producto -->
    <?php
	$artista_2=substr($row_Productos['artista'], 0, 20);  // los primeros 20 caracteres de ARTISTA
	$album_2=substr($row_Productos['album'], 0, 20);  // los primeros 20 caracteres de ALBUM
	?>
    <p class="tipografia_catalogo"><strong><?php echo utf8_encode($artista_2); ?></strong><br><?php echo utf8_encode($album_2); ?></p>
    
</div>


<?php	
}while($row_Productos = mysql_fetch_assoc($Productos));

?>
</div>

 <!-- =========================== fin de muestra catalogo =========================== --> 
 <center> 
<?php 
// paso 7/7 con la siguiente funcion, genera la paginacion abajo de la tabla
$paginacion->render(); 
?>
</center>


            
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
<?php
mysql_free_result($Productos);
?>
