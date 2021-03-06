<?php

date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

// получаю переменные с данными инпутов
$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';

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

if ( !isset($password) || empty($password) ) {
    $ok = false;
    $messages[] = 'Password cannot be empty!';
}

// Ошибка пароля
if (!empty($password) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!%*#?&])[A-Za-z\d@!%*#?&]{6,}/', $password)) {
    $ok = false;
    $messages[] = 'Password should contain one uppercase and lowercase word, one figure and special sign - @!%*#?&';
}

if ( !isset($repassword) || empty($repassword) ) {
    $ok = false;
    $messages[] = 'Repeat password cannot be empty!';
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
    if ($hash == $tokenDB && $password == $repassword) {

        $secret1 = 'Star-9';
        $password = md5($password . $secret1);
        $secret2 = 'Wars-9';
        $token = md5(date("Y-m-d H:i:s") . $secret2);

        //обновляю token
        $st = $act->db->prepare("UPDATE users SET token = :token WHERE id_user = :id");
        $st->bindParam(':token', $token);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

        //обновляю пароль
        $st = $act->db->prepare("UPDATE users SET password = :password WHERE id_user = :id");
        $st->bindParam(':password', $password);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

        //обновляю статус онлайн на 0
        $online = 0;
        $st = $act->db->prepare("UPDATE users SET online = :online WHERE id_user = :id");
        $st->bindParam(':online', $online);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

        $ok = true;
        $messages[] = 'Successful password update!';
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