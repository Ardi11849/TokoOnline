	  	<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
  		<h6>Akun: 
  			<select class="form-control" style="width: 300px;" id="selectAkunShopee">
      			<option value="">Pilih akun shopee</option>
      			<?php foreach ($akun as $data) { ?>
      				<option data-id="<?php echo $data['IdUserShopee']?>" data-idSeller="<?php echo $data['IdSeller']?>" data-namaShop="<?php echo $data['NamaShop']?>" data-token="<?php echo $data['AksesToken']?>" data-expired="<?php echo $data['ExpiredToken']?>" data-refreshToken="<?php echo $data['RefreshToken']?>" value="<?php echo $data['IdUserShopee']?>"><?php echo $data['NamaShop']?></option>
      			<?php } ?>
      		</select>
      	</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="<?php echo base_url()?>Shopee/loginShopee" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1" aria-hidden="true"></i>
                <span class="d-sm-inline d-none"> Login Shopee </span>
              </a>
            </li>
            <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer" aria-hidden="true"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer" aria-hidden="true"></i><span id="countNotification">0</span>
              </a>
              <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton" id="isiNotification">
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>