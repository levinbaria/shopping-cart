<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
	exit();
}

require '../dbconnect.php';

if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ../admin/view_products.php' );
}

// Fetch user details based on ID
$productID = mysqli_real_escape_string( $connect, $_GET['id'] );
// Delete user from the database
$query  = "DELETE FROM `products` WHERE `p_id` = '$productID'";
$result = mysqli_query( $connect, $query );

if ( $result ) {
	// Redirect back to view_user.php after successful deletion
	header( 'location: ../admin/view_products.php' );
	exit();
} else {
	// Handle deletion error
	echo 'Error deleting product.';
}
