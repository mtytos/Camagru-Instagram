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

if ($_POST['action'] == 'likeInfo') {

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
}

if ($_POST['action'] == 'commentInfo') {

    $username = $_SESSION['logged'];

    $st = $db->prepare("SELECT comment_alert FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $commentDB = $st->fetchColumn();

    if ($commentDB == 1) {
        $comment = 0;
        $st = $db->prepare("UPDATE users SET comment_alert = :comment_alert WHERE username = :username");
        $st->bindParam(':comment_alert', $comment);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    else {
        $comment = 1;
        $st = $db->prepare("UPDATE users SET comment_alert = :comment_alert WHERE username = :username");
        $st->bindParam(':comment_alert', $comment);
        $st->bindParam(':username', $username);
        $st->execute();
    }
}

if ($_POST['action'] == 'profileInfo ') {

    $username = $_SESSION['logged'];

    $st = $db->prepare("SELECT profile_alert FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $profileDB = $st->fetchColumn();

    if ($profileDB == 1) {
        $profile = 0;
        $st = $db->prepare("UPDATE users SET profile_alert = :profile_alert WHERE username = :username");
        $st->bindParam(':profile_alert', $profile);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    else {
        $profile = 1;
        $st = $db->prepare("UPDATE users SET profile_alert = :profile_alert WHERE username = :username");
        $st->bindParam(':profile_alert', $profile);
        $st->bindParam(':username', $username);
        $st->execute();
    }
}

header('Location: http://localhost/Camagru/view/options.php');
exit;