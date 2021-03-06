
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="<?php echo base_url();?>assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="sidetext ms-1 font-weight-bold text-white">Hello <?php echo $this->session->userdata('namatoko');?></span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto  max-height-vh-100" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white dashboard" href="<?php echo base_url()?>Dashboard">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="sidetext nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white lazada" href="<?php echo base_url()?>Lazada">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">shop</i>
            </div>
            <span class="sidetext nav-link-text ms-1">Lazada</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white shopee" href="<?php echo base_url()?>Shopee">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">shop</i>
            </div>
            <span class="sidetext nav-link-text ms-1">Shopee</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white logout" href="<?php echo base_url()?>Welcome/Logout">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">logout</i>
            </div>
            <span class="sidetext nav-link-text ms-1">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>