<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('Connections/conexion.php'); 


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



if(isset($_POST['inserta_coment']) and ($_POST['inserta_coment']))
{
	
	
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

    <title>Contacto | Fonarte Latino</title>
  
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

<script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body>

    <?php include("menu.php"); ?>

    <!-- Page Content -->
    
		
        
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Contacto<small>&nbsp;</small></p>
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
               
               <br>
               
             <?php include("pinta_alerta.php"); ?>  
            <div class="row tipografia_contacto" >
                <div class="col-sm-6" >
                	<h3>Fonarte Latino</h3>
                    <p>Calzada General Anaya 55 &ndash; 2A</p>
                    <p>San Diego Churubusco 04120 M&eacute;xico D.F.</p>
                    <p>Tels. 5549 8405 | 5689 0198 | Fax 5549 8406</p>  
                    
                    <h3>Direcci&oacute;n Art&iacute;stica</h3>
                    <p>Pepe &Aacute;vila</p>
                    
                    <h3>Direcci&oacute;n Comercial</h3>
                    <p>Diego &Aacute;vila</p>
                    
                    <h3>Ventas</h3>
                    <p>ventas@fonartelatino.com</p>

                    
                    
                </div>
                <div class="col-sm-6">
<form style="margin-top:20px;" method="post" action="procesa.php">

    <div class="form-group">
    <label for="">Nombre: *(requerido)</label>
    <input type="text" class="form-control" name="nombre" id="id_nombre"  >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="form-group">
    <label>Email: *(requerido)</label>
    <input type="text" class="form-control" name="email" id="id_email"  >
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="form-group">
    <label for="">Tel&eacute;fono: *(requerido)</label>
    <input type="text" class="form-control" name="telefono" id="id_telefono">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="form-group">
    <label for="">Comentario:</label>
    <textarea class="form-control" name="comentario" rows="5" id="comment"></textarea>
    </div>
    
    <!--
    <div class="form-group">
    <input type="checkbox" id="id_leido" value="">
    <label  data-toggle="modal" data-target="#aviso_priv" style="cursor: url(img/click.png), pointer; color:#000000;">Acepto Aviso de Privacidad <span style="color:red;">*</span> </label>
    <span class="help-block"></span>
    </div>
    -->
    
    
    <div class="form-group">
    <div class="g-recaptcha" data-sitekey="6LemvSgUAAAAADsTVFF1w30R2NRQ-TAqTIzqFSI7"></div>
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    
    
    
    <!-- Modal -->
<div class="modal fade" id="aviso_priv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width: 70%;">
    <div class="modal-content" style="color:#000000;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Aviso de Privacidad</h4>
      </div>
      <div class="modal-body" style="font-size:14px; text-align:justify; font-weight:lighter;">
        
        <?php include_once("aviso_privacidad.php"); ?>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



    
    
    <input type="hidden" name="inserta_coment" value="1">    
    <div class="form-group">
    <button  id="id_btn_contacto" style="background-color:#244e58; color:#ffffff; font-size:16px; border:none; width: 75px; height:35px;">Enviar</button>
    </div>
    
    
</form>
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
    <script src="js/validacion_contacto.js"></script>
<?php
/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>
</body>

</html>
