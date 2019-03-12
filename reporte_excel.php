<?php
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte_Fonarte.xls");

require_once('Connections/conexion.php'); 

/*
echo "<br>".$_POST['fecha_inicio'];
echo "<br>".$_POST['fecha_inicio'];
echo "<br>".$_POST['tipo'];
*/



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

//**************************** tomamos los datos del pedido
switch($_POST['tipo'])
{
	//TODOS LOS PEDIDOS(PENDIENTES Y PAGADAS)
	case 1:mysql_select_db($database_conexion, $conexion);
		 $query_Pedido = "SELECT * FROM pedido where fecha BETWEEN '".$_POST['fecha_inicio']."' and '".$_POST['fecha_final']."'";
		$Pedido = mysql_query($query_Pedido, $conexion) or die(mysql_error());
		$row_Pedido = mysql_fetch_assoc($Pedido);
		$totalRows_Pedido = mysql_num_rows($Pedido);
		break;
	//LOS PEDIDOS PENDIENTES
	case 2:mysql_select_db($database_conexion, $conexion);
		$query_Pedido = "SELECT * FROM pedido where estatus=2 and (fecha BETWEEN '".$_POST['fecha_inicio']."' and '".$_POST['fecha_final']."')";
		$Pedido = mysql_query($query_Pedido, $conexion) or die(mysql_error());
		$row_Pedido = mysql_fetch_assoc($Pedido);
		$totalRows_Pedido = mysql_num_rows($Pedido);
		break;
	//LOS PEDIDOS PAGADOS
	case 3:mysql_select_db($database_conexion, $conexion);
		$query_Pedido = "SELECT * FROM pedido where estatus=3 and (fecha BETWEEN '".$_POST['fecha_inicio']."' and '".$_POST['fecha_final']."')";
		$Pedido = mysql_query($query_Pedido, $conexion) or die(mysql_error());
		$row_Pedido = mysql_fetch_assoc($Pedido);
		$totalRows_Pedido = mysql_num_rows($Pedido);
		break;
}






//**************************** tomamos los datos de la direccion

//**************************** tomamos los datos del cupon (en caso de que haya aplicado alguno)





?>

<table border="1">
  <tr>
    <td>Id Pedido</td>
    <td>Usuario</td>
    <td>Forma de Pago</td>
    <td>Datos de Envio</td>
    <td>Estatus</td>
    <td>Fecha</td>
    <td>Productos</td>
    <td>Subtotal</td>
    <td>Envio</td>
    <td>Cupon Aplicado</td>
    <td>Total</td>
    
  </tr>
  <?php 
  $total_ventas=0;
  do { 
  
//**************************** tomamos los datos del usuario
$query_Usuario = "SELECT * FROM usuarios_ecommerce where id=".$row_Pedido['id_usuario'];
$Usuario = mysql_query($query_Usuario, $conexion) or die(mysql_error());
$row_Usuario = mysql_fetch_assoc($Usuario);
$totalRows_Usuario = mysql_num_rows($Usuario);

//**************************** tomamos los datos de la direccion
$query_Direccion = "SELECT * FROM direcciones where id=".$row_Pedido['id_direccion'];
$Direccion = mysql_query($query_Direccion, $conexion) or die(mysql_error());
$row_Direccion = mysql_fetch_assoc($Direccion);
$totalRows_Direccion = mysql_num_rows($Direccion);

//**************************** tomamos los datos del cupon(en caso de que haya aplciado alguno)
$query_Cupon = "SELECT * FROM cupon where codigo='".$row_Pedido['cupon_aplicado']."'";
$Cupon = mysql_query($query_Cupon, $conexion) or die(mysql_error());
$row_Cupon = mysql_fetch_assoc($Cupon);
$totalRows_Cupon = mysql_num_rows($Cupon);

if($row_Cupon['medida']=='PORCENTAJE')
{
	$descuento="- %".$row_Cupon['descuento'];
}
else
{
	$descuento="- $".$row_Cupon['descuento'];
}


//**************************** tomamos los datos de los productos
$query_ProductosDetalle = "SELECT
pedido.id,
pedido.id_usuario,
pedido.id_direccion,
pedido.forma_pago,
pedido.subtotal_productos,
pedido.precio_envio,
pedido.total,
pedido.cupon_aplicado,
pedido.estatus,
pedido.descripcion_estatus,
pedido.fecha, 
pedido.hora,
pedido_productos.id,
pedido_productos.id_pedido,
pedido_productos.id_producto,
pedido_productos.id_producto_fonarte,
pedido_productos.tipo,
pedido_productos.artista,
pedido_productos.album,
pedido_productos.cantidad,
pedido_productos.precio,
pedido_productos.precio_final,
pedido_productos.fecha_hora
FROM
pedido
INNER JOIN pedido_productos ON pedido.id = pedido_productos.id_pedido

where pedido_productos.id_pedido=".$row_Pedido['id'];
$ProductosDetalle = mysql_query($query_ProductosDetalle, $conexion) or die(mysql_error());
$row_ProductosDetalle= mysql_fetch_assoc($ProductosDetalle);
$totalRows_ProductosDetalle = mysql_num_rows($ProductosDetalle);



  ?>

    <tr>
      <td><?php echo $row_Pedido['id']; ?></td>
      <td><?php echo utf8_encode($row_Usuario['nombre'])." ".utf8_encode($row_Usuario['apepat'])." ".utf8_encode($row_Usuario['apemat'])." <br />".$row_Usuario['email']; ?></td>
      
      <td><?php echo $row_Pedido['forma_pago']; ?></td>
      <td>
	  	<ul>
        	<li><?php echo utf8_encode($row_Direccion['nombre_recibe']); ?></li>
            <li><?php echo utf8_encode($row_Direccion['tel_recibe']); ?></li>
            <li><?php echo $row_Direccion['calle']." N/E ".$row_Direccion['n_ext']." N/I ".$row_Direccion['n_int']." ".$row_Direccion['colonia']." ".$row_Direccion['muni_dele']." ".$row_Direccion['estado'].", ".$row_Direccion['pais']." C.P. ".$row_Direccion['cp']; ?></li>
        </ul>
	  </td>
      <td><?php echo $row_Pedido['descripcion_estatus']; ?></td>
      <td><?php echo $row_Pedido['fecha']." ".$row_Pedido['hora']; ?></td>
      <td>
      <ul>
      <?php
	  do{
		  
		  ?><li><?php echo "<strong>".$row_ProductosDetalle['id_producto_fonarte']."</strong> - ".$row_ProductosDetalle['artista'].", ".$row_ProductosDetalle['album']." - Cantidad: ".$row_ProductosDetalle['cantidad']." - $".$row_ProductosDetalle['precio'].".00"; ?></li><?php

		}while($row_ProductosDetalle= mysql_fetch_assoc($ProductosDetalle));
	  ?>
      </ul>
      </td>
      
      <td><?php echo "$".$row_Pedido['subtotal_productos'].".00"; ?></td>
      <td><?php echo "$".$row_Pedido['precio_envio'].".00"; ?></td>
      <td><?php echo $row_Pedido['cupon_aplicado']; if($totalRows_Cupon>0){ echo "(".$descuento.")"; } ?></td>
      <td><?php echo "$".$row_Pedido['total'].".00"; ?></td>
      <?php
	  $total_ventas=$total_ventas+$row_Pedido['total'];
	  ?>
      
    </tr>
    <?php } while ($row_Pedido = mysql_fetch_assoc($Pedido)); ?>
    <tr>
    	<td colspan="11" style="text-align:right;"><strong>TOTAL DE VENTAS <?php echo "$".$total_ventas.".00"; ?></td>
    </tr>
</table>




<?php

mysql_free_result($Pedido);
?>