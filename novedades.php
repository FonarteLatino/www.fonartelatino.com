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

mysql_select_db($database_conexion, $conexion);
$query_Novedades = "SELECT
productos.id,
productos.sku,
productos.id_fonarte,
productos.clave_precio,
productos.artista,
productos.album,
productos.genero,
productos.genero2,
productos.genero3,
productos.categoria,
productos.spotify,
productos.itunes,
productos.amazon,
productos.google,
productos.ruta_img,
productos.ruta_img_2,
productos.descripcion,
productos.fecha_alta,
productos.hora_alta,
productos.prendido,
productos.estatus,
novedades.id_producto
FROM
productos
INNER JOIN novedades ON productos.id = novedades.id_producto
";
$Novedades = mysql_query($query_Novedades, $conexion) or die(mysql_error());
$row_Novedades = mysql_fetch_assoc($Novedades);
$totalRows_Novedades = mysql_num_rows($Novedades);


if(isset($_GET['borra']) and $_GET['borra']==1)
{
	$deleteSQL = sprintf("DELETE FROM novedades WHERE id_producto=%s",
	GetSQLValueString($_GET['id_producto'], "int"));
	
	mysql_select_db($database_conexion, $conexion);
	$Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());

	?><script type="text/javascript">window.location="admin_home.php?alerta=7&activa=2";</script><?php
}



?>

  <h3 class="tipografia2">Agregar Novedades</h3>             
<div class="row">
    <!-- inicio de formulario de agregar genero -->
    <div class="col-sm-5">
        <form class="letra_admin_prod2" method="post" name="form1" action="">
        
        <script type="text/javascript" src="jquery.js"></script>   
        
        <!--  INICIO PARTE 2   -->
        <script type="text/javascript">
        $(document).ready(function()
        {
        $('#id_nombre_novedad').keyup(function()
        {
        var nombre_novedad=$('#id_nombre_novedad').val(); //declaramos las variables que vamos a mandar al siguiente php
        
        $('#variable4').load('js_despliega_art.php?nombre_novedad='+nombre_novedad);//enviamos las 2 variables
        });    
        });
        </script>
        <!--    FIN PARTE 2   -->
    
    
        <div class="form-group">
        <label>Artista o Album:</label>
        <input type="text" name="nombre_novedad" class="form-control" id="id_nombre_novedad"  required > 
        </div>
        
         <div class="form-group">
            <div id="variable4"> 
            </div>
        </div>
        
        
    
        
        </form>

    </div>
    <!-- fin de formulario de agregar genero -->
    
    
    <!-- inicio de tabla de generos -->
    <div class="col-sm-7">
    
    
    <!-- ======================inicio cuerpo ======================================= -->              
<div class="dataTable_wrapper">
<table class="table table-striped table-bordered table-hover" id="dataTables-example">
<thead>
 <tr style="background-color: #E6E6E6;" class="letra_admin_prod" >
    <td>&nbsp;#&nbsp;</td>
   <td>&nbsp;</td>
   <td>Artista</td>
   <td>Album</td>
   <td>&nbsp;</td>
</tr>
</thead>
<tbody>
<?php
$x=1;
do{	
	?>
    <tr class="letra_admin_prod2">
        <td><?php echo $x; ?></td>
        <td><img src="<?php echo $row_Novedades['ruta_img']; ?>" class="img-rounded" alt="" width="40" height="40"></td>
        <td><?php echo utf8_encode($row_Novedades['artista']); ?></td>
        <td><?php echo utf8_encode($row_Novedades['album']); ?></td>
        <td><a href="novedades.php?borra=1&id_producto=<?php echo $row_Novedades['id_producto']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></a></td>
    </tr>
    <?php
	$x++;
}while($row_Novedades = mysql_fetch_assoc($Novedades));
?>

</tbody>
</table>
</div>

 <!-- ======================fin cuerpo ======================================= -->
    
    
    </div>
    <!-- fin de tabla de generos -->
</div>
<?php
mysql_free_result($Novedades);
?>
