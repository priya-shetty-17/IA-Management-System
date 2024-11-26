// Function to open the sidebar
function openSidebar() {
    document.getElementById('sidebar').style.left = '0'; // Open sidebar
    document.querySelector('.main-content').style.marginLeft = '250px'; // Adjust content
    document.getElementById('sidebarToggle').style.display = 'none'; // Hide toggle button
    document.getElementById('closeSidebar').style.display = 'block'; // Show close button
}

// Function to close the sidebar
function closeSidebar() {
    document.getElementById('sidebar').style.left = '-250px'; // Close sidebar
    document.querySelector('.main-content').style.marginLeft = '0'; // Reset content margin
    document.getElementById('sidebarToggle').style.display = 'block'; // Show toggle button
    document.getElementById('closeSidebar').style.display = 'none'; // Hide close button
}

// Add event listeners for the toggle button and close button
document.getElementById('sidebarToggle').addEventListener('click', openSidebar);
document.getElementById('closeSidebar').addEventListener('click', closeSidebar);
