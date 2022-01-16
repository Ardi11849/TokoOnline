<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">
<?php $this->load->view('dashboard/css/css'); ?>

<body class="g-sidenav-show  bg-gray-200">
	<?php $this->load->view('template/sidebar');?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
  	<?php $this->load->view('dashboard/isi/main'); ?>
  </main>
	<?php $this->load->view('template/setting');?>
  <?php $this->load->view('dashboard/js/js'); ?>
  <?php $this->load->view('template/js'); ?>
</body>

</html>