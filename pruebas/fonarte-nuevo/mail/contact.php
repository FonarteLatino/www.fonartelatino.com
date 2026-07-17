<?php
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['link']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$link = strip_tags(htmlspecialchars($_POST['link']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "aibarra@fonartelatino.com.mx"; // Change this email to your //
$subject = "$m_subject:  $name";
$body = "Recibiste un nuevo mensaje de tu website.\n\n"."Aquí están los detalles:\n\nNombre: $name\n\n\nEmail: $email\n\nAsunto: $m_subject\n\nMensage: $message";
$header = "De: $email";
$header .= "Responde a: $email";	

if(!mail($to, $subject, $body, $header))
  http_response_code(500);
?>
