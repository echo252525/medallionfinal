<?php
// Include database connection
include_once "../connection/connection.php";

if (isset($_POST['signUp'])) {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contact'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    
    // Validate passwords match
    if ($password !== $confirmPassword) {
        echo '<script type="text/javascript">alert("Passwords do not match!"); window.location = "../signUp.php"; </script>';
        exit();
    }

    // Validate contact number is numeric
    if (!ctype_digit($contactNumber)) {
        echo '<script type="text/javascript">alert("Contact number must be numeric only!"); window.location = "../signUp.php"; </script>';
        exit();
    }

    // Check if email already exists
    $checkQuery = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $checkQuery->bindParam(':email', $email);
    $checkQuery->execute();
    $emailCount = $checkQuery->fetchColumn();

    if ($emailCount > 0) {
        echo '<script type="text/javascript">alert("Email is already registered!"); window.location = "../signUp.php"; </script>';
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Get current date and time
    $dateCreated = date('Y-m-d H:i:s');

    // Set initial balance
    $balance = 0;

    // Insert into database
    $query = $pdo->prepare("INSERT INTO users (fullname, contactNumber, balance, email, password, dateCreated) 
                            VALUES (:fullname, :contactNumber, :balance, :email, :password, :dateCreated)");

    $query->bindParam(':fullname', $fullname);
    $query->bindParam(':contactNumber', $contactNumber);
    $query->bindParam(':balance', $balance);
    $query->bindParam(':email', $email);
    $query->bindParam(':password', $hashedPassword);
    $query->bindParam(':dateCreated', $dateCreated);

    if ($query->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error during sign up!";
    }
}
?>