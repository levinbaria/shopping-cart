<?php
session_start();
// If user is already logged in, redirect to dashboard
if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {
	header( 'Location: dashboard.php' );
	exit();
}
// require './header.php';
// Initializing the variable to empty.
$uname    = $email = '';
$emailerr = $unameerr = $passworderr = $cpassworderr = '';
// Flag for error and succes and initializing it to false.

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	// database connectivity should be required.
	require './dbconnect.php';
	// Storing the data of the form.
	$uname     = $_POST['uname'];
	$email     = $_POST['email'];
	$password  = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	validuname( $uname );
	validemail( $email );
	// Validation of password and confirm password.
	if ( empty( $password ) ) {
		$passworderr = 'Enter Password please';
	} elseif ( empty( $cpassword ) ) {
		$cpassworderr = '	Confirm your password';
	} elseif ( strlen( $password ) < 8 || strlen( $password ) > 16 ) {
		$passworderr = 'required min. 8 char. and max. 16';
	} elseif ( ! preg_match( '/[A-Z]/', $password ) ) {
		$passworderr = 'One alphabet required';
	} else {
		$passworderr = '';
	}
	// Condition to check that if all the error field is empty then insert the data into the database and head it to login page.
	if ( empty( $unameerr ) && empty( $emailerr ) && empty( $passworderr ) ) {
		if ( $cpassword == $password ) {
			$hash   = password_hash( $password, PASSWORD_DEFAULT );
			$sql    = "INSERT INTO `customer` (`cname`,`cemail`,`cpassword`,`r_time`) VALUES ('$uname','$email','$hash',current_timestamp())";
			$result = mysqli_query( $connect, $sql );
			if ( $result ) {
				echo '<script>
					alert("Registration successful");
					window.location.href = "login.php";
				</script>';
				exit();
			}
		}
		// If condition not satisfied show error.
		else {
			$cpassworderr = 'Passwords do not match';
		}
	}
}
// Function to validate the user name.
function validuname( $uname ) {
	global  $unameerr, $connect;
	if ( empty( $uname ) ) {
		$unameerr = 'username is required';
	} elseif ( strlen( $uname ) < 3 || strlen( $uname ) > 25 ) {
		$unameerr = 'minimum 3 charc. and max 25 charc. allowed';
	} else {
		$uname = test_input( $uname );
		if ( ! preg_match( '/^[a-zA-Z]*$/', $uname ) ) {
			$unameerr = 'Only Letters and white space allowed';
		} else {
			$existSql    = "SELECT * FROM `customer` where `cname`= '$uname'";
			$existResult = mysqli_query( $connect, $existSql );
			if ( mysqli_num_rows( $existResult ) > 0 ) {
				$unameerr = 'User Already Exists';
			} else {
				$unameerr = '';
			}
		}
	}
}

// Function to validate the email.
function validemail( $email ) {
	global  $emailerr, $connect;
	if ( empty( $email ) ) {
		$emailerr = 'Email is required';
	} else {
		$email = strtolower( test_input( $email ) );
		if ( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ) {
			$emailerr = 'Invalid emial';
		} else {
			$existSql    = "SELECT * FROM `customer` where `cemail`= '$email'";
			$existResult = mysqli_query( $connect, $existSql );
			if ( mysqli_num_rows( $existResult ) > 0 ) {
				$emailerr = 'Email Already Exists';
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
	<link rel="stylesheet"  href="./css/index.css">


	<title>Home | Shoping Cart</title>
</head>
	<h1 class="cart__user-register">User Registration</h1>
	<a href="./login.php" style="font-size:1.5rem; color: lightcoral;"> <i class="fa-solid fa-arrow-left" style="margin: 0 10px"></i> For Login, Click here</a>
	<div class="cart__registration-form">
			<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>"  id="registration-form" method="post">
				<h3>Sign Up</h3>
				<label for="uname">Username</label>
				<input type="text" name="uname" placeholder="Enter your username" id="uname" value="<?php echo $uname; ?>">
				<span class="form__error"><?php echo $unameerr; ?></span>
				<label for="email">	Email</label>
				<input type="email" name="email" placeholder="Enter your email" id="email" value="<?php echo $email; ?>">
				<spanp class="form__error"><?php echo $emailerr; ?></spanp>
				<label for="password">Password</label>
				<input type="password" name="password" placeholder="Enter Password" id="password">
				<spanp class="form__error"><?php echo $passworderr; ?></spanp>
				<label for="cpassword">Confirm Password</label>
				<input type="password" name="cpassword" placeholder="Confirm Password" id="cpassword">
				<spanp class="form__error"><?php echo $cpassworderr; ?></spanp>
				<input type="submit" value="Sign up" class="cart__sign-up-btn btn">
				<p>Forget Password ?</p><a href="#">Click here</a>
				<p>Already have an account ?</p><a href="./login.php">Click here to login</a>

			</form>
		</div>

<?php
require './footer.php';
?>
