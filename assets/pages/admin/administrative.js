$modalManageJenisPemeriksaan="#modal-manage-jenis-pemeriksaan"
$modalManageDokter="#modal-manage-dokter"
$modalManageJenisSample="#modal-manage-jenis-sample"
$modalManageNotes="#modal-manage-notes"
$tableUsers = $("#tableUsers").DataTable({
    serverSide: true,
    ordering: true,
    pageLength: 25,
    ajax: {
        url: base_url('admin/administrative/load-dt-users'),
        type: 'POST',
        headers: {
            'x-user-agent': 'ctc-webapi',
        },
        data: function(d) {
           
        }
    },
    language: DataTableLanguage(),
    responsive: true,
    scrollY: '50vh',
    scrollCollapse: true,
    scrollX: false,
    sorting: [[1,'ASC']],
    columnDefs: [
        { targets: [0], width: '35px',className: 'text-center' },
        { targets: [4], width: '79px',className: 'text-center' },
        { targets: [-1], width: '50px',className: 'text-center',searchable: false,orderable: false },
    ],
    rowCallback: function(row, data, iDisplayIndex){
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        var index = page * length + (iDisplayIndex + 1);
        $('td:eq(0)', row).html(index);
        var selected="", set_status="Inactive", btnclass="btn-danger";
        if(parseInt(data[4])==1){
            selected="checked='checked'"; set_status="Active";
            btnclass="btn-success";
        }else{
            $(row).addClass("text-danger");
        }
        $("td:eq(4)",row).html($('<label class="ckbox"><input type="checkbox" class="set_status_user" data-id="'+data[0]+'" name="is_enabled" value="1" '+selected+'> <span>'+set_status+'</span></label>'));
        //$("td:eq(4)",row).html($('<label class="ctc-toggle-active btn-status2"><input class="hide" type="checkbox" '+selected+'><span> '+set_status+'</span></label>'));
    },
})

$(document)
.ready(function(){
    getActiveLang('administrative');
    
})
.on("click",".add-user",function(){
    $modal_id="#modal-manage-user";
    $modal_body=$($modal_id).find('.modal-body');
    $modal_body.find('input[name="user_id"]').val('');
    
    $modal_body.find("input:text").val("");
    $modal_body.find("[name*='password']").attr('required');
    $modal_body.find(".show-on-update").addClass('hide');
    $($modal_id).modal({
        effect: 'effect-slide-in-right',
        backdrop: 'static',
        keyboard: false,
        show: true
    })
})
.on("click",".set_status_user",function(){
    var $that=$(this);
    var status=0;
    var endisUser=" Disabled this user";
    var id=$that.data('id');
    if($that.is(":checked")){
           status=1;  
           var endisUser=" Enabled this user";
    }
    bootbox.confirm({
        title: $lang.bootbox_title_confirmation,
        message: $lang.bootbox_message_confirm_+endisUser+"?",
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
            if(result){
                http_request('administrative/enable-disable-user/','POST',{id: id,status: status})
                .done(function(res){
                    Msg.success(res.message);
                    $tableUsers.ajax.reload(null,false);
                })
                .fail(function(err){
                    if($that.is(":checked")){
                        $that.prop("checked",false);
                    }else{
                        $that.prop("checked",true);
                    }
                })
            }else{
                if($that.is(":checked")){
                    $that.prop("checked",false);
                }else{
                    $that.prop("checked",true);
                }
            }
        }
    });
})
.on("keypress",".no-space",function(e){
    if(e.keyCode==32){
        Msg.error($lang.msg_space_no_allowed);
        return false;  
    } 
})
.on("click",".link-edit-user",function(){
    http_request('administrative/search-user','GET',{id: $(this).data('id')})
    .done(function(result){
        var data=result.data;
        $modal_id="#modal-manage-user";
        $modal_body=$($modal_id).find('.modal-body');
        $.each(data,function(key,val){
            $modal_body.find("[name='"+key+"']").val(val);
		})
		if (data.provider_id != "") {
			$("#search_provider").append('<option value="'+data.provider_id+'" selected="selected">'+data.nama_provider+'</option>')
		}
        $modal_body.find("[name*='password']").removeAttr('required');
        $modal_body.find(".show-on-update").removeClass('hide');
        $(".accessibility").prop("checked",false);
        if(result.privilege && result.privilege.superAdmin==false){
            $.each(result.privilege.accessibility,function(i,dt){
                $("[name^='accessibility'][value='"+dt+"']").prop("checked",true);
            })
            $.each(result.privilege.actions_code,function(i,dt){
                $("[name^='actions_code'][value='"+dt+"']").prop("checked",true);
            })
        }else
        if(result.privilege && result.privilege.superAdmin==true){
            $(".accessibility").prop("checked",true);
        }
        $($modal_id).modal({
            effect: 'effect-slide-in-right',
            backdrop: 'static',
            keyboard: false,
            show: true
        })
        //showRemoveIconOnProcess();
    })
})
.on("submit","form[name='form-manage-user']",function(e){
    e.preventDefault();
    $form=$(this).closest('form');
    var data=$form.serialize();
    http_request('administrative/save-user','POST',data)
    .done(function(res){
        Msg.success(res.message);
        $("#modal-manage-user").modal('hide');
        $tableUsers.ajax.reload();
    })
})
	.on("click", ".add-provider", function () {
		$modal_id=$modalManageprovider;
    $modal_body=$($modal_id).find('.modal-body');
    // $modal_body.find('input[name="user_id"]').val('');
    
    $modal_body.find("input:text").val("");
    $modal_body.find("textarea[name='alamat']").val("");
    // $modal_body.find("[name*='password']").attr('required');
    $modal_body.find(".show-on-update").addClass('hide');
    $($modal_id).modal({
        effect: 'effect-slide-in-right',
        backdrop: 'static',
        keyboard: false,
        show: true
    })
	})
	.on("click",".link-edit-provider",function(){
		http_request('provider/search__','GET',{id: $(this).data('id')})
		.done(function(result){
			var data=result.data;
			$modal_id=$modalManageprovider;
			$modal_body = $($modal_id).find('.modal-body');
			$.each(data, function (key, val) {
				$modal_body.find("[name='"+key+"']").val(val);
			})
			$($modal_id).modal({
				effect: 'effect-slide-in-right',
				backdrop: 'static',
				keyboard: false,
				show: true
			})
		})
	})
	.on("submit","form[name='form-manage-provider']",function(e){
		e.preventDefault();
		$form=$(this).closest('form');
		var data=$form.serialize();
		http_request('provider/save__','POST',data)
		.done(function(res){
			Msg.success(res.message);
			$($modalManageprovider).modal('hide');
			$tableProvider.ajax.reload();
		})
	})
	.on("click",".link-delete-provider",function(){
		hideMsg();
		var id=$(this).data('id');
		$that=$(this);
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
				if(result){
					http_request('provider/delete__/'+id,'DELETE',{})
					.done(function(res){
						Msg.success(res.message);
						$tableProvider.ajax.reload(null,false);
					})
				}
			}
		});
	})

	// jenis pemeriksaan setting
	.on("click", "[name^='group_hasil1']", function () {
		var grp = $(this).data('group');

		$("[name*='group_hasil']").each(function () {
			if ($(this).data('group') != grp) {
				$(this).removeAttr('checked')
			} else {
				$(this).attr('checked', 'checked');
				var nm = $(this).attr('name');
				console.log(nm, $(this).val())
				$("input[data-groupv='"+nm+"']").val($(this).val())
			}
		})
	})
	.on("click", "[name^='group_hasil2']", function () {
		Msg.error("Silahkan pilih nilai di hasil 1. hasil 2 akan mengikuti")
		return false;
	})
	.on("keyup", "[name='pemeriksaan1[]']", function () {
		var ind = $(this).index();
		$("[name='pemeriksaan2["+ind+"]").val($(this).val())
	})
.on("click",".add-jenis-pemeriksaan",function(){
	$modal_id=$modalManageJenisPemeriksaan;
	$modal_body=$($modal_id).find('.modal-body');
	$modal_body.find("input:text").val("");
	$modal_body.find("textarea[name='alamat']").val("");
	$modal_body.find(".show-on-update").addClass('hide');
	$($modal_id).modal({
		effect: 'effect-slide-in-right',
		backdrop: 'static',
		keyboard: false,
		show: true
	})
})

.on("click",".link-delete-jenis-pemeriksaan",function(){
	hideMsg();
	var id=$(this).data('id');
	$that=$(this);
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
			if(result){
				http_request('jenispemeriksaan/delete__/'+id,'DELETE',{})
				.done(function(res){
					Msg.success(res.message);
					$tableJenisPemeriksaan.ajax.reload(null,false);
				})
			}
		}
	});
})
	.on("click", ".add-row-opsi-pemeriksaan", function () {
	// 	var getLength = $("[name^='nama_pemeriksaan']").length;
	// var row = '<tr>' +
	// 	'<td>' +
	// 	'<input type="text" class="form-control input-sm" name="nama_pemeriksaan[]" placeholder="Nama Pemeriksaan">' +
	// 	'</td>' +
	// 	'<td>' +
	// 	'<input type="text" class="form-control input-sm" name="hasil[]" placeholder="Hasil">' +
	// 	'</td>' +
	// 	'<td>' +
	// 	'<input type="text" class="form-control input-sm" name="nilai_rujukan[]" placeholder="Nilai Rujukan">' +
	// 	'</td>' +
	// 	'</tr>';
		var row_table1='<tr class="row-append">'+
											'<td class="p-1">'+
												'<input type="hidden" class="form-control input-sm" name="is_main[]" value="0">'+
												'<input type="hidden" class="form-control input-sm" name="hasil_id1[]" value="">'+
												'<input type="text" class="form-control input-sm" name="pemeriksaan[]">'+
											'</td>'+
											'<td class="p-1"><input type="text" class="form-control input-sm" name="hasil1[]"></td>'+
											'<td class="p-1"><input type="text" class="form-control input-sm" name="nilai_rujukan1[]"></td>'+
										'</tr>';
		$(".table-hasil1 tbody").append($(row_table1));
			var row_table2='<tr class="row-append">'+
			'<td class="p-1">'+
			'<input type = "hidden" class="form-control input-sm" name = "hasil_id2[]" value="">' +
			'<input type = "text" class="form-control input-sm" name = "hasil2[]" >' +
			'</td > '+
											'<td class="p-1"><input type="text" class="form-control input-sm" name="nilai_rujukan2[]"></td>'+
											'<td class="p-1 tx-center"><i class="fa fa-times text-danger pointer remove-row"></i></td>'+
										'</tr>';
	$(".table-hasil2 tbody").append($(row_table2));
})
.on("click", ".link-edit-jenis-pemeriksaan", function () {
	http_request('jenispemeriksaan/search__', 'GET', { id: $(this).data('id') })
	.done(function(result){
		var data = result.data;
		$("table tr.row-append").remove();
		$modal_id=$modalManageJenisPemeriksaan;
		$modal_body = $($modal_id).find('.modal-body');
		var opsi_hasil = result.list_hasil;
		if (opsi_hasil.length > 0) {
			var search_main = _.filter(opsi_hasil, function (item) {
				return item.is_main == 1;
			})
			var search_nonmain = _.filter(opsi_hasil, function (item) {
				return item.is_main == 0;
			})
			if (search_main.length > 0) {
				$("[name='group_hasil1'][value='" + search_main[0].group_hasil + "']").removeAttr('readonly').trigger('click');
				$("[name='group_hasil1'][value!='" + search_main[0].group_hasil + "']").attr("readonly","readonly")
				$("[name='hasil_id1[]").val(search_main[0].id);
				$("[name='hasil_id2[]").val(search_main[1].id);
				$("[name='pemeriksaan[]").val(search_main[0].nama_pemeriksaan);
			}
			if (search_nonmain.length > 0) {
				var search_another=_.filter(search_nonmain, function (s) {
					return s.group_hasil!=search_main[0].group_hasil
				})
				$.each(_.filter(search_nonmain, function (s) {
					return s.group_hasil==search_main[0].group_hasil
				}), function (i, item) {
					var row_table1='<tr class="row-append">'+
							'<td class="p-1">'+
								'<input type="hidden" class="form-control input-sm" name="is_main[]" value="0">'+
								'<input type="hidden" class="form-control input-sm" name="hasil_id1[]" value="'+item.id+'">'+
								'<input type="text" class="form-control input-sm" name="pemeriksaan[]" value="'+item.nama_pemeriksaan+'">'+
							'</td>'+
							'<td class="p-1"><input type="text" class="form-control input-sm" name="hasil1[]" value="'+item.hasil+'"></td>'+
							'<td class="p-1"><input type="text" class="form-control input-sm" name="nilai_rujukan1[]" value="'+item.nilai_rujukan+'"></td>'+
						'</tr>';
						$(".table-hasil1 tbody").append($(row_table1));
						
					var row_table2='<tr class="row-append">'+
							'<td class="p-1">' +
							'<input type="hidden" class="form-control input-sm" name="hasil_id2[]" value="'+search_another[i].id+'">'+
							'<input type="text" class="form-control input-sm" name="hasil2[]" value="' + search_another[i].hasil + '">' +
							'</td > '+
							'<td class="p-1"><input type="text" class="form-control input-sm" name="nilai_rujukan2[]" value="'+search_another[i].nilai_rujukan+'"></td>'+
							'<td class="p-1 tx-center"><i class="fa fa-times text-danger pointer remove-row while-edit" data-ids="'+item.id+','+search_another[i].id+'"></i></td>'+
						'</tr>';
					$(".table-hasil2 tbody").append($(row_table2));
				})
			}
		}
		$("[name='jenis_pemeriksaan']").val(data[0].jenis);
		$("[name='metode']").val(data[0].metode);
		$("[name='_id']").val(data[0]._id);
		$($modal_id).modal({
				effect: 'effect-slide-in-right',
				backdrop: 'static',
				keyboard: false,
				show: true
		})
	})
})
	.on("click", "[name='group_hasil1'][readonly]", function () {
		Msg.error("Hasil 1 & 2 tidak bisa di ubah by edit. data yang dapat diubah hanya list pemeriksaan, silakan hapus dan buat baru")
		return false;
	})
	.on("click", ".remove-row", function () {
		if ($(this).is(".while-edit")) {
			var that=$(this)
			var ids=$(this).data("ids")
			bootbox.confirm({
				title: $lang.bootbox_title_confirmation,
				message: "Baris pemeriksaan ini akan dihapus tanpa perlu di submit, Yakin?",
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
					if(result){
						http_request('jenispemeriksaan/delete_opsi_hasil__/','DELETE',{ids: ids})
						.done(function(res){
							Msg.success(res.message);
							$tableJenisPemeriksaan.ajax.reload(null, false);
							var ind = that.closest('tr').index()
							that.closest('tr').remove();
							$(".table-hasil1 tr:eq("+ind+")").remove();
						})
					}
				}
			});
		} else {
				var ind = $(this).closest('tr').index()
			$(this).closest('tr').remove();
			$(".table-hasil1 tr:eq("+ind+")").remove();
		}
		
	})
.on("submit","form[name='form-manage-jenis-pemeriksaan']",function(e){
	e.preventDefault();
	$form=$(this).closest('form');
	var data=$form.serialize();
	http_request('jenispemeriksaan/save__','POST',data)
	.done(function(res){
		Msg.success(res.message);
		$($modalManageJenisPemeriksaan).modal('hide');
		$tableJenisPemeriksaan.ajax.reload();
	})
})
.on("click",".add-dokter",function(){
	$modal_id=$modalManageDokter;
	$modal_body=$($modal_id).find('.modal-body');
	$modal_body.find("input:text").val("");
	$modal_body.find(".show-on-update").addClass('hide');
	$($modal_id).modal({
		effect: 'effect-slide-in-right',
		backdrop: 'static',
		keyboard: false,
		show: true
	})
})
.on("click", ".link-edit-dokter", function () {
	http_request('dokter/search__', 'GET', { id: $(this).data('id') })
	.done(function(result){
		var data=result.data;
		$modal_id=$modalManageDokter;
		$modal_body = $($modal_id).find('.modal-body');
		$.each(data, function (key, val) {
			$modal_body.find("[name='"+key+"']").val(val);
		})
		$($modal_id).modal({
				effect: 'effect-slide-in-right',
				backdrop: 'static',
				keyboard: false,
				show: true
		})
	})
})
.on("click",".link-delete-dokter",function(){
	hideMsg();
	var id=$(this).data('id');
	$that=$(this);
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
			if(result){
				http_request('dokter/delete__/'+id,'DELETE',{})
				.done(function(res){
					Msg.success(res.message);
					$tableDokter.ajax.reload(null,false);
				})
			}
		}
	});
})
.on("submit","form[name='form-manage-dokter']",function(e){
	e.preventDefault();
	$form=$(this).closest('form');
	var data=$form.serialize();
	http_request('dokter/save__','POST',data)
	.done(function(res){
		Msg.success(res.message);
		$($modalManageDokter).modal('hide');
		$tableDokter.ajax.reload();
	})
})
.on("click",".add-jenis-sample",function(){
	$modal_id=$modalManageJenisSample;
	$modal_body=$($modal_id).find('.modal-body');
	$modal_body.find("input:text").val("");
	$modal_body.find(".show-on-update").addClass('hide');
	$($modal_id).modal({
		effect: 'effect-slide-in-right',
		backdrop: 'static',
		keyboard: false,
		show: true
	})
})
.on("click", ".link-edit-jenis-sample", function () {
	http_request('pemeriksaan/search-jenis-sample__', 'GET', { id: $(this).data('id') })
	.done(function(result){
		var data=result.data;
		$modal_id=$modalManageJenisSample;
		$modal_body = $($modal_id).find('.modal-body');
		$.each(data, function (key, val) {
			$modal_body.find("[name='"+key+"']").val(val);
		})
		$($modal_id).modal({
				effect: 'effect-slide-in-right',
				backdrop: 'static',
				keyboard: false,
				show: true
		})
	})
})
.on("click",".link-delete-jenis-sample",function(){
	hideMsg();
	var id=$(this).data('id');
	$that=$(this);
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
			if(result){
				http_request('pemeriksaan/delete-jenis-sample__/'+id,'DELETE',{})
				.done(function(res){
					Msg.success(res.message);
					$tableJenisSample.ajax.reload(null,false);
				})
			}
		}
	});
})
.on("submit","form[name='form-manage-jenis-sample']",function(e){
	e.preventDefault();
	$form=$(this).closest('form');
	var data=$form.serialize();
	http_request('pemeriksaan/save-jenis-sample__','POST',data)
	.done(function(res){
		Msg.success(res.message);
		$($modalManageJenisSample).modal('hide');
		$tableJenisSample.ajax.reload();
	})
})
.on("click",".add-notes",function(){
	$modal_id=$modalManageNotes;
	$modal_body=$($modal_id).find('.modal-body');
	$modal_body.find("input:text").val("");
	$modal_body.find(".show-on-update").addClass('hide');
	$($modal_id).modal({
		effect: 'effect-slide-in-right',
		backdrop: 'static',
		keyboard: false,
		show: true
	})
})
.on("click", ".link-edit-notes", function () {
	http_request('pemeriksaan/search-notes__', 'GET', { id: $(this).data('id') })
	.done(function(result){
		var data=result.data;
		$modal_id=$modalManageNotes;
		$modal_body = $($modal_id).find('.modal-body');
		$.each(data, function (key, val) {
			$modal_body.find("[name='"+key+"']").val(val);
		})
		$($modal_id).modal({
				effect: 'effect-slide-in-right',
				backdrop: 'static',
				keyboard: false,
				show: true
		})
	})
})
.on("click",".link-delete-notes",function(){
	hideMsg();
	var id=$(this).data('id');
	$that=$(this);
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
			if(result){
				http_request('pemeriksaan/delete-notes__/'+id,'DELETE',{})
				.done(function(res){
					Msg.success(res.message);
					$tableNotes.ajax.reload(null,false);
				})
			}
		}
	});
})
.on("submit","form[name='form-manage-notes']",function(e){
	e.preventDefault();
	$form=$(this).closest('form');
	var data=$form.serialize();
	http_request('pemeriksaan/save-notes__','POST',data)
	.done(function(res){
		Msg.success(res.message);
		$($modalManageNotes).modal('hide');
		$tableNotes.ajax.reload();
	})
})
	.on("click", ".link-edit-others-setting", function () {
		var id = $(this).data('id');
		http_request('administrative/get-setting/' + id, 'GET', {})
	.done(function(result){
		var data = (result.length > 0) ? result[0] : {};
		$modal_id="#modal-manage-others-setting";
		$modal_body = $($modal_id).find('.modal-body');
		$.each(data, function (key, val) {
			$modal_body.find("[name='"+key+"']").val(val);
		})
		$($modal_id).modal({
				effect: 'effect-slide-in-right',
				backdrop: 'static',
				keyboard: false,
				show: true
		})
	})
})
.on("submit","form[name='form-manage-others-setting']",function(e){
	e.preventDefault();
	$form=$(this).closest('form');
	var data=$form.serialize();
	http_request('administrative/save-others-setting__','POST',data)
	.done(function(res){
		Msg.success(res.message);
		$("#modal-manage-others-setting").modal('hide');
		$tableOthersSetting.ajax.reload();
	})
})
.on("click",".btn-status",function(){
    $that=$(this);
    if($that.find("input:checkbox").is(":checked")){
        $that.removeClass('btn-success').addClass('btn-danger');
        $that.find('span').text('In active');
    }else{
        $that.removeClass('btn-danger').addClass('btn-success');
        $that.find('span').text('Active');
    }
})
.on("click",".accessibility",function(){
    $this=$(this);
    var val=$this.val();
    if($this.is(":checked") && val=='c-spadmin'){
        $("input[type='checkbox'].accessibility").prop("checked",true);
    }else
    if($this.is(":checked")==false && val!='c-spadmin'){
        $this.closest('li').find("ul input.accessibility[name^='actions_code']").prop("checked",false);
    }
})
.on("click",".accessibility[name^='actions_code']",function(){
    $this=$(this);
    $parent_ul=$this.closest('ul');
    $parent_li=$parent_ul.closest('li');
    var val=$this.val();
    var any=false;
    if($this.is(":checked")){
        $parent_li.find(".accessibility[name^='accessibility']").prop('checked',true);
    }else{
        $parent_ul.find(".accessibility[name^='actions_code']").each(function(){
            if($(this).is(":checked")){
                any=true;
            }
        })
        setTimeout(function(){
            if(!any)  $parent_li.find(".accessibility[name^='accessibility']").prop('checked',false);
           },100)
    }
})
var showRemoveIconOnProcess=function(){
    $(".row-internal-process-unselected label.ckbox,.row-external-process-unselected label.ckbox").hover(function(){
        $(this).find('.remove-process').removeClass('hide');
    },function(){
        $(this).find('.remove-process').addClass('hide');
    })
}
