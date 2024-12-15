<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <div class="row">
                <h3 class="col">Daftar Pelanggaran</h3>
                <div class="col-auto">
                    <select class="form-select" aria-label="Status" id="status" onchange="filterTableByStatus()">
                        <option value="" selected>Status</option>
                        <option value="Proses">Proses</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Kirim Surat Bebas Saksi">Kirim Surat</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover" id="tableIni">
                    <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start-3 col-1">No</th>
                        <th class="border-0">Pelanggaran</th>
                        <th class="border-0 col-2">Tingkat</th>
                        <th class="border-0 col-2">Tanggal</th>
                        <th class="border-0 col-2">Status</th>
                        <th class="border-0 rounded-end-3 col-1">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (isset($model['data']['listPelanggaran'])) {
                        $no = 1;
                        foreach ($model['data']['listPelanggaran'] as $pelanggaran) {
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>$pelanggaran->pelanggaran</td>";
                            if ($pelanggaran->tingkat == 1) {
                                echo "<td>I</td>";
                            } else if ($pelanggaran->tingkat == 2) {
                                echo "<td>II</td>";
                            } else if ($pelanggaran->tingkat == 3) {
                                echo "<td>III</td>";
                            } else if ($pelanggaran->tingkat == 4) {
                                echo "<td>IV</td>";
                            } else {
                                echo "<td>V</td>";
                            }
                            echo "<td>$pelanggaran->tanggal</td>";
                            echo "<td>";
                            if ($pelanggaran->status == true) {
                                echo "<button class='alert alert-success m-0 p-1 small' disabled>Selesai</button>";
                            } else if ($pelanggaran->status == false && $pelanggaran->kirimDokumenStatus == true) {
                                echo "<button class='alert alert-warning m-0 p-1 small' disabled>Proses</button>";
                            } else {
                                echo "<button class='alert alert-info m-0 p-1 small' data-bs-toggle='modal' data-bs-target='#uploadbebassanksi' onclick='changePelanggaranId($pelanggaran->id)'>Kirim Surat Bebas Saksi</button>";
                            }
                            echo "</td>";
                            echo "<td>";
                            echo "<button class='btn btn-sm btn-outline-primary' data-bs-toggle='modal' data-bs-target='#detailPelanggaranMahasiswa' onclick='getDetailPelanggaran($pelanggaran->id)'>Detail</button>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <!-- Modal Detail-->
                <div
                        class="modal fade"
                        id="detailPelanggaranMahasiswa"
                        data-bs-backdrop="static"
                        data-bs-keyboard="false"
                        tabindex="-1"
                        aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailPelanggaranLabel">Detail Pelanggaran</h5>
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
                                <!--                                <button class="alert alert-info" id="downloadDokumen">-->
                                <!--                                    <i class="bi bi-file-earmark"></i>-->
                                <!--                                    Download Dokumen-->
                                <!--                                </button>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Upload dokumen-->
                <div
                        class="modal fade"
                        id="uploadbebassanksi"
                        tabindex="-1"
                        aria-labelledby="uploadbebassanksiLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadbebassanksiLabel">Upload Surat Bebas Saksi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form enctype="multipart/form-data" id="kirimbebassanksi">
                                <div class="modal-body">
                                    <label for="formFile" class="form-label">Upload File</label>
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="pelanggaranId" name="pelanggaranId" value="">
                                        <input class="form-control" type="file" id="inputbebassanksi"
                                               name="inputbebassanksi">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="kirimbebassanksi">Kirim
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>

    $(document).ready(function () {
        let table = $('#tableIni').DataTable();

        window.filterTableByStatus = function () {
            let status = $('#status').val();
            table.column(4).search(status).draw();
        };
    });

    $(document).ready(function () {
        $('#tableIni').DataTable();
    });

    $(document).ready(function () {
        $('#kirimbebassanksi').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '<?php echo APP_URL ?>/mahasiswa/pelanggaran/kirimbebassanksi',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // response = JSON.parse(response);
                    // if (response.status === 'success') {
                    //     alert(response.message);
                    alert('Surat bebas saksi berhasil dikirim');
                    $('#uploadbebassanksi').modal('hide');
                    $('inputbebassanksi').val('');

                    window.location.reload();
                    //
                    // } else {
                    //     alert(response.message);
                    // }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });

    function getDetailPelanggaran(id) {
        $.ajax({
            url: '<?php echo APP_URL ?>/mahasiswa/pelanggaran/getdetail?id=' + id,
            type: 'GET',
            success: function (response) {
                response = JSON.parse(response);
                let data = response.data;
                if (response.status === 'OK') {
                    $('#detailNIM').text(data.nim);
                    $('#detailNamaPelanggar').text(data.nama);
                    $('#detailKelas').text(data.kelas);
                    $('#detailTanggal').text(data.tanggal);
                    $('#detailPelanggaran').text(data.pelanggaran);
                    $('#detailTingkat').text(data.tingkat);
                    $('#detailSanksi').text(data.sanksi);
                    $('#detailBukti').attr('src', '<?php echo APP_URL?>/resources/buktipelanggaran/' + data.bukti);
                    $('#detailDeskripsi').text(data.deskripsi);
                    if (data.status === true) {
                        $('#downloadDokumen').show();
                    } else {
                        $('#downloadDokumen').hide();
                    }
                    $('#detailPelanggaranMahasiswa').modal('show');

                    if (data.tingkat != data.tingkatKP) {
                        $('#alertTingkat').removeClass('d-none');
                    } else {
                        $('#alertTingkat').addClass('d-none');
                    }
                } else {
                    alert(response.message);
                }
            }

        });
    }

    function changePelanggaranId(id) {
        $('#pelanggaranId').val(id);
    }
</script>