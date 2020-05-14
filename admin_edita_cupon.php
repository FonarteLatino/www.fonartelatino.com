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



mysqli_select_db($conexion,$database_conexion);
$query_cupon2 = "SELECT * FROM cupon where codigo='".$_GET['cupon']."' and estatus='DISPONIBLE'";
$cupon2 = mysqli_query($conexion,$query_cupon2) or die(mysqli_error($conexion));
$row_cupon2 = mysqli_fetch_assoc($cupon2);
$totalRows_cupon2 = mysqli_num_rows($cupon2);


if ((isset($_POST["edita_cupon"])) && ($_POST["edita_cupon"] == 1)) 
{
		//echo "<br>Disponibles nuevos: ".$_POST['disponibles']." disponibles viejo: ".$_POST['disponibles_old'];
		//echo "<br><br>";
		
		
	//SI BAJA EL NUMERO DE CUPONES CREADOS, BORRA LA DIFERENCIA
	if($_POST['disponibles']<$_POST['disponibles_old'])
	{
		$num_eliminar=$_POST['disponibles_old']-$_POST['disponibles'];
		
		$deleteSQL = sprintf("DELETE FROM cupon WHERE codigo=%s and estatus='DISPONIBLE' limit ".$num_eliminar,
		GetSQLValueString($_POST['codigo_old'], "text"));

		mysqli_select_db($conexion,$database_conexion);
		$Result1 = mysqli_query($conexion,$deleteSQL) or die(mysqli_error($conexion));
		
	}
	//SI SUBE EL NUMERO DE CUPONES CREADOS, EDITA LOS YA EXISTENTES Y CREA LOS RESTANTES
	if($_POST['disponibles']>$_POST['disponibles_old'])
	{
		$num_nuevos=$_POST['disponibles']-$_POST['disponibles_old'];
		
		for($i=1;$i<=$num_nuevos;$i++)//numero de cumpones creados
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
			$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
			
		}
	}
	//SI EL NUMERO DE CUPONES NO LO MODIFICA, SOLO LOS EDITA
	
	$updateSQL = sprintf("UPDATE cupon SET codigo=%s, medida=%s, descuento=%s, vencimiento=%s, mas_de=%s WHERE codigo=%s AND estatus='DISPONIBLE'" ,
	GetSQLValueString($_POST['codigo'], "text"),
	GetSQLValueString($_POST['medida'], "text"),
	GetSQLValueString($_POST['descuento'], "int"),
	GetSQLValueString($_POST['vencimiento'], "date"),
	GetSQLValueString($_POST['mas_de'], "int"),
	GetSQLValueString($_POST['codigo_old'], "text"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	
	?><script type="text/javascript">window.location="admin_cupon.php?alerta=6";</script><?php
	
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
                    <small><?php echo $_GET['cupon']; ?></small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
        
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
                
         <br>      




 <form class="form-horizontal typ" method="post" name="" action="admin_edita_cupon.php" style="font-size:12px;">
 
<div class="modal-body">

<div class="row">
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Codigo</p>
    <input type="text" class="form-control" name="codigo" id="id_codigo" value="<?php echo $row_cupon2['codigo']; ?>" placeholder="">
    <input type="hidden" class="form-control" name="codigo_old" id="" value="<?php echo $row_cupon2['codigo']; ?>" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>    
    
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Medida de descuento</p>
        <select class="form-control" name="medida" id="id_medida">
        	<?php
			if($row_cupon2['medida']=='PESOS')
			{
				?>
                <option value="PESOS">$</option>
            	<option value="PORCENTAJE">%</option>
                <?php
			}
			else
			{
				?>        
                <option value="PORCENTAJE">%</option>
                <option value="PESOS">$</option>
                <?php
			}
			?>

        </select>
        <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>   
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Descuento</p>
    <input type="number" class="form-control" name="descuento" id="id_descuento" value="<?php echo $row_cupon2['descuento']; ?>"  placeholder="">
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
    <input type="number" class="form-control" name="mas_de" id="id_mas_de" placeholder="" value="<?php echo $row_cupon2['mas_de']; ?>">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Cupones disponibles</p>
    <input type="hidden" value="<?php echo $totalRows_cupon2; ?>" name="disponibles_old">
    <input type="number" class="form-control" name="disponibles" id="id_disponibles" value="<?php echo $totalRows_cupon2; ?>"  placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div> 
</div>

<input type="hidden" name="edita_cupon" value="1">


 
</div>

   <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
        <button type="submit" class="btn btn-primary" id="id_btn_crear"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;Editar</button>
    </div>
      
 </form>  







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
    
    <script src="js/valida_cupon_edit.js"></script>
    
    
    
     
   
<?php
/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>

</body>





</html>
