<?php
session_start();

date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

$username = $_SESSION['logged'];

$st = $act->db->prepare("SELECT id_user FROM users WHERE username = ?");
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
    $act->db->exec($sql);
    //создаю таблицу комментов поста
    $nameComment = $name . '.Comment';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameComment` (id_comment INT NOT NULL AUTO_INCREMENT, id_user VARCHAR(21) NOT NULL, comment TEXT, PRIMARY KEY (id_comment))";
    $act->db->exec($sql);
}

header('Location: http://localhost/view/gallery.php');
exit;
?>