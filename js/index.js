window.onscroll = () => {
	if (window.scrollY > 80) {
		document.querySelector('.cart__header .cart__nav-2').classList.add('active');
	} else {
		document.querySelector('.cart__header .cart__nav-2').classList.remove('active');
	}
}

window.onload = () => {
	if (window.scrollY > 80) {
		document.querySelector('.cart__header .cart__nav-2').classList.add('active');
	} else {
		document.querySelector('.cart__header .cart__nav-2').classList.remove('active');
	}

	fadeOut();
}

function loader() {
	document.querySelector('.cart__loader').classList.add('active__loader');
}

function fadeOut() {
	setTimeout(loader, 1500);
}


document.addEventListener('DOMContentLoaded', function () {
	const userId = document.querySelector('.user-id').innerText;
	const cartList = document.querySelector('.add-to-cart__list-items');
	const cartItemsSpan = document.querySelector('.cart__items');
	console.log(userId);

	const cartMenuIcon = document.querySelector('.cart__menu-icon');
	cartMenuIcon.addEventListener('click', () => {
		document.querySelector('.cart__main-nav').classList.toggle('menu-active');
		document.getElementById('search-box').classList.toggle('menu-active');
	});

	if (userId !== null && userId !== '') {
		mergeCartItems(userId);
	}
	function mergeCartItems(userId) {
		const temporaryCartItemsKey = `cartItems_`;
		const userCartItemsKey = `cartItems_${userId}`;

		// Retrieve temporary cart items from local storage
		const temporaryCartItems = JSON.parse(localStorage.getItem(temporaryCartItemsKey)) || [];

		// Retrieve user's cart items from local storage
		const userCartItems = JSON.parse(localStorage.getItem(userCartItemsKey)) || [];

		// Merge temporary cart items with user's cart items
		const mergedCartItems = [...temporaryCartItems];
		userCartItems.forEach(userCartItem => {
			const existingItemIndex = mergedCartItems.findIndex(item => item.name === userCartItem.name);
			if (existingItemIndex !== -1) {
				// If item already exists, update its quantity
				mergedCartItems[existingItemIndex].quantity += userCartItem.quantity;
			} else {
				// If item doesn't exist, add it to the merged items list
				mergedCartItems.push(userCartItem);
			}
		});

		// Update user's cart items in local storage with merged data
		localStorage.setItem(userCartItemsKey, JSON.stringify(mergedCartItems));

		// Clear temporary cart items from local storage
		localStorage.removeItem(temporaryCartItemsKey);
	}


	const close = document.querySelector('.fa-close');
	const CartDetails = document.querySelector('.add-to-cart');
	const shoppingBag = document.querySelector('.fa-bag-shopping');
	const removeAllButton = document.querySelector('.removeall');
	const productList = document.querySelectorAll('.cart__wrapper-box');
	const productList1 = document.querySelectorAll('.cart__hero-product-box');
	shoppingBag.addEventListener('click', () => {
		CartDetails.classList.add('active-cart');
	});

	close.addEventListener('click', () => {
		CartDetails.classList.remove('active-cart');
	});

	// Function to update the cart items count
	function updateCartItemCount() {
		const itemCount = cartList.children.length;
		cartItemsSpan.textContent = itemCount;
	}


	// Function to add event listeners to product list
	function addEventListenersToProductList(productList) {
		productList.forEach(product => {
			const addToCartButton = product.querySelector('.cart__add-cart');
			const productName = product.querySelector('h3').innerText;
			const productPrice = product.querySelector('.cart__wrapper-price span').innerText;

			addToCartButton.addEventListener('click', () => {
				addToCart(productName, productPrice);
			});
		});
	}

	addEventListenersToProductList(productList);
	addEventListenersToProductList(productList1);


	function addToCart(name, price) {
		const cartList = document.querySelector('.add-to-cart__list-items');
		const existingItem = Array.from(cartList.children).find(item => {
			const itemName = item.querySelector('p:first-child').innerText;
			return itemName === name;
		});

		if (existingItem) {
			const quantityInput = existingItem.querySelector('input[type="number"]');
			quantityInput.value = parseInt(quantityInput.value) + 1;
		} else {
			const listItem = document.createElement('div');
			listItem.classList.add('add-to-cart__cart-items');
			listItem.innerHTML = `
			<div>
				<p>${name}</p>
				<p>Rs.<span>${price}</span></p>
			</div>
			<div>
			<input type="number" value=1>
			<i class="fa-solid fa-trash" style="cursor:pointer"></i>
			</div>
			`;
			cartList.appendChild(listItem);
			updateCartItemCount();
		}
		// Save cart items to local storage
		saveCartItems();
	}

	const productInfo = document.querySelectorAll('.product');
	function addEventListenersToProductList1(productInfo) {
		productInfo.forEach(product => {
			const addToCartButton = product.querySelector('.product__cart');
			const productName = product.querySelector('h1').innerText;
			const productPrice = product.querySelector('.product-price span').innerText;

			addToCartButton.addEventListener('click', () => {
				addToCart1(productName, productPrice);
			});
		});
	}
	addEventListenersToProductList1(productInfo);
	function addToCart1(name, price) {
		const cartList = document.querySelector('.add-to-cart__list-items');
		const existingItem = Array.from(cartList.children).find(item => {
			const itemName = item.querySelector('p:first-child').innerText;
			return itemName === name;
		});

		if (existingItem) {
			const quantityInput = existingItem.querySelector('input[type="number"]');
			quantityInput.value = parseInt(quantityInput.value) + 1;
		} else {
			const listItem = document.createElement('div');
			listItem.classList.add('add-to-cart__cart-items');
			listItem.innerHTML = `
                <div>
                    <p>${name}</p>
                    <p>Rs.<span>${price}</span></p>
                </div>
                <div>
                    <input type="number" value="1">
                    <i class="fa-solid fa-trash"></i>
                </div>
            `;
			cartList.appendChild(listItem);
			updateCartItemCount();
		}
		saveCartItems();
	}

	// Function to load cart items from local storage
	function loadCartItems() {
		const cartItems = JSON.parse(localStorage.getItem(`cartItems_${userId}`));
		if (cartItems) {
			cartItems.forEach(item => {
				const listItem = document.createElement('div');
				listItem.classList.add('add-to-cart__cart-items');
				listItem.innerHTML = `
					<div>
						<p>${item.name}</p>
						<p>${item.price}</p>
					</div>
					<div>
						<input type="number" value="${item.quantity}" data-item-name="${item.name}">
						<i class="fa-solid fa-trash"></i>
					</div>
				`;
				cartList.appendChild(listItem);

			});
			updateCartItemCount();
		}

	}

	loadCartItems();

	function saveCartItems() {
		const items = Array.from(cartList.children).map(item => {
			return {
				name: item.querySelector('p:first-child').innerText,
				price: item.querySelector('p:nth-child(2)').innerText,
				quantity: parseInt(item.querySelector('input[type="number"]').value)
			};
		});
		localStorage.setItem(`cartItems_${userId}`, JSON.stringify(items));
	}
	// Event listener for delete buttons
	document.addEventListener('click', event => {
		if (event.target.classList.contains('fa-trash')) {
			const item = event.target.closest('.add-to-cart__cart-items');
			item.remove();
			updateCartItemCount();
			saveCartItems();
		}
	});

	// Event listener for quantity input change
	cartList.addEventListener('change', event => {
		if (event.target.tagName === 'INPUT') {
			const itemName = event.target.dataset.itemName;
			const item = Array.from(cartList.children).find(child => {
				const name = child.querySelector('p:first-child').innerText;
				return name === itemName;
			});
			if (item) {
				const quantity = parseInt(event.target.value);
				if (!isNaN(quantity) && quantity >= 0) {
					updateCartItemQuantity(item, quantity);
					saveCartItems();
				}
			}
		}
	});

	const cartList1 = document.querySelector('.product__hero-details');
	cartList1.addEventListener('change', event => {
		if (event.target.tagName === 'INPUT') {
			const itemName = event.target.dataset.itemName;
			const item = Array.from(cartList1.children).find(child => {
				const name = child.querySelector('.cart-item__name p:first-child').innerText;
				return name === itemName;
			});
			if (item) {
				const quantity = parseInt(event.target.value);
				if (!isNaN(quantity) && quantity >= 0) {
					updateCartItemQuantity(item, quantity);
					saveCartItems();
				}
			}
		}
	});

	// Function to update cart item quantity
	function updateCartItemQuantity(item, quantity) {
		const quantityInput = item.querySelector('input[type="number"]');
		quantityInput.value = quantity;

		saveCartItems();
		// Update quantity in local storage
		// const itemName = item.querySelector('.cart-item__name p').innerText;
		// const cartItems = JSON.parse(localStorage.getItem('cartItems'));
		// const updatedCartItems = cartItems.map(cartItem => {
		// 	if (cartItem.name === itemName) {
		// 		return { ...cartItem, quantity: quantity };
		// 	} else {
		// 		return cartItem;
		// 	}
		// });
		// localStorage.setItem('cartItems', JSON.stringify(updatedCartItems));

		const pricePerItem = parseInt(item.querySelector('.cart-item__price').innerText.replace('Rs.', ''));
		const totalPriceElement = item.querySelector('.cart-item__total-price p:last-child');
		const totalPrice = pricePerItem * quantity;
		totalPriceElement.innerText = `Rs.${totalPrice.toFixed(2)}`;
	}




	// Retrieve data from local storage
	const cartItems = JSON.parse(localStorage.getItem(`cartItems_${userId}`));

	// Reference the product__hero-details element
	const heroDetails = document.querySelector('.product__hero-details');

	// Check if there are cart items in local storage
	if (cartItems && cartItems.length > 0) {
		// Iterate over each cart item and create HTML elements to display them
		cartItems.forEach(item => {
			// Create a div to represent each cart item
			const cartItemDiv = document.createElement('div');
			cartItemDiv.classList.add('cart-item');

			// Add the item name and price to the cart item div
			cartItemDiv.innerHTML = `
			<div class="cart-item__name">
				<p>${item.name}</p>
				<p class="cart-item__price">${item.price}</p>
			</div>
			<div class="cart-item__quantity">
			<p>Quantity:</p>
			<input type="number" value="${item.quantity}" data-item-name="${item.name}" readonly> 
			</div>
			<div class="cart-item__total-price">
			<p>Total Price:</p>
			<p>Rs.${(parseFloat(item.price.replace('Rs.', '')) * item.quantity).toFixed(2)}</p>
			</div>
            `;

			// Append the cart item div to the heroDetails div
			heroDetails.appendChild(cartItemDiv);
		});
	} else {
		// If there are no cart items, display a message
		heroDetails.innerHTML = '<p>No items in the cart</p>';
	}

	const totalPriceSpan = document.querySelector('.product__checkout-price p span');
	const cart_items = document.querySelectorAll('.cart-item');

	// Function to calculate total price
	function calculateTotalPrice() {
		let totalPrice = 0;
		cart_items.forEach(item => {
			const quantity = parseInt(item.querySelector('.cart-item__quantity input').value);
			const priceString = item.querySelector('.cart-item__total-price p:last-child').innerText;
			const price = parseFloat(priceString.replace('Rs.', ''));
			totalPrice += price * quantity;
		});
		return totalPrice;
	}

	// Update total price display
	function updateTotalPrice() {
		const totalPrice = calculateTotalPrice();
		totalPriceSpan.innerText = 'Rs. ' + totalPrice.toFixed(2);
	}

	// Initial update of total price
	updateTotalPrice();

	const totalpriceSpan = document.querySelector('span[name="totalPrice"]');

	// Extract the total price value
	const totalPrice = totalpriceSpan.textContent.trim();

	const numericTotalPrice = parseFloat(totalPrice.replace('Rs. ', '').trim());

	// Set the value of the hidden input field
	document.getElementById('totalPriceInput').value = numericTotalPrice;

	// Retrieve the cart items from local storage using JavaScript
	const cartItemsPreview = JSON.parse(localStorage.getItem(`cartItems_${userId}`));
	// console.log(cartItemsPreview);

	// Set the value of the hidden input field with the cart items data
	document.getElementById('cartItemsInput').value = JSON.stringify(cartItemsPreview);



	// Add event listener to each quantity input field
	cart_items.forEach(item => {
		const quantityInput = item.querySelector('.cart-item__quantity input');
		quantityInput.addEventListener('input', () => {
			updateTotalPrice(); // Update total price when quantity changes
		});
	});

	removeAllButton.addEventListener('click', () => {
		const cartList = document.querySelector('.add-to-cart__list-items');
		cartList.innerHTML = '';
		localStorage.removeItem(`cartItems_${userId}`);
	});
});

let swiper = new Swiper(".cart__home-book-slider", {
	// loop: true,
	// centeredSlides: true,
	spaceBetween: 30,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	autoplay: {
		delay: 1000,
		disableOnInteraction: false,
	},
	breakpoints: {
		0: {
			slidesPerView: 1,
		},
		768: {
			slidesPerView: 2,
		},
		1024: {
			slidesPerView: 3,
		},
	},
});

let swiper2 = new Swiper(".cart__products-slider", {
	spaceBetween: 10,
	loop: true,
	centeredSlides: true,
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	breakpoints: {
		0: {
			slidesPerView: 1,
		},
		450: {
			slidesPerView: 2,
		},
		768: {
			slidesPerView: 3,
		},
		1024: {
			slidesPerView: 4,
		},
	},
});

let swiper3 = new Swiper(".cart__arrivals-slider", {
	spaceBetween: 10,
	loop: true,
	centeredSlides: true,
	autoplay: {
		delay: 3000,
		disableOnInteraction: true,
	},
	breakpoints: {
		0: {
			slidesPerView: 1,
		},
		768: {
			slidesPerView: 2,
		},
		1024: {
			slidesPerView: 3,
		},
	},
});

let swiper4 = new Swiper(".cart__brands-slider", {
	spaceBetween: 10,
	loop: true,
	centeredSlides: true,
	pagination: {
		el: ".swiper-pagination",
		clickable: true,
	},
	navigation: {
		nextEl: ".swiper-button-next",
		prevEl: ".swiper-button-prev",
	},
	breakpoints: {
		0: {
			slidesPerView: 1,
		},
		450: {
			slidesPerView: 2,
		},
		768: {
			slidesPerView: 3,
		},
		1024: {
			slidesPerView: 4,
		},
	},
});
