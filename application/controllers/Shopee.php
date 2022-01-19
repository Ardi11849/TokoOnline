<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Shopee extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Shopee_m');
		if (!$this->session->userdata('id')) redirect(base_url(),'refresh');
	}

	public function index()
	{
		$akun_shopee['akun'] = $this->Shopee_m->getShopFromDB();
		$this->load->view('shopee/start', $akun_shopee);
	}

	public function setSession()
	{
	    $this->session->set_userdata('shopIdShopee', intval($this->input->post('id')));
	    $this->session->set_userdata('sellerIdShopee', intval($this->input->post('id')));
	    $this->session->set_userdata('accessTokenShopee', $this->input->post('token'));
	    $this->session->set_userdata('expiresTokenShopee', $this->input->post('expired'));
	    $this->session->set_userdata('refreshTokenShopee', $this->input->post('refresh_token'));
	    $this->session->set_userdata('accountShopee', $this->input->post('namaShop'));
	    echo 1;
	}

	public function loginShopee()
	{
		$url = $this->Shopee_m->loginShopeeV2();
		redirect($url,'refresh');
	}

	public function getTokenShopee()
	{
		$this->Shopee_m->getTokenShopee($this->input->get('shop_id'));
		redirect(base_url().'Shopee/getShopInfo', 'refresh');
	}

	public function getShopInfo()
	{
		$this->Shopee_m->getShopInfoV2();
		redirect(base_url().'Shopee', 'refresh');
	}

	public function getTransactionsShopee()
	{
		$data = $this->Shopee_m->getTransactionsShopeeV2($this->input->post());
		if (is_array($data)) {
			$encode = json_encode($data);
			echo $encode;
		} else {
			echo $data;
		}
	}

	public function getOrdersShopee()
	{
		$data = $this->Shopee_m->getOrdersShopeeV2($this->input->post());
		if (is_array($data)) {
			$encode = json_encode($data);
			echo $encode;
		} else {
			echo $data;
		}
	}

	public function saveOrdersAuto()
	{
		$no = 0;
		$one = 1;
		$order = null;
		do {
			$data = array('start' => $no, 'length' => 10, 'dateFrom' => date('Y-m-d'), 'dateTo' => date('Y-m-d'), 'type' => 'ALL', 'draw' => $one++);
			$result = $this->Shopee_m->getOrdersShopeeV2($data);
			if ($result['recordsTotal'] == 0) break;
			// echo "<pre>".var_dump($result['data'])."new line</pre>";
			foreach ($result['data'] as $key) {
				// var_dump($key);
				$order .= '("'.$this->session->userdata('id').'","'.$this->session->userdata('shopIdShopee').'","'.$key["order_sn"].'","'.$key["buyer_username"].'","'.$key["item_list"][0]["model_discounted_price"].'","'.$key["order_status"].'","Shopee","'.$key["create_time"].'","'.$this->session->userdata('id').'",now()),';
			}
			$no+=10;
		} while ($no <= 100000000000);
		echo $order;
		// $result2 = $this->Shopee->saveOrderShopee(rtrim($order, ','));
		// echo $result;
	}

	public function getOrderShopee()
	{
		$data = $this->Shopee_m->getDetailsOrderShopeeV2($this->input->post('order_sn'));
		if (is_array($data)) {
			$encode = json_encode($data);
			echo $encode;
		} else {
			echo $data;
		}
	}

	public function saveOrderShopee()
	{
		$result = $this->Shopee_m->saveOrderShopee($this->input->post('data'));
		echo $result;
	}

	public function trackOrderShopee()
	{
		$data = $this->Shopee_m->trackingOrderShopee($this->input->post('order_sn'));
		if (is_array($data)) {
			$encode = json_encode($data);
			echo $encode;
		} else {
			echo $data;
		}
	}

	public function getReturnShopee()
	{
		$data = $this->Shopee_m->getReturnShopeeV2($this->input->post());
		if (is_array($data)) {
			$encode = json_encode($data);
			echo $encode;
		} else {
			echo $data;
		}
	}

	public function getProductsShopee()
	{
		$data = $this->Shopee_m->getProductsShopeeV2($this->input->post());
		if (is_array($data)) {
			$encode = json_encode($data);
			echo $encode;
		} else {
			echo $data;
		}
	}

	public function saveProdukShopee()
	{
		$result = $this->Shopee_m->saveProdukShopee($this->input->post('data'));
		echo $result;
	}

}

/* End of file Shopee.php */
/* Location: ./application/controllers/Shopee.php */