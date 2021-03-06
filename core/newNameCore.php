<?php

date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

// получаю переменные с данными инпутов
$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';

$ok = true;
$messages = array();

if ( !isset($hash) || empty($hash) ) {
    $ok = false;
    $messages[] = 'Hash cannot be empty!';
}

if ( !isset($email) || empty($email) ) {
    $ok = false;
    $messages[] = 'Email cannot be empty!';
}

// Ошибка мейла
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ok = false;
    $messages[] = 'Incorrect email';
}

if ( !isset($username) || empty($username) ) {
    $ok = false;
    $messages[] = 'Password cannot be empty!';
}

// Ошибка ника
if (!empty($username) && !preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $username)) {
    $ok = false;
    $messages[] = 'Username could contain only uppercase and lowercase words, figures and special sign _ ';
}


$st = $act->db->prepare("SELECT id_user FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$idNameDB = $st->fetchColumn();

$st = $act->db->prepare("SELECT token FROM users WHERE id_user = ?");
$st->bindParam(1, $idNameDB);
$st->execute();
$tokenDB = $st->fetchColumn();


if ($ok) {
    if ($hash == $tokenDB) {

        $st = $act->db->prepare("SELECT id_user FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $checkNewName = $st->fetchColumn();

        if ($checkNewName) {
            $ok = false;
            $messages[] = 'User with that nickname exists!';
        }
        else {
            $secret2 = 'Wars-9';
            $token = md5(date("Y-m-d H:i:s") . $secret2);

            //обновляю token
            $st = $act->db->prepare("UPDATE users SET token = :token WHERE id_user = :id");
            $st->bindParam(':token', $token);
            $st->bindParam(':id', $idNameDB);
            $st->execute();

            //обновляю name
            $st = $act->db->prepare("UPDATE users SET username = :username WHERE id_user = :id");
            $st->bindParam(':username', $username);
            $st->bindParam(':id', $idNameDB);
            $st->execute();

            //обновляю статус онлайн на 0
            $online = 0;
            $st = $act->db->prepare("UPDATE users SET online = :online WHERE id_user = :id");
            $st->bindParam(':online', $online);
            $st->bindParam(':id', $idNameDB);
            $st->execute();

            //если уведомления включены, отправлю письмо
            $st = $act->db->prepare("SELECT profile_alert FROM users WHERE id_user = ?");
            $st->bindParam(1, $idNameDB);
            $st->execute();
            $profileAlert = $st->fetchColumn();

            if ($profileAlert == 1) {

                require_once 'Mail.php';
                $action = new Mail;
                $action->newNameMail($email);
            }

            $ok = true;
            $messages[] = 'Successful password update!';
        }
    }
    else {
        $ok = false;
        $messages[] = 'Ooops, somthng going wrong! Try again.';
    }
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);

?>