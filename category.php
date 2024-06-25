<?php require './dbconnect.php'; ?>
<?php require './header.php'; ?>

<section class="cart__category">
	<h1 class="cart__category-heading heading"><span>Available Category</span></h1>
		<div class="cart__category-wrapper">
			<div class="cart__category-box">
				<!-- <div class="hidden product" style="display: none;">Redmi</div> -->
				<div class="cart__category-name">
					<h3>Android</h3>
				</div>
				<div class="cart__category-image">
					<img src="./images/icons8-android-logo-100.png" alt="brand-img" height="100px" width="100px">
				</div>
			</div>
			<div class="cart__category-box">
				<div class="cart__category-name">
					<h3>iOS</h3>
				</div>
				<div class="cart__category-image">
					<img src="./images/icons8-ios-logo-96.png" alt="brand-img" height="100px" width="100px">
				</div>
			</div>
		</div>
	<script>
				// JavaScript to handle click event on product box
				document.addEventListener('DOMContentLoaded', function () {
					const categoryBoxes = document.querySelectorAll('.cart__category-box');
					const categoryNames = document.querySelectorAll('.cart__category-name h3');
					categoryBoxes.forEach(function (box, index) {
						box.addEventListener('click', function () {
							const categoryName = categoryNames[index].innerText;
							window.location.href = './category.php?cname='+categoryName; 
						});
					});
				});
		</script>

</section>

<?php
if ( isset( $_GET['cname'] ) ) {
	$selected_category = $_GET['cname'];
	// Fetch products related to the selected brand from the database
	$query  = "SELECT * FROM products WHERE p_catOS = '$selected_category'";
	$result = mysqli_query( $connect, $query );
	if ( $result ) {
		echo '<section class="cart__all-products" id="products">';
		if ( mysqli_num_rows( $result ) > 0 ) {
			echo '<div class="cart__wrapper">';
			while ( $data = mysqli_fetch_assoc( $result ) ) {
				echo '
						<div class="cart__hero-product-box">
							<div class="cart__wrapper-icons">
								<button class="fas fa-heart"></button>
							</div>
							<div class="hidden product_id" style="display:none">' . $data['p_id'] . '</div>
							<div class="cart__wrapper-image">
								<img src="./admin/assets/images/' . basename( $data['p_images'] ) . '" alt="' . $data['p_name'] . '">
							</div>
							<div class="cart__wrapper-content">
								<h3>' . $data['p_name'] . '</h3>
								<div class="cart__wrapper-price">
									Rs.<span>' . $data['p_price'] . '</span>
								</div>
								<div class="cart__wrapper-summary">
									<button class="cart__add-cart">Add to cart</button>
								</div>
							</div>
						</div>';
			}
			echo '</div>';
		} else {
				echo '<p>No products found.</p>';
		}
		echo '	<script>
			// JavaScript to handle click event on product box
			document.addEventListener("DOMContentLoaded", function () {
				const productBoxes = document.querySelectorAll(".cart__wrapper-image");
				const productIDs = document.querySelectorAll(".product_id");
				productBoxes.forEach(function (box, index) {
					box.addEventListener("click", function () {
						const productId = productIDs[index].innerText;
						window.location.href = "./product.php?id="+productId; 
					});
				});
			});	
	</script>';
		echo '</section>';
	} else {
			echo 'Error: ' . mysqli_error( $connect );
	}
	mysqli_close( $connect );
} else {
	// User is not logged in, show login form
	echo '<div class="no-category">';
	echo '<p>Click on the Category to show it Products.</p>';
	echo '</div>';
}
?>


<style>

	.cart__category-wrapper {
		display: flex;
		flex-direction: row;
		align-items: center;
		justify-content: center;
		width: 100%;
	}

	.cart__category-box {
		display: flex;
		flex-direction: column;
		align-items: center;
		/* justify-content: center; */
		border: 2px solid lightgray;
		/* width: 100%; */
		padding: 10px 16px;
		margin: 1rem auto;
		border-radius: 12px;
		box-shadow: 5px 5px 10px 5px lightgray;
		gap: 1.5rems;
		cursor: pointer;
	}

	.cart__category-name h3 {
		font-size: 2rem;
		font-weight: 700;
	}

	.no-category {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
		margin: 2rem auto;
		padding: 1.5rem 1.5rem;
		background-color: white;
		box-shadow: 5px 5px 10px 5px lightgray;
		border: 2px solid black;
		font-size: 1.5rem;
		max-width: 550px;
		width: 80%;
	}

	

</style>
