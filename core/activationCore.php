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

$hash = isset($_POST['hash']) ? $_POST['hash'] : '';
$username = isset($_POST['username']) ? $_POST['username'] : '';

$ok = true;
$messages = array();

if ( !isset($hash) || empty($hash) ) {
    $ok = false;
    $messages[] = 'Code input cannot be empty!';
}

if ( !isset($username) || empty($username) ) {
    $ok = false;
    $messages[] = 'Username cannot be empty!';
}

// Ошибка ника
if (!empty($username) && !preg_match('/^[a-zA-Z][a-zA-Z0-9-_\.]{1,20}$/', $username)) {
    $ok = false;
    $messages[] = 'Incorrect username';
}

$st = $db->prepare("SELECT id_user FROM users WHERE username = ?");
$st->bindParam(1, $username);
$st->execute();
$idNameDB = $st->fetchColumn();

$st = $db->prepare("SELECT token FROM users WHERE id_user = ?");
$st->bindParam(1, $idNameDB);
$st->execute();
$tokenDB = $st->fetchColumn();

if ($ok) {
    if ($hash === $tokenDB) {
        $secret = 'Dont_Forget';
        $token = md5(date("Y-m-d H:i:s") . $secret);

        //обновляю token
        $st = $db->prepare("UPDATE users SET token = :token WHERE id_user = :id");
        $st->bindParam(':token', $token);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

        $status = 1;

        $st = $db->prepare("UPDATE users SET status = :status WHERE id_user = :id");
        $st->bindParam(':token', $status);
        $st->bindParam(':id', $idNameDB);
        $st->execute();

        $ok = true;
        $messages[] = 'Successful login!';
    } else {
        $ok = false;
        $messages[] = 'Ooops, somthng going wrong! Try again.';
    }
}

echo json_encode(
    array(
        'ok' => $ok,
        'messages' => $messages
    )
);

?>