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
$query    = "SELECT * FROM `brands` WHERE `ID` = '$brandsID'";
$result   = mysqli_query( $connect, $query );

if ( mysqli_num_rows( $result ) == 1 ) {
	$brand = mysqli_fetch_assoc( $result );
} else {
	// Redirect back if user not found
	header( 'location: ../admin/view_brands.php' );
	exit();
}

// Initialize variables
$errors = array();
// Update user details in the database
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$brand_name = mysqli_real_escape_string( $connect, $_POST['brand_name'] );
	if ( empty( $brand_name ) ) {
		array_push( $errors, 'Brand Name is required' );
	} else {
		$existSql    = "SELECT * FROM `brands` WHERE `b_name`= '$brand_name'";
		$existResult = mysqli_query( $connect, $existSql );
		if ( mysqli_num_rows( $existResult ) >= 1 ) {
			array_push( $errors, 'Brand name already exists' );
		}
	}

	if ( count( $errors ) == 0 ) {
		$query         = "UPDATE `brands` SET `b_name` = '$brand_name' WHERE `ID`='$brandsID'";
		$update_result = mysqli_query( $connect, $query );
		if ( $update_result ) {
			// Redirect back to view_user.php after successful update
			header( 'location: ../admin/view_brands.php' );
			exit();
		} else {
			// Handle update error
			echo 'Error updating user details.';
		}
	}
}

?>


<?php
require '../admin/header.php';
?>
<div class="update-brands__container">
		<h2 class="update-brands__heading">Update Brands</h2>
		<?php if ( count( $errors ) > 0 ) : ?>
			<div class="errors">
				<?php foreach ( $errors as $error ) : ?>
					<p class="update-brands__error"><?php echo $error; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] . '?id=' . urlencode( $brandsID ) ); ?>" method="post" class="add-user__form">
			<div class="form-group">
				<label for="brand_name">Brand Name:</label>
				<input type="text" id="brand_name" name="brand_name" required value="<?php echo $brand['b_name']; ?>">
			</div>
			<button type="submit" name="add_brand">Update Brand</button>
		</form>
</div>
