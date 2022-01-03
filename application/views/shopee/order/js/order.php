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
    $('#tanggalAwal').datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd-mm-yyyy'
    });
    $('#tanggalAkhir').datepicker({
      uiLibrary: 'bootstrap4',
      format: 'dd-mm-yyyy'
    });
    var table;
    var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
    // function table(data) {
    function tableOrderan(from, to, type) {
      $('#tOrder').DataTable().destroy();
        return table = $('#tOrder').DataTable({
        dom: 'Bfrtip',
        buttons: [{extend: 'excel', footer: true, title: 'Shopee order tanggal: '+from+' - '+to}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
        scrollX: true,
        ordering: false,
        paging: true,
        processing: true,
        serverSide: true,
        "pageLength": 49,
        ajax: {
          url: '<?php echo base_url()?>Shopee/getOrdersShopee',
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
              console.log(d);
            if (d.message === '' || d.message === undefined) {
            $("#isiToastSuccess").html('Berhasil mengambil data');
            $("#successToast").toast('show');
          }else{
            $("#isiToastGagal").html('Message: '+d.message+' <br><p>Note: Jika error refresh_token harap login ulang akun online shop anda</p>');
            $("#dangerToast").toast('show');
            }
               return d
            }
        },
      //       data:  data,
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
          { data: 'buyer_username' },
          { data: 'item_list.0.item_name' },
          { data: 'days_to_ship' },
          { data: 'estimated_shipping_fee' },
          { data: 'payment_method' },
          { data: 'item_list.0.model_discounted_price' },
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
     
                $( api.column( 2 ).footer() ).html(
                    "Total Page ini: "+numberRenderer(pageTotal) +' ( '+numberRenderer(total) +' Total Semua Page)'
                );
            }
      });
    };

    function validasi() {
      if ($('#tanggalAwal').val() == '') {
        $("#isiToastGagal").html('harap isi tanggal awal');
        $("#dangerToast").toast('show');
        return false;
      } else if ($('#tanggalAkhir').val() == '') {
        $("#isiToastGagal").html('harap isi tanggal akhir');
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

    $('#btn-searchOrder').on('click', function() {
      const dateToInt = $('#tanggalAkhir').val().split('-');
      const dateFromInt = $("#tanggalAwal").val().split('-');
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
          tableOrderan($('#tanggalAwal').val(), $("#tanggalAkhir").val(), $("#type").val());
          // $.ajax({
          //     type: 'POST',
          //     url: '<?php echo base_url()?>Shopee/getOrdersShopee',
          //     data: 'dateFrom='+$('#tanggalAwal').val()+'&dateTo='+$("#tanggalAkhir").val()+'&type=',
          //     dataType: 'json',
          //     success: function(data){
          //     console.log(data.message);
          //      if (data.message === '' || data.message === undefined) {
          //      $("#isiToastSuccess").html('Berhasil mengambil data');
          //      $("#successToast").toast('show');
          //    }else{
          //      $("#isiToastGagal").html('Message: '+data.message.split(',')[1]+' <p>Jika error refresh_token harap login ulang akun online shop anda</p>');
          //      $("#dangerToast").toast('show');
          //      }
          //      table(data);
          //     }
          // })
        }
      }
    });

    $("#tOrder").on("click", 'td.detailOrdersLazada', function() {
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
    $('#tOrder').on( 'page.dt', function () {
        var info = table.page.info();
        console.log(info);
    } );
  } );
</script>