<?php
namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController
{
    public static function enviar()
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'guillermocr221@gmail.com';
            $mail->Password   = 'imhm xmgf mfqv yttu';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Remitente y destinatario
            $mail->setFrom('guillermocr221@gmail.com', 'Guillermo envia');
            $mail->addAddress('guillermo.calle@unmsm.edu.pe', 'Guillermo Recibe');

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Correo desde mi MVC con PHPMailer';
            $mail->Body    = '<b>Hola!</b> Este correo fue enviado usando PHPMailer en mi proyecto MVC.';
            $mail->AltBody = 'Hola! Este correo fue enviado usando PHPMailer en mi proyecto MVC.';

            $mail->send();
            echo '✅ Correo enviado correctamente';
        } catch (Exception $e) {
            echo "❌ Error: {$mail->ErrorInfo}";
        }
    }

    public static function enviarCodigoActivacion($email, $nombre, $codigo)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'guillermocr221@gmail.com';
            $mail->Password   = 'imhm xmgf mfqv yttu';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Remitente y destinatario
            $mail->setFrom('guillermocr221@gmail.com', 'TreeSolution');
            $mail->addAddress($email, $nombre);

            // Contenido
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->Subject = 'Código de activación - TreeSolution';
            $mail->Body    = "
                <h2>¡Bienvenido a TreeSolution!</h2>
                <p>Hola <strong>{$nombre}</strong>,</p>
                <p>Gracias por registrarte en nuestra tienda. Para activar tu cuenta, utiliza el siguiente código:</p>
                <div style='background-color: #f0f0f0; padding: 20px; text-align: center; font-size: 24px; font-weight: bold; letter-spacing: 3px; margin: 20px 0;'>
                    {$codigo}
                </div>
                <p>Ingresa este código en la página de activación para completar tu registro.</p>
                <p>Si no solicitaste esta cuenta, puedes ignorar este correo.</p>
                <br>
                <p>Saludos,<br>El equipo de TreeSolution</p>
            ";
            $mail->AltBody = "Hola {$nombre}, tu código de activación es: {$codigo}. Ingresa este código en la página de activación para completar tu registro.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
