<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
	exit();
}

require '../dbconnect.php';

if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ../admin/view_brands.php' );
}

// Fetch user details based on ID
$brandsID = mysqli_real_escape_string( $connect, $_GET['id'] );
// Delete user from the database
$query  = "DELETE FROM `brands` WHERE `ID` = '$brandsID'";
$result = mysqli_query( $connect, $query );

if ( $result ) {
	// Redirect back to view_user.php after successful deletion
	header( 'location: ../admin/view_brands.php' );
	exit();
} else {
	// Handle deletion error
	echo 'Error deleting user.';
}
