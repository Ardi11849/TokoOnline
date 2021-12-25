<script type="text/javascript">
	$(document).ready( function () {
		$('#tanggalAwalProcessed').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		$('#tanggalAkhirProcessed').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		var table;
		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
		function tableProcessed(data) {
			console.log(data);
		    table = $('#tProcessed').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel', 'pdf', 'print',],
				scrollX: true,
		        data:  data,
				columns: [
					{ data: 'create_time' },
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

		$('#btn-searchProcessed').on('click', function() {
			var dateToInt = parseInt($('#tanggalAkhirProcessed').val().split('-'));
			var dateFromInt = parseInt($("#tanggalAwalProcessed").val().split('-'));
			var dateRange = dateToInt - dateFromInt;
			if (dateRange > 15) {
				$("#isiToastGagal").html('Range Tanggal tidak boleh melebihi 15 hari');
				$("#dangerToast").toast('show');
			} else if (dateToInt < dateFromInt) {
				$("#isiToastGagal").html('Tanggal akhir harus lebih besar dari tanggal awal');
				$("#dangerToast").toast('show');
			} else {
			$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url()?>Shopee/getOrdersShopee',
			    data: 'dateFrom='+$('#tanggalAwalProcessed').val()+'&dateTo='+$("#tanggalAkhirProcessed").val()+'&type=PROCESSED',
			    dataType: 'json',
			    success: function(data){
					$("#isiToastSuccess").html('Berhasil mengambil data');
					$("#successToast").toast('show');
			      	console.log(data);
			      	tableProcessed(data);
			    }
			})
			}
		});

		$("#tProcessed").on("click", 'td.detailOrdersLazada', function() {
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