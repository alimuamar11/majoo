<div class="row">
    <?php
    foreach ($detail_produk as $dt) {
    ?>
        <div class="col-lg-3 col-md-6 col-sm-12 ">
            <div class="card card-majoo bd-0 border">
                <img class="card-fluid" src="<?= base_url('assets/img/' . $dt->image . ''); ?>" alt="Image">
                <div class="card-body ">
                    <h5 class="card-title text-center"><?= $dt->nama ?></h5>
                    <h6 class="text-center"><b><?= number_format($dt->harga); ?> </b></h6>
                    <p class="card-text "><?= $dt->deskripsi ?></p>

                </div>
                <div class="card-footer text-center"><a href="#" class="btn-sm btn-primary">Beli</a></div>
            </div>
        </div><!-- col-4 -->

    <?php
    }
    ?>
</div>