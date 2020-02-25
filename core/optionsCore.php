<?php
session_start();

date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

if ($_POST['action'] == 'likeInfo') {

    $username = $_SESSION['logged'];

    $st = $act->db->prepare("SELECT like_alert FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $likeDB = $st->fetchColumn();

    if ($likeDB == 1) {
        $like = 0;
        $st = $act->db->prepare("UPDATE users SET like_alert = :like_alert WHERE username = :username");
        $st->bindParam(':like_alert', $like);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    else {
        $like = 1;
        $st = $act->db->prepare("UPDATE users SET like_alert = :like_alert WHERE username = :username");
        $st->bindParam(':like_alert', $like);
        $st->bindParam(':username', $username);
        $st->execute();
    }
}

if ($_POST['action'] == 'commentInfo') {

    $username = $_SESSION['logged'];

    $st = $act->db->prepare("SELECT comment_alert FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $commentDB = $st->fetchColumn();

    if ($commentDB == 1) {
        $comment = 0;
        $st = $act->db->prepare("UPDATE users SET comment_alert = :comment_alert WHERE username = :username");
        $st->bindParam(':comment_alert', $comment);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    else {
        $comment = 1;
        $st = $act->db->prepare("UPDATE users SET comment_alert = :comment_alert WHERE username = :username");
        $st->bindParam(':comment_alert', $comment);
        $st->bindParam(':username', $username);
        $st->execute();
    }
}

if ($_POST['action'] == 'profileInfo') {

    $username = $_SESSION['logged'];

    $st = $act->db->prepare("SELECT profile_alert FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $profileDB = $st->fetchColumn();

    if ($profileDB == 1) {
        $profile = 0;
        $st = $act->db->prepare("UPDATE users SET profile_alert = :profile_alert WHERE username = :username");
        $st->bindParam(':profile_alert', $profile);
        $st->bindParam(':username', $username);
        $st->execute();
    }
    else {
        $profile = 1;
        $st = $act->db->prepare("UPDATE users SET profile_alert = :profile_alert WHERE username = :username");
        $st->bindParam(':profile_alert', $profile);
        $st->bindParam(':username', $username);
        $st->execute();
    }
}

header('Location: http://localhost/view/options.php');
exit;