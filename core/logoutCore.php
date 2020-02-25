<?php
session_start();
require_once '../config/db.php';
$act = new Db();

if ($_POST['exit'] == 'logout') {

    $username = $_SESSION['logged'];

    $online = 0;
    $st = $act->db->prepare("UPDATE users SET online = :online WHERE username = :username");
    $st->bindParam(':online', $online);
    $st->bindParam(':username', $username);
    $st->execute();

    header('Location: ../index.php');
    exit;
}