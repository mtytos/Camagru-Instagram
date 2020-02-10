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

$btnSubmit = isset($_POST['btnSubmit']) ? $_POST['btnSubmit'] : '';

$ok = false;
//$messages = array();

if ($btnSubmit == 'like') {
    $username = $_SESSION['logged'];

    $st = $db->prepare("SELECT like_alert FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $likeDB = $st->fetchColumn();

    if ($likeDB == 1) {
        $like = 0;
        $st = $db->prepare("UPDATE users SET like_alert = :like_alert WHERE username = :username");
        $st->bindParam(':like_alert', $like);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    else {
        $like = 1;
        $st = $db->prepare("UPDATE users SET like_alert = :like_alert WHERE username = :username");
        $st->bindParam(':like_alert', $like);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    $ok = true;
}

echo json_encode(
    array(
        'ok' => $ok,
//        'messages' => $messages
    )
);