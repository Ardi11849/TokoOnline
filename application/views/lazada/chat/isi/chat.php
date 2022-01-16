		<?php $this->load->view('lazada/chat/css/chat');?>
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
											<div id="listChatLazada" class="scroll" style="height: 500px;max-height: 480px;overflow: auto;">
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

											<?php $this->load->view('lazada/chat/isi/navsTab');?>
										</div>
									</div>
								</div>
	              			</div>
	            		</div>
	          		</div>
	        	</div>
	      	</div>
	    </div>