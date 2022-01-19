<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Lazada_m extends CI_Model {

	var $url = 'https://api.lazada.com/rest';
	var $url_id = 'https://api.lazada.co.id/rest';
	var $appId = '101798';
	var $token = 'K3sGxHn7Su8zzUJG0qTfzMZo6bUuDCM4';

	public function getShopFromDB()
	{
		$this->db->select('IdUserLazada, IdUser, IdSeller, NamaShop, AksesToken, ExpiredToken, RefreshToken, ExpiredRefreshToken');
		$this->db->where('IdUser', $this->session->userdata('id'));
		$data = $this->db->get('user_lazada')->result_array();
		return $data;
	}

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
		$this->saveUser();
		return $decode;
	}

	public function refreshTokenLazada($func, $data)
	{
		try {
			var_dump($this->session->userdata());
			$c = new LazopClient($this->url, $this->appId, $this->token);
			$request = new LazopRequest('/auth/token/refresh');
			$request->addApiParam('refresh_token', $this->session->userdata('refreshTokenLazada'));
			$token = $c->execute($request);
			$decode = json_decode($token, true);
			$this->session->set_userdata('accessTokenLazada', $decode['access_token']);
			$this->session->set_userdata('refreshTokenLazada', $decode['refresh_token']);
			$this->session->set_userdata('userIdLazada', $decode["country_user_info_list"][0]['user_id']);
			$this->session->set_userdata('sellerIdLazada', $decode["country_user_info_list"][0]['seller_id']);
			$this->session->set_userdata('refreshExpiresInTokenLazada', $decode['refresh_expires_in']);
			$this->session->set_userdata('expiresTokenLazada', $decode['expires_in']);
			$this->session->set_userdata('accountLazada', $decode['account']);
			$this->saveUser();
			return $this->$func($data);
		} catch (Exception $e) {
			var_dump($e);
			return $e;
		}
	}

	private function getSeller($token){
		// var_dump($token);die();
		$c = new LazopClient($this->url, $this->appId, $this->token);
		$request = new LazopRequest('/seller/get','GET');
		var_dump($c->execute($request, $token));die();
	}

	private function saveUser()
	{
		$insert = $this->db->query("replace into user_lazada
			(IdUserLazada, IdUser, IdSeller, NamaShop, AksesToken, ExpiredToken, RefreshToken, ExpiredRefreshToken, CreatedBy, CreatedOn)
			values (
			'".$this->session->userdata('userIdLazada')."',
			'".$this->session->userdata('id')."',
			'".$this->session->userdata('sellerIdLazada')."',
			'".$this->session->userdata('accountLazada')."',
			'".$this->session->userdata('accessTokenLazada')."',
			'".$this->session->userdata('expiresTokenLazada')."',
			'".$this->session->userdata('refreshTokenLazada')."',
			'".$this->session->userdata('refreshExpiresInTokenLazada')."',
			'".$this->session->userdata('id')."',
			'".date('d-m-Y')."'
		)");
	}

	public function getOrdersLazada($data)
	{
		try {
			$result = [];
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/orders/get','GET');
			$request->addApiParam('sort_direction','DESC');
			$request->addApiParam('offset', $data['start']);
			$request->addApiParam('limit', $data['length']);
			if (isset($data['dateToUpdate'])) {
				$request->addApiParam('update_before',date(DATE_ISO8601, strtotime($data['dateToUpdate'])));
				$request->addApiParam('update_after',date(DATE_ISO8601, strtotime($data['dateFromUpdate'])));
			} else {
				$request->addApiParam('created_before',date(DATE_ISO8601, strtotime($data['dateTo'])));
				$request->addApiParam('created_after',date(DATE_ISO8601, strtotime($data['dateFrom'])));
			}
			if ($data['type'] != 'all') $request->addApiParam('status',$data['type']);
			$result['data'] = json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
			$result['draw'] = $data['draw'];
			return $result;
		} catch (Exception $e) {
			$this->refreshTokenLazada('getOrdersLazada', $data);
		}
	}

	public function getOrderLazada($data)
	{
		try {
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/order/get/new','GET');
			$request->addApiParam('order_id', $data['orderId']);
			return json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
		} catch (Exception $e) {
			$this->refreshTokenLazada('getOrderLazada', $data);
		}
	}

	public function getSaldoLazada()
	{
		try {
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/finance/payout/status/get','GET');
			$request->addApiParam('created_after',date("Y-m-d", strtotime('-1 month')));
			return json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
		} catch (Exception $e) {
			$this->refreshTokenLazada('getOrderLazada', $data);
		}
	}

	public function getTransactionsLazada($data)
	{
		// try {
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/finance/transaction/detail/get','GET');
			$request->addApiParam('start_time',date("Y-m-d", strtotime($data['dateFrom'])));
			$request->addApiParam('end_time',date("Y-m-d", strtotime($data['dateTo'])));
			// $request->addApiParam('limit',$data['length']);
			// $request->addApiParam('offset',$data['start']);
			return json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
		// } catch (Exception $e) {
		// 	$this->refreshTokenLazada('getOrderLazada', $data);
		// }
	}

	public function getTrackLazada($data)
	{
		try {
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/logistic/order/trace', 'GET');
			$request->addApiParam('order_id', $data['orderId']);
			return json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
		} catch (Exception $e) {
			$this->refreshTokenLazada('getTrackLazada', $data);
		}
	}

	public function getOrderItem($data)
	{
		try {
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/order/items/get', 'GET');
			$request->addApiParam('order_id', $data['orderId']);
			return json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
		} catch (Exception $e) {
			$this->refreshTokenLazada('getTrackLazada', $data);
		}
	}

	public function getProductsLazada($data)
	{
		try {
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/products/get','GET');
			$request->addApiParam('filter',$data['type']);
			$request->addApiParam('offset', $data['start']);
			$request->addApiParam('limit', $data['length']);
			$result['data'] = json_decode($c->execute($request, $this->session->userdata('accessTokenLazada')));
			$result['draw'] = $data['draw'];
			return $result;
		} catch (Exception $e) {
			var_dump($e);
			$this->refreshTokenLazada('getProductsLazada', null);
		}
	}

	public function getSessionChatLazada()
	{
		try {
			$date = date("y-m-d H:i:s.v", strtotime("-1 month"));
			$unixNow2 = strtotime("-1 month") * 1234;
			$unixNow = intval(microtime(true) * 1000);
			$c = new LazopClient($this->url_id, $this->appId, $this->token);
			$request = new LazopRequest('/im/session/list','GET');
			$request->addApiParam('start_time', $unixNow2);
			$request->addApiParam('page_size','99999');
			return $c->execute($request, $this->session->userdata('accessTokenLazada'));	
		} catch (Exception $e) {
			var_dump($e);
			$this->refreshTokenLazada('getSessionChatLazada', null);
		}
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

	public function saveProdukLazada($data)
	{
		return $insert = $this->db->query("replace into `produk`
			(IdUser, IdUserLazada, NoProduk, NamaProduk, Harga, Stock, Gambar, SKU, Status, TglPembuatanProduk, Platform, CreatedBy, CreatedOn)
			values ".$data);
	}

	public function saveOrderLazada($data)
	{
		return $insert = $this->db->query("replace into `order`
			(IdUser, IdUserLazada, NoOrder, NamaPembeli, Harga, Status, TglPembuatanOrder, Platform, CreatedBy, CreatedOn)
			values ".$data);
	}

}

/* End of file Lazada_m.php */
/* Location: ./application/models/Lazada_m.php */