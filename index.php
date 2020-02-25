<?php
    session_start();

    if (isset($_SESSION['logged'])) {

        $username = $_SESSION['logged'];

        $DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
        $DB_USER = 'root';
        $DB_PASSWORD = '';
        try {
            $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
        }

        $st = $db->prepare("SELECT online FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $onlineDB = $st->fetchColumn();

        if ($onlineDB == 1) {
            header('Location: http://localhost/view/home.php');
            exit;
        }
    }

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Camagru</title>
    <link href="style/style.css" rel="stylesheet">
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
                <p><a class="gradient-link" href='view/reset.php'>Forggot a password?</a></p>
                <button type="submit" id="btn-submit" value="signin">Sign in</button>
                <p><a class="gradient-link" href='view/signup.php'>Don't have an account<br>Sign up with email</a></p>
                <br><br><br>
                <p><a class="gradient-link" href='view/gallery.php'>You can look at preview Gallery.<br>Tap here</a></p>
            </div>
        </div>
        <div class="footer">
            <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
        </div>
    </div>
    <script src="script/signinAjax.js" ></script>
</body>
</html>