<script type="text/javascript">
		$('#selectAkunLazada').val('<?php echo $this->session->userdata('shopIdLazada');?>');
		$('#selectAkunLazada').trigger('change');
		$("a.lazada").addClass('active bg-gradient-primary');
		$("a.dashboard").removeClass('active bg-gradient-primary');
		$("a.shopee").removeClass('active bg-gradient-primary');

		$('#selectAkunLazada').on('change', function() {
				$.ajax({
						type: 'post',
						url: '<?php echo base_url()?>Lazada/setSession',
						data: $(this).find(':selected').data(),
						dataType: 'json',
						success: function(data){
								console.log(data);
                var tables = $.fn.dataTable.fnTables(true);

                $(tables).each(function () {
                    $(this).dataTable().fnDestroy();
                });
						}
				})
		});

		$('select').select2();

		$('#tanggalAwal').datepicker({
				uiLibrary: 'bootstrap5',
				format: 'dd-mm-yyyy'
		});
		$('#tanggalAkhir').datepicker({
				uiLibrary: 'bootstrap5',
				format: 'dd-mm-yyyy'
		});

		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;

		function tableOrderan(from, to, type) {
				loading();
				$('#tOrderLazada').DataTable().destroy();
				return table = $('#tOrderLazada').DataTable({
						dom: 'Bfrtip',
						lengthMenu: [
								[ 10, 25, 50 ],
								[ '10 rows', '25 rows', '50 rows' ]
						],
						buttons: [
								{extend: 'excel', footer: true, title: 'Lazada order tanggal: '+from+' - '+to}, 
								{extend: 'pdf', footer: true}, {extend: 'print', footer: true},
								'pageLength', 
								{
										text: 'Simpan ke DB', action: function ( e, dt, node, config ) {
												var data = [];
												dt.buttons.exportData().body.forEach((item) => {
												data.push("('<?php echo $this->session->userdata('id');?>','<?php echo $this->session->userdata('shopIdLazada');?>','"+item[2]+"','"+item[4]+"','"+item[5]+"','"+item[6][0]+"','Lazada','"+item[1]+"','<?php echo $this->session->userdata('id');?>',now())");
												});
												saveOrder(data);
										}
								}
						],
						scrollX: true,
						ordering: false,
						paging: true,
						processing: true,
						serverSide: true,
						pageLength: 10,
						ajax: {
								url: '<?php echo base_url()?>Lazada/getOrdersLazada',	
								type:'POST',
								data: {
										dateFrom: from,
										dateTo: to,
										type: type
								},
								"error": function (e) {
										console.log(e);
										$("#loading").waitMe("hide");
										if (e == 'error_auth') return "token kadaluarsa harap login akun online shop anda";
										return e
								},
								"dataSrc": function (d) {
										$("#loading").waitMe("hide");
										if (d.data.message === '' || d.data.message === undefined) {
												$("#isiToastSuccess").html('Berhasil mengambil data');
												$("#successToast").toast('show');
												d.recordsTotal = d.data.data.countTotal;
												d.recordsFiltered = d.data.data.countTotal;
												d.draw = d.draw;
												return d.data.data.orders
										}else{
												$("#isiToastGagal").html('Message: '+d.data.message+' <br><p>Note: Jika error refresh_token harap login ulang akun online shop anda</p>');
												$("#dangerToast").toast('show');
												return [];
										}
								}
						},
						columns: [
								{ 
										"data": null,
										"sortable": false,
										render: function (data, type, row, meta) {
												return meta.row + meta.settings._iDisplayStart + 1;
										}
								},
								{ data: 'created_at' },
								{ 
										data: 'order_id', 
										render: function (data, type, row) {
												return '<button class="btn btn-link" onclick="detailOrderLazada(\''+data+'\')">'+data+"</button>"
										} 
								},
								{ data: 'order_number' },
								{ data: 'address_billing.first_name' },
								{ data: 'price', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },
								{ data: 'statuses' }
						],
						"footerCallback": function ( row, data, start, end, display ) {
								var api = this.api(), data;

								var intVal = function ( i ) {
								return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
								};

								total = api
								.column( 5 )
								.data()
								.reduce( function (a, b) {
								return intVal(a) + intVal(b);
								}, 0 );

								pageTotal = api
								.column( 5, { page: 'current'} )
								.data()
								.reduce( function (a, b) {
								return intVal(a) + intVal(b);
								}, 0 );

								$( api.column( ).footer() ).html(
								'Total Page Ini: '+numberRenderer(pageTotal)
								);
						}
				});
		};

		function saveOrder(data) {
				loading();
				$.ajax({
						type: 'POST',
						url: '<?php echo base_url()?>Lazada/saveOrderLazada',
						dataType: 'json',
						data: 'data='+data,
						success: function(result){
								$("#loading").waitMe("hide");
								$("#isiToastSuccess").html('Berhasil menyimpan data');
								$("#successToast").toast('show');
						}
				})
		}

		function validasiOrder() {
				if ($('#tanggalAwal').val() == '') {
						$("#isiToastGagal").html('harap isi tanggal awal');
						$("#dangerToast").toast('show');
				return false;
				} else if ($('#typeOrder').val() == '') {
						$("#isiToastGagal").html('harap pilih type orderan');
						$("#dangerToast").toast('show');
						return false;
				} else {
						return true;
				}
		}

		$("#btn-searchOrder").on('click', function() {
				const dateToInt = $('#tanggalAkhir').val().split('-');
				const dateFromInt = $("#tanggalAwal").val().split('-');
				const oneDay = 24 * 60 * 60 * 1000;
				const fDate = new Date(dateToInt[2], dateToInt[1], dateToInt[0]);
				const tDate = new Date(dateFromInt[2], dateFromInt[1], dateFromInt[0]);
				const dateRange = Math.round(Math.abs((fDate - tDate) / oneDay));
				console.log(dateRange);
				if (dateToInt[2]+dateToInt[1]+dateToInt[0] < dateFromInt[2]+dateFromInt[1]+dateFromInt[0]) {
						$("#isiToastGagal").html('Tanggal akhir harus lebih besar dari tanggal awal');
						$("#dangerToast").toast('show');
				} else {
						if (validasiOrder() == true) {
								tableOrderan($('#tanggalAwal').val(), $("#tanggalAkhir").val(), $("#typeOrder").val());
						}
				}
		});

		function detailOrderLazada(data) {
				loading();
				$.ajax({
						type: 'POST',
						url: '<?php echo base_url()?>Lazada/getOrderLazada',
						dataType: 'json',
						data: 'orderId='+data,
						success: function(result){
								$("#loading").waitMe("hide");
								console.log(result);
								$("#detailOrderModalLabel").html("Detail No Pembeli: "+data+"<span style='float:right;'>"+result.order.data.created_at);
								$("#userIdModalOrder").html("<strong>User Id:</strong> "+result.item.data[0].buyer_id);
								$("#usernameModalOrder").html("<strong>Username:</strong> "+result.order.data.customer_first_name);
								$("#cancelByModalOrder").html("<strong>Di Batalkan Oleh:</strong> "+result.item.data[0].cancel_return_initiator);
								$("#reasonCancelModalOrder").html("<strong>Alasan Batal:</strong> "+result.item.data[0].reason);
								$("#reasonCancelModalOrder").html("<strong>Detail Alasan Batal:</strong> "+result.item.data[0].reason_detail);
								$("#reasonCancelModalOrder").html("<strong>Status Pengembalian:</strong> "+result.item.data[0].return_status);
								$("#metodePembayaranModalOrder").html("<strong>Metode Pembayaran:</strong> "+result.order.data.payment_method);
								$("#provinsiModalOrder").html("<strong>Provinsi:</strong> "+result.order.data.address_billing.address3);
								$("#kotaModalOrder").html("<strong>Kota/Kab:</strong> "+result.order.data.address_billing.city);
								$("#kecamatanModalOrder").html("<strong>Kecamatan:</strong> "+result.order.data.address_billing.address4);
								$("#kodePosModalOrder").html("<strong>Kode Pos:</strong> "+result.order.data.address_billing.post_code);
								$("#alamatModalOrder").html("<strong>Alamat Lengkap:</strong> "+result.order.data.address_billing.address1);
								$("#jumlahBeliModalOrder").html("<strong>Jumlah Beli:</strong> "+result.order.data.items_count);
								$("#jumlahBayarModalOrder").html("<strong>Jumlah Bayar:</strong> "+result.order.data.price);
								var setItem = '';
								for (var i = 0; i <= result.item.data.length - 1; i++) {
										setItem += '<li class="list-group-item border-0 ps-0 text-sm"><strong>No:</strong> '+(i+1)+'</li>'+
										'<li class="list-group-item border-0 ps-0 text-sm"><strong>ID Barang:</strong> '+result.item.data[0].product_id+'</li>'+
										'<li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong>Nama Barang:</strong> '+result.item.data[0].name+'</li>'+
										'<li class="list-group-item border-0 ps-0 text-sm"><strong>SKU Barang:</strong> '+result.item.data[0].sku+'</li>'+
										'<li class="list-group-item border-0 ps-0 text-sm"><strong>Harga Barang:</strong> '+result.item.data[0].paid_price+'</li>'+
										'<li class="list-group-item border-0 ps-0 text-sm"><strong>Nama Model:</strong> '+result.item.data[0].variation+'</li>'+
										'<li class="list-group-item border-0 ps-0 text-sm"><strong>Id Pesanan:</strong> '+result.item.data[0].order_item_id+'</li><hr>'
								}
								$("#listItem").html(setItem);
								$("#ekspedisiOrderModal").html(result.item.data[0].shipment_provider);
								$("#idPengirimanOrderModal").html(result.item.data[0].tracking_code);
								$("#statusEkspedisiOrderModal").html(result.item.data[0].status);
								var html = '';
								for (var i = 0; i <= result.trace.result.module[0].package_detail_info_list[0].logistic_detail_info_list.length - 1; i++) {
										var toDate = new Date(result.trace.result.module[0].package_detail_info_list[0].logistic_detail_info_list[i].event_time).toISOString()
										var date = toDate.substr(0, 10)+' '+toDate.substr(11, 8);
										html += '<li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">'+
										'<div class="avatar me-3">'+
										'<i class="fa fa-truck" style="color: black;"></i>'+
										'</div>'+
										'<div class="d-flex align-items-start flex-column justify-content-center">'+
										'<h6 class="mb-0 text-sm">'+result.trace.result.module[0].package_detail_info_list[0].logistic_detail_info_list[i].detail_type+'</h6>'+
										'<p class="mb-0 text-xs">'+result.trace.result.module[0].package_detail_info_list[0].logistic_detail_info_list[i].description+'</p>'+
										'</div>'+
										'<a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto" href="javascript:;">'+date+'</a>'+
										'</li>'
								}
								$("#listTrackOrder").html(html);
								$('#detailOrderModal').modal('show');
						}
				})
		}
		$('#tOrderLazada').on( 'page.dt', function () {
				loading();
		});
</script>