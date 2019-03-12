<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'configuraciones_email.php';
require_once 'rutas_absolutas.php';

//require_once 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css';
//session_start();
//Create a new PHPMailer instance
$mail = new PHPMailer;


//Tell PHPMailer to use SMTP
$mail->isSMTP();


$mail->SMTPDebug = 0;


$mail->Debugoutput = 'html';

$mail->Host = $protocolo;

$mail->Port = $puerto;

//$mail->SMTPSecure = 'ssl';

$mail->SMTPAuth = true;

$mail->Username = $de;

$mail->Password = $psw_de;

$mail->setFrom($de, $de_mascara);

$correo=$correo_admin;
$mail->addAddress($correo, '');

$mail->Subject = 'Comentario nuevo';


$cuerpo= '
Nombre: '.utf8_decode($_POST['nombre']).'<br />
Email: '.$_POST['email'].'<br />
Telefono: '.$_POST['telefono'].'<br />
Comentario: '.utf8_decode($_POST['comentario']).'
';


$mail->MsgHTML($cuerpo);
//send the message, check for errors
if (!$mail->send()) {
	echo "error al enviar ";
    return false;
} else {
     return true;
}





?>



