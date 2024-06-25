<?php
session_start();
if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {
	$userID = $_SESSION['id'];
} else {
	$userID = null;
}
// echo $userID;
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
	<script src="./js/index.js" defer></script>

	<title>Home | Shoping Cart</title>
</head>
<body>
	<p hidden class="user-id"><?php echo $userID; ?></p>
	<!-- Header part -->
	<header class="cart__header">
		<nav class="cart__nav-1">
			<a href="./index.php" class="cart__logo"><i class="fa-solid fa-cart-shopping"></i>MobileKART</a>

			<!-- <form action="" method="post" class="cart__search-form">
				<input type="text" name="product" placeholder="search products" id="search-box">
				<label for="search-box" class="fa-solid fa-magnifying-glass"></label>
			</form> -->

			<div class="cart__derivatives-icon">
				<a href="#" class="fa-solid fa-bag-shopping"><span class="cart__items">0</span></a>
				<a href="#" class="fa-solid fa-heart"><span class="cart__wishlist">0</span></a>
				<?php
					// session_start();
				if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {
					// If user is logged in, display username and ID
					echo '<div class = "user-name" style="cursor:pointer">' . $_SESSION['username'] . '</div>
							<div class="cart__user-profile-box">
								<p>' . $_SESSION['email'] . '</p>
								<a href="./my_orders.php?id=' . $userID . '">My Orders</a>
								<button id="logout-btn">Logout</button>
								<button id="update-btn">Update</button>
						</div>';
					echo '<script>
						const userName = document.querySelector(".user-name");
						const userProfileBox = document.querySelector(".cart__user-profile-box");
						const logoutBtn = document.getElementById("logout-btn");
						const updateBtn = document.getElementById("update-btn");
						userName.addEventListener("click", function () {
							userProfileBox.classList.toggle("active");
							userName.classList.toggle("icon-active");
						});
						// Add event listener for logout button
						document.getElementById("logout-btn").addEventListener("click", function () {
							console.log("clicked");
							window.location.href = "logout.php"; // Redirect to logout page
						});

						updateBtn.addEventListener("click", function () {
							window.location.href = "update-profile.php"; // Redirect to register page
						});
					</script>';
				} else {
					// If user is not logged in, remove the username and ID.
					echo '<div class="cart__user-icon">
							<a  class="fa-solid fa-user" id="user-icon" style="cursor:pointer"></a>
							<div class="cart__login-register-box" id="login-register-box">
								<div class="buttons-container">
									<button id="login-btn">Login</button>
									<button id="register-btn">Register</button>
								</div>
								<div class="anchor-container">
									<a href="./admin/login.php">For Admin, click here</a>
								</div>
						</div>
						
						</div>';
					echo '<script>
						const userIcon = document.getElementById("user-icon");
						const loginRegisterBox = document.getElementById("login-register-box");
						const loginBtn = document.getElementById("login-btn");
						const registerBtn = document.getElementById("register-btn");

						userIcon.addEventListener("click", function () {
							loginRegisterBox.classList.toggle("active");
							userIcon.classList.toggle("icon-active");
						});

						loginBtn.addEventListener("click", function () {
							window.location.href = "login.php"; // Redirect to login page
						});

						registerBtn.addEventListener("click", function () {
							window.location.href = "register.php"; // Redirect to register page
						});
					</script>';
				}
				?>
			</div>
		</nav>
		<hr>
		<nav class="cart__nav-2">
			<div class="cart__menu-icon" id="nav-toggle">
				<i class="fa-solid fa-bars"></i>
			</div>
			<ul type="none" class="cart__main-nav">
				<li><a href="./index.php">Home</a></li>
				<li><a href="./all_products.php">Products</a></li>
				<li><a href="./brands.php">Brands</a></li>
				<li><a href="./category.php">Category</a></li>
				<li><a href="./contact_us.php">Contact</a></li>
			</ul>

		</nav>
	</header>

	<!-- Add-to-cart section -->

	<section class="add-to-cart">
		<div class="add-to-cart__wrapper">
			<div class="add-to-cart__header">
				<h2>Your Items</h2>
				<i class="fas fa-close"></i>
			</div>
			<div class="add-to-cart__list-items">

			</div>
			<?php
			if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
				echo '<div class="add-to-cart__footer">
				<a href="./login.php" class="checkout">For checkout, Login First</a>
				</div>';
			} else {
				echo '<div class="add-to-cart__footer">
						<a href="./preview_details.php" class="checkout">Checkout</a>
						<button class="removeall">Remove All</button>
					</div>';
			}
			?>

		</div>
	</section>
	<!-- Add to cart ends -->

	<section class="add-to-wishlist">
		<div class="add-to-wishlist__wrapper">
			<div class="add-to-wishlist__header">
				<h2>Your Wishlist</h2>
				<i class="fas fa-close wishlist-close"></i>
			</div>
			<div class="add-to-wishlist__list-items">

			</div>
			<?php
			if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
				echo '<div class="add-to-wishlist__footer">
				<a href="./login.php" class="checkout">For checkout, Login First</a>
				</div>';
			} else {
				echo '<div class="add-to-wishlist__footer">
						<button class="checkout">Add to cart</button>
						<button class="removeall">Remove All</button>
					</div>';
			}
			?>

		</div>
	</section>
	<!-- Header section ends -->

