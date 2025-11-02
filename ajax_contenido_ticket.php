<?php 
require_once('Connections/conexion.php');
session_start();

// Verificar que el usuario tiene permisos para ver el ticket
if (!isset($_SESSION['USUARIO_ECOMMERCE']) && !isset($_SESSION['USUARIO'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No tiene permiso para ver este ticket']);
    exit;
}

// Función mejorada para sanitizar valores SQL
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
    if (empty($theValue)) {
        return $theType === "text" ? "NULL" : "0";
    }
    
    // Sanitizar el valor usando mysqli_real_escape_string
    global $conexion;
    $theValue = mysqli_real_escape_string($conexion, $theValue);
    
    switch ($theType) {
        case "text":
            return "'" . $theValue . "'";
        case "long":
        case "int":
            return intval($theValue);
        case "double":
            return floatval($theValue);
        case "date":
            return "'" . $theValue . "'";
        default:
            return "'" . $theValue . "'";
    }
}
}

mysqli_select_db($conexion,$database_conexion);
// Validar el id del pedido
$id_pedido = isset($_GET['id_pedido']) ? intval($_GET['id_pedido']) : 0;
if ($id_pedido <= 0) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'ID de pedido inválido']);
    exit;
}

// Consulta optimizada usando JOIN y con manejo de codificación
$query_ProductosPedidos = "SELECT 
    pedido.id,
    pedido.id_usuario,
    pedido.id_direccion,
    pedido.forma_pago,
    pedido.subtotal_productos,
    pedido.id_envio,
    pedido.precio_envio,
    pedido.total,
    pedido.cupon_aplicado,
    pedido.estatus,
    pedido.descripcion_estatus,
    pedido.fecha,
    pedido.hora,
    pedido_productos.id AS producto_id,
    pedido_productos.id_pedido,
    pedido_productos.id_producto,
    pedido_productos.id_producto_fonarte,
    pedido_productos.tipo,
    CONVERT(pedido_productos.artista USING utf8) as artista,
    CONVERT(pedido_productos.album USING utf8) as album,
    pedido_productos.cantidad,
    pedido_productos.precio,
    pedido_productos.precio_final,
    pedido_productos.fecha_hora,
    envios.region,
    envios.precio as precio_envio,
    CONVERT(envios.descripcion USING utf8) as descripcion_envio
FROM
pedido
LEFT JOIN pedido_productos ON pedido.id = pedido_productos.id_pedido
LEFT JOIN envios ON pedido.id_envio = envios.id
where pedido.id=".$_GET['id_pedido'];
$ProductosPedidos = mysqli_query($conexion,$query_ProductosPedidos) or die(mysqli_error($conexion));
$row_ProductosPedidos = mysqli_fetch_assoc($ProductosPedidos);
$totalRows_ProductosPedidos = mysqli_num_rows($ProductosPedidos);



mysqli_select_db($conexion,$database_conexion);
$query_ProductosPedidos2 = "SELECT
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
pedido_productos.id_producto,
pedido_productos.cantidad,
pedido_productos.precio,
pedido_productos.precio_final,
pedido_productos.fecha_hora,
productos.artista,
productos.album
FROM
pedido
LEFT JOIN pedido_productos ON pedido.id = pedido_productos.id_pedido
LEFT JOIN productos ON productos.id = pedido_productos.id_producto
where pedido.id=".$_GET['id_pedido'];
$ProductosPedidos2 = mysqli_query($conexion,$query_ProductosPedidos2) or die(mysqli_error($conexion));
$row_ProductosPedidos2 = mysqli_fetch_assoc($ProductosPedidos2);
$totalRows_ProductosPedidos2 = mysqli_num_rows($ProductosPedidos2);

//datos de envio

$desc=utf8_encode(utf8_decode($row_ProductosPedidos['descripcion'])); 



mysqli_select_db($conexion,$database_conexion);
$query_Direccion = "SELECT * FROM direcciones where id=".$row_ProductosPedidos2['id_direccion'];
$Direccion = mysqli_query($conexion,$query_Direccion) or die(mysqli_error($conexion));
$row_Direccion = mysqli_fetch_assoc($Direccion);
$totalRows_Direccion = mysqli_num_rows($Direccion);

// datos del usuario
mysqli_select_db($conexion,$database_conexion);
$query_Usuario = "SELECT * FROM usuarios_ecommerce where id=".$row_ProductosPedidos2['id_usuario'];
$Usuario = mysqli_query($conexion,$query_Usuario) or die(mysqli_error($conexion));
$row_Usuario = mysqli_fetch_assoc($Usuario);
$totalRows_Usuario = mysqli_num_rows($Usuario);

//¿utilizo un cupon de descuento?
if($row_ProductosPedidos2['cupon_aplicado']!='')//si uso cupon de descuento
{
	mysqli_select_db($conexion,$database_conexion);
	$query_DatosCupon = "SELECT * FROM cupon where codigo='".$row_ProductosPedidos2['cupon_aplicado']."'";
	$DatosCupon = mysqli_query($conexion,$query_DatosCupon) or die(mysqli_error($conexion));
	$row_DatosCupon = mysqli_fetch_assoc($DatosCupon);
	$totalRows_DatosCupon = mysqli_num_rows($DatosCupon);
	
}
if(isset($row_DatosCupon['descuento']))
{
	if($row_DatosCupon['descuento']=='PESOS')
	{
		$descuento='- $'.$row_DatosCupon['descuento'];
	}
	else
	{
		$descuento='- %'.$row_DatosCupon['descuento'];
	}
	
}


//modifica el estatus cuando el pedido ya fue pagado
if(isset($_GET['pagado']) and ($_GET['pagado']==1))
{
	
	//le aparta este cupon a este pedido
	$updateSQL = sprintf("UPDATE pedido SET estatus=%s, descripcion_estatus=%s WHERE id=%s",
	GetSQLValueString('3', "int"),
	GetSQLValueString('PAGADO', "text"),
	GetSQLValueString($_GET['id_pedido'], "int"));
	 
	mysqli_select_db($conexion,$database_conexion);	
	$Result1 = mysqli_query($conexion,$updateSQL) or die(mysqli_error($conexion));
	
	$correo_comprador=$_GET['email'];
	/* envia correo de que el pago fue recibido correctamente*/
	include_once("mail_confirmacion_pago.php");
	
	
	
	?><script type="text/javascript">window.location="bienvenida.php";</script><?php
	
	
	
	
}

?>




<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Pedido #<?php echo $_GET['id_pedido']; ?></h4>
</div>



<div class="modal-body" id="">

<table class="table table-hover tipografia2">

    <thead style="font-size:11px;">
      <tr>
        <th>#</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody style="font-size:11px;">
		<?php
		$i=1;
        do{
        ?>
        <tr>
        	<td><?php echo $i; ?></td>
            <td><?php echo $row_ProductosPedidos['id_producto_fonarte']."-".utf8_encode(utf8_decode($row_ProductosPedidos['artista'])).", ".utf8_encode(utf8_decode($row_ProductosPedidos['album'])); ?></td>
            <td><?php echo $row_ProductosPedidos['cantidad']; ?></td>
            <td><?php echo "$".$row_ProductosPedidos['precio'].".00"; ?></td>
            
        </tr>
        <?php
		$i++;
        }while($row_ProductosPedidos = mysqli_fetch_assoc($ProductosPedidos))
        ?>
        
         <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Subtotal:</strong></td>
            <td><?php echo "$".$row_ProductosPedidos2['subtotal_productos'].".00"; ?></td>
        </tr>
        
        <?php 
		//SI EXISTE DESCUENTO
		if(isset($row_DatosCupon['descuento']))
		{
		?>
		 <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Cupon:</strong></td>
            <td><?php echo $descuento.".00"; ?></td>
        </tr>
        
        <?php
		}
		?>	
        
        
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Envio:</strong></td>
            <td><?php echo "$".$row_ProductosPedidos2['precio_envio'].".00"; ?></td>
        </tr>
        		
       
        
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><strong>Total:</strong></td>
            <td><?php echo "$".$row_ProductosPedidos2['total'].".00"; ?></td>
        </tr>
        
      
    </tbody>
  </table>
  



<hr style="border-top: 1px solid #244e58;">


<div class="row tipografia2">
	<!-- ======================== datos del usuario ============================================= -->
  <div class="col-sm-6">
      <p style="font-size:11px; text-align:left;"><strong>Datos de usuario</strong></p>
      <p style="font-size:11px;"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo utf8_encode(utf8_decode($row_Usuario['nombre']))." ".$row_Usuario['apepat']." ".$row_Usuario['apemat']; ?></p> 
      <p style="font-size:11px;"><span class="glyphicon glyphicon-envelope"></span>&nbsp;<?php echo $row_Usuario['email']; ?></p>
  </div>
  
  
  <!-- ======================== datos de envio ============================================= -->
  <div class="col-sm-6">
  <p style="font-size:11px; text-align:left;"><strong>Datos de envio</strong></p>
  <ul>
  <li><p style="font-size:11px;"><?php echo "PARA: ".utf8_encode(utf8_decode($row_Direccion['nombre_recibe'])); ?></p></li>
  <li><p style="font-size:11px;"><?php echo "TELEFONO: ".$row_Direccion['tel_recibe']; ?></p></li>
  <li><p style="font-size:11px;">
  <?php echo "DIRECCI&Oacute;N: ".$row_Direccion['calle']." # EXT ".$row_Direccion['n_ext']." # INT ".$row_Direccion['n_int']." ".utf8_encode(utf8_decode($row_Direccion['colonia']))." ".utf8_encode(utf8_decode($row_Direccion['muni_dele'])).", ".utf8_encode(utf8_decode($row_Direccion['estado'])).", ".utf8_encode(utf8_decode($row_Direccion['pais']))." CP ".$row_Direccion['cp']; ?>
  </p>
  <p style="font-size:11px;">
  <?php echo "ENTRE LA CALLE ".$row_Direccion['entre_calle_1']." Y LA CALLE ".$row_Direccion['entre_calle_2']; ?>
  </p></li>
  <li><p style="font-size:11px;"><?php echo "Tipo envío: ".$desc; ?></p></li>
  </ul>
  </div>
  
</div>






</div>




<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Close</button>

<?php
//muestra boton de imprimir solo si ya esta en estatus 3-PAGADO
if($row_ProductosPedidos2['estatus']==3)
{
	?>
    <a href="estampa.php?id_pedido=<?php echo $_GET['id_pedido']; ?>" target="_blank"><button type="button" class="btn btn-default" style="background-color:#244e58; border:#244e58; color:#ffffff;" ><span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span>&nbsp;Estampa</button></a>
    <?php	
}
?>



<?php
//muestra boton de pagado solo si esta en estatus 2-pendiente
if($row_ProductosPedidos2['estatus']==2)
{
	?>
    <a href="ajax_contenido_ticket.php?id_pedido=<?php echo $_GET['id_pedido']; ?>&pagado=1&email=<?php echo $row_Usuario['email']; ?>"><button type="button" class="btn btn-primary" style="background-color:#244e58; border:#244e58;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Pagado</button></a>
    <?php	
}
?>



</div>





<?php
mysqli_free_result($ProductosPedidos);
?>
