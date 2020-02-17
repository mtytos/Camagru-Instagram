<?php

class Db {

    protected $db;

    public function __construct() {
        try {
            // Новый вариант подключения надо обкатывать
            $dbConfig = require 'database.php';
            $this->db = new PDO($dbConfig['dsn'], $dbConfig['user'], $dbConfig['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Рабочий вариант подключения
            // $dbConfig = require 'dbConfig.php';
            // $this->db = new PDO('mysql:host=' . $dbConfig['host'] . ';dbname=' . $dbConfig['dbname'] . '', $dbConfig['user'], $dbConfig['password']);
            // $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            echo 'Everything is OK, connection to DATABASE was granted';
//            echo "<br>";
//            echo 'Ну и ебала';
        }
        catch (PDOException $e) {
//            echo "Connection failed" . $e->getMessage();
//            echo "<br>";
        }
    }

    public function likeInfo($username) {
        $st = $this->db->prepare("SELECT like_alert FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $like_alertDB = $st->fetchColumn();
        return $like_alertDB;
    }

    public function commentInfo($username) {
        $st = $this->db->prepare("SELECT comment_alert FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $comment_alertDB = $st->fetchColumn();
        return $comment_alertDB;
    }

    public function profileInfo($username) {
        $st = $this->db->prepare("SELECT profile_alert FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $profile_alert = $st->fetchColumn();
        return $profile_alert;
    }

    public function btnLike($username, $table) {
        $tableName = $table . '.like';
        $st = $this->db->prepare("SELECT id_like FROM `$tableName` WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $idLikeDB = $st->fetchColumn();
        return $idLikeDB;
    }

    public function countLike($table) {
        $tableName = $table . '.like';
        $sql = "SELECT COUNT(*) FROM `$tableName`";
        $st = $this->db->prepare($sql);
        $st->execute();
        $totalLike = $st->fetchColumn();
        return $totalLike;
    }

    public function countComment($table) {
        $tableName = $table . '.comment';
        $sql = "SELECT COUNT(*) FROM `$tableName`";
        $st = $this->db->prepare($sql);
        $st->execute();
        $totalComment = $st->fetchColumn();
        return $totalComment;
    }

    public function showComments($table, $user) {
        $tableName = $table . '.comment';
        $st = $this->db->prepare("SELECT * FROM `$tableName`");
        $st->execute();
        $total = $st->fetchALL(PDO::FETCH_ASSOC);

        $checkUser = explode('.', $table);
        echo "<form method='post' action='../commentCore.php'>";
        for ($i = 0; $i < count($total); $i++) {
            echo $total[$i]['username'] . ": " . $total[$i]['comment'];
            echo "<br>";
            $idDel = $total[$i]['id_comment'];
            if ($user == $checkUser[1] || $user == $total[$i]['username']) {
                echo "<button type='submit' name='deleteComment' value='$idDel'>Delete</button>";
            }
            echo "<br>";
        }
        echo "</form>";
    }
//
//    public function login($email, $pass) {
//        try {
//            if ($_POST['action'] == 'signin') {
//                $st = $this->db->prepare("SELECT id FROM users WHERE email = ?");
//                $st->bindParam(1, $email);
//                $st->execute();
//                $idDB = $st->fetchColumn();
//                if (!$idDB) {
//                    echo 'Пользователь с таким Email не зарегистрирован. ИД';
//                    exit;
//                }
//                $st = $this->db->prepare("SELECT status FROM users WHERE email = ?");
//                $st->bindParam(1, $email);
//                $st->execute();
//                $statusDB = $st->fetchColumn();
//                if (!$statusDB) {
//                    echo 'Ползователь не активировал аккаунт. Статус';
//                    exit;
//                }
//                $secret = 'Starwars';
//                $st = $this->db->prepare("SELECT password FROM users WHERE email = ?");
//                $st->bindParam(1, $email);
//                $st->execute();
//                $passDB = $st->fetchColumn();
//                if (md5($pass.$secret) === $passDB) {
//                    $_SESSION['logged'] = $idDB;
//                    require_once ('home.php');
//                }
//                else {
//                    echo 'Введен неверный пароль';
//                }
//            }
//
//        }
//        catch (PDOException $e) {
//            echo "NOT WORKING sign IN" . $e->getMessage();
//            echo "<br>";
//        }
//    }
//
//
//
//
//
//    public function signup($name, $email, $pass, $repass) {
//        try {
//            if ($_POST['action'] == 'signup') {
//                if ($pass === $repass) {
//                    $secret = 'Starwars'; //немного подсОлим хэш
//                    $status = 0; //изначально делает аккаут деактивированым
//                    $tmpass = md5($pass.$secret); //хэш пароля
//                    $token = md5($name.$secret); // токен для активации аккаунта
//
//                    // Ошибка пароля
//                    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}/', $pass)) {
//                        include ('errorPass.php');
//                        exit;
//                    }
//
//                    // Ошибка ника
//                    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $name)) {
//                        include ('errorName.php');
//                        exit;
//                    }
//
//                    // Ошибка мейла
//                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//                        include ('errorEmail.php');
//                        exit;
//                    }
//
//                    // ищу пользователя по email
//                    $st = $this->db->prepare("SELECT username FROM users WHERE email = ?");
//                    $st->bindParam(1, $email);
//                    $st->execute();
//                    $usernameDB = $st->fetchColumn();
//
//                    // ищу сатус аккаунта по email
//                    $st = $this->db->prepare("SELECT status FROM users WHERE email = ?");
//                    $st->bindParam(1, $email);
//                    $st->execute();
//                    $statusDB = $st->fetchColumn();
//
//                    // проверяю уникальность никнейма
//                    $st = $this->db->prepare("SELECT id FROM users WHERE username = ?");
//                    $st->bindParam(1, $name);
//                    $st->execute();
//                    $idDB = $st->fetchColumn();
//
//                    //после успешных проверок записываю данные юзера в БД используя prepare
//                    if (!$usernameDB) {
//                        if ($idDB) {
//                            echo 'Пользователь с таким именем уже существует. Придумайте что-нибудь оригинальное. Создание';
//                            exit;
//                        }
//                        $st = $this->db->prepare("INSERT INTO users (username, email, password, status, token) VALUES(?, ?, ?, ?, ?)");
//                        $st->bindParam(1, $name);
//                        $st->bindParam(2, $email);
//                        $st->bindParam(3, $tmpass);
//                        $st->bindParam(4, $status);
//                        $st->bindParam(5, $token);
//                        $st->execute();
//                        $this->sendMail($email, $name, $token);
//                    }
//                    else {
//                        if ($statusDB) {
//                            echo 'Аккаунт с такой почтой зарегистрирован. Вы если вы забыли пароль, можете восстановить его на странице входа.';
//                            echo "<br>";
//                        }
//                        else {
//                            if ($idDB) {
//                                echo 'Пользователь с таким именем уже существует. Придумайте что-нибудь оригинальное. Обновление';
//                                exit;
//                            }
//                            $st = $this->db->prepare("UPDATE users SET username = :username, password = :password, token = :token WHERE email = :email");
//                            $st->bindParam(':username', $name);
//                            $st->bindParam(':password', $tmpass);
//                            $st->bindParam(':token', $token);
//                            $st->bindParam(':email', $email);
//                            $st->execute();
//                            echo 'Данные обновлены';
//                            echo "<br>";
//                            $this->sendMail($email, $token);
//                        }
//                    }
//                }
//                else {
//                    echo 'Sorry, but You have mistake. Passwords have different.';
//                    echo "<br>";
//                    include ('errorPass.php');
//                    exit;
//                }
//            }
//        }
//        catch (PDOException $e) {
//            echo "NOT WORKING sign UP" . $e->getMessage();
//            echo "<br>";
//        }
//    }
//
//    public function reset($email) {
//        try {
//            //сюда надо добавить проверку на существование такого Емейла, если нет то не запускать
//            if ($_POST['action'] == 'reset') {
//
//                //проверка статуса аккаунта
//                $st = $this->db->prepare("SELECT status FROM users WHERE email = ?");
//                $st->bindParam(1, $email);
//                $st->execute();
//                $statusDB = $st->fetchColumn();
//
//                if ($statusDB) {
//                    $to = $email;
//                    $secret = 'Thor';
//                    $token = md5($email . $secret);
//
//                    //добавляю новый токен в БД
//                    $st = $this->db->prepare("UPDATE users SET token = :token WHERE email = :email");
//                    $st->bindParam(':token', $token);
//                    $st->bindParam(':email', $email);
//                    $st->execute();
//                    // тема письма
//                    $subject = 'CAMAGRU - Reset password';
//
//                    //собираю из четырех кусков свое сообщение
//                    $message1 = '
//                    <html>
//                    <head>
//                    <title>Reset password</title>
//                    </head>
//                    <body>
//                    <p>If you want to reset password on CAMAGRU</p>';
//                    $message2 = '<p>Copy this HASH - ' . $token . '</p>';
//                    $message3 = '<p>And click on this link <a href="http://localhost:51555/resetPass.php">reset password</a>.</p>
//                    <p>If you not reset password, please, ignoring this message.</p>
//                    </body>
//                    </html>';
//                    $message = $message1 . $message2 . $message3;
//
//                    // Для отправки HTML-письма должен быть установлен заголовок Content-type
//                    $headers = 'MIME-Version: 1.0' . "\r\n";
//                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//
//
//                    // Отправляем
//                    if (mail($to, $subject, $message, $headers)) {
//                        include_once('mailReset.php');
//                    }
//                    else {
//                        echo 'noting';
//                    }
//                }
//                 else {
//                    echo 'Нет активированного аккаунта с такой почтой';
//                }
//            }
//        }
//        catch (PDOException $e) {
//            echo "NOT WORKING reset" . $e->getMessage();
//            echo "<br>";
//        }
//    }
//
//     public function test($a) {
//        echo $a;
//     }
//
//     public function sendMail($email, $hash) {
//         //$to = 'orividerchi2013@yandex.ru';
//         //$to = 'storylove788@gmail.com';
//         $to = $email;
//
//         //$name = $user;
//         //$token = $hash;
//
//         // тема письма
//         $subject = 'Registration on CAMAGRU';
//
//        //собираю из трех кусков свое сообщение
//         $message1 = '
//                      <html>
//                      <head>
//                      <title>Registration on CAMAGRU</title>
//                      </head>
//                      <body>
//                      <p>If you want to finish registration on CAMAGRU and activate account</p>';
//         $message2 = '<p>Copy this HASH - ' . $hash . '</p>';
//         $message3 = '<p>And click on this link <a href="http://localhost:51555/activation.php">activate account</a>.</p>
//                      <p>If you not registered on site, please, ignoring this message.</p>
//                      </body>
//                      </html>';
//         $message = $message1.$message2.$message3;
//
//         // Для отправки HTML-письма должен быть установлен заголовок Content-type
//         $headers  = 'MIME-Version: 1.0' . "\r\n";
//         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//
//
//         // Отправляем
//         if (mail($to, $subject, $message, $headers)) {
//             include_once ('mailInfo.php');
//         }
//         else {
//            echo 'noting';
//         }
//     }
//
//
//     public function newPass($hash, $pass, $repass) {
//         if ($_POST['action'] == 'newPass') {
//             if ($pass === $repass) {
//                 // Ошибка пароля
//                 if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}/', $pass)) {
//                     include ('errorPass.php');
//                     exit;
//                 }
//                 $st = $this->db->prepare("SELECT id FROM users WHERE token = ?");
//                 $st->bindParam(1, $hash);
//                 $st->execute();
//                 $idDB = $st->fetchColumn();
//
//                 if ($idDB) {
//                     $secret = 'Starwars';
//                     $tmpass = md5($pass.$secret);
//                     $st = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
//                     $st->bindParam(':password', $tmpass);
//                     $st->bindParam(':id', $idDB);
//                     $st->execute();
//                     include ('resetSuc.php');
//                     exit;
//                 }
//                 else {
//                     echo 'Не удалось обновить данные пароля';
//                 }
//             }
//             else {
//                 echo 'Sorry, but You have mistake. Passwords have different.';
//                 echo "<br>";
//                 include ('errorPass.php');
//                 exit;
//             }
//         }
//     }
//
//
//     public function activateAC($hash) {
//        if ($_POST['action'] == 'regHash') {
//
//            //получаю статус аккаунта с данным токеном
//            $st = $this->db->prepare("SELECT status FROM users WHERE token = ?");
//            $st->bindParam(1, $hash);
//            $st->execute();
//            $statusDB = $st->fetchColumn();
//
//            if (!$statusDB) {
//                $newStatus = 1;
//                $st = $this->db->prepare("UPDATE users SET status = :status WHERE token = :token");
//                $st->bindParam(':status', $newStatus);
//                $st->bindParam(':token', $hash);
//                $st->execute();
//                include ('activateSuc.php');
//                exit;
//            }
//        }
//     }
//
//     public function deleteAcc() {
//
//     }
//
//     public function logout() {
//         if ($_POST['action'] == 'logout') {
//            session_start();
//            session_unset();
//            session_destroy();
//            $_SESSION['logged'] = '';
//            header('Location: http://localhost/camagru/index.php');
//            exit;
//        }
//     }

}

?>