<?php
// session_start();

require './dbconnect.php';
require './header.php';

?>

<!-- Section for Home -->
<section class="cart__home" id="home">
		<div class="cart__home-row">
			<div class="cart__home-content">
				<h3>upto 60% off</h3>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit fuga illum quisquam, non lorem 10</p>
				<button class="cart__shop-now btn">Shop Now</button>
			</div>
			<div class="swiper cart__home-book-slider">
				<div class="home-book-slider__wrapper swiper-wrapper wrapper">
					<a href="#" class="swiper-slide"><img src="./images/gettyimages-1166119245-612x612.jpg" alt=""></a>
					<a href="#" class="swiper-slide"><img src="./images/gettyimages-1190447864-612x612.jpg" alt=""></a>
					<a href="#" class="swiper-slide"><img src="./images/gettyimages-1234934343-612x612.jpg" alt=""></a>
					<a href="#" class="swiper-slide"><img src="./images/gettyimages-1242435604-612x612.jpg" alt=""></a>
					<a href="#" class="swiper-slide"><img src="./images/gettyimages-1421721189-612x612.jpg" alt=""></a>
					<a href="#" class="swiper-slide"><img src="./images/gettyimages-1428710193-612x612.jpg" alt=""></a>
				</div>
				<!-- <img src="./images/xiaomi-redmi-10-2.jpg" class="stand" alt=""> -->
				<div class="swiper-pagination slide-change"></div>
			</div>
		</div>
	</section>

	<!-- Icon section starts -->
	<section class="cart__quality">
		<div class="cart__quality-icons">
			<i class="fas fa-plane"></i>
			<div class="cart__icons-info">
				<h3>Free Shipping</h3>
				<p>Order over 499</p>
			</div>
		</div>

		<div class="cart__quality-icons">
			<i class="fas fa-lock"></i>
			<div class="cart__icons-info">
				<h3>Secure Payments</h3>
				<p>100% secure payments</p>
			</div>
		</div>


		<div class="cart__quality-icons">
			<i class="fas fa-redo-alt"></i>
			<div class="cart__icons-info">
				<h3>Easy Returns</h3>
				<p>10 Days Reurns</p>
			</div>
		</div>

		<div class="cart__quality-icons">
			<i class="fas fa-headset"></i>
			<div class="cart__icons-info">
				<h3>24/7 Support</h3>
				<p>Contact Anytime</p>
			</div>
		</div>
	</section>
	<!-- 	Icon section ends -->

	<!-- Featured section -->
	<section class="cart__products" id="products">
		<h1 class="cart__products-heading heading"><span>Available Products</span></h1>
		<div class="swiper cart__products-slider">
			<?php
				// Query to fetch products from the database
				$query  = 'SELECT * FROM products LIMIT 8';
				$result = mysqli_query( $connect, $query );

			if ( $result ) {
				// Check if there are any products fetched
				if ( mysqli_num_rows( $result ) > 0 ) {
					echo '<div class="swiper-wrapper wrapper">';
					// Loop through each product
					while ( $data = mysqli_fetch_assoc( $result ) ) {
						echo '<div class="swiper-slide cart__wrapper-box">';
						echo '<div class="cart__wrapper-icons">';
						// echo '<a href="#" class="fas fa-search"></a>';
						echo '<button class="fas fa-heart"></button>';
						// echo '<a href="#" class="fas fa-eye"></a>';
						echo '</div>';
						echo '<div class="hidden product_id" style="display:none">' . $data['p_id'] . '</div>';
						echo '<div class="cart__wrapper-image">';
						echo '<img src="./admin/assets/images/' . basename( $data['p_images'] ) . '" alt="' . $data['p_name'] . '" style="cursor:pointer;">';
						echo '</div>';
						echo '<div class="cart__wrapper-content">';
						echo '<h3>' . $data['p_name'] . '</h3>';
						echo '<div class="cart__wrapper-price">Rs.<span>' . $data['p_price'] . '</span></div>';
						echo '<div class="cart__wrapper-product-summary">';
						echo '<button class="cart__add-cart btn">Add to cart</button>';
						echo '</div>';
						echo '</div>';
						echo '</div>';
					}
					echo '</div>';

				} else {
					echo '<p>No products found.</p>';
				}
			} else {
				echo '<p>Error fetching products: ' . mysqli_error( $connect ) . '</p>';
			}
				// Close the database connection
				mysqli_close( $connect );
			?>
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		<a href="./all_products.php" style="text-decoration: none; color:red; font-size: 1.5rem; margin-left:auto">View All</a>
		<script>
				// JavaScript to handle click event on product box
				document.addEventListener('DOMContentLoaded', function () {
					const productBoxes = document.querySelectorAll('.cart__wrapper-image');
					const productIDs = document.querySelectorAll('.product_id');
					productBoxes.forEach(function (box, index) {
						box.addEventListener('click', function () {
							const productId = productIDs[index].innerText;
							window.location.href = './product.php?id='+productId; 
						});
					});
				});
		</script>

	</section>
	<!-- Featured section ends -->

	<!-- Arrival Section starts -->

	<section class="cart__arrivals" id="cart__arrivals">
		<h3 class="cart__arrivals-heading heading"><span>New Arrivals</span></h3>
		<div class="swiper cart__arrivals-slider">
			<div class="swiper-wrapper cart__arrivals-wrapper">
				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/iphone14.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>Apple iPhone 14</h3>
						<div class="cart__arrivals-price">Rs.62500</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/iphone14Plus.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>Apple iPhone 14 Plus</h3>
						<div class="cart__arrivals-price">Rs.100200</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>
				
				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/iphone15promax.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>iPhone 15 Pro Max</h3>
						<div class="cart__arrivals-price">Rs.150000</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/oneplusnord2T.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>OnePlus Nord 2T 5G </h3>
						<div class="cart__arrivals-price">Rs.33999</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/ONEPLUS2R.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>OnePlus 12R</h3>
						<div class="cart__arrivals-price">Rs.42999</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

			</div>
		</div>

		<div class="swiper cart__arrivals-slider">
			<div class="swiper-wrapper cart__arrivals-wrapper">
				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/IQOO.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>iQOO Neo9 Pro 5G</h3>
						<div class="cart__arrivals-price">Rs.34999</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/redmi13proplus.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>Redmi Note 13 Pro+</h3>
						<div class="cart__arrivals-price">Rs.31999</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>
				
				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/realme12pro.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>realme 12 Pro 5G</h3>
						<div class="cart__arrivals-price">Rs.24990</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/realme10.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>Realme 10</h3>
						<div class="cart__arrivals-price">Rs.15489</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

				<a href="#" class="swiper-slide cart__arrivals-box">
					<div class="cart__arrivals-image">
						<img src="./images/realme11.jpg" alt="product-image">
					</div>
					<div class="cart__arrivals-content">
						<h3>Realme 11 5G</h3>
						<div class="cart__arrivals-price">Rs.15489</div>
						<div class="cart__arrivals-stars">
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star"></i>
							<i class="fa-solid fa-star-half-alt"></i>
						</div>
					</div>
				</a>

			</div>
		</div>
	</section>

	<!-- Arrival section ends -->

	<!-- Deal Section starts -->

	<section class="cart__deal">
		<div class="cart__deal-content">
			<h3>Deal fo the Day</h3>
			<h1>Upto 60% off</h1>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit est earum pariatur asperiores amet labore quis sapiente porro perferendis ad!</p>
			<a href="#" class="cart__shop-now btn">Shop Now</a>
		</div>
		<div class="cart__deal-image">
			<img src="./images/OIP (1).jfif" alt="product-image">
		</div>
	</section>
	<!-- Deal Section Ends -->

		<!-- NewsLetter starts -->
	<section class="cart__newsletter">
		<form action="">
			<h3>Subscribe for the latest updates</h3>
			<input type="email" name="newsletter__email" placeholder="Enter your email" class="cart__newsletter-email">
			<input type="submit" value="subscribe" class="newsletter__btn">
		</form>
	</section>
	<!-- Newsletter ends -->
	 
	

	<!-- loader starts -->
	<div class="cart__loader">
		<img src="./images/WoZMYyosBw.gif" alt="loader" height="150px" width="150px">
	</div>
	<!-- Loader ends -->

	<!-- External JS file -->
	<script src="./js/index.js" defer></script>
	
<!-- Footer file -->
<?php
require './footer.php';
?>
