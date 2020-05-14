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
	$updateSQL = sprintf("UPDATE categoria SET nombre=%s WHERE id=%s",
	GetSQLValueString($_POST['nombre'], "text"),
	GetSQLValueString($_POST['id'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	
	$updateGoTo = "admin_categorias.php?alerta=6";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}

	?><script type="text/javascript">window.location="<?php echo $updateGoTo; ?>";</script><?php
}

mysqli_select_db($conexion,$database_conexion);
$query_UpdateCategoria = "SELECT * FROM categoria";
$UpdateCategoria = mysqli_query($conexion,$query_UpdateCategoria) or die(mysqli_error($conexion));
$row_UpdateCategoria = mysqli_fetch_assoc($UpdateCategoria);
$totalRows_UpdateCategoria = mysqli_num_rows($UpdateCategoria);

mysqli_select_db($conexion,$database_conexion);
$query_Categoria = "SELECT * FROM categoria where id=".$_GET['id_cateoria'];
$Categoria = mysqli_query($conexion,$query_Categoria) or die(mysqli_error($conexion));
$row_Categoria = mysqli_fetch_assoc($Categoria);
$totalRows_Categoria = mysqli_num_rows($Categoria);




//$_GET['id_cateoria'];

?>

<form  class="letra_admin_prod2"  method="post" name="form1" action="<?php echo $editFormAction; ?>">

<div class="modal-header tipografia2">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel"># <?php echo $_GET['id_cateoria']; ?></h4>
</div>



<div class="modal-body">

    <div class="form-group">
    <label>Nombre:</label>
    <input type="text" name="nombre" class="form-control" value="<?php echo $row_Categoria['nombre']; ?>" id="" required>
    <input type="hidden" name="id" value="<?php echo $_GET['id_cateoria'] ?>">
    <input type="hidden" name="MM_update" value="form1">
    </div>

</div>


<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<button type="submit" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Editar</button>
</div>

</form>

<?php
mysqli_free_result($Categoria);

mysqli_free_result($UpdateCategoria);
?>
