<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'configuraciones_email.php';
require_once 'rutas_absolutas.php';


$mail = new PHPMailer;


//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server

$mail->Host = $protocolo;

$mail->Port = $puerto;

$mail->SMTPAuth = true;

$mail->Username = $de;

$mail->Password = $psw_de;

$mail->setFrom($de, $de_mascara);

$correo=$_POST['email'];
$mail->addAddress($correo, '');

$mail->Subject = $asunto5;

$cuerpo= '

Gracias por enviar tus comentarios, nos pondremos en contacto contigo lo antes posible


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

