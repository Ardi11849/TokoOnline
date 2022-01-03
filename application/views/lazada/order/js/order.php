<script type="text/javascript">
	$(document).ready( function () {
		var table;
		var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
		function lazadaDatatable(data) {
		    table = $('#tOrderLazada').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel', 'pdf', 'print',],
				scrollX: true,
		        data:  data,
				columns: [
					{ data: 'created_at' },
					{ data: 'address_billing.first_name' },
					{ data: 'items_count' },
					{ data: 'order_id' },
					{ data: 'order_number' },
					{ data: 'payment_method' },
					{ data: 'price' },
					{ data: 'shipping_fee' },
					{ data: 'statuses' },
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
		 
		            $( api.column( 0 ).footer() ).html(
		                numberRenderer(pageTotal) +' ( '+numberRenderer(total) +' Total Semua Page)'
		            );
		        }
			});
		};

		getOrders();
		function getOrders() {
		  $.ajax({
		    type: 'GET',
		    url: '<?php echo base_url()?>Lazada/getOrdersLazada',
		    dataType: 'json',
		    success: function(data){
		      console.log(data.data.orders);
		      lazadaDatatable(data.data.orders);
		    }
		  })
		};

		$("#tbarangLazada").on("click", 'td.detailOrdersLazada', function() {
			console.log(table.row(this).data());
			const data = table.row(this).data();
			$.ajax({
			    type: 'POST',
			    url: '<?php echo base_url()?>Lazada/getOrderLazada',
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