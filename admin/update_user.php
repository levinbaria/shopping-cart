<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
	exit();
}

require '../dbconnect.php';

if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ../admin/view_user.php' );
}

// Fetch user details based on ID
$userID = mysqli_real_escape_string( $connect, $_GET['id'] );
$query  = "SELECT * FROM `customer` WHERE `ID` = '$userID'";
$result = mysqli_query( $connect, $query );

if ( mysqli_num_rows( $result ) == 1 ) {
	$user = mysqli_fetch_assoc( $result );
} else {
	// Redirect back if user not found
	header( 'location: ../admin/view_user.php' );
	exit;
}

// Initialize variables
$errors = array();
// Update user details in the database
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	// Handle form submission to update user details
	// Retrieve form data
	$email = mysqli_real_escape_string( $connect, $_POST['email'] );
	if ( empty( $email ) ) {
		array_push( $errors, 'Email is required' );
	} elseif ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
		array_push( $errors, 'Invalid email format' );
	} else {
		$existSql    = "SELECT * FROM `customer` where `cemail`= '$email'";
		$existResult = mysqli_query( $connect, $existSql );
		if ( mysqli_num_rows( $existResult ) == 0 ) {
			array_push( $errors, 'Email does not exists' );
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
	} elseif ( strlen( $password ) < 8 || strlen( $password ) > 25 ) {
		array_push( $errors, 'Password must be between 8 and 25 characters' );
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

		// Update user into database
		$query         = "UPDATE `customer` SET `cemail`='$email', `cname`='$username', `cpassword`='$password' WHERE `ID`='$userID'";
		$update_result = mysqli_query( $connect, $query );
		if ( $update_result ) {
			// Redirect back to view_user.php after successful update
			header( 'location: ../admin/view_user.php' );
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
	<div class="add-user__container">
		<h2 class="add-user__heading">Update User</h2>
		<?php if ( count( $errors ) > 0 ) : ?>
			<div class="errors">
				<?php foreach ( $errors as $error ) : ?>
					<p class="add-user__error"><?php echo $error; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] . '?id=' . urlencode( $userID ) ); ?>"  method="post" class="add-user__form">

			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required value="<?php echo $user['cemail']; ?>">
			</div>
			<div class="form-group">
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" required value="<?php echo $user['cname']; ?>">
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" id="password" name="password" required>
			</div>
			<button type="submit" class="btn">Update User</button>
			<a href="../admin/view_user.php" class="btn" value=cancle>Cancel</a>
		</form>
	</div>
</body>
</html>
