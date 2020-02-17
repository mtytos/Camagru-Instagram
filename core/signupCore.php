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

// получаю переменные с данными инпутов
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$repassword = isset($_POST['repassword']) ? $_POST['repassword'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';

$ok = true;
$messages = array();

//$username = 'kiri';
//$password = 'Prosto9!';
//$repassword = 'Prosto9!';
//$email = 'topic99@mail.ru';

// Проверка на пустые инпуты, хотя...можно было просто инпутам формы добавить require и сократить код тут. Может так и сделаю
if ( !isset($username) || empty($username) ) {
    $ok = false;
    $messages[] = 'Username cannot be empty!';
}

// Ошибка ника
if (!empty($username) && !preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $username)) {
    $ok = false;
    $messages[] = 'Username could contain only uppercase and lowercase words, figures and special sign _ ';
}

if ( !isset($password) || empty($password) ) {
    $ok = false;
    $messages[] = 'Password cannot be empty!';
}

// Ошибка пароля
if (!empty($password) && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@!%*#?&])[A-Za-z\d@!%*#?&]{6,}/', $password)) {
    $ok = false;
    $messages[] = 'Password should contain one uppercase and lowercase word, one figure and special sign - @!%*#?&';
}

if ( !isset($repassword) || empty($repassword) ) {
    $ok = false;
    $messages[] = 'Repeat password cannot be empty!';
}

if ( !isset($email) || empty($email) ) {
    $ok = false;
    $messages[] = 'Email cannot be empty!';
}

// Ошибка мейла
if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $ok = false;
    $messages[] = 'Incorrect email';
}


// получаю id из БД для проверки на существование nickname
$st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$checkName = $st->fetchColumn();
//echo $checkName;
//echo "<br/>";

// получаю id из БД для проверки на существование email
$st = $db->prepare("SELECT id_user FROM users WHERE email = ?");
$st->bindParam(1, $email);
$st->execute();
$checkEmail = $st->fetchColumn();
//echo $checkEmail;
//echo "<br/>";
//
//echo $username;
//echo "<br/>";
//echo $repassword;
//echo "<br/>";

// $stp = $db->prepare("SELECT pass FROM users WHERE id = ?");
// $stp->bindParam(1, $idNameDB);;
// $stp->execute();
// $passDB = $stp->fetchColumn();
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
    if ($checkName) {
        $ok = false;
        $messages[] = 'Incorrect, user with that name already exists';
    }
    else {
        if ($checkEmail) {
            $ok = false;
            $messages[] = 'Incorrect, account with that email already exists';
        }
        else {
            if ($password !== $repassword) {
                $ok = false;
                $messages[] = 'Incorrect, passwords do not match';
            }
            else {
                $secret1 = 'Star-9';
                $password = md5($password . $secret1);
                $secret2 = 'Wars-9';
                $token = md5(date("Y-m-d H:i:s") . $secret2);
                insertUserData($username, $email, $password, $token, $db);
                $ok = true;
                $messages[] = 'Successful create!';
                require_once 'Mail.php';
                $action = new Mail;
                $action->sendMail($email, $token);
            }
        }
    }
}

function insertUserData($username, $email, $password, $token, $db) {

    $status = 0;
    $like_alert = 1;
    $comment_alert = 1;
    $profile_alert = 1;
    $online = 0;

    $st = $db->prepare("INSERT INTO users (username, email, password, status, token, like_alert, comment_alert, profile_alert, online) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $st->bindParam(1, $username);
    $st->bindParam(2, $email);
    $st->bindParam(3, $password);
    $st->bindParam(4, $status);
    $st->bindParam(5, $token);
    $st->bindParam(6, $like_alert);
    $st->bindParam(7, $comment_alert);
    $st->bindParam(8, $profile_alert);
    $st->bindParam(9, $online);
    $st->execute();
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