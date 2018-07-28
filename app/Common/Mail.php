<?php

/**
 * Configure mail common
 *
 * @package App\Common
 * @author Rikkei.Quangpm
 * @date 2018/07/19
*/

namespace App\Common;

use PHPMailer\PHPMailer\PHPMailer;

/**
 * Configure mail common
 */
class Mail
{
    /**
     * Configure server mail and send mail
     * 
     * @param array $request request send mail
     * @return boolean
     */
    public static function sendMail($request)
    {
        $mail = new PHPMailer(true);     //// Passing `true` enables exceptions

        //Server settings
        $mail->SMTPDebug = 0;                                 // Enable verbose debug output: 1 = errors and messages, 2 = messages only
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = env('MAIL_HOST');       // Specify main and backup SMTP servers
        $mail->SMTPAuth = env('MAIL_SMTP_AUTH');                               // Enable SMTP authentication
        $mail->Username = env('MAIL_USERNAME');                 // SMTP username
        $mail->Password = env('MAIL_PASSWORD');                           // SMTP password
        $mail->SMTPSecure = env('MAIL_SMTP_SECURE');                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = env('MAIL_PORT');                                    // TCP port to connect to

        //Recipients
        $mail->setFrom(env('MAIL_FROM'), env('MAIL_FROM_NAME'));
        $mail->addAddress($request['toAdress'], $request['toPerson']);     // Add a recipient

        //Attachments
        $mail->addAttachment($request['attachmentFile']);         // Add attachments

        //Content
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $request['subject'];
        $mail->Body    = $request['body'];

        $mail->send();
    }
}
