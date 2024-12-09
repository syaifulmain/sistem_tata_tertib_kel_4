<!--Main layout-->
<main class="mx-lg-3 mb-4 mt-5 mt-lg-0">
    <div class="container-fluid pt-4">
        <div class="bg-white rounded-2 p-3" style="min-height: 500px">
            <h4>Profil</h4>
            <hr>
            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col row mb-4">
                    <div class="col-lg-3 text-lg-end">Nama Mahasiswa</div>
                    <div class="col py-2 py-lg-0"><?php echo $model['data']['profil']->nama?></div>
                </div>
                <div class="col row mb-4">
                    <div class="col-lg-3 text-lg-end">NIM</div>
                    <div class="col py-2 py-lg-0"><?php echo $model['data']['profil']->username?></div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col row mb-4">
                    <div class="col-lg-3 text-lg-end">No Telpon</div>
                    <div class="col py-2 py-lg-0"><?php echo $model['data']['profil']->noHp?></div>
                </div>
                <div class="col row mb-4">
                    <div class="col-lg-3 text-lg-end">Email</div>
                    <div class="col py-2 py-lg-0"><?php echo $model['data']['profil']->email?></div>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-2">
                <div class="col row mb-4">
                    <div class="col-lg-3 text-lg-end">DPA Kelas</div>
                    <div class="col py-2 py-lg-0"><?php echo $model['data']['profil']->kelas?></div>
                </div>
            </div>
<!--            <h4>User</h4>-->
<!--            <hr>-->
        </div>
    </div>
</main>