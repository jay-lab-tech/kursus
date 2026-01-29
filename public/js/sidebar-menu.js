/**
 * Sidebar Menu Management
 * Handles dynamic menu visibility based on user role
 */

function initializeSidebar() {
    try {
        const userJSON = localStorage.getItem('user');
        const userRole = localStorage.getItem('userRole');
        
        let role = userRole;
        
        if (!role && userJSON) {
            try {
                const userData = JSON.parse(userJSON);
                role = userData.role;
            } catch (e) {
                console.error('Error parsing user data:', e);
            }
        }

        // Apply role-based menu visibility
        if (role) {
            showMenuItemsByRole(role);
        }
    } catch (error) {
        console.error('Error initializing sidebar:', error);
    }
}

function showMenuItemsByRole(role) {
    // Hide all conditional items first
    const conditionalItems = document.querySelectorAll('[data-role]');
    conditionalItems.forEach(item => {
        item.style.display = 'none';
    });

    // Show items for current role
    const roleItems = document.querySelectorAll(`[data-role~="${role}"]`);
    roleItems.forEach(item => {
        item.style.display = '';
    });

    // Show items that have 'all' role
    const allItems = document.querySelectorAll('[data-role~="all"]');
    allItems.forEach(item => {
        item.style.display = '';
    });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeSidebar);
} else {
    initializeSidebar();
}
