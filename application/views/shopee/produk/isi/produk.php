		<?php $this->load->view('shopee/produk/css/produk');?>
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
							  	<div class="row">
								  <div class="col-sm-4">
								    	<label>Type</label>
								    	<select class="form-control" id="typeProduk">
								    		<option value="">Pilih Type</option>
								    		<option value="NORMAL">Normal</option>
								    		<option value="BANNED">Banned</option>
								    		<option value="DELETED">Deleted</option>
								    		<option value="UNLIST">Unlist</option>
								    	</select>
								  </div>
								  <div class="col-auto" style="padding-top: 25px">
							  			<button class="btn btn-primary" id="btn-searchProduk"><i class="fa fa-search"></i> Cari</button>
								  </div>
							  	</div>
				                <table class="table align-items-center mb-0" id="tProduk">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Item</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No SKU</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Gambar</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Brand</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pre Order</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Item</th>
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
	    <?php $this->load->view('shopee/produk/js/produk');?>