<?php
if (!isset($_SESSION)) {
  session_start();
}


// *** Logout the current user.
$logoutGoTo = "login.php?alerta=4";

$_SESSION['MM_Username_Panel'] = NULL;
$_SESSION['MM_UserGroup_Panel'] = NULL;
$_SESSION['USUARIO'] = NULL;

unset($_SESSION['MM_Username_Panel']);
unset($_SESSION['MM_UserGroup_Panel']);
unset($_SESSION['USUARIO']);

if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
