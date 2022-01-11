<script type="text/javascript">
  $(document).ready( function () {
    $('#tanggalAwalSaldo').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    $('#tanggalAkhirSaldo').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    var table;
    var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
    function tableSaldo(from, to, type) {
      loading();
      $('#tSaldo').DataTable().destroy();
        return table = $('#tSaldo').DataTable({
        dom: 'Bfrtip',
        buttons: [{extend: 'excel', footer: true, title: 'Shopee Saldo tanggal: '+from+' - '+to}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
        scrollX: true,
        Saldoing: false,
        paging: true,
        processing: true,
        serverSide: true,
        "pageLength": 49,
        ajax: {
          url: '<?php echo base_url()?>Shopee/getSaldoShopee',
          type:'POST',
          data: {
            dateFrom: from,
            dateTo: to
          },
            "error": function (e) {
              console.log(e);
              $("#loading").waitMe("hide");
              if (e == 'error_auth') return "token kadaluarsa harap login akun online shop anda";
              return e;
            },
            "dataSrc": function (d) {
              console.log(d);
              $("#loading").waitMe("hide");
              if (d.message === '' || d.message === undefined) {
                $("#isiToastSuccess").html('Berhasil mengambil data');
                $("#successToast").toast('show');
              }else{
                $("#isiToastGagal").html('Message: '+d.message+' <br><p>Note: Jika error refresh_token harap login ulang akun online shop anda</p>');
                $("#dangerToast").toast('show');
              }
              return d.data
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
            data: 'create_time', 
            render: function (data, type, row) {
              var toDate = new Date(data * 1000).toISOString()
                  return toDate.substr(0, 10)+' '+toDate.substr(11, 8);
              } 
          },
          { data: 'buyer_name' },
          { data: 'transaction_id' },
          { 
            data: 'order_sn', 
            render: function (data, type, row) {
              return '<button class="btn btn-link" onclick="detailOrderShopee(\''+data+'\')">'+data+"</button>"
            } 
          },
          { data: 'wallet_type' },
          { 
            data: 'amount',
            render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' )
          },
          { 
            data: 'current_balance', 
            render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' )
          },
          { 
            data: 'status', 
            render: function (data, type, row) {
                  if(data === 'FAILED') return "Gagal";
                  if(data === 'COMPLETED') return "Berhasil";
                  if(data === 'PENDING') return "Menunggu";
                  if(data === 'INITIAL') return "Baru";
              } 
          }
        ],
        "rowCallback": function( row, data, index ) {
          console.log(data);
          console.log(data['status']);
          if (type === 'ALL') return true;
          if (data["status"] !== type) {
            console.log(row);
            $(row).empty();
          }
        }
      });
    };

    function validasi() {
      if ($('#tanggalAwalSaldo').val() == '') {
        $("#isiToastGagal").html('harap isi tanggal awal');
        $("#dangerToast").toast('show');
        return false;
      } else if ($('#tanggalAkhirSaldo').val() == '') {
        $("#isiToastGagal").html('harap isi tanggal akhir');
        $("#dangerToast").toast('show');
        return false;
      } else if ($("#typeSaldo").val() == '') {
        $("#isiToastGagal").html('harap pilih type');
        $("#dangerToast").toast('show');
        return false;
      } else {
        return true;
      }
    }

    $('#btn-searchSaldo').on('click', function() {
      const dateToInt = $('#tanggalAkhirSaldo').val().split('-');
      const dateFromInt = $("#tanggalAwalSaldo").val().split('-');
      const oneDay = 24 * 60 * 60 * 1000;
      const fDate = new Date(dateToInt[2], dateToInt[1], dateToInt[0]);
      const tDate = new Date(dateFromInt[2], dateFromInt[1], dateFromInt[0]);
      const dateRange = Math.round(Math.abs((fDate - tDate) / oneDay));
      console.log(dateRange);
      if (dateRange > 14) {
        $("#isiToastGagal").html('Range Tanggal tidak boleh melebihi 15 hari');
        $("#dangerToast").toast('show');
      } else if (dateToInt[2]+dateToInt[1]+dateToInt[0] < dateFromInt[2]+dateFromInt[1]+dateFromInt[0]) {
        $("#isiToastGagal").html('Tanggal akhir harus lebih besar dari tanggal awal');
        $("#dangerToast").toast('show');
      } else {
        if (validasi() == true) {
          tableSaldo($('#tanggalAwalSaldo').val(), $("#tanggalAkhirSaldo").val(), $("#typeSaldo").val());
        }
      }
    });

    $("#tSaldo").on("click", 'td.detailSaldoLazada', function() {
      console.log(table.row(this).data());
      const data = table.row(this).data();
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url()?>Dashboard/getSaldoLazada',
          dataType: 'json',
          data: 'SaldoId='+data.Saldo_id,
          success: function(data){
            console.log(data);
            lazadaDatatable(data);
          }
      })
    });
    $('#tSaldo').on( 'page.dt', function () {
      loading();
    });
  } );
</script>