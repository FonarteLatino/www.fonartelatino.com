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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) 
{
	//toma el pais
	mysqli_select_db($conexion,$database_conexion);
	$query_Pais = "SELECT * FROM pais where id=".$_POST['pais'];
	$Pais = mysqli_query($conexion,$query_Pais) or die(mysqli_error($conexion));
	$row_Pais = mysqli_fetch_assoc($Pais);
	$totalRows_Pais = mysqli_num_rows($Pais);
	
	//toma el estado
	mysqli_select_db($conexion,$database_conexion);
	$query_Estado = "SELECT * FROM estado where id=".$_POST['estado'];
	$Estado = mysqli_query($conexion,$query_Estado) or die(mysqli_error($conexion));
	$row_Estado = mysqli_fetch_assoc($Estado);
	$totalRows_Estado = mysqli_num_rows($Estado);
    
    
$insertSQL = sprintf("INSERT INTO direcciones (id_usr, calle, colonia, muni_dele, cp, n_ext, n_int, id_pais, pais, id_estado, estado, entre_calle_1, entre_calle_2, nombre_recibe, tel_recibe, estatus) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
	GetSQLValueString($_POST['id_usr'], "int"),
	GetSQLValueString(utf8_decode($_POST['calle']), "text"),
	GetSQLValueString(utf8_decode($_POST['colonia']), "text"),
	GetSQLValueString($_POST['muni_dele'], "text"),
	GetSQLValueString($_POST['cp'], "text"),
	GetSQLValueString(utf8_decode($_POST['n_ext']), "text"),
	GetSQLValueString(utf8_decode($_POST['n_int']), "text"),
	GetSQLValueString($_POST['pais'], "int"),
	GetSQLValueString($row_Pais['paisnombre'], "text"),
	GetSQLValueString($_POST['estado'], "int"),
	GetSQLValueString($row_Estado['estadonombre'], "text"),
	GetSQLValueString(utf8_decode($_POST['entre_calle_1']), "text"),
	GetSQLValueString(utf8_decode($_POST['entre_calle_2']), "text"),
	GetSQLValueString(utf8_decode($_POST['nombre_recibe']), "text"),
	GetSQLValueString($_POST['tel_recibe'], "text"),
	GetSQLValueString(1, "int"));
	
	mysqli_select_db($conexion,$database_conexion);
	$Result1 = mysqli_query($conexion,$insertSQL) or die(mysqli_error($conexion));
	
	$insertGoTo = "direcciones_envio.php?alerta=203";
	if (isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
	$insertGoTo .= $_SERVER['QUERY_STRING'];
	}
	?><script type="text/javascript">window.location="<?php echo $insertGoTo; ?>";</script><?php
    
}
?>


<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1"  class="tipografia2">
    
<div class="row">
    
    
    <div class="col-sm-3">
        <div class="form-group">
        <label>Calle</label>
        <input type="text"  class="form-control" name="calle" id="id_calle" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
     <div class="col-sm-3">
        <div class="form-group">
        <label>Colonia</label>
        <input type="text"  class="form-control" name="colonia" id="id_colonia" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
      <div class="col-sm-3">
        <div class="form-group">
        <label>Muicipio / Delegacion</label>
        <input type="text"  class="form-control" name="muni_dele" id="id_muni_dele" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
     <div class="col-sm-3">
        <div class="form-group">
        <label>Codigo Postal</label>
        <input type="text" class="form-control" name="cp" id="id_cp" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
 
</div>



<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
        <label>Numero exterior</label>
        <input type="text"  class="form-control" name="n_ext" id="id_n_ext" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
     <div class="col-sm-3">
        <div class="form-group">
        <label>Numero interior</label>
        <input type="text"  class="form-control" name="n_int" id="id_n_int" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
    
    

<script type="text/javascript" src="jquery.js"></script>   
        
<!--  INICIO PARTE 2   -->
<script type="text/javascript">
$(document).ready(function()
{
$('#id_pais').change(function()
{
var pais=$('#id_pais').val(); //declaramos las variables que vamos a mandar al siguiente php

$('#estado').load('js_estados.php?pais='+pais);//enviamos las 2 variables
});    
});
</script>
<!--    FIN PARTE 2   -->


    <div class="col-sm-3">
        <div class="form-group">
            <label>Pais</label>
            <select class="form-control" style="text-transform: uppercase;" name="pais" id="id_pais">
                <option value=""></option>
                <?php
                do {  
                ?>
                <option value="<?php echo $row_CatPais['id']?>"><?php echo utf8_encode($row_CatPais['paisnombre']); ?></option>
                <?php
                } while ($row_CatPais = mysqli_fetch_assoc($CatPais));
                $rows = mysqli_num_rows($CatPais);
                if($rows > 0) {
                mysqli_data_seek($CatPais, 0);
                $row_CatPais = mysqli_fetch_assoc($CatPais);
                }
                ?>
            </select>
            <span class="help-block"></span><!-- muestra texto de ayuda -->
       </div>
    </div>
    
     <div class="col-sm-3">
        <div id="estado"> </div>
    </div>
</div>





<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Entre la calle</label>
        <input type="text" class="form-control" name="entre_calle_1" id="id_entre_calle_1" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
     <div class="col-sm-6">
        <div class="form-group">
        <label>y la calle</label>
        <input type="text"  class="form-control" name="entre_calle_2" id="id_entre_calle_2" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
        <label>Nombre de quien recibe</label>
        <input type="text"  class="form-control" name="nombre_recibe" id="id_nombre_recibe" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
    
     <div class="col-sm-6">
        <div class="form-group">
        <label>Telefono de quien recibe</label>
        <input type="text" class="form-control" name="tel_recibe" id="id_tel_recibe" value="" >
        <span class="help-block"></span><!-- muestra texto de ayuda -->
        </div>
    </div>
</div>



 <br>
  <div style="text-align:right;">
  <button type="submit"  class="btn btn-default tipografia2" id="id_btn_enviar"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp;Guardar</button>
</div>

<input type="hidden" class="form-control" name="id_usr" value="<?php print_r($_SESSION['USUARIO_ECOMMERCE']['id']); ?>" readonly>
  <input type="hidden" name="MM_insert" value="form1" />
</form>

<script src="js/valida_direccion_nueva.js"></script>