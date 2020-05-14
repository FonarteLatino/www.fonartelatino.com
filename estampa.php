<?php 
if (!isset($_SESSION)) {
  session_start();
}

require_once('Connections/conexion.php'); ?>
<?php

$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php?alerta=3";
if (!((isset($_SESSION['MM_Username_Panel'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username_Panel'], $_SESSION['MM_UserGroup_Panel'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);

  ?><script type="text/javascript">window.location="<?php echo $MM_restrictGoTo; ?>";</script><?php
  exit;
}


//datos PEDIDO
mysqli_select_db($conexion,$database_conexion);
$query_Pedido = "SELECT * from pedido where id=".$_GET['id_pedido'];
$Pedido = mysqli_query($conexion,$query_Pedido) or die(mysqli_error($conexion));
$row_Pedido = mysqli_fetch_assoc($Pedido);
$totalRows_Pedido = mysqli_num_rows($Pedido);

//si el pedido aun no esta en estatus de PAGADO no permite ver la estampa
if($row_Pedido['estatus']!=3)
{
	?><script type="text/javascript">window.location="bienvenida.php";</script><?php
}

//datos CUPON (si aplico uno)
if($row_Pedido['cupon_aplicado']!='')
{
	mysqli_select_db($conexion,$database_conexion);
	$query_Cupon = "SELECT * from cupon where codigo='".$row_Pedido['cupon_aplicado']."'";
	$Cupon = mysqli_query($conexion,$query_Cupon) or die(mysqli_error($conexion));
	$row_Cupon = mysqli_fetch_assoc($Cupon);
	$totalRows_Cupon = mysqli_num_rows($Cupon);
	
	if($row_Cupon['medida']=='PORCENTAJE')
	{
		$descuento_aplicado="- %".$row_Cupon['descuento'];
	}
	else
	{
		$descuento_aplicado="- $".$row_Cupon['descuento'];
	}
}


					
//datos USUARIO
mysqli_select_db($conexion,$database_conexion);
$query_Usuario = "SELECT * from usuarios_ecommerce where id=".$row_Pedido['id_usuario'];
$Usuario = mysqli_query($conexion,$query_Usuario) or die(mysqli_error($conexion));
$row_Usuario = mysqli_fetch_assoc($Usuario);
$totalRows_Usuario = mysqli_num_rows($Usuario);

//datos DIRECCION
mysqli_select_db($conexion,$database_conexion);
$query_Direccion = "SELECT * from direcciones where id=".$row_Pedido['id_direccion'];
$Direccion = mysqli_query($conexion,$query_Direccion) or die(mysqli_error($conexion));
$row_Direccion = mysqli_fetch_assoc($Direccion);
$totalRows_Direccion = mysqli_num_rows($Direccion);

//tomamos los productos de su compra
mysqli_select_db($conexion,$database_conexion);
$query_Productos = "SELECT
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
where id_pedido=".$_GET['id_pedido'];
$Productos = mysqli_query($conexion,$query_Productos) or die(mysqli_error($conexion));
$row_Productos = mysqli_fetch_assoc($Productos);
$totalRows_Productos = mysqli_num_rows($Productos);






?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fonarte Latino | Estampa</title>
  
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

<body>

    <?php include("estilos.php"); ?>

    <!-- Page Content -->
    <div class="container">
		
         


        <!-- Content Row -->
        <div class="row">
            <div class="col-lg-12 tipografia2" style="width:50%;" id="imprime">
               <!-- Inicio 212121212121212121212121212121212121212121212121212121212121 -->
               
  

<!-- ============================================================================= --> 
<div class="row" >
    <div class="col-sm-12" style="text-align:center; border:1px solid #000000; background-color: #ffffff;padding-top: 5px; padding-bottom: 5px;">
    <img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
    </div>
</div>

<!-- ============================================================================= --> 
<div class="row">
    <div class="col-sm-12" style="border:1px solid #000000;">
    <p style="padding-top:6px;">N&uacute;mero de Pedido: #<?php echo $_GET['id_pedido']; ?></p>
    </div>
</div>

<!-- ============================================================================= --> 
<div class="row">
    <div class="col-sm-12" style="border:1px solid #000000; padding-top:15px;">
   <center>
    <table class="table table-bordered"  width="99%"  style="font-size:12px;" >
    <thead>
      <tr>
        <th style="width:20%; border:1px solid #000000;">Tipo de envio</th>
        <th style="width:20%; border:1px solid #000000;">Precio de envio</th>
        <th style="width:60%; border:1px solid #000000;">Desglose de compra</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="border:1px solid #000000;"><?php echo utf8_encode($row_Direccion['pais']); ?></td>
        <td style="border:1px solid #000000;"><?php echo "$".$row_Pedido['precio_envio'].".00"; ?></td>
        <td style="border:1px solid #000000;">
        <!-- -->
        <center>
            <table class="table table-bordered" width="99%" style="font-size:10px;">
                <thead>
                <tr>
                    <th style="width:25%; border:1px solid #000000;">Articulo</th>
                    <th style="width:25%; border:1px solid #000000;">Precio Unitario</th>
                    <th style="width:25%; border:1px solid #000000; text-align:center;">Cantidad</th>
                    <th style="width:25%; border:1px solid #000000; text-align:right;">Subtotal</th>
                </tr>
                </thead>
                <tbody>
                <?php
				do{
					?>
                    <tr>
                        <td style="border:1px solid #000000;"><?php echo $row_Productos['id_producto_fonarte']; ?></td>
                        <td style="border:1px solid #000000;"><?php echo "$".$row_Productos['precio'].".00"; ?></td>
                        <td style="border:1px solid #000000; text-align:center;"><?php echo $row_Productos['cantidad']; ?></td>
                        <?php $sub=$row_Productos['precio']*$row_Productos['cantidad']; ?>
                        <td style="border:1px solid #000000; text-align:right;"><?php echo "$".$sub.".00"; ?></td>
                    </tr> 
                    <?php
				}while($row_Productos = mysqli_fetch_assoc($Productos));
				?>
                <!-- ===== total de los productos ==== -->
                <tr>
                	<td colspan="4" style="border:1px solid #000000; text-align:right;"><?php echo "$".$row_Pedido['subtotal_productos'].".00"; ?></td>
                </tr>
                <!-- ===== cupon de descuento ==== -->
                <?php 
				if($row_Pedido['cupon_aplicado']!='')
				{
					?>
                    <tr>
                        <td colspan="4" style="border:1px solid #000000; text-align:right;"><?php echo $descuento_aplicado; ?></td>
                    </tr> 
                    
                    <?php
				}
				?>
                
                
                
                </tbody>
            </table>
            </center>
        <!-- -->
        
        
        </td>
      </tr>
      
      <tr>
        <td colspan="4" style="border:1px solid #000000;">
        	<p  style="font-size:10px; text-align:right;">Compra Total: <?php echo "$".$row_Pedido['total'].".00"; ?></p>
        </td>
      </tr>
      
      <tr>
        <td colspan="4" style="border:1px solid #000000;">
        <p>Datos del Usuario</p>
        <ul style="font-size:10px;">
			<li><?php echo utf8_encode($row_Usuario['nombre'])." ".utf8_encode($row_Usuario['apepat'])." ".utf8_encode($row_Usuario['apemat']); ?></li>
            <li><?php echo $row_Usuario['email']; ?></li>
        </ul>
        </td>
      </tr>
      
      <tr>
        <td colspan="4" style="border:1px solid #000000;">
        <p>Datos de Entrega</p>
        <ul style="font-size:10px;">
        	<li><?php echo utf8_encode($row_Direccion['nombre_recibe']); ?></li>
            <li><?php echo $row_Direccion['tel_recibe'] ?></li>
            <li><?php echo utf8_encode($row_Direccion['calle'])." N/E ".utf8_encode($row_Direccion['n_ext'])." N/I ".utf8_encode($row_Direccion['n_int'])." ".utf8_encode($row_Direccion['colonia'])." ".utf8_encode($row_Direccion['muni_dele'])." ".utf8_encode($row_Direccion['estado']).", ".utf8_encode($row_Direccion['pais'])." C.P. ".$row_Direccion['cp']." ".$row_Direccion['calle']." ".utf8_encode($row_Direccion['calle'])."<br>ENTRE LA CALLE ".utf8_encode($row_Direccion['entre_calle_1'])." Y LA CALLE ".$row_Direccion['entre_calle_2'] ?></li>
        </ul>
        </td>
      </tr>
      
    </tbody>
  </table>
  </center>
    </div>
</div>





<!-- ============================================================================= --> 
<div class="row">
    <div class="col-sm-12" style=" text-align:center;border:1px solid #000000;">
   	<p style="padding-top:6px; font-size:11;">Derechos Reservados Fonarte Latino 2010<br>Todos los precios est&aacute;n expresados en Pesos Mexicanos e incluyen iva<br>Sujetos a cambio sin previo aviso.</p>

    </div>
</div>


<br><br>


              
               <?php //print_r($_SESSION['USUARIO']); ?>
               <!-- Fin 212121212121212121212121212121212121212121212121212121212121 -->
            </div>
            


        </div>
        <!-- /.row -->

       
<button type="button" class="btn btn-default" onclick="imprimir();" style="background-color:#244e58; border:#244e58; color:#ffffff; width:50%;"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Imprimir</button>
<br><br><br><br>


<script>

function imprimir(){
  var objeto=document.getElementById('imprime');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write(objeto.innerHTML);  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento
  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
}
</script>



       

    </div>
    <!-- /.container -->



 
 




    <!-- jQuery -->
    <script src="js/jquery.js"></script>

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
