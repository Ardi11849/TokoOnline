<script type="text/javascript">
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
        lengthMenu: [
          [ 10, 25, 50 ],
          [ '10 rows', '25 rows', '50 rows' ]
        ],
        buttons: [
            {extend: 'excel', footer: true, title: 'Lazada Saldo tanggal: '+from+' - '+to}, 
            {extend: 'pdf', footer: true}, 
            {extend: 'print', footer: true},
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
        Saldoing: false,
        paging: true,
        processing: true,
        serverSide: false,
        ajax: {
          url: '<?php echo base_url()?>Lazada/getTransactionsLazada',
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
          { data: 'transaction_date' },
          { data: 'fee_name' },
          { data: 'transaction_number' },
          { 
            data: 'order_no', 
            render: function (data, type, row) {
              return '<button class="btn btn-link" onclick="detailOrderLazada(\''+data+'\')">'+data+"</button>"
            } 
          },
          { 
            data: 'VAT_in_amount',
            render: $.fn.dataTable.render.number( ',', '.', 0, ' Rp. ' )
          },
          { 
            data: 'WHT_amount',
            render: $.fn.dataTable.render.number( ',', '.', 0, ' Rp. ' )
          },
          { 
            data: 'amount', 
            render: $.fn.dataTable.render.number( ',', '.', 0, ' Rp. ' )
          },
          { 
            data: 'paid_status', 
            render: function (data, type, row) {
                  if(data === 'Not paid') return "Belum Di Bayar";
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

    function validasiSaldo() {
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
      if (dateToInt[2]+dateToInt[1]+dateToInt[0] < dateFromInt[2]+dateFromInt[1]+dateFromInt[0]) {
        $("#isiToastGagal").html('Tanggal akhir harus lebih besar dari tanggal awal');
        $("#dangerToast").toast('show');
      } else {
        if (validasiSaldo() == true) {
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
</script>