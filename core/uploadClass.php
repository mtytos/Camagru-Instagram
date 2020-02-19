<?php
session_start();

$DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
$DB_USER = 'root';
$DB_PASSWORD = '';

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<br>";
    echo "Successfully connected to the database - ajax";
    echo "<br>";
}
catch (PDOException $e) {
    echo "Creating or re-creating the database schema FAILED" . $e->getMessage();
    echo "<br>";
}

$username = $_SESSION['logged'];

$st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$usernameDB = $st->fetchColumn();

if(isset($_POST['upload'])) {
    $upload_dir = '../IMG/';
    $name = date('YmdHis');
    $name .= '.';
    $name .= $usernameDB;
    $name .= '.jpg';

    copy("$_POST[upload]", $upload_dir . $name);

    //создаю таблицу лайков поста
    $nameLike = $name . '.like';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameLike` (id_like INT NOT NULL AUTO_INCREMENT, id_user VARCHAR(21) NOT NULL, PRIMARY KEY (id_like))";
    $db->exec($sql);
    //создаю таблицу комментов поста
    $nameComment = $name . '.Comment';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameComment` (id_comment INT NOT NULL AUTO_INCREMENT, id_user VARCHAR(21) NOT NULL, comment TEXT, PRIMARY KEY (id_comment))";
    $db->exec($sql);
}

header('Location: http://localhost/Camagru/view/gallery.php');
exit;
?>