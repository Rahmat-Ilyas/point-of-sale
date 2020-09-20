$(document).ready(function() {
	// STAR Config
	$(document).on('click', '.items', function(e) {
		e.preventDefault();
		var element = $(this).attr('id');

		$.ajax({
			url     : "controller.php",
			method  : "POST",
			data    : { element: element, crypt: true },
			success : function(data) {
				window.history.pushState('', '', data);
			}
		});
		$('#content').load('pages/' + element + '.php');
		$('#link-lock').attr('href', 'lock.php?lock=true&from=' + element);
		$('li, a').removeClass('active');
	});

	$(document).on('click', '.waves-effect', function(e) {
		$('.waves-effect').removeClass('active');
	});

	$(window).on('popstate', function() {
		var url = new URL(location.href);
		var element = url.searchParams.get('page');
		$('#content').load('pages/' + element + '.php');
		$('#link-lock').attr('href', 'lock.php?lock=true&from=' + element);

		$('#sidebar-menu').find('.active').removeClass('active');
		$('#sidebar-menu').find('.waves-effect').removeClass('subdrop active');
		$('#sidebar-menu').find('.list-unstyled').removeClass('parnt');
		$('#sidebar-menu').find('.list-unstyled').css('display', 'none');

		$('#' + element).addClass('active');
		$('#' + element).parentsUntil('.has_sub').addClass('parnt');
		$('.parnt').siblings().addClass('active subdrop');
		$('.parnt').css('display', 'block');
	});
	// END Config

	// STAR Barang Masuk
	$(document).on('click', '#add-btn', function() {
		$('.modal-title').text('Tambah Barang Masuk');
		$('.action').val('create');
		$('.nb-add').show().attr('required', 'true').removeAttr('disabled');
		$('.nb-edt').hide().removeAttr('required').attr('disabled', 'true');
		$('#kategori').removeAttr('disabled');
		$('#kategori1').attr('disabled', 'true');
		$('#harga_jual').attr('required', 'true');
		$('.harga_jual').show();
		$('#fr_brgMasuk')[0].reset();
	});

	$(document).on('click', '#edt-btn', function() {
		var id = $(this).attr('dta-id');

		$('.modal-title').text('Edit Barang Masuk');
		$('.id').val(id);
		$('.action').val('update');
		$('.nb-add').hide().removeAttr('required').attr('disabled', 'true');
		$('.nb-edt').show().attr('required', 'true').removeAttr('disabled');
		$('#kategori').removeAttr('disabled');
		$('#kategori1').attr('disabled', 'true');
		$('#harga_jual').removeAttr('required');
		$('.harga_jual').hide();
		$('#getBarang').fadeOut();

		$.ajax({
			url     : "controller.php",
			method  : "POST",
			data    : { get_dtaBrg: true, id: id },
			success : function(data) {
				$.each(data, function(el, val) {
					$('#'+el).val(val);
				});

				if (data.many == true) {
					$('.nb-edt').attr('readonly', 'true');
					$('#kategori').attr('disabled', 'true');
					$('#kategori1').removeAttr('disabled');
					$('#kategori1').val(data.kategori);
				} else {
					$('.nb-edt').removeAttr('readonly');
					$('#kategori').removeAttr('disabled');
					$('#kategori1').attr('disabled', 'true');
				}
			}
		});
	});

	$(document).on('click', '#del-btn', function() {
		$('.modal-title').text('Hapus Barang Masuk');
		var id = $(this).attr('dta-id');
		$('.delete').attr('dta-id', id);
	});

	//getBarang
	$(document).on('keyup', '#nama_brg', function(){  
		var keyword = $(this).val();  
		if (keyword != '') {  
			$.ajax({  
				url 	: "controller.php",  
				method	: "POST",  
				data	: { keyword: keyword },  
				success	: function(data)  
				{  
					$('#getBarang').fadeIn();  
					$('#getBarang').html(data.output);
					setAdd(keyword, data.nama_barang, data);
				}  
			});  
		} else {
			$('#getBarang').fadeOut();  
		}
	});  

	$(document).on('click', '#item-ac', function() {
		var text = $(this).text()
		$('#nama_brg').val(text);  
		$('#getBarang').fadeOut();

		$.ajax({  
			url 	: "controller.php",  
			method	: "POST",  
			data	: { text: text },  
			success	: function(data)  
			{
				setAdd(text, data.nama_barang, data);
			}  
		});
	});

	$(document).on('blur', '#nama_brg', function() {
		$('#getBarang').fadeOut(); 
	});

	function setAdd(string, params, data) {
		if (string == params) {
			$('#kd_barang').val(data.kd_barang);
			$('#hrg_beli_prpcs').val(data.hrg_beli_prpcs);
			$('#supplier_id').val(data.supplier_id);
			$('#kategori').attr('disabled', 'true');
			$('#kategori').val(data.kategori);
			$('#kategori1').removeAttr('disabled');
			$('#kategori1').val(data.kategori);
			$('#harga_jual').removeAttr('required');
			$('.harga_jual').hide();
		} else {
			$('#kategori').removeAttr('disabled');
			$('#hrg_beli_prpcs').val('');
			$('#supplier_id').val(1);
			$('#kategori1').attr('disabled', 'true');
			$('#kd_barang').val($('#kd_barang').attr('data-kdbrg'));
			$('#harga_jual').attr('required', 'true');
			$('.harga_jual').show();
		}
	}

	// Add & Edit Barang
	$(document).on('submit', '#fr_brgMasuk', function(e) {
		e.preventDefault();

		var data = $('#fr_brgMasuk').serialize();

		$.ajax({
			url    	: "controller.php",
			method  : "POST",
			data    : data,
			success : function(data) {
				console.log(data);
				$.Notification.autoHideNotify(data.status, 'top right', data.title, data.message);
				if (data.status == 'success') {
					$('.modal-form').modal('hide');
					$('#content').load('pages/barang_masuk.php');
				}
			}
		});
	});

	// Delete Barang
	$(document).on('click', '.delete', function() {
		var id = $('.delete').attr('dta-id');

		$.ajax({
			url     : "controller.php",
			method  : "POST",
			data    : { del_dtaBrg: true, id: id },
			success : function(data) {
				console.log(data);
				$.Notification.autoHideNotify(data.status, 'top right', data.title, data.message);
				if (data.status == 'success') {
					$('.modal-delete').modal('hide');
					$('#content').load('pages/barang_masuk.php');
				}
			}
		});
	});

	// Return Pembelian Barang
	$(document).on('click', '#rtb-btn', function() {
		$('.modal-title').text('Return Barang Masuk');
		$('#btn-rtb').attr('disabled', 'true');
		$('#fr_returBrg')[0].reset();
	});

	$(document).on('click', '#kd_pembelian', function() {
		$('#fr_returBrg')[0].reset();
		$(this).val('KSL-0');
		$('#btn-rtb').attr('disabled', 'true');
	});

	$(document).on('keyup', '#kd_pembelian', function() {
		var kd_pembelian = $(this).val();
		$('#btn-rtb').attr('disabled', 'true');
		$('#re_kd_barang').val('');
		$('#re_nama_barang').val('');
		$('#re_jumlah_beli').val('');
		$('#re_hrg_beli_prpcs').val('');

		$.ajax({
			url     : "controller.php",
			method  : "POST",
			data    : { ret_brgBli: true, kd_pembelian: kd_pembelian },
			success : function(data) {
				$.each(data, function(el, val) {
					$('#re_'+el).val(val);
				});

				if (data.strlen == 8 && data.id == null) {
					$('#find-kd').show();
				}
				else if(data.id) {
					$('#find-kd').hide();
					$('#btn-rtb').removeAttr('disabled');
				}
			}
		});
	});

	$(document).on('click', '#jumlah_return', function() {
		$('#jumlah_return').popover('hide');
	});

	$(document).on('keyup', '#jumlah_return', function() {
		var hrg_pcs = parseInt($('#re_hrg_beli_prpcs').val());
		var jum_beli = parseInt($('#re_jumlah_beli').val());
		var jum_return = parseInt($(this).val());
		$('#uang_return').val('');

		if (jum_return > jum_beli) {
			$('#jumlah_return').popover('show');
			$(this).val('');		
			$('#uang_return').val('');
		} else {
			$('#jumlah_return').popover('hide');
			var uang_return = hrg_pcs * jum_return;
			if (uang_return >0 ) $('#uang_return').val(uang_return);
		}
	});

	$(document).on('submit', '#fr_returBrg', function(e) {
		e.preventDefault();

		var data = $('#fr_returBrg').serialize();

		$.ajax({
			url    	: "controller.php",
			method  : "POST",
			data    : data,
			success : function(data) {
				console.log(data);
				$.Notification.autoHideNotify(data.status, 'top right', data.title, data.message);
				if (data.status == 'success') {
					$('.form-rebeli').modal('hide');
					$('#content').load('pages/barang_masuk.php');
				}
			}
		});
	});
	// END Barang Masuk

	// STAR Data Barang
	$(document).on('click', '#edit-barang', function(e) {
		var id = $(this).attr('dta-id');
		$('#id_brg').val(id);

		$.ajax({
			url     : "controller.php",
			method  : "POST",
			data    : { get_dataBrg: true, id: id },
			success : function(data) {
				$.each(data, function(el, val) {
					$('#'+el).val(val);
				});
			}
		});
	});

	$(document).on('submit', '#fr_edtBrg', function(e) {
		e.preventDefault();

		var data = $('#fr_edtBrg').serialize();

		$.ajax({
			url    	: "controller.php",
			method  : "POST",
			data    : data,
			success : function(data) {
				console.log(data);
				$.Notification.autoHideNotify(data.status, 'top right', data.title, data.message);
				if (data.status == 'success') {
					$('.edit-barang').modal('hide');
					$('#content').load('pages/data_barang.php');
				}
			}
		});
	});

	$(document).on('click', '#detail-barang', function(e) {
		var id = $(this).attr('dta-id');
		$('#collapseOne-2').addClass('in');

		$.ajax({
			url     : "controller.php",
			method  : "POST",
			data    : { get_dataBrg: true, detail: true, id: id },
			success : function(data) {
				$.each(data, function(el, val) {
					$('#'+el).text(val);
				});

				$('#riwayat-beli').html(data.riwayat);
			}
		});
	});
	// END Data Barang
});