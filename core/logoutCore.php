<?php
session_start();

if ($_POST['exit'] == 'logout') {

    $DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
    $DB_USER = 'root';
    $DB_PASSWORD = '';
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
    }

    $username = $_SESSION['logged'];

    $online = 0;
    $st = $db->prepare("UPDATE users SET online = :online WHERE username = :username");
    $st->bindParam(':online', $online);
    $st->bindParam(':username', $username);
    $st->execute();

    header('Location: ../index.php');
    exit;
}