<?php
if (!isset($_SESSION)) {
  session_start();
}

// *** Logout the current user.
$logoutGoTo = "index";
$_SESSION['MM_Username_Ecommerce'] = NULL;
$_SESSION['MM_UserGroup_Ecommerce'] = NULL;
$_SESSION['USUARIO_ECOMMERCE'] = NULL;

$_SESSION['CARRITO_TEMP'] = NULL;
$_SESSION['PEDIDO_NUEVO'] = NULL;



unset($_SESSION['MM_Username_Ecommerce']);
unset($_SESSION['MM_UserGroup_Ecommerce']);
unset($_SESSION['USUARIO_ECOMMERCE']);

unset($_SESSION['CARRITO_TEMP']);
unset($_SESSION['PEDIDO_NUEVO']);


if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
   