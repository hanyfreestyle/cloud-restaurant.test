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
    
    // For category buttons, when they are clicked, scroll to products section
    document.querySelectorAll('.btn-outline-primary').forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(() => {
                const productsContainer = document.getElementById('products-container');
                if (productsContainer) {
                    productsContainer.scrollIntoView({ behavior: 'smooth' });
                }
            }, 500);
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
    
    // Add active class to selected variant in modals
    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('input[name="variant_id"]')) {
            // Remove active class from all variant containers in this modal
            const listItems = e.target.closest('.list-group').querySelectorAll('.list-group-item');
            listItems.forEach(item => {
                item.classList.remove('active', 'bg-light');
            });
            
            // Add active class to selected variant
            if (e.target.checked) {
                e.target.closest('.list-group-item').classList.add('active', 'bg-light');
            }
        }
    });
    
    // Add click effect to buttons
    document.addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('btn') || e.target.closest('.btn'))) {
            const btn = e.target.classList.contains('btn') ? e.target : e.target.closest('.btn');
            btn.classList.add('clicked');
            setTimeout(() => {
                btn.classList.remove('clicked');
            }, 200);
        }
    });
});