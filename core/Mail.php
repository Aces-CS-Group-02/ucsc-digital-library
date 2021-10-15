<?php

namespace app\core;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    private $mail = NULL;

    public function __construct(array $receivers, string $subject, string $body, string $altBody)
    {
        $this->mail = new PHPMailer();

        $config = [
            'host' => $_ENV['MAIL_HOST'],
            'username' => $_ENV['MAIL_USERNAME'],
            'password' => $_ENV['MAIL_PASSWORD']
        ];

        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $this->mail->isSMTP();                                            //Send using SMTP
            $this->mail->Host       = $config['host'] ?? '';                     //Set the SMTP server to send through
            $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $this->mail->Username   = $config['username'] ?? '';                     //SMTP username
            $this->mail->Password   = $config['password'] ?? '';                               //SMTP password
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $this->mail->setFrom('from@example.com', 'UCSC Digital Library');
            // $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient

            foreach ($receivers as $receiver) {
                $this->mail->addAddress($receiver);               //Name is optional
            }
            $this->mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->mail->Subject = $subject ?? '';
            $this->mail->Body    = $body ?? '';
            $this->mail->isHTML(true);                                  //Set email format to HTML

            // $this->mail->AltBody = $altBody ?? '';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }

    public function sendMail()
    {
        try {
            $this->mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
