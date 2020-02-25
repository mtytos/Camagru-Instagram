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
    <link href="../style/styleOptions.css" rel="stylesheet">
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
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления о лайках ваших постов - <b>
                        <?php
                            if ($act->likeInfo($_SESSION['logged']) == 1) {
                                echo "<span style='color: green;'>Включены</span>";
                            }
                            else {
                                echo "<span style='color: red;'>Отключены</span>";
                            }
                        ?></b></p><br>
                <button class='button-gall' type="submit" name="action" value="likeInfo">Изменить</button>
            </form>
            <br><br>
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления о комментариях ваших постов - <b>
                        <?php
                        if ($act->commentInfo($_SESSION['logged']) == 1) {
                            echo "<span style='color: green;'>Включены</span>";
                        }
                        else {
                            echo "<span style='color: red;'>Отключены</span>";
                        }
                        ?></b></p><br>
                <button class='button-gall' type="submit" name="action" value="commentInfo">Изменить</button>
            </form>
            <br><br>
            <form action="../core/optionsCore.php" method="post">
                <p>Уведомления об изменении данных профиля - <b>
                        <?php
                        if ($act->profileInfo($_SESSION['logged']) == 1) {
                            echo "<span style='color: green;'>Включены</span>";
                        }
                        else {
                            echo "<span style='color: red;'>Отключены</span>";
                        }
                        ?></b></p><br>
                <button class='button-gall' type="submit" name="action" value="profileInfo">Изменить</button>
            </form>
            <br><br>
            <hr>
            <br>
            <h3>Раздел измененния данных профиля</h3>
            <br>
            <a class="gradient-link" href='newEmail.php'>Изменить почтовый адрес аккаунта</a>
            <br><br>
            <a class="gradient-link" href='reset.php'>Изменить пароль</a>
            <br><br>
            <a class="gradient-link" href='newName.php'>Изменить имя профиля</a>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>