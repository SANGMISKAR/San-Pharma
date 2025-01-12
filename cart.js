document.addEventListener('DOMContentLoaded', function () {
    const jsonFile = 'product.json'; // Path to your JSON file
    const cartItemsContainer = document.getElementById('cart-items');
    const subtotalElement = document.getElementById('subtotal');
    const taxesElement = document.getElementById('taxes');
    const totalElement = document.getElementById('total');

    function updateOrderSummary() {
        let subtotal = 0;
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems.forEach(item => {
            const price = parseFloat(item.querySelector('.product-price').textContent.replace('₹', ''));
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            subtotal += price * quantity;
        });
        const taxes = subtotal * 0.10;
        const total = subtotal + taxes;

        subtotalElement.textContent = subtotal.toFixed(2);
        taxesElement.textContent = taxes.toFixed(2);
        totalElement.textContent = total.toFixed(2);
    }

    function addItemToCart(product) {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
            <img src="${product.image_url}" alt="Product Image" class="product-image">
            <div class="product-details">
                <h3 class="product-name">${product.name}</h3>
                <p class="product-description">${product.description.join('<br>')}</p>
                <div class="quantity-controls">
                    <button class="decrease-quantity">-</button>
                    <input type="number" class="quantity-input" value="${quantity}" min="1">
                    <button class="increase-quantity">+</button>
                </div>
                <p class="product-price">₹${product.price.new_price.toFixed(2)}</p>
            </div>
        `;
        cartItemsContainer.appendChild(cartItem);

        // Add event listeners for the + and - buttons
        const decreaseButton = cartItem.querySelector('.decrease-quantity');
        const increaseButton = cartItem.querySelector('.increase-quantity');
        const quantityInput = cartItem.querySelector('.quantity-input');

        decreaseButton.addEventListener('click', function () {
            if (quantityInput.value > 1) {
                quantityInput.value--;
                updateOrderSummary();
            }
        });

        increaseButton.addEventListener('click', function () {
            quantityInput.value++;
            updateOrderSummary();
        });

        // Also update the order summary initially
        updateOrderSummary();
    }

    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    const productId = getQueryParam('product_id');
    const quantity = getQueryParam('quantity') || 1;

    fetch(jsonFile)
        .then(response => response.json())
        .then(data => {
            const product = data.products.find(p => p.id === productId);
            if (product) {
                addItemToCart(product);
            } else {
                console.error('Product not found.');
            }
        })
        .catch(error => {
            console.error('Error fetching the JSON data:', error);
        });
});
