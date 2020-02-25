<?php
session_start();
date_default_timezone_set('Europe/Moscow');
require_once '../config/db.php';
$act = new Db();

if (empty($_FILES['file']['size'])) die('Вы не выбрали файл');
if ($_FILES['file']['size'] > (5 * 1024 * 1024)) die('Размер файла не должен превышать 5Мб');

$stick = $_POST['mask'];
$pic = $_FILES['file']['tmp_name'];

// Загрузка штампа и фото, для которого применяется водяной знак (называется штамп или печать)
$stamp = imagecreatefrompng($stick);
$im = imagecreatefromjpeg($pic);

// Установка полей для штампа и получение высоты/ширины штампа
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);

// Копирование изображения штампа на фотографию с помощью смещения края
// и ширины фотографии для расчета позиционирования штампа.
imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));


$username = $_SESSION['logged'];

$st = $act->db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$usernameDB = $st->fetchColumn();


$upload_dir = '../IMG/';
$name = date('YmdHis');
$name .= '.';
$name .= $usernameDB;
$name .= '.jpg';


//создаю таблицу лайков поста
$nameLike = $name . '.like';
$sql = "CREATE TABLE IF NOT EXISTS `$nameLike` (id_like INT NOT NULL AUTO_INCREMENT, id_user VARCHAR(21) NOT NULL, PRIMARY KEY (id_like))";
$act->db->exec($sql);
//создаю таблицу комментов поста
$nameComment = $name . '.Comment';
$sql = "CREATE TABLE IF NOT EXISTS `$nameComment` (id_comment INT NOT NULL AUTO_INCREMENT, id_user VARCHAR(21) NOT NULL, comment TEXT, PRIMARY KEY (id_comment))";
$act->db->exec($sql);


$npath = $upload_dir . $name;
imagejpeg($im, $npath);
imagedestroy($im);


header('Location: http://localhost/view/gallery.php');
exit;

?>