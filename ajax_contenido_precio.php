<?php require_once('Connections/conexion.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) 
{
	$updateSQL = sprintf("UPDATE precios SET precio=%s WHERE id=%s",
	GetSQLValueString($_POST['precio'], "int"),
	GetSQLValueString($_POST['id_precio'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	$updateGoTo = "admin_precios.php?alerta=6";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}

	?><script type="text/javascript">window.location="<?php echo $updateGoTo; ?>";</script><?php
	
}

mysql_select_db($database_conexion, $conexion);
$query_UpdatePrecio = "SELECT * FROM precios";
$UpdatePrecio = mysql_query($query_UpdatePrecio, $conexion) or die(mysql_error());
$row_UpdatePrecio = mysql_fetch_assoc($UpdatePrecio);
$totalRows_UpdatePrecio = mysql_num_rows($UpdatePrecio);

mysql_select_db($database_conexion, $conexion);
$query_DatosPrecio = "SELECT * FROM precios where id=".$_GET['id_precio'];
$DatosPrecio = mysql_query($query_DatosPrecio, $conexion) or die(mysql_error());
$row_DatosPrecio = mysql_fetch_assoc($DatosPrecio);
$totalRows_DatosPrecio = mysql_num_rows($DatosPrecio);
?>

<div class="modal-header tipografia2">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">#<?php echo $_GET['id_precio']; ?></h4>
</div>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">

<div class="modal-body">

<input type="hidden" name="id_precio" value="<?php echo  $_GET['id_precio']; ?>" >
<input type="hidden" name="MM_update" value="form1">
<div class="form-group">
    <label>Clave:</label>
    <input type="text" class="form-control" name="" id="" value="<?php echo $row_DatosPrecio['clave']; ?>" required readonly>
</div>

<div class="form-group">
    <label>Precio:</label>
    <input type="text" class="form-control" name="precio" id="" value="<?php echo $row_DatosPrecio['precio']; ?>" required >
</div>


</div>


<div class="modal-footer">


<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
<button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Modificar</button>
</form>

</div>
<?php
mysql_free_result($DatosPrecio);

mysql_free_result($UpdatePrecio);
?>
