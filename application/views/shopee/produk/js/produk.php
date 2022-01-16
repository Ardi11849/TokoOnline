<script type="text/javascript">
    var table;
    function tableProduk(type) {
        loading();
        $('#tProduk').DataTable().destroy();
        return table = $('#tProduk').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {extend: 'excel', footer: true, title: 'Shopee produk'}, 
                {extend: 'pdf', footer: true}, {extend: 'print', footer: true},
                'pageLength', 
                {
                text: 'Simpan ke DB', action: function ( e, dt, node, config ) {
                  var data = [];
                  dt.buttons.exportData().body.forEach((item) => {
                    console.log(item);
                     data.push("('<?php echo $this->session->userdata('id');?>','<?php echo $this->session->userdata('shopIdShopee');?>','"+item[2]+"','"+item[3]+"','"+item[8]+"','"+item[9]+"','"+item[5]+"','"+item[4].replace("&", " dan ")+"','"+item[10]+"','Shopee','"+item[1]+"','<?php echo $this->session->userdata('id');?>',now())");
                  });
                  saveProduk(data);
                }
                }
            ],
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
                    }else{
                        $("#isiToastGagal").html('Message: '+d.message+' <br><p>Note: Jika error refresh_token harap login ulang akun online shop anda</p>');
                        $("#dangerToast").toast('show');
                    }
                    return d.data;
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
                { data: 'item_id' },
                { data: 'item_name' },
                { data: 'item_sku' },
                { 
                    data: 'image.image_url_list.0',
                    render: function(data, type, row){
                        if (!data) {
                            return ""
                        }else{
                            return "<img src='"+data+"' style='width:100px;height:auto;border-radius:0%'><span style='width: 100%;position: fixed;bottom: 0;'>"+data+"</span></img>"
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
                { data: 'price_info.0.current_price', render: $.fn.dataTable.render.number( ',', '.', 0, 'Rp ' ) },
                { data: 'stock_info.0.normal_stock' },
                { data: 'item_status' },
                {
                    data: null,
                    className: "dt-center detailProduksShopee",
                    defaultContent: '<td class="align-middle"><a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">Detail</a></td>'
                }
            ]
        });
    };

    function saveProduk(data) {
            loading();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url()?>Shopee/saveProdukShopee',
            dataType: 'json',
                    data: 'data='+data,
            success: function(result){
                $("#loading").waitMe("hide");
                            $("#isiToastSuccess").html('Berhasil menyimpan data');
                            $("#successToast").toast('show');
            }
        })
    }

    function validasiProduk() {
        if ($('#typeProduk').val() == '') {
            $("#isiToastGagal").html('harap pilih type produk');
            $("#dangerToast").toast('show');
            return false;
        } else {
            return true;
        }
    }

    $('#btn-searchProduk').on('click', function() {
        if (validasiProduk() == true) {
            tableProduk($("#typeProduk").val());
        }
    });

    $("#tProduk").on("click", 'td.detailProduksShopee', function() {
        console.log(table.row(this).data());
        const data = table.row(this).data();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url()?>Dashboard/getProdukShopee',
            dataType: 'json',
            data: 'ProdukId='+data.Produk_id,
            success: function(data){
                console.log(data);
                ShopeeDatatable(data);
            }
        })
    });
    $('#tProduk').on( 'page.dt', function () {
        loading();
    } );
</script>