<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('dashboard/css/css');?>

<body class="g-sidenav-show  bg-gray-200">
	<?php $this->load->view('template/sidebar');?>
	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<?php $this->load->view('dashboard/isi/lazada'); ?>
		<?php $this->load->view('dashboard/isi/shopee'); ?>
		<?php $this->load->view('dashboard/isi/bukalapak'); ?>
		<?php $this->load->view('template/footer'); ?>
	</main>
	<?php $this->load->view('template/setting');?>
  <?php $this->load->view('dashboard/js/js');?>
  <?php $this->load->view('dashboard/js/lazada');?>
</body>

</html>