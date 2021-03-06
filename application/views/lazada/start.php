<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('template/css');?>

<body class="g-sidenav-show  bg-gray-200">
		<?php $this->load->view('template/sidebar');?>
		<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
			<?php $this->load->view('template/toast'); ?>
			<?php $this->load->view('lazada/navbar'); ?>
			<div id="loading">
				<?php $this->load->view('lazada/saldo/isi/saldo'); ?>
				<!-- <?php $this->load->view('lazada/chat/isi/chat'); ?> -->
				<?php $this->load->view('lazada/produk/isi/produk'); ?>
				<?php $this->load->view('lazada/order/isi/order'); ?>
			</div>
			<?php $this->load->view('template/footer'); ?>
		</main>
		<?php $this->load->view('template/setting');?>
</body>
<?php $this->load->view('template/js');?>
<?php $this->load->view('lazada/saldo/js/saldo');?>
<!-- <?php $this->load->view('lazada/chat/js/chat');?> -->
<?php $this->load->view('lazada/order/js/order');?>
<?php $this->load->view('lazada/produk/js/produk');?>
</html>