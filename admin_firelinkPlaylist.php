<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php require_once('Connections/conexion.php'); ?>
<?php

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php?alerta=3";
if (!((isset($_SESSION['MM_Username_Panel'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username_Panel'], $_SESSION['MM_UserGroup_Panel'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
 
  ?><script type="text/javascript">window.location="<?php echo $MM_restrictGoTo ?>";</script><?php
  exit;
}
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
$query_Productos = "SELECT
productos.id as id_tabla,
productos.sku,
productos.id_fonarte,
productos.artista,
productos.album,
productos.genero,
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
productos.clave_precio,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
productos.prendido,
precios.precio,
precios.id
FROM
productos
LEFT JOIN categoria ON categoria.id = productos.categoria

LEFT JOIN precios ON precios.clave = productos.clave_precio
WHERE productos.prendido=1 and productos.categoria = 5

";
$Productos = mysql_query($query_Productos, $conexion) or die(mysql_error());
$row_Productos = mysql_fetch_assoc($Productos);
$totalRows_Productos = mysql_num_rows($Productos);
?>
<?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
    <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Playlist</title>
  
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

    <?php include("menu_admin.php"); ?>

    <!-- Page Content -->
    <div class="container">
		
         <?php include("pinta_alerta.php"); ?>
        <!-- Inicio de titulo de la pagina -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header tipografia2"><span class="glyphicon glyphicon-cd"></span>&nbsp;Productos
              <small>&nbsp;</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
               <i class="icon-large icon-amazon"></i>
               
               
               <!-- ======================inicio cuerpo ======================================= -->              
<div class="dataTable_wrapper">
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
 <tr style="background-color: #E6E6E6;" class="letra_admin_prod" >
    <td>&nbsp;#&nbsp;</td>
    <td>&nbsp;</td>
   <td>SKU</td>
   <td>CLAVE</td>
   <td>PRECIO</td>
   <td>ARTISTA</td>
   <td>ALBUM</td>
   <td>GENERO</td>
   <td>CATEGORIA</td>
   <td><i class="fa fa-spotify fa-1x" aria-hidden="true"></i></td>
   <td><i class="fa fa-apple fa-1x" aria-hidden="true"></i></td>
   <td><i class="fa fa-font fa-1x" aria-hidden="true"></i></td>  
   <td><i class="fa fa-google fa-1x" aria-hidden="true"></i></td>
   <td><i class="fa fa-copyright fa-1x" aria-hidden="true"></i></td>
   <td><i class="fa fa-youtube-play fa-1x" aria-hidden="true"></i></td>
   <td><i class="fa fa-delicious fa-1x" aria-hidden="true"></i></td>
   <td><i class="fa fa-tumblr fa-1x" aria-hidden="true"></i></td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
</tr>
</thead>
<tbody>

 <?php do { ?>

     <tr class="letra_admin_prod2">
       <td><?php echo $row_Productos['id_tabla']; ?></td>
       <td><img src="<?php echo $row_Productos['ruta_img']; ?>" class="img-rounded" alt="" width="40" height="40"></td>
     <td><?php echo $row_Productos['sku']; ?></td>
     <td><?php echo $row_Productos['id_fonarte']; ?></td>
     <td><?php echo "$".$row_Productos['precio'].".00"; ?></td>
     <td><?php echo utf8_encode($row_Productos['artista']); ?></td>
     <td><?php echo utf8_encode($row_Productos['album']); ?></td>
	<?php
    mysql_select_db($database_conexion, $conexion);
    $query_Genero = "select * from genero where id=".$row_Productos['genero'];  
    $Genero = mysql_query($query_Genero, $conexion) or die(mysql_error());
    $row_Genero = mysql_fetch_assoc($Genero);
    $totalRows_Genero = mysql_num_rows($Genero);
    ?>
     <td><?php echo utf8_encode($row_Genero['nombre']); ?></td>
     <td><?php echo utf8_encode($row_Productos['cat_nombre']); ?></td>
     <?php
	 //si tiene link de spootify, pone una palomita, de lo contrario no pone nada
	 if($row_Productos['spotify']!=''){ $spo="<i class='fa fa-check' aria-hidden='true'></i>"; }
	 else { $spo=''; }
	 
	 //si tiene link de itunes, pone una palomita, de lo contrario no pone nada
	 if($row_Productos['itunes']!=''){ $itu="<i class='fa fa-check' aria-hidden='true'></i>"; }
	 else { $itu=''; }
	 
	 //si tiene link de amazon, pone una palomita, de lo contrario no pone nada
	 if($row_Productos['amazon']!=''){ $ama="<i class='fa fa-check' aria-hidden='true'></i>"; }
	 else { $ama=''; }
	 
	 //si tiene link de amazon, pone una palomita, de lo contrario no pone nada
	 if($row_Productos['google']!=''){ $goo="<i class='fa fa-check' aria-hidden='true'></i>"; }
	 else { $goo=''; }

   if($row_Productos['claro']!=''){ $cla="<i class='fa fa-check' aria-hidden='true'></i>"; }
   else { $cla=''; }

   if($row_Productos['youtube']!=''){ $you="<i class='fa fa-check' aria-hidden='true'></i>"; }
   else { $you=''; }

   if($row_Productos['deezer']!=''){ $dee="<i class='fa fa-check' aria-hidden='true'></i>"; }
   else { $dee=''; }

   if($row_Productos['tidal']!=''){ $tid="<i class='fa fa-check' aria-hidden='true'></i>"; }
   else { $tid=''; }
	 
	 ?>
     <td><?php echo $spo; ?></td>
     <td><?php echo $itu; ?></td>
     <td><?php echo $ama; ?></td>
     <td><?php echo $goo; ?></td>
     <td><?php echo $cla; ?></td>
     <td><?php echo $you; ?></td>
     <td><?php echo $dee; ?></td>
     <td><?php echo $tid; ?></td>
 
     <td  style="cursor:pointer"  onclick="window.open('admin_ver_producto.php?id_producto=<?php echo $row_Productos['id_tabla']; ?>','_blank')";><i class="fa fa-eye" aria-hidden="true"></i></td>
     
     <td data-toggle="modal" data-target="#borra_producto" onclick="carga_modal_1(<?php echo  $row_Productos['id_tabla']; ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i></td>
     
     </tr>
     <?php } while ($row_Productos = mysql_fetch_assoc($Productos)); ?>

</tbody>
</table>
</div>

 <!-- ======================fin cuerpo ======================================= -->
 
 <!-- inicio de Modal -->
<div class="modal fade" id="borra_producto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenido_borra_prod">
      
      
      
    </div>
  </div>
</div>
 <!-- fin de Modal -->
 
 
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->

        <hr>

       

    </div>
    <!-- /.container -->


<?php include("pie_admin.php"); ?>


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


<!-- ************************ INICIO DE LIBRERIAS PARA LAS TABLAS DINAMICAS ********************* -->
    <!-- jQuery -->
<script src="tablas_dinamicas/jquery.min.js"></script>
    <!-- Metis Menu Plugin JavaScript -->
<script src="tablas_dinamicas/metisMenu.min.js"></script>
    <!-- DataTables JavaScript -->
<script src="tablas_dinamicas/jquery.dataTables.min.js"></script>
<script src="tablas_dinamicas/dataTables.bootstrap.min.js"></script>
	<!-- DataTables Responsive CSS -->
    <link href="tablas_dinamicas/dataTables.responsive.css" rel="stylesheet">  
     <!-- DataTables CSS -->
    <link href="tablas_dinamicas/dataTables.bootstrap.css" rel="stylesheet">
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>
     
<!-- ************************ FIN DE LIBRERIAS PARA LAS TABLAS DINAMICAS ********************* -->


<script>
/* inicio modal edita_categoria*/
function carga_modal_1(id_producto)
{
	//alert(id_cateoria+'---')
	$( "#contenido_borra_prod" ).load( "ajax_contenido_borra_prod.php?id_producto="+id_producto);
}
/* fin modal edita_categoria*/

</script>



</html>
<?php
mysql_free_result($Productos);
?>
