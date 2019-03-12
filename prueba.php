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

$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = "sub4.mail.dreamhost.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;



$mail->SMTPAuth = true;

//correo de quien envia
$mail->Username = 'no-reply@fonartelatino.com';

//password de quien envia
$mail->Password = 'fon010117lat';


$mail->setFrom($de, $de_mascara);


$mail->addAddress('j.garcia.e1987@gmail.com', '');


$mail->Subject = 'qwerty';


$cuerpo= '

<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 10px; padding-bottom: 10px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
</div>

<div class="col-sm-12" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
<h2>&#161;PEDIDO NUEVOjavier prueba!</h2><br />

</div>




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



