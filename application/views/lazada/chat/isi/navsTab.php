<nav>
  	<div class="nav nav-tabs" id="nav-tab" role="tablist">
	    <button class="nav-link active" id="nav-text-tab" data-bs-toggle="tab" data-bs-target="#nav-text" type="button" role="tab" aria-controls="nav-text" aria-selected="true">Text</button>
	    <button class="nav-link" id="nav-produk-tab" data-bs-toggle="tab" data-bs-target="#nav-produk" type="button" role="tab" aria-controls="nav-produk" aria-selected="false">Produk</button>
	    <button class="nav-link" id="nav-order-tab" data-bs-toggle="tab" data-bs-target="#nav-order" type="button" role="tab" aria-controls="nav-order" aria-selected="false">Order</button>
  	</div>
</nav>
<div class="tab-content" id="nav-tabContent">
  	<div class="tab-pane fade show active" id="nav-text" role="tabpanel" aria-labelledby="nav-text-tab">
		<div class="input-group">
			<input type="text" class="form-control" placeholder="Type your message" id="text">
			<button class="btn btn-primary" id="btnSendMessage"><i class="fa fa-send"></i> Send</button>
		</div>
	</div>
  <div class="tab-pane fade" id="nav-produk" role="tabpanel" aria-labelledby="nav-produk-tab">
		<div class="col-12 mt-4" style="max-height: 350px; overflow: auto;">
		  <div class="row" id="rowProduk">
		  </div>
		</div>
  </div>
  <div class="tab-pane fade" id="nav-order" role="tabpanel" aria-labelledby="nav-order-tab"></div>
</div>