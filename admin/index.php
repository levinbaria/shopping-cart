<?php
session_start();
require '../admin/header.php';

if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {

	require '../dbconnect.php';
	// Initialize variables to store counts
	$totalUsers    = 0;
	$totalProducts = 0;
	$totalOrders   = 0;

	// Query to count total number of users
	$queryTotalUsers  = 'SELECT COUNT(*) AS total_users FROM customer';
	$resultTotalUsers = mysqli_query( $connect, $queryTotalUsers );
	if ( $resultTotalUsers ) {
		$rowTotalUsers = mysqli_fetch_assoc( $resultTotalUsers );
		$totalUsers    = $rowTotalUsers['total_users'];
	}

	// Query to count total number of products
	$queryTotalProducts  = 'SELECT COUNT(*) AS total_products FROM products';
	$resultTotalProducts = mysqli_query( $connect, $queryTotalProducts );
	if ( $resultTotalProducts ) {
		$rowTotalProducts = mysqli_fetch_assoc( $resultTotalProducts );
		$totalProducts    = $rowTotalProducts['total_products'];
	}

	// Query to count total number of orders
	$queryTotalOrders  = 'SELECT COUNT(*) AS total_orders FROM orders';
	$resultTotalOrders = mysqli_query( $connect, $queryTotalOrders );
	if ( $resultTotalOrders ) {
		$rowTotalOrders = mysqli_fetch_assoc( $resultTotalOrders );
		$totalOrders    = $rowTotalOrders['total_orders'];
	}

	// Close database connection
	mysqli_close( $connect );
} else {
	// If user is not logged in, redirect to login page
	header( 'Location: ../admin/login.php' );
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard</title>
	<!-- Add your CSS link here -->
	<link rel="stylesheet" href="../css/admin.css">
</head>
<body>
<?php
	// Check if the user is logged in
if ( isset( $_SESSION['login'] ) && $_SESSION['login'] === true ) {
	// User is logged in, show dashboard content
	echo '<section>';
	echo '<div class="content">';
	// Include your dashboard content here
	echo '<p class= "content__dashboard">Welcome to the Admin Panel</p>';
	echo '</div>';
	echo '</section>';
} else {
	// User is not logged in, show login form
	echo '<div class="error-container">';
	echo '<p>You need to login to access the dashboard.</p>';
	echo '<a href="../admin/login.php">Login</a>';
	echo '</div>';
}
?>

<section class="admin__dashboard">
		<div class="admin__wrapper">
			<div class="admin__hero-user">
				<div class="admin__total-user">
					<h2>Total Users</h2>
					<p><?php echo $totalUsers; ?></p>
				</div>
				<div class="admin__user-icon">
					<i class="fas fa-user"></i>
				</div>
			</div>
			<div class="admin__hero-products">
				<div class="admin__total-products">
					<h2>Total Products</h2>
					<p><?php echo $totalProducts; ?></p>
				</div>
				<div class="admin__products-icon">
					<i class="fa-solid fa-cart-shopping"></i>
				</div>
			</div>
			<div class="admin__hero-orders">
				<div class="admin__total-orders">
					<h2>Total Orders</h2>
					<p><?php echo $totalOrders; ?></p>
				</div>
				<div class="admin__orders-icon">
				<i class="fa-solid fa-bag-shopping"></i>
				</div>
			</div>
		</div>
	</section>

</body>
</html>

