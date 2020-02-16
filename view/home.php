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
    } catch (PDOException $e) {
    }

    $st = $db->prepare("SELECT online FROM users WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $onlineDB = $st->fetchColumn();

    if ($onlineDB == 0) {
        header('Location: http://127.0.0.1/Camagru/index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Camagru</title>
    <link href="../style/styleHome.css" rel="stylesheet">
    <script>
        var username = '<?php echo $_SESSION['logged']; ?>';
    </script>
    <script src="../script/scriptWebCam.js"></script>
</head>
<body>
<div class="container">
    <div class="logo">
        <p class="gradient">CAMAGRU</p>
    </div>
    <div class="user-greeting">
        <p class="nav">Hello, <?php echo $_SESSION['logged']; ?></p>
    </div>
    <div class="gallery">
        <button type="button" id="gallery"><a class="link-btn" href="gallery.php">Gallery</a></button>
    </div>
    <div class="info">
        <p class="nav">Online</p>
    </div>
    <div class="options">
        <button type="button" id="options"><a class="link-btn" href="options.php">Options</a></button>
    </div>
    <div class="exit">
        <form action="../core/logoutCore.php" method="post">
            <button id="logout" name='exit' value='logout'>Logout</button>
        </form>
    </div>
    <div class="menu">
        <div class="tempGallery">
            <div class="downloadPic">
                <form method="post" enctype="multipart/form-data" action="../core/downloadCore.php">
                    <input type="file" name="file" />
                    <input type="submit" name="download" value="download" />
                </form>
            </div>
            <div id="tempPic" class="thumb"></div>
        </div>
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