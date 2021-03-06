<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Shopee_m extends CI_Model {

	var $url = 'https://partner.shopeemobile.com';
	var $partnerId = 2002850;
	var $partnerKey = 'ea405b9b70ba25b1ac4f2accee38b9ac445235c18c1a7de7eec5343e9389b938';

	public function getShopFromDB()
	{
		$this->db->select('IdUserShopee, IdUser, IdSeller, NamaShop, AksesToken, ExpiredToken, RefreshToken');
		$this->db->where('IdUSer', $this->session->userdata('id'));
		$data = $this->db->get('user_shopee')->result_array();
		return $data;
	}

	public function loginShopeeV2()
	{
		$path = '/api/v2/shop/auth_partner';
		// $redirect = 'https://phpclusters-61918-0.cloudclusters.net/Shopee/getTokenShopee';
		$redirect = base_url().'/Shopee/getTokenShopee';
		$date = new DateTime();
		$string = sprintf("%s%s%s", $this->partnerId, $path, $date->getTimestamp());
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		return $sign = $this->url.$path.'?partner_id='.$this->partnerId.'&timestamp='.$date->getTimestamp().'&sign='.$encrypt.'&redirect='.$redirect;
	}

	public function loginShopeeV1()
	{
		$path = '/api/v1/shop/auth_partner';
		// $redirect = 'https://phpclusters-61918-0.cloudclusters.net/Shopee/getTokenShopee';
		$redirect = base_url().'/Shopee/getTokenShopee';
		$date = new DateTime();
		$string = sprintf("%s%s", $this->partnerKey, $redirect);
		$encrypt = hash('sha256', $string);
		return $sign = $this->url.$path.'?id='.$this->partnerId.'&token='.$encrypt.'&redirect='.$redirect;
	}

	public function getTokenShopee($data)
	{
		$path = '/api/v2/auth/token/get';
		$code = $this->input->get('code');
		$shopId = intval($data);
		$date = new DateTime();
		$string = sprintf("%s%s%s", $this->partnerId, $path, $date->getTimestamp());
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 30,
		]);
		 
		$response = $client->request('POST', $path.'?sign='.$encrypt.'&partner_id='.$this->partnerId.'&timestamp='.$date->getTimestamp(), [
		    'json' => [
		        'shop_id' => $shopId,
		        'code' => $code,
		        'partner_id' => $this->partnerId
		    ]
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		$this->session->set_userdata('shopIdShopee', intval($data));
		$this->session->set_userdata('accessTokenShopee', $body_array['access_token']);
		$this->session->set_userdata('expiresTokenShopee', $body_array['expire_in']);
		$this->session->set_userdata('refreshTokenShopee', $body_array['refresh_token']);
		return $body_array;
	}

	public function refreshToken($func, $data)
	{
		try {
			$path = '/api/v2/auth/access_token/get';
			$date = new DateTime();
			$string = sprintf("%s%s%s", $this->partnerId, $path, $date->getTimestamp());
			$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
			$client = new Client([
			    'base_uri' => $this->url,
			    // default timeout 5 detik
			    'timeout'  => 30,
			]);
			 
			$response = $client->request('POST', $path.'?sign='.$encrypt.'&partner_id='.$this->partnerId.'&timestamp='.$date->getTimestamp(), [
			    'json' => [
			        'refresh_token' => (string)$this->session->userdata('refreshTokenShopee'),
			        'partner_id' => $this->partnerId,
			        'shop_id' => $this->session->userdata('shopIdShopee')
			    ]
			]);
			$body = $response->getBody();
			$body_array = json_decode($body, true);
			$this->session->set_userdata('shopIdShopee', $body_array['shop_id']);
			$this->session->set_userdata('accessTokenShopee', $body_array['access_token']);
			$this->session->set_userdata('expiresTokenShopee', $body_array['expire_in']);
			$this->session->set_userdata('refreshTokenShopee', $body_array['refresh_token']);
			$this->getShopInfoV2();
			return $this->$func($data);
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
			return $error;
		}
	}

	public function getShopInfoV2()
	{
		$path = '/api/v2/shop/get_shop_info';
		$code = $this->input->get('code');
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = intval($this->session->userdata('shopIdShopee'));
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 30,
		]);
		 
		$response = $client->request('GET', $path.'?sign='.$encrypt.'&partner_id='.$this->partnerId.'&timestamp='.$date->getTimestamp().'&shop_id='.$shopId.'&access_token='.$token);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		$this->session->set_userdata('accountShopee', $body_array['shop_name']);
		$this->session->set_userdata('statusAccountShopee', $body_array['status']);
		$this->session->set_userdata('waktuMasukShopee', $body_array['auth_time']);
		$this->session->set_userdata('expiresAccountShopee', $body_array['expire_time']);
		$this->session->set_userdata('accountShopee', $body_array['shop_name']);
		$this->session->set_userdata('statusAccountShopee', $body_array['status']);
		$this->session->set_userdata('waktuMasukShopee', $body_array['auth_time']);
		$this->session->set_userdata('expiresAccountShopee', $body_array['expire_time']);
		$this->saveUser();
	}

	private function saveUser()
	{
		$insert = $this->db->query("replace into user_shopee
			(IdUserShopee, IdUSer, IdSeller, NamaShop, AksesToken, ExpiredToken, RefreshToken, CreatedBy, CreatedOn)
			values (
			'".$this->session->userdata('shopIdShopee')."',
			'".$this->session->userdata('id')."',
			'".$this->session->userdata('shopIdShopee')."',
			'".$this->session->userdata('accountShopee')."',
			'".$this->session->userdata('accessTokenShopee')."',
			'".$this->session->userdata('expiresTokenShopee')."',
			'".$this->session->userdata('refreshTokenShopee')."',
			'".$this->session->userdata('id')."',
			'".date('d-m-Y')."'
		)");
	}

	public function getTransactionsShopeeV2($data)
	{
		$path = '/api/v2/payment/get_wallet_transaction_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$dateFrom = $data['dateFrom']."00:00:00";
		$dateTo = $data['dateTo']."23:59:59";
		$length = $data['length'];
		$cursor = $data['start'];
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		try {
			$client = new Client([
			    'base_uri' => $this->url,
			    // default timeout 5 detik
			    'timeout'  => 60,
			]);
			 
			$response = $client->request('GET', $path, [
			    'query' => [
			        'shop_id' => $shopId,
			        'access_token' => $token,
			        'partner_id' => $this->partnerId,
			        'timestamp' => $date->getTimestamp(),
			        'sign' => $encrypt,
			        'create_time_from' => strtotime($dateFrom),
			        'create_time_to' => strtotime($dateTo),
			        'page_size' => $length,
			        'page_no' => $cursor
			    ]
			]);
			$body = $response->getBody();
			$body_json = $body->getContents();
			$body_array = json_decode($body, true);
			$result = [];
			if (empty($body_array['response']['transaction_list'])) {
				$result['data'] = [];
			} else {
				$result['data'] = $body_array['response']['transaction_list'];
			}
			$result['recordsTotal'] = count($body_array['response']['transaction_list']);
			$result['draw'] = $data['draw'];
			return $result;
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
		    return $this->refreshToken('getSaldoShopeeV2', $data);
		}
	}

	public function getOrdersShopeeV2($data)
	{
		// var_dump($data['type']);die();
		$path = '/api/v2/order/get_order_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$dateFrom = $data['dateFrom']."00:00:00";
		$dateTo = $data['dateTo']."23:59:59";
		$type = $data['type'];
		if (isset($data['length'])) {
			$length = $data['length'];
		}else{
			$length = 50;
		}
		if (isset($data['start'])) {
			$cursor = $data['start'];
		} else {
			$cursor = 0;
		}
		
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		try {
			$client = new Client([
			    'base_uri' => $this->url,
			    // default timeout 5 detik
			    'timeout'  => 30,
			]);
			 
			$response = $client->request('GET', $path, [
			    'query' => [
			        'shop_id' => $shopId,
			        'access_token' => $token,
			        'partner_id' => $this->partnerId,
			        'timestamp' => $date->getTimestamp(),
			        'sign' => $encrypt,
			        'time_range_field' => 'create_time',
			        'time_from' => strtotime($dateFrom),
			        'time_to' => strtotime($dateTo),
			        // 'page_size' => 50,
			        'page_size' => $length,
			        'cursor' => $cursor,
			        ($data['type'] != 'ALL' ? array('order_status' => $type) : false)
			    ]
			]);
			$body = $response->getBody();
			$body_json = $body->getContents();
			$body_array = json_decode($body, true);
			// var_dump($body_array);
			try {
				$result= [];
				$result['recordsTotal'] = count($body_array['response']['order_list']);
				// $result['recordsFiltered'] = count($body_array['response']['order_list']);
				$result['draw'] = $data['draw'];
				if (empty($body_array['response']['order_list'])) {
					$result['data'] = [];
				} else {
					$noSn = null;
					foreach ($body_array['response']['order_list'] as $key) {
						$noSn .= $key['order_sn'].',';
					}
					$result['data'] = $this->getDetailsOrderShopeeV2($noSn);
				}
				return $result;
			} catch (Exception $e) {
				return $e;
			}
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
		    return $this->refreshToken('getOrdersShopeeV2', $data);
		}
	}

	public function getReturnShopeeV2($data)
	{
		// var_dump($data);die();
		$path = '/api/v2/returns/get_return_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$dateFrom = $data['dateFrom'];
		$dateTo = $data['dateTo'];
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		try {
			$client = new Client([
			    'base_uri' => $this->url,
			    // default timeout 5 detik
			    'timeout'  => 30,
			]);
			 
			$response = $client->request('GET', $path, [
			    'query' => [
			        'shop_id' => $shopId,
			        'access_token' => $token,
			        'partner_id' => $this->partnerId,
			        'timestamp' => $date->getTimestamp(),
			        'sign' => $encrypt,
			        'time_from' => strtotime($dateFrom),
			        'time_to' => strtotime($dateTo),
			        'page_size' => $data['length'],
			        'page_no' => $data['start']
			    ]
			]);
			$body = $response->getBody();
			$body_json = $body->getContents();
			$body_array = json_decode($body, true);
			if ($body_array['error'] != '') return $body_array;
			try {
				$result= [];
				$result['recordsTotal'] = count($body_array['response']['return']);
				// $result['recordsFiltered'] = count($body_array['response']['order_list']);
				$result['draw'] = $data['draw'];
				// if (empty($body_array['response']['order_list'])) {
				$result['data'] = $body_array['response']['return'];
				// } else {
				// 	$noSn = null;
				// 	foreach ($body_array['response']['order_list'] as $key) {
				// 		$noSn .= $key['order_sn'].',';
				// 	}
				// 	$result['data'] = $this->getDetailsOrderShopeeV2($noSn);
				// }
				return $result;
			} catch (Exception $e) {
				return $e;
			}
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
		    return $this->refreshToken('getReturnShopeeV2', $data);
		}
	}

	public function getDetailsOrderShopeeV2($data)
	{
		// var_dump("data dari details= ".$data);die();
		$path = '/api/v2/order/get_order_detail';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 30,
		]);
		 
		$response = $client->request('GET', $path, [
		    'query' => [
		        'shop_id' => $shopId,
		        'access_token' => $token,
		        'partner_id' => $this->partnerId,
		        'timestamp' => $date->getTimestamp(),
		        'sign' => $encrypt,
		    	'order_sn_list' => $data,
		    	'response_optional_fields' => 'buyer_user_id,buyer_username,estimated_shipping_fee,recipient_address,actual_shipping_fee ,goods_to_declare,note,note_update_time,item_list,pay_time,dropshipper,dropshipper_phone,split_up,buyer_cancel_reason,cancel_by,cancel_reason,actual_shipping_fee_confirmed,buyer_cpf_id,fulfillment_flag,pickup_done_time,package_list,shipping_carrier,payment_method,total_amount,buyer_username,invoice_data, checkout_shipping_carrier,reverse_shipping_fee'
		    ],
		    'timeout' => 60
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		$body_json = $body->getContents();
		// var_dump($body_array);die();
		if ($body_array['error'] != '') return $body_array;
		return $body_array['response']['order_list'];
	}

	public function getProductsShopeeV2($data)
	{
		$path = '/api/v2/product/get_item_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		try {
			$client = new Client([
			    'base_uri' => $this->url,
			    // default timeout 5 detik
			    'timeout'  => 30,
			]);
			 
			$response = $client->request('GET', $path, [
			    'query' => [
			        'shop_id' => $shopId,
			        'access_token' => $token,
			        'partner_id' => $this->partnerId,
			        'timestamp' => $date->getTimestamp(),
			        'sign' => $encrypt,
			        'item_status' => $data['type'],
			        'page_size' => $data['length'],
			        'offset' => $data['start']
			    ]
			]);
			$body = $response->getBody();
			$body_json = $body->getContents();
			$body_array = json_decode($body, true);
			if ($body_array['error'] != '') return $body_array;
			try {
				$result= [];
				$result['recordsTotal'] = $body_array['response']['total_count'];
				$result['recordsFiltered'] = $body_array['response']['total_count'];
				$result['draw'] = $data['draw'];
				if (empty($body_array['response']['item'])) {
					$result['data'] = [];
				} else {
					$itemId = null;
					foreach ($body_array['response']['item'] as $key) {
						$itemId .= $key['item_id'].',';
					}
					$result['data'] = $this->getDetailsProductShopeeV2($itemId);
				}
				return $result;
			} catch (Exception $e) {
				return $e;
			}
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
		    return $this->refreshToken('getProductsShopeeV2', $data);
		}
	}

	public function getDetailsProductShopeeV2($data)
	{
		$path = '/api/v2/product/get_item_base_info';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 30,
		]);
		 
		$response = $client->request('GET', $path, [
		    'query' => [
		        'shop_id' => $shopId,
		        'access_token' => $token,
		        'partner_id' => $this->partnerId,
		        'timestamp' => $date->getTimestamp(),
		        'sign' => $encrypt,
		    	'item_id_list' => rtrim("$data", ', '),
		    	'need_tax_info' => true
		    ],
		    'timeout' => 60
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		$body_json = $body->getContents();
		if ($body_array['error'] != '') return $body_array;
		return $body_array['response']['item_list'];
	}

	public function trackingOrderShopee($data)
	{
		$path = '/api/v2/logistics/get_tracking_info';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 30,
		]);
		 
		$response = $client->request('GET', $path, [
		    'query' => [
		        'shop_id' => $shopId,
		        'access_token' => $token,
		        'partner_id' => $this->partnerId,
		        'timestamp' => $date->getTimestamp(),
		        'sign' => $encrypt,
		        'order_sn' => $data
		    ]
		]);
		$body = $response->getBody();
		$body_json = $body->getContents();
		return $body_array = json_decode($body, true);
	}

	public function saveProdukShopee($data)
	{
		return $insert = $this->db->query("replace into `produk`
			(IdUser, IdUserShopee, NoProduk, NamaProduk, Harga, Stock, Gambar, SKU, Status, TglPembuatanProduk, Platform, CreatedBy, CreatedOn)
			values ".$data);
	}

	public function saveOrderShopee($data)
	{
		return $insert = $this->db->query("replace into `order`
			(IdUser, IdUserShopee, NoOrder, NamaPembeli, Harga, Status, TglPembuatanOrder, Platform, CreatedBy, CreatedOn)
			values ".$data);
	}

}

/* End of file Shopee_m.php */
/* Location: ./application/models/Shopee_m.php */