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

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


$username = 'milckiway';
$password = 'Prosto9!';


$ok = true;
$messages = array();

if ( !isset($username) || empty($username) ) {
    $ok = false;
    $messages[] = 'Username cannot be empty!';
}

if ( !isset($password) || empty($password) ) {
    $ok = false;
    $messages[] = 'Password cannot be empty!';
}


$st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$idNameDB = $st->fetchColumn();
//echo $idNameDB;
//echo "<br/>";

$st = $db->prepare("SELECT password FROM users WHERE id_user = ?");
$st->bindParam(1, $idNameDB);
$st->execute();
$passDB = $st->fetchColumn();
//echo $passDB;
//echo "<br/>";

$st = $db->prepare("SELECT status FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$statusDB = $st->fetchColumn();

//if ($idNameDB) {
//    echo 'Yes';
//    echo "<br/>";
//}
//else {
//    echo 'No';
//    echo "<br/>";
//}

$secret1 = 'Star-9';
$password = md5($password . $secret1);

if ($ok) {
    if ($idNameDB && $password === $passDB) {
        if ($statusDB == 1) {
            $ok = true;
            $messages[] = 'Successful login!';
        }
        else {
            $secret2 = 'Wars-9';
            $token = md5(date("Y-m-d H:i:s") . $secret2);

            $st = $db->prepare("SELECT email FROM users WHERE id_user = ?");
            $st->bindParam(1, $idNameDB);
            $st->execute();
            $emailDB = $st->fetchColumn();

            //Не забудь изменить путь до класса Мэйл после вывода из Core
            require_once 'Mail.php';
            $action = new Mail;
            $action->sendMail($emailDB, $token);
            $ok = false;
            $messages[] = 'Account has not activated. We send you activation instruction to email.';
        }
    } 
    else {
        $ok = false;
        $messages[] = 'Incorrect username/password combination!';
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