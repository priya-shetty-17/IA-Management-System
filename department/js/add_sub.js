document.addEventListener("DOMContentLoaded", () => {
    const successAlert = document.getElementById("successAlert");
    const errorAlert = document.getElementById("errorAlert");

    // Auto-hide alerts after 3 seconds with sliding animation
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transform = "translateX(200%)";
            setTimeout(() => (successAlert.style.display = "none"), 500);
        }, 3000);
    }

    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.transform = "translateX(200%)";
            setTimeout(() => (errorAlert.style.display = "none"), 500);
        }, 3000);
    }
});
