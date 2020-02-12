<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Reset password</title>
    <link href="../style/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="header">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="content">
        <div class="main">
            <div id="form-messages"></div>
            <input placeholder="Newname" type="newname" id="newname" name="newname">
            <br>
            <button type="submit" id="btn-submit" value="changeName">Reset password</button>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
<script src="../script/changeNameAjax.js"></script>
</body>
</html>