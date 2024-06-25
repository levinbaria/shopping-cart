<?php

require './dbconnect.php';

?>

<?php require './header.php'; ?>
<section class="cart__all-products" id='products'>
	<h1 class="cart__products-heading heading"><span>Available Products</span></h1>
	<?php
		$query  = 'SELECT * FROM products';
		$result = mysqli_query( $connect, $query );

	if ( $result ) {
		// Check if there are any products fetched
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
	} else {
		echo '<p>Error fetching products: ' . mysqli_error( $connect ) . '</p>';
	}

	mysqli_close( $connect );
	?>
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
	<script src="./js/index.js" defer></script>
<?php
require './footer.php';
?>
