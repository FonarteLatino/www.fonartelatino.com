<?php require_once('Connections/conexion.php'); ?>
<?php
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

mysqli_select_db($conexion,$database_conexion);
$query_DiscoSemana = "SELECT
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
d_semana.id_producto
FROM
productos
INNER JOIN d_semana ON productos.id = d_semana.id_producto";
$DiscoSemana = mysqli_query($conexion,$query_DiscoSemana) or die(mysqli_error($conexion));
$row_DiscoSemana = mysqli_fetch_assoc($DiscoSemana);
$totalRows_DiscoSemana = mysqli_num_rows($DiscoSemana);

if(isset($_GET['borra']) and $_GET['borra']==1)
{
	$deleteSQL = sprintf("DELETE FROM d_semana WHERE id_producto=%s",
	GetSQLValueString($_GET['id_producto'], "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$deleteSQL) or die(mysqli_error($conexion));

	?><script type="text/javascript">window.location="admin_home.php?alerta=7&activa=3";</script><?php
}



?>

  <h3 class="tipografia2">Agregar Disco de la Semana</h3>             
<div class="row">
    <!-- inicio de formulario de agregar genero -->
    <div class="col-sm-5">
        <form class="letra_admin_prod2" method="post" name="form1" action="">
        
        <script type="text/javascript" src="jquery.js"></script>   
        
        <!--  INICIO PARTE 2   -->
        <script type="text/javascript">
        $(document).ready(function()
        {
        $('#id_nombre_d_semana').keyup(function()
        {
        var nombre_d_semana=$('#id_nombre_d_semana').val(); //declaramos las variables que vamos a mandar al siguiente php
        
        $('#variable5').load('js_despliega_art.php?nombre_d_semana='+nombre_d_semana);//enviamos las 2 variables
        });    
        });
        </script>
        <!--    FIN PARTE 2   -->
    
    
        <div class="form-group">
        <label>Artista o Album:</label>
        <input type="text" name="nombre_d_semana" class="form-control" id="id_nombre_d_semana"  required > 
        </div>
        
         <div class="form-group">
            <div id="variable5"> 
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
        <td><img src="<?php echo $row_DiscoSemana['ruta_img']; ?>" class="img-rounded" alt="" width="40" height="40"></td>
        <td><?php echo utf8_encode(utf8_decode($row_DiscoSemana['artista'])); ?></td>
        <td><?php echo utf8_encode(utf8_decode($row_DiscoSemana['album'])); ?></td>
        <td><a href="d_semana.php?borra=1&id_producto=<?php echo $row_DiscoSemana['id_producto']; ?>" ><i class="fa fa-times" aria-hidden="true"></i></a></td>
    </tr>
    <?php
	$x++;
}while($row_DiscoSemana = mysqli_fetch_assoc($DiscoSemana));
?>

</tbody>
</table>
</div>

 <!-- ======================fin cuerpo ======================================= -->
    
    
    </div>
    <!-- fin de tabla de generos -->
</div>

<?php
mysqli_free_result($DiscoSemana);
?>
