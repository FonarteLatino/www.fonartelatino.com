
<?php 
if(isset($_GET['alerta']))
{?>

	<div class="<?php echo $clase; ?>">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $msj; ?>
	</div>

	
<?php } ?>
                  
