<?php
include_once("../connection/session.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = $_POST['userid'];
    $fullname = $_POST['fullname'];
    $contactNumber = $_POST['contactNumber'];
    $balance = $_POST['balance'];
    $email = $_POST['email'];

    $stmt = $pdo->prepare("UPDATE users SET fullname = ?, contactNumber = ?, balance = ?, email = ? WHERE userid = ?");
    $stmt->execute([$fullname, $contactNumber, $balance, $email, $userid]);

    header("Location: ../pages/database.php");
    exit();
}
?>