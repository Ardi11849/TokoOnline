<script type="text/javascript">
  $(document).ready( function () {
    $('#tanggalAwalProduk').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    $('#tanggalAkhirProduk').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    var table;
    var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
    // function table(data) {
    function tableProduk(type) {
      loading();
      $('#tProduk').DataTable().destroy();
      return table = $('#tProduk').DataTable({
        dom: 'Bfrtip',
        buttons: [{extend: 'excel', footer: true, title: 'Shopee Produk'}, {extend: 'pdf', footer: true}, {extend: 'print', footer: true}],
        scrollX: true,
        Produking: false,
        paging: true,
        processing: true,
        serverSide: true,
        "pageLength": 10,
        ajax: {
          url: '<?php echo base_url()?>Shopee/getProductsShopee',
          type:'POST',
          data: {
            type: type
          },
          "error": function (e) {
            console.log(e);
            console.log(e.responseText);
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
              // d.recordsTotal = d.recordsTotal;
              // d.recordsFiltered = 10;
              // d.draw = 1;
            }else{
              $("#isiToastGagal").html('Message: '+d.message+' <br><p>Note: Jika error refresh_token harap login ulang akun online shop anda</p>');
              $("#dangerToast").toast('show');
            }
             return d.data;
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
          { data: 'item_name' },
          { data: 'item_sku' },
          { 
            data: 'image.image_url_list.0',
            render: function(data, type, row){
              if (!data) {
                return ""
              }else{
                return "<img src='"+data+"' style='width:100px;height:auto;border-radius:0%'></img>"
              }
            }
          },
          { data: 'brand.original_brand_name' },
          { 
            data: 'pre_order.is_pre_order',
            render: function(data, type, row){
              if (data === false) {
                return "Tidak pre order"
              }else{
                return "Sedang pre order"
              }
            }
          },
          { data: 'price_info.0.currency'+'price_info.0.current_price' },
          { data: 'item_status' },
          {
            data: null,
            className: "dt-center detailProduksLazada",
            defaultContent: '<td class="align-middle"><a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">Detail</a></td>'
          }
        ]
      });
    };

    function validasi() {
      if ($('#typeProduk').val() == '') {
        $("#isiToastGagal").html('harap pilih type produk');
        $("#dangerToast").toast('show');
        return false;
      } else {
        return true;
      }
    }

    $('#btn-searchProduk').on('click', function() {
      if (validasi() == true) {
        tableProduk($("#typeProduk").val());
      }
    });

    $("#tProduk").on("click", 'td.detailProduksLazada', function() {
      console.log(table.row(this).data());
      const data = table.row(this).data();
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url()?>Dashboard/getProdukLazada',
          dataType: 'json',
          data: 'ProdukId='+data.Produk_id,
          success: function(data){
            console.log(data);
            lazadaDatatable(data);
          }
      })
    });
    $('#tProduk').on( 'page.dt', function () {
      loading();
    } );
  } );
</script>