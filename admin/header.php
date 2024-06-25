<?php
// session_start();
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
	<!-- <link rel="stylesheet"  href="../css/index.css"> -->
	<link rel="stylesheet"  href="../css/admin.css">

	<!-- Rxternal JS file -->
	<script src="../js/admin.js"></script>


	<title>Admin-Panel | Shoping Cart</title>
</head>
<body>
	<?php if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) : ?>
		<!-- Header part -->
		<header class="cart__header">
			<nav class="cart__nav-1">
				<a href="#" class="cart__logo"><i class="fa-solid fa-cart-shopping"></i>MobileKART</a>

				<div class="cart__derivatives-icon">
					<?php
						// session_start();
					if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {
						// If user is logged in, display username and ID.
						echo '<div class = "user-name" style="cursor:pointer; font-size:1rem">' . $_SESSION['email'] . '</div>
								<div class="cart__user-profile-box">
									<button id="logout-btn">Logout</button>
									<button id="update-btn">Update</button>
							</div>';
						echo '				<script>
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
								window.location.href = "../admin/logout.php"; // Redirect to logout page
							});

							updateBtn.addEventListener("click", function () {
								window.location.href = "../admin/update.php"; // Redirect to register page
							});
						</script>';
					} else {
						// If user is not logged in, remove the username and ID.
						echo '<div class="cart__user-icon">
								<a  class="fa-solid fa-user" id="user-icon"></a>
								<div class="cart__login-register-box" id="login-register-box">
									<div class="buttons-container">
										<button id="login-btn">Login</button>
									</div>
									<div class="anchor-container">
										<a href="../login.php">For User, click here</a>
									</div>
								</div>
							
							</div>';
						echo '<script>
							const userIcon = document.getElementById("user-icon");
							const loginRegisterBox = document.getElementById("login-register-box");
							const loginBtn = document.getElementById("login-btn");

							userIcon.addEventListener("click", function () {
								loginRegisterBox.classList.toggle("active");
								userIcon.classList.toggle("icon-active");
							});

							loginBtn.addEventListener("click", function () {
								window.location.href = "../admin/login.php"; // Redirect to login page
							});

						</script>';
					}
					?>
				</div>
			</nav>
			<div class="sidebar">
			<nav class="sidebar__nav">
				<ul class="nav">
					<li class="nav__item"><a href="../admin/index.php" class="nav__link">Dashboard</a></li>
					<li class="nav__item nav__item--has-submenu">
						<a href="#" class="nav__link">Users <i class="fa-solid fa-chevron-right"></i></a>
						<ul class="submenu" type="none">
							<li class="submenu__item"><a href="../admin/view_user.php" class="submenu__link">View Users</a></li>
							<li class="submenu__item"><a href="../admin/add_user.php" class="submenu__link">Add User</a></li>
						</ul>
					</li>
					<li class="nav__item nav__item--has-submenu">
						<a href="#" class="nav__link"> Products <i class="fa-solid fa-chevron-right"></i></a>
						<ul class="submenu" type="none">
							<li class="submenu__item"><a href="../admin/view_products.php" class="submenu__link">View Productss</a></li>
							<li class="submenu__item"><a href="../admin/add_products.php" class="submenu__link">Add Products</a></li>
						</ul>
					</li>
					<li class="nav__item nav__item--has-submenu">
						<a href="#" class="nav__link"> Brands <i class="fa-solid fa-chevron-right"></i></a>
						<ul class="submenu" type="none">
							<li class="submenu__item"><a href="../admin/view_brands.php" class="submenu__link">View Brands</a></li>
							<li class="submenu__item"><a href="../admin/add_brands.php" class="submenu__link">Add Brands</a></li>
						</ul>
					</li>
					<li class="nav__item nav__item--has-submenu">
						<a href="#" class="nav__link">Orders <i class="fa-solid fa-chevron-right"></i></a>
						<ul class="submenu" type="none">
							<li class="submenu__item"><a href="../admin/view_orders.php" class="submenu__link">View Orders</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
		</header>
		<!-- Header section ends -->
	<?php endif; ?>
