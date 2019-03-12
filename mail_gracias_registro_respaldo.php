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

$mail->Host = $protocolo;

$mail->Port = $puerto;

//$mail->SMTPSecure = 'ssl';

$mail->SMTPAuth = true;

$mail->Username = $de;

$mail->Password = $psw_de;

$mail->setFrom($de, $de_mascara);


$mail->addAddress($respaldo_mail_usuario, '');


$mail->Subject = $asunto;


$cuerpo= '

<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 10px; padding-bottom: 10px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
</div>


<div class="col-sm-12" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
<h2>&#161;LISTO!<br />TU REGISTRO SE REALIZO CON EXITO</h2><br /><br />

<center>
<table width="50%" border="0">
  <tr>
    <td>Usuario</td>
    <td>'.$_POST['email'].'</td>
  </tr>
  <tr>
    <td>Password</td>
    <td>'.$_POST['psw'].'</td>
  </tr>
</table>
</center>


</div>


<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 10px; padding-bottom: 10px;">
FONARTE LATINO
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



