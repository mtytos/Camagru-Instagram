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
    <title>Camagru</title>
    <link href="../style/styleHome.css" rel="stylesheet">
    <script>
        var username = '<?php echo $_SESSION['logged']; ?>';

        function EnableSubmit() {
            var btn = document.getElementById("button1");
            btn.disabled = false;
        }
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
        <div class="forlink">
            <a class="link-btn" href="gallery.php">Gallery</a>
        </div>
    </div>
    <div class="info">
        <p class="nav">Online</p>
    </div>
    <div class="options">
        <div class="forlink">
            <a class="link-btn" href="options.php">Options</a>
        </div>
    </div>
    <div class="exit">
        <form action="../core/logoutCore.php" method="post">
            <button id="logout" name='exit' value='logout'>Logout</button>
        </form>
    </div>
    <div class="menu">
        <div class="tempGallery">
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
            <div class="output" style="display: none">
                <img id="photo" alt="The screen capture will appear in this box.">
            </div>
            <div class="downloadPic">
                <form method="post" enctype="multipart/form-data" action="../core/downloadCore.php">
                    <label><input type="radio" name="mask" value="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/one.png" onclick="EnableSubmit()">
                        <img src="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/one.png"> </label>
                    <label><input type="radio" name="mask" value="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/boroda-png.png" onclick="EnableSubmit()">
                        <img src="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/boroda-png.png" width="200"></label>
                    <label><input type="radio" name="mask" value="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/petuh.png" onclick="EnableSubmit()">
                        <img src="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/petuh.png" width="100"></label>
                    <label><input type="radio" name="mask" value="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/shapka-santy.png" onclick="EnableSubmit()">
                        <img src="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/shapka-santy.png" width="100"></label>
                    <label><input type="radio" name="mask" value="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/star_wars.png" onclick="EnableSubmit()">
                        <img src="https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/tryy/star_wars.png" width="100"></label>
                    <br><br>
                    <input type="file" name="file" accept="image/jpeg">
                    <input type="submit" id="button1" name="download" value="download" disabled="disabled">
                </form>
            </div>
        </div>
    </div>
    <div class="footer">
        <p class="gradient">&copy; Copyright<br>created by student School 21 - Mtytos</p>
    </div>
</div>
</body>
</html>