function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("sidebar-open");

    // Adjust main content when sidebar is open
    document.querySelector(".main-content").classList.toggle("sidebar-open");
}
