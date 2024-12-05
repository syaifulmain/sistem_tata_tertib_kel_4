<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <h3>Daftar Pelanggaran</h3>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover">
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
                                echo "<button class='alert alert-info m-0 p-1 small' data-bs-toggle='modal' data-bs-target='#uploadSuratPernyataan' onclick='changePelanggaranId($pelanggaran->id)'>Kirim Surat Pernyataan</button>";
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
                    <!--                    <tr>-->
                    <!--                        <td>1</td>-->
                    <!--                        <td>Merokok di tangga</td>-->
                    <!--                        <td>III</td>-->
                    <!--                        <td>2024-10-10</td>-->
                    <!---->
                    <!--                        <td>-->
                    <!--                            <button class="alert alert-success m-0 p-1 small" disabled>Selesai</button>-->
                    <!--                        </td>-->
                    <!--                        <td>-->
                    <!--                            <button-->
                    <!--                                    class="btn btn-sm btn-outline-primary"-->
                    <!--                                    data-bs-toggle="modal"-->
                    <!--                                    data-bs-target="#detailPelanggaran"-->
                    <!--                            >Detail-->
                    <!--                            </button>-->
                    <!--                        </td>-->
                    <!--                    </tr>-->
                    </tbody>
                </table>
                <?php
                if (isset($model['data']['listPelanggaran']) && count($model['data']['listPelanggaran']) == 0) {
                    echo "<div class='text-center'>Tidak ada data</div>";
                }
                ?>
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
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Tingkat Pelanggar</p>
                                    <h5 id="detailTingkat">Ringan</h5>
                                    <!--                                    <h5 id="detailTingkat">-->
                                    <!--                                        <select class="form-select" aria-label="Tingkat Pelanggar">-->
                                    <!--                                            <option selected>Pilih Tingkat</option>-->
                                    <!--                                            <option value="1">Tingkat 1</option>-->
                                    <!--                                            <option value="2">Tingkat 2</option>-->
                                    <!--                                        </select>-->
                                    <!--                                    </h5>-->

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
                                <button class="alert alert-info" id="downloadDokumen">
                                    <i class="bi bi-file-earmark"></i>
                                    Download Dokumen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Upload dokumen-->
                <div
                        class="modal fade"
                        id="uploadSuratPernyataan"
                        tabindex="-1"
                        aria-labelledby="uploadSuratPernyataanLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadSuratPernyataanLabel">Upload Surat Pernytaan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form enctype="multipart/form-data" id="kirimSuratPernyataan">
                                <div class="modal-body">
                                    <label for="formFile" class="form-label">Upload File</label>
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="pelanggaranId" name="pelanggaranId" value="">
                                        <input class="form-control" type="file" id="inputSuratPernyataan"
                                               name="inputSuratPernyataan">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" id="kirimSuratPernyataan">Kirim
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
        $('#kirimSuratPernyataan').submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: '<?php echo APP_URL ?>/mahasiswa/pelanggaran/kirimsuratpernyataan',
                type: 'POST',
                data: formData,
                success: function (response) {
                    // response = JSON.parse(response);
                    // if (response.status === 'success') {
                    //     alert(response.message);
                    alert('Surat pernyataan berhasil dikirim');
                    $('#uploadSuratPernyataan').modal('hide');
                    $('inputSuratPernyataan').val('');

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
                if (response.status === 'OK') {
                    $('#detailNIM').text(response.data.nim);
                    $('#detailNamaPelanggar').text(response.data.nama);
                    $('#detailKelas').text(response.data.kelas);
                    $('#detailTanggal').text(response.data.tanggal);
                    $('#detailPelanggaran').text(response.data.pelanggaran);
                    $('#detailTingkat').text(response.data.tingkat);
                    $('#detailSanksi').text(response.data.sanksi);
                    $('#detailBukti').attr('src', '<?php echo APP_URL?>/resources/buktipelanggaran/' + response.data.bukti);
                    $('#detailDeskripsi').text(response.data.deskripsi);
                    if (response.data.status === true) {
                        $('#downloadDokumen').show();
                    } else {
                        $('#downloadDokumen').hide();
                    }
                    $('#detailPelanggaranMahasiswa').modal('show');
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