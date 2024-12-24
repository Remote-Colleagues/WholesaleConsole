document.addEventListener("DOMContentLoaded", function() {
    const sidebarLinks = document.querySelectorAll('.sidebar-menu li a');
    
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            alert("Navigating to: " + link.textContent);
            // You can add actual navigation or dynamic content loading logic here
        });
    });
});
