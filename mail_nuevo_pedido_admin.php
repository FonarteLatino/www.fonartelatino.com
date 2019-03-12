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

//correo de quien envia
$mail->Username = $de;

//password de quien envia
$mail->Password = $psw_de;


$mail->setFrom($de, $de_mascara);


$mail->addAddress($correo_admin, '');//para
$mail->AddBCC ( $correo_copia );//con copia a
//$mail->AddBCC ( $correo_copia2 ); 
$mail->AddBCC ( $respaldo_mail_admin ); 

$asunto4 .="-".$tipo;
$mail->Subject = $asunto4;


$cuerpo= '

<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 10px; padding-bottom: 10px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
</div>

<div class="col-sm-12" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
<h2>&#161;PEDIDO NUEVO!</h2><br />

<h1>PEDIDO #'.$_SESSION['PEDIDO_NUEVO'].'</h1>
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



