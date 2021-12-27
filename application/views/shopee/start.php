<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('shopee/css/css');?>

<body class="g-sidenav-show  bg-gray-200">
	<?php $this->load->view('template/sidebar');?>
	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<?php $this->load->view('template/toast'); ?>
		<?php $this->load->view('shopee/isi/unpaid'); ?>
		<?php $this->load->view('shopee/isi/invoicePending'); ?>
		<?php $this->load->view('shopee/isi/readyToShip'); ?>
		<?php $this->load->view('shopee/isi/shipped'); ?>
		<?php $this->load->view('shopee/isi/processed'); ?>
		<?php $this->load->view('shopee/isi/completed'); ?>
		<?php $this->load->view('shopee/isi/inCancel'); ?>
		<?php $this->load->view('shopee/isi/cancelled'); ?>
		<?php $this->load->view('template/footer'); ?>
	</main>
	<?php $this->load->view('template/setting');?>
  <?php $this->load->view('shopee/js/js');?>
  <?php $this->load->view('shopee/js/unpaid');?>
  <?php $this->load->view('shopee/js/invoicePending');?>
  <?php $this->load->view('shopee/js/readyToShip');?>
  <?php $this->load->view('shopee/js/shipped');?>
  <?php $this->load->view('shopee/js/processed');?>
  <?php $this->load->view('shopee/js/completed');?>
  <?php $this->load->view('shopee/js/inCancel');?>
  <?php $this->load->view('shopee/js/cancelled');?>
</body>

</html>