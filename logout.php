<?php

	// Access: Admin and Employee
	// Purpose: Logout from the website and redirect to the login page

require 'includes/functions.php';
	logfiles('105');
    session_destroy();
    header("Location: index.php");
exit;
?>