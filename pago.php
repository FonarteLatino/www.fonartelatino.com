<?php 
if (!isset($_SESSION)) {
  session_start();
}
if(!isset($_SESSION['USUARIO_ECOMMERCE']))//SI NO EXISTE UNA SESION REDIRECCIONA
{
	?><script type="text/javascript">window.location="index";</script><?php
}

if(!isset($_SESSION['PEDIDO_NUEVO']))//SI NO EXISTE UNA SESION REDIRECCIONA
{
	?><script type="text/javascript">window.location="index";</script><?php
}





require_once('Connections/conexion.php'); 

require_once('rutas_absolutas.php'); 


?>
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




//selecciona pedido
mysql_select_db($database_conexion, $conexion);
$query_Pedido1 = "SELECT * from pedido where id=".$_SESSION['PEDIDO_NUEVO'];
$Pedido1 = mysql_query($query_Pedido1, $conexion) or die(mysql_error());
$row_Pedido1 = mysql_fetch_assoc($Pedido1);
$totalRows_Pedido1 = mysql_num_rows($Pedido1);



//selecciona productos de este pedido
mysql_select_db($database_conexion, $conexion);
$query_PedidoProductos = "SELECT * from pedido_productos where id_pedido=".$_SESSION['PEDIDO_NUEVO'];
$PedidoProductos = mysql_query($query_PedidoProductos, $conexion) or die(mysql_error());
$row_PedidoProductos = mysql_fetch_assoc($PedidoProductos);
$totalRows_PedidoProductos = mysql_num_rows($PedidoProductos);
	
	//seleccciona la direccion que escogio este usuario para este pedido
mysql_select_db($database_conexion, $conexion);
$query_Direccion = "SELECT
direcciones.id,
direcciones.id_usr,
direcciones.calle,
direcciones.colonia,
direcciones.muni_dele,
direcciones.cp,
direcciones.n_ext,
direcciones.n_int,
direcciones.id_pais,
direcciones.pais,
direcciones.estado,
direcciones.entre_calle_1,
direcciones.entre_calle_2,
direcciones.nombre_recibe,
direcciones.tel_recibe,
direcciones.estatus
FROM
direcciones
INNER JOIN pedido ON pedido.id_direccion = direcciones.id
where pedido.id=".$_SESSION['PEDIDO_NUEVO'];
$Direccion = mysql_query($query_Direccion, $conexion) or die(mysql_error());
$row_Direccion = mysql_fetch_assoc($Direccion);
$totalRows_Direccion = mysql_num_rows($Direccion);
	


//verifica si el cupon es valido, si es valido aplica el descuento
if(isset($_POST['aplica_cupon']) and ($_POST['aplica_cupon']==21))
{
	//1----VERIFICA SI EXISTE UN CUPON CON ESTE CODIGO 
	mysql_select_db($database_conexion, $conexion);
	$query_ExisteCupon = "SELECT * from cupon where codigo='".$_POST['cupon']."'";
	$ExisteCupon = mysql_query($query_ExisteCupon, $conexion) or die(mysql_error());
	$row_ExisteCupon = mysql_fetch_assoc($ExisteCupon);
	$totalRows_ExisteCupon = mysql_num_rows($ExisteCupon);
	
	if($totalRows_ExisteCupon==0)//el codigo no existe
	{
		?><script type="text/javascript">window.location="pago.php?alerta=206";</script><?php
	}
	else
	{
		// 2-----VERIFICA SI EXISTE UN CUPON DISPONIBLE 
		mysql_select_db($database_conexion, $conexion);
		$query_ExisteCuponDiponible = "SELECT * from cupon where codigo='".$_POST['cupon']."' and  estatus='DISPONIBLE'";
		$ExisteCuponDiponible = mysql_query($query_ExisteCuponDiponible, $conexion) or die(mysql_error());
		$row_ExisteCuponDiponible = mysql_fetch_assoc($ExisteCuponDiponible);
		$totalRows_ExisteCuponDiponible = mysql_num_rows($ExisteCuponDiponible);

		
		if($totalRows_ExisteCuponDiponible==0)//cupon si existe pero ya esta agotado
		{
			?>
<script type="text/javascript">window.location="pago.php?alerta=207";</script><?php
		}
		else//si existe el cupon y aun existe DISPONIBLE
		{
			//  3-----VERIFICA SI EL CODIGO ESTA VIGENTE
			$hoy=date("Y-m-d");
			if($hoy > $row_ExisteCupon['vencimiento'])
			{
				?><script type="text/javascript">window.location="pago.php?alerta=208";</script><?php
			}
			else
			{
				//  4-----PREGUNTA CUANTOS PRODUCTOS COMPRO, SI SON MAYORES A LOS QUE ESPECIFICA EL CUPON, LO APLICA
				mysql_select_db($database_conexion, $conexion);
				$query_CatidadProductos = "SELECT * from pedido_productos where id_pedido=".$_SESSION['PEDIDO_NUEVO'];
				$CatidadProductos = mysql_query($query_CatidadProductos, $conexion) or die(mysql_error());
				$row_CatidadProductos= mysql_fetch_assoc($CatidadProductos);
				$totalRows_CatidadProductos = mysql_num_rows($CatidadProductos);
				
				$total_productos=0;
				do{
					$total_productos=$total_productos+$row_CatidadProductos['cantidad'];
				}while($row_CatidadProductos= mysql_fetch_assoc($CatidadProductos));
				
				if($total_productos<$row_ExisteCupon['mas_de'])//los productos son igual o mayor a los requeridos
				{
					?><script type="text/javascript">window.location="pago.php?alerta=209&minimo=<?php echo $row_ExisteCupon['mas_de']; ?>";</script><?php
				}
				else
				{
					
// ********************************************* INICIO DE APLICA EL CUPON DE DESCUENTO, PASO TODAS LAS REGLAS
// -EL CUPON EXISTE -EXISTEN CUPONES DISPONIBLE   - EL CUPON ESTA VIGENTE    - LA COMPRA ES MAYOR O IGUAL A LOS PRODUCTOS REQUERIDOS  	

	//le aparta este cupon a este pedido
	$updateSQL = sprintf("UPDATE cupon SET usado_por_pedido=%s, estatus=%s WHERE id=%s",
	GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"),
	GetSQLValueString('PENDIENTE', "text"),
	GetSQLValueString($row_ExisteCuponDiponible['id'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
							
				
	//Selecciona el pedido comprar
	mysql_select_db($database_conexion, $conexion);
	$query_PedidoCupon = "SELECT * from pedido where id=".$_SESSION['PEDIDO_NUEVO'];
	$PedidoCupon  = mysql_query($query_PedidoCupon, $conexion) or die(mysql_error());
	$row_PedidoCupon = mysql_fetch_assoc($PedidoCupon );
	$totalRows_PedidoCupon  = mysql_num_rows($PedidoCupon );	

	 
	// verifica que tipo de descuento realizara, porcentaje o en pesos
	if($row_ExisteCupon['medida']=='PESOS')
	{
		$precio_con_descuento=$row_PedidoCupon['subtotal_productos']-$row_ExisteCuponDiponible['descuento']+$row_PedidoCupon['precio_envio'];
	}
	else
	{
		$desc=".".$row_ExisteCuponDiponible['descuento'];
		$precio_con_descuento=$row_PedidoCupon['subtotal_productos']-($row_PedidoCupon['subtotal_productos']*$desc)+$row_PedidoCupon['precio_envio'];

	}
		
			
	$updateSQL = sprintf("UPDATE pedido SET total=%s, cupon_aplicado=%s WHERE id=%s",
	GetSQLValueString($precio_con_descuento, "int"),
	GetSQLValueString($_POST['cupon'], "text"),
	GetSQLValueString($_SESSION['PEDIDO_NUEVO'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	
	//toma el detalle del cupon
	mysql_select_db($database_conexion, $conexion);
	$query_CuponDetalle = "SELECT * from cupon where codigo='".$_POST['cupon']."'";
	$CuponDetalle  = mysql_query($query_CuponDetalle, $conexion) or die(mysql_error());
	$row_CuponDetalle= mysql_fetch_assoc($CuponDetalle );
	$totalRows_CuponDetalle  = mysql_num_rows($CuponDetalle );

					
?><script type="text/javascript">window.location="pago.php?alerta=210&desc=<?php echo $row_CuponDetalle['descuento']; ?>&medida=<?php echo $row_CuponDetalle['medida']; ?>";</script><?php
// ********************************************* FIN DE APLICA EL CUPON DE DESCUENTO, PASO TODAS LAS REGLAS					
					
				}
				

			}
		}
		
		
	}
}
	
	
	

	
?>

 <?php include("alertas.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" type="image/png" href="http://www.fonartelatino.com/img/favicon.png" />
   <meta charset="ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Pago</title>
  
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/modern-business.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i, 900" rel="stylesheet">
</head>

<body oncontextmenu="return false">

    <?php include("menu.php"); ?>

    <!-- Page Content -->
    
		
        
        <!-- Inicio de titulo de la pagina -->
        <div class="container" style="width:100%;" >
        <div class="row franja" >
            <div class="col-lg-12">
                <div class="container">
                    <p class="page-header">Pago<small>&nbsp;</small></p>
                </div>
            </div>
        </div>
        </div>
        <!-- Fin de titulo de la pagina -->

<div class="container">
        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
  
            
                 <br><br>
      
              <?php /*echo $updateSQL;
			  echo"<br>".$row_ExisteCuponDiponible['id']; 
			  echo"<br>".$query_ExisteCuponDiponible; */?>   
                 <!-- ======================== INICIO DE PASOS ======================================== -->
<div class="row tipografia2">
 
<div class="col-sm-3">
<button type="button" class="btn btn-default" onClick="location.href='carrito.php'" style="text-align:center; color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px;border:2px solid #ffffff; width:100%;"><i class="fa fa-shopping-cart  fa-1x" aria-hidden="true"></i>&nbsp;Carrito &nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px; border:2px solid #ffffff; width:100%;"><i class="fa fa-lock fa-1x" aria-hidden="true"></i>&nbsp;Iniciar Sesi&oacute;n &nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
</div>

<div class="col-sm-3">
<button type="button" class="btn btn-default" onClick="location.href='direcciones_envio.php'" style="text-align:center;color:#ffffff; background-color:#244e58;border-radius: 0px 200px 200px 0px; border:2px solid #ffffff; width:100%;"><i class="fa fa-share fa-1x" aria-hidden="true"></i>&nbsp;Direcci&oacute;n de Env&iacute;o &nbsp;<i class="fa fa-check" aria-hidden="true"></i></button>
</div>


<div class="col-sm-3">
<button type="button" class="btn btn-default" style="text-align:center;border-radius: 0px 200px 200px 0px;background-color:#244e58; color:#ffffff;  border:2px solid #ffffff; width:100%;"><i class="fa fa-usd fa-1x" aria-hidden="true"></i>&nbsp;Pago</button>
</div>
  
</div>
<!-- ======================== FIN DE PASOS ======================================== -->

<br>

<?php include("pinta_alerta.php"); ?>

       
  <h3 class="tipografia2" style="text-align:center">Detalle de compra</h3>         
           <br>
<div class="row">
    <div class="col-sm-6">
    
    
    
    <div class="table-responsive">          
  <table class="table tipografia2">
    <thead>
      <tr>
        <th>#</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unitario</th>
        <th>Precio Total </th>
      </tr>
    </thead>
 <?php 
$contador=1;
$subtotal_pedido=0;
do{
	
	?>

      <tr>
        <td><?php echo $contador; ?></td>
        <td><?php echo utf8_encode($row_PedidoProductos['artista']).", ".utf8_encode($row_PedidoProductos['album']); ?></td>
        <td><?php echo $row_PedidoProductos['cantidad']; ?></td>
		<?php
        $subtotal_producto=$row_PedidoProductos['precio_final']*$row_PedidoProductos['cantidad'];
        ?>
        <td><?php echo "$".$row_PedidoProductos['precio_final'].".00"; ?></td>
        <td><?php echo "$".$subtotal_producto.".00"; ?></td>

      </tr>
  
    
    <?php
	
    $subtotal_pedido=$subtotal_pedido+$subtotal_producto;
    $contador=$contador+1;
    
}while($row_PedidoProductos= mysql_fetch_assoc($PedidoProductos)); 






?>



<?php
if(isset($_GET['desc']))
{
	if($_GET['medida']=='PESOS'){ $signo='$'; }
	else{ $signo='%'; }
?>
<tr>
    <td colspan="4" style="text-align:right">Descuento de cupon:</td>
    <td><?php echo "-".$signo." ".$_GET['desc']; ?></td>
</tr>
<?php	
}
?>




<?php


mysql_select_db($database_conexion, $conexion);
$query_DatoEnvio = "SELECT * from envios where id=".$row_Pedido1['id_envio'];
$DatoEnvio  = mysql_query($query_DatoEnvio, $conexion) or die(mysql_error());
$row_DatoEnvio = mysql_fetch_assoc($DatoEnvio );
$totalRows_DatoEnvio = mysql_num_rows($DatoEnvio );
	
	
// toma la descripcion del envio cuando el precio de envio es 0 o diferente a 0
if($row_Direccion['id_pais']==42)//envio en MEXICO
{
	mysql_select_db($database_conexion, $conexion);
	$query_DescripEnvio = "SELECT * from envios where id=1";
	$DescripEnvio = mysql_query($query_DescripEnvio, $conexion) or die(mysql_error());
	$row_DescripEnvio= mysql_fetch_assoc($DescripEnvio);
	$totalRows_DescripEnvio = mysql_num_rows($DescripEnvio);
	
	$des=$row_DescripEnvio['descripcion'];
	$pre="$".$row_DescripEnvio['precio'].".00";
	$envio_a='mexico';
}
else if($row_Direccion['id_pais']==55 or $row_Direccion['id_pais']==32)//ENVIO estados unidos y canada
{
	mysql_select_db($database_conexion, $conexion);
	$query_DescripEnvio = "SELECT * from envios where id=2";
	$DescripEnvio = mysql_query($query_DescripEnvio, $conexion) or die(mysql_error());
	$row_DescripEnvio= mysql_fetch_assoc($DescripEnvio);
	$totalRows_DescripEnvio = mysql_num_rows($DescripEnvio);
	
	$des=$row_DescripEnvio['descripcion'];
	$pre="$".$row_DescripEnvio['precio'].".00";
	$envio_a='usa_canada';
}
else//fuera de Mexico, Estados Unidos y Canada
{
	mysql_select_db($database_conexion, $conexion);
	$query_DescripEnvio = "SELECT * from envios where id=3";
	$DescripEnvio = mysql_query($query_DescripEnvio, $conexion) or die(mysql_error());
	$row_DescripEnvio= mysql_fetch_assoc($DescripEnvio);
	$totalRows_DescripEnvio = mysql_num_rows($DescripEnvio);
	
	$des="<span style='color:red;'>".utf8_encode($row_DescripEnvio['descripcion'])."</span>";
	$pre="<span style='color:red; font-size:12px;'>PENDIENTE</span>";
	$envio_a='resto_mundo';
}

?>

<tr>
    <td colspan="3" style="font-size:10px; font-style:italic; font-weight:bold;"><?php echo utf8_encode($row_DatoEnvio['descripcion']); ?></td>
    <td style="text-align:right">Envio:</td>
    <td><?php echo "$".$row_DatoEnvio['precio'].".00"; ?> </td>
</tr>




<?php
$total=$subtotal_pedido+$row_Pedido1['precio_envio'];
?>

<tr>
    <td colspan="4" style="text-align:right">Total:</td>
    <td><?php echo "$".$row_Pedido1['total'].".00"; ?> </td>
</tr>

  </table>
</div>

<div class="container" style="width:100%">

<form class="form-horizontal tipografia2" action="pago.php" method="post">
  <div class="form-group">
    <p>C&oacute;digo de descuento:</p>
      <input type="text" class="form-control" name="cupon"  id="id_cupon" placeholder="C&oacute;digo de descuento" style="width:50%">
       <span class="help-block"></span><!-- muestra texto de ayuda -->
      
      <input type="hidden" name="aplica_cupon" value="21">
      <br><button type="submit" class="btn btn-default" id="id_btn_cupon">Aplicar</button>
  </div>
</form>

</div>


</div>


    
    

   
    
    
    <div class="col-sm-6 tipografia2" style="border:3px solid #ffffff;background-color: #eee; padding-left: 3%; padding-right: 3%;padding-bottom: 2%;padding-top: 2%;border-radius: 15px 15px 15px 15px;">
   <center><label>Datos de env&iacute;o</label></center>
    <p><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo utf8_encode($row_Direccion['nombre_recibe']); ?></p>
    
    <p><span class="glyphicon glyphicon-earphone"></span>&nbsp;<?php echo $row_Direccion['tel_recibe']; ?></p>
    
    <p><span class="glyphicon glyphicon-home"></span>&nbsp;<?php echo utf8_encode($row_Direccion['calle'])." Ext. ".utf8_encode($row_Direccion['n_ext'])." Int. ".utf8_encode($row_Direccion['n_int'])." ".utf8_encode($row_Direccion['colonia'])." ".utf8_encode($row_Direccion['muni_dele'])." ,".utf8_encode($row_Direccion['estado'])." ,".utf8_encode($row_Direccion['pais'])." C.P.".$row_Direccion['cp'] ; ?>.<br>&nbsp;ENTRE LA CALLE <?php echo utf8_encode($row_Direccion['entre_calle_1'])." Y ".utf8_encode($row_Direccion['entre_calle_2']); ?></p>
    <p></p>
    
    
    
    </div>
</div>

           
     
      <center>  
      <?php
	  if($envio_a=='resto_mundo')//el pedido es fuera de MEXICO, ESTADOS UNIDOS Y CANADA
	  {
		  ?>
          <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#resto_mundo" style="margin-top:6px;"><span class="glyphicon glyphicon-paste"></span>&nbsp;Realizar Pedido</button>
          <?php
	  }
	  else// EL PEDIDO ES EN MEXICO, USA O CANADA
	  {
		?>
        <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#pagobancario" style="margin-top:6px;"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Pago Bancario</button>
     
     <button type="button" class="btn btn-default" data-toggle="modal" data-target="#pagopaypal" style="margin-top:6px;"><i class="fa fa-paypal" aria-hidden="true"></i>&nbsp;Pago por PayPal</button>
        <?php  
	  }
	  ?>
         
     
     
         </center>  
           
       <br><br>         
           

<!-- ============================== Inicio Modal resto del mundo ====================== -->
<div class="modal fade" id="resto_mundo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content tipografia2">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-paste"></span>&nbsp;Realizar pedido</h4>
      </div>
      <div class="modal-body">
        
        <br>
        <h1 style="text-align:center;">&#191;Confirmar compra?</h1>
        <br>
		<h4 style="text-align:center;">El vendedor se pondra en contacto contigo para calcular el costo de envio</h4>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</button>
        <a href="pedido_resto_mundo.php"><button type="button" class="btn btn-primary" style="background-color:#244e58; border:#244e58;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Si</button></a>
      </div>
    </div>
  </div>
</div>
<!-- ============================== fin Modal resto del mundo ====================== -->




<!-- ============================== Inicio Modal pago bancario ====================== -->
<div class="modal fade" id="pagobancario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content tipografia2">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-money" aria-hidden="true"></i>&nbsp;Pago en ventanilla bancaria</h4>
      </div>
      <div class="modal-body">
        
        <br>
        <h1 style="text-align:center;">&#191;Confirmar compra?</h1>
        <br>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</button>
        <a href="pago_bancario.php"><button type="button" class="btn btn-primary" style="background-color:#244e58; border:#244e58;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Si</button></a>
      </div>
    </div>
  </div>
</div>
<!-- ============================== fin Modal pago bancario ====================== -->





<!-- ============================== Inicio Modal PayPal ====================== -->
<div class="modal fade" id="pagopaypal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content tipografia2">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-paypal" aria-hidden="true"></i>&nbsp;Pago por PayPal</h4>
      </div>
      <div class="modal-body">
        
        <br>
        <h1 style="text-align:center;">&#191;Confirmar compra?</h1>
        <br>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;No</button>
        <a href="pago_paypal.php"><button type="button" class="btn btn-primary" style="background-color:#244e58; border:#244e58;"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Si</button></a>
      </div>
    </div>
  </div>
</div>
 <!-- ============================== fin Modal PayPal ====================== -->          
           
            
            
            
               
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
    
     
    <?php include("pie.php"); ?>



    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/valida_cupon_aplicarlo.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    
<?php
/*

Este codigo es propiedad de
Lic. Javier Alfredo Garcia Espinoza
j.garcia.e1987@gmail.com

*/
?>

</body>

</html>
<?php
//mysql_free_result($ExisteCupon);

//mysql_free_result($JuegoUpdatePedidoProductos);
?>
