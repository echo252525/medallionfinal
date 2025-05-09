<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optionally, you can also clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the login page
// header("Location: index.php");
// exit();

echo "<script type='text/javascript'>alert('Logged out successfully.');document.
location='index.php'</script>";
?>