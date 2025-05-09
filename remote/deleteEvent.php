// deleteEvent.php
<?php
include_once "../connection/connection.php";

if (isset($_GET['eventId'])) {
    $eventId = $_GET['eventId'];

    // Delete the event from the database
    $stmt = $pdo->prepare("DELETE FROM `event` WHERE `eventId` = ?");
    $stmt->execute([$eventId]);

    // Redirect after deletion
    header("Location: ../pages/database.php");
}
?>