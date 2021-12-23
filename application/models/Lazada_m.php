<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Lazada_m extends CI_Model {

	var $url = 'https://api.lazada.com/rest';
	var $url_id = 'https://api.lazada.co.id/rest';
	var $appId = '105624';
	var $token = 'XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8';

	public function getTokenLazada()
	{
		$c = new LazopClient($this->url, $this->appId, $this->token);
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
		return $decode;
	}

	public function refreshTokenLazada()
	{
		$c = new LazopClient($this->url, $this->appId, $this->token);
		$request = new LazopRequest('/auth/token/refresh');
		$request->addApiParam('refresh_token', $this->session->userdata('refreshExpiresInTokenLazada'));
		$token = $c->execute($request);
		$decode = json_decode($token, true);
		return $decode;
	}

	public function getOrdersLazada()
	{
		// echo $this->session->userdata('accessTokenLazada');die();
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/orders/get','GET');
		$request->addApiParam('update_after','2017-02-10T09:00:00+08:00');
		return $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getOrderLazada($data)
	{
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/order/get','GET');
		$request->addApiParam('order_id', $data['orderId']);
		return $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getProductsLazada()
	{
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/products/get','GET');
		// $request->addApiParam('update_after','2017-02-10T09:00:00+08:00');
		return $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getSessionChatLazada()
	{
		$date = date("y-m-d H:i:s.v", strtotime("-1 month"));
		$unixNow2 = strtotime("-1 month") * 1234;
		$unixNow = intval(microtime(true) * 1000);
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/im/session/list','GET');
		$request->addApiParam('start_time', $unixNow2);
		$request->addApiParam('page_size','99999');
		return $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function readSessionChatLazada($data)
	{
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/im/session/read');
		$request->addApiParam('session_id',  $data['sessionId']);
		$request->addApiParam('last_read_message_id', $data['lastMessageId']);
		return $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function getMessageChatLazada($data)
	{
		$unixNow2 = strtotime("-1 month") * 1234;
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/im/message/list','GET');
		$request->addApiParam('session_id', $data['sessionId']);
		$request->addApiParam('start_time', $unixNow2);
		$request->addApiParam('page_size','999999');
		echo $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

	public function sendMessageLazada($data)
	{
		$c = new LazopClient($this->url_id, $this->appId, $this->token);
		$request = new LazopRequest('/im/message/send');
		$request->addApiParam('session_id', $data['sessionId']);
		$request->addApiParam('template_id', $data['templateId']);
		if (array_key_exists('text', $data)) $request->addApiParam('txt', $data['text']);
		if (array_key_exists('itemId', $data)) $request->addApiParam('item_id', $data['itemId']);
		if (array_key_exists('orderId', $data)) $request->addApiParam('order_id', $data['orderId']);
		return $c->execute($request, $this->session->userdata('accessTokenLazada'));
	}

}

/* End of file Lazada_m.php */
/* Location: ./application/models/Lazada_m.php */