<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('Connections/conexion.php'); 
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

    <title>Fonarte Latino | Configuraciones Home</title>
  
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
                <h1 class="page-header tipografia2"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Home
                    <small>&nbsp;</small>
            </div>
        </div>
        <!-- Fin de titulo de la pagina -->

        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 tipografia2">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
               <br><br>
<?php

//activa el TAB de LANZAMEINTOS
if(!isset($_GET['activa']) or $_GET['activa']==1) 
{ 
	$activa_lanzamientos="class='active'"; 
	$activa_lanzamientos2="in active"; 
}
else
{ 
	$activa_lanzamientos=""; 
	$activa_lanzamientos2=""; 
}


//activa el TAB de NOVEDADES
if(isset($_GET['activa']) and $_GET['activa']==2) 
{ 
	$activa_novedades="class='active'"; 
	$activa_novedades2="in active";
}
else
{ 
	$activa_novedades=""; 
	$activa_novedades2="";
}


//activa el TAB de DIA DE LA SEMANA
if(isset($_GET['activa']) and $_GET['activa']==3) 
{ 
	$activa_d_semana="class='active'"; 
	$activa_d_semana2="in active";
}
else
{ 
	$activa_d_semana=""; 
	$activa_d_semana2="";
}
//activa el TAB de EN DETALL
if(isset($_GET['activa']) and $_GET['activa']==4) 
{ 
	$activa_en_detalle="class='active'"; 
	$activa_en_detalle2="in active";
}
else
{ 
	$activa_en_detalle=""; 
	$activa_en_detalle2="";
}

?>
               
<ul class="nav nav-tabs">
    <li <?php echo $activa_lanzamientos; ?>><a data-toggle="tab" href="#lanzamientos">Lanzamientos</a></li>
    <li <?php echo $activa_novedades; ?>><a data-toggle="tab" href="#novedades">Novedades</a></li>
    <li <?php echo $activa_d_semana; ?>><a data-toggle="tab" href="#d_semana">Disco de la semana</a></li>
    <li <?php echo $activa_en_detalle; ?>><a data-toggle="tab" href="#detalle">En detalle</a></li>
</ul>

<div class="tab-content">

    <div id="lanzamientos" class="tab-pane fade <?php echo $activa_lanzamientos2; ?>">
        <?php include_once("lanzamientos.php"); ?>
    </div>
    
    <div id="novedades" class="tab-pane fade <?php echo $activa_novedades2; ?>">
       <?php include_once("novedades.php"); ?>
    </div>
    
    <div id="d_semana" class="tab-pane fade <?php echo $activa_d_semana2; ?>">
        <?php include_once("d_semana.php"); ?>
    </div>
    
    <div id="detalle" class="tab-pane fade <?php echo $activa_en_detalle2; ?>">
        <?php include_once("en_detalle.php"); ?>
    </div>
    
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
<?php
/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>
</body>

</html>
