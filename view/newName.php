<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Change Nickname</title>
    <link href="../style/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="content">
        <div class="main">
            <form method="post" action="../core/sendNewNameCore.php">
                <p>Write your Email. We send instruction for change nickname.</p>
                <br>
                <input placeholder="email" type="email" name="email">
                <br>
                <button type="submit" id="submit" value="newname">Change name</button>
            </form>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>