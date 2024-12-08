<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="mb-4" style="background-color: #F9FAFB;">
            <div class="row">

                <div class="col-8">

                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between">
                            <div class="card-title h2">Chart Pelanggaran</div>
                            <div class="card-title h4">
                                <img src="<?php echo APP_URL ?>/assets/image/kotak.png" class="mb-3 ">
                                <span>Pelanggaran</span>
                            </div>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>

                    <img src="kotak.png" alt="">

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                    <script>
                        const ctx = document.getElementById('myChart');

                        // Set maximum height dynamically
                        ctx.style.maxHeight = '230px';

                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                                datasets: [{
                                    label: 'Pelanggaran',
                                    data: [30, 45, 90, 70, 80, 100],
                                    borderColor: 'orange',
                                    backgroundColor: 'transparent',
                                    borderWidth: 2,
                                    tension: 0.4,
                                    pointRadius: 0
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false, // Disable aspect ratio to allow full control
                                plugins: {
                                    legend: {
                                        display: false,
                                    }
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false,
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        max: 100, // Set maximum Y-axis value to fit within the desired height
                                        grid: {
                                            drawBorder: false,
                                        },
                                        ticks: {
                                            stepSize: 50,
                                            maxTicksLimit: 3,
                                        }
                                    }
                                }
                            }
                        });
                    </script>

                </div>

                <div class="col-4">
                    <div class="col mb-lg-0 mb-sm-2">
                        <div class="card border-0 p-3 rounded bg-white mb-4">
                            <div class="d-flex align-items-center">
                                <!-- Icon container -->
                                <div class="d-flex justify-content-center align-items-center rounded bg-danger bg-opacity-10 p-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-person fs-4" style="text-color: #FFFAEB"></i>
                                </div>
                                <!-- Text content -->
                                <div class="ms-3">
                                    <p class="mb-0 text-muted small">Total Pelanggaran Semester Ini</p>
                                    <h3 class="mb-0 fw-bold text-dark">20</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-lg-0 mb-sm-2">
                        <div class="card border-0 p-3 rounded bg-white mb-4">
                            <div class="d-flex align-items-center">
                                <!-- Icon container -->
                                <div class="d-flex justify-content-center align-items-center rounded bg-info bg-opacity-10 p-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-person fs-4" style="text-color: #FFFAEB"></i>
                                </div>
                                <!-- Text content -->
                                <div class="ms-3">
                                    <p class="mb-0 text-muted small">Total Pelanggaran Semester Ini</p>
                                    <h3 class="mb-0 fw-bold text-dark">20</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-lg-0 mb-sm-2">
                        <div class="card border-0 p-3 rounded bg-white mb-4">
                            <div class="d-flex align-items-center">
                                <!-- Icon container -->
                                <div class="d-flex justify-content-center align-items-center rounded bg-warning bg-opacity-10 p-2"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi bi-person fs-4" style="text-color: #FFFAEB"></i>
                                </div>
                                <!-- Text content -->
                                <div class="ms-3">
                                    <p class="mb-0 text-muted small">Total Pelanggaran Semester Ini</p>
                                    <h3 class="mb-0 fw-bold text-dark">20</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <h3>Pelanggaran Terbaru</h3>
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
                        <tr>
                            <td>1</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>

                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>

                                <button class="alert alert-info m-0 p-1 small" data-bs-toggle="modal"
                                    data-bs-target="#uploadDokumen">Upload dokumen
                                </button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>11</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>12</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>13</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>14</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>15</td>
                            <td>Merokok di tangga</td>
                            <td>III</td>
                            <td>2024-10-10</td>
                            <td>
                                <button class="alert alert-warning m-0 p-1 small" disabled>Proses</button>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#detailPelanggaran">Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Modal Detail-->
                <div class="modal fade" id="detailPelanggaran" data-bs-backdrop="static" data-bs-keyboard="false"
                    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                <div class="modal fade" id="uploadDokumen" tabindex="-1" aria-labelledby="uploadDokumenLabel"
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