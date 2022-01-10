		<?php $this->load->view('shopee/return/css/return');?>
	    <div class="container-fluid py-4">
	      	<div class="row">
	        	<div class="col-12">
	          		<div class="card my-4">
	            		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			              	<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
			                	<h6 class="text-white text-capitalize ps-3">Tabel Pengembalian</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
							  	<div class="row">
								    <div class="col">
								    	<label>Tanggal Awal</label>
								      	<input type="text" class="form-control" id="tanggalAwalReturn" placeholder="Tanggal awal">
								    </div>
								    <div class="col">
								    	<label>Tanggal Akhir</label>
								      	<input type="text" class="form-control" id="tanggalAkhirReturn" placeholder="Tanggal akhir">
								    </div>
								    <div class="col">
								    	<label>Type</label>
								    	<select class="form-control" id="typeReturn">
								    		<option value="">Pilih Type</option>
								    		<option value="ALL">Semua</option>
								    		<option value="CANCELLED">Dibatalkan</option>
								    		<option value="REFUND_PAID">Pengembalian Dana</option>
								    		<option value="CLOSED">Ditutup</option>
								    	</select>
								    </div>
							  	</div>
							  	<div class="row">
							  		<div class="col">
							  			<button class="btn btn-primary" id="btn-searchReturn"><i class="fa fa-search"></i> Cari</button>
							  		</div>
							  	</div>
				                <table class="table align-items-center mb-0" id="tReturn">
							  	<!-- <input type="text" id="searchreturnShopee" class="form-control" placeholder="Search"> -->
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Pembeli</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Return</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Pengirimam</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah Pengembalian Uang</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Alasan</th>
				                    </tr>
				                  </thead>
				                  <tbody>
				                  </tbody>
							        <tfoot>
							            <tr>
							                <th colspan="5"></th>
							            </tr>
							        </tfoot>
				                </table>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>
	    <?php $this->load->view('shopee/return/js/return');?>