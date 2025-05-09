<?php
include_once("../connection/connection.php");

if (isset($_GET['seatId'])) {
    $seatId = $_GET['seatId'];

    // Prepare the DELETE query
    $stmt = $pdo->prepare("DELETE FROM `seats` WHERE `seatId` = :seatId");
    $stmt->bindParam(':seatId', $seatId);

    if ($stmt->execute()) {
        header("Location: ../pages/database.php"); // Redirect back to the database page
    } else {
        echo "Error deleting seat.";
    }
} else {
    echo "Invalid seat ID.";
}
?>