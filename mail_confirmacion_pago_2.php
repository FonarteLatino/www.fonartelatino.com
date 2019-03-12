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


$mail->addAddress($correo_comprador, '');
$mail->AddBCC ( $respaldo_mail_admin ); 


$mail->Subject = $asunto6;



if(isset($_GET['id_pedido']))
{
	$id_ped=$_GET['id_pedido'];//viene de ajax_contenido_ticket.php
}
else
{
	$id_ped=$_SESSION['PEDIDO_NUEVO'];//viene de pago_paypal.php
	
	
}

$cuerpo= '

<div class="col-sm-12" style="text-align:center;background-color: #eee;padding-top: 10px; padding-bottom: 10px;">
<img src="img/fonarte-logo.png" width="80" height="75" alt="Fonarte Latino"><br>
</div>

<div class="col-sm-12" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
<h2>&#161;GRACIAS!</h2><br />FINALIZA TU PAGO A TRAV&Eacute;S DE PAYPAL YC<br />ENVIAREMOS TU PAQUETE A LA MAYOR BREVEDAD POSIBLE.

<h3>PEDIDO #'.$id_ped.'</h3>
</div>




<div class="col-sm-4" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
COMPRA <span style="color:#66BB6A; font-size:12px;">(LISTO)</span>
</div>

<div class="col-sm-4" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
PAGO <span style="color:#ff0; font-size:12px;">(EN PROCESO)</span>
</div>

<div class="col-sm-4" style="text-align:center;padding-top: 10px; padding-bottom: 10px;">
ENV&Iacute;O <span style="color:#000000; font-size:12px;">(PENDIENTE)</span>
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



