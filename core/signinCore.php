<?php
session_start();
date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$ok = true;
$messages = array();

if ( !isset($username) || empty($username) ) {
    $ok = false;
    $messages[] = 'Username cannot be empty!';
}

if ( !isset($password) || empty($password) ) {
    $ok = false;
    $messages[] = 'Password cannot be empty!';
}

$st = $act->db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$idNameDB = $st->fetchColumn();

$st = $act->db->prepare("SELECT password FROM users WHERE id_user = ?");
$st->bindParam(1, $idNameDB);
$st->execute();
$passDB = $st->fetchColumn();

$st = $act->db->prepare("SELECT status FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$statusDB = $st->fetchColumn();

$secret1 = 'Star-9';
$password = md5($password . $secret1);

if ($ok) {
    if ($idNameDB && $password === $passDB) {
        if ($statusDB == 1) {

            $_SESSION['logged'] = $username;
            // refresh ONLINE
            $online = 1;
            $st = $act->db->prepare("UPDATE users SET online = :online WHERE username = :username");
            $st->bindParam(':online', $online);
            $st->bindParam(':username', $username);
            $st->execute();

            $ok = true;
            $messages[] = 'Successful login!';
        }
        else {
            $secret2 = 'Wars-9';
            $token = md5(date("Y-m-d H:i:s") . $secret2);

            $st = $act->db->prepare("SELECT email FROM users WHERE id_user = ?");
            $st->bindParam(1, $idNameDB);
            $st->execute();
            $emailDB = $st->fetchColumn();

            //Не забудь изменить путь до класса Мэйл после вывода из Core
            require_once 'Mail.php';
            $action = new Mail;
            $action->sendMail($emailDB, $token);
            $ok = false;
            $messages[] = 'Account has not activated. We send you activation instruction to email.';
        }
    } 
    else {
        $ok = false;
        $messages[] = 'Incorrect username/password combination!';
    }
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);

?>