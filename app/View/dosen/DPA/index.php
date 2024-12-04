<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
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
                <select class="form-select" aria-label="Status">
                    <option selected>Status</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover">
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
                    <tr>
                        <td>1</td>
                        <td>1234567890</td>
                        <td>Ini Adalah Nama Saya</td>
                        <td>
                            <div class="alert alert-warning m-0 p-1 small">Proses</div>
                        </td>

                        <td>
                            <button
                                    class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailLaporanMahasiswa"
                            >Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1234567890</td>
                        <td>Ini Adalah Nama Saya</td>
                        <td>
                            <div class="alert alert-danger m-0 p-1 small">Batal</div>
                        </td>

                        <td>
                            <button
                                    class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailLaporanMahasiswa"
                            >Detail
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>1234567890</td>
                        <td>Ini Adalah Nama Saya</td>
                        <td>
                            <div class="alert alert-success m-0 p-1 small">Dikirm</div>
                        </td>

                        <td>
                            <button
                                    class="btn btn-sm btn-outline-info"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detailLaporanMahasiswa"
                            >Detail
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- Modal tambah laporan mahasiswa-->
<!--                <div-->
<!--                        class="modal fade"-->
<!--                        id="tambahLaporanMahasiswa"-->
<!--                        data-bs-backdrop="static"-->
<!--                        tabindex="-1"-->
<!--                        aria-labelledby="staticBackdropLabel"-->
<!--                        aria-hidden="true">-->
<!--                    <div class="modal-dialog modal-dialog-centered">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-header">-->
<!--                                <h5 class="modal-title" id="tambahLaporanMahasiswaLabel">Lapor Mahasiswa</h5>-->
<!--                                <button type="button" class="btn-close" data-bs-dismiss="modal"-->
<!--                                        aria-label="Close"></button>-->
<!--                            </div>-->
<!--                            <div class="modal-body">-->
<!--                                <div class="mb-4">-->
<!--                                    <label for="inputNIM" class="form-label">NIM</label>-->
<!--                                    <input type="text" class="form-control" id="inputNIM">-->
<!--                                </div>-->
<!--                                <div class="mb-4">-->
<!--                                    <label for="inputNama" class="form-label">Nama</label>-->
<!--                                    <input type="text" class="form-control disabled" id="inputNama" disabled>-->
<!--                                </div>-->
<!--                                <div class="mb-4">-->
<!--                                    <label for="inputTanggal" class="form-label">Tanggal</label>-->
<!--                                    <input type="date" class="form-control" id="inputTanggal">-->

<!--                                </div>-->
<!--                                <div class="mb-4">-->
<!--                                    <label for="select-state" class="form-label">Pelanggaran</label>-->
<!--                                    <select id="select-state" placeholder="Cari Barang" class="my-form-control">-->
<!--                                        <option value="">Select your country</option>-->
<!--                                        <option value="US">United States of America</option>-->
<!--                                        <option value="KE">Kenya</option>-->
<!--                                        <option value="UK">United Kingdom</option>-->
<!--                                        <option value="IN">India</option>-->
<!--                                        <option value="CN">China</option>-->
<!--                                        <option value="CA">Canada</option>-->
<!--                                        <option value="RU">Russia</option>-->
<!--                                        <option value="DE">Germany</option>-->
<!--                                        <option value="ZA">South Africa</option>-->
<!--                                        <option value="BR">Brazil</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                                <div class="mb-4">-->
<!--                                    <label for="inputBukti" class="form-label">Upload Bukti</label>-->
<!--                                    <input type="file" class="form-control" id="inputBukti">-->
<!--                                </div>-->
<!--                                <div class="mb-4">-->
<!--                                    <label for="inputDeskripsi" class="form-label">Deskripsi</label>-->
<!--                                    <textarea class="form-control" id="inputDeskripsi" rows="3"></textarea>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="modal-footer">-->
<!--                                <button class="col btn btn-success">Kirim</button>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
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
                                <!--                                <div class="mb-4">-->
                                <!--                                    <label for="inputDeskripsi" class="form-label">Status</label>-->
                                <!--                                    <div class="alert alert-warning text-center">Proses</div>-->
                                <!--                                </div>-->
                                <div class="mb-4">
                                    <label for="inputNIM" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="inputNIM" value="asdfdsfasdfads">
                                </div>
                                <div class="mb-4">
                                    <label for="inputNama" class="form-label">Nama</label>
                                    <input type="text" class="form-control disabled" id="inputNama" disabled>
                                </div>
                                <div class="mb-4">
                                    <label for="inputNama" class="form-label">Pelapor</label>
                                    <input type="text" class="form-control disabled" id="inputNama" disabled>
                                </div>
                                <div class="mb-4">
                                    <label for="inputTanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="inputTanggal">

                                </div>
                                <div class="mb-4">
                                    <label for="select-state-test" class="form-label">Pelanggaran</label>
                                    <select id="select-state-test" placeholder="Cari " class="my-form-control">
                                        <option value="">Select your country</option>
                                        <option value="US">United States of America</option>
                                        <option value="KE">Kenya</option>
                                        <option value="UK">United Kingdom</option>
                                        <option value="IN">India</option>
                                        <option value="CN">China</option>
                                        <option value="CA">Canada</option>
                                        <option value="RU">Russia</option>
                                        <option value="DE">Germany</option>
                                        <option value="ZA">South Africa</option>
                                        <option value="BR">Brazil</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="inputBukti" class="form-label">Sanksi</label>
                                    <input type="text" class="form-control" id="inputBukti">
                                </div>
                                <div class="mb-4">
                                    <label for="inputBukti" class="form-label">Upload Bukti</label>
                                    <input type="file" class="form-control" id="inputBukti">
                                </div>
                                <div class="mb-4">
                                    <label for="inputDeskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="inputDeskripsi" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="col btn btn-danger">Batal</button>
                                <button class="col btn btn-success">Kirim</button>
                            </div>
                        </div>
                    </div>
                </div>
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
            </div>
        </div>
    </div>
</main>
<!--Main layout-->
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