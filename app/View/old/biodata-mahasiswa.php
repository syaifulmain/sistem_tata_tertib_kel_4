<!-- Main content starts here -->

<h1>Biodata Mahasiswa</h1>
<div class="row row-cols-1 row-cols-lg-2">
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Nama Mahasiswa</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->nama_lengkap;  ?></div>
    </div>
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">NIK</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->nik;  ?></div>
    </div>
</div>
<div class="row row-cols-1 row-cols-lg-2">
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Kota Lahir</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->kota_lahir;  ?></div>
    </div>
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Tanggal Lahir</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->tanggal_lahir;  ?></div>
    </div>
</div>
<div class="row row-cols-1 row-cols-lg-2">
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Agama</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->agama;  ?></div>
    </div>
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Jenis Kelamin</div>
        <div class="col py-2 py-lg-0"><?php echo ($model['data']->jenis_kelamin == "L") ? "Laki-laki" : "Perempuan";  ?></div>
    </div>
</div>
<div class="row row-cols-1 row-cols-lg-2">
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Golongan Darah</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->golongan_darah;  ?></div>
    </div>
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Anak ke</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->anak_ke;  ?></div>
    </div>
</div>
<div class="row row-cols-1 row-cols-lg-2">
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">No Telpon</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->no_telepon;  ?></div>
    </div>
    <div class="col row mb-4">
        <div class="col-lg-3 text-lg-end">Email</div>
        <div class="col py-2 py-lg-0"><?php echo $model['data']->email;  ?></div>
    </div>
</div>
<!-- Main content ends here -->

