<?php
session_start();
// Include the connection file
include_once("../connection/connection.php");

// Check if the form is submitted
if (isset($_POST['logIn'])) {
    // Retrieve the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare the SQL query to select the user based on email
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $email);
        $query->execute();

        // Check if a user with the provided email exists
        if ($query->rowCount() > 0) {
            // Fetch the user data
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // Verify the provided password with the stored hashed password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start a session
                $_SESSION['userid'] = $user['userid']; // Store the user ID in the session
                $_SESSION['fullname'] = $user['fullname']; // Store the user full name in the session
                
                // Redirect the user to the homepage or dashboard
                echo "<script type='text/javascript'>alert('Welcome!');document.location='../pages/database.php'</script>";        

                exit();
            } else {
                // Incorrect password
                echo '<script type = "text/javascript">alert("Incorrect password."); window.location = "../index.php"; </script>';
            }
        } else {
            // No user found with the provided email
            echo '<script type = "text/javascript">alert("No account data in database."); window.location = "../index.php"; </script>';
        }
    } catch (PDOException $e) {
        // If there's a database error
        echo "Error: " . $e->getMessage();
    }
}
?>