<?php

date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

$email = isset($_POST['email']) ? $_POST['email'] : '';

$ok = true;

if ( !isset($email) || empty($email) ) {
    $ok = false;
}

// Ошибка мейла
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ok = false;
}

$st = $act->db->prepare("SELECT id_user FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$idNameDB = $st->fetchColumn();

if ($ok) {
    if ($idNameDB) {
        $secret = 'Dont_Forget';
        $token = md5(date("Y-m-d H:i:s") . $secret);

        //обновляю token
        $st = $act->db->prepare("UPDATE users SET token = :token WHERE email = :email");
        $st->bindParam(':token', $token);
        $st->bindParam(':email', $email);
        $st->execute();

        require_once 'Mail.php';
        $action = new Mail;
        $action->resetEmailMail($email, $token);
    }
}

header('Location: http://localhost/view/home.php');
exit;

?>