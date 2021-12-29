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
		$this->db->select('id_user_shopee, id_user, id_seller, nama_shop, akses_token, expired_token, refresh_token');
		$this->db->where('id_user', $this->session->userdata('id'));
		$data = $this->db->get('tbl_user_shopee')->result_array();
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
		    'timeout'  => 5,
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

	public function refreshToken()
	{
		try {
			$path = '/api/v2/auth/access_token/get';
			$date = new DateTime();
			$string = sprintf("%s%s%s", $this->partnerId, $path, $date->getTimestamp());
			$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
			$client = new Client([
			    'base_uri' => $this->url,
			    // default timeout 5 detik
			    'timeout'  => 5,
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
			var_dump($body_array);
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
		    'timeout'  => 5,
		]);
		 
		$response = $client->request('GET', $path.'?sign='.$encrypt.'&partner_id='.$this->partnerId.'&timestamp='.$date->getTimestamp().'&shop_id='.$shopId.'&access_token='.$token);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		print_r($body_array);
		$this->session->set_userdata('accountShopee', $body_array['shop_name']);
		$this->session->set_userdata('statusAccountShopee', $body_array['status']);
		$this->session->set_userdata('waktuMasukShopee', $body_array['auth_time']);
		$this->session->set_userdata('expiresAccountShopee', $body_array['expire_time']);
		$this->session->set_userdata('accountShopee', $body_array['shop_name']);
		$this->session->set_userdata('statusAccountShopee', $body_array['status']);
		$this->session->set_userdata('waktuMasukShopee', $body_array['auth_time']);
		$this->session->set_userdata('expiresAccountShopee', $body_array['expire_time']);
		// var_dump($this->session->userdata());die();
		$insert = $this->db->query("replace into tbl_user_shopee
			(id_user_shopee, id_user, id_seller, nama_shop, akses_token, expired_token, refresh_token, created_by, created_on)
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
		// var_dump($insert);die();
		return $body_array;
	}

	public function getShopInfoV1()
	{
		$path = '/api/v1/shop/get';
		$shopId = intval($this->session->userdata('shopIdShopee'));
		// echo $this->partnerId; die();
		$date = new DateTime();
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 5,
		]);
		 
		$response = $client->request('POST', $path, [
		    'form_params' => [
		        'partner_id' => $this->partnerId,
		        'shopid' => $shopId,
		        'timestamp' => $date->getTimestamp()
		    ]
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		print_r($body_array);
		// return $body_array;
	}

	public function getOrdersShopeeV2($data)
	{
		// var_dump($data['start']);
		$path = '/api/v2/order/get_order_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$dateFrom = $data['dateFrom'];
		$dateTo = $data['dateTo'];
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
			    'timeout'  => 5,
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
			        'order_status' => $type
			    ]
			]);
			$body = $response->getBody();
			$body_json = $body->getContents();
			$body_array = json_decode($body, true);
			if ($body_array['error'] != '') return $body_array;
			try {
				$noSn = null;
				foreach ($body_array['response']['order_list'] as $key) {
					$noSn .= $key['order_sn'].',';
				}
				$data = $this->getDetailsOrderShopeeV2($noSn);
				return $data;
			} catch (Exception $e) {
				return $e;
			}
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
		    return $this->refreshToken();
		}
	}

	public function getReturnShopeeV2($data)
	{
		// var_dump($data['start']);
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
			    'timeout'  => 5,
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
			        // 'page_size' => 50,
			        'page_size' => $data['length'],
			        'page_no' => $data['start']
			    ]
			]);
			$body = $response->getBody();
			$body_json = $body->getContents();
			$body_array = json_decode($body, true);
			if ($body_array['error'] != '') return $body_array;
			return['response_data']['response'];
		} catch (GuzzleHttp\Exception\ClientException $e) {
		    $response = $e->getResponse();
		    $error = $response->getBody();
		    return $this->refreshToken();
		}
	}

	public function getOrdersShopeeV1()
	{
		$path = '/api/v1/orders/get';
		$shopId = intval($this->session->userdata('shopIdShopee'));
		$partner_id = intval($this->partnerId);
		// echo $this->partnerId; die();
		$date = new DateTime();
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 5,
		]);
		 
		$response = $client->request('POST', $path, [
		    'json' => [
		    	'order_status' => 'ALL',
		        'partner_id' => $partner_id,
		        'shopid' => $shopId,
		        'timestamp' => $date->getTimestamp()
		    ]
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		print_r($body_array);
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
		    'timeout'  => 5,
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
		    ]
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		$body_json = $body->getContents();
		// var_dump($body_array);die();
		if ($body_array['error'] != '') return $body_array;
		return $body_array['response']['order_list'];
	}

	public function getProductsShopeeV2()
	{
		$path = '/api/v2/product/get_item_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		$client = new Client([
		    'base_uri' => $this->url,
		    // default timeout 5 detik
		    'timeout'  => 5,
		]);
		 
		$response = $client->request('GET', $path, [
		    'query' => [
		        'shop_id' => $shopId,
		        'access_token' => $token,
		        'partner_id' => $this->partnerId,
		        'timestamp' => $date->getTimestamp(),
		        'sign' => $encrypt,
		        'offset' => 0,
		        'item_status' => 'NORMAL',
		        'page_size' => 100
		    ]
		]);
		$body = $response->getBody();
		$body_json = $body->getContents();
		$body_array = json_decode($body, true);
		return $body_json;
	}

}

/* End of file Shopee_m.php */
/* Location: ./application/models/Shopee_m.php */