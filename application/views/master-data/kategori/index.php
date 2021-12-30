<div class="row">
    <section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card card-dashboard-one">
            <div class="card-header border c-header-large">
                <div class="card-title">
                    Tabel Kategori
                </div>

                <div class="pull-right">
                    <button type="button" class="btn btn-success add-kategori btn-xs"><i class="fa fa-plus"></i> Tambah data</button>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered dataTable table-striped minimize-padding-all" id="kategori" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th><?= lang('label_nomor'); ?> </th>
                            <th><?= lang('label_nama'); ?> </th>
                            <th><?= lang('label_action'); ?></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div id="modal-manage-kategori" class="modal">
    <div class="modal-dialog" role="document">
        <form method="POST" name="form-manage-kategori">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">Add/Update Data</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label"><?= lang('label_nama'); ?></label>
                                <input type="text" class="form-control input-sm" name="nama_kategori" autocomplete="off" id="nama_kategori" placeholder="<?= lang('label_nama'); ?>">
                            </div>
                        </div>
                    </div>
                    <input type="text" class="hide" name="_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="save-produk" class="btn btn-indigo"><i class="fa fa-save"></i> <?= lang('label_save'); ?></button>
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal"><?= lang('label_close'); ?></button>
                </div>
            </div>
        </form>
    </div><!-- modal-dialog -->
</div><!-- modal -->