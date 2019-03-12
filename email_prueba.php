<?php
require_once 'PHPMailer/PHPMailerAutoload.php';
//require_once 'http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css';
//session_start();
//Create a new PHPMailer instance
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
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 465;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "javier.garcia@axisdigital.com.mx";
//Password to use for SMTP authentication
$mail->Password = "6arcia3.";
//Set who the message is to be sent from
$mail->setFrom('javier.garcia@axisdigital.com.mx', 'Contacto Fonarte');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
//$correo=$_POST['mail'];
$correo='j.garcia.e1987@gmail.com';
$mail->addAddress($correo, '');
//$mail->addCC($oficio['enlase']);
//Set the subject line
$mail->Subject = 'PRUEBA PHP EN CORREO';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');


	//set it to writable location, a place for temp generated PNG files
	/*$PNG_TEMP_DIR = dirname(__FILE__).'/phpqrcode/temp/';

	//html PNG location prefix
	$PNG_WEB_DIR = 'phpqrcode/temp/';

	//ofcourse we need rights to create temp dir
	if (!file_exists($PNG_TEMP_DIR))
    	mkdir($PNG_TEMP_DIR);

	$filename = $PNG_TEMP_DIR.'test'.md5($row_rs_cita['num']).'.png';

	if (!file_exists($filename))
		QRcode::png($row_rs_cita['num'], $filename, 'M', 8, 1); */






$cabecera= "imprime los 10 primeros numeros ";


$numeros=0;
for($i=1;$i<=10;$i++)
{
	$i;
	
$arreglo = array(
    "foo" => "bar",
    "bar" => "foo",
);



var_dump($arreglo);


}


$pie=" fin de email";






$mail->MsgHTML($cuerpo);
//send the message, check for errors
if (!$mail->send()) {
	echo "error al enviar ";
    return false;
} else {
     return true;
}





?>

