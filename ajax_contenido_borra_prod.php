<?php require_once('Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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


//borra el producto logicamente, NO FISICAMENTE, cambia el estatus de 1 a 0
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) 
{
	$updateSQL = sprintf("UPDATE productos SET prendido=%s WHERE id=%s",
	GetSQLValueString(0, "int"),
	GetSQLValueString($_POST['id_producto'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	
	$updateGoTo = "admin_productos.php?alerta=7";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	?><script type="text/javascript">window.location="<?php echo $updateGoTo; ?>";</script><?php
	
	
}

mysqli_select_db($conexion,$database_conexion);
$query_UpdateBorraProducto = "SELECT * FROM productos";
$UpdateBorraProducto = mysqli_query($conexion,$query_UpdateBorraProducto) or die(mysqli_error($conexion));
$row_UpdateBorraProducto = mysqli_fetch_assoc($UpdateBorraProducto);
$totalRows_UpdateBorraProducto = mysqli_num_rows($UpdateBorraProducto);

mysqli_select_db($conexion,$database_conexion);
$query_DatosProducto = "SELECT
productos.id as id_tabla,
productos.sku,
productos.id_fonarte,
productos.artista,
productos.album,
productos.genero,
genero.nombre AS gen_nombre,
productos.categoria,
categoria.nombre AS cat_nombre,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.ruta_img,
productos.clave_precio,
productos.fecha_alta,
productos.hora_alta,
productos.estatus,
precios.precio,
precios.id
FROM
productos
LEFT JOIN categoria ON categoria.id = productos.categoria
LEFT JOIN genero ON genero.id = productos.genero
LEFT JOIN precios ON precios.clave = productos.clave_precio
WHERE productos.id=".$_GET['id_producto'];
$DatosProducto = mysqli_query($conexion,$query_DatosProducto) or die(mysqli_error($conexion));
$row_DatosProducto = mysqli_fetch_assoc($DatosProducto);
$totalRows_DatosProducto = mysqli_num_rows($DatosProducto);



$_GET['id_producto'];

?>

<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<div class="modal-header tipografia2">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">&#191;Seguro deseas eliminar el producto #<?php echo $_GET['id_producto']; ?>?</h4>
</div>


 
<div class="modal-body">

<div class="row">
  <div class="col-sm-4">
  <img src="<?php echo $row_DatosProducto['ruta_img']; ?>" class="img-rounded" alt="" width="100%" height="100%">
  </div>
  <div class="col-sm-8 tipografia2">
  	<p><strong>SKU</strong>: <?php echo $row_DatosProducto['sku']; ?></p>
    <p><strong>ID:</strong> <?php echo $row_DatosProducto['id_fonarte']; ?></p>
    <p><strong>PRECIO:</strong> <?php echo "$".$row_DatosProducto['precio'].".00"; ?></p>
    <p><strong>ARTISTA:</strong> <?php echo utf8_encode($row_DatosProducto['artista']); ?></p>
    <p><strong>ALBUM:</strong> <?php echo utf8_encode($row_DatosProducto['album']); ?></p>
  </div>
</div>

</div>


<div class="modal-footer">

<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
<input type="hidden" name="id_producto" value="<?php echo  $_GET['id_producto']; ?>" >
<input type="hidden" name="MM_update" value="form1">
<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</button>
<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Si</button>
</form>

</div>
<?php
mysqli_free_result($DatosProducto);

mysqli_free_result($UpdateBorraProducto);
?>
