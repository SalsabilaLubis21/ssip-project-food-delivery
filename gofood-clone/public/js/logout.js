document.addEventListener("DOMContentLoaded", function () {
    window.handleLogout = function () {
        if (confirm("Are you sure you want to logout?")) {
            const form = document.getElementById("logout-form");
            if (form) {
                form.submit();
            }
        }
    };
});
