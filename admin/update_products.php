<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
}

require '../dbconnect.php';

if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ../admin/view_products.php' );
}

$productID = mysqli_real_escape_string( $connect, $_GET['id'] );
$query     = "SELECT * FROM `products` WHERE `p_id` = '$productID'";
$result    = mysqli_query( $connect, $query );
if ( mysqli_num_rows( $result ) == 1 ) {
	$product = mysqli_fetch_assoc( $result );
} else {
	header( 'location: ../admin/view_products.php' );
	exit();
}
// Initialize variables
$errors    = array();
$uphotoerr = '';
// Update user details in the database
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	// Handle form submission to update user details
	// Retrieve form data
	$product_name        = mysqli_real_escape_string( $connect, $_POST['product_name'] );
	$product_price       = floatval( $_POST['product_price'] );
	$product_description = mysqli_real_escape_string( $connect, $_POST['product_description'] );
	$brand_name          = $_POST['brand_name'];
	$category_type       = $_POST['cat-type'];
	$category_os         = $_POST['cat-os'];
	$pimage_old          = $_POST['pimage_old'];
	$pimage_new          = $_FILES['product_new-image']['name'];


	if ( ! empty( $pimage_new ) ) {
		$ptype       = $_FILES['product_new-image']['type'];
		$ptmp_name   = $_FILES['product_new-image']['tmp_name'];
		$perror      = $_FILES['product_new-image']['error'];
		$psize       = $_FILES['product_new-image']['size'];
		$allowed_ext = array(
			'jpg'  => 'image/jpg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
		);
		$folder      = '../admin/assets/images/' . $pimage_new;
		$ext         = pathinfo( $pimage_new, PATHINFO_EXTENSION );
		if ( ! array_key_exists( $ext, $allowed_ext ) ) {
			$uphotoerr = 'Invalid image format';
		}
		$maxsize = 5 * 1024 * 1024;
		if ( $psize > $maxsize ) {
			$uphotoerr = 'image size more than 3mb';
		}
		if ( in_array( $ptype, $allowed_ext ) ) {
			if ( file_exists( $folder ) ) {
				$uphotoerr = '';
			} elseif ( move_uploaded_file( $ptmp_name, $folder ) ) {
					$uphotoerr = '';
					unlink( $pimage_old );
			} else {
				$uphotoerr = 'Error in file Uploading file';
			}
		}
	} else {
		$folder    = $pimage_old;
		$uphotoerr = '';
	}


	// Validate product name
	if ( empty( $product_name ) ) {
		$errors[] = 'Product name is required.';
	}

	// Validate product price
	if ( $product_price <= 0 ) {
		$errors[] = 'Product price must be greater than zero.';
	}

	// Validate product description
	if ( empty( $product_description ) ) {
		$errors[] = 'Product description is required.';
	}
	// Validate brand name
	if ( ( $brand_name == 'Select' ) ) {
		$errors[] = 'Please choose relevant brand.';
	}

	// Validate type
	if ( $category_type == 'Mobile Type' ) {
		$errors[] = 'Please choose relevant Type.';
	}

	// Validate OS
	if ( $category_os == 'Operating System' ) {
		$errors[] = 'Please choose relevant OS.';
	}

	// Check if there are no validation errors
	if ( empty( $errors ) && empty( $uphotoerr ) ) {
		// Insert data into the database
		$query  = "UPDATE `products` SET `p_name`= '$product_name', `p_price`='$product_price', `p_description`='$product_description', `p_brand`='$brand_name', `p_cat-mobiletype`='$category_type ', `p_catOS`='$category_os', `p_images`='$folder' WHERE `p_id`='$productID'";
		$result = mysqli_query( $connect, $query );
		if ( $result ) {
			echo '<script> 
				if(confirm("Product updated successfully!")){ 
					window.location.href = "../admin/view_products.php"; // Redirect to view_product.php 
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



<?php require '../admin/header.php'; ?>
	<div class="product-form">
		<h2 class="product-form__heading">Add Product</h2>
		<?php if ( count( $errors ) > 0 ) : ?>
			<div class="errors">
				<?php foreach ( $errors as $error ) : ?>
					<p class="add-user__error"><?php echo $error; ?></p>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] . '?id=' . urlencode( $productID ) ); ?>" enctype="multipart/form-data" method="POST"  class="product-form__form">
			<div class="product-form__field">
				<label for="product_name" class="product-form__label">Product Name:</label>
				<input type="text" id="product_name" name="product_name" class="product-form__input" required value="<?php echo $product['p_name']; ?>">
			</div>
			<div class="product-form__field">
				<label for="product_name" class="product-form__label">Product Image:</label>
				<input type="file" id="product_image" name="product_new-image" class="product-form__input">
				<input type="hidden" name="pimage_old" value="<?php echo $product['p_images']; ?>">
				<p class="errors"><?php echo $uphotoerr; ?></p>
			</div>
			<div class="product-form__field">
				<label for="product_price" class="product-form__label">Product Price:</label>
				<input type="number" id="product_price" name="product_price" class="product-form__input" min="0" step="0.01" required value="<?php echo $product['p_price']; ?>">
			</div>
			<div class="product-form__field">
				<label for="product_description" class="product-form__label">Product Description:</label>
				<textarea id="product_description" name="product_description" class="product-form__textarea" required><?php echo $product['p_description']; ?></textarea>
			</div>
			<div class="product-form__field">
				<label for="brand_id" class="product-form__label">Brand:</label>
				<select id="brand_id" name="brand_name" class="product-form__select" required>
					<?php
					// Fetch brands from the database
					$brand_query  = 'SELECT * FROM brands';
					$brand_result = mysqli_query( $connect, $brand_query );

					// Check if brands exist
					if ( mysqli_num_rows( $brand_result ) > 0 ) {
						// Loop through each brand to generate options
						while ( $row = mysqli_fetch_assoc( $brand_result ) ) {
							$selected = ( $row['b_name'] === $product['p_brand'] ) ? 'selected' : '';
							echo "<option value='" . $row['b_name'] . "'$selected>" . $row['b_name'] . '</option>';
						}
					}
					?>
				</select>
			</div>
			<div class="product-form__field category">
				<label for="category_id" class="product-form__label">Category:</label>
				<select id="category_id" name="cat-type" class="product-form__select" required >
					<?php
					// Fetch categories from the database
					$category_query  = 'SELECT DISTINCT `cat_mobiletype` FROM category';
					$category_result = mysqli_query( $connect, $category_query );

					// Check if categories exist
					if ( mysqli_num_rows( $category_result ) > 0 ) {
						// Loop through each category to generate options
						while ( $row = mysqli_fetch_assoc( $category_result ) ) {
							$selected = ( $row['cat_mobiletype'] === $product['p_cat-mobiletype'] ) ? 'selected' : '';
							echo "<option value='" . $row['cat_mobiletype'] . "'$selected>" . $row['cat_mobiletype'] . '</option>';
						} b
					}
					?>
				</select>
				<select id="category_id" name="cat-os" class="product-form__select" required>
					<?php
						$os_query  = 'SELECT DISTINCT `cat_OS` FROM category';
						$os_result = mysqli_query( $connect, $os_query );

					if ( mysqli_num_rows( $os_result ) > 0 ) {
						while ( $row = mysqli_fetch_assoc( $os_result ) ) {
							$selected = ( $row['cat_OS'] == $product['p_catOS'] ) ? 'selected' : '';
							echo '<option value="' . $row['cat_OS'] . '" ' . $selected . '>' . $row['cat_OS'] . '</option>';
						}
					}
					?>
				</select>
			</div>
			<button type="submit" name="add_product" class="product-form__submit">Update Product</button>
		</form>
	</div>
</body>
</html>
