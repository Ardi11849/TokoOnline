<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_m');
	}

	public function index()
	{
		$this->load->view('dashboard/start');
	}

	public function loginLazada()
	{
		redirect('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://phpclusters-61918-0.cloudclusters.net/Dashboard/getTokenLazada/&client_id=101798','refresh');
	}

	public function getTokenLazada()
	{
		$this->session->set_userdata('code', $this->input->get('code'));
		$c = new LazopClient('https://api.lazada.com/rest','101798','K3sGxHn7Su8zzUJG0qTfzMZo6bUuDCM4');
		$request = new LazopRequest('/auth/token/create');
		$request->addApiParam('code', $this->session->userdata('code'));
		$token = $c->execute($request);
		$decode = json_decode($token, true);
		$this->session->set_userdata('accessTokenLazada', $decode['access_token']);
		$this->session->set_userdata('refreshTokenLazada', $decode['refresh_token']);
		$this->session->set_userdata('userIdLazada', $decode["country_user_info"][0]['user_id']);
		$this->session->set_userdata('sellerIdLazada', $decode["country_user_info"][0]['seller_id']);
		$this->session->set_userdata('refreshExpiresInTokenLazada', $decode['refresh_expires_in']);
		$this->session->set_userdata('expiresTokenLazada', $decode['expires_in']);
		$this->session->set_userdata('accountLazada', $decode['account']);
		redirect(base_url(), 'refresh');
	}

	public function refreshTokenLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest
','101798','K3sGxHn7Su8zzUJG0qTfzMZo6bUuDCM4');
		$request = new LazopRequest('/auth/token/refresh');
		$request->addApiParam('refresh_token', $this->session->userdata('refreshExpiresInTokenLazada'));
		var_dump($c->execute($request));
	}

	public function getOrdersLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','101798','K3sGxHn7Su8zzUJG0qTfzMZo6bUuDCM4');
		$request = new LazopRequest('/orders/get','GET');
		$request->addApiParam('update_after','2017-02-10T09:00:00+08:00');
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getOrderLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','101798','K3sGxHn7Su8zzUJG0qTfzMZo6bUuDCM4');
		$request = new LazopRequest('/order/get','GET');
		$request->addApiParam('order_id', $this->input->post('orderId'));
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function loginBukalapak()
	{
		redirect('https://accounts.bukalapak.com/login?comeback=https://phpclusters-61918-0.cloudclusters.net?client_id=050deb9a7ce330cb7e3baf04&redirect_uri=https://phpclusters-61918-0.cloudclusters.net/&response_type=code&scope=public+user+store','refresh');
		// $result = $this->curl->simple_get('https://seller.bukalapak.com/api/authenticate');
		// var_dump($result);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */