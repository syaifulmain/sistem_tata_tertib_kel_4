<!--Main layout-->
<main class="mx-lg-3 mb-4">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <div class="row">
                <h3 class="col">Laporan Pelanggaran Mahasiswa</h3>
                <div class="col-auto">
                    <!--                    <button-->
                    <!--                            class="btn btn-primary"-->
                    <!--                            data-bs-toggle="modal"-->
                    <!--                            data-bs-target="#tambahLaporanMahasiswa"-->
                    <!--                    >-->
                    <!--                        Buat Laporan-->
                    <!--                    </button>-->
                    <!--                <select class="form-select" aria-label="Status">-->
                    <!--                    <option selected>Status</option>-->
                    <!--                    <option value="1">One</option>-->
                    <!--                    <option value="2">Two</option>-->
                    <!--                    <option value="3">Three</option>-->
                    <!--                </select>-->
                    <!--                </div>-->
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
                        if (isset($model['data']['listPelanggaranMahasiswa'])) {
                            foreach ($model['data']['listPelanggaranMahasiswa'] as $laporan) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $laporan->nama_mahasiswa ?></td>
                                    <td><?= $laporan->pelanggaran ?></td>
                                    <td>
                                        <?php
                                        if ($laporan->status) {
                                            ?>
                                            <div class="alert alert-success m-0 p-1 small">Selesai</div>
                                            <?php
                                        } else {
                                            ?>
                                            <div class="alert alert-warning m-0 p-1 small">Proses</div>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button
                                                class="btn btn-sm btn-outline-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#detailLaporanMahasiswa"
                                                onclick="getDetailLaporanPelanggaran(<?= $laporan->id ?>)"
                                        >Detail
                                        </button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </tbody>
                    </table>
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
                                    <!--                                <div class="mb-4">-->
                                    <!--                                    <label for="inputDeskripsi" class="form-label">Status</label>-->
                                    <!--                                    <div class="alert alert-warning text-center">Proses</div>-->
                                    <!--                                </div>-->
                                    <input type="hidden" id="detailId">
                                    <div class="mb-4">
                                        <p class="text-secondary mb-1">NIM</p>
                                        <h5 id="detailNIM">1234567890</h5>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-secondary mb-1">Nama Pelanggar</p>
                                        <h5 id="detailNama">Ini Adalah Nama Saya</h5>
                                    </div>
                                    <div class="mb-4">
                                        <p class="text-secondary mb-1">Nama Pelanggar</p>
                                        <h5 id="detailNama">Ini Adalah Nama Pelapor</h5>
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
                                    </div>
                                    <div class="alert alert-warning d-none" role="alert" id="alertTingkat">
                                        Pelanggaran ditingkatkan karena sudah 3 kali melakukan pelanggaran di tingkat yang sama
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
                                    <div class="mb-4">
                                        <label for="" class="form-label">Surat Pernyataan</label>
                                        <img src="https://via.placeholder.com/1000" alt="Bukti" class="img-fluid"
                                             id="detailSurat"
                                             style="max-width: 100%; height: auto;" onclick="showFullImage(this.src)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
<!--                    <nav aria-label="Page navigation">-->
<!--                        <ul class="pagination justify-content-center">-->
<!--                            <li class="page-item disabled">-->
<!--                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>-->
<!--                            </li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">1</a></li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">2</a></li>-->
<!--                            <li class="page-item"><a class="page-link" href="#">3</a></li>-->
<!--                            <li class="page-item">-->
<!--                                <a class="page-link" href="#">Next</a>-->
<!--                            </li>-->
<!--                        </ul>-->
<!--                    </nav>-->
                </div>
            </div>
        </div>
</main>
<!--Main layout-->
<script>
    $(document).ready(function () {
        $('#tableIni').DataTable();
    });


    function getDetailLaporanPelanggaran(id) {
        $.ajax({
            url: `<?php echo APP_URL ?>/dosen/pelanggaran/detail?id=${id}`,
            method: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                data = data.data;
                $('#detailId').val(id);
                $('#detailNIM').text(data.nim);
                $('#detailNama').text(data.namaPelanggar);
                $('#detailTanggal').text(data.tanggal);
                $('#detailPelanggaran').text(data.pelanggaran);
                $('#detailTingkat').text(data.tingkat);
                $('#detailSanksi').text(data.sanksi);
                $('#detailDeskripsi').text(data.deskripsi);
                $('#detailBukti').attr('src', `<?php echo APP_URL ?>/resources/buktipelanggaran/${data.bukti}`);
                if (data.buktiSurat != null) {
                    $('#detailSurat').attr('src', `<?php echo APP_URL ?>/resources/buktipelanggaran/${data.buktiSurat}`);
                } else {
                    $('#detailSurat').attr('src', `https://via.placeholder.com/1000`);
                }
                $('#detailLaporanMahasiswa').modal('show');

                if (data.tingkat != data.tingkatKP) {
                    $('#alertTingkat').removeClass('d-none');
                } else {
                    $('#alertTingkat').addClass('d-none');
                }
            }
        });
    }

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