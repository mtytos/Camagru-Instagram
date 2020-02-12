<?php
session_start();

class Options {

    public function likeInfo() {

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

        $username = $_SESSION['logged'];
        $st = $db->prepare("SELECT like_alert FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $likeDB = $st->fetchColumn();
        return $likeDB;
    }

    public function commentInfo() {

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

        $username = $_SESSION['logged'];
        $st = $db->prepare("SELECT comment_alert FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $commentDB = $st->fetchColumn();
        return $commentDB;
    }

    public function profileInfo() {

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

        $username = $_SESSION['logged'];
        $st = $db->prepare("SELECT profile_alert FROM users WHERE username = ?");
        $st->bindParam(1, $username);
        $st->execute();
        $profileDB = $st->fetchColumn();
        return $profileDB;
    }

}