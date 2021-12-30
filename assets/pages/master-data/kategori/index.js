$modalManageKategori = "#modal-manage-kategori";
$tableData = $("#kategori").DataTable({
    serverSide: true,
    ordering: true,
    pageLength: "50",
    ajax: {
        url: base_url('master-data/kategori/load-dt'),
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
        { targets: [2], width: '45px', className: 'text-center' },
    ],
    rowCallback: function (row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        var index = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html(index);
    },
})
$(document)
    .ready(function () {
        getActiveLang('master-data/kategori');
    })
    .on("click", ".add-kategori", function () {
        $modal_id = $modalManageKategori;
        $modal_body = $($modal_id).find('.modal-body');

        $modal_body.find("input:text").val("");
        $modal_body.find(".show-on-update").addClass('hide');
        $($modal_id).modal({
            effect: 'effect-slide-in-right',
            backdrop: 'static',
            keyboard: false,
            show: true
        })
    })
    .on("click", ".link-edit-kategori", function () {
        http_request('master-data/kategori/search__', 'GET', { id: $(this).data('id') })
            .done(function (result) {
                var data = result.data;
                $modal_id = $modalManageKategori;
                $modal_body = $($modal_id).find('.modal-body');

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
    .on("submit", "form[name='form-manage-kategori']", function (e) {
        e.preventDefault();
        $("#save-kategori").attr('disabled', 'disabled');
        $form = $(this).closest('form');
        var data = $form.serialize();
        http_request('master-data/kategori/save__', 'POST', data)
            .done(function (res) {
                $($modalManageKategori).modal('hide');
                $tableData.ajax.reload();
                Msg.success(res.message);
                $("#save-kategori").removeAttr('disabled');
            })
            .fail(function () {
                $("#save-kategori").removeAttr('disabled');
            })
            .always(function () {
                $("#save-kategori").removeAttr('disabled');
            })
    })
    .on("click", ".link-delete-kategori", function () {
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
                    http_request('master-data/kategori/delete__/' + id, 'DELETE', {})
                        .done(function (res) {
                            Msg.success(res.message);
                            $tableData.ajax.reload(null, false);
                        })
                }
            }
        });
    })

