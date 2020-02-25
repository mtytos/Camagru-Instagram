<?php
session_start();
require_once '../config/db.php';
$act = new Db();

if (isset($_SESSION['logged'])) {

    $username = $_SESSION['logged'];

    $st = $act->db->prepare("SELECT online FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $onlineDB = $st->fetchColumn();

    if ($onlineDB == 0) {
        header('Location: http://localhost/index.php');
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
    <div class="home">
        <p><a class="gradient-link" href="home.php">Home</a></p>
    </div>
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="exit">
        <form action="../core/logoutCore.php" method="post">
            <button id="logout" name='exit' value='logout'>Logout</button>
        </form>
    </div>
    <div class="content">
        <div class="main">
            <?php

            $dir = '../IMG/'; // Папка с изображениями
            $files = scandir($dir); // Беру всё содержимое директории

            $username = $_SESSION['logged'];
            $st = $act->db->prepare("SELECT id_user FROM users WHERE username = ?");
            $st->bindParam(1, $username);
            $st->execute();
            $usernameDB = $st->fetchColumn();

            $path = $dir . $_POST['commentbtn']; // Получаем путь к картинке
            $picname = $_POST['commentbtn'];
            echo "<br>";
            echo "<img src='$path' alt='#' width='600' />"; // Вывод превью картинки
            $act->showComments($picname, $usernameDB);
            ?>
            <hr>
            <form method="post" action="../core/commentCore.php">
                <p><b>Введите ваш комментарий:</b></p>
                <p><textarea name="commentText" style="min-width:600px; max-width: 600px; min-height: 50px;"></textarea></p>
                <?php
                echo "<button class='button-gall' type='submit' name='btnCommentSend' value='$picname'>Send</button>";
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