<?php
// Start session
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'Location: ../admin/index.php' );
	exit;
}

// Include database connection file
require '../dbconnect.php';

// Initialize variables
$errors = array();

// Form submission handling
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	// Validate email
	$email = mysqli_real_escape_string( $connect, $_POST['email'] );
	if ( empty( $email ) ) {
		array_push( $errors, 'Email is required' );
	} elseif ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		array_push( $errors, 'Invalid email format' );
	} else {
		$existSql    = "SELECT * FROM `customer` where `cemail`= '$email'";
		$existResult = mysqli_query( $connect, $existSql );
		if ( mysqli_num_rows( $existResult ) == 1 ) {
			array_push( $errors, 'Email does exists' );
		}
	}

	// Validate username
	$username = mysqli_real_escape_string( $connect, $_POST['username'] );
	if ( empty( $username ) ) {
		array_push( $errors, 'Username is required' );
	} elseif ( strlen( $username ) < 3 || strlen( $username ) > 25 ) {
		array_push( $errors, 'Username must be 3 charc. long or max. 25 charac.' );
	}

	// Validate password
	$password = mysqli_real_escape_string( $connect, $_POST['password'] );
	if ( empty( $password ) ) {
		array_push( $errors, 'Password is required' );
	} elseif ( strlen( $password ) < 8 ) {
		array_push( $errors, 'Password must be at least 8 characters long' );
	} elseif ( strlen( $password ) > 25 ) {
		array_push( $errors, 'Password must not exceed 25 characters' );
	} elseif ( ! preg_match( '/[A-Z]/', $password ) ) {
		array_push( $errors, 'Password must contain at least one uppercase letter' );
	} elseif ( ! preg_match( '/[a-z]/', $password ) ) {
		array_push( $errors, 'Password must contain at least one lowercase letter' );
	} elseif ( ! preg_match( '/[0-9]/', $password ) ) {
		array_push( $errors, 'Password must contain at least one number' );
	} elseif ( ! preg_match( '/[^a-zA-Z0-9]/', $password ) ) {
		array_push( $errors, 'Password must contain at least one special character' );
	}


	// If no validation errors, insert user into database
	if ( count( $errors ) == 0 ) {
		// Hash password before storing in database
		$hashed_password = password_hash( $password, PASSWORD_DEFAULT );

		// Insert user into database
		$query = "INSERT INTO `customer` (`cemail`, `cname`, `cpassword`) VALUES ('$email', '$username', '$hashed_password')";
		mysqli_query( $connect, $query );

		echo '<script> 
			if(confirm("User added successfully!")){ 
				window.location.href = "../admin/add_user.php"; // Redirect to add_user.php 
			} else { 
				window.location.href = "../admin/index.php";// Redirect to index.php (dashboard) 
			} 
			</script>';

		// Redirect to success page or display success message
		// $_SESSION['success'] = 'User added successfully!';
		// header( 'location: ../admin/add_user.php' );
		exit();
	}
}
?>
<?php
require '../admin/header.php';
?>
	<div class="add-user__container">
		<h2 class="add-user__heading">Add User</h2>
		<?php if ( count( $errors ) > 0 ) : ?>
			<div class="errors">
				<?php foreach ( $errors as $error ) : ?>
					<p class="add-user__error"><?php echo $error; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="add-user__form">
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required>
			</div>
			<div class="form-group">
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" required>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" required>
			</div>
			<button type="submit" class="btn">Add User</button>
		</form>
	</div>
</body>
</html>
