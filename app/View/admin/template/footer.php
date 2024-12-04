<script>
    $(document).ready(function() {
        function toggleFixedTop() {
            const navbar = $('#main-navbar');
            if ($(window).width() < 992) {
                navbar.addClass('fixed-top');
            } else {
                navbar.removeClass('fixed-top');
            }
        }

        $(window).on('resize', toggleFixedTop);
        toggleFixedTop();

        function setActive(element) {
            $('.list-group-item').removeClass('active');
            $(element).addClass('active');
        }
    });
</script>
</body>
</html>