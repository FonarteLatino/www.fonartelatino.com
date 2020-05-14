<?php 

	if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'])
	{
		//var_dump($_POST);
		$secret="6LemvSgUAAAAAK9E4atvD2waSDcehM0ocVEnl7Kj";
		$ip=$_SERVER["REMOTE_ADDR"];
		
		$captcha=$_POST['g-recaptcha-response'];
		
		$result= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
		
		echo "<br /><br /><br />";
		
		//var_dump($result);
		
		
		$array=json_decode($result, TRUE);
		
		echo "<br /><br /><br />";
		
		if($array["success"])
		{
			
			
			
/*************************************************************************/
require_once('Connections/conexion.php'); 

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

$insertSQL = sprintf("INSERT INTO contacto (nombre, email, telefono, comentario, fecha, hora) VALUES (%s, %s, %s, %s, %s, %s)",
GetSQLValueString(utf8_decode($_POST['nombre']), "text"),
GetSQLValueString($_POST['email'], "text"),
GetSQLValueString($_POST['telefono'], "text"),
GetSQLValueString(utf8_decode($_POST['comentario']), "text"),
GetSQLValueString(date("Y-m-d"), "date"),
GetSQLValueString(date("H:i:s"), "date"));

mysqli_select_db($conexion,$database_conexion);
$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));

$insertGoTo = "contacto.php?alerta=212";
if (isset($_SERVER['QUERY_STRING'])) {
$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
$insertGoTo .= $_SERVER['QUERY_STRING'];
}

include_once("email_comentario_recibido.php");
include_once("email_comentario_enviado.php");

?><script type="text/javascript">window.location="<?php echo $insertGoTo; ?>";</script><?php
/*************************************************************************/


		}
		else
		{
			echo "eres spam";
			?><script type="text/javascript">window.location="contacto?alerta=211";</script><?php
			
		}
	}
	else
	{
		?><script type="text/javascript">window.location="contacto?alerta=211";</script><?php
	}

?>