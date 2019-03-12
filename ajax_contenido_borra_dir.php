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


?>
<?php
require_once('Connections/conexion.php'); 

//existen direcciones de este usuario
mysql_select_db($database_conexion, $conexion);
$query_Direccion = "SELECT * FROM direcciones where id=".$_GET['id_dir'];
$Direccion  = mysql_query($query_Direccion, $conexion) or die(mysql_error());
$row_Direccion  = mysql_fetch_assoc($Direccion );
$totalRows_Direccion  = mysql_num_rows($Direccion );

if(isset($_POST['query_delete'])  and ($_POST['query_delete']==1))
{
	
	$deleteSQL = sprintf("DELETE FROM direcciones WHERE id=%s",
	GetSQLValueString($_POST['id_dir'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
	
	$deleteGoTo = "direcciones_envio.php?alerta=204";
	if (isset($_SERVER['QUERY_STRING'])) {
	$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
	$deleteGoTo .= $_SERVER['QUERY_STRING'];
	}
	?><script type="text/javascript">window.location="<?php echo $deleteGoTo; ?>";</script><?php

}

?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel" style="color:#F00;"># <?php echo $_GET['id_dir']; ?> &#191;Seguro deseas eliminar esta direcci&oacute;n?</h4>
</div>



<div class="modal-body">

 <?php
                
echo "CALLE: ".utf8_encode($row_Direccion['calle']);
echo "<br>COLONIA: ".utf8_encode($row_Direccion['colonia']);
echo "<br>DELEGACION O MUNICIPIO: ".utf8_encode($row_Direccion['muni_dele']).", ".utf8_encode($row_Direccion['n_ext']).", ".utf8_encode($row_Direccion['n_int']);
echo "<br>PAIS: ".utf8_encode($row_Direccion['pais']);
echo "<br> ESTADO: ".utf8_encode($row_Direccion['estado']);
echo "<br> CP: ".$row_Direccion['cp'];
echo "<br>ENTRE LA CALLE ".utf8_encode($row_Direccion['entre_calle_1'])." Y LA CALLE ".utf8_encode($row_Direccion['entre_calle_2']);
echo "<br>PARA: ".utf8_encode($row_Direccion['nombre_recibe']);
echo "<br>TELEFONO: ".utf8_encode($row_Direccion['tel_recibe']);

?>
                


</div>


<form action="ajax_contenido_borra_dir.php?id_dir=<?php echo $_GET['id_dir']; ?>" method="post">
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</button>
    <input type="hidden" name="query_delete" value="1">
    <input type="hidden" name="id_dir" value="<?php echo $_GET['id_dir']; ?>">
    <button type="submit" class="btn btn-primary" style="background-color:#F00; border:#F00;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Si</button>
</div>
</form>