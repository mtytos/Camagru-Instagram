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

            if (isset($_SESSION['logged'])) {

                $chekTool = $_SESSION['logged'];

                $DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
                $DB_USER = 'root';
                $DB_PASSWORD = '';
                try {
                    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                }

                $st = $db->prepare("SELECT online FROM users WHERE username = ?");
                $st->bindParam(1, $chekTool);
                $st->execute();
                $onlineDB = $st->fetchColumn();

                if ($onlineDB == 1) {

                    $dir = '../IMG/'; // Папка с изображениями
                    $files = scandir($dir); // Беру всё содержимое директории

                    $DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
                    $DB_USER = 'root';
                    $DB_PASSWORD = '';
                    try {
                        $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    } catch (PDOException $e) {
                    }
                    $username = $_SESSION['logged'];

                    $st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
                    $st->bindParam(1, $username);
                    $st->execute();
                    $usernameDB = $st->fetchColumn();

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
                            echo "<img src='$path' alt='$files[$i]' width='600' />"; // Вывод превью картинки
                            echo "<br>";
                            echo "Like = " . $postLike . "  |  ";
                            echo "Comments = " . $postComment . "  |  ";
                            echo "Posted - " . $c;
                            echo "<br>";
                            $btnName = "Like";
                            if ($act->btnLike($usernameDB, $files[$i])) {
                                $btnName = 'Unlike';
                            } else {
                                $btnName = 'Like';
                            }
                            echo "<button type='submit' name='likebtn' value='$files[$i]'>" . $btnName . "</button>";

                            // И тут будет еще одна кнопка "УДАЛИТЬ", видима только для владельца этой фотографии
                            $checkUser = explode('.', $files[$i]);
                            if ($usernameDB == $checkUser[1]) {
                                echo "<button type='submit' name='deletebtn' value='$files[$i]'>Delete</button>";
                            }
                            echo "</form>";
                            echo "<form method='post' action='comment.php' style='display: inline-block'>";
                            echo "<button type='submit' name='commentbtn' value='$files[$i]'>Comment</button>";
                            echo "</form><br><hr><br>";
                        }
                    }
                }
                else {
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

                            echo "<form>";
                            echo "<img src='$path' alt='$files[$i]' width='600' />"; // Вывод превью картинки
                            echo "<br>";
                            echo "Posted - " . $c . "   ";
                            echo "Like = " . $postLike . "   ";
                            echo "Comments = " . $postComment;
                            echo "<br>";
                            $btnName = "Like";
                            echo "<button type='button'><a href='../index.php'>Like</a></button>";
                            echo "</form>";
                            echo "<form>";
                            echo "<button type='button'><a href='../index.php'>Comment</a></button>";
                            echo "</form>";
                        }
                    }
                }
            }
            else {
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

                        echo "<form>";
                        echo "<img src='$path' alt='$files[$i]' width='600' />"; // Вывод превью картинки
                        echo "<br>";
                        echo "Posted - " . $c . "   ";
                        echo "Like = " . $postLike . "   ";
                        echo "Comments = " . $postComment;
                        echo "<br>";
                        $btnName = "Like";
                        echo "<button type='button'><a href='../index.php'>Like</a></button>";
                        echo "</form>";
                        echo "<form>";
                        echo "<button type='button'><a href='../index.php'>Comment</a></button>";
                        echo "</form>";
                    }
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