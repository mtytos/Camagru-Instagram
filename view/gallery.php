<?php
session_start();
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

            for ($i = count($files) - 1; $i != 0; $i--) {
                if (($files[$i] != ".") && ($files[$i] != "..")) {
                    $path = $dir . $files[$i]; // Получаем путь к картинке
                    // создаю форму для картинки
                    echo "<form method='post' action='post.php'>";
                    echo $files[$i];
                    echo "<br>";
                    echo "<img src='$path' alt='$files[$i]' width='300' />"; // Вывод превью картинки
                    echo "<br>";
                    echo "<button type='submit' name='action' value='$files[$i]'>Like</button>";
                    echo "<button type='submit' name='action' value='$files[$i]'>Comment</button>";

                    // И тут будет еще одна кнопка "УДАЛИТЬ", видима только для владельца этой фотографии
                    //echo "<button type='submit'>Delete</button>";

                    echo "</form>";
                }
            }
            ?>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>