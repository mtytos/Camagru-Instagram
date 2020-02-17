<?php
session_start();

$DB_DSN = 'mysql:host=127.0.0.1;dbname=camagru';
$DB_USER = 'root';
$DB_PASSWORD = '';

try {
    $db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "Successfully connected to the database - ajax";
//    echo "<br>";
} catch (PDOException $e) {
//    echo "Creating or re-creating the database schema FAILED" . $e->getMessage();
//    echo "<br>";
}

if ($_POST['btnCommentSend']) {

    $username = $_SESSION['logged'];
    $table = $_POST['btnCommentSend'] . '.comment';
    $comment = htmlspecialchars($_POST['commentText']);

    $st = $db->prepare("INSERT INTO `$table` (username, comment) VALUES(?, ?)");
    $st->bindParam(1, $username);
    $st->bindParam(2, $comment);
    $st->execute();
}

if ($_POST['deleteComment']) {

    $tmp = explode(".", $_POST['deleteComment']);
    $idDel = $tmp[0];
    unset($tmp[0]);
    $table = implode(".", $tmp);

    $st = $db->prepare("DELETE FROM `$table` WHERE id_comment = :id_comment");
    $st->bindParam(':id_comment', $idDel);
    $st->execute();
}

header('Location: http://localhost/Camagru/view/gallery.php');
exit;