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

if(isset($_POST['download'])) {
    if(empty($_FILES['file']['size']))  die('Вы не выбрали файл');
    if($_FILES['file']['size'] > (5 * 1024 * 1024)) die('Размер файла не должен превышать 5Мб');

    $upload_dir = '../IMG/';
    $name = date('YmdHis');
    $name .= '.';
    $name .= $_SESSION['logged'];
    $name .= '.jpg';
    $mov = move_uploaded_file($_FILES['file']['tmp_name'],"../IMG/".$name);


    //создаю таблицу лайков поста
    $nameLike = $name . '.like';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameLike` (id_like INT NOT NULL AUTO_INCREMENT, username VARCHAR(21) NOT NULL, PRIMARY KEY (id_like))";
    $db->exec($sql);
    //создаю таблицу комментов поста
    $nameComment = $name . '.Comment';
    $sql = "CREATE TABLE IF NOT EXISTS `$nameComment` (id_comment INT NOT NULL AUTO_INCREMENT, username VARCHAR(21) NOT NULL, comment TEXT, PRIMARY KEY (id_comment))";
    $db->exec($sql);

}

header('Location: http://localhost/Camagru/view/gallery.php');
exit;
?>