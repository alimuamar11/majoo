$modalManageProduk = "#modal-manage-produk";
$tableData = $("#produk").DataTable({
	serverSide: true,
	ordering: true,
	pageLength: "50",
	ajax: {
		url: base_url('master-data/produk/load-dt'),
		type: 'POST',
		headers: {
			'x-user-agent': 'ctc-webapi',
		},
		data: function (d) {
		}
	},
	language: DataTableLanguage(),
	responsive: true,
	scrollY: '50vh',
	bFilter: false,
	scrollX: false,
	order: [[1, 'asc']],
	columnDefs: [
		{ targets: [0], width: '20px', className: 'text-center' },
		{ targets: [6], width: '45px', className: 'text-center' },
	],
	rowCallback: function (row, data, iDisplayIndex) {
		var info = this.fnPagingInfo();
		var page = info.iPage;
		var length = info.iLength;
		var index = page * length + (iDisplayIndex + 1);
		$('td:eq(0)', row).html(index);
		var image = '<div class="az-img-user"> <img src="' + base_url('assets/img/' + data[5]) + '" alt=""> </div>';
		$("td:eq(5)", row).html(image);
	},
})
$(document)
	.ready(function () {
		getActiveLang('master-data/produk');
	})
	.on("click", ".add-produk", function () {
		$modal_id = $modalManageProduk;
		$modal_body = $($modal_id).find('.modal-body');

		$modal_body.find("input:text").val("");
		$modal_body.find("select").val('').trigger('change');
		$modal_body.find("textarea").val('');
		$modal_body.find(".show-on-update").addClass('hide');
		$($modal_id).modal({
			effect: 'effect-slide-in-right',
			backdrop: 'static',
			keyboard: false,
			show: true
		})
	})
	.on("click", ".link-edit-produk", function () {
		http_request('master-data/produk/search__', 'GET', { id: $(this).data('id') })
			.done(function (result) {
				var data = result.data;
				$modal_id = $modalManageProduk;
				$modal_body = $($modal_id).find('.modal-body');

				$('#kategori').html('<option value="' + data.id_kategori + '">' + data.nama_kategori + '</option>').trigger('change');
				$.each(data, function (key, val) {
					$modal_body.find("[name='" + key + "']").val(val);
				})

				$($modal_id).modal({
					effect: 'effect-slide-in-right',
					backdrop: 'static',
					keyboard: false,
					show: true
				})
			})
	})
	.on("submit", "form[name='form-manage-produk']", function (e) {
		e.preventDefault();
		$.ajax({
			url: base_url('master-data/produk/save__'),
			type: "post",
			data: new FormData(this),
			processData: false,
			contentType: false,
			cache: false,
			async: false,
			success: function (data) {
				$('#uploaded_image').html(data);
				$($modalManageProduk).modal('hide');
				$tableData.ajax.reload();
			}
		});
	})


	.on("click", ".link-delete-produk", function () {
		hideMsg();
		var id = $(this).data('id');
		$that = $(this);
		bootbox.confirm({
			title: $lang.bootbox_title_confirmation,
			message: $lang.bootbox_message_confirm_remove,
			size: 'small',
			buttons: {
				confirm: {
					label: $lang.bootbox_btn_confirm,
					className: 'btn-success'
				},
				cancel: {
					label: $lang.bootbox_btn_no,
					className: 'btn-danger'
				}
			},
			callback: function (result) {
				if (result) {
					http_request('master-data/produk/delete__/' + id, 'DELETE', {})
						.done(function (res) {
							Msg.success(res.message);
							$tableData.ajax.reload(null, false);
						})
				}
			}
		});
	})

$("#kategori").select2({
	minimumResultsForSearch: -1,
	placeholder: "Pilih kategori",
	tags: true,
	ajax: {
		url: base_url('master-data/produk/select2_'),
		type: "GET",
		dataType: 'json',
		data: function (params) {
			return {
				key: params.term
			};
		},
		processResults: function (search) {
			return {
				results: search
			};
		},
		cache: true
	},

});
