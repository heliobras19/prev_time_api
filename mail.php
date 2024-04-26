
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
function enviarEmail($email, $name = null, $msg = "teste") {
    
$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ec132458ae42f0';                     //SMTP username
    $mail->Password   = '89a60fc59a9e61'; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                         //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->setFrom('helio.bras12king@gmail.com', 'Prev Time');
    $mail->addAddress($email, $name ?? "Sem Nome"); 

    $mail->isHTML(true);                                 
    $mail->Subject = 'Alerta da previsão do tempo';
    $mail->Body    = $msg;
    $mail->AltBody = '';

    $mail->send();
    return true;
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}