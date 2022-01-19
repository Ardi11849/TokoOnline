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
	    $this->session->set_userdata('sellerIdLazada', intval($this->input->post('idseller')));
	    $this->session->set_userdata('accessTokenLazada', $this->input->post('token'));
	    $this->session->set_userdata('expiresTokenLazada', $this->input->post('expired'));
	    $this->session->set_userdata('refreshTokenLazada', $this->input->post('refreshtoken'));
	    $this->session->set_userdata('accountLazada', $this->input->post('namashop'));
	    echo 1;
	}

	public function loginLazada()
	{
		redirect('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri='.base_url().'Lazada/getTokenLazada/&client_id=101798','refresh');
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
		$data = $this->Lazada_m->refreshTokenLazada(null, null);
		var_dump($data);
		// redirect(base_url().'Lazada', 'refresh');
	}

	public function getOrdersLazada()
	{
		$data = $this->Lazada_m->getOrdersLazada($this->input->post());
		echo json_encode($data);
	}

	public function saveOrderLazada()
	{
		$result = $this->Lazada_m->saveOrderLazada($this->input->post('data'));
		echo $result;
	}

	public function getOrderLazada()
	{
		$result = [];
		$result['order'] = $this->Lazada_m->getOrderLazada($this->input->post());
		$result['trace'] = $this->Lazada_m->getTrackLazada($this->input->post());
		$result['item'] = $this->Lazada_m->getOrderItem($this->input->post());
		echo json_encode($result);
	}

	public function saveOrdersAuto()
	{
		$no = 0;
		$one = 1;
		$order = null;
		do {
			$data = array('start' => $no, 'length' => 50, 'dateFromUpdate' => date('Y-m-d').' 00:00:00', 'dateToUpdate' => date('Y-m-d').' 23:59:59', 'type' => 'all', 'draw' => $one++);
			$result = $this->Lazada_m->getOrdersLazada($data);
			foreach ($result['data']->data->orders as $key) {
				$order .= '("'.$this->session->userdata('id').'","'.$this->session->userdata('shopIdLazada').'","'.$key->order_number.'","'.$key->address_billing->first_name.'","'.$key->price.'","'.$key->statuses[0].'","Lazada","'.$key->created_at.'","'.$this->session->userdata('id').'",now()),';
			}
			if ($result['data']->data->count == 0) break;
			$no+=50;
		} while ($no <= 100000000);
		if ($order != null) $result2 = $this->Lazada_m->saveOrderLazada(rtrim($order, ','));
		if ($order == null) $result2 = 0;
		echo $result2;
	}

	public function getSaldoLazada()
	{
		$data = $this->Lazada_m->getSaldoLazada();
		// echo '<pre>'.var_dump($data->data).'</pre>';
		$this->session->set_userdata('saldo', $data->data[0]->closing_balance);
		echo json_encode($data);
	}

	public function getTransactionsLazada()
	{
		$data = $this->Lazada_m->getTransactionsLazada($this->input->post());
		// echo '<pre>'.var_dump($data->data).'</pre>';
		echo json_encode($data);
	}

	public function getProductsLazada()
	{
		$data = $this->Lazada_m->getProductsLazada($this->input->post());
		echo json_encode($data);
	}

	public function saveProdukLazada()
	{
		$result = $this->Lazada_m->saveProdukLazada($this->input->post('data'));
		echo $result;
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