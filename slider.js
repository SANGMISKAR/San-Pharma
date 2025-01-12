
document.addEventListener('DOMContentLoaded', function () {
    const productSection = document.querySelector('.product-list');
    const scrollLeftButton = document.getElementById('scroll-left');
    const scrollRightButton = document.getElementById('scroll-right');

    // Scroll to the left
    scrollLeftButton.addEventListener('click', function () {
        productSection.scrollBy({
            top: 0,
            left: -300, // Adjust the value to control the scroll distance
            behavior: 'smooth'
        });
    });

    // Scroll to the right
    scrollRightButton.addEventListener('click', function () {
        productSection.scrollBy({
            top: 0,
            left: 300, // Adjust the value to control the scroll distance
            behavior: 'smooth'
        });
    });
});
