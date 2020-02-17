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

            for ($i = count($files) - 1; $i != 0; $i--) {
                if (($files[$i] != ".") && ($files[$i] != "..")) {
                    $path = $dir . $files[$i]; // Получаем путь к картинке
                    // создаю форму для картинки
                    $postLike = $act->countLike($files[$i]);
                    $postComment = $act->countComment($files[$i]);

                    $b = explode(".", $files[$i]);
                    $c = substr_replace($b[0], ".", 4, 0);
                    $c = substr_replace($c, ".", 7, 0);
                    $c = substr_replace($c, ".", 10, 0);
                    $c = substr($c, 0, 10);

                    echo "<form method='post' action='../core/galleryCore.php'>";
                    echo $files[$i];
                    echo "<br>";
                    echo "<img src='$path' alt='$files[$i]' width='200' />"; // Вывод превью картинки
                    echo "<br>";
                    echo "Posted - " . $c;
                    echo "<br>";
                    echo "Like = " . $postLike;
                    echo "<br>";
                    echo "Comments = " . $postComment;
                    echo "<br>";
                    $btnName = "Like";
                    if ($act->btnLike($_SESSION['logged'], $files[$i])) {
                        $btnName = 'Unlike';
                    }
                    else {
                        $btnName = 'Like';
                    }
                    echo "<button type='submit' name='likebtn' value='$files[$i]'>" . $btnName ."</button>";

                    // И тут будет еще одна кнопка "УДАЛИТЬ", видима только для владельца этой фотографии
                    $checkUser = explode('.', $files[$i]);
                    if ($_SESSION['logged'] == $checkUser[1]) {
                        echo "<button type='submit' name='deletebtn' value='$files[$i]'>Delete</button>";
                    }
                    echo "</form>";
                    echo "<form method='post' action='comment.php'>";
                    echo "<button type='submit' name='commentbtn' value='$files[$i]'>Comment</button>";
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