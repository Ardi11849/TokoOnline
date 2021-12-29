<script type="text/javascript">
	$(document).ready( function () {
		$('#tanggalAwalReturn').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		$('#tanggalAkhirReturn').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		var table;
		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
		// function tableReturn(data) {
		function tableReturn(from, to) {
			$('#tReturn').DataTable().destroy();
		    return table = $('#tReturn').DataTable({
				dom: 'Bfrtip',
				buttons: [{extend: 'excel', footer: true}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
				scrollX: true,
				ordering: false,
				paging: true,
				processing: true,
				serverSide: true,
				"pageLength": 10,
				ajax: {
				  url: '<?php echo base_url()?>Shopee/getReturnShopee',
				  type:'POST',
				  data: {
				  	dateFrom: from,
				  	dateTo: to,
				  },
			      "error": function (e) {
			      	return e
			      },
			      "dataSrc": function (d) {
			    	if (d.message === '' || d.message === undefined) {
						$("#isiToastSuccess").html('Berhasil mengambil data');
						$("#successToast").toast('show');
					}else{
						$("#isiToastGagal").html('Message: '+d.message+' <p>Jika error refresh_token harap login ulang akun online shop anda</p>');
						$("#dangerToast").toast('show');
			    	}
			         return d
			      }
				},
		  //       data:  data,
				columns: [
					{ 
						data: 'create_time', 
						render: function (data, type, row) {
							var toDate = new Date(data * 1000).toISOString()
					        return toDate.substr(0, 10)+' '+toDate.substr(11, 8);
					    } 
					},
					{ data: 'buyer_username' },
					{ data: 'item_list.0.item_name' },
					{ data: 'days_to_ship' },
					{ data: 'estimated_shipping_fee' },
					{ data: 'payment_method' },
					{ data: 'total_amount' },
					{ data: 'order_status' },
					{ data: 'cancel_reason' },
					{
						data: null,
						className: "dt-center detailOrdersLazada",
						defaultContent: '<td class="align-middle"><a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">Detail</a></td>'
					}
				],
				"footerCallback": function ( row, data, start, end, display ) {
		            var api = this.api(), data;
		 
		            var intVal = function ( i ) {
		                return typeof i === 'string' ?
		                    i.replace(/[\$,]/g, '')*1 :
		                    typeof i === 'number' ?
		                        i : 0;
		            };
		 
		            total = api
		                .column( 6 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            pageTotal = api
		                .column( 6, { page: 'current'} )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            $( api.column( 2 ).footer() ).html(
		                "Total Page ini: "+numberRenderer(pageTotal) +' ( '+numberRenderer(total) +' Total Semua Page)'
		            );
		        }
			});
		};

		function validasiReturn(argument) {
			if ($('#tanggalAwalReturn').val() == '') {
				$("#isiToastGagal").html('harap isi tanggal awal');
				$("#dangerToast").toast('show');
				return false;
			} else if ($('#tanggalAkhirReturn').val() == '') {
				$("#isiToastGagal").html('harap isi tanggal akhir');
				$("#dangerToast").toast('show');
				return false;
			} else {
				return true;
			}
		}

		$('#btn-searchReturn').on('click', function() {
			const dateToInt = $('#tanggalAkhirReturn').val().split('-');
			const dateFromInt = $("#tanggalAwalReturn").val().split('-');
			const oneDay = 24 * 60 * 60 * 1000;
			const fDate = new Date(dateToInt[2], dateToInt[1], dateToInt[0]);
			const tDate = new Date(dateFromInt[2], dateFromInt[1], dateFromInt[0]);
			const dateRange = Math.round(Math.abs((fDate - tDate) / oneDay));
			console.log(dateRange);
			if (dateRange > 15) {
				$("#isiToastGagal").html('Range Tanggal tidak boleh melebihi 15 hari');
				$("#dangerToast").toast('show');
			} else if (dateToInt[2]+dateToInt[1]+dateToInt[0] < dateFromInt[2]+dateFromInt[1]+dateFromInt[0]) {
				$("#isiToastGagal").html('Tanggal akhir harus lebih besar dari tanggal awal');
				$("#dangerToast").toast('show');
			} else {
				if (validasiReturn() == true) {
					tableReturn($('#tanggalAwalReturn').val(), $("#tanggalAkhirReturn").val());
					// $.ajax({
					//     type: 'POST',
					//     url: '<?php echo base_url()?>Shopee/getOrdersShopee',
					//     data: 'dateFrom='+$('#tanggalAwalReturn').val()+'&dateTo='+$("#tanggalAkhirReturn").val()+'&type=Return',
					//     dataType: 'json',
					//     success: function(data){
					//     console.log(data.message);
					//     	if (data.message === '' || data.message === undefined) {
					// 			$("#isiToastSuccess").html('Berhasil mengambil data');
					// 			$("#successToast").toast('show');
					// 		}else{
					// 			$("#isiToastGagal").html('Message: '+data.message.split(',')[1]+' <p>Jika error refresh_token harap login ulang akun online shop anda</p>');
					// 			$("#dangerToast").toast('show');
					//     	}
					// 	    tableReturn(data);
					//     }
					// })
				}
			}
		});

		$("#tReturn").on("click", 'td.detailOrdersLazada', function() {
			console.log(table.row(this).data());
			const data = table.row(this).data();
			$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url()?>Dashboard/getOrderLazada',
			    dataType: 'json',
			    data: 'orderId='+data.order_id,
			    success: function(data){
			      console.log(data);
			      lazadaDatatable(data);
			    }
			})
		});
		$('#tReturn').on( 'page.dt', function () {
		    var info = table.page.info();
		    console.log(info);
		} );
	} );
</script>