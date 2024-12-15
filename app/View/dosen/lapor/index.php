<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <div class="row">
                <h3 class="col">Lapor Mahasiswa</h3>
                <div class="col-auto row">
                    <div class="col col-auto">

                        <button
                                class="btn btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#tambahLaporanMahasiswa"
                        >
                            Buat Laporan
                        </button>
                    </div>
                    <div class="col col-auto">
                        <select class="form-select" aria-label="Status" id="status" onchange="filterTableByStatus()">
                            <option value="" selected>Status</option>
                            <option value="Proses">Proses</option>
                            <option value="Dikirim">Dikirim</option>
                            <option value="Batal">Batal</option>
                        </select>
                    </div>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover" id="tableIni">
                    <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start-3 col-1">No</th>
                        <th class="border-0 col-3">Nama</th>
                        <th class="border-0">Pelanggaran</th>
                        <th class="border-0 col-1">Status</th>
                        <th class="border-0 col-1">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach ($model['data']['listRiwayatLapor'] as $riwayatLapor) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>{$riwayatLapor->nama_mahasiswa}</td>";
                        echo "<td>{$riwayatLapor->pelanggaran}</td>";
                        echo "<td>";
                        if ($riwayatLapor->verifikasi == 0 & $riwayatLapor->batal == 0) {
                            echo "<div class='alert alert-warning m-0 p-1 small'>Proses</div>";
                        } else if ($riwayatLapor->batal == 1) {
                            echo "<div class='alert alert-danger m-0 p-1 small'>Batal</div>";
                        } else {
                            echo "<div class='alert alert-success m-0 p-1 small'>Dikirim</div>";
                        }
                        echo "</td>";
                        echo "<td>";
                        echo "<button class='btn btn-sm btn-outline-info' data-bs-toggle='modal' data-bs-target='#detailLaporanMahasiswa' onclick='getDetailLaporan({$riwayatLapor->id})'>Detail</button>";
                        echo "</td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>
                <!-- Modal tambah laporan mahasiswa-->
                <div
                        class="modal fade"
                        id="tambahLaporanMahasiswa"
                        data-bs-backdrop="static"
                        tabindex="-1"
                        aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahLaporanMahasiswaLabel">Lapor Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form enctype="multipart/form-data" id="buatLaporan">
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <label for="inputMahasiswa" class="form-label">Pelanggar</label>
                                        <select id="inputMahasiswa" name="inputMahasiswa" placeholder="Cari"
                                                class="my-form-control">
                                            <option value="">Select your country</option>
                                            <?php
                                            foreach ($model['data']['listMahasiswa'] as $mahasiswa) {
                                                echo "<option value='{$mahasiswa->nim}'>{$mahasiswa->nim}/{$mahasiswa->nama}</option>";
                                            }
                                            ?>
                                        </select>
                                        <span id="inputMahasiswaError"
                                              class="text-danger d-none">Field ini harus diisi</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="inputTanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" id="inputTanggal" name="inputTanggal">
                                        <span id="inputTanggalError"
                                              class="text-danger d-none">Field ini harus diisi</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="inputKlasifikasi" class="form-label">Pelanggaran</label>
                                        <select id="inputKlasifikasi" name="inputKlasifikasi"
                                                placeholder="Pilih Pelanggaran" class="my-form-control">
                                            <option value="">Pilih pelanggaran</option>
                                            <?php
                                            $listKlasifikasi = $model['data']['listKlasifikasi'];
                                            for ($i = 0; $i < count($listKlasifikasi); $i++) {
                                                if ($listKlasifikasi[$i]->tingkat == 2) {
                                                    for ($j = 0; $j < count($listKlasifikasi); $j++) {
                                                        if ($listKlasifikasi[$i]->pelanggaran == $listKlasifikasi[$j]->pelanggaran && $listKlasifikasi[$j]->tingkat == 1) {
                                                            $listKlasifikasi[$i]->tingkat = '1/2';
                                                            unset($listKlasifikasi[$j]);
                                                            $listKlasifikasi = array_values($listKlasifikasi);
                                                        }
                                                    }
                                                }
                                            }

                                            foreach ($listKlasifikasi as $klasifikasi) {
                                                echo "<option value='{$klasifikasi->id}'>{$klasifikasi->tingkat}-{$klasifikasi->pelanggaran} </option>";
                                            }
                                            ?>
                                        </select>
                                        <span id="inputKlasifikasiError" class="text-danger d-none">Field ini harus diisi</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="inputBukti" class="form-label">Upload Bukti</label>
                                        <input type="file" class="form-control" id="inputBukti" name="inputBukti">
                                        <span id="inputBuktiError"
                                              class="text-danger d-none">Field ini harus diisi</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="inputDeskripsi"
                                                  name="inputDeskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="col btn btn-success" type="submit" id="kirimLaporan">Kirim Laporan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal details laporan mahasiswa-->
                <div
                        class="modal fade"
                        id="detailLaporanMahasiswa"
                        data-bs-backdrop="static"
                        tabindex="-1"
                        aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="labelDetailLaporanMahasiswa">Detail Pelanggaran</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">NIM</p>
                                    <h5 id="detailNIM">1234567890</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Nama Pelanggar</p>
                                    <h5 id="detailNama">Ini Adalah Nama Saya</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Tanggal</p>
                                    <h5 id="detailTanggal">12/12/2021</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Pelanggaran</p>
                                    <h5 id="detailPelanggaran">Merokok di kampus</h5>
                                </div>
                                <div class="alert alert-warning d-none" role="alert" id="alertTingkat">
                                    Pelanggaran ditingkatkan karena sudah 3 kali melakukan pelanggaran di tingkat yang
                                    sama
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Tingkat Pelanggar</p>
                                    <h5 id="detailTingkat">Ringan</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Sanksi</p>
                                    <h5 id="detailSanksi">Sanksi</h5>
                                    <!--                                    <h5 id="detailTingkat">-->
                                    <!--                                        <select class="form-select" aria-label="Tingkat Pelanggar">-->
                                    <!--                                            <option selected>Pilih Tingkat</option>-->
                                    <!--                                            <option value="1">Tingkat 1</option>-->
                                    <!--                                            <option value="2">Tingkat 2</option>-->
                                    <!--                                        </select>-->
                                    <!--                                    </h5>-->
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Bukti</p>
                                    <img src="https://via.placeholder.com/1000" alt="Bukti" class="img-fluid"
                                         id="detailBukti"
                                         style="max-width: 100%; height: auto;" onclick="showFullImage(this.src)">
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Deskripsi</p>
                                    <h5 id="detailDeskripsi">Lorem ipsum </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal for full image -->
            <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel">Bukti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="fullImage" src="" class="img-fluid" alt="Full Image">
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if ($no > 15) {
                ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
                <?php
            }
            ?>
        </div>
    </div>
</main>
<!--Main layout-->
<script>

    $(document).ready(function () {
        let table = $('#tableIni').DataTable();

        window.filterTableByStatus = function() {
            let status = $('#status').val();
            table.column(3).search(status).draw();
        };
    });

    $(document).ready(function () {
        $('#tableIni').DataTable();
    });

    function getDetailLaporan(id) {
        $.ajax({
            url: '<?php echo APP_URL?>/dosen/lapor/detaillaporan',
            method: 'POST',
            data: {
                id: id
            },
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                data = data.data;

                $('#detailNIM').text(data.nim);
                $('#detailNama').text(data.nama);
                $('#detailTanggal').text(data.tanggal);
                $('#detailPelanggaran').text(data.pelanggaran);
                if (data.tingkat != null) {
                    $('#detailTingkat').text(data.tingkat);
                    $('#detailSanksi').text(data.sanksi);
                } else {
                    $('#detailTingkat').text("1/2");
                    $('#detailSanksi').text("Belum ditentukan");
                }
                $('#detailDeskripsi').text(data.deskripsi);
                $('#detailBukti').attr('src', '<?php echo APP_URL?>/resources/buktipelanggaran/' + data.bukti);

                if (data.tingkat != data.tingkatKP & data.tingkat != null) {
                    $('#alertTingkat').removeClass('d-none');
                } else {
                    $('#alertTingkat').addClass('d-none');
                }
            },
            error: function (response) {
                alert('Gagal mengambil data');
            }
        });
    }

    $('#inputMahasiswa, #inputTanggal, #inputKlasifikasi, #inputBukti').on('change', function () {
        let errorId = $(this).attr('id') + 'Error';
        $('#' + errorId).toggleClass('d-none', $(this).val().trim() !== '');
    });

    $(document).ready(function () {
        $('#buatLaporan').on('submit', function (e) {
            e.preventDefault();

            let isValid = true;

            let formData = new FormData(this);

            $('#inputMahasiswa, #inputTanggal, #inputKlasifikasi, #inputBukti').each(function () {
                let errorId = $(this).attr('id') + 'Error';
                if ($(this).val().trim() === '') {
                    $('#' + errorId).removeClass('d-none');
                    isValid = false;
                } else {
                    $('#' + errorId).addClass('d-none');
                }
            });

            if (!isValid) {
                return;
            }

            $.ajax({
                url: '<?php echo APP_URL?>/dosen/lapor/tambah',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert('Berhasil mengirim laporan');
                    $('#inputMahasiswa, #inputTanggal, #inputKlasifikasi, #inputBukti, #inputDeskripsi').val('');
                    window.location.reload();
                },
                error: function (response) {
                    alert('Gagal mengirim laporan');
                }
            });
        });
    });


</script>

<script>
    function showFullImage(src) {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        document.getElementById('fullImage').src = src;
        modal.show();
    }

    $('#inputKlasifikasi').selectize({
        onChange: function (value) {

        }
    });

    $('#inputMahasiswa').selectize({
        onChange: function (value) {

        }
    });

    const toggleChevron = (submenuId, chevronId) => {
        $(`#${submenuId}`).on('show.bs.collapse hide.bs.collapse', function () {
            $(`#${chevronId}`).toggleClass('bi-caret-down-fill bi-caret-left-fill');
        });
    }
    toggleChevron('submenuMahasiswa', 'chevronMahasiswa');
    toggleChevron('submenuDosen', 'chevronDosen');
    toggleChevron('submenuSistemTataTertib', 'chevronSistemTataTertib');
</script>
<script>
    $(function () {
        $('input[type=checkbox]').prop('checked', true);
    });

    function setActive(element) {
        $('.list-group-item').removeClass('active');
        $(element).addClass('active');
    }
</script>