// Restaurant Menu Scripts
document.addEventListener('DOMContentLoaded', function() {
    // Handle category scrolling
    window.addEventListener('scroll', highlightCurrentCategory);
    
    // Ensure the menu categories are correctly initialized
    initializeMenu();
});

/**
 * Initialize the menu functionality
 */
function initializeMenu() {
    // Make the first category active by default if not already set
    if (!document.querySelector('.btn-outline-primary.active') && document.querySelector('.btn-outline-primary')) {
        document.querySelector('.btn-outline-primary').classList.add('active');
    }
}

/**
 * Scroll to a specific category
 */
function scrollToCategory(categoryId) {
    const element = document.getElementById(categoryId);
    if (element) {
        // Update active button
        document.querySelectorAll('.btn-outline-primary').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Find and activate the button for this category
        const categoryButton = document.querySelector(`.btn-outline-primary[onclick*="${categoryId}"]`);
        if (categoryButton) {
            categoryButton.classList.add('active');
        }
        
        // Scroll to category
        const offset = 150; // Account for sticky header + category menu
        const elementPosition = element.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - offset;
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
}

/**
 * Highlight the current category based on scroll position
 */
function highlightCurrentCategory() {
    const scrollPosition = window.scrollY + 200; // Add offset for header and category menu
    const categories = document.querySelectorAll('.category-section');
    
    // Don't do anything if no categories are found
    if (categories.length === 0) return;
    
    // Find the current visible section
    let activeCategory = null;
    
    for (let i = 0; i < categories.length; i++) {
        const section = categories[i];
        const sectionTop = section.offsetTop;
        const sectionHeight = section.offsetHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            activeCategory = section.id;
            break;
        }
    }
    
    // If we've scrolled past the last section, highlight the last one
    if (!activeCategory && scrollPosition >= categories[categories.length - 1].offsetTop) {
        activeCategory = categories[categories.length - 1].id;
    }
    
    // Update active button
    if (activeCategory) {
        document.querySelectorAll('.btn-outline-primary').forEach(btn => {
            btn.classList.remove('active');
        });
        
        const categoryButton = document.querySelector(`.btn-outline-primary[onclick*="${activeCategory}"]`);
        if (categoryButton) {
            categoryButton.classList.add('active');
        }
    }
}

// Make functions available globally
window.scrollToCategory = scrollToCategory;
window.highlightCurrentCategory = highlightCurrentCategory;
window.initializeMenu = initializeMenu;
