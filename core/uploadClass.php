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


if(isset($_POST['upload'])) {
    $upload_dir = '../IMG/';
    $name = date('YmdHis');
    $name .= '.';
    $name .= $_SESSION['logged'];
    $name .= '.jpg';

    copy("$_POST[upload]", $upload_dir . $name);

//    $sql = "CREATE TABLE IF NOT EXISTS `$name` (id_post INT NOT NULL AUTO_INCREMENT, username VARCHAR(21) NOT NULL, PRIMARY KEY (id_post))";
//    $db->exec($sql);

    //создаю таблицу лайков поста
    $nameLike = $name . '.like';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameLike` (id_like INT NOT NULL AUTO_INCREMENT, username VARCHAR(21) NOT NULL, PRIMARY KEY (id_like))";
    $db->exec($sql);
    //создаю таблицу комментов поста
    $nameComment = $name . '.Comment';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameComment` (id_comment INT NOT NULL AUTO_INCREMENT, username VARCHAR(21) NOT NULL, comment TEXT, PRIMARY KEY (id_comment))";
    $db->exec($sql);
}
?>