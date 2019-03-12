<?php

//echo $_GET['select_tipo'];
if($_GET['select_tipo']==2 or $_GET['select_tipo']==3)
{
?>
<label class="control-label col-sm-2" for="">Talla:</label>
<div class="col-sm-4">


<label><input type="checkbox" name="s"  value="1">S</label>

&nbsp;&nbsp;
<label><input type="checkbox" name="m" value="1">M</label>

&nbsp;&nbsp;
<label><input type="checkbox" name="l" value="1">L</label>


</div>
<?php
}

?>