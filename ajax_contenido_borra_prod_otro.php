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

mysqli_select_db($conexion,$database_conexion);
$query_DatosProductoOtro = "SELECT
productos_otros.id,
productos_otros.sku,
productos_otros.id_fonarte,
productos_otros.clave_precio,
productos_otros.artista,
productos_otros.tipo,
productos_otros.s,
productos_otros.m,
productos_otros.l,
productos_otros.ruta_img,
productos_otros.ruta_img_2,
productos_otros.descripcion,
productos_otros.fecha_alta,
productos_otros.hora_alta,
productos_otros.prendido,
productos_otros.estatus,
cat_otros.nombre,

precios.precio
FROM
productos_otros
INNER JOIN cat_otros ON cat_otros.id = productos_otros.tipo
INNER JOIN precios ON productos_otros.clave_precio = precios.clave
where productos_otros.prendido=1 and productos_otros.id=".$_GET['id_producto_otro'];
$DatosProductoOtro = mysqli_query($conexion,$query_DatosProductoOtro) or die(mysqli_error($conexion));
$row_DatosProductoOtro = mysqli_fetch_assoc($DatosProductoOtro);
$totalRows_DatosProductoOtro = mysqli_num_rows($DatosProductoOtro);


if(isset($_POST['update']) and $_POST['update']==1)
{
	
	$updateSQL = sprintf("UPDATE productos_otros SET prendido=%s WHERE id=%s",
	GetSQLValueString(0, "int"),
	GetSQLValueString($_POST['id_producto'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	
	$updateGoTo = "admin_productos_otros.php?alerta=7";
	if (isset($_SERVER['QUERY_STRING'])) {
	$updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
	$updateGoTo .= $_SERVER['QUERY_STRING'];
	}
	?><script type="text/javascript">window.location="<?php echo $updateGoTo; ?>";</script><?php

	
}

?>

<div class="modal-header tipografia2">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">&#191;Seguro deseas eliminar el producto #<?php echo $_GET['id_producto_otro']; ?>?</h4>
</div>



<div class="modal-body">

<div class="row">
  <div class="col-sm-5">
 <center> <img src="<?php echo $row_DatosProductoOtro['ruta_img'];  ?>" class="img-rounded" alt="" width="100%" height="100%"></center>
  </div>
  <div class="col-sm-7 tipografia2">
  	<p><strong>SKU</strong>: <?php echo $row_DatosProductoOtro['sku']; ?></p>
    <p><strong>ID:</strong> <?php echo $row_DatosProductoOtro['id_fonarte']; ?></p>
    <p><strong>PRECIO:</strong> <?php echo "$".$row_DatosProductoOtro['precio'].".00"; ?></p>
    <p><strong>TITULO:</strong> <?php echo utf8_encode(utf8_decode($row_DatosProductoOtro['artista'])); ?></p>

  </div>
</div>

</div>


<div class="modal-footer">

<form method="post" name="form1" action="ajax_contenido_borra_prod_otro.php?id_producto_otro=<?php echo $_GET['id_producto_otro']; ?>">
<input type="hidden" name="id_producto" value="<?php echo  $_GET['id_producto_otro']; ?>" >
<input type="hidden" name="update" value="1">
<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</button>
<button type="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Si</button>
</form>

</div>
<?php
mysqli_free_result($DatosProductoOtro);
?>
