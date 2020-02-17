<?php

$DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
$DB_USER = 'root';
$DB_PASSWORD = '';

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Successfully connected to the database - ajax";
//    echo "<br>";
}
catch (PDOException $e) {
//    echo "Creating or re-creating the database schema FAILED" . $e->getMessage();
//    echo "<br>";
}

// получаю переменные с данными инпутов
$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$newemail = isset($_POST['newemail']) ? $_POST['newemail'] : '';

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

if ( !isset($newemail) || empty($newemail) ) {
    $ok = false;
    $messages[] = 'New email cannot be empty!';
}

// Ошибка мейла 2
if (!empty($newemail) && !filter_var($newemail, FILTER_VALIDATE_EMAIL)) {
    $ok = false;
    $messages[] = 'Incorrect new email';
}


$st = $db->prepare("SELECT id_user FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$idNameDB = $st->fetchColumn();

$st = $db->prepare("SELECT token FROM users WHERE id_user = ?");
$st->bindParam(1, $idNameDB);
$st->execute();
$tokenDB = $st->fetchColumn();


if ($ok) {
    if ($hash == $tokenDB) {

        $st = $db->prepare("SELECT id_user FROM users WHERE email = ?");
        $st->bindParam(1, $newemail);
        $st->execute();
        $checkNewEmail = $st->fetchColumn();

        if ($checkNewEmail) {
            $ok = false;
            $messages[] = 'User with that email exists!';
        }
        else {
            $secret2 = 'Wars-9';
            $token = md5(date("Y-m-d H:i:s") . $secret2);

            //обновляю token
            $st = $db->prepare("UPDATE users SET token = :token WHERE id_user = :id");
            $st->bindParam(':token', $token);
            $st->bindParam(':id', $idNameDB);
            $st->execute();

            //обновляю email
            $st = $db->prepare("UPDATE users SET email = :email WHERE id_user = :id");
            $st->bindParam(':email', $newemail);
            $st->bindParam(':id', $idNameDB);
            $st->execute();

            //обновляю статус онлайн на 0
            $online = 0;
            $st = $db->prepare("UPDATE users SET online = :online WHERE id_user = :id");
            $st->bindParam(':online', $online);
            $st->bindParam(':id', $idNameDB);
            $st->execute();

            $ok = true;
            $messages[] = 'Successful email update!';
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