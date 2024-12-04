
<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <h3>Klasifikasi Pelanggaran</h3>
            <hr>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th class="border-0 rounded-start-3 col-1">No</th>
                        <th class="border-0">Klasifikasi Pelanggaran</th>
                        <th class="border-0 col-1">Tingkat</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain</td>
                        <td>V</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celana pendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, sepatu sandal di lingkungan kampus</td>
                        <td>IV</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Mahasiswa Iaki-laki berambut tidak rapi, gondrong yaitu panjang rarnbutnya melewati batas alis mata di bagian depan, telinga di bagian sarnping atau menyentuh kerah baju di bagian leher</td>
                        <td>IV</td>
                    </tr>
                    </tbody>
                </table>
                <!-- Modal Detail-->
                <div
                    class="modal fade"
                    id="detailPelanggaran"
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
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Nama Pelanggar</p>
                                    <h5>Andi Surya</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">NIM</p>
                                    <h5>1234567890</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Tanggal</p>
                                    <h5>2024-10-10</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Pelapor</p>
                                    <h5>Nama Dosen</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Pelanggaran</p>
                                    <h5>Merokok di tangga</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Tingkat Pelanggar</p>
                                    <h5>III</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Sanksi</p>
                                    <h5>Membuat surat pernyataan</h5>
                                </div>
                                <div class="mb-4">
                                    <p class="text-secondary mb-1">Status</p>
                                    <h5>Diproses</h5>
                                </div>
                                <button class="alert alert-info">
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
                    id="uploadDokumen"
                    tabindex="-1"
                    aria-labelledby="uploadDokumenLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="uploadDokumenLabel">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="formFile" class="form-label">Upload File</label>
                                <div class="input-group mb-3">
                                    <input class="form-control" type="file" id="formFile">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Kirim</button>
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