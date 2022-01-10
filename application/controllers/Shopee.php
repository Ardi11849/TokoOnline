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
	    $this->session->set_userdata('accessTokenShopee', $this->input->post('token'));
	    $this->session->set_userdata('expiresTokenShopee', $this->input->post('expired'));
	    $this->session->set_userdata('refreshTokenShopee', $this->input->post('refresh_token'));
	    $this->session->set_userdata('accountShopee', $this->input->post('namaShop'));
	    echo 1;
	}

	public function loginShopee()
	{
		$url = $this->Shopee_m->loginShopeeV2();
		// $url = $this->Shopee_m->loginShopeeV1();
		redirect($url,'refresh');
	}

	public function getTokenShopee()
	{
		// $this->session->set_userdata('shopIdShopee', $this->input->get('shop_id'));
		$this->Shopee_m->getTokenShopee($this->input->get('shop_id'));
		redirect(base_url().'Shopee/getShopInfo', 'refresh');
	}

	public function getShopInfo()
	{
		$this->Shopee_m->getShopInfoV2();
		// $this->Shopee_m->getShopInfoV1();
		redirect(base_url().'Shopee', 'refresh');
	}

	public function getSaldoShopee()
	{
		$data = $this->Shopee_m->getSaldoShopeeV2($this->input->post());
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
		// $data = $this->Shopee_m->getOrdersShopeeV1();
		// var_dump($data);die();
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

}

/* End of file Shopee.php */
/* Location: ./application/controllers/Shopee.php */