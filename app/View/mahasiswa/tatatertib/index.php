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
                <table class="table table-hover" id="tableKlasifikasiPelanggaran">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 rounded-start-3 col-1">No</th>
                            <th class="border-0 ">Klasifikasi Pelanggaran</th>
                            <th class="border-0  col-1">Tingkat</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($model['data']['listKlasifikasiPelanggaran'])) {
                        $no = 1;
                        $listKlasifikasi = $model['data']['listKlasifikasiPelanggaran'];
                        for ($i = 0; $i < count($listKlasifikasi); $i++) {
                            if ($listKlasifikasi[$i]->tingkat == 2) {
                                for ($j = 0; $j < count($listKlasifikasi); $j++) {
                                    if ($listKlasifikasi[$i]->pelanggaran == $listKlasifikasi[$j]->pelanggaran && $listKlasifikasi[$j]->tingkat == 1) {
                                        $listKlasifikasi[$i]->tingkat = 12;
                                        unset($listKlasifikasi[$j]);
                                        $listKlasifikasi = array_values($listKlasifikasi);
                                    }
                                }
                            }
                        }

                        foreach ($listKlasifikasi as $klasifikasi) {
                                echo "<tr>";
                                echo "<td>{$no}</td>";
                                echo "<td>{$klasifikasi->pelanggaran}</td>";
                                if ($klasifikasi->tingkat == 12) {
                                    echo "<td>1 / 2</td>";
                                } else {
                                    echo "<td>{$klasifikasi->tingkat}</td>";
                                }
                                echo "</tr>";
                                $no++;
                        }
                    } else {
                        echo "<tr><td colspan='3'>Data tidak ditemukan</td></tr>";
                    }
                    ?>
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

    $(document).ready(function() {
        $('#tableKlasifikasiPelanggaran').DataTable();
    });
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
