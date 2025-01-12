// product.js

// Function to add item to cart
function addToCart() {
    // Get the product details
    const productName = document.querySelector('.product-name').innerText;
    const productDescription = document.querySelector('.product-description').innerText;
    const productPrice = parseFloat(document.querySelector('.product-price').innerText.replace('₹', ''));
    const productQuantity = parseInt(document.querySelector('.quantity-input').value);
    const productImage = document.querySelector('.product-image img').src;

    // Create an object for the product
    const product = {
        name: productName,
        description: productDescription,
        price: productPrice,
        quantity: productQuantity,
        image: productImage
    };

    // Retrieve the cart from localStorage or create a new one if it doesn't exist
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Check if the product already exists in the cart
    const existingProductIndex = cart.findIndex(item => item.name === productName);

    if (existingProductIndex > -1) {
        // If the product exists, update the quantity
        cart[existingProductIndex].quantity += productQuantity;
    } else {
        // If the product does not exist, add it to the cart
        cart.push(product);
    }

    // Save the updated cart back to localStorage
    localStorage.setItem('cart', JSON.stringify(cart));

    // Provide feedback to the user
    alert(`${productName} has been added to your cart.`);
}

// Event listener for the "Add to Cart" button
document.querySelector('.add-to-cart-button').addEventListener('click', addToCart);
