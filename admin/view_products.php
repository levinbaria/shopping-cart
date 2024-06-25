<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
	exit();
}
// Include database connection file
require '../dbconnect.php';

// Fetch all users from the database
$query  = 'SELECT * FROM `products`';
$result = mysqli_query( $connect, $query );

// Check if users exist
if ( mysqli_num_rows( $result ) > 0 ) {
	// Initialize an empty array to store user data
	$products = array();

	// Fetch user data and store it in the array
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$products[] = $row;
	}
}

// Include header file
require '../admin/header.php';
?>
<div class="product-table">
	<h2 class="product-table__heading">User List</h2>
	<?php if ( isset( $products ) && ! empty( $products ) ) : ?>
		<table class="product-table__table" border="1" cellspacing="5" cellpadding="10">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Images</th>
					<th>Price</th>
					<th>Description</th>
					<th>Brand</th>
					<th>Operating System</th>
					<th>Mobile Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $count = 1; ?>
				<?php foreach ( $products as $product ) : ?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo htmlspecialchars( $product['p_name'] ); ?></td>
						<td><img src="<?php echo htmlspecialchars( $product['p_images'] ); ?>" alt="product_image" height="80px" width="80px"></td>
						<td><?php echo htmlspecialchars( $product['p_price'] ); ?></td>
						<td><?php echo htmlspecialchars( $product['p_description'] ); ?></td>
						<td><?php echo htmlspecialchars( $product['p_brand'] ); ?></td>
						<td><?php echo htmlspecialchars( $product['p_catOS'] ); ?></td>
						<td><?php echo htmlspecialchars( $product['p_cat-mobiletype'] ); ?></td>
						<td>
							<a href="../admin/update_products.php?id=<?php echo $product['p_id']; ?>" class="btn btn--update">Update</a>
							<button type="button" class="btn" onclick="confirmDelete(<?php echo $product['p_id']; ?>)">Delete Product</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p class="product-table__message">No users found.</p>
	<?php endif; ?>
</div>

<script>
	function confirmDelete(productID) {
		if (confirm("Are you sure you want to delete this product?")) {
			window.location.href = "../admin/delete_products.php?id="+ productID;
		} else {
			window.location.href = "../admin/view_products.php";
		}
	}
</script>
