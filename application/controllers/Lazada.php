<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lazada extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Lazada_m');
		if (!$this->session->userdata('id')) redirect(base_url(),'refresh');
	}

	public function index()
	{
		$akun_lazada['akun'] = $this->Lazada_m->getShopFromDB();
		$this->load->view('lazada/start', $akun_lazada);
	}

	public function setSession()
	{
	    $this->session->set_userdata('shopIdLazada', intval($this->input->post('id')));
	    $this->session->set_userdata('accessTokenLazada', $this->input->post('token'));
	    $this->session->set_userdata('expiresTokenLazada', $this->input->post('expired'));
	    $this->session->set_userdata('refreshTokenLazada', $this->input->post('refresh_token'));
	    $this->session->set_userdata('accountLazada', $this->input->post('namaShop'));
	    echo 1;
	}

	public function loginLazada()
	{
		redirect('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri='.base_url().'Lazada/getTokenLazada/&client_id=105624','refresh');
	}

	public function getTokenLazada()
	{
		$this->session->set_userdata('code', $this->input->get('code'));
		$data = $this->Lazada_m->getTokenLazada();
		var_dump($data);
		redirect(base_url().'Lazada', 'refresh');
	}

	public function refreshTokenLazada()
	{
		$data = $this->Lazada_m->refreshTokenLazada();
		var_dump($data);
		redirect(base_url().'Lazada', 'refresh');
	}

	public function getOrdersLazada()
	{
		$data = $this->Lazada_m->getOrdersLazada($this->input->post());
		echo json_encode($data);
	}

	public function getOrderLazada()
	{
		$data = $this->Lazada_m->getOrderLazada($this->input->post());
		echo $data;
	}

	public function getProductsLazada()
	{
		$data = $this->Lazada_m->getProductsLazada();
		echo $data;
	}

	public function getSessionChatLazada()
	{
		$data = $this->Lazada_m->getSessionChatLazada();
		echo $data;
	}

	public function readSessionChatLazada()
	{
		$data = $this->Lazada_m->readSessionChatLazada($this->input->post());
		echo $data;
	}

	public function getMessageChatLazada()
	{
		$data = $this->Lazada_m->getMessageChatLazada($this->input->post());
		echo $data;
	}

	public function sendMessageLazada()
	{
		$data = $this->Lazada_m->sendMessageLazada($this->input->post());
		echo $data;
	}

}

/* End of file Lazada.php */
/* Location: ./application/controllers/Lazada.php */