<!--Main layout-->
<main class="mx-lg-3 mb-4" style="margin-top: 58px">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <div class="row">
                <h3 class="col">Mahasiswa</h3>
                <div class="col-auto">
                    <button
                            class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#tambahMahasiswa"
                    >
                        Tambah
                    </button>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start-3 col-1">No</th>
                        <th class="border-0 col-2">NIM</th>
                        <th class="border-0">Nama</th>
                        <th class="border-0 col-2">No Telepon</th>
                        <th class="border-0 col-1"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    foreach ($model['mahasiswaList'] as $mahasiswa) {
                        ?>
                        <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $mahasiswa->nim ?></td>
                            <td><?php echo $mahasiswa->nama_lengkap ?></td>
                            <td><?php echo $mahasiswa->no_telepon ?></td>
                            <td>
                                <button
                                        class="btn btn-sm btn-outline-info"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailMahasiswa"
                                >Detail
                                </button>
                            </td>
                        </tr>
                        <?php
                    }
                    if ($no === 1) {
                        ?>
                        <tr>
                            <td colspan="5" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
                <!-- Modal tambah-->
                <div
                        class="modal fade"
                        id="tambahMahasiswa"
                        data-bs-backdrop="static"
                        tabindex="-1"
                        aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahMahasiswaLabel">Detail Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form>
                                <div class="modal-body">
                                    <div id="alertDiv" class="mb-4 alert d-none alert-danger text-center"
                                         role="alert">
                                    </div>
                                    <div class="mb-4">
                                        <label for="nim" class="form-label text-secondary">NIM</label>
                                        <input type="text" class="form-control" id="nim" name="nim">
                                        <span id="nimError" class="text-danger d-none">Nim tidak boleh kosong</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="nama" class="form-label text-secondary">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama">
                                        <span id="namaError" class="text-danger d-none">Nama tidak boleh kosong</span>
                                    </div>
                                    <div class="mb-4">
                                        <label for="noTelp" class="form-label text-secondary">No Telepon</label>
                                        <input type="text" class="form-control" id="noTelp" name="noTelp">
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label text-secondary">Email</label>
                                        <input type="email" class="form-control shadow-none" id="email" name="email">
                                    </div>
                                    <label for="kelas" class="form-label text-secondary">Kelas</label>
                                    <select class="mb-4 form-select" aria-label="Select an option" name="kelas"
                                            id="kelas">
                                        <option selected></option>
                                        <option value="2A">2A</option>
                                        <option value="2B">2B</option>
                                        <option value="2C">2C</option>
                                    </select>
                                    <span id="kelasError" class="text-danger d-none">Kelas tidak boleh kosong</span>
                                </div>
                                <div class="modal-footer">
                                    <button class="col btn btn-success" type="button" id="submitBtn">Simpan</button>
                                </div>
                            </form>
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
                <!-- Modal Detail-->
                <div
                        class="modal fade"
                        id="detailMahasiswa"
                        data-bs-backdrop="static"
                        tabindex="-1"
                        aria-labelledby="staticBackdropLabel"
                        aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailMahasiswaLabel">Detail Mahasiswa</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">NIM</p>
                                    <h5>1234567890</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Nama Pelanggar</p>
                                    <h5>Andi Surya</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">No Telepon</p>
                                    <h5>0987654321</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Email</p>
                                    <h5>Example@example.com</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Kelas</p>
                                    <h5>2A</h5>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Username</p>
                                    <h5>0987654321</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Password</p>
                                    <h5>Example@example.com</h5>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="col btn btn-danger">Hapus</button>
                                <button class="col btn btn-success">Simpan</button>
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
    $('#nim, #nama, #kelas').on('change', function () {
        let errorId = $(this).attr('id') + 'Error';
        $('#' + errorId).toggleClass('d-none', $(this).val().trim() !== '');
    });

    $('#submitBtn').on('click', function () {
        let isValid = true;
        $('#nim, #nama, #kelas').each(function () {
            let errorId = $(this).attr('id') + 'Error';
            if ($(this).val().trim() === '') {
                $('#' + errorId).removeClass('d-none');
                isValid = false;
            } else {
                $('#' + errorId).addClass('d-none');
            }
        });

        if (isValid) {
            $('#alertDiv').addClass('d-none');
            $.ajax({
                url: '<?php echo APP_URL?>/admin/mahasiswa/tambah',
                method: 'POST',
                data: {
                    nim: $('#nim').val(),
                    nama: $('#nama').val(),
                    noTelp: $('#noTelp').val(),
                    email: $('#email').val(),
                    kelas: $('#kelas').val()
                },
                success: function (response) {
                    $('#tambahMahasiswa').modal('hide');
                    $('#tambahMahasiswa form')[0].reset();
                    // alert('Mahasiswa berhasil ditambahkan');
                    location.reload();
                },
                error: function (response) {
                    let error = JSON.parse(response.responseText);
                    // alert(error['error']);
                    $('#alertDiv').text(error['error']);
                    $('#alertDiv').removeClass('d-none');
                }
            });
        }
    });

    $('#detailMahasiswa').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let nim = button.closest('tr').find('td:eq(1)').text();
        $.ajax({
            url: '<?php echo APP_URL?>/admin/mahasiswa/detail',
            method: 'POST',
            data: {
                nim: nim
            },
            success: function (response) {
                let mahasiswa = JSON.parse(response);
                $('#detailMahasiswa .modal-body h5:eq(0)').text(mahasiswa.data.nim);
                $('#detailMahasiswa .modal-body h5:eq(1)').text(mahasiswa.data.nama_lengkap);
                $('#detailMahasiswa .modal-body h5:eq(2)').text(mahasiswa.data.$no_telepon);
                $('#detailMahasiswa .modal-body h5:eq(3)').text(mahasiswa.data.email);
                $('#detailMahasiswa .modal-body h5:eq(4)').text(mahasiswa.data.kelas);
                $('#detailMahasiswa .modal-body h5:eq(5)').text(mahasiswa.data.nim);
                $('#detailMahasiswa .modal-body h5:eq(6)').text(mahasiswa.data.password);
            },
            error: function (response) {
                let error = JSON.parse(response.responseText);
                alert(error['error']);
            }
        });
    });
</script>