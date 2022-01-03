<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('template/css');?>
<?php $this->load->view('template/js');?>

<body class="g-sidenav-show  bg-gray-200">
	<?php $this->load->view('template/sidebar');?>
	<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
		<?php $this->load->view('template/toast'); ?>
		<?php $this->load->view('shopee/navbar'); ?>
		<?php $this->load->view('shopee/order/isi/order'); ?>
		<?php $this->load->view('template/footer'); ?>
	</main>
	<?php $this->load->view('template/setting');?>
</body>

</html>