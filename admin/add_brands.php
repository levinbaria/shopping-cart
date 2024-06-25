<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
	exit();
}

require '../dbconnect.php';

// Initialize variables
$errors = array();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$brand_name = mysqli_real_escape_string( $connect, $_POST['brand_name'] );
	if ( empty( $brand_name ) ) {
		array_push( $errors, 'Brand Name is required' );
	} else {
		$existSql    = "SELECT * FROM `brands` where `b_name`= '$brand_name'";
		$existResult = mysqli_query( $connect, $existSql );
		if ( mysqli_num_rows( $existResult ) == 1 ) {
			array_push( $errors, 'Brand name already exists' );
		}
	}

	// If no validation errors, insert user into database
	if ( count( $errors ) == 0 ) {
		$sql = "INSERT INTO `brands`(`b_name`) VALUES ('$brand_name')";
		mysqli_query( $connect, $sql );

		echo '<script> 
			if(confirm("Brand added successfully!")){ 
				window.location.href = "../admin/add_brands.php"; // Redirect to add_user.php 
			} else { 
				window.location.href = "../admin/index.php";// Redirect to index.php (dashboard) 
			} 
			</script>';
		// exit();
	}
}
?>
<?php
require '../admin/header.php';
?>
<div class="add-user__container">
	<h2 class="add-user__heading">Add Brands</h2>
	<?php if ( count( $errors ) > 0 ) : ?>
		<div class="errors">
			<?php foreach ( $errors as $error ) : ?>
				<p class="add-user__error"><?php echo $error; ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="add-user__form">
		<div class="form-group">
			<label for="brand_name">Brand Name:</label>
			<input type="text" id="brand_name" name="brand_name" required>
		</div>
		<button type="submit" name="add_brand">Add Brand</button>
	</form>
</div>
