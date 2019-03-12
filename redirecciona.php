<?php

if (!isset($_SESSION)) {
  session_start();
}




if($_SESSION['USUARIO']['nivel']==1)
{
	?><script type="text/javascript">window.location="bienvenida.php";</script><?php
}
if($_SESSION['USUARIO']['nivel']==2)
{
	
	?><script type="text/javascript">window.location="admin_reporte.php";</script><?php
}
if($_SESSION['USUARIO']['nivel']==3)
{
	
	?><script type="text/javascript">window.location="analytic.php";</script><?php
}



?>