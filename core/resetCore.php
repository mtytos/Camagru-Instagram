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

//  something else

$email = isset($_POST['email']) ? $_POST['email'] : '';

//$email = 'topic9@mail.ru';

$ok = true;
$messages = array();

if ( !isset($email) || empty($email) ) {
    $ok = false;
    $messages[] = 'Email cannot be empty!';
}

// Ошибка мейла
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ok = false;
    $messages[] = 'Incorrect email';
}

$st = $db->prepare("SELECT id_user FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$idNameDB = $st->fetchColumn();
//echo $idNameDB;
//echo "<br/>";

$st = $db->prepare("SELECT status FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$statusDB = $st->fetchColumn();
//echo $passDB;
//echo "<br/>";

//if ($idNameDB) {
//    echo 'Yes';
//    echo "<br/>";
//}
//else {
//    echo 'No';
//    echo "<br/>";
//}

if ($ok) {
    if ($idNameDB && $statusDB == 0 || $statusDB == 1) {
        $secret = 'Dont_Forget';
        $token = md5(date("Y-m-d H:i:s") . $secret);

        //обновляю token 
        $st = $db->prepare("UPDATE users SET token = :token WHERE email = :email");
        $st->bindParam(':token', $token);
        $st->bindParam(':email', $email);
        $st->execute();

        //обновляю статус щнлайн на 0
        $online = 0;
        $st = $db->prepare("UPDATE users SET online = :online WHERE email = :email");
        $st->bindParam(':online', $online);
        $st->bindParam(':email', $email);
        $st->execute();

        require_once 'Mail.php';
        $action = new Mail;
        $action->sendResetMail($email, $token);
        $ok = true;
        $messages[] = 'Successful login!';
    } else {
        $ok = false;
        $messages[] = 'User has not exists';
    }
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);


// create table users (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(20) NOT NULL, pass VARCHAR(30) NOT NULL, PRIMARY KEY (id));
// INSERT INTO users (name, pass) VALUES ("vova", "1234"), ("alex", "1q2w"), ("kirill", "floda");


?>