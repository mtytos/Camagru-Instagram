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
}
catch (PDOException $e) {
//    echo "Creating or re-creating the database schema FAILED" . $e->getMessage();
//    echo "<br>";
}


if ($_POST['likebtn']) {

    $username = $_SESSION['logged'];
    $table = $_POST['likebtn'] . '.like';

    $st = $db->prepare("SELECT id_like FROM `$table` WHERE username = ?");
    $st->bindParam(1, $username);
    $st->execute();
    $idLikeDB = $st->fetchColumn();

    if ($idLikeDB) {
        $st = $db->prepare("DELETE FROM `$table` WHERE id_like = :id_like");
        $st->bindParam(':id_like', $idLikeDB);
        $st->execute();
    }
    else {
        $st = $db->prepare("INSERT INTO `$table` (username) VALUES(?)");
        $st->bindParam(1, $username);
        $st->execute();
    }
}

if ($_POST['deletebtn']) {

    $username = $_SESSION['logged'];
    $tableLike = $_POST['deletebtn'] . '.like';
    $tableComment = $_POST['deletebtn'] . '.comment';

    $st = $db->prepare("DROP TABLE `$tableLike`");
    $st->execute();
    $st = $db->prepare("DROP TABLE `$tableComment`");
    $st->execute();
    unlink('../IMG/' . $_POST['deletebtn']);
}

//
//if ($_POST['action'] == 'profileInfo') {
//
//    $username = $_SESSION['logged'];
//
//    $st = $db->prepare("SELECT profile_alert FROM users WHERE username = ?");
//    $st->bindParam(1, $username);
//    $st->execute();
//    $profileDB = $st->fetchColumn();
//
//    if ($profileDB == 1) {
//        $profile = 0;
//        $st = $db->prepare("UPDATE users SET profile_alert = :profile_alert WHERE username = :username");
//        $st->bindParam(':profile_alert', $profile);
//        $st->bindParam(':username', $username);
//        $st->execute();
//    }
//    else {
//        $profile = 1;
//        $st = $db->prepare("UPDATE users SET profile_alert = :profile_alert WHERE username = :username");
//        $st->bindParam(':profile_alert', $profile);
//        $st->bindParam(':username', $username);
//        $st->execute();
//    }
//}
//
header('Location: http://localhost/Camagru/view/gallery.php');
exit;