</main>
</div>
</div>
</div>
</div>
</div>
<footer class="text-center text-lg-start">
    <div class="text-white p-3">
        <p>&copy; 2024 Kelompok 4 TI 2A</p>
    </div>
</footer>
<script>
    document.getElementById('toggleSidebar').addEventListener('click', function () {
        document.getElementById('sidebarMenu').classList.toggle('collapsed-sidebar');
    });

    function loadContent(url) {
        fetch(url)
            .then(response => response.text())
            .then(data => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(data, 'text/html');
                document.getElementById('main-content').innerHTML = doc.getElementById('main-content').innerHTML;
            })
            .catch(error => console.error('Error loading content:', error));
    }

    document.querySelectorAll('a[data-load]').forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            loadContent(this.href);
        });
    });
</script>
</body>
</html>