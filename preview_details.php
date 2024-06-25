<?php
require './dbconnect.php';
require './header.php';
// Condition to check if the user is logged in or not
if ( ! isset( $_SESSION['login'] ) || $_SESSION['login'] !== true ) {
	header( 'location: ./login.php' );
	exit();
}

// Initialize variables
$errors = array();
$name   = $pnumber = $zipcode = '';
// validating the form for the checkout details and if there is no error store the data into the database and head to the users order page
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	$name       = $_POST['name'];
	$pnumber    = $_POST['pnumber'];
	$address    = $_POST['address'];
	$zipcode    = $_POST['zipcode'];
	$totalPrice = $_POST['totalPrice'];
	$cartItems  = json_decode( $_POST['cartItems'], true );

	if ( empty( $cartItems ) ) {
		$errors[] = 'Your cart is empty. Please add items to proceed.';
	}

	if ( empty( $name ) ) {
		$errors[] = 'Name Required';
	} elseif ( strlen( $name ) < 3 ) {
		$errors[] = 'Minimum 3 charcters required';
	} else {
		$name = test_input( $name );
		if ( ! preg_match( '/^[a-zA-Z]+(?:\s+[a-zA-Z]+)*(?:\s+[a-zA-Z]\.)?$/', $name ) ) {
			$errors[] = 'Invalid name format. Please enter a valid name.';
		}
	}

	if ( empty( $pnumber ) ) {
		$errors[] = 'Phone Number Required';
	} elseif ( strlen( (string) $pnumber ) !== 10 ) {
		$errors[] = 'Phone no. should be 10 digit';
	} else {
		$pnumber = test_input( $pnumber );
	}

	if ( empty( $zipcode ) ) {
		$errors[] = 'Pin Code Required';
	} elseif ( strlen( (string) $zipcode ) !== 6 ) {
		$errors[] = 'Pin code should be 6 digit';
	} else {
		$pnumber = test_input( $pnumber );
	}

	if ( empty( $address ) ) {
		$errors[] = 'Address Required';
	} else {
		$address = test_input( $address );
	}

	if ( empty( $errors ) ) {
		$p_names           = array();
		$order_total_items = 0;
		foreach ( $cartItems as $item ) {
			$p_names[]          = $item['name'] . '(' . $item['quantity'] . ')';
			$order_total_items += $item['quantity'];
		}

		$p_names      = implode( ',', $p_names );
		$order_status = 'Order Paced';

		$sql    = "INSERT INTO `orders` (`cust_id`, `cust_address`, `cust_zipcode`, `p_name`, `o_amount`, `o_items`, `o_status`) VALUES ('$userID','$address', '$zipcode', '$p_names', '$totalPrice', '$order_total_items', '$order_status')";
		$result = mysqli_query( $connect, $sql );
		if ( $result ) {
			echo '<script> 
				if(confirm("Your Order Placed")){
                    // Clear cart items from local storage
                    localStorage.removeItem("cartItems_' . $_SESSION['id'] . '");
                    // Remove cart items from DOM
                    document.querySelector(".add-to-cart__list-items").innerHTML = "";
					window.location.href = "./my_orders.php?id=' . $userID . '";
				} else { 
					window.location.href = "./preview_details.php";
				} 
				</script>';
			exit();
		} else {
			echo 'Error while Checkout';
		}
	}
}
function test_input( $data ) {
	$data = trim( $data );
	$data = stripslashes( $data );
	$data = htmlspecialchars( $data );
	return $data;
}
?>
	<!-- Html part for the showing the items that user buys and the form for entering extra details -->
	<section class="product__checkout">
		<div class="product__wrapper">
			<div class="product__heading">
				<h2>Shopping Items</h2>
			</div>
			<div class="product__hero-details">
			</div>
			<?php if ( count( $errors ) > 0 ) : ?>
				<div class="errors">
					<ul>
						<?php foreach ( $errors as $error ) : ?>
							<li style="color: red; margin-left: 1rem;"><?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
			<form method="post" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>">
				<div class="product__user-information">
					<h3>Enter your Shipping details</h3>
					<input type="text" name="name"  class="user-name" placeholder="Enter Full Name" value="<?php echo $name; ?>">
					<input type="number" name="pnumber"  class="user-number" placeholder="Enter Phone Number" value="<?php echo $pnumber; ?>">
					<input type="number" name="zipcode"  class="user-zipcode" placeholder="Enter Pin Code" value="<?php echo $zipcode; ?>">
					<textarea type="text" name="address"  class="address" placeholder="Enter Address"></textarea>
					<input type="hidden" name="cartItems" id="cartItemsInput">
				</div>
				<div class="product__checkout-price">
					<p>Total Checkout Price: <span name="totalPrice">Rs. 0</span></p>
					<input type="hidden" name="totalPrice" id="totalPriceInput">
				</div>
				<div class="product__checkout-btn">
					<a href="./index.php" class="back-to-home">Home</a>
					<button type="submit" class="continue-shopping">Proceed to Checkout</button>
					<!-- <a href="./checkout.php" class="continue-shopping">Proceed to Checkout</a> -->
				</div>
			</form>
		</div>
	</section>
