<?php
session_start();
if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] != true ) {
	header( './index.php' );
	exit();
}

require '../dbconnect.php';
if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ./index.php' );
}

$order_id = mysqli_real_escape_string( $connect, $_GET['id'] );
// Fetch all users from the database
$query  = "SELECT * FROM `orders` WHERE `o_id`='$order_id'";
$result = mysqli_query( $connect, $query );

if ( mysqli_num_rows( $result ) == 1 ) {
	$user = mysqli_fetch_assoc( $result );
} else {
	header( 'location: ../admin/view_orders.php' );
	exit;
}

// Initialize variables
$errors = array();
// Update user details in the database
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$status = $_POST['status'];

	if ( ( $status == 'Select' ) ) {
		$errors[] = 'Choose the relevant order status';
	}

	if ( empty( $errors ) ) {
		$query  = "UPDATE `orders` SET `o_status`='$status' WHERE `o_id`='$order_id'";
		$result = mysqli_query( $connect, $query );
		if ( $result ) {
			echo '<script> 
				if(confirm("Status updated successfully!")){ 
					window.location.href = "../admin/view_orders.php"; // Redirect to view_product.php 
				} else { 
					window.location.href = "../admin/index.php";// Redirect to index.php (dashboard) 
				} 
				</script>';
			exit();
		} else {
			$errors[] = 'Error: ' . mysqli_error( $connect );
		}
	}
}
?>
<?php
require '../admin/header.php';
?>

	<div class="order-status__container">
		<h2 class="order-status__heading">Update Order Status</h2>
		<?php if ( count( $errors ) > 0 ) : ?>
			<div class="errors">
				<?php foreach ( $errors as $error ) : ?>
					<p class="add-user__error"><?php echo $error; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] . '?id=' . urlencode( $order_id ) ); ?>"  method="post" class="order-status__form">
			<div class="order-status__field">
				<label for="order_id" class="order-status__label">Status:</label>
				<select name="status" id="order_id" class="order-status__select" required>
					<option value="select" <?php echo ( $user['o_status'] == 'select' ) ? 'selected' : ''; ?>>Select</option>
					<option value="Order Dispatched and will be delivered today" <?php echo ( $user['o_status'] == 'Order Dispatched and will be delivered today' ) ? 'selected' : ''; ?>>Order Dispatched and will be delivered today</option>
					<option value="Pending(Order not Shipped yet)" <?php echo ( $user['o_status'] == 'Pending(Order not Shipped yet)' ) ? 'selected' : ''; ?>>Pending(Order not Shipped yet)</option>
					<option value="Rejected due to out of stocks" <?php echo ( $user['o_status'] == 'Rejected due to out of stocks' ) ? 'selected' : ''; ?>>Rejected due to out of stocks</option>
					<option value="Order Shipped" <?php echo ( $user['o_status'] == 'Order Shipped' ) ? 'selected' : ''; ?>>Order Shipped</option>
					<option value="Order delivered within 2 days" <?php echo ( $user['o_status'] == 'Order delivered within 2 days' ) ? 'selected' : ''; ?>>Order delivered within 2 days</option>
				</select>

			</div>
			<button type="submit" name="order-status__update" class="order-status__submit">Update Status</button>
		</form>
	</div>
