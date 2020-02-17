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
    <link href="../style/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="content">
        <div class="main">
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления о лайках ваших постов - <b>
                        <?php
                            if ($act->likeInfo($_SESSION['logged']) == 1) {
                                echo 'Включены';
                            }
                            else {
                                echo 'Отключены';
                            }
                        ?></b></p>
                <button type="submit" name="action" value="likeInfo">Изменить</button>
            </form>
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления о комментариях ваших постов - <b>
                        <?php
                        if ($act->commentInfo($_SESSION['logged']) == 1) {
                            echo 'Включены';
                        }
                        else {
                            echo 'Отключены';
                        }
                        ?></b></p>
                <button type="submit" name="action" value="commentInfo">Изменить</button>
            </form>
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления об изменении данных профиля - <b>
                        <?php
                        if ($act->profileInfo($_SESSION['logged']) == 1) {
                            echo 'Включены';
                        }
                        else {
                            echo 'Отключены';
                        }
                        ?></b></p>
                <button type="submit" name="action" value="profileInfo">Изменить</button>
            </form>
            <a class="link-btn" href='reset.php'>Изменить пароль</a>
            <br/>
            <a class="link-btn" href='newName.php'>Изменить имя профиля</a>
            <br/>
            <a class="link-btn" href='#'>Изменить почтовый адрес аккаунта</a>
            <br/>
            <a class="link-btn" href='home.php'>Home</a>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>