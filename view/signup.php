<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Camagru</title>
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
            <input placeholder="Nickname" type="text" id="username" name="username">
            <br>
            <input placeholder="Password" type="password" id="password" name="password">
            <br>
            <input placeholder="Repeat password" type="password" id="repassword" name="repassword">
            <br>
            <input placeholder="Email" type="email" id="email" name="email">
            <br>
            <button type="submit" id="btn-submit" value="signin">Sign up</button>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
<script src="../script/signupAjax.js"></script>
</body>
</html>