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
		$this->load->view('shopee/start');
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

	public function getOrdersShopee()
	{
		$data = $this->Shopee_m->getOrdersShopeeUnpaidV2($this->input->post());
		// $data = $this->Shopee_m->getOrdersShopeeV1();
		$encode = json_encode($data);
		echo $encode;
	}

	public function getProductsShopee()
	{
		$data = $this->Shopee_m->getProductsShopeeV2();
		echo $data;
	}

}

/* End of file Shopee.php */
/* Location: ./application/controllers/Shopee.php */