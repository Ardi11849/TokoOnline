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
  <script type="text/javascript">
    $.fn.dataTable.ext.errMode = 'none';
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
    $("a.shopee").addClass('active bg-gradient-primary');
    $("a.dashboard").removeClass('active bg-gradient-primary');
    $("a.lazada").removeClass('active bg-gradient-primary');
  </script>