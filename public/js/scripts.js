// Menu Category Navigation
document.addEventListener('DOMContentLoaded', function() {
    console.log('Document loaded!');
    
    // Add animation class to menu items for staggered entrance
    const menuItems = document.querySelectorAll('.menu-item');
    if (menuItems.length) {
        menuItems.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add('show');
            }, 100 * index);
        });
    }
    
    // Register click handlers for category buttons
    document.querySelectorAll('.btn-outline-primary').forEach(btn => {
        btn.addEventListener('click', function() {
            // Get the target section ID from the data-target attribute
            const targetId = this.getAttribute('data-target');
            console.log('Button clicked, target:', targetId);
            
            // Find the target section
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                console.log('Found target section:', targetSection);
                
                // Update active button
                document.querySelectorAll('.btn-outline-primary').forEach(button => {
                    button.classList.remove('active');
                });
                this.classList.add('active');
                
                // Scroll to the target section
                const headerOffset = 120; // Adjust based on fixed header height
                const elementPosition = targetSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            } else {
                console.error('Target section not found:', targetId);
            }
        });
    });
    
    // Handle quantity buttons in modals
    document.querySelectorAll('.decrease-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.quantity-input');
            const value = parseInt(input.value);
            if (value > 1) {
                input.value = value - 1;
            }
        });
    });
    
    document.querySelectorAll('.increase-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('.quantity-input');
            const value = parseInt(input.value);
            if (value < 10) {
                input.value = value + 1;
            }
        });
    });
    
    // Enhance variants selection visibility
    document.querySelectorAll('.variant-selector').forEach(input => {
        // Add click handler to the entire list item, not just the radio button
        const listItem = input.closest('.list-group-item');
        
        listItem.addEventListener('click', function(e) {
            // If click is on the label or span and not on the radio button itself,
            // manually trigger the radio button
            if (e.target !== input) {
                input.checked = true;
                // Trigger change event
                const event = new Event('change', { bubbles: true });
                input.dispatchEvent(event);
            }
        });
        
        input.addEventListener('change', function() {
            // Remove active class from all variant containers in this modal
            const modal = this.closest('.modal');
            modal.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active', 'bg-light');
            });
            
            // Add active class to selected variant
            if (this.checked) {
                listItem.classList.add('active', 'bg-light');
            }
        });
    });
    
    // Select the first variant by default when opening modal
    const productModals = document.querySelectorAll('.modal');
    productModals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            const firstInput = this.querySelector('.variant-selector');
            if (firstInput) {
                firstInput.checked = true;
                const event = new Event('change', { bubbles: true });
                firstInput.dispatchEvent(event);
            }
        });
    });
    
    // Monitor scroll to update active category button
    window.addEventListener('scroll', function() {
        const scrollPosition = window.scrollY + 150; // Add offset
        
        // Find the current visible section
        document.querySelectorAll('.category-section').forEach((section) => {
            const sectionTop = section.offsetTop;
            const sectionHeight = section.offsetHeight;
            const sectionId = section.id;
            
            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                // Update active button
                document.querySelectorAll('.btn-outline-primary').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                const activeBtn = document.querySelector(`button[data-target="${sectionId}"]`);
                if (activeBtn) {
                    activeBtn.classList.add('active');
                }
            }
        });
    });
    
    // Add click animation to add to cart buttons
    document.querySelectorAll('.btn-primary').forEach(btn => {
        btn.addEventListener('click', function() {
            this.classList.add('clicked');
            setTimeout(() => {
                this.classList.remove('clicked');
            }, 400);
        });
    });
});
