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
	$updateSQL = sprintf("UPDATE genero SET nombre=%s WHERE id=%s",
	GetSQLValueString($_POST['nombre'], "text"),
	GetSQLValueString($_POST['id'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	$updateGoTo = "admin_generos.php?alerta=6";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}

	?><script type="text/javascript">window.location="<?php echo $updateGoTo; ?>";</script><?php
}

mysql_select_db($database_conexion, $conexion);
$query_UpdateGenero = "SELECT * FROM genero";
$UpdateGenero = mysql_query($query_UpdateGenero, $conexion) or die(mysql_error());
$row_UpdateGenero = mysql_fetch_assoc($UpdateGenero);
$totalRows_UpdateGenero = mysql_num_rows($UpdateGenero);

mysql_select_db($database_conexion, $conexion);
$query_Genero = "SELECT * FROM genero where id=".$_GET['id_genero'];
$Genero = mysql_query($query_Genero, $conexion) or die(mysql_error());
$row_Genero = mysql_fetch_assoc($Genero);
$totalRows_Genero = mysql_num_rows($Genero);




//$_GET['id_genero'];

?>

<form  class="letra_admin_prod2" method="post" name="form1" action="<?php echo $editFormAction; ?>">

<div class="modal-header tipografia2">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel"># <?php echo $_GET['id_genero']; ?></h4>
</div>



<div class="modal-body">

    <div class="form-group">
    <label>Nombre:</label>
    <input type="text" name="nombre" class="form-control" value="<?php echo $row_Genero['nombre']; ?>" id="" required>
    <input type="hidden" name="id" value="<?php echo $_GET['id_genero'] ?>">
	<input type="hidden" name="MM_update" value="form1">
    </div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Editar</button>
</div>

</form>

<?php
mysql_free_result($Genero);

mysql_free_result($UpdateGenero);
?>
