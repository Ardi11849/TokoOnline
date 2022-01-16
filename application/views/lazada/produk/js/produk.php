<script type="text/javascript">
	var table;
	function tableProduk(type) {
		loading();
		$('#tProdukLazada').DataTable().destroy();
		table = $('#tProdukLazada').DataTable({
			dom: 'Bfrtip',
			lengthMenu: [
				[ 10, 25, 50 ],
				[ '10 rows', '25 rows', '50 rows' ]
			],
			buttons: [
				{extend: 'excel', footer: true, title: 'Lazada produk'}, 
				{extend: 'pdf', footer: true}, {extend: 'print', footer: true},
				'pageLength', 
				{
					text: 'Simpan ke DB', action: function ( e, dt, node, config ) {
						var data = [];
						dt.buttons.exportData().body.forEach((item) => {
					  		console.log(item);
					    	data.push("('<?php echo $this->session->userdata('id');?>','<?php echo $this->session->userdata('shopIdLazada');?>','"+item[2]+"','"+item[3]+"','"+item[5]+"','"+item[6]+"','"+item[7]+"','"+item[8]+"','"+item[10]+"','"+item[1]+"','Lazada','<?php echo $this->session->userdata('id');?>',now())");
						});
						saveProduk(data);
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
				url: '<?php echo base_url()?>Lazada/getProductsLazada',	
				type:'POST',
				data: {
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
						d.recordsTotal = d.data.data.total_products;
						d.recordsFiltered = d.data.data.total_products;
						d.draw = d.draw;
						if (!d.data.data.products) return [];
						return d.data.data.products
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
		        {
		            data: 'created_time', 
		            render: function (data, type, row) {
		                var toDate = new Date(parseInt(data)).toISOString()
		                return toDate.substr(0, 10)+' '+toDate.substr(11, 8);
		            } 
		        },
				{ data: 'item_id' },
				{ data: 'attributes.name' },
				{ 
					data: 'attributes.description',
					render: function(data, type, row){
						data = data.replace(/<\/?span[^>]*>/g,"");
						data = data.replace(/<\/?p[^>]*>/g,"");
						data = data.replace(/<\/?img[^>]*>/g,"");
						data = data.replace(/<\/?strong[^>]*>/g,"");
						data = data.replace(/<\/?ul[^>]*>/g,"");
						data = data.replace(/<\/?li[^>]*>/g,"");
						data = data.replace(/<\/?div[^>]*>/g,"");
						data = data.replace(/<\/?h2[^>]*>/g,"");
						return "<span style='display: block;width: 350px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;'>"+data+"</span>"
					}
				},
				{ data: 'skus.0.price', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },
				{ data: 'skus.0.quantity' },
				{ 
					data: 'images',
					render: function(data, type, row){
						if (!data) {
							return ""
						}else{
							return "<img src='"+data+"' title='"+data+"' style='width:100px;height:auto;border-radius:0%'><span style='width: 100%;position: fixed;bottom: 0;'>"+data+"</span></img>"
						}
					}	
				},
				{ data: 'skus.0.ShopSku' },
				{ data: 'skus.0.SkuId' },
				{ data: 'skus.0.Status' }
			]
		});
	};

	function saveProduk(data) {
		loading();
	    $.ajax({
	        type: 'POST',
	        url: '<?php echo base_url()?>Lazada/saveProdukLazada',
	        dataType: 'json',
			data: 'data='+data,
	        success: function(result){
	            $("#loading").waitMe("hide");
				$("#isiToastSuccess").html('Berhasil menyimpan data');
				$("#successToast").toast('show');
	        }
	    })
	}

	$("#tbarangLazada").on("click", 'td.detailProdukLazada', function() {
		console.log(table.row(this).data());
		const data = table.row(this).data();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url()?>Lazada/getProductLazada',
			dataType: 'json',
			data: 'orderId='+data.order_id,
			success: function(data){
				console.log(data);
				tableProduk(data);
			}
		})
	});

	function validasi() {
		if ($('#typeProduk').val() == '') {
			$("#isiToastGagal").html('harap pilih type produk');
			$("#dangerToast").toast('show');
			return false;
		} else {
			return true;
		}
	}

	$('#btn-searchProduk').on('click', function() {
		if (validasi() == true) {
			tableProduk($("#typeProduk").val());
		}
	});

	$('#tProdukLazada').on( 'page.dt', function () {
		loading();
	});
</script>