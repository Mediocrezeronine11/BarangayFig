<?php
session_start();
session_unset(); // This function removes all session variables
// Destroy the session
session_destroy(); // This function destroys the session data on the server
// Unset all session variables
unset($_SESSION['authenticated']);
unset($_SESSION['auth_user']);

// Set a logout status message
$_SESSION['status'] = "Logout Successful Ina Mo!<span>&#129324;</span>";

// Redirect to login page
header("Location: login.php");
exit(0); // Always call exit after a redirect
?>
