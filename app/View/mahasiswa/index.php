<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="mb-4" style="background-color: #F9FAFB;">
            <div class="col">
                <div class="row row-cols-1 row-cols-lg-2">
                    <div class="col mb-lg-0 mb-sm-2">
                        <div class="card border-0 p-3 rounded bg-white mb-2">
                            <div class="d-flex align-items-center">
                                <!-- Icon container -->
                                <div class="d-flex justify-content-center align-items-center rounded bg-info bg-opacity-10 p-2"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-person fs-4" style="text-color: #FFFAEB"></i>
                                </div>
                                <!-- Text content -->
                                <div class="ms-3">
                                    <p class="mb-0 text-muted small">Total Pelanggaran Tahun Ini</p>
                                    <h3 class="mb-0 fw-bold text-dark" id="tahunini">20</h3>
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
                                    <p class="mb-0 text-muted small">Total Pelanggaran Keseluruhan</p>
                                    <h3 class="mb-0 fw-bold text-dark" id="keseluruhan">20</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col  mb-4">
                    <div class="card p-3 border-0">
                        <div class="d-flex justify-content-between">
                            <div class="card-title h2">Pelanggaran <span id="detailtahun">xxxx</span></div>
                            <div class="card-title h4">
                                <select class="form-select" aria-label="Tahun" id="pilihTahun">
                                    <option value="2023">2023</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    let chartInstance;

    $(document).ready(function () {
        const tahunSekarang = new Date().getFullYear();
        $.ajax({
            url: '<?php echo APP_URL ?>/mahasiswa/alltahun',
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                $('#pilihTahun').append(`<option value="${tahunSekarang}" selected>${tahunSekarang}</option>`);
                data.data.forEach(tahun => {
                    if (tahun != tahunSekarang) {
                        $('#pilihTahun').append(`<option value="${tahun}">${tahun}</option>`);
                    }
                });
            },
        })

        updateChart(tahunSekarang);
    });

    $('#pilihTahun').change(function () {
        const tahun = $(this).val();
        if (chartInstance) {
            chartInstance.destroy();
        }
        updateChart(tahun);
    });

    function updateChart(tahun) {
        const ctx = document.getElementById('myChart');
        ctx.style.maxHeight = '230px';
        $.ajax({
            url: '<?php echo APP_URL ?>/mahasiswa/laporanpertahun?tahun=' + tahun,
            type: 'GET',
            success: function (response) {
                let data = JSON.parse(response);
                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                        datasets: [{
                            label: 'Pelanggaran',
                            data: data.data.tahun,
                            borderColor: 'orange',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
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
                                grid: {
                                    drawBorder: false,
                                },
                            }
                        }
                    }
                });
                let tahunIni = data.data.tahun.reduce((a, b) => a + b, 0);
                $('#tahunini').text(tahunIni);
                $('#keseluruhan').text(data.data.total);
                $('#detailtahun').text(tahun);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
</script>