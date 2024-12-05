<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <h3>TATA TERTIB KEHIDUPAN KAMPUS</h3>
            <hr>

            <!-- Button Navigation -->
            <div class="mb-4">
                <button class="btn btn-primary me-2" onclick="showContent('tingkat')">Tingkat</button>
                <button class="btn btn-secondary me-2" onclick="showContent('klasifikasi')">Klasifikasi</button>
                <button class="btn btn-info me-2" onclick="showContent('akumulasi')">Akumulasi</button>
                <button class="btn btn-warning me-2" onclick="showContent('sanksi')">Sanksi</button>
            </div>

            <!-- Content Sections -->
            <div id="content-tingkat" class="content-section">
                <h4>Tingkat Pelanggaran</h4>
                <h6>Adapun tingkat pelanggaran ditentukan sebagai berikut:</h6>
                <ul>
                    <li>Tingkat I: Pelanggaran sangat berat</li>
                    <li>Tingkat II: Pelanggaran berat</li>
                    <li>Tingkat III: Pelanggaran cukup berat</li>
                    <li>Tingkat IV: Pelanggaran sedang</li>
                    <li>Tingkat V: Pelanggaran ringan</li>
                </ul>
            </div>

            <div id="content-klasifikasi" class="content-section d-none">
                <h4>Klasifikasi Pelanggaran</h4>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Klasifikasi Pelanggaran</th>
                            <th>Tingkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Berkomunikasi dengan tidak sopan...</td>
                            <td>V</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Berbusana tidak sopan...</td>
                            <td>IV</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Mahasiswa laki-laki berambut tidak rapi...</td>
                            <td>IV</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="content-akumulasi" class="content-section d-none">
                <h4>Akumulasi Sanksi Pelanggaran</h4>
                <h6>Perbuatan/tindakan pelanggaran Tata Tertib Kehidupan Kampus akan
                diakumulasikan untuk setiap kategori pelanggaran dan berlaku sepanjang mahasiswa
                masih tercatat sebagai mahasiswa di Polinema.</h6>
                <ul>
                    <li>Apabila pelanggaran tingkat V dilakukan 3 (tiga) kali maka klasifikasi
                    pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat IV.</li>
                    <li>Apabila pelanggaran tingkat IV dilakukan 3 (tiga) kali maka klasifikasi
                    pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat III.</li>
                    <li>Apabila pelanggaran tingkat III dilakukan 3 (tiga) kali maka klasifikasi
                    pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat II.</li>
                    <li>Apabila pelanggaran tingkat II dilakukan 3 (tiga) kali maka klasifikasi
                    pelanggaran tersebut ditingkatkan menjadi pelanggaran tingkat I.
                    </li>
                </ul>
            </div>

            <div id="content-sanksi" class="content-section d-none">
                <h4>Sanksi Pelanggaran</h4>
                <h6>Berikut adalah sanksi yang diberikan berdasarkan tingkat pelanggarannya:</h6>
                <ul>
                    <li>Tingkat V: Teguran lisan dan surat pernyataan</li>
                    <li>Tingkat IV: Teguran tertulis, pemanggilan orang tua/wali</li>
                    <li>Tingkat III: Surat pernyataan, tugas khusus</li>
                    <li>Tingkat II: Penggantian kerugian, tugas sosial, nilai D</li>
                    <li>Tingkat I: Cuti Akademik/Diberhentikan</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<!-- JavaScript -->
<script>
    function showContent(sectionId) {
        // Hide all sections
        const sections = document.querySelectorAll('.content-section');
        sections.forEach(section => section.classList.add('d-none'));

        // Show the selected section
        const selectedSection = document.getElementById(`content-${sectionId}`);
        if (selectedSection) {
            selectedSection.classList.remove('d-none');
        }
    }
</script>
