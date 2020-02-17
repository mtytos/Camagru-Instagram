<?php
session_start();
require_once '../config/db.php';
$act = new Db();
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

            $path = $dir . $_POST['commentbtn']; // Получаем путь к картинке
            $picname = $_POST['commentbtn'];
            echo $picname;
            echo "<br>";
            echo "<img src='$path' alt='#' width='400' />"; // Вывод превью картинки
            $act->showComments($picname, $_SESSION['logged']);
            ?>
        </div>
    </div>

    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>