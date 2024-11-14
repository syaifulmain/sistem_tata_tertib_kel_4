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
</script>
</body>
</html>