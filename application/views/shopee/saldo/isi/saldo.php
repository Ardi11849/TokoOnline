		<?php $this->load->view('shopee/saldo/css/saldo');?>
	    <div class="container-fluid py-4">
	      	<div class="row">
	        	<div class="col-12">
	          		<div class="card my-4">
	            		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			              	<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
			                	<h6 class="text-white text-capitalize ps-3">Tabel Transaksi Saldo</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
							  	<div class="row">
								    <div class="col">
								    	<label>Tanggal Awal</label>
								      	<input type="text" class="form-control" id="tanggalAwalSaldo" placeholder="Tanggal awal">
								    </div>
								    <div class="col">
								    	<label>Tanggal Akhir</label>
								      	<input type="text" class="form-control" id="tanggalAkhirSaldo" placeholder="Tanggal akhir">
								    </div>
								    <div class="col">
								    	<label>Type</label>
								    	<select class="form-control" id="typeSaldo">
								    		<option value="">Pilih Type</option>
								    		<option value="ALL">Semua</option>
								    		<option value="INITIAL">Baru</option>
								    		<option value="PENDING">Menunggu</option>
								    		<option value="COMPLETED">Berhasil</option>
								    		<option value="FAILED">Gagal</option>
								    	</select>
								    </div>
							  	</div>
							  	<div class="row">
							  		<div class="col">
							  			<button class="btn btn-primary" id="btn-searchSaldo"><i class="fa fa-search"></i> Cari</button>
							  		</div>
							  	</div>
				                <table class="table align-items-center mb-0" id="tSaldo">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username Pembeli</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Id Transaksi</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nomer Pembeli</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Wallet</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Total</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Saldo</th>
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
	    <?php $this->load->view('shopee/saldo/js/saldo');?>