
<div class="modal fade" id="detailOrderModal" tabindex="-1" aria-labelledby="detailOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailOrderModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card card-body">
          <div class="row">
            <div class="row">
              <div class="col-12 col-xl-4">
                <div class="card card-plain h-100">
                  <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Informasi Pembeli</h6>
                  </div>
                  <hr>
                  <div class="card-body p-3">
                    <ul class="list-group">
                      <li class="list-group-item border-0 ps-0 pt-0 text-sm" id="userIdModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="usernameModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="messageModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="cancelByModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="reasonCancelModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="metodePembayaranModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="provinsiModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="kotaModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="kecamatanModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="kodePosModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="alamatModalOrder"></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-xl-4">
                <div class="card card-plain h-100">
                  <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Informasi Produk</h6>
                  </div>
                  <hr>
                  <div class="card-body p-3">
                    <ul class="list-group">
                      <li class="list-group-item border-0 ps-0 pt-0 text-sm" id="idBarangModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="namaBarangModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="skuBarangModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="hargaBarangModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="idModelModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="namaModelModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="skuModelModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="jumlahBeliModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="idPesanaBarangModalOrder"></li>
                      <li class="list-group-item border-0 ps-0 text-sm" id="beratModalOrder"></li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-xl-4">
                <div class="card card-plain h-100">
                  <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Informasi Pengiriman</h6>
                  </div>
                  <hr>
                  <div class="card-body p-3">
                    <ul class="list-group">
                      <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
                        <div class="avatar me-3">
                          <i class="fa fa-store-alt" style="color: black;"></i>
                        </div>
                        <div class="d-flex align-items-start flex-column justify-content-center">
                          <h6 class="mb-0 text-sm" id="ekspedisiOrderModal"></h6>
                          <p class="mb-0 text-xs" id="statusEkspedisiOrderModal"></p>
                        </div>
                        <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto" href="javascript:;" id="idPengirimanOrderModal"></a>
                      </li>
                      <span id="listTrackOrder"></span>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>