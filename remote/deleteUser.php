<?php
session_start();
include_once("../connection/connection.php");

// Only allow if logged in (and optionally check admin role)
if (!isset($_SESSION['userid'])) {
    die("Access denied.");
}

if (!isset($_GET['userid']) || !is_numeric($_GET['userid'])) {
    die("Invalid user ID.");
}

$userid = (int)$_GET['userid'];

// Delete the user
$stmt = $pdo->prepare("DELETE FROM users WHERE userid = :userid");
$stmt->execute(['userid' => $userid]);

// Check if the deleted user is the currently logged-in user
if ($userid === $_SESSION['userid']) {
    // Destroy session to log out
    session_unset();
    session_destroy();
    // Redirect to login/index page
    header("Location: ../index.php");
    exit;
} else {
    // Redirect back to the database page
    header("Location: ../pages/database.php");
    exit;
}