<?php require_once('Connections/conexion.php'); ?>
<?php

require_once('rutas_absolutas.php'); 
//header('Content-Type: text/plain; charset=ISO-8859-1');
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
?>

<?php
//************************************agrega un lanzamiento
if(isset($_GET['agrega']) and $_GET['agrega']=='lanzamientos')
{
	$insertSQL = sprintf("INSERT INTO lanzamientos (id_producto) VALUES (%s)",
	GetSQLValueString($_GET['id_producto'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	
	//header("Location: admin_home.php?alerta=7&activa=1");
	?><script>window.location="admin_home.php?alerta=7&activa=1";</script><?php

}
//************************************agrega un novedad
if(isset($_GET['agrega']) and $_GET['agrega']=='novedades')
{
	$insertSQL = sprintf("INSERT INTO novedades (id_producto) VALUES (%s)",
	GetSQLValueString($_GET['id_producto'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	
	//header("Location: admin_home.php?alerta=5&activa=2");
	?><script type="text/javascript">window.location="admin_home.php?alerta=5&activa=2";</script><?php

}
//************************************agrega un Disco de la Semana
if(isset($_GET['agrega']) and $_GET['agrega']=='disco_semana')
{
	$insertSQL = sprintf("INSERT INTO d_semana (id_producto) VALUES (%s)",
	GetSQLValueString($_GET['id_producto'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	
	//header("Location: admin_home.php?alerta=5&activa=3");
	?><script type="text/javascript">window.location="admin_home.php?alerta=5&activa=3";</script><?php

}
//************************************agrega un EN DETALLE
if(isset($_GET['agrega']) and $_GET['agrega']=='en_detalle')
{
	//toma todos los albums de ese artista
	mysqli_select_db($conexion,$database_conexion);
	$query_ProductoArtista = "select * from productos where prendido=1 and  artista='".$_GET['artista']."'";
	$ProductoArtista = mysqli_query($conexion,$query_ProductoArtista) or die(mysqli_error($conexion));
	$row_ProductoArtista= mysqli_fetch_assoc($ProductoArtista); 
	$totalRows_ProductoArtista = mysqli_num_rows($ProductoArtista);
	
	do
	{
		
	$insertSQL = sprintf("INSERT INTO en_detalle (id_producto) VALUES (%s)",
	GetSQLValueString($row_ProductoArtista['id'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	

	}while($row_ProductoArtista= mysqli_fetch_assoc($ProductoArtista));
	
	//header("Location: admin_home.php?alerta=5&activa=4");
	?><script type="text/javascript">window.location="admin_home.php?alerta=5&activa=4";</script><?php
}













//muestra lista desplegable LANZAMIENTOS
if(isset($_GET['nombre_lanzamientos']) and $_GET['nombre_lanzamientos']!='')
{
	
	mysqli_select_db($conexion,$database_conexion);
	$query_Producto = "SELECT * FROM productos where prendido=1 and (artista like '%".$_GET['nombre_lanzamientos']."%' or album like '%".$_GET['nombre_lanzamientos']."%') order by artista, album";
	$Producto = mysqli_query($conexion,$query_Producto) or die(mysqli_error($conexion));
	$row_Producto = mysqli_fetch_assoc($Producto); 
	$totalRows_Producto = mysqli_num_rows($Producto);
	
	do
	{
	
	?><a href="js_despliega_art.php?agrega=lanzamientos&id_producto=<?php echo $row_Producto ['id'] ?>" class="tipografia2" style="color:#244e58;"><?php echo utf8_encode(utf8_decode($row_Producto ['artista']))." - ".utf8_encode(utf8_decode($row_Producto ['album'])); ?><br></a><?php
	
	}while($row_Producto = mysqli_fetch_assoc($Producto));

}


 
//muestra lista desplegable NOVEDADES
if(isset($_GET['nombre_novedad']) and $_GET['nombre_novedad']!='')
{
	
	 mysqli_select_db($conexion,$database_conexion);
	$query_Producto = "SELECT * FROM productos where prendido=1 and (artista like '%".$_GET['nombre_novedad']."%' or album like '%".$_GET['nombre_novedad']."%')  order by artista, album";
	$Producto = mysqli_query($conexion,$query_Producto) or die(mysqli_error($conexion));
	$row_Producto = mysqli_fetch_assoc($Producto); 
	$totalRows_Producto = mysqli_num_rows($Producto);
	
	do
	{
	
	?><a href="js_despliega_art.php?agrega=novedades&id_producto=<?php echo $row_Producto ['id'] ?>" class="tipografia2" style="color:#244e58;"><?php echo utf8_encode(utf8_decode($row_Producto ['artista']))." - ".utf8_encode(utf8_decode($row_Producto ['album'])); ?><br></a><?php
	
	}while($row_Producto = mysqli_fetch_assoc($Producto));

}

//muestra lista desplegable DISCO DE LA SEMANA
if(isset($_GET['nombre_d_semana']) and $_GET['nombre_d_semana']!='')
{
	
	 mysqli_select_db($conexion,$database_conexion);
	$query_Producto = "SELECT * FROM productos where prendido=1 and (artista like '%".$_GET['nombre_d_semana']."%' or album like '%".$_GET['nombre_d_semana']."%')  order by artista, album";
	$Producto = mysqli_query($conexion,$query_Producto) or die(mysqli_error($conexion));
	$row_Producto = mysqli_fetch_assoc($Producto); 
	$totalRows_Producto = mysqli_num_rows($Producto);
	 
	do
	{
	
	?><a href="js_despliega_art.php?agrega=disco_semana&id_producto=<?php echo $row_Producto ['id'] ?>" class="tipografia2" style="color:#244e58;"><?php echo utf8_encode(utf8_decode($row_Producto ['artista']))." - ".utf8_encode(utf8_decode($row_Producto ['album'])); ?><br></a><?php
	
	}while($row_Producto = mysqli_fetch_assoc($Producto));

}



//muestra lista desplegable EN DETALLE
if(isset($_GET['nombre_detalle']) and $_GET['nombre_detalle']!='')
{
	
	 mysqli_select_db($conexion,$database_conexion);
	$query_Producto = "SELECT DISTINCT(artista) FROM productos where prendido=1 and (artista like '%".$_GET['nombre_detalle']."%' )  order by artista, album";
	$Producto = mysqli_query($conexion,$query_Producto) or die(mysqli_error($conexion));
	$row_Producto = mysqli_fetch_assoc($Producto); 
	$totalRows_Producto = mysqli_num_rows($Producto);
	 
	do
	{
		/*le quita los acentos a los artistas*/
		$sustituye1=str_replace("á","a",utf8_encode(utf8_decode($row_Producto['artista'])));//remplaza á por a
		$sustituye2=str_replace("é","e",$sustituye1);//remplaza é por e
		$sustituye3=str_replace("í","i",$sustituye2);//remplaza í por i
		$sustituye4=str_replace("ó","o",$sustituye3);//remplaza ó por o
		$sustituye5=str_replace("ú","u",$sustituye4);//remplaza ú por u
		$sustituye6=str_replace("Á","A",$sustituye5);//remplaza Á por A
		$sustituye7=str_replace("É","E",$sustituye6);//remplaza É por E
		$sustituye8=str_replace("Í","I",$sustituye7);//remplaza Í por I
		$sustituye9=str_replace("Ó","O",$sustituye8);//remplaza Ó por O 
		$sustituye10=str_replace("Ú","U",$sustituye9);//remplaza Ú por U
	
	?><a href="js_despliega_art.php?agrega=en_detalle&artista=<?php echo $sustituye10 ?>" class="tipografia2" style="color:#244e58;"><?php echo utf8_encode(utf8_decode($row_Producto ['artista'])); ?><br></a><?php
	
	}while($row_Producto = mysqli_fetch_assoc($Producto));

}



//muestra lista desplegable EN BUSQUEDA
if(isset($_GET['buscar']) and $_GET['buscar']!='')
{
	
	 mysqli_select_db($conexion,$database_conexion);
	$query_Producto = "SELECT DISTINCT(artista) FROM productos where prendido=1 and (artista like '%".$_GET['buscar']."%' )  order by artista, album";
	$Producto = mysqli_query($conexion,$query_Producto) or die(mysqli_error($conexion));
	$row_Producto = mysqli_fetch_assoc($Producto); 
	$totalRows_Producto = mysqli_num_rows($Producto);
	 ?><ul type="square"><?php
	do
	{
	
	?><li><a href="<?php echo $ruta_absoluta; ?>busqueda.php?artista=<?php echo utf8_encode(utf8_decode($row_Producto ['artista'])); ?>" class="tipografia2" style="color:#244e58; font-size:11px;"><?php echo utf8_encode(utf8_decode($row_Producto ['artista'])); ?><br></a></li><?php
	
	}while($row_Producto = mysqli_fetch_assoc($Producto));

	?></ul><?php
}





else
{
	?>&nbsp;<?php
}





?>








<?php
//mysql_free_result($Producto);
?>
