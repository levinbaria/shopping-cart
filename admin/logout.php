<?php
session_start();

// Check if the user confirmed logout
if ( isset( $_GET['confirm_logout'] ) && $_GET['confirm_logout'] === 'true' ) {
	// Destroy session and redirect to login page
	session_destroy();
	header( 'location: ../admin/login.php' );
	exit();
}

// If confirmation is not received, prompt the user
echo "<script>
    if (confirm('Do you want to Logout?')) {
        window.location.href = 'logout.php?confirm_logout=true';
    } else {
        window.location.href = '../admin/index.php';
    }
</script>";
