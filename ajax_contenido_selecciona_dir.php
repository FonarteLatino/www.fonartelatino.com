<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('Connections/conexion.php'); 

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






//existen direcciones de este usuario
mysql_select_db($database_conexion, $conexion);
$query_Direccion = "SELECT * FROM direcciones where id=".$_GET['id_dir2'];
$Direccion  = mysql_query($query_Direccion, $conexion) or die(mysql_error());
$row_Direccion  = mysql_fetch_assoc($Direccion );
$totalRows_Direccion  = mysql_num_rows($Direccion );


//envio expres Mexico
mysql_select_db($database_conexion, $conexion);
$query_ExpresMexico = "SELECT * FROM envios where id=1";
$ExpresMexico  = mysql_query($query_ExpresMexico, $conexion) or die(mysql_error());
$row_ExpresMexico  = mysql_fetch_assoc($ExpresMexico );
$totalRows_ExpresMexico  = mysql_num_rows($ExpresMexico );
//envio expres USA y Canada
mysql_select_db($database_conexion, $conexion);
$query_ExpresUSACanada = "SELECT * FROM envios where id=2";
$ExpresUSACanada  = mysql_query($query_ExpresUSACanada, $conexion) or die(mysql_error());
$row_ExpresUSACanada  = mysql_fetch_assoc($ExpresUSACanada );
$totalRows_ExpresUSACanada  = mysql_num_rows($ExpresUSACanada );
//envio expres RESTO DEL MUNDO
mysql_select_db($database_conexion, $conexion);
$query_ExpresRestoMundo = "SELECT * FROM envios where id=3";
$ExpresRestoMundo  = mysql_query($query_ExpresRestoMundo, $conexion) or die(mysql_error());
$row_ExpresRestoMundo  = mysql_fetch_assoc($ExpresRestoMundo );
$totalRows_ExpresRestoMundo  = mysql_num_rows($ExpresRestoMundo );
//envio local Mexico
mysql_select_db($database_conexion, $conexion);
$query_LocalMexico = "SELECT * FROM envios where id=4";
$LocalMexico  = mysql_query($query_LocalMexico, $conexion) or die(mysql_error());
$row_LocalMexico  = mysql_fetch_assoc($LocalMexico );
$totalRows_LocalMexico  = mysql_num_rows($LocalMexico );
//envio local USA Y CANADA
mysql_select_db($database_conexion, $conexion);
$query_LocalUSACanada = "SELECT * FROM envios where id=5";
$LocalUSACanada  = mysql_query($query_LocalUSACanada, $conexion) or die(mysql_error());
$row_LocalUSACanada  = mysql_fetch_assoc($LocalUSACanada );
$totalRows_LocalUSACanada  = mysql_num_rows($LocalUSACanada );
//envio local RESTO DEL MUNDO
mysql_select_db($database_conexion, $conexion);
$query_LocalRestoMundo = "SELECT * FROM envios where id=6";
$LocalRestoMundo  = mysql_query($query_LocalRestoMundo, $conexion) or die(mysql_error());
$row_LocalRestoMundo  = mysql_fetch_assoc($LocalRestoMundo );
$totalRows_LocalRestoMundo  = mysql_num_rows($LocalRestoMundo );




if(isset($_POST['insert_dir']) and ($_POST['insert_dir']==1))
{
		
	//****************************************************************************************************
	//ENVIO A MEXICO EXPRESS
	if($_POST['tipo_envio']==1 and $row_Direccion['id_pais']==42)//es direccion de la republica mexicana
	{
		//toma el costo de envio de mexico
		mysql_select_db($database_conexion, $conexion);
		$query_CostoEnvio = "SELECT * FROM envios where id=1";
		$CostoEnvio  = mysql_query($query_CostoEnvio, $conexion) or die(mysql_error());
		$row_CostoEnvio = mysql_fetch_assoc($CostoEnvio );
		$totalRows_CostoEnvio = mysql_num_rows($CostoEnvio );

	}
	//ENVIO A MEXICO LOCAL
	else if($_POST['tipo_envio']==2 and $row_Direccion['id_pais']==42)//es direccion de la republica mexicana
	{
		//toma el costo de envio de mexico
		mysql_select_db($database_conexion, $conexion);
		$query_CostoEnvio = "SELECT * FROM envios where id=4";
		$CostoEnvio  = mysql_query($query_CostoEnvio, $conexion) or die(mysql_error());
		$row_CostoEnvio = mysql_fetch_assoc($CostoEnvio );
		$totalRows_CostoEnvio = mysql_num_rows($CostoEnvio );

	}
	
	
	//****************************************************************************************************
	//ENVIO A ESTADOS UNIDOS O CANADA EXPRES
	else if($_POST['tipo_envio']==1 and ($row_Direccion['id_pais']==55 or $row_Direccion['id_pais']==32))
	{
		//estados unidos y canada
		mysql_select_db($database_conexion, $conexion);
		$query_CostoEnvio = "SELECT * FROM envios where id=2";
		$CostoEnvio  = mysql_query($query_CostoEnvio, $conexion) or die(mysql_error());
		$row_CostoEnvio = mysql_fetch_assoc($CostoEnvio );
		$totalRows_CostoEnvio = mysql_num_rows($CostoEnvio );
	}
	//ENVIO A ESTADOS UNIDOS O CANADA LOCAL
	else if($_POST['tipo_envio']==2 and ($row_Direccion['id_pais']==55 or $row_Direccion['id_pais']==32))
	{
		//estados unidos y canada
		mysql_select_db($database_conexion, $conexion);
		$query_CostoEnvio = "SELECT * FROM envios where id=5";
		$CostoEnvio  = mysql_query($query_CostoEnvio, $conexion) or die(mysql_error());
		$row_CostoEnvio = mysql_fetch_assoc($CostoEnvio );
		$totalRows_CostoEnvio = mysql_num_rows($CostoEnvio );
	}
	
	
	//ENVIO A EL RESTO DEL MUNDO EXPRES
	else if($_POST['tipo_envio']==1 and ($row_Direccion['id_pais']!=55 or $row_Direccion['id_pais']!=32))
	{
		//resto del mundo
		mysql_select_db($database_conexion, $conexion);
		$query_CostoEnvio = "SELECT * FROM envios where id=3";
		$CostoEnvio  = mysql_query($query_CostoEnvio, $conexion) or die(mysql_error());
		$row_CostoEnvio = mysql_fetch_assoc($CostoEnvio );
		$totalRows_CostoEnvio = mysql_num_rows($CostoEnvio );
	}
	
	//ENVIO A EL RESTO DEL MUNDO LOCAL
	else if($_POST['tipo_envio']==2 and ($row_Direccion['id_pais']!=55 or $row_Direccion['id_pais']!=32))
	{
		//resto del mundo
		mysql_select_db($database_conexion, $conexion);
		$query_CostoEnvio = "SELECT * FROM envios where id=6";
		$CostoEnvio  = mysql_query($query_CostoEnvio, $conexion) or die(mysql_error());
		$row_CostoEnvio = mysql_fetch_assoc($CostoEnvio );
		$totalRows_CostoEnvio = mysql_num_rows($CostoEnvio );
	}
		
		

	// inicio de genera numero de pedido
	if(!isset($_SESSION['PEDIDO_NUEVO']))
	{
		
		
		// genera numero de pedido
		$insertSQL = sprintf("INSERT INTO pedido (id_usuario, id_direccion, forma_pago, precio_envio, estatus, descripcion_estatus, fecha, hora) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_SESSION['USUARIO_ECOMMERCE']['id'], "int"),
		GetSQLValueString($_POST['id_direccion'], "int"),
		GetSQLValueString('NA', "text"),
		GetSQLValueString($row_CostoEnvio['precio'], "int"),
		GetSQLValueString(1, "int"),
		GetSQLValueString('ESTA COMPRANDO', "text"),
		GetSQLValueString(date('Y-m-d'), "date"),
		GetSQLValueString(date('H:i:s'), "date"));
		mysql_select_db($database_conexion, $conexion);
		$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
		
		//tomamos el numero de pedido que se genero
		mysql_select_db($database_conexion, $conexion);
		$query_NumPedido = "SELECT max(id) as id_pedido FROM pedido where id_usuario=".$_SESSION['USUARIO_ECOMMERCE']['id'];
		$SelectNumPedido = mysql_query($query_NumPedido, $conexion) or die(mysql_error());
		$row_NumPedido  = mysql_fetch_assoc($SelectNumPedido);
		$totalRows_NumPedido  = mysql_num_rows($SelectNumPedido);
		
		$_SESSION['PEDIDO_NUEVO']  = $row_NumPedido['id_pedido']; 	
	}
	else
	{
		$updateSQL = sprintf("UPDATE pedido SET id_direccion=%s WHERE id=%s",
		GetSQLValueString($_GET['id_dir2'], "int"),
		GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
		
		mysql_select_db($database_conexion, $conexion);
		$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	}
	
	//¿Existen productos de este pedidos? (en caso de que ya que iba a pagar  y regresa a agrega otro producto al carrito o a cambiar la direccion)
	
	mysql_select_db($database_conexion, $conexion);
	$query_ExisteProductosPedido = "SELECT * FROM pedido_productos where id_pedido=".$_SESSION['PEDIDO_NUEVO'];
	$ExisteProductosPedido  = mysql_query($query_ExisteProductosPedido, $conexion) or die(mysql_error());
	$row_ExisteProductosPedido = mysql_fetch_assoc($ExisteProductosPedido );
	$totalRows_ExisteProductosPedido  = mysql_num_rows($ExisteProductosPedido );
	//si ya tiene pedidos este usuario se los borra para despues insertar las modificaciones
	if($row_ExisteProductosPedido>=1)
	{
		$deleteSQL = sprintf("DELETE FROM pedido_productos WHERE id_pedido=%s",
		GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
		mysql_select_db($database_conexion, $conexion);
		$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());
	
	}
	
	
	//¿Existen algun cupon usado por este pedido? (en caso de que ya que iba a pagar  y regresa a agrega otro producto al carrito o a cambiar la direccion)
	
	mysql_select_db($database_conexion, $conexion);
	$query_ExisteCuponPedido = "SELECT * FROM cupon where usado_por_pedido=".$_SESSION['PEDIDO_NUEVO'];
	$ExisteCuponPedido  = mysql_query($query_ExisteCuponPedido, $conexion) or die(mysql_error());
	$row_ExisteCuponPedido = mysql_fetch_assoc($ExisteCuponPedido );
	$totalRows_ExisteCuponPedido  = mysql_num_rows($ExisteCuponPedido );
	//si ya tiene pedidos este usuario se los borra para despues insertar las modificaciones
	if($totalRows_ExisteCuponPedido>=1)
	{
		$updateSQL = sprintf("UPDATE cupon SET usado_por_pedido=%s, estatus=%s WHERE usado_por_pedido=%s",
		GetSQLValueString('', "int"),
		GetSQLValueString('DISPONIBLE', "text"),
		GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
		
		mysql_select_db($database_conexion, $conexion);
		$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	}
	
	//toma los productos del carrito
	mysql_select_db($database_conexion, $conexion);
	$query_Carrito = "SELECT * FROM carrito where id_usr=".$_SESSION['USUARIO_ECOMMERCE']['id'];
	$Carrito  = mysql_query($query_Carrito, $conexion) or die(mysql_error());
	$row_Carrito = mysql_fetch_assoc($Carrito );
	$totalRows_Carrito  = mysql_num_rows($Carrito );
	
	$subtotal_productos=0;
	do
	{

	$insertSQL = sprintf("INSERT INTO pedido_productos (id_pedido, id_producto, id_producto_fonarte, tipo, artista, album, cantidad, precio, precio_final , fecha_hora) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"),
	GetSQLValueString($row_Carrito['id_producto'], "int"),
	GetSQLValueString($row_Carrito['id_producto_fonarte'], "text"),
	GetSQLValueString($row_Carrito['tipo'], "text"),
	GetSQLValueString($row_Carrito['artista'], "text"),
	GetSQLValueString($row_Carrito['album'], "text"),
	GetSQLValueString($row_Carrito['cantidad'], "text"),
	GetSQLValueString($row_Carrito['precio'], "int"),
	GetSQLValueString($row_Carrito['precio'], "int"),
	GetSQLValueString(date('Y-m-d H:i:s'), "date"));
	
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
	
	$subtotal_productos=$subtotal_productos+($row_Carrito['cantidad']*$row_Carrito['precio']);
		
	}while($row_Carrito = mysql_fetch_assoc($Carrito ));
	
	
	$insertGoTo = "pago.php";
	if (isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	

	$total=$subtotal_productos+$row_CostoEnvio['precio'];

//asina los siguientes campos al pedido 
	$updateSQL = sprintf("UPDATE pedido SET subtotal_productos=%s,   total=%s, id_envio=%s, precio_envio=%s, cupon_aplicado=%s WHERE id=%s",
	GetSQLValueString($subtotal_productos, "int"),
	GetSQLValueString($total, "int"),
	GetSQLValueString($row_CostoEnvio['id'], "int"),
	GetSQLValueString($row_CostoEnvio['precio'], "int"),
	GetSQLValueString('', "text"),
	GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
		
		
	?><script type="text/javascript">window.location="<?php echo $insertGoTo; ?>";</script><?php
	
}

?>

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <h4 class="modal-title" id="myModalLabel" style="color:#244e58;">#<?php echo $_GET['id_dir2']; ?>&nbsp;&nbsp;&#191;Selecciona tipo de envío?</h4>
    </div>
    
	<form action="ajax_contenido_selecciona_dir.php?id_dir2=<?php echo $_GET['id_dir2']; ?>" method="post">
	<div class="modal-body">

    <label class="radio-inline" style="font-size:12px; padding:3%; margin:0px;">
        <input type="radio" name="tipo_envio" value="1" style="transform: scale(2);" checked="checked"><span style="font-size:18px;">Servicio Express</span><br />
        
        <table class="table table-striped">
        	<tr>
                <td style="padding:1%; width:10%;"><?php echo "$".$row_ExpresMexico['precio'].".00"; ?></td>
                <td style="padding:1%; width:20%;"><?php echo $row_ExpresMexico['region']; ?></td>
                <td style="padding:1%"><?php echo utf8_encode($row_ExpresMexico['descripcion']); ?></td>
            </tr>
            <tr>
                <td style="padding:1%;"><?php echo "$".$row_ExpresUSACanada['precio'].".00"; ?></td>
                <td style="padding:1%"><?php echo $row_ExpresUSACanada['region']; ?></td>
                <td style="padding:1%"><?php echo utf8_encode($row_ExpresUSACanada['descripcion']); ?></td>
            </tr>
            <tr>
                <td style="padding:1%"><?php echo "$".$row_ExpresRestoMundo['precio'].".00"; ?></td>
                <td style="padding:1%"><?php echo $row_ExpresRestoMundo['region']; ?></td>
                <td style="padding:1%"><?php echo utf8_encode($row_ExpresRestoMundo['descripcion']); ?></td>
            </tr>
        </table>
    </label>

    <label class="radio-inline" style="font-size:12px; padding:3%; margin:0px;">
    	<input type="radio" name="tipo_envio" value="2" style="transform: scale(2);"><span style="font-size:18px;">Servicio Ordinario</span><br />

        <table class="table table-striped">
        	<tr>
                <td style="padding:1%; width:10%;"><?php echo "$".$row_LocalMexico['precio'].".00"; ?></td>
                <td style="padding:1%; width:20%;"><?php echo $row_LocalMexico['region']; ?></td>
                <td style="padding:1%"><?php echo utf8_encode($row_LocalMexico['descripcion']); ?></td>
            </tr>
            <tr>
                <td style="padding:1%;"><?php echo "$".$row_LocalUSACanada['precio'].".00"; ?></td>
                <td style="padding:1%"><?php echo $row_LocalUSACanada['region']; ?></td>
                <td style="padding:1%"><?php echo utf8_encode($row_LocalUSACanada['descripcion']); ?></td>
            </tr>
            <tr>
                <td style="padding:1%"><?php echo "$".$row_LocalRestoMundo['precio'].".00"; ?></td>
                <td style="padding:1%"><?php echo $row_LocalRestoMundo['region']; ?></td>
                <td style="padding:1%"><?php echo utf8_encode($row_LocalRestoMundo['descripcion']); ?></td>
            </tr>
        </table>
    </label>
   


	</div>

  	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
        <input type="hidden" name="insert_dir" value="1">
        <input type="hidden" name="id_direccion" value="<?php echo $_GET['id_dir2']; ?>">
        <button type="submit" class="btn btn-primary"  style="background-color:#244e58; border:#244e58;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Siguiente</button>
  	</div>
</form>

