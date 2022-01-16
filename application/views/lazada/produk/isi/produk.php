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
							  	<div class="row">
								  <div class="col-sm-4">
								    	<label>Type</label>
								    	<select class="form-control" id="typeProduk">
								    		<option value="">Pilih Type</option>
								    		<option value="all">Semua</option>
								    		<option value="live">Aktif</option>
								    		<option value="inactive">Tidak Aktif</option>
								    		<option value="deleted">Dihapus</option>
								    		<option value="image-missing">Tidak Ada Gambar</option>
								    		<option value="pending">Menunggu</option>
								    		<option value="rejected">Ditolak</option>
								    		<option value="sold-out">Sold Out/Habis</option>
								    	</select>
								  </div>
								  <div class="col-auto" style="padding-top: 25px">
							  			<button class="btn btn-primary" id="btn-searchProduk"><i class="fa fa-search"></i> Cari</button>
								  </div>
							  	</div>
				                <table class="table align-items-center mb-0 table-striped" id="tProdukLazada">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Id Produk</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Produk</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deskripsi</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kuantitas</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Image</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Shop SKU</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">SKU Id</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
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