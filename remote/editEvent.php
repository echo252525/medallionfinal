<?php
// editEvent.php

// Include the database connection file
include_once("../connection/connection.php");

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve POST data
    $eventId = $_POST['eventId'];
    $eventTitle = htmlspecialchars($_POST['eventTitle']);
    $eventDescription = htmlspecialchars($_POST['eventDescription']);
    $eventDate = $_POST['eventDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Prepare the SQL UPDATE query
    $stmt = $pdo->prepare("UPDATE `event` SET 
        `eventTitle` = :eventTitle, 
        `eventDescription` = :eventDescription, 
        `eventDate` = :eventDate, 
        `startTime` = :startTime, 
        `endTime` = :endTime
        WHERE `eventId` = :eventId");

    // Bind the parameters and execute the query
    $stmt->bindParam(':eventId', $eventId);
    $stmt->bindParam(':eventTitle', $eventTitle);
    $stmt->bindParam(':eventDescription', $eventDescription);
    $stmt->bindParam(':eventDate', $eventDate);
    $stmt->bindParam(':startTime', $startTime);
    $stmt->bindParam(':endTime', $endTime);

    if ($stmt->execute()) {
        // Redirect to the page displaying events after a successful update
        header("Location: ../pages/database.php");
    } else {
        echo "Error updating event.";
    }
}
?>