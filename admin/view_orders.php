<?php
session_start();
if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] != true ) {
	header( './index.php' );
	exit();
}

require '../dbconnect.php';

// Fetch all users from the database
$query  = 'SELECT orders.*, customer.cname  FROM `orders` INNER JOIN `customer` ON orders.cust_id = customer.ID';
$result = mysqli_query( $connect, $query );

if ( mysqli_num_rows( $result ) > 0 ) {
	$orders_details = array();
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$orders_details[] = $row;
	}
}
// Include header file
require '../admin/header.php';
?>

<div class="order-table">
	<h2 class="order-table__heading">Order List</h2>
	<?php if ( isset( $orders_details ) && ! empty( $orders_details ) ) : ?>
		<table class="order-table__table" border="1" cellspacing="5" cellpadding="10">
			<thead>
				<tr>
					<th>Sr. No.</th>
					<th>Customer Name</th>
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
						<td><?php echo htmlspecialchars( $order['cname'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['p_name'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['cust_address'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['cust_zipcode'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_amount'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_items'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_date'] ); ?></td>
						<td><?php echo htmlspecialchars( $order['o_status'] ); ?></td>
						<td>
							<a href="../admin/update_order-status.php?id=<?php echo $order['o_id']; ?>" class="btn btn--update">Update</a>
							<button type="button" class="btn" onclick="confirmDelete(<?php echo $order['o_id']; ?>)">Delete Orders</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p class="order-table__message">No users found.</p>
	<?php endif; ?>
</div>
<script>
	function confirmDelete(orderID) {
		if (confirm("Are you sure you want to delete this order?")) {
			window.location.href = "../admin/delete_order.php?id="+ orderID;
		} else {
			window.location.href = "../admin/view_orders.php";
		}
	}
</script>
