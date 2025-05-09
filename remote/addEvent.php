<?php
include_once("../connection/session.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect the event data from the form
    $eventTitle = $_POST['eventTitle'];
    $eventDescription = $_POST['eventDescription'];
    $eventDate = $_POST['eventDate'];
    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];

    // Handle file upload for event picture
    if (isset($_FILES['eventPicture']) && $_FILES['eventPicture']['error'] == 0) {
        $targetDir = "../uploads/"; // Path to store uploaded images
        $fileName = basename($_FILES["eventPicture"]["name"]);
        $targetFile = $targetDir . $fileName;

        // Ensure the file is an image
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($imageFileType, $validExtensions)) {
            // Check if file already exists
            if (file_exists($targetFile)) {
                echo "Sorry, file already exists.";
            } else {
                // Try to upload the file
                if (move_uploaded_file($_FILES["eventPicture"]["tmp_name"], $targetFile)) {
                    $eventPicture = $targetFile; // Store the path of the uploaded picture
                } else {
                    $eventPicture = ''; // If file upload fails, set to empty
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $eventPicture = ''; // If file is not an image, set to empty
            echo "Only image files are allowed (jpg, jpeg, png, gif).";
        }
    } else {
        $eventPicture = ''; // If no file is uploaded
    }

    // Insert the event into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO event (eventTitle, eventPicture, eventDescription, eventDate, startTime, endTime) 
                               VALUES (:eventTitle, :eventPicture, :eventDescription, :eventDate, :startTime, :endTime)");
        $stmt->bindParam(':eventTitle', $eventTitle);
        $stmt->bindParam(':eventPicture', $eventPicture);
        $stmt->bindParam(':eventDescription', $eventDescription);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':startTime', $startTime);
        $stmt->bindParam(':endTime', $endTime);
        $stmt->execute();

        echo "Event added successfully!";
        // Redirect to the database page
        header("Location: ../pages/database.php");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>