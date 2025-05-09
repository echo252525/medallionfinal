<?php
include_once("../connection/connection.php");

if (isset($_GET['ticketId'])) {
    $ticketId = $_GET['ticketId'];

    // Prepare the DELETE query
    $stmt = $pdo->prepare("DELETE FROM `ticket` WHERE `ticketId` = :ticketId");
    $stmt->bindParam(':ticketId', $ticketId);

    if ($stmt->execute()) {
        header("Location: ../pages/database.php"); // Redirect back to the database page
    } else {
        echo "Error deleting ticket.";
    }
} else {
    echo "Invalid ticket ID.";
}
?>