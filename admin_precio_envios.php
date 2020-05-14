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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
	$insertSQL = sprintf("INSERT INTO precios (clave, precio) VALUES (%s, %s)",
	GetSQLValueString($_POST['clave'], "text"),
	GetSQLValueString($_POST['precio'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	
	$insertGoTo = "admin_precios.php?alerta=5";
	if (isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	?><script type="text/javascript">window.location="<?php echo $insertGoTo ?>";</script><?php
}


mysqli_select_db($conexion,$database_conexion);
$query_PreciosEnvios = "SELECT * FROM envios";
$PreciosEnvios = mysqli_query($conexion,$query_PreciosEnvios) or die(mysqli_error($conexion));
$row_PreciosEnvios = mysqli_fetch_assoc($PreciosEnvios);
$totalRows_PreciosEnvios = mysqli_num_rows($PreciosEnvios);


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

    <title>Fonarte Latino | Precios Envios</title>
  
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
                <h1 class="page-header tipografia2"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>&nbsp;Precios Envios
                    <small>&nbsp;</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
               
  <h3 class="tipografia2">&nbsp;</h3>             
<div class="row">
    <!-- inicio de formulario de agregar genero -->
    <!--div class="col-sm-4">
        <form class="letra_admin_prod2" method="post" name="form1" action="<?php echo $editFormAction; ?>">
        
        <div class="form-group">
        <label>Clave:</label>
        <input type="text" class="form-control" name="clave" id="" required>
        </div>
        
        <div class="form-group">
        <label>Precio:</label>
        <input type="number" class="form-control" name="precio" id="" required>
        </div>
		<input type="hidden" name="MM_insert" value="form1">
        <button type="submit" class="btn btn-default"> <i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Agregar</button>
        </form>
    
    </div-->
    <!-- fin de formulario de agregar genero -->
    
    
    <!-- inicio de tabla de generos -->
    <div class="col-sm-12">
    
    
    <!-- ======================inicio cuerpo ======================================= -->              
<div class="dataTable_wrapper">
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
 <tr style="background-color: #E6E6E6;" class="letra_admin_prod" >
    <td>&nbsp;#&nbsp;</td>
   <td>Region</td>
   <td>Precio</td>
  <td>Descripcion</td>
   <td>&nbsp;</td>
</tr>
</thead>
<tbody>

	<?php do { 
	

		
	?>
    <tr class="letra_admin_prod2">
        <td><?php echo $row_PreciosEnvios['id']; ?></td>
        <td><?php echo $row_PreciosEnvios['region']; ?></td>
         <td><?php echo "$".$row_PreciosEnvios['precio'].".00"; ?></td>
         <td><?php echo utf8_encode($row_PreciosEnvios['descripcion']); ?></td>
        <td data-toggle="modal" data-target="#edita_precio_envio" onclick="carga_modal_1(<?php echo $row_PreciosEnvios['id'] ?>)"><i class="fa fa-pencil" aria-hidden="true"></i></td>
    </tr>
    <?php } while ($row_PreciosEnvios = mysqli_fetch_assoc($PreciosEnvios)); ?>

</tbody>
</table>
</div>

 <!-- ======================fin cuerpo ======================================= -->
    
    
    </div>
    <!-- fin de tabla de generos -->
</div>
               
               



<!-- inicio de Modal -->
<div class="modal fade" id="edita_precio_envio" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenido_precio_envio">
      
      
      
    </div>
  </div>
</div>
 <!-- fin de Modal -->
 
 
 <script>
/* inicio modal edita_categoria*/
function carga_modal_1(id_precio_envio)
{
	//alert(id_precio_envio+'---')
	$( "#contenido_precio_envio" ).load( "ajax_contenido_precio_envio.php?id_precio_envio="+id_precio_envio);
}
/* fin modal edita_categoria*/

</script>

 
 
 
 
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
mysqli_free_result($PreciosEnvios);


?>
