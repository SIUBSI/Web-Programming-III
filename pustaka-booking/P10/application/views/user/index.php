<!-- Begin Page Content -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 justify-content-x">
            <?= $this->session->flashdata('pesan'); ?>
        </div>
    </div>
    <?php foreach ($anggota as $usr) { ?>
    <div class="card mb-5 mr-5" style="max-width: 400px; display: inline-block;">
        <div class="row no-gutters">
            <div class="col-md-12">
                <img src="<?= base_url('assets/img/profile/') . $usr['image']; ?>" class="card-img" alt="...">
            </div>
            <div class="col-md-12">
                <div class="card-body">
                    <h5 class="card-title"><?= $usr['nama'];?></h5>
                    <p class="card-text"><?= $usr['email']; ?></p>
                    <p class="card-text"><small class="textmuted">Daftar sejak: <br><b><?= date('d F Y',$usr['tanggal_input']); ?></b></small></p>
                    <div class="btn btn-md btn-primary">
                        <a href="<?= base_url('user/ubahprofil/') . $usr['id']; ?>" style="text-decoration:none;" class="text text-white"><i class="fas fa-user-edit"></i> Perbarui data profil</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->