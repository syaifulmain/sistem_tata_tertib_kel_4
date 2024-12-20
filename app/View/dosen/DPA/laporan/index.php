<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <div class="row">
                <h3 class="col">Laporan Pelanggaran Mahasiswa</h3>
                <div class="col-auto">
                    <select class="form-select" aria-label="Status" id="status" onchange="filterTableByStatus()">
                        <option value="" selected>Status</option>
                        <option value="Proses">Proses</option>
                        <option value="Dikirim">Dikirim</option>
                        <option value="Batal">Batal</option>
                    </select>
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
                    foreach ($model['data']['listLaporan'] as $riwayatLapor) {
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
                <?php
                ?>
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
                                <h5 class="modal-title" id="detailLaporanMahasiswaLabel">Detail Lapor Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="detailId" value="">
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">NIM</p>
                                    <h5 id="detailNIM">1234567890</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Nama Pelanggar</p>
                                    <h5 id="detailNamaPelanggar">Ini Adalah Nama Saya</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Kelas</p>
                                    <h5 id="detailKelas">Ini Adalah Nama Saya</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Nama Pelapor</p>
                                    <h5 id="detailNamaPelapor">Ini Adalah Nama Pelapor</h5>
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
                                    Pelanggaran ditingkatkan karena sudah 3 kali melakukan pelanggaran di tingkat yang sama
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Tingkat Pelanggar</p>
                                        <select id="detailTingkat" class="form-select" aria-label="Tingkat Pelanggar">
                                        </select>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Sanksi</p>
                                    <h5 id="detailSanksi">Sanksi</h5>
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
                            <div class="modal-footer">
                                <button class="col btn btn-danger" id="batalkanLaporan">Batal</button>
                                <button class="col btn btn-success" id="kirimLaporan">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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


    const getDetailLaporan = (id) => {
        $.ajax({
            url: '<?php echo APP_URL ?>/dosen/laporan/detaillaporan?id=' + id,
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                data = data.data;
                $('#detailId').val('');
                $('#detailId').val(id);
                $('#detailNIM').text(data.nim);
                $('#detailNamaPelanggar').text(data.namaPelanggar);
                $('#detailKelas').text(data.kelas);
                $('#detailNamaPelapor').text(data.namaPelapor);
                $('#detailTanggal').text(data.tanggal);
                $('#detailPelanggaran').text(data.pelanggaran);
                $('#detailTingkat').empty();
                if (data.tingkat != null){
                    $('#detailTingkat').append(`<option value="${data.tingkat}" selected disabled>${data.tingkat}</option>`);
                    $('#detailTingkat').prop('disabled', true);
                    $('#detailSanksi').text(data.sanksi);
                } else  {
                    $('#detailTingkat').append(`<option value="1" >1</option>`).append(`<option value="2">2</option>`);
                    $('#detailTingkat').prop('disabled', false);
                    $('#detailSanksi').text('Belum ditentukan');
                }
                $('#detailBukti').attr('src', '<?php echo APP_URL?>/resources/buktipelanggaran/' + data.bukti);
                $('#detailDeskripsi').text(data.deskripsi);

                if (data.verifikasi == 0 & data.batal == 0) {
                    $('#batalkanLaporan').show();
                    $('#kirimLaporan').show();
                } else {
                    $('#batalkanLaporan').hide();
                    $('#kirimLaporan').hide();
                }

                if (data.tingkat != data.tingkatKP & data.tingkat != null) {
                    $('#alertTingkat').removeClass('d-none');
                } else {
                    $('#alertTingkat').addClass('d-none');
                }
            },
            error: function (response) {
                console.log(response);
                alert('Gagal mengambil data');
            }
        });
    }

    $('#kirimLaporan').click(function () {
        let id = $('#detailId').val();
        $.ajax({
            url: '<?php echo APP_URL ?>/dosen/laporan/kirimlaporan',
            type: 'POST',
            data: {
                id: id
            },
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                if (data.status === 'OK') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            },
            error: function (response) {
                console.log(response);
                alert('Gagal mengirim laporan');
            }
        });
    });

    $('#batalkanLaporan').click(function () {
        let id = $('#detailId').val();
        $.ajax({
            url: '<?php echo APP_URL ?>/dosen/laporan/batalkanlaporan',
            type: 'POST',
            data: {
                id: id
            },
            success: function (response) {
                console.log(response);
                let data = JSON.parse(response);
                if (data.status === 'OK') {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message);
                }
            },
            error: function (response) {
                console.log(response);
                alert('Gagal membatalkan laporan');
            }
        });
    });

    const showFullImage = (src) => {
        $('#fullImage').attr('src', src);
        $('#fullImageModal').modal('show');
    }
</script>
<script>
    $('#select-state').selectize({
        onChange: function (value) {

        }
    });
    $('#select-state-test').selectize({
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