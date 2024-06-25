<?php require './dbconnect.php'; ?>
<?php require './header.php'; ?>

<section class="cart__brands">
	<h1 class="cart__brands-heading heading"><span>Available Brands</span></h1>
	<div class="swiper cart__brands-slider">
		<div class="swiper-wrapper cart__brands-wrapper">
			<div class="swiper-slide cart__brand-box">
				<!-- <div class="hidden product" style="display: none;">Redmi</div> -->
				<div class="cart__brand-name">
					<h3>Redmi</h3>
				</div>
				<div class="cart__brand-image">
					<img src="./images/Xiaomi-logo.png" alt="brand-img" height="100px" width="150px">
				</div>
			</div>
			<div class="swiper-slide cart__brand-box">
				<div class="cart__brand-name">
					<h3>Iphone</h3>
				</div>
				<div class="cart__brand-image">
					<img src="./images/Apple_logo_grey.png" alt="brand-img" height="100px" width="150px">
				</div>
			</div>
			<div class="swiper-slide cart__brand-box">
				<div class="cart__brand-name">
					<h3>Realme</h3>
				</div>
				<div class="cart__brand-image">
					<img src="./images/Realme-Logo-Vector.png" alt="brand-img" height="100px" width="150px">
				</div>
			</div>
			<div class="swiper-slide cart__brand-box">
				<div class="cart__brand-name">
					<h3>Samsung</h3>
				</div>
				<div class="cart__brand-image">
					<img src="./images/samsung-logo-8A87EDFB33-seeklogo.com.png" alt="brand-img" height="100px" width="150px">
				</div>
			</div>
			<div class="swiper-slide cart__brand-box">
				<div class="cart__brand-name">
					<h3>One Plus</h3>
				</div>
				<div class="cart__brand-image">
					<img src="./images/OnePlus-Emblem.png" alt="brand-img" height="100px" width="150px">
				</div>
			</div>
		</div>
		<div class="swiper-pagination slide-change"></div>
		<div class="swiper-button-next"></div>
		<div class="swiper-button-prev"></div>
	</div>

	<script>
				// JavaScript to handle click event on product box
				document.addEventListener('DOMContentLoaded', function () {
					const brandBoxes = document.querySelectorAll('.cart__brand-box');
					const brandNames = document.querySelectorAll('.cart__brand-name h3');
					brandBoxes.forEach(function (box, index) {
						box.addEventListener('click', function () {
							const brandName = brandNames[index].innerText;
							console.log(brandName)
							window.location.href = './brands.php?bname='+brandName; 
						});
					});
				});
		</script>

</section>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<?php

if ( isset( $_GET['bname'] ) ) {
	$selectedBrand = $_GET['bname'];
	// Fetch products related to the selected brand from the database
	$query  = "SELECT * FROM products WHERE p_brand = '$selectedBrand'";
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
	echo '<div class="no-product">';
	echo '<p>Click on the Brands to show it Products.</p>';
	echo '</div>';
}
?>


<style>

	.cart__brands-wrapper {
		/* display: flex;
		flex-direction: column;
		gap: 1rem; */
		width: 140%;
	}

	.cart__brand-box {
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

	.cart__brand-name h3 {
		font-size: 2rem;
		font-weight: 700;
	}

	.no-product {
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
<?php require './footer.php'; ?>
