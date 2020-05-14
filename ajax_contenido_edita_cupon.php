<?php require_once('Connections/conexion.php'); ?>
<?php
$_GET['cupon'];
?>
<?php
mysqli_select_db($conexion,$database_conexion);
$query_cupon2 = "SELECT * FROM cupon where codigo='".$_GET['cupon']."' and estatus='DISPONIBLE'";
$cupon2 = mysqli_query($conexion,$query_cupon2) or die(mysqli_error($conexion));
$row_cupon2 = mysqli_fetch_assoc($cupon2);
$totalRows_cupon2 = mysqli_num_rows($cupon2);
?>
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Edita cupon</h4>
</div>

 <form class="form-horizontal typ" method="post" name="" action="ajax_contenido_edita_cupon.php" style="font-size:12px;">
 
<div class="modal-body">

<div class="row">
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Codigo</p>
    <input type="text" class="form-control" name="codigo" id="id_codigo2" value="<?php echo $row_cupon2['codigo']; ?>" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>    
    
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Medida de descuento</p>
        <select class="form-control" name="medida" id="id_medida">
        	<?php
			if($row_cupon2['medida']=='PESOS')
			{
				?>
                <option value="PESOS">$</option>
            	<option value="PORCENTAJE">%</option>
                <?php
			}
			else
			{
				?>        
                <option value="PORCENTAJE">%</option>
                <option value="PESOS">$</option>
                <?php
			}
			?>

        </select>
        <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>   
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Descuento</p>
    <input type="number" class="form-control" name="descuento" id="id_descuento" value="<?php echo $row_cupon2['descuento']; ?>"  placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
</div>

<div class="row">
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Vencimiento</p>
    <input type="date" class="form-control" name="vencimiento" id="id_vencimiento" placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Minimo de productos</p>
    <input type="number" class="form-control" name="mas_de" id="id_mas_de" placeholder="" value="<?php echo $row_cupon2['mas_de']; ?>">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div>
    
    <div class="col-sm-4" style="margin-top: 15px;">
    <p>Cupones disponibles</p>
    <input type="number" class="form-control" name="disponibles" id="id_disponibles" value="<?php echo $totalRows_cupon2; ?>"  placeholder="">
    <span class="help-block"></span><!-- muestra texto de ayuda -->
    </div> 
</div>

<input type="hidden" name="edita_cupon" value="1">


 
</div>

   <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;Cerrar</button>
        <button type="submit" class="btn btn-primary" id="id_boton_edita"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;Editar</button>
    </div>
      
 </form>  
 
 <script src="js/valida_cupon_edit.js"></script>