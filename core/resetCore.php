<?php

date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

$email = isset($_POST['email']) ? $_POST['email'] : '';

$ok = true;
$messages = array();

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

$st = $act->db->prepare("SELECT status FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$statusDB = $st->fetchColumn();

if ($ok) {
    if ($idNameDB && $statusDB == 0 || $statusDB == 1) {
        $secret = 'Dont_Forget';
        $token = md5(date("Y-m-d H:i:s") . $secret);

        //обновляю token 
        $st = $act->db->prepare("UPDATE users SET token = :token WHERE email = :email");
        $st->bindParam(':token', $token);
        $st->bindParam(':email', $email);
        $st->execute();

        //обновляю статус щнлайн на 0
        $online = 0;
        $st = $act->db->prepare("UPDATE users SET online = :online WHERE email = :email");
        $st->bindParam(':online', $online);
        $st->bindParam(':email', $email);
        $st->execute();

        require_once 'Mail.php';
        $action = new Mail;
        $action->sendResetMail($email, $token);
        $ok = true;
        $messages[] = 'Successful login!';
    }
    else {
        $ok = false;
        $messages[] = 'User has not exists';
    }
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);

?>