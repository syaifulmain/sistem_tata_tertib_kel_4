<script>
    function toggleFixedTop() {
        const navbar = document.getElementById('main-navbar');
        if (window.innerWidth < 992) {
            navbar.classList.add('fixed-top');
        } else {
            navbar.classList.remove('fixed-top');
        }
    }

    window.addEventListener('resize', toggleFixedTop);
    window.addEventListener('load', toggleFixedTop);

    function setActive(element) {
        // Remove active class from all items
        document.querySelectorAll('#navMenu .list-group-item').forEach(function(item) {
            item.classList.remove('active');
        });
        // Add active class to the clicked item
        element.classList.add('active');
    }
</script>
</body>
</html>