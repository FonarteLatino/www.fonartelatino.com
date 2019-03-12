<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); 

require_once('rutas_absolutas.php'); 

//SI YA EXISTE LA SESION DEL USUARIO ACTIVA, SE SALTA ESTE PASO Y MANDA A LA DIRECCIOND DE ENVIO
if(isset($_SESSION['USUARIO_ECOMMERCE']))
{
	?><script type="text/javascript">window.location="direcciones_envio.php";</script><?php
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
?>
<?php
// *** Validate request to login to this site.


$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['email'])) {
  $loginUsername=$_POST['email'];
  $password=$_POST['psw'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "direcciones_envio.php";
  $MM_redirectLoginFailed = "cuenta.php?alerta=2";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_conexion, $conexion);
  
  $LoginRS__query=sprintf("SELECT * FROM usuarios_ecommerce WHERE email=%s AND psw=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
   //********************PASO 2 SESION --- agregamos la siguiente linea para imprimir todo el registro
  	$row_LoginRS = mysql_fetch_array($LoginRS);
	
	
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	//if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username_Ecommerce'] = $loginUsername;
    $_SESSION['MM_UserGroup_Ecommerce'] = $loginStrGroup;	  
	//****PASO 3 SESION --- agregamos la siguiente linea para crear el arreglo de sesion y le asinamos un nombre	
	$_SESSION['USUARIO_ECOMMERCE'] = $row_LoginRS;   
	    

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
	
	
	//¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬ INICIO DE MODIFICA LOS PRODUCTOS A LA NUEVA VARIABLE SESION Y DESTRUYE LA SESION TEMPORAL
	$updateSQL = sprintf("UPDATE carrito set id_usr=%s WHERE id_usr=%s",
	GetSQLValueString($_SESSION['USUARIO_ECOMMERCE']['id'], "int"),
	GetSQLValueString($_SESSION['CARRITO_TEMP'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	$updateGoTo = "direcciones_envio.php";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	
	//INICIO DE BORRAMOS LA VARIABLE SESION TEMPORAL
	$_SESSION['CARRITO_TEMP'] = NULL;
	unset($_SESSION['CARRITO_TEMP']);
	//FIN DE BORRAMOS LA VARIABLE SESION TEMPORAL
	//¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬¬ FIN DE MODIFICA LOS PRODUCTOS A LA NUEVA VARIABLE SESION Y DESTRUYE LA SESION TEMPORAL
	
	
	?><script type="text/javascript">window.location="<?php echo $MM_redirectLoginSuccess; ?>";</script><?php
  }
  else {
	?><script type="text/javascript">window.location="<?php echo $MM_redirectLoginFailed; ?>";</script><?php
  }
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

    <title>Fonarte Latino | Cuenta</title>
  
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
    
		
        
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Iniciar Sesion<small>&nbsp;</small></p>
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
                 <?php include("pinta_alerta.php"); ?>
                 
                 <!-- ======================== INICIO DE PASOS ======================================== -->
<div class="row tipografia2">

<div class="col-sm-3">
<button type="button" class="btn btn-default"  onClick="location.href='carrito.php'" style=" text-align:center; color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px;border:2px solid #ffffff; width:100%;"><i class="fa fa-shopping-cart  fa-1x" aria-hidden="true"></i>&nbsp;Carrito&nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px; border:2px solid #ffffff; width:100%;"><i class="fa fa-lock fa-1x" aria-hidden="true"></i>&nbsp;Iniciar Sesi&oacute;n</button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px;background-color:#D8D8D8;  border:2px solid #ffffff; width:100%;"><i class="fa fa-share fa-1x" aria-hidden="true"></i>&nbsp;Direcci&oacute;n de Env&iacute;o</button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px;background-color:#D8D8D8;  border:2px solid #ffffff; width:100%;"><i class="fa fa-usd fa-1x" aria-hidden="true"></i>&nbsp;Pago</button>
</div>
  
</div>
<!-- ======================== FIN DE PASOS ======================================== -->

<br><br><br>


<div class="row tipografia2">

    <div class="col-sm-4">
        <div style="border:3px solid #ffffff;background-color: #eee; padding-left: 3%; padding-right: 3%;padding-bottom: 5%;padding-top: 5%;border-radius: 15px 15px 15px 15px;"><br>
            <h3 style="text-align:center;"> <span class="glyphicon glyphicon-user"></span>&nbsp;Iniciar Sesi&oacute;n</h3><br>
            <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" id="cuenta">  
            <div class="form-group" >
            <span>Correo Electronico:</span>
            <input type="text" name="email" class="form-control" id="email">
            </div>
            <div class="form-group">
            <span>Contrase&ntilde;a:</span>
            <input type="password" name="psw" class="form-control" id="pwd">
            </div>
            <!--div class="checkbox">
            <label><input type="checkbox"> Remember me</label>
            </div-->
            
            
            <script type="text/javascript" src="jquery.js"></script>   
        
            <!--  INICIO PARTE 2   -->
            <script type="text/javascript">
            $(document).ready(function()
            {
            $('#id_btn').click(function()
            {

            $('#registrate').load('js_registrate.php');//enviamos las 2 variables
            });    
            });
            </script>
            <!--    FIN PARTE 2   -->

            <button type="button" class="btn btn-default" id="id_btn" style="width: 100px;" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;Registrate</button>

            <button type="submit" class="btn btn-default" id="" style="color:#ffffff; background-color:#244e58; border:1px solid #244e58;width: 100px;"><i class="fa fa-sign-in" aria-hidden="true"></i>&nbsp;Entrar</button>
            </form><br><br><br> 
        </div>
    </div>
    
<!-- =============================================================================================== -->
	<div class="col-sm-8" id="registrate">
		
	</div>
</div>
                    
            
         <br><br><br><br><br>  
            
            
            
            
            
            
            
            
            
               
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    
     
    <?php include("pie.php"); ?>



    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/valida_registro.js"></script>

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
