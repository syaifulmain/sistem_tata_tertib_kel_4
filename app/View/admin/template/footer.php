<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script>
    const toggleChevron = (submenuId, chevronId) => {
        $(`#${submenuId}`).on('show.bs.collapse hide.bs.collapse', function () {
            $(`#${chevronId}`).toggleClass('bi-caret-down-fill bi-caret-left-fill');
        });
    }
    toggleChevron('submenuMahasiswa', 'chevronMahasiswa');
    toggleChevron('submenuDosen', 'chevronDosen');
    toggleChevron('submenuSistemTataTertib', 'chevronSistemTataTertib');
</script>
</body>
</html>