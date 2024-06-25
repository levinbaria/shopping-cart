<?php
session_start();
// If user is already logged in, redirect to dashboard
if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {
	header( 'location: ../admin/index.php' );
	exit();
}

$login = false; // Flag for the login.
// Initiallizing the email  and password variable.
$email    = '';
$emailerr = $passworderr = '';
// Condition to check that the method is post and then validate the data.
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	require '../dbconnect.php'; // including the database connection file.
	$email    = $_POST['uemail'];
	$password = $_POST['upassword'];
	validemail( $email ); // validating the email.
	// Validation for the password.
	if ( empty( $password ) ) {
		$passworderr = 'Password blank';
	} else {
		$passworderr = '';
	}

	// Condition if the error field is empty.
	if ( empty( $emailerr ) && empty( $passworderr ) ) {
		$sql    = "SELECT * FROM `admin` WHERE `ad_email`='$email'";
		$result = mysqli_query( $connect, $sql );
		$row    = mysqli_num_rows( $result );
		if ( $row == 1 ) {
			while ( $data = mysqli_fetch_assoc( $result ) ) {
				// Verfying the password with the database and if it is true started the session ans set the cookie.
				if ( password_verify( $password, $data['ad_password'] ) ) {
					$login = true;
					session_start();
					$_SESSION['login'] = true;
					$_SESSION['email'] = $email;
					$_SESSION['id']    = $data['ID'];
					setcookie( 'email', $data['ad_email'], time() + ( 86400 * 30 ), '/' );
					header( 'location: ../admin/index.php' );
					exit();
				}
				// If condition not satisfied error occur.
				else {
					$passworderr = 'Password doesn not match';
				}
			}
		} else {
			$emailerr    = 'Verify email first';
			$passworderr = 'Verify password first';
		}
	}
}


function validemail( $email ) {
	global $emailerr, $connect;
	if ( empty( $email ) ) {
		$emailerr = 'Email is required';
	} else {
		$email = test_input( $email );
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$emailerr = 'Invalid emial';
		} else {
			$existSql    = "SELECT * FROM `admin` where `ad_email`= '$email'";
			$existResult = mysqli_query( $connect, $existSql );
			if ( mysqli_num_rows( $existResult ) == 0 ) {
				$emailerr = 'Email does not exists';
			} else {
				$emailerr = '';
			}
		}
	}
}
// Function to remove unnecessary things from the input data.
function test_input( $data ) {
	$data = trim( $data );
	$data = stripslashes( $data );
	$data = htmlspecialchars( $data );
	return $data;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Font Awesome Link -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" 
	integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" 
	crossorigin="anonymous" referrerpolicy="no-referrer" />

	<!-- External Font Family -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">

	<link
	rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
	/>

	<!-- External CSS file -->
	<link rel="stylesheet"  href="../css/index.css">


	<title>Home | Shoping Cart</title>
</head>
	<h1 class="cart__admin-login">Admin Login</h1>
	<a href="../login.php" style="font-size:1.5rem; color: lightcoral;"> <i class="fa-solid fa-arrow-left" style="margin: 0 10px"></i> For User Login, Click here</a>
	<div class="cart__login-form">
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" id="login-form">
			<h3>Sign In</h3>
			<label for="email">Email</label>
			<input type="email" name="uemail" placeholder="Enter your email" id="email" value = "<?php echo isset( $_COOKIE['email'] ) ? $_COOKIE['email'] : ''; ?>">
			<span class="form__error"><?php echo $emailerr; ?></span>
			<label for="password">Password</label>
			<input type="password" name="upassword" placeholder="Enter Password" id="password">
			<span class="form__error"><?php echo $passworderr; ?></span>
			<input type="submit" value="Sign in" class="cart__sign-btn btn">
		</form>
	</div>

<?php
require '../footer.php';
?>
