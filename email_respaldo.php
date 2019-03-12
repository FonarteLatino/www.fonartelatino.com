<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
require_once 'email_configuraciones.php';



$mail = new PHPMailer;


$mail->isSMTP();

$mail->SMTPDebug = 0;

$mail->Debugoutput = 'html';

$mail->Host = $protocolo;

$mail->Port = $puerto;

$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = $de;
$mail->Password = $psw_de;
$mail->setFrom($de, $de_mascara);
$correo=$email_respaldo;



$mail->addAddress($correo, '');
//$mail->AddBCC ( $con_copia_a );



$mail->Subject = $asunto;





$cuerpo= '

Nombre: '.utf8_decode($_POST['nombre']).'<br />
Email: '.$_POST['email'].'<br />
Telefono: '.$_POST['tel'].'<br />
Asunto: '.$_POST['asunto'].'<br />

';  

$mail->MsgHTML($cuerpo);
//send the message, check for errors
if (!$mail->send()) {
	echo "error al enviar";
    return false;
} else {
     return true;
}
?>

