<?php
#SERVIDOR LOCAL
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"

$hostname_conexion = "localhost";
$database_conexion = "fonartecommerce";
$username_conexion = "root";
$password_conexion = "";
#$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR);
$conexion = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysqli_error($conexion),E_USER_ERROR); 


# SERVIDOR DE PRUBA
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*
$hostname_conexion = "mysql.axiscom.com.mx";
$database_conexion = "fonarte_v2";
$username_conexion = "usrfonartebjf1nk";
$password_conexion = "NZojmHb8QyBJf1nk";
$conexion = mysql_pconnect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 

*/



# SERVIDOR DE PRODUCCION
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
/*
$hostname_conexion = "mysql.fonartelatino.com";
$database_conexion = "fonartecommerce";
$username_conexion = "usrfonartebjf";
$password_conexion = "NZojmHb8QyBJf1nk";
$conexion = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysqli_error($conexion),E_USER_ERROR);
*/

?> 