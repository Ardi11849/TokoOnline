<!--   Core JS Files   -->
<script src="<?php echo base_url()?>assets/js/core/popper.min.js"></script>
<script src="<?php echo base_url()?>assets/js/core/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?php echo base_url()?>assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="<?php echo base_url()?>assets/js/plugins/chartjs.min.js"></script>
<script src="<?php echo base_url()?>assets/js/jquery.min.js"></script>
<script src="<?php echo base_url()?>template/DataTables/datatables.min.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="<?php echo base_url();?>assets/js/material-dashboard.min.js?v=3.0.0"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.11.3/dataRender/datetime.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
  <script type="text/javascript">
    $.fn.dataTable.ext.errMode = 'none';
     const beamsClient = new PusherPushNotifications.Client({
      instanceId: '12b60059-f1a5-4f32-9cd8-eac3defaaa55',
    });

    beamsClient.start()
    .then(() => beamsClient.addDeviceInterest('hello'))
    .then(() => console.log('Successfully registered and subscribed!'))
    .catch(console.error);

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('bb43daf7ba6cf7a53184', {
      cluster: 'ap1'
    });

    var channel = pusher.subscribe('webhook');
    channel.bind('my-event', function(data) {
      $("#isiToastInfo").html(data.type+': '+data.message);
      $("#infoToast").toast('show');
      // alert(JSON.stringify(data));
      var toDate = new Date(data.timestamp * 1000).toISOString()
      var getDate = toDate.substr(0, 10)+' '+toDate.substr(11, 8);
      $("#isiNotification").append('<li class="mb-2 nf">'+
                  '<a class="dropdown-item border-radius-md" href="javascript:;">'+
                    '<div class="d-flex py-1">'+
                      '<div class="my-auto">'+
                        '<img src="'+data.image+'" class="avatar avatar-sm  me-3 ">'+
                      '</div>'+
                      '<div class="d-flex flex-column justify-content-center">'+
                        '<h6 class="text-sm font-weight-normal mb-1">'+
                          '<span class="font-weight-bold">'+data.type+'</span> '+data.message+
                        '</h6>'+
                        '<p class="text-xs text-secondary mb-0">'+
                          '<i class="fa fa-clock me-1" aria-hidden="true"></i>'+
                          getDate+
                        '</p>'+
                      '</div>'+
                    '</div>'+
                  '</a>'+
                '</li>');
      $('#countNotification').html($('.nf').length);
    });
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
    })
  </script>