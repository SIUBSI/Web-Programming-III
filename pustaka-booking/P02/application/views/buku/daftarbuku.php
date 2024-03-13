<?= $this->session->flashdata('pesan'); ?>

<div style="padding: 25px;">
    <div class="x_panel">
        <div class="x_content">
        <!-- Tampilkan semua produk -->
            <div class="row">
            <!-- looping products -->
                <?php foreach ($buku as $buku) { ?>
                <div class="col-md-2 col-md-3" style="margin-bottom:50px;">
                    <div class="thumbnail" style="height: 370px;">
                        <img src="<?php echo base_url('assets/img/upload/') . $buku->image; ?>" style="max-width:100%; max-height: 100%; height: 200px; width: 150px; border: 1px solid black; border-radius: 10px; padding: 5px;">
                        <div class="caption">
                            <h5 style="margin-top:10px;"><?= $buku->judul_buku ?></h5>
                            <h5 style="display:inline-block;background-color:salmon;padding:5px;border-radius:10px;font-size:16px;color:white;"><?= $buku->penerbit ?></h5>
                            <h5 style="display:inline-block;background-color: salmon;padding:5px;border-radius:10px;font-size:16px;color:white;"><?= $buku->pengarang ?></h5>
                            <h5 style="display:inline-block;background-color: blue;padding:5px;border-radius:10px;font-size:14px;color:white;"><?= substr($buku->tahun_terbit, 0, 4) ?></h5><p>
                            <?php
                            if ($buku->stok < 1) 
                            {
                                echo "<i class='btn btn-outline-primary fas fw fa-shopping-cart'> Booking&nbsp;&nbsp 0</i>";
                            } else {
                                echo "<a class='btn btn-outline-primary fas' style='font-family:arial;font-size:14px;' href='" . base_url('booking/tambahBooking/' . $buku->id) . "'> Booking</a>";
                            }
                            ?>
                            <a class="btn btn-outline-warning fas" style='font-family:arial;font-size:14px;' href="<?= base_url('home/detailBuku/' . $buku->id); ?>"> Detail</a></p>
                        </div>
                    </div>
                </div> 
                <?php } ?>
            <!-- end looping -->
            </div>
        </div>
    </div>
</div>