// Custom JavaScript for the restaurant menu app

document.addEventListener('DOMContentLoaded', function() {
    // Add smooth scrolling to all links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
    
    // Add animation class to menu items for staggered entrance
    const menuItems = document.querySelectorAll('.menu-item');
    if (menuItems.length) {
        menuItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('show');
            }, 100 * index);
        });
    }
    
    // Enhance variants selection visibility
    const variantInputs = document.querySelectorAll('input[name="variant"]');
    if (variantInputs.length) {
        variantInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Remove active class from all variant containers
                document.querySelectorAll('.list-group-item').forEach(item => {
                    item.classList.remove('active', 'bg-light');
                });
                
                // Add active class to selected variant
                if (this.checked) {
                    this.closest('.list-group-item').classList.add('active', 'bg-light');
                }
            });
        });
    }
    
    // Add click effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            this.classList.add('clicked');
            setTimeout(() => {
                this.classList.remove('clicked');
            }, 200);
        });
    });
});

// Custom Livewire event listeners
document.addEventListener('livewire:load', function() {
    // Listen for category changes
    window.addEventListener('category-changed', event => {
        const productsContainer = document.getElementById('products-container');
        if (productsContainer) {
            productsContainer.scrollIntoView({ behavior: 'smooth' });
        }
    });
    
    // Listen for cart update events
    window.addEventListener('cartUpdated', event => {
        // Add a small animation to the cart icon
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.classList.add('cart-updated');
            setTimeout(() => {
                cartIcon.classList.remove('cart-updated');
            }, 1000);
        }
    });
});
