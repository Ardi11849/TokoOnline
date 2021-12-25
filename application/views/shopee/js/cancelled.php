<script type="text/javascript">
	$(document).ready( function () {
		$('#tanggalAwalCancelled').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		$('#tanggalAkhirCancelled').datepicker({
			uiLibrary: 'bootstrap4',
			format: 'dd-mm-yyyy'
		});
		var table;
		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
		function tableCancelled(data) {
			console.log(data);
		    table = $('#tCancelled').DataTable({
				dom: 'Bfrtip',
				buttons: [{extend: 'excel', footer: true}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
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

		function validasiCancelled(argument) {
			if ($('#tanggalAwalCancelled').val() == '') {
				$("#isiToastGagal").html('harap isi tanggal awal');
				$("#dangerToast").toast('show');
				return false;
			} else if ($('#tanggalAkhirCancelled').val() == '') {
				$("#isiToastGagal").html('harap isi tanggal akhir');
				$("#dangerToast").toast('show');
				return false;
			} else {
				return true;
			}
		}

		$('#btn-searchCancelled').on('click', function() {
			var dateToInt = $('#tanggalAkhirCancelled').val().split('-');
			var dateFromInt = $("#tanggalAwalCancelled").val().split('-');
			var dateRange = (dateToInt[2] + dateToInt[1] + dateToInt[0]) - (dateFromInt[2] + dateFromInt[1] + dateFromInt[0]);
			console.log($('#tanggalAkhirCancelled').val().split('-')[0]);
			console.log(dateFromInt);
			console.log(dateRange);
			if (dateRange > 15) {
				$("#isiToastGagal").html('Range Tanggal tidak boleh melebihi 15 hari');
				$("#dangerToast").toast('show');
			} else if (dateToInt < dateFromInt) {
				$("#isiToastGagal").html('Tanggal akhir harus lebih besar dari tanggal awal');
				$("#dangerToast").toast('show');
			} else {
				if (validasiCancelled() == true) {
					$.ajax({
					    type: 'POST',
					    url: '<?php echo base_url()?>Shopee/getOrdersShopee',
					    data: 'dateFrom='+$('#tanggalAwalCancelled').val()+'&dateTo='+$("#tanggalAkhirCancelled").val()+'&type=CANCELLED',
					    dataType: 'json',
					    success: function(data){
							$("#isiToastSuccess").html('Berhasil mengambil data');
							$("#successToast").toast('show');
					      	tableCancelled(data);
					    }
					})
				}
			}
		});

		$("#tCancelled").on("click", 'td.detailOrdersLazada', function() {
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