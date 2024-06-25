<?php
session_start();

if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ../admin/index.php' );
	exit();
}
// Include database connection file
require '../dbconnect.php';

// Initialize variables
$errors    = array();
$uphotoerr = ' ';
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	// Validate and sanitize input.
	$product_name        = mysqli_real_escape_string( $connect, $_POST['product_name'] );
	$product_price       = floatval( $_POST['product_price'] );
	$product_description = mysqli_real_escape_string( $connect, $_POST['product_description'] );
	$brand_name          = $_POST['brand_name'];
	$category_type       = $_POST['cat-type'];
	$category_os         = $_POST['cat-os'];

	// Handling and the validation for the file.
	$pname     = $_FILES['product_image']['name'];
	$ptype     = $_FILES['product_image']['type'];
	$ptmp_name = $_FILES['product_image']['tmp_name'];
	$perror    = $_FILES['product_image']['error'];
	$psize     = $_FILES['product_image']['size'];
	// array of the allowed extension of the file(image).
	$allowed_ext = array(
		'jpg'  => 'image/jpg',
		'jpeg' => 'image/jpeg',
		'png'  => 'image/png',
	);
	// Folder to put the image into that.
	$folder = '../admin/assets/images/' . $pname;
	$ext    = pathinfo( $pname, PATHINFO_EXTENSION );
	// Valdation of file based on the below condition.
	if ( $_FILES['product_image']['error'] === UPLOAD_ERR_NO_FILE ) {
		$uphotoerr = 'Please upload image';
	} else {
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
			} else {
				$uphotoerr = 'Error in file Uploading file';
			}
		}
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
		$query  = "INSERT INTO products (`p_name`, `p_price`, `p_description`, `p_brand`, `p_cat-mobiletype`, `p_catOS`, p_images) 
                  VALUES ('$product_name', '$product_price', '$product_description', '$brand_name', '$category_type','$category_os', '$folder')";
		$result = mysqli_query( $connect, $query );

		if ( $result ) {
			echo '<script> 
				if(confirm("Product added successfully!")){ 
					window.location.href = "../admin/add_products.php"; // Redirect to add_product.php 
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
		<form action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" enctype="multipart/form-data" method="POST"  class="product-form__form">
			<div class="product-form__field">
				<label for="product_name" class="product-form__label">Product Name:</label>
				<input type="text" id="product_name" name="product_name" class="product-form__input" required>
			</div>
			<div class="product-form__field">
				<label for="product_name" class="product-form__label">Product Image:</label>
				<input type="file" id="product_image" name="product_image" class="product-form__input" required>
				<p class="errors"><?php echo $uphotoerr; ?></p>
			</div>
			<div class="product-form__field">
				<label for="product_price" class="product-form__label">Product Price:</label>
				<input type="number" id="product_price" name="product_price" class="product-form__input" min="0" step="0.01" required>
			</div>
			<div class="product-form__field">
				<label for="product_description" class="product-form__label">Product Description:</label>
				<textarea id="product_description" name="product_description" class="product-form__textarea" required></textarea>
			</div>
			<div class="product-form__field">
				<label for="brand_id" class="product-form__label">Brand:</label>
				<select id="brand_id" name="brand_name" class="product-form__select" required>
				<option  selected >Select</option>
					<?php
					// Fetch brands from the database
					$brand_query  = 'SELECT * FROM brands';
					$brand_result = mysqli_query( $connect, $brand_query );

					// Check if brands exist
					if ( mysqli_num_rows( $brand_result ) > 0 ) {
						// Loop through each brand to generate options
						while ( $row = mysqli_fetch_assoc( $brand_result ) ) {
							echo "<option value='" . $row['b_name'] . "'>" . $row['b_name'] . '</option>';
						}
					}
					?>
				</select>
			</div>
			<div class="product-form__field category">
				<label for="category_id" class="product-form__label">Category:</label>
				<select id="category_id" name="cat-type" class="product-form__select" required>
					<option  selected>Mobile Type</option>
					<?php
					// Fetch categories from the database
					$category_query  = 'SELECT * FROM category';
					$category_result = mysqli_query( $connect, $category_query );

					// Check if categories exist
					if ( mysqli_num_rows( $category_result ) > 0 ) {
						// Loop through each category to generate options
						while ( $row = mysqli_fetch_assoc( $category_result ) ) {
							echo "<option value='" . $row['cat_mobiletype'] . "'>" . $row['cat_mobiletype'] . '</option>';
						}
					}
					?>
				</select>
				<select id="category_id" name="cat-os" class="product-form__select" required>
					<option  selected>Operating System</option>
					<option value="iOS">iOS</option>
					<option value="android">Android</option>
				</select>
			</div>
			<button type="submit" name="add_product" class="product-form__submit">Add Product</button>
		</form>
	</div>
</body>
</html>
