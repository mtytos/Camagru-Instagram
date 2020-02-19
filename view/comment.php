<?php
session_start();
require_once '../config/db.php';
$act = new Db();

if (isset($_SESSION['logged'])) {

    $username = $_SESSION['logged'];

    $DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
    $DB_USER = 'root';
    $DB_PASSWORD = '';
    try {
        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
    }

    $st = $db->prepare("SELECT online FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $onlineDB = $st->fetchColumn();

    if ($onlineDB == 0) {
        header('Location: http://127.0.0.1/Camagru/index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Options</title>
    <link href="../style/styleGallery.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="content">
        <div class="main">
            <?php

            $dir = '../IMG/'; // Папка с изображениями
            $files = scandir($dir); // Беру всё содержимое директории

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
            $st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
            $st->bindParam(1, $username);
            $st->execute();
            $usernameDB = $st->fetchColumn();

            $path = $dir . $_POST['commentbtn']; // Получаем путь к картинке
            $picname = $_POST['commentbtn'];
            echo $picname;
            echo "<br>";
            echo "<img src='$path' alt='#' width='400' />"; // Вывод превью картинки
            $act->showComments($picname, $usernameDB);
            ?>
            <form method="post" action="../core/commentCore.php">
                <p><b>Введите ваш комментарий:</b></p>
                <p><textarea name="commentText"></textarea></p>
                <?php
                echo "<button type='submit' name='btnCommentSend' value='$picname'>Send</button>";
                ?>
            </form>
        </div>
    </div>

    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>