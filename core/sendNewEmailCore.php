<?php

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

$email = isset($_POST['email']) ? $_POST['email'] : '';

$ok = true;

if ( !isset($email) || empty($email) ) {
    $ok = false;
}

// Ошибка мейла
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ok = false;
}

$st = $db->prepare("SELECT id_user FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$idNameDB = $st->fetchColumn();

if ($ok) {
    if ($idNameDB) {
        $secret = 'Dont_Forget';
        $token = md5(date("Y-m-d H:i:s") . $secret);

        //обновляю token
        $st = $db->prepare("UPDATE users SET token = :token WHERE email = :email");
        $st->bindParam(':token', $token);
        $st->bindParam(':email', $email);
        $st->execute();

        require_once 'Mail.php';
        $action = new Mail;
        $action->resetEmailMail($email, $token);
    }
}

header('Location: http://localhost/Camagru/view/home.php');
exit;

?>