<?php require_once('Connections/conexion.php'); ?>
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



//response (required) El valor de "g-recaptcha-response".
if(isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response'])
{
	
	//secret (required) 6LcstRYUAAAAAE-HWHeOhFbZ6cTkM-s0hx7sx2on
	$secret="6Ld5XxcUAAAAAPBtq09mqyNVVk8_j7Cq7IpU6jfL";
	
	$ip=$_SERVER["REMOTE_ADDR"];
	
	$captcha=$_POST['g-recaptcha-response']; //es igual al valor del captcha
	
	
	$result=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha&remoteip=$ip");
	//echo"<br><br><br>".var_dump($result);

	$array = json_decode($result,TRUE);


	if($array["success"]=='true')
	{
		/*inicio de insert*/
		//echo"humano";
		
		$insertSQL = sprintf("INSERT INTO usuarios_ecommerce (nombre, apepat, apemat, email, psw, fecha_alta, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString(utf8_decode($_POST['nombre']), "text"),
		GetSQLValueString(utf8_decode($_POST['apepat']), "text"),
		GetSQLValueString(utf8_decode($_POST['apemat']), "text"),
		GetSQLValueString($_POST['email'], "text"),
		GetSQLValueString($_POST['psw'], "text"),
		GetSQLValueString(date('Y-m-d H:i:s'), "date"),
		GetSQLValueString(1, "int"));
		
		mysqli_select_db($conexion,$database_conexion);
		$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
		
		$insertGoTo = "cuenta.php?alerta=202";
		if (isset($_SERVER['QUERY_STRING'])) {
		$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
		$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		include_once("mail_gracias_registro.php");
		include_once("mail_gracias_registro_respaldo.php");//envia una copia cuando alguien se registra a usuariostienda@fonartelatino.com
		?><script type="text/javascript">window.location="<?php echo $insertGoTo ?>";</script><?php
		
	}
	else
	{
		/*redireccion por que es un robot*/
		//echo"robot";
		?>

<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id:</td>
      <td><input type="text" name="id" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nombre:</td>
      <td><input type="text" name="nombre" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Apepat:</td>
      <td><input type="text" name="apepat" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Apemat:</td>
      <td><input type="text" name="apemat" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Email:</td>
      <td><input type="text" name="email" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Psw:</td>
      <td><input type="text" name="psw" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Fecha_alta:</td>
      <td><input type="text" name="fecha_alta" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Estatus:</td>
      <td><input type="text" name="estatus" value="" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Insertar registro" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
<script type="text/javascript">window.location="cuenta.php?alerta=201";</script>
<?php
	}
	
}
else
{
	?>
<script type="text/javascript">window.location="cuenta.php?alerta=200";</script>
<?php
}

?>
