<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Produk extends CI_Controller {

	public function index()
	{
		$this->load->view('produk/start');
	}


	public function getProductsLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','101798','K3sGxHn7Su8zzUJG0qTfzMZo6bUuDCM4');
		$request = new LazopRequest('/products/get','GET');
		// $request->addApiParam('update_after','2017-02-10T09:00:00+08:00');
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */