<?php
require './header.php';
if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] != true ) {
	header( './index.php' );
	exit();
}

require './dbconnect.php';
if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ./index.php' );
}

$user_id = mysqli_real_escape_string( $connect, $_GET['id'] );
// Fetch orders from the database according to the user logged in
$query  = "SELECT * FROM `orders` WHERE `cust_id`='$user_id'";
$result = mysqli_query( $connect, $query );
$rows   = mysqli_num_rows( $result );
if ( mysqli_num_rows( $result ) > 0 ) {
	$orders_details = array();
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$orders_details[] = $row;
	}
} else {
	header( 'location: ./index.php' );
	exit();
}
// condition and query for cancelling  the order.
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset( $_POST['delete'] ) ) {
	// Handle order cancellation
	$order_id     = mysqli_real_escape_string( $connect, $_POST['order_id'] );
	$delete_query = "DELETE FROM `orders` WHERE `o_id`='$order_id'";
	$result       = mysqli_query( $connect, $delete_query );

	if ( $result ) {
		echo '<script> 
			if(confirm("Order cancelled successfully!")){ 
				window.location.href = "./my_orders.php?id=' . $user_id . '"; 
			} else { 
				window.location.href = "./index.php";
			} 
			</script>';
		exit();
	} else {
		echo 'Error: ' . mysqli_error( $connect );
	}
	// Redirect to same page to refresh the order list
	// header( "location: ./my_orders.php?id=$user_id" );
	// exit();
}

?>
<!-- Table for showing the data of the logged in user orders -->
<div class="order-table">
	<h2 class="order-table__heading">Order List</h2>
	<?php if ( isset( $orders_details ) && ! empty( $orders_details ) ) : ?>
		<table class="order-table__table" border="1" cellspacing="5" cellpadding="10">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Products List</th>
					<th>Address</th>
					<th>Zip Code</th>
					<th>Total Amount</th>
					<th>Total Items</th>
					<th>Order Placed On</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $count = 1; ?>
				<?php foreach ( $orders_details as $order ) : ?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo htmlspecialchars( $order['p_name'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['cust_address'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['cust_zipcode'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_amount'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_items'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_date'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_status'] ); ?></td>
						<td>
							<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $user_id; ?>">
									<input type="hidden" name="order_id" value="<?php echo $order['o_id']; ?>">
									<button type="submit" class="delete-btn" name="delete">Cancel Order</button>
							</form>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p class="order-table__message">No users found.</p>
	<?php endif; ?>
</div>
