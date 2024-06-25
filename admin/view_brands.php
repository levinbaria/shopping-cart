<?php
// Start session
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'Location: ../admin/index.php' );
	exit();
}

// Include database connection file
require '../dbconnect.php';

// Fetch all users from the database
$query  = 'SELECT * FROM `brands`';
$result = mysqli_query( $connect, $query );

// Check if users exist
if ( mysqli_num_rows( $result ) > 0 ) {
	// Initialize an empty array to store user data
	$brands = array();

	// Fetch user data and store it in the array
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$brands[] = $row;
	}
}

// Include header file
require '../admin/header.php';
?>
<div class="brand-table">
	<h2 class="brand-table__heading">User List</h2>
	<?php if ( isset( $brands ) && ! empty( $brands ) ) : ?>
		<table class="brand-table__table" border="1" cellspacing="5" cellpadding="10">
			<thead>
				<tr>
					<th>ID</th>
					<th>Brand Name</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $count = 1; ?>
				<?php foreach ( $brands as $brand ) : ?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo htmlspecialchars( $brand['b_name'] ); ?></td>
						<td>
							<a href="../admin/update_brands.php?id=<?php echo $brand['ID']; ?>" class="btn btn--update">Update</a>
							<button type="button" class="btn" onclick="confirmDelete(<?php echo $brand['ID']; ?>)">Delete Brand</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p class="brand-table__message">No brands found.</p>
	<?php endif; ?>
</div>

<script>
	function confirmDelete(brandID) {
		if (confirm("Are you sure you want to delete this brand?")) {
			window.location.href = "../admin/delete_brands.php?id="+ brandID;
		} else {
			window.location.href = "../admin/view_brands.php";
		}
	}
</script>
