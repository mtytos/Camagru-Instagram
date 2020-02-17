<?php

class Mail {

    public function sendMail($email, $token) {

        //$to = 'orividerchi2013@yandex.ru';
        //$to = 'storylove788@gmail.com';
        $to = $email;

        // тема письма
        $subject = 'Registration on CAMAGRU';

        //собираю из трех кусков свое сообщение
        $message1 = '
            <html>
            <head>
            <title>Registration on CAMAGRU</title>
            </head>
            <body>
            <p>If you want to finish registration on CAMAGRU and activate account</p>';
        $message2 = '<p>Copy this HASH - ' . $token . '</p>';

        //ОБЯЗАТЕЛЬНО ИЗМЕНИТЬ ЛОКАЛХОСТ или ДОБАВИТЬ ПОРТЫ ПОД СВОЙ СЕРВЕР
        $message3 = '
            <p>And click on this link <a href="http://127.0.0.1/Camagru/view/activation.php">activate account</a>.</p>
            <p>If you not registered on site, please, ignoring this message.</p>
            </body>
            </html>';

        $message = $message1.$message2.$message3;

        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Отправляем
        if (mail($to, $subject, $message, $headers)) {
            //echo 'goof';
        }
        else {
            echo 'noting';
        }
    }

    public function sendResetMail($email, $token) {

        //$to = 'orividerchi2013@yandex.ru';
        //$to = 'storylove788@gmail.com';
        $to = $email;

        // тема письма
        $subject = 'Registration on CAMAGRU';

        //собираю из трех кусков свое сообщение
        $message1 = '
                    <html>
                    <head>
                    <title>Reset password</title>
                    </head>
                    <body>
                    <p>If you want to reset password on CAMAGRU</p>';
        $message2 = '<p>Copy this HASH - ' . $token . '</p>';

        //ОБЯЗАТЕЛЬНО ИЗМЕНИТЬ ЛОКАЛХОСТ или ДОБАВИТЬ ПОРТЫ ПОД СВОЙ СЕРВЕР
        $message3 = '<p>And click on this link <a href="http://127.0.0.1/Camagru/view/newPass.php">reset password</a>.</p>
                    <p>If you not reset password, please, ignoring this message.</p>
                    </body>
                    </html>';
        $message = $message1 . $message2 . $message3;
                    
        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Отправляем
        if (mail($to, $subject, $message, $headers)) {
            //echo 'goof';
        }
        else {
            echo 'noting';
        }
    }


    public function likeMail($email) {

        $to = $email;

        // тема письма
        $subject = 'Your post has been liked!';

        //собираю из трех кусков свое сообщение
        $message = '
                    <html>
                    <head>
                    <title>Your post has been liked!</title>
                    </head>
                    <body>
                    <p>It is inform mail about new like</p>
                    <p>If you want get this message, please, turn off notification in options.</p>
                    </body>
                    </html>';
        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Отправляем
        mail($to, $subject, $message, $headers);
    }

    public function commentMail($email) {

        $to = $email;

        // тема письма
        $subject = 'Your post has new comment!';

        //собираю из трех кусков свое сообщение
        $message = '
                    <html>
                    <head>
                    <title>Your post has new comment!</title>
                    </head>
                    <body>
                    <p>It is inform mail about new comment</p>
                    <p>If you want get this message, please, turn off notification in options.</p>
                    </body>
                    </html>';
        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Отправляем
        mail($to, $subject, $message, $headers);
    }

    public function newNameMail($email) {

        $to = $email;

        // тема письма
        $subject = 'You changed nickname!';

        //собираю из трех кусков свое сообщение
        $message = '
                    <html>
                    <head>
                    <title>You changed nickname!</title>
                    </head>
                    <body>
                    <p>It is inform mail about change nickname!</p>
                    <p>If you want get this message, please, turn off notification in options.</p>
                    </body>
                    </html>';
        // Для отправки HTML-письма должен быть установлен заголовок Content-type
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Отправляем
        mail($to, $subject, $message, $headers);
    }
}
