<script type="text/javascript">
	$(document).ready( function () {
		var table;
		function lazadaDatatable(data) {
		    table = $('#tProdukLazada').DataTable({
				dom: 'Bfrtip',
				buttons: ['excel', 'pdf', 'print',],
				scrollX: true,
		        data:  data,
				columns: [
					{ data: 'item_id' },
					{ data: 'attributes.name' },
					{ 
						data: 'attributes.description',
						render: function(data, type, row){
							data = data.replace(/<\/?span[^>]*>/g,"");
							data = data.replace(/<\/?p[^>]*>/g,"");
							return "<span style='display: block;width: 350px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;'>"+data+"</span>"
						}
					},
					{ data: 'skus.0.price' },
					{ data: 'skus.0.quantity' },
					{ 
						data: 'images',
						render: function(data, type, row){
							if (!data) {
								return ""
							}else{
								return "<img src='"+data+"' style='width:100px;height:auto;border-radius:0%'></img>"
							}
						}
					},
					{ data: 'skus.0.SellerSku' },
					{ data: 'skus.0.ShopSku' },
					{ data: 'skus.0.SkuId' },
					{ data: 'skus.0.Status' },
					{
						data: null,
						className: "dt-center detailProdukLazada",
						defaultContent: '<td class="align-middle"><a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">Detail</a></td>'
					}
				]
			});
		};

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
			      lazadaDatatable(data);
			    }
			})
		});

		setTimeout(getProducts(), 1000);

		function getProducts() {
		  $.ajax({
		    type: 'GET',
		    url: '<?php echo base_url()?>Lazada/getProductsLazada',
		    dataType: 'json',
		    success: function(data){
		      console.log(data);
		      lazadaDatatable(data.data.products);
	      	  lazadaShowProduk(data.data.products);
		    }
		  })
		}
	} );
</script>