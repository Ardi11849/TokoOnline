
		<!-- Navbar -->
		<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
	    	<div class="container-fluid py-1 px-3">
	        	<nav aria-label="breadcrumb">
	          		<h6 class="font-weight-bolder mb-0">Shopee code: <?php
	          			var_dump($this->session->userdata('codeShopee'));?></h6>
	        	</nav>
		        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
		        	<div class="ms-md-auto pe-md-3 d-flex align-items-center">
		          	</div>
		          	<ul class="navbar-nav  justify-content-end">
		            	<li class="nav-item d-flex align-items-center">
			              	<a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
			                	<i class="fa fa-user me-sm-1"></i>
			                	<span class="d-sm-inline d-none"><a href="<?php echo base_url()?>Dashboard/loginShopee">Login Shopee</span>
			              	</a>
		            	</li>
		          	</ul>
		        </div>
	    	</div>
		</nav>
	  	<!-- End Navbar -->
	    <div class="container-fluid py-4">
	      	<div class="row">
	        	<div class="col-12">
	          		<div class="card my-4">
	            		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			              	<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
			                	<h6 class="text-white text-capitalize ps-3">Tabel Barang</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
				                <table class="table align-items-center mb-0" id="tbarangLazada">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Id Orderan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pembayaran</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Pengiriman</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
				                    </tr>
				                  </thead>
				                  <tbody>
				                  </tbody>
				                </table>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>