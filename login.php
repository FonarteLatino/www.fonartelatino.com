<?php 
if (!isset($_SESSION)) {
  session_start();
}
require_once('Connections/conexion.php'); ?>
<?php
include_once("alertas.php");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
?>
<?php
// *** Validate request to login to this site.


$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['usr'])) {
  $loginUsername=$_POST['usr'];
  $password=$_POST['psw'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "redirecciona.php?alerta=1";
  $MM_redirectLoginFailed = "login.php?alerta=2";
  $MM_redirecttoReferrer = false;
  mysqli_select_db($conexion,$database_conexion);
  
  $LoginRS__query="SELECT * FROM usuarios WHERE usr='".$loginUsername."' AND psw='".$password."'"; 
   
  $LoginRS = mysqli_query($conexion,$LoginRS__query );
  $loginFoundUser = mysqli_num_rows($LoginRS);
  //********************PASO 2 SESION --- agregamos la siguiente linea para imprimir todo el registro
  	$row_LoginRS = mysqli_fetch_array($LoginRS);
    
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	//if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username_Panel'] = $loginUsername;
    $_SESSION['MM_UserGroup_Panel'] = $loginStrGroup;	 
		//****PASO 3 SESION --- agregamos la siguiente linea para crear el arreglo de sesion y le asinamos un nombre	
	$_SESSION['USUARIO'] = $row_LoginRS;   
     

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }

	?><script type="text/javascript">window.location="<?php echo $MM_redirectLoginSuccess; ?>";</script><?php
  }
  else {
	?><script type="text/javascript">window.location="<?php echo $MM_redirectLoginFailed; ?>";</script><?php
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Iniciar Sesion</title>
  
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


    <!-- Page Content -->
    <div class="container">
		
         <?php include("pinta_alerta.php"); ?>
        <!-- Inicio de titulo de la pagina -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header tipografia2">Fonartelatino
                    <small>&nbsp;</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
               
		<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
        <script>
			$(document).ready(function()
			{
				$("#myModal").modal("show");
			});
        </script>




               <!-- Button trigger modal -->
               <center>
               <a href="index.php">
<button type="button" class="btn btn-primary btn-lg">
  <span class="glyphicon glyphicon-home"></span>&nbsp;Home
</button>
	</a>

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  <span class="glyphicon glyphicon-log-in"></span>&nbsp;Iniciar Sesion
</button>
</center>

<center>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 60%;">
    
    <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" role="form">
    
    <!--=======================cabecera -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <center><h4 class="modal-title" id="myModalLabel"><img src="img/fonarte-logo.png" width="95" height="80" alt="logo"></h4></center>
      </div>
      <div class="modal-body">
        
        
        

<div class="row">
  <div class="col-sm-12">
        <div class="form-group">
        <label><span class="glyphicon glyphicon-user"></span>&nbsp;Usuario:</label>
        <input type="text" class="form-control" id="" name="usr">
        </div>
  </div>
</div>

<div class="row">  
  <div class="col-sm-12">
        <div class="form-group">
        <label><span class="glyphicon glyphicon-lock"></span>&nbsp;Contrase&ntilde;a:</label>
        <input type="password" class="form-control" id="" name="psw">
        </div>
  </div>
</div>


    
  
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Entrar</button>
      </div>
      
      </form>
      
    </div>
  </div>
</div>
</center>



               
               
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->

      

    </div>
    <!-- /.container -->

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
