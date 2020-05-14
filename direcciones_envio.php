<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); 

?>
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

$MM_restrictGoTo = "index.php?alerta=2";
if (!((isset($_SESSION['MM_Username_Ecommerce'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username_Ecommerce'], $_SESSION['MM_UserGroup_Ecommerce'])))) {   
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



mysqli_select_db($conexion,$database_conexion);
$query_CatPais = "SELECT * FROM pais order by paisnombre asc";
$CatPais = mysqli_query($conexion,$query_CatPais) or die(mysqli_error($conexion));
$row_CatPais = mysqli_fetch_assoc($CatPais);
$totalRows_CatPais = mysqli_num_rows($CatPais);

//existen direcciones de este usuario
mysqli_select_db($conexion,$database_conexion);
$query_ExisteDireccion = "SELECT * FROM direcciones where id_usr=".$_SESSION['USUARIO_ECOMMERCE']['id']."";
$ExisteDireccion  = mysqli_query($conexion,$query_ExisteDireccion) or die(mysqli_error($conexion));
$row_ExisteDireccion  = mysqli_fetch_assoc($ExisteDireccion );
$totalRows_ExisteDireccion  = mysqli_num_rows($ExisteDireccion );



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

    <title>Fonarte Latino | Direccion de envio</title>
  
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
                    <p class="page-header">Direcci&oacute;n de env&iacute;o<small>&nbsp;</small></p>
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

<div class="col-sm-3" >
<button type="button"  onClick="location.href='carrito.php'"  class="btn btn-default"  style=" text-align:center; color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px;border:2px solid #ffffff; width:100%"><i class="fa fa-shopping-cart  fa-1x" aria-hidden="true"></i>&nbsp;Carrito &nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px; border:2px solid #ffffff; width:100%"><i class="fa fa-lock fa-1x" aria-hidden="true"></i>&nbsp;Iniciar Sesi&oacute;n &nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
</div>

<div class="col-sm-3" >
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px;background-color:#244e58; color:#ffffff;  border:2px solid #ffffff; width:100%;"><i class="fa fa-share fa-1x" aria-hidden="true"></i>&nbsp;Direcci&oacute;n de Env&iacute;o</button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px;background-color:#D8D8D8;  border:2px solid #ffffff; width:100%;"><i class="fa fa-usd fa-1x" aria-hidden="true"></i>&nbsp;Pago</button>
</div>
  
</div>
<!-- ======================== FIN DE PASOS ======================================== -->              

            <br><br>
            
            
            
<div class="panel-group tipografia2" id="accordion">
 <!-- ================================================================= -->
    <div class="panel panel-default">
      <div class="panel-heading" style="background-color:#D8D8D8; ">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="fa fa-home" aria-hidden="true"></i>&nbsp;Direcciones Existentes</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
       <!-- inicio de cuerpo de dicecciones existentes -->
       
       <div class="container" style="width: 95%;">
        <br>
        <?php
		if($totalRows_ExisteDireccion==0)
		{
			?>Lo sentimos, no tienes direcciones existentes. Da click en: &nbsp;&nbsp;"<i class="fa fa-plus" aria-hidden="true"></i>&nbsp;<i>Crear una nueva direccion</i>"<?php
		}
		else
		{
			
			
			?>

            
<div class="row">
<?php
$contador=1;
	do{
?>
	
    <div class="col-sm-3 col-md-3 tipografia2" style="font-size:10px;">
        <div class="thumbnail">
            <div class="caption"  style="min-height: 220px;">
            	<!--input type="radio" name="direccion" style=" border: 0px;width: 100%;height: 2em;"-->

                <h4 style="text-align:center;"><?php echo utf8_encode($row_ExisteDireccion['pais']); ?></h4>
               <?php
                
                echo "CALLE: ".utf8_encode($row_ExisteDireccion['calle']);
				echo "<br>COLONIA: ".utf8_encode($row_ExisteDireccion['colonia']);
				echo "<br>DELEGACION O MUNICIPIO: ".utf8_encode($row_ExisteDireccion['muni_dele']).", ".utf8_encode($row_ExisteDireccion['n_ext']).", ".utf8_encode($row_ExisteDireccion['n_int']);
				echo "<br>PAIS: ".utf8_encode($row_ExisteDireccion['pais']);
				echo "<br> ESTADO: ".utf8_encode($row_ExisteDireccion['estado']);
				echo "<br> CP: ".$row_ExisteDireccion['cp'];
				echo "<br>ENTRE LA CALLE ".utf8_encode($row_ExisteDireccion['entre_calle_1'])." Y LA CALLE ".utf8_encode($row_ExisteDireccion['entre_calle_2']);
				echo "<br><span class='glyphicon glyphicon-user'></span>PARA: ".utf8_encode($row_ExisteDireccion['nombre_recibe']);
				echo "<br><span class='glyphicon glyphicon-earphone'></span>TELEFONO: ".$row_ExisteDireccion['tel_recibe'];

        		?>
                
                
                
            </div>
            
            
<div>

<button type="button" class="btn btn-default" style="color: #244e58;"  data-toggle="modal" data-target="#borra_direccion" onclick="modal_borra_dir(<?php echo $row_ExisteDireccion['id'] ?>)"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;Borrar</button>

<button type="button" class="btn btn-default" style="color: #244e58;" data-toggle="modal" data-target="#selecciona_direccion" onclick="selecciona_direccion_modal(<?php echo $row_ExisteDireccion['id'] ?>)"><i class="fa fa-check-square-o" aria-hidden="true"></i>&nbsp;Seleccionar</button>





    
    <!-- ===== inicio de modal de borra direccion ====== -->
<div class="modal fade" id="borra_direccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content tipografia2"  id="contenido_borra_dir" style=" font-size:12px;">
     
     
    </div>
  </div>
</div>
<!-- ===== inicio de modal de borra direccion ====== -->

<!-- ===== inicio de modal de selecciona direccion ====== -->
<div class="modal fade" id="selecciona_direccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="contenido_selecciona_dir">
      
    </div>
  </div>
</div>

<!-- ===== inicio de modal de selecciona direccion ====== -->
    
</div>
            
            
            
        </div>
    </div>
    <?php
			$contador=$contador+1;
			}while($row_ExisteDireccion  = mysqli_fetch_assoc($ExisteDireccion ));
		}
		?>
</div>
            
    
    
        

<script>
/* inicio modal rechazo*/
function modal_borra_dir(id_dir)
{
	//alert(id_dir+'---')
	$( "#contenido_borra_dir" ).load( "ajax_contenido_borra_dir.php?id_dir="+id_dir);
}
/* fin modal rechazo*/

/* inicio modal selecciona direccion*/
function selecciona_direccion_modal(id_dir2)
{
	//alert(id_dir2+'---')
	$( "#contenido_selecciona_dir" ).load( "ajax_contenido_selecciona_dir.php?id_dir2="+id_dir2);
}
/* inicio modal selecciona direccion*/

</script>



        
			
 		<br><br>   
		</div>
       
       <!-- fin de cuerpo de dicecciones existentes -->
      </div>
    </div>

    
    
    
 <!-- ================================================================= -->     
    <div class="panel panel-default tipografia2">
      <div class="panel-heading"  style="background-color:#D8D8D8;">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;Crear nueva direcci&oacute;n</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <!-- fin de cuerpo de crear nueva direccion -->
        <div class="container" style="width: 95%;">
            <br><br>   
            <?php include_once("form_nueva_direccion.php"); ?>
            <br><br>   
        </div>
        <!-- fin de cuerpo de crear nueva direccion -->
      </div>
    </div>
  </div> 
 
               
  
            
     
            
            

               
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
    <script src="js/valida_direccion_nueva.js"></script>
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
//mysqli_free_result($UpdateCarrito);
?>
