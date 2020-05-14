<?php require_once('Connections/conexion.php'); ?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) 
{
	$updateSQL = sprintf("UPDATE envios SET precio=%s, descripcion=%s WHERE id=%s",
	GetSQLValueString($_POST['precio'], "int"),
	GetSQLValueString(utf8_decode($_POST['descripcion']), "text"),
	GetSQLValueString($_POST['id_envio'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	
	$updateGoTo = "admin_precio_envios.php?alerta=6";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}

	?><script type="text/javascript">window.location="<?php echo $updateGoTo; ?>";</script><?php
	
}

mysqli_select_db($conexion,$database_conexion);
$query_UpdatePrecio = "SELECT * FROM envios";
$UpdatePrecio = mysqli_query($conexion,$query_UpdatePrecio) or die(mysqli_error($conexion));
$row_UpdatePrecio = mysqli_fetch_assoc($UpdatePrecio);
$totalRows_UpdatePrecio = mysqli_num_rows($UpdatePrecio);

mysqli_select_db($conexion,$database_conexion);
$query_DatosPrecio = "SELECT * FROM envios where id=".$_GET['id_precio_envio'];
$DatosPrecio = mysqli_query($conexion,$query_DatosPrecio) or die(mysqli_error($conexion));
$row_DatosPrecio = mysqli_fetch_assoc($DatosPrecio);
$totalRows_DatosPrecio = mysqli_num_rows($DatosPrecio);
?>

<div class="modal-header tipografia2">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">#<?php echo $_GET['id_precio_envio']." - ".$row_DatosPrecio['region']; ?></h4>
</div>

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">

<div class="modal-body">

<input type="hidden" name="id_envio" value="<?php echo  $_GET['id_precio_envio']; ?>" >
<input type="hidden" name="MM_update" value="form1">
<div class="form-group">
    <label>Precio:</label>
    <input type="text" class="form-control" name="precio" id="" value="<?php echo $row_DatosPrecio['precio']; ?>" required >
</div>

<div class="form-group">
    <label>Descripcion:</label>
    <input type="text" class="form-control" name="descripcion" id="" value="<?php echo utf8_encode($row_DatosPrecio['descripcion']); ?>" required >
</div>


</div>


<div class="modal-footer">


<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
<button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Modificar</button>
</form>

</div>
