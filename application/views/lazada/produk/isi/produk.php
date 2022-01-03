		<?php $this->load->view('lazada/produk/css/produk');?>
	    <div class="container-fluid py-4">
	      	<div class="row">
	        	<div class="col-12">
	          		<div class="card my-4">
	            		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			              	<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
			                	<h6 class="text-white text-capitalize ps-3">Tabel Produk</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
				                <table class="table align-items-center mb-0 table-striped" id="tProdukLazada">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Id Produk</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Produk</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kuantitas</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Seller SKU</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Shop SKU</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SKU Id</th>
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
	    <?php $this->load->view('lazada/produk/js/produk');?>