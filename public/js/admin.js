/**
 * Admin UI JavaScript
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize table dropdowns
    initTableDropdowns();
});

/**
 * Initialize the custom dropdowns in tables
 */
function initTableDropdowns() {
    // Get all table dropdown buttons (more specific selector to avoid conflicts with navigation)
    const dropdownButtons = document.querySelectorAll('.table-dropdown .dropdown-button');

    // Add click event to each button
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Prevent the click from propagating
            event.stopPropagation();

            // Toggle the 'show' class on the parent dropdown
            this.parentElement.classList.toggle('show');

            // Close other dropdowns
            dropdownButtons.forEach(otherButton => {
                if (otherButton !== button) {
                    otherButton.parentElement.classList.remove('show');
                }
            });
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.table-dropdown')) {
            dropdownButtons.forEach(button => {
                button.parentElement.classList.remove('show');
            });
        }
    });
}
