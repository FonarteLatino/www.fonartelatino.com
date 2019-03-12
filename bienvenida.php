<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); ?>
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

   ?><script type="text/javascript">window.location="<?php echo $MM_restrictGoTo; ?>";</script><?php
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
$query_Pedidos = "SELECT * FROM pedido WHERE estatus>=2 order by id DESC";
$Pedidos = mysql_query($query_Pedidos, $conexion) or die(mysql_error());
$row_Pedidos = mysql_fetch_assoc($Pedidos);
$totalRows_Pedidos = mysql_num_rows($Pedidos);
?>
<?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Bienvenido</title>
  
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
                <h1 class="page-header"><i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;Ecommerce
                    <small>&nbsp;</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
  
<br><br>  
  
           <!-- ======================inicio tabla ======================================= -->              
<div class="dataTable_wrapper tipografia2">
<table class="table table-striped table-bordered table-hover" id="dataTables-example" >
<thead>
 <tr style="background-color: #E6E6E6; font-size:12px;" class="letra_admin_prod" >
    <td>#</td>
    <td># Pedido</td>
   <td>forma_pago</td>
   <td>$ Productos</td>
   <td>$ Envio</td>
   <td>$ Total</td>
   <td>Estatus</td>
   <td>	Fecha </td>
   <td style="text-align:center;"> Ticket </td>
</tr>
</thead>
<tbody >

	<?php
	$a=1;
	 do { ?>  
    <tr class="letra_admin_prod2" style="font-size:12px">
        <td><?php echo $a; ?></td>
         <td><?php echo $row_Pedidos['id']; ?></td>
        <td><?php echo $row_Pedidos['forma_pago']; if($row_Pedidos['forma_pago']=='PAYPAL') { ?>&nbsp;<i class="fa fa-paypal" aria-hidden="true"></i><?php } ?></td>
        <td><?php echo "$".$row_Pedidos['subtotal_productos'].".00"; ?></td>
        <td><?php echo "$".$row_Pedidos['precio_envio'].".00"; ?></td>
        <td><?php echo "$".$row_Pedidos['total'].".00"; ?></td>
        <?php
		if($row_Pedidos['estatus']==2){ $proceso='PENDIENTE'; $color="style='color:#F90;'";}
		else if($row_Pedidos['estatus']==3){ $proceso="PAGADO&nbsp;<i class='fa fa-check' aria-hidden='true'></i>"; $color="style='color:#244e58;'"; }
		else{ $proceso='DESCONOCIDO';  $color="style='color:#000000;'"; }
		?>
        <td <?php echo $color; ?>><?php echo $proceso; ?></td>
        <td><?php echo $row_Pedidos['fecha']." ".$row_Pedidos['hora'] ?></td>
        
        <td><center><button type="button" class="btn btn-default" data-toggle="modal" data-target="#ver_ticket" onclick="carga_modal_1(<?php echo $row_Pedidos['id'] ?>)"><span class="glyphicon glyphicon-list-alt"></span></button></center></td>
        

        
    </tr>
    <?php 
	$a=$a+1;
	} while ($row_Pedidos = mysql_fetch_assoc($Pedidos)); ?>

</tbody>
</table>
</div>

 <!-- ======================fin table ======================================= -->
 
 
 <!-- ===== inicio de modal de ver ticket ====== -->
<div class="modal fade" id="ver_ticket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenido_ticket">
     
     
     
    </div>
  </div>
</div>

<!-- ===== fin de modal de ver ticket ====== -->



 <script>
/* inicio modal rechazo*/
function carga_modal_1(id_pedido)
{
	//alert(id_usuario+'---')
	$( "#contenido_ticket" ).load( "ajax_contenido_ticket.php?id_pedido="+id_pedido);
}
/* fin modal rechazo*/

</script>

 
 
 
             
               
               <?php //print_r($_SESSION['USUARIO']); ?>
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->

       

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



</html>
<?php
mysql_free_result($Pedidos);
?>
