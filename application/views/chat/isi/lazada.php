
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
			                	<span class="d-sm-inline d-none"><a href="<?php echo base_url()?>Chat/loginLazada">Login Chat Lazada</span>
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
											<div class="py-2 px-4 border-bottom d-none d-lg-block">
												<div class="d-flex align-items-center py-1">
													<div class="position-relative">
														<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
													</div>
													<div class="flex-grow-1 pl-3">
														<strong>Sharon Lessman</strong>
														<div class="text-muted small"><em>Typing...</em></div>
													</div>
													<div>
														<button class="btn btn-primary btn-lg mr-1 px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-phone feather-lg"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></button>
														<button class="btn btn-info btn-lg mr-1 px-3 d-none d-md-inline-block"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-video feather-lg"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg></button>
														<button class="btn btn-light border btn-lg px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal feather-lg"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>
													</div>
												</div>
											</div>

											<div class="position-relative">
												<div class="chat-messages p-4" id="isiMessage">

												</div>
											</div>

											<div class="flex-grow-0 py-3 px-4 border-top">
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Type your message">
													<button class="btn btn-primary">Send</button>
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