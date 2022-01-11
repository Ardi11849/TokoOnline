<script type="text/javascript">
    $('select').select2();
    $('#selectAkunShopee').val('<?php echo $this->session->userdata('shopIdShopee');?>');
    $('#selectAkunShopee').trigger('change');
    $('#selectAkunShopee').on('change', function() {
      $.ajax({
        type: 'post',
        url: '<?php echo base_url()?>Shopee/setSession',
        data: $(this).find(':selected').data(),
        dataType: 'json',
        success: function(data){
          console.log(data);
        }
      })
    });
    $("a.shopee").addClass('active bg-gradient-primary');
    $("a.dashboard").removeClass('active bg-gradient-primary');
    $("a.lazada").removeClass('active bg-gradient-primary');
  $(document).ready( function () {
    $('#tanggalAwalReturn').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    $('#tanggalAkhirReturn').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    var table;
    var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
    // function table(data) {
    function tableReturnan(from, to, type) {
      loading();
      $('#tReturn').DataTable().destroy();
      table = $('#tReturn').DataTable({
        dom: 'Bfrtip',
        buttons: [{extend: 'excel', footer: true, title: 'Shopee Return tanggal: '+from+' - '+to}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
        scrollX: true,
        Returning: false,
        paging: true,
        processing: true,
        serverSide: true,
        "pageLength": 49,
        ajax: {
          url: '<?php echo base_url()?>Shopee/getReturnShopee',
          type:'POST',
          data: {
            dateFrom: from,
            dateTo: to
          },
            "error": function (e) {
              console.log(e);
              $("#loading").waitMe("hide");
              if (e == 'error_auth') return "token kadaluarsa harap login akun online shop anda";
              return e
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
          { 
            data: 'order_sn', 
            render: function (data, type, row) {
              return '<button class="btn btn-link" onclick="detailOrderShopee(\''+data+'\')">'+data+"</button>"
            } 
          },
          { data: 'return_sn' },
          { data: 'tracking_number' },
          { 
            data: 'refund_amount',
            render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' )
          },
          { 
            data: 'status', 
            render: function (data, type, row) {
                  if(data === 'CANCELLED') return "Dibatalkan";
                  if(data === 'REFUND_PAID') return "Pengembalian Dana";
                  if(data === 'CLOSED') return "Ditutup";
              } 
          },
          { data: 'text_reason' }
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
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            pageTotal = api
                .column( 5, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            $( api.column( ).footer() ).html(
                "Total Page ini: "+numberRenderer(pageTotal)
            );
        },
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
      if ($('#tanggalAwalReturn').val() == '') {
        $("#isiToastGagal").html('harap isi tanggal awal');
        $("#dangerToast").toast('show');
        return false;
      } else if ($('#tanggalAkhirReturn').val() == '') {
        $("#isiToastGagal").html('harap isi tanggal akhir');
        $("#dangerToast").toast('show');
        return false;
      } else if ($("#typeReturn").val() == '') {
        $("#isiToastGagal").html('harap pilih type');
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
        if (validasi() == true) {
          tableReturnan($('#tanggalAwalReturn').val(), $("#tanggalAkhirReturn").val(), $("#typeReturn").val());
        }
      }
    });

    $("#tReturn").on("click", 'td.detailReturnsLazada', function() {
      console.log(table.row(this).data());
      const data = table.row(this).data();
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url()?>Dashboard/getReturnLazada',
          dataType: 'json',
          data: 'ReturnId='+data.Return_id,
          success: function(data){
            console.log(data);
            lazadaDatatable(data);
          }
      })
    });
    $('#tReturn').on( 'page.dt', function () {
      loading();
    } );
  } );
</script>