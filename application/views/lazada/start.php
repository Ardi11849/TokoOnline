<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('lazada/css/css');?>

<body class="g-sidenav-show  bg-gray-200">
	<?php $this->load->view('template/sidebar');?>
	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<?php $this->load->view('template/toast'); ?>
		<?php $this->load->view('lazada/isi/chat'); ?>
		<?php $this->load->view('lazada/isi/order'); ?>
		<?php $this->load->view('lazada/isi/produk'); ?>
		<?php $this->load->view('template/footer'); ?>
	</main>
	<?php $this->load->view('template/setting');?>
  <?php $this->load->view('lazada/js/js');?>
  <?php $this->load->view('lazada/js/chat');?>
  <?php $this->load->view('lazada/js/order');?>
  <?php $this->load->view('lazada/js/produk');?>
</body>

</html>