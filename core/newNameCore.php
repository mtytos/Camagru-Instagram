<?php
session_start();

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

$newname = isset($_POST['newname']) ? $_POST['newname'] : '';

$ok = true;
$messages = array();

if ( !isset($newname) || empty($newname) ) {
    $ok = false;
    $messages[] = 'Newname cannot be empty!';
}

$username = $_SESSION['logged'];

$st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $newname);
$st->execute();
$checkName = $st->fetchColumn();

if ($checkName) {
    $ok = false;
    $messages[] = 'Incorrect, user with that name already exists';
}
else {

    $st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $idUserBD = $st->fetchColumn();

    $st = $db->prepare("UPDATE users SET username = :username WHERE id_user = :id_user");
    $st->bindParam(':username', $newname);
    $st->bindParam(':id_user', $idUserBD);
    $st->execute();

    $ok = true;
    $messages[] = 'Name has been changed';
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);