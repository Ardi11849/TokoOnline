<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('shopee/css/css');?>

<body class="g-sidenav-show  bg-gray-200">
	<?php $this->load->view('template/sidebar');?>
	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<?php $this->load->view('template/toast'); ?>
		<?php $this->load->view('shopee/isi/order/unpaid'); ?>
		<?php $this->load->view('shopee/isi/order/invoicePending'); ?>
		<?php $this->load->view('shopee/isi/order/readyToShip'); ?>
		<?php $this->load->view('shopee/isi/order/shipped'); ?>
		<?php $this->load->view('shopee/isi/order/processed'); ?>
		<?php $this->load->view('shopee/isi/order/completed'); ?>
		<?php $this->load->view('shopee/isi/order/inCancel'); ?>
		<?php $this->load->view('shopee/isi/order/cancelled'); ?>
		<?php $this->load->view('shopee/isi/return/return'); ?>
		<?php $this->load->view('template/footer'); ?>
	</main>
	<?php $this->load->view('template/setting');?>
  <?php $this->load->view('shopee/js/order/js');?>
  <?php $this->load->view('shopee/js/order/unpaid');?>
  <?php $this->load->view('shopee/js/order/invoicePending');?>
  <?php $this->load->view('shopee/js/order/readyToShip');?>
  <?php $this->load->view('shopee/js/order/shipped');?>
  <?php $this->load->view('shopee/js/order/processed');?>
  <?php $this->load->view('shopee/js/order/completed');?>
  <?php $this->load->view('shopee/js/order/inCancel');?>
  <?php $this->load->view('shopee/js/order/cancelled');?>
  <?php $this->load->view('shopee/js/return/return');?>
</body>

</html>