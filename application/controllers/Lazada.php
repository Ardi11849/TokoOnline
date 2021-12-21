<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Lazada extends CI_Controller {

	public function index()
	{
		$this->load->view('lazada/start');
	}

	public function loginLazada()
	{
		redirect('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://phpclusters-61918-0.cloudclusters.net/Lazada/getTokenLazada/&client_id=105624','refresh');
	}

	public function getTokenLazada()
	{
		$this->session->set_userdata('code', $this->input->get('code'));
		$c = new LazopClient('https://api.lazada.com/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
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
		redirect(base_url().'Lazada', 'refresh');
	}

	public function refreshTokenLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/auth/token/refresh');
		$request->addApiParam('refresh_token', $this->session->userdata('refreshExpiresInTokenLazada'));
		var_dump($c->execute($request));
	}

	public function getOrdersLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/orders/get','GET');
		$request->addApiParam('update_after','2017-02-10T09:00:00+08:00');
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getOrderLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/order/get','GET');
		$request->addApiParam('order_id', $this->input->post('orderId'));
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getProductsLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/products/get','GET');
		// $request->addApiParam('update_after','2017-02-10T09:00:00+08:00');
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getSessionChatLazada()
	{
		$date = date("y-m-d H:i:s.v", strtotime("-1 month"));
		$unixNow2 = strtotime("-1 month") * 1234;
		$unixNow = intval(microtime(true) * 1000);
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/im/session/list','GET');
		$request->addApiParam('start_time', $unixNow2);
		$request->addApiParam('page_size','99999');
		echo $c->execute($request, $this->session->userdata('accessChatTokenLazada'));
	}

	public function readSessionChatLazada()
	{
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/im/session/read');
		$request->addApiParam('session_id',  $this->input->post('sessionId'));
		$request->addApiParam('last_read_message_id', $this->input->post('lastMessageId'));
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getMessageChatLazada()
	{
		$unixNow2 = strtotime("-1 month") * 1234;
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/im/message/list','GET');
		$request->addApiParam('session_id', $this->input->post('sessionId'));
		$request->addApiParam('start_time', $unixNow2);
		$request->addApiParam('page_size','999999');
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function sendMessageLazada()
	{
		$text = $this->input->post('text');
		$itemId = $this->input->post('itemId');
		$orderId = $this->input->post('orderId');
		if($text == '' || $text == 'null' || $text == 'undefined' || $text == null) $text = null;
		if($itemId == '' || $itemId == 'null' || $itemId == 'undefined' || $itemId == null) $itemId = null;
		if($orderId == '' || $orderId == 'null' || $orderId == 'undefined' || $orderId == null) $orderId = null;
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/im/message/send');
		$request->addApiParam('session_id', $this->input->post('sessionId'));
		$request->addApiParam('template_id', $this->input->post('templateId'));
		if ($text != null) $request->addApiParam('txt', $text);
		if ($itemId !=null) $request->addApiParam('item_id', $itemId);
		if ($orderId != null) $request->addApiParam('order_id', $orderId);
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

}

/* End of file Lazada.php */
/* Location: ./application/controllers/Lazada.php */