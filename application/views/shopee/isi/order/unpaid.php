
		<!-- Navbar -->
		<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
	    	<div class="container-fluid py-1 px-3">
	        	<nav aria-label="breadcrumb">
	          		<h6>Akun: 
	          			<select class="form-control" style="width: 300px;" id="selectAkunShopee">
		          			<option>Pilih akun shopee</option>
		          			<?php foreach ($akun as $data) { ?>
		          				<option data-id="<?php echo $data['id_seller']?>" data-namaShop="<?php echo $data['nama_shop']?>" data-token="<?php echo $data['akses_token']?>" data-expired="<?php echo $data['expired_token']?>" data-refreshToken="<?php echo $data['refresh_token']?>" value="<?php echo $data['id_seller']?>"><?php echo $data['nama_shop']?></option>
		          			<?php } ?>
		          		</select>
		          	</h6>
	        	</nav>
		        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
		        	<div class="ms-md-auto pe-md-3 d-flex align-items-center">
		          	</div>
		          	<ul class="navbar-nav  justify-content-end">
		            	<li class="nav-item d-flex align-items-center">
			              	<a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
			                	<i class="fa fa-user me-sm-1"></i>
			                	<span class="d-sm-inline d-none"><a href="<?php echo base_url()?>Shopee/loginShopee">Login Shopee</span>
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
			                	<h6 class="text-white text-capitalize ps-3">Tabel Unpaid Orderan</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
							  	<div class="row">
								    <div class="col">
								    	<label>Tanggal Awal</label>
								      <input type="text" class="form-control" id="tanggalAwalUnpaid" placeholder="Tanggal awal">
								    </div>
								    <div class="col">
								    	<label>Tanggal Akhir</label>
								      <input type="text" class="form-control" id="tanggalAkhirUnpaid" placeholder="Tanggal akhir">
								    </div>
							  	</div>
							  	<div class="row">
							  		<div class="col">
							  			<button class="btn btn-primary" id="btn-searchUnpaid"><i class="fa fa-search"></i> Cari</button>
							  		</div>
							  	</div>
				                <table class="table align-items-center mb-0" id="tUnpaid">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username Pembeli</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Item</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hari Untuk Di Kirim</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Perkiraan Biaya Pengiriman</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Metode Pembayaran</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Operator Pengirim</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Total</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
				                    </tr>
				                  </thead>
				                  <tbody>
				                  </tbody>
							        <tfoot>
							            <tr>
							                <th colspan="3"></th>
							            </tr>
							        </tfoot>
				                </table>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>