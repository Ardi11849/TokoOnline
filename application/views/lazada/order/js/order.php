<script type="text/javascript">
$('#selectAkunLazada').val('<?php echo $this->session->userdata('shopIdLazada');?>');
$('#selectAkunLazada').trigger('change');
$('#selectAkunLazada').on('change', function() {
  $.ajax({
    type: 'post',
    url: '<?php echo base_url()?>Lazada/setSession',
    data: $(this).find(':selected').data(),
    dataType: 'json',
    success: function(data){
      console.log(data);
      getProducts();
      getChat();
    }
  })
});
$(document).ready( function () {
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
		$('#tOrderLazada').DataTable().destroy();
		return table = $('#tOrderLazada').DataTable({
			dom: 'Bfrtip',
			buttons: [{extend: 'excel', footer: true, title: 'Lazada order tanggal: '+from+' - '+to}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
			scrollX: true,
			ordering: false,
			paging: true,
			processing: true,
			serverSide: true,
			'pageLength': 100,
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
					if (e == 'error_auth') return "token kadaluarsa harap login akun online shop anda";
					// return e
				},
				"dataSrc": function (d) {
					if (d.message === '' || d.message === undefined) {
						$("#isiToastSuccess").html('Berhasil mengambil data');
						$("#successToast").toast('show');
						d.recordsTotal = d.data.data.countTotal;
						d.recordsFiltered = d.data.data.countTotal;
						d.draw = d.draw;
						return d.data.data.orders
					}else{
						$("#isiToastGagal").html('Message: '+d.message+' <br><p>Note: Jika error refresh_token harap login ulang akun online shop anda</p>');
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
				  return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
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
    			numberRenderer(pageTotal) +' ( '+numberRenderer(total) +' Total Semua Page)'
				);
			}
		});
	};

	function validasi() {
		if ($('#tanggalAwal').val() == '') {
			$("#isiToastGagal").html('harap isi tanggal awal');
			$("#dangerToast").toast('show');
			return false;
		} else if ($('#type').val() == '') {
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
			if (validasi() == true) {
				tableOrderan($('#tanggalAwal').val(), $("#tanggalAkhir").val(), $("#type").val());
			}
		}
	});

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
});
</script>