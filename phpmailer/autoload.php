<?php

require 'PHPMailer.php';
require 'SMTP.php'; 
require 'Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EMail
{
    public $sender_name;
    public $sender_username;
    public $sender_password;

    public function __construct($sender_name, $sender_username, $sender_password)
    {
        $this->sender_name = $sender_name;
        $this->sender_username = $sender_username;
        $this->sender_password = $sender_password;
    }

    public function send($recepient_name, $recepient_email, $subject, $message)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $this->sender_username;
            $mail->Password   = $this->sender_password;
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->isHTML(true);
            $mail->setFrom($this->sender_username, $this->sender_name);
            $mail->addAddress($recepient_email, $recepient_name);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
