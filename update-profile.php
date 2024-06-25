<?php
require './dbconnect.php';
require './header.php';
// Condition to check if the user is logged in or not
if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ./login.php' );
	exit();
}

// Initializing the variable to empty.
$uname    = $email = '';
$emailerr = $unameerr = $passworderr = $cpassworderr = '';
$user_id  = $_SESSION['id'];
$update_profile = true; // flag to set the update profile

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	// Storing the data of the form.
	$uname     = $_POST['uname'];
	$email     = $_POST['email'];
	$password  = $_POST['password'];
	$cpassword = $_POST['cpassword'];

	validuname( $uname );
	validemail( $email );

	// if the user want to delete the data then the flag is false.
	if ( isset( $_POST['delete'] ) ) {
		$update_profile = false;
		// script to confirm that the user want to delete the data.
		echo "<script>
		if (window.confirm('Are you sure, you want to delete your profile?')) {
			window.location.href = 'delete_profile.php';
		} else {
			window.location.href = 'update-profile.php';
		}
		</script>";
		exit();
	} else {
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
			if ( empty( $password ) && empty( $cpassword ) ) {
				echo '<script>alert("Enter your password to confirm the update")</script>';
			} elseif ( $cpassword != $password ) {
				$cpassworderr = 'Passwords do not match';
			} else {
				$hash   = password_hash( $password, PASSWORD_DEFAULT );
				$sql    = "UPDATE `customer` SET  `cname`='$uname',`cemail`='$email',`cpassword`='$hash' WHERE ";
				$result = mysqli_query( $connect, $sql );
				if ( $result ) {
					echo '<script>alert("Updation successful")</script>';
					echo '<script>
						setTimeout(()=>{
							window.location.href = "dashboard.php"
						},50);	
					</script>';
					exit();
				}
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
	<div class="cart__registration-form">
			<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>"  id="registration-form" method="post">
				<h3>Update Profile</h3>
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
				<button type="submit" class="update-profile__btn">Update</button>
				<button type="submit" class="update-profile__delete-btn update-profile__btn" name="delete">Delete Profile</button>
				<a href="./index.php">Cancel</a>
			</form>
		</div>



<?php
require './footer.php';
