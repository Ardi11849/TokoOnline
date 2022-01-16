		<?php $this->load->view('lazada/order/css/order');?>
	    <div class="container-fluid py-4">
	      	<div class="row">
	        	<div class="col-12">
	          		<div class="card my-4">
	            		<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
			              	<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
			                	<h6 class="text-white text-capitalize ps-3">Tabel Order</h6>
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
								    	<select class="form-control" id="typeOrder">
								    		<option value="">Pilih Type</option>
								    		<option value="all">Semua</option>
								    		<option value="unpaid">Unpaid</option>
								    		<option value="pending">Pending</option>
								    		<option value="ready_to_ship">Ready To Ship</option>
								    		<option value="shipped">Shipped</option>
								    		<option value="delivered">Delivered</option>
								    		<option value="returned">Returned</option>
								    		<option value="failed">Failed</option>
								    		<option value="canceled">Cancelled</option>
								    	</select>
								    </div>
							  	</div>
							  	<div class="row" style="padding-top: 10px;">
							  		<div class="col">
							  			<button class="btn btn-danger" id="btn-searchOrder"><i class="fa fa-search"></i> Cari</button>
							  		</div>
							  	</div>
				                <table class="table align-items-center mb-0 table-striped" id="tOrderLazada">
				                  <thead>
				                    <tr>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal Pembuatan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Id Orderan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No Orderan</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama Customer</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
				                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
				                    </tr>
				                  </thead>
				                  <tbody>
				                  </tbody>
							        <tfoot>
							            <tr>
							                <th colspan="6" style="text-align:left">Total Page Ini:</th>
							                <th></th>
							            </tr>
							        </tfoot>
				                </table>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>
	    <?php $this->load->view('lazada/order/isi/detailOrder');?>