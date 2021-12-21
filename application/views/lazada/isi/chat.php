
		<!-- Navbar -->
		<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
	    	<div class="container-fluid py-1 px-3">
	        	<nav aria-label="breadcrumb">
	          		<h6 class="font-weight-bolder mb-0">Lazada akun: <?php
	          			var_dump($this->session->userdata('accountChatLazada'));?></h6>
	        	</nav>
		        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
		        	<div class="ms-md-auto pe-md-3 d-flex align-items-center">
		          	</div>
		          	<ul class="navbar-nav  justify-content-end">
		            	<li class="nav-item d-flex align-items-center">
			              	<a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
			                	<i class="fa fa-user me-sm-1"></i>
			                	<span class="d-sm-inline d-none"><a href="<?php echo base_url()?>Lazada/loginLazada">Login Lazada</span>
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
			                	<h6 class="text-white text-capitalize ps-3">Chat Lazada</h6>
			              	</div>
	            		</div>
	            		<div class="card-body pb-2">
	              			<div class="table-responsive p-0">
								<div class="card">
									<div class="row g-0">
										<div class="col-12 col-lg-5 col-xl-3 border-right">

											<div class="px-4 d-none d-md-block">
												<div class="d-flex align-items-center">
													<div class="flex-grow-1">
														<input type="text" class="form-control my-3" placeholder="Search...">
													</div>
												</div>
											</div>
											<div id="listChatLazada" style="height: 500px;max-height: 480px;overflow: auto;">
											</div>

											<hr class="d-block d-lg-none mt-1 mb-0">
										</div>
										<div class="col-12 col-lg-7 col-xl-9">
											<div class="py-2 px-4 border-bottom d-none d-lg-block" id="headerMessage">
											</div>

											<div class="position-relative">
												<div class="chat-messages p-4" id="isiMessage">

												</div>
											</div>

											<div class="flex-grow-0 py-3 px-4 border-top">
											    <ul class="nav nav-tabs" id="myTab" role="tablist">
											        <li class="nav-item">
											            <a class="nav-link active" id="text-tab" data-toggle="tab" href="#text1" role="tab" aria-controls="text" aria-selected="true">Text</a>
											        </li>
											        <li class="nav-item">
											            <a class="nav-link" id="produk-tab" data-toggle="tab" href="#produk1" role="tab" aria-controls="produk" aria-selected="false">Produk</a>
											        </li>
											        <li class="nav-item">
											            <a class="nav-link" id="order-tab" data-toggle="tab" href="#order1" role="tab" aria-controls="order" aria-selected="false">Order</a>
											        </li>
											    </ul>
											    <div class="tab-content" id="myTabContent">
											        <div class="tab-pane fade show active" id="text1" role="tabpanel" aria-labelledby="text-tab">
														<div class="input-group">
															<input type="text" class="form-control" placeholder="Type your message" id="text">
															<button class="btn btn-primary" id="btnSendMessage">Send</button>
														</div>
											        </div>
											        <div class="tab-pane fade" id="produk1" role="tabpanel" aria-labelledby="produk-tab">
											        	<div class="col-12 mt-4" style="max-height: 350px; overflow: auto;">
														  <div class="row" id="rowProduk">
														  </div>
														</div>
											        </div>
											        <div class="tab-pane fade" id="order1" role="tabpanel" aria-labelledby="order-tab"></div>
											    </div>
											</div>

										</div>
									</div>
								</div>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>