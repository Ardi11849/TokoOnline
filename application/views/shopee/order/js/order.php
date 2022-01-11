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
    $('#tanggalAwal').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    $('#tanggalAkhir').datepicker({
      uiLibrary: 'bootstrap5',
      format: 'dd-mm-yyyy'
    });
    var table;
    var numberRenderer = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. '  ).display;
    function tableOrderan(from, to, type) {
      loading();
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
          { data: 'buyer_username' },
          { 
            data: 'item_list.0.model_discounted_price',
            render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' )
          },
          { 
            data: 'order_status', 
            render: function (data, type, row) {
                  if(data === 'UNPAID') return "Belum Di Bayar";
                  if(data === 'INVOICE_PANDING') return "Menunggu Konfirm Pembeli";
                  if(data === 'READY_TO_SHIP') return "Belum Di Bayar";
                  if(data === 'SHIPPED') return "Dikirim";
                  if(data === 'PROCESSED') return "Diproses";
                  if(data === 'COMPLETED') return "Selesai";
                  if(data === 'IN_CANCEL') return "Menunggu Respon Pembatalan Seller";
                  if(data === 'CANCELLED') return "Dibatalkan";
                  if(data === 'TO_CONFIRM_RECEIVE') return "Konfirmasi Penerimaan";
              } 
          },
          { data: 'cancel_reason' }
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
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                pageTotal = api
                    .column( 4, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
     
                $( api.column().footer() ).html(
                    "Total Page ini: "+numberRenderer(pageTotal)
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
        }
      }
    });
    $('#tOrder').on( 'page.dt', function () {
      loading();
    });

    function detailOrderShopee(data) {
      loading();
      $.ajax({
          type: 'POST',
          url: '<?php echo base_url()?>Shopee/getOrderShopee',
          dataType: 'json',
          data: 'order_sn='+data,
          success: function(result){
            $("#loading").waitMe("hide");
            console.log(result);
            var toDate2 = new Date(result[0].create_time * 1000).toISOString()
            var tgl = toDate2.substr(0, 10)+' '+toDate2.substr(11, 8);
            $("#detailOrderModalLabel").html("Detail No Pembeli: "+data+"<span style='float:right;'>"+tgl);
            $("#userIdModalOrder").html("<strong>User Id:</strong> "+result[0].buyer_user_id);
            $("#usernameModalOrder").html("<strong>Username:</strong> "+result[0].buyer_username);
            $("#messageModalOrder").html("<strong>Pesan Untuk Penjual:</strong> "+result[0].message_to_seller);
            $("#cancelByModalOrder").html("<strong>Di Batalkan Oleh:</strong> "+result[0].cancel_by);
            $("#reasonCancelModalOrder").html("<strong>Alasan Batal:</strong> "+result[0].buyer_cancel_reason);
            $("#metodePembayaranModalOrder").html("<strong>Metode Pembayaran:</strong> "+result[0].payment_method);
            $("#provinsiModalOrder").html("<strong>Provinsi:</strong> "+result[0].recipient_address.state);
            $("#kotaModalOrder").html("<strong>Kota/Kab:</strong> "+result[0].recipient_address.city);
            $("#kecamatanModalOrder").html("<strong>Kecamatan:</strong> "+result[0].recipient_address.district);
            $("#kodePosModalOrder").html("<strong>Kode Pos:</strong> "+result[0].recipient_address.zipcode);
            $("#alamatModalOrder").html("<strong>Alamat Lengkap:</strong> "+result[0].recipient_address.full_address);
            $("#idBarangModalOrder").html("<strong>ID Barang:</strong> "+result[0].item_list[0].item_id);
            $("#namaBarangModalOrder").html("<strong>Nama Barang:</strong> "+result[0].item_list[0].item_name);
            $("#skuBarangModalOrder").html("<strong>SKU Barang:</strong> "+result[0].item_list[0].item_sku);
            $("#hargaBarangModalOrder").html("<strong>Harga Barang:</strong> <span class='harga'>"+result[0].item_list[0].model_discounted_price)+"</span>";
            $("#idModelModalOrder").html("<strong>Id Model:</strong> "+result[0].item_list[0].model_id);
            $("#namaModelModalOrder").html("<strong>Nama Model:</strong> "+result[0].item_list[0].model_name);
            $("#skuModelModalOrder").html("<strong>SKU Model:</strong> "+result[0].item_list[0].model_sku);
            $("#jumlahBeliModalOrder").html("<strong>Jumlah Beli:</strong> "+result[0].item_list[0].model_quantity_purchased);
            $("#idPesanaBarangModalOrder").html("<strong>Id Pesanan:</strong> "+result[0].item_list[0].order_item_id);
            $("#beratModalOrder").html("<strong>Berat:</strong> "+result[0].item_list[0].weight);
            $("#ekspedisiOrderModal").html(result[0].package_list[0].shipping_carrier);
            $("#idPengirimanOrderModal").html(result[0].package_list[0].package_number);
            $("#statusEkspedisiOrderModal").html(result[0].package_list[0].logistics_status);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()?>Shopee/trackOrderShopee',
                dataType: 'json',
                data: 'order_sn='+data,
                success: function(result2){
                  console.log(result2)
                  var html = '<p></p>';
                  for (var i = 0; i <= result2.response.tracking_info.length - 1; i++) {
                    var toDate = new Date(result2.response.tracking_info[i].update_time * 1000).toISOString()
                    var date = toDate.substr(0, 10)+' '+toDate.substr(11, 8);
                    html += '<li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">'+
                        '<div class="avatar me-3">'+
                          '<i class="fa fa-truck" style="color: black;"></i>'+
                        '</div>'+
                        '<div class="d-flex align-items-start flex-column justify-content-center">'+
                          '<h6 class="mb-0 text-sm">'+result2.response.tracking_info[i].logistics_status+'</h6>'+
                          '<p class="mb-0 text-xs">'+result2.response.tracking_info[i].description+'</p>'+
                        '</div>'+
                        '<a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto" href="javascript:;">'+date+'</a>'+
                      '</li>'
                  }
                  $("#listTrackOrder").append(html);
                }
            })
            $('#detailOrderModal').modal('show');
          }
      })
    }
</script>