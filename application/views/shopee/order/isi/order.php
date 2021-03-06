		<?php $this->load->view('shopee/order/css/order');?>
	    <div class="container-fluid py-4">
	      	<div class="row">
	        	<div class="col-12">
	          		<div class="card my-4">
	            		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			              	<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
			                	<h6 class="text-white text-capitalize ps-3">Tabel Pembeli</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
							  	<div class="row">
								    <div class="col">
								    	<label>Tanggal Awal</label>
								      	<input type="text" class="form-control" id="tanggalAwal" placeholder="Tanggal awal">
								    </div>
								    <div class="col">
								    	<label>Tanggal Akhir</label>
								      	<input type="text" class="form-control" id="tanggalAkhir" placeholder="Tanggal akhir">
								    </div>
								    <div class="col">
								    	<label>Type</label>
								    	<select class="form-control" id="type">
								    		<option value="">Pilih Type</option>
								    		<option value="UNPAID">Belum Di Bayar</option>
								    		<option value="INVOICE_PANDING">Menunggu Konfirm Pembeli</option>
								    		<option value="READY_TO_SHIP">Siap Di Kirim</option>
								    		<option value="SHIPPED">Dikirim</option>
								    		<option value="PROCESSED">Proses</option>
								    		<option value="COMPLETED">Selesai</option>
								    		<option value="IN_CANCEL">Menunggu Respon Pembatalan Seller</option>
								    		<option value="CANCELLED">Batal</option>
								    	</select>
								    </div>
							  	</div>
							  	<div class="row">
							  		<div class="col">
							  			<button class="btn btn-primary" id="btn-searchOrder"><i class="fa fa-search"></i> Cari</button>
							  		</div>
							  	</div>
				                <table class="table align-items-center mb-0" id="tOrder">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Pembeli</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Username Pembeli</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga Total</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alasan</th>
				                    </tr>
				                  </thead>
				                  <tbody>
				                  </tbody>
							        <tfoot>
							            <tr>
							                <th colspan="6"></th>
							            </tr>
							        </tfoot>
				                </table>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>
	    <?php $this->load->view('shopee/order/isi/detailOrder');?>
	    <?php $this->load->view('shopee/order/js/order');?>