<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Change Email</title>
    <link href="../style/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="content">
        <div class="main">
            <form method="post" action="../core/sendNewEmailCore.php">
                <p>Write your Email. We send instruction for change email.</p>
                <br>
                <input placeholder="email" type="email" name="email">
                <br>
                <button type="submit" id="submit" value="newemail">Change email</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>