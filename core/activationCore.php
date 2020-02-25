<?php
session_start();
date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

$ok = true;
$messages = array();

if ( !isset($hash) || empty($hash) ) {
    $ok = false;
    $messages[] = 'Code input cannot be empty!';
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
        $secret = 'Dont_Forget';
        $token = md5(date("Y-m-d H:i:s") . $secret);

        //обновляю token
        $st = $act->db->prepare("UPDATE users SET token = :token WHERE id_user = :id");
        $st->bindParam(':token', $token);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

        $status = 1;
//        $online = 1;

        $st = $act->db->prepare("UPDATE users SET status = :status WHERE id_user = :id");
        $st->bindParam(':status', $status);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

//        $st = $db->prepare("UPDATE users SET online = :online WHERE id_user = :id");
//        $st->bindParam(':online', $online);
//        $st->bindParam(':id', $idNameDB);
//        $st->execute();

        $ok = true;
        $messages[] = 'Successful login!';
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