<?php
session_start();

//    if (!isset($_SESSION['logged'])) {
//        header('Location: http://127.0.0.1/index.php');
//        exit;
//    }
$sen = 'test';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Camagru</title>
    <link href="../style/styleHome.css" rel="stylesheet">
    <script>
        var pe = '<?php echo $sen; ?>';
    </script>
    <script src="../script/webcam.js"></script>
</head>
<body>
<div class="container">
    <div class="logo">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="greetings">
        <p class="nav">Hello, </p>
    </div>
    <div class="info">
        <p class="nav">Online</p>
    </div>
    <div class="options">
        <button id="options" name='action' value='logout'><a class="link-btn" href="options.php">Options</a></button>
    </div>
    <div class="exit">
        <button id="logout" name='action' value='logout'>Logout</button>
    </div>
    <div class="menu">
        <form method='POST' action='action.php'>
            <p id="try" class="thumb">
                <img src="images/thumb1.jpg" alt="Фотография 1" width="120" height="120">
                <img src="images/thumb3.jpg" alt="Фотография 2" width="120" height="120">
                <img src="images/thumb3.jpg" alt="Фотография 3" width="120" height="120">
                <img src="images/thumb4.jpg" alt="Фотография 4" width="120" height="120">
            </p>
        </form>
    </div>
    <div class="content">
        <div class="main">
            <div class="camera">
                <video id="video">Video stream not available.</video>
                <button id="startbutton">Take photo</button>
            </div>
            <canvas id="canvas"></canvas>
            <div class="output">
                <img id="photo" alt="The screen capture will appear in this box.">
            </div>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>