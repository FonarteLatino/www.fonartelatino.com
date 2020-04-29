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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


//inicio de crea el cupon
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
	for($i=1;$i<=$_POST['disponibles'];$i++)//numero de cumpones creados
	{
		$insertSQL = sprintf("INSERT INTO cupon (codigo, medida, descuento, vencimiento, mas_de, fecha_creacion, fecha_uso, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['codigo'], "text"),
		GetSQLValueString($_POST['medida'], "text"),
		GetSQLValueString($_POST['descuento'], "int"),
		GetSQLValueString($_POST['vencimiento'], "date"),
		GetSQLValueString($_POST['mas_de'], "int"),
		GetSQLValueString(date("Y-m-d"), "date"),
		GetSQLValueString("0000-00-00", "date"),
		GetSQLValueString("DISPONIBLE", "text"));
		
		mysqli_select_db($conexion,$database_conexion);
		$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error());
		
		$insertGoTo = "admin_cupon.php?alerta=205";
		if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		?><script type="text/javascript">window.location="<?php echo $insertGoTo; ?>";</script><?php
	}
}
//fin de crea el cupon


mysqli_select_db($conexion,$database_conexion);
$query_artistas = "SELECT distinct(artista) FROM productos order by artista asc";
$artistas = mysqli_query($conexion,$query_artistas) or die(mysqli_error());
$row_artistas = mysqli_fetch_assoc($artistas);
$totalRows_artistas = mysqli_num_rows($artistas);

mysqli_select_db($conexion,$database_conexion);
$query_Genero = "SELECT * FROM genero order by nombre asc";
$Genero = mysqli_query($conexion,$query_Genero) or die(mysqli_error());
$row_Genero = mysqli_fetch_assoc($Genero);
$totalRows_Genero = mysqli_num_rows($Genero);

mysqli_select_db($conexion,$database_conexion);
$query_Cupones = "select COUNT(codigo) as cantidad, fecha_creacion, codigo, medida, descuento, vencimiento, mas_de from cupon GROUP BY codigo order by fecha_creacion DESC"; 
$Cupones = mysqli_query($conexion,$query_Cupones) or die(mysqli_error());
$row_Cupones = mysqli_fetch_assoc($Cupones);
$totalRows_Cupones = mysqli_num_rows($Cupones);


if ((isset($_GET["delete"])) && ($_GET["delete"] == 1)) 
{
	$deleteSQL = sprintf("DELETE FROM cupon WHERE codigo=%s and estatus='DISPONIBLE'",
	GetSQLValueString($_GET['codigo_cupon'], "text"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$deleteSQL) or die(mysqli_error());
	
	?><script type="text/javascript">window.location="admin_cupon.php?alerta=7";</script><?php
	
}



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

    <title>Fonarte Latino | Cupon</title>
  
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
                <h1 class="page-header tipografia2"><i class="fa fa-ticket" aria-hidden="true"></i>&nbsp;Cupon
                    <small>&nbsp;</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
        
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
                
         <br>      



<!-- ==================== INICIO DE MODAL PARA AGREGAR UN CUPON DE DESCUENTO ========================== -->
<button type="button" class="btn btn-primary" style="background-color:#244e58; border:#244e58;" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Nuevo Cupon</button>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
 
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Nuevo cupon</h4>
</div>
  
  
  
  
  
  <div class="modal-body">    
 <!--div class="container" style="width:90%;padding-top: 3%; padding-bottom: 3%;"--> 
 <form class="form-horizontal tipografia2" method="post" name="form1" action="<?php echo $editFormAction; ?>" style="font-size:12px;">
     
<div class="row">
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Codigo</p>
    <input type="text" class="form-control" name="codigo" id="id_codigo" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>    
    
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Medida de descuento</p>
        <select class="form-control" name="medida" id="id_medida">
            <option value=""></option>
            <option value="PESOS">$</option>
            <option value="PORCENTAJE">%</option>
        </select>
        <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>   
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Descuento</p>
    <input type="number" class="form-control" name="descuento" id="id_descuento" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
</div>

<div class="row">
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Vencimiento</p>
    <input type="date" class="form-control" name="vencimiento" id="id_vencimiento" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Aplicar despues de cuantos productos</p>
    <input type="number" class="form-control" name="mas_de" id="id_mas_de" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Cupones disponibles</p>
    <input type="number" class="form-control" name="disponibles" id="id_disponibles" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div> 
</div>

<input type="hidden" name="MM_insert" value="form1">


 
 </div><!-- fin de body -->
 
 
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
        <button type="submit" class="btn btn-primary" id="id_btn_crear"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;Crear</button>
    </div>
      
 </form>     

    </div>
  </div>
</div>
<!-- ==================== FIN DE MODAL PARA AGREGAR UN CUPON DE DESCUENTO ========================== -->



<br><br><br>
<div class="dataTable_wrapper">
<table class="table table-striped table-bordered table-hover" id="dataTables-example" style="">
<thead>
 <tr style="background-color: #E6E6E6;" class="letra_admin_prod" >
 <td>FECHA DE CREACION</td>
   <td>CODIGO</td>
   <td>DESCUENTO</td>
   <td>VENCIMIENTO</td>
   <td>COMPRA MAS DE</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
</tr>
</thead>
<tbody>

 <?php 

 do { ?>

    <tr class="letra_admin_prod2">
    <td><?php echo $row_Cupones['fecha_creacion']; ?></td> 
        <td><?php echo $row_Cupones['codigo']; ?></td>
        <td><?php echo $row_Cupones['descuento']." (".$row_Cupones['medida'].")"; ?></td>
        <td><?php echo $row_Cupones['vencimiento']; ?></td>
        <td><?php echo "<i>".$row_Cupones['mas_de']."</i> PRODUCTOS"; ?></td>
        <?php
		
		mysqli_select_db($conexion,$database_conexion);
		$query_CuponesDisp = "select * FROM cupon where codigo='".$row_Cupones['codigo']."' and estatus='DISPONIBLE'";
		$CuponesDisp = mysqli_query($conexion,$query_CuponesDisp) or die(mysqli_error());
		$row_CuponesDisp = mysqli_fetch_assoc($CuponesDisp);
		$totalRows_CuponesDisp = mysqli_num_rows($CuponesDisp);
		
		?> 
        <td><?php echo "<i>".$totalRows_CuponesDisp."</i> DISPONIBLES DE <i>".$row_Cupones['cantidad']."</i>"; ?></td>  
        
        <td  style="cursor:pointer" onclick="location.href='admin_edita_cupon.php?cupon=<?php echo $row_Cupones['codigo']; ?>'";><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></td>
        
         
         <td  style="cursor:pointer" onclick="location.href='admin_cupon.php?delete=1&codigo_cupon=<?php echo $row_Cupones['codigo']; ?>'";><i class="glyphicon glyphicon-trash" aria-hidden="true"></i></td>
         

         
     </tr>
  <?php 

  } while ($row_Cupones = mysqli_fetch_assoc($Cupones)); ?>

</tbody>
</table>
</div>




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
    
    <script src="js/valida_cupon_new.js"></script>
    
    
    
     
   
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
mysqli_free_result($artistas);

mysqli_free_result($Genero);

mysqli_free_result($Cupones);


?>
