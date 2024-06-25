<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>iDiscuss-Forum</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
		integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
	</script>
</head>
<body>
	<?php require './dbconnect.php'; ?>
	<?php require './header.php'; ?>
	<?php
	$show_alert = false;
	// storing the form data into the database for the contact us if any quey exist
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
		$name       = $_POST['contact_name'];
		$email      = $_POST['email'];
		$message    = $_POST['msg'];
		$sql        = "INSERT INTO `contacts` (`Contact_name`, `Contact_email`, `Contact_msg`, `Time`) VALUES ('$name', '$email', '$message', current_timestamp())";
		$result     = mysqli_query( $connect, $sql );
		$show_alert = true;
		if ( $show_alert ) {
			echo "<script> alert('Your query is been informed😊, we will get back to you soon')</script>";
		}
	}
	?>
	<!-- Form for accepting the query -->
	<div class="container my-3">
		<h1 class="text-center my-3">Contact Us</h1>
		<div class="container-fluid px-5 my-5">
			<div class="row justify-content-center align-items-center">
				<div class="col-xl-10">
					<div class="card border-0 rounded-3 shadow-lg overflow-hidden">
						<div class="card-body p-0">
							<div class="row g-0">
								<div class="p-4">
									<div class="text-center">
										<div class="h3 fw-light"><b>If any Query Kindly Contact us</b></div>
									</div>
									<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method='post'>
										<div class="form-floating mb-3">
											<input class="form-control" id="name" type="text" placeholder="Name" name="contact_name" required />
											<label for="name">Name</label>
										</div>
										<div class="form-floating mb-3">
											<input class="form-control" id="emailAddress" type="email" name="email" placeholder="Email Address" required />
											<label for="emailAddress">Email Address</label>
										</div>
										<div class="form-floating mb-3">
											<textarea class="form-control" id="message" type="text" name="msg" placeholder="Enter the message" style="height:10rem;" required></textarea>
											<label for="message">Message</label>
										</div>
								</div>
								<div class="d-grid mt-3">
									<button class="btn btn-success" type="submit">Submit</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</div>
	</div>
	<?php require './footer.php'; ?>
</body>
</html>
