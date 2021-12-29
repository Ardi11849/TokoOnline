<script type="text/javascript">
	$(document).ready( function () {
		$('#tanggalAwalInvoicePending').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		$('#tanggalAkhirInvoicePending').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		var table;
		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
		function tableInvoicePending(data) {
			$('#tInvoicePending').DataTable().destroy();
		    table = $('#tInvoicePending').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel', 'pdf', 'print',],
				scrollX: true,
		        data:  data,
				columns: [
					{ 
						data: 'create_time', 
						render: function (data, type, row) {
							var toDate = new Date(data * 1000).toISOString()
					        return toDate.substr(0, 10)+' '+toDate.substr(11, 8);
					    } 
					},
					{ data: 'buyer_username' },
					{ data: 'buyer_user_id' },
					{ data: 'days_to_ship' },
					{ data: 'estimated_shipping_fee' },
					{ data: 'payment_method' },
					{ data: 'shipping_carrier' },
					{ data: 'total_amount' },
					{ data: 'order_status' },
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
		                .column( 7 )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            pageTotal = api
		                .column( 7, { page: 'current'} )
		                .data()
		                .reduce( function (a, b) {
		                    return intVal(a) + intVal(b);
		                }, 0 );
		 
		            $( api.column( 1 ).footer() ).html(
		                "Total Page ini: "+numberRenderer(pageTotal) +' ( '+numberRenderer(total) +' Total Semua Page)'
		            );
		        }
			});
		};

		$('#btn-searchInvoicePending').on('click', function() {
			var dateToInt = $('#tanggalAkhirInvoicePending').val().split('-');
			var dateFromInt = $("#tanggalAwalInvoicePending").val().split('-');
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
				$.ajax({
				    type: 'POST',
				    url: '<?php echo base_url()?>Shopee/getOrdersShopee',
				    data: 'dateFrom='+$('#tanggalAwalInvoicePending').val()+'&dateTo='+$("#tanggalAkhirInvoicePending").val()+'&type=INVOICE_PENDING',
				    dataType: 'json',
				    success: function(data){
				    	if (data.message != '' || data.message === undefined) {
							$("#isiToastSuccess").html('Berhasil mengambil data');
							$("#successToast").toast('show');
						}else{
							$("#isiToastGagal").html('Message: '+data.message.split(',')[1]+' <p>Jika error refresh_token harap login ulang akun online shop anda</p>');
							$("#dangerToast").toast('show');
				    	}
				    	tableInvoicePending(data);
				    }
				})
			}
		});

		$("#tInvoicePending").on("click", 'td.detailOrdersLazada', function() {
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
	} );
</script>