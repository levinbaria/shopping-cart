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
$query  = 'SELECT * FROM `customer`';
$result = mysqli_query( $connect, $query );

// Check if users exist
if ( mysqli_num_rows( $result ) > 0 ) {
	// Initialize an empty array to store user data
	$users = array();

	// Fetch user data and store it in the array
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$users[] = $row;
	}
}

// Include header file
require '../admin/header.php';
?>
<div class="user-table">
	<h2 class="user-table__heading">User List</h2>
	<?php if ( isset( $users ) && ! empty( $users ) ) : ?>
		<table class="user-table__table" border="1" cellspacing="5" cellpadding="10">
			<thead>
				<tr>
					<th>ID</th>
					<th>Email</th>
					<th>Username</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php $count = 1; ?>
				<?php foreach ( $users as $user ) : ?>
					<tr>
						<td><?php echo $count++; ?></td>
						<td><?php echo htmlspecialchars( $user['cemail'] ); ?></td>
						<td><?php echo htmlspecialchars( $user['cname'] ); ?></td>
						<td>
							<a href="../admin/update_user.php?id=<?php echo $user['ID']; ?>" class="btn btn--update">Update</a>
							<button type="button" class="btn" onclick="confirmDelete(<?php echo $user['ID']; ?>)">Delete User</button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<p class="user-table__message">No users found.</p>
	<?php endif; ?>
</div>

<script>
	function confirmDelete(userID) {
		if (confirm("Are you sure you want to delete this user?")) {
			window.location.href = "../admin/delete_user.php?id="+ userID;
		} else {
			window.location.href = "../admin/view_user.php";
		}
	}
</script>
