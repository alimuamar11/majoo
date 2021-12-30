<div class="row">
	<section class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card card-dashboard-one">
			<div class="card-header border c-header-large">
				<div class="card-title">
					Tabel Produk
				</div>

				<div class="pull-right">
					<button type="button" class="btn btn-success add-produk btn-xs"><i class="fa fa-plus"></i> Tambah data</button>
				</div>
			</div>
			<div class="card-body">
				<table class="table table-bordered dataTable table-striped minimize-padding-all" id="produk" role="grid" aria-describedby="dataTable_info" style="width: 100%;" width="100%" cellspacing="0">
					<thead>
						<tr role="row">
							<th><?= lang('label_nomor'); ?> </th>
							<th><?= lang('label_nama'); ?> </th>
							<th><?= lang('label_deskripsi'); ?> </th>
							<th><?= lang('label_harga'); ?> </th>
							<th><?= lang('label_kategori'); ?> </th>
							<th><?= lang('label_gambar'); ?> </th>
							<th><?= lang('label_action'); ?></th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
</div>

<div id="modal-manage-produk" class="modal">
	<div class="modal-dialog" role="document">
		<form method="POST" name="form-manage-produk" enctype="multipart/form-data">
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
								<input type="text" class="form-control input-sm" name="nama" autocomplete="off" id="nama" placeholder="<?= lang('label_nama'); ?>">
							</div>
						</div>
					</div>
					<div class="row">

						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="form-group">
								<label class="form-label"><?= lang('label_deskripsi'); ?></label>
								<textarea class="form-control" rows="2" cols="100" name="deskripsi" autocomplete="off" id="deskripsi" placeholder="<?= lang('label_deskripsi'); ?>"></textarea>

							</div>
						</div>

					</div>
					<div class="row">

						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="form-group">
								<label class="form-label"><?= lang('label_harga'); ?></label>
								<input type="text" class="form-control input-sm" name="harga" autocomplete="off" id="harga" placeholder="<?= lang('label_harga'); ?>">
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12">
							<div class="form-group">
								<label class="form-label"><?= lang('label_kategori'); ?></label>
								<div class="d-grid gap-2 d-md-flex ">
									<select id="kategori" class="form-control select2-no-search" name="fk_kategori" style="width:100%;">
										<option value=''></option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Image</label>
							</div>
							<div class="form-group">
								<input type="file" name="file">
							</div>
						</div>
						<div class="row">
							<div class="col-sm-4 col-md-offset-4" id="uploaded_image">
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




<div id="modal-manage-gambar" class="modal">
	<div class="modal-dialog modal-lg" role="document">
		<form method="POST" name="form-manage-gambar">
			<div class="modal-content modal-content-demo">
				<div class="modal-header">
					<h6 class="modal-title"><?= lang('label_gambar'); ?></h6>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<img src="<?= base_url('assets/img/image-sample-import-dokter.png'); ?>" class="zoomImage" style="max-width: 100%;border: 1px solid #ff0000">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 col-md-6 col-sm-12">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<label class="form-label">Pilih</label>
								</div>
								<div class="btn btn-xs p-0 btn-import">
									<button type="button" class="btn btn-warning choose_file__ btn-xs"><i class="fa fa-folder-open-o"></i> <span><?= lang('label_browse'); ?></span></button>
									<input type="file" name="file" class="hide" id="file" accept=".png,.jpg,.jpeg">
									<span class="filename"></span>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-12 row-error">
							<h5 class="title m-0 pb-2 tx-bold tx-danger"></h5>
							<div class="content" style="height: 170px; overflow-y: auto;"></div>
						</div>
					</div>

				</div>
				<div class="modal-footer inline-block">
					<button type="submit" id="submit-import" class="btn btn-primary"><?= lang('label_save'); ?></button>
					<button type="button" class="btn btn-outline-light pull-right" data-dismiss="modal"><?= lang('label_close'); ?></button>
				</div>
			</div>
		</form>
	</div><!-- modal-dialog -->
</div><!-- modal -->