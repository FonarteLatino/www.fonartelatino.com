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

mysqli_select_db($conexion,$database_conexion);
$query_CatCiudades = "SELECT * FROM estado where ubicacionpaisid=".$_GET['pais']." order by estadonombre asc";
$CatCiudades = mysqli_query($conexion,$query_CatCiudades) or die(mysqli_error($conexion));
$row_CatCiudades = mysqli_fetch_assoc($CatCiudades);
$totalRows_CatCiudades = mysqli_num_rows($CatCiudades);


//
?>
<div class="form-group">
    <label>Estado</label>
    <select class="form-control" style="text-transform: uppercase;" name="estado" id="id_estado">

      <?php
do {  
?>
      <option value="<?php echo $row_CatCiudades['id']?>"><?php echo utf8_encode($row_CatCiudades['estadonombre']) ?></option>
      <?php
} while ($row_CatCiudades = mysqli_fetch_assoc($CatCiudades));
  $rows = mysqli_num_rows($CatCiudades);
  if($rows > 0) {
      mysqli_data_seek($CatCiudades, 0);
	  $row_CatCiudades = mysqli_fetch_assoc($CatCiudades);
  }
?>
  </select>
  <span class="help-block"></span><!-- muestra texto de ayuda -->
</div>
<?php
mysqli_free_result($CatCiudades);
?>
