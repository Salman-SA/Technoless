// Ensure the cart variable is defined
let cart = JSON.parse(localStorage.getItem('cart')) || [];
console.log('Initial cart:', cart);

// Function to add item to cart
function addToCart(productId) {
    const productElement = document.querySelector(`[data-product-id='${productId}']`).parentElement;
    const productName = productElement.querySelector('h2').innerText;
    const productPrice = parseFloat(productElement.querySelector('p').innerText.replace(' SAR', '').replace(',', ''));
    const productImage = productElement.querySelector('img').src;

    // Debug: Check if product image is defined
    if (!productImage) {
        console.error('Product image is undefined for product ID:', productId);
        return;
    }

    const item = {
        product_id: productId,
        product_name: productName,
        product_price: productPrice,
        quantity: 1,
        product_image: productImage
    };

    console.log('Adding item to cart:', item);

    fetch('add_to_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(item)
    }).then(response => response.json())
      .then(data => {
          if (data.status === 'success') {
              const existingItem = cart.find(cartItem => cartItem.product_id === productId);
              if (existingItem) {
                  existingItem.quantity += 1;
              } else {
                  cart.push(item);
              }
              localStorage.setItem('cart', JSON.stringify(cart));
              updateCartCount();
              console.log('Updated cart:', cart);
          } else {
              console.error('Failed to add item to cart:', data);
          }
      }).catch(error => {
          console.error('Error:', error);
      });
}

// Function to remove item from cart
function removeFromCart(productId) {
    console.log('Removing item from cart:', productId);

    fetch('remove_from_cart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ product_id: productId })
    }).then(response => response.json())
      .then(data => {
          if (data.status === 'success') {
              cart = cart.filter(item => item.product_id !== productId);
              localStorage.setItem('cart', JSON.stringify(cart));
              displayCart();
              updateCartCount();
              console.log('Updated cart after removal:', cart);
          } else {
              console.error('Failed to remove item from cart:', data);
          }
      }).catch(error => {
          console.error('Error:', error);
      });
}

// Function to update cart count
function updateCartCount() {
    document.getElementById('cart-count').innerText = cart.reduce((total, item) => total + item.quantity, 0);
}

// Function to display cart contents
function displayCart() {
    const cartItems = document.getElementById('cartItems');
    const subtotalElement = document.getElementById('subtotal');
    const taxElement = document.getElementById('tax');
    const totalElement = document.getElementById('total');
    cartItems.innerHTML = ''; // Clear previous contents

    let subtotal = 0;

    cart.forEach(item => {
        const li = document.createElement('li');
        li.className = 'cart-item';

        // Debug: Log item image
        console.log('Item image:', item.product_image);

        const itemImage = document.createElement('img');
        itemImage.src = item.product_image;
        itemImage.alt = item.product_name;
        itemImage.style.width = '100px'; // Adjust as necessary

        const itemName = document.createElement('h3');
        itemName.textContent = item.product_name;

        const itemPrice = document.createElement('p');
        itemPrice.textContent = `Price: ${item.product_price} SAR`;

        const itemQuantity = document.createElement('p');
        itemQuantity.textContent = `Quantity: ${item.quantity}`;

        const itemTotal = document.createElement('p');
        itemTotal.textContent = `Total: ${(item.product_price * item.quantity).toFixed(2)} SAR`;

        const removeButton = document.createElement('button');
        removeButton.className = 'remove';
        removeButton.textContent = 'Remove';
        removeButton.addEventListener('click', function() {
            console.log('Clicked Remove Button for:', item.product_id);
            removeFromCart(item.product_id);
        });

        li.appendChild(itemImage);
        li.appendChild(itemName);
        li.appendChild(itemPrice);
        li.appendChild(itemQuantity);
        li.appendChild(itemTotal);
        li.appendChild(removeButton);
        cartItems.appendChild(li);

        subtotal += item.product_price * item.quantity;
    });

    const tax = subtotal * 0.1; // Assuming 10% sales tax
    const total = subtotal + tax;

    subtotalElement.textContent = `Subtotal: ${subtotal.toFixed(2)} SAR`;
    taxElement.textContent = `Sales Tax: ${tax.toFixed(2)} SAR`;
    totalElement.textContent = `Total: ${total.toFixed(2)} SAR`;
}

// Display cart items and update count on page load
document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    displayCart();

    // Only add event listener if the checkout button exists
    const checkoutButton = document.getElementById('checkout');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function() {
            alert('Proceeding to checkout...');
            // Implement the checkout functionality here
        });
    }
});
