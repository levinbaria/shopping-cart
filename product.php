<?php
require './dbconnect.php';

// if(!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
// header('location: ./index.php');
// }
// Condition to check is id is attached with the clicked product
if ( ! isset( $_GET['id'] ) || empty( $_GET['id'] ) ) {
	header( 'location: ./index.php' );
}

$productID = mysqli_real_escape_string( $connect, $_GET['id'] );
// Query to get the all products that have that respective product id
$product_query = "SELECT * FROM products WHERE `p_id`=$productID";
$result        = mysqli_query( $connect, $product_query );

if ( mysqli_num_rows( $result ) > 0 ) {
	$product = mysqli_fetch_assoc( $result );

} else {
	header( 'location: ./index.php' );
	exit();
}

?>
<?php require './header.php'; ?>
<!-- HTML part to show that particular product -->
<section class="product">
	<div class="product__photo">
		<img src="./admin/assets/images/<?php echo basename( $product['p_images'] ); ?>"  alt="<?php echo $product['p_name']; ?> "  height="100%" width="100%">
	</div>
	<div class="product-info">
		<div class="product-title">
			<h1><?php echo $product['p_name']; ?></h1>
			<span>COD: 6566</span>
		</div>
		<div class="product-price">
			Rs. <span><?php echo $product['p_price']; ?></span>
		</div>
		<div class="product-description">
			<h3>Mobile Description</h3>
			<p><?php echo $product['p_description']; ?></p>
		</div>
		<div class="product-button">
			<!-- <input type=button value="Buy Now" class="product__buy"> -->
			<input type=button value="Add to cart" class="product__cart">
		</div>
	</div>

</section>
<!-- Including the footer file -->
<?php require './footer.php'; ?>
