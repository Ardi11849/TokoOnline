<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Shopee_m extends CI_Model {

	var $url = 'https://partner.shopeemobile.com';
	var $partnerId = 2002850;
	var $partnerKey = 'ea405b9b70ba25b1ac4f2accee38b9ac445235c18c1a7de7eec5343e9389b938';

	public function loginShopeeV2()
	{
		$path = '/api/v2/shop/auth_partner';
		$redirect = 'https://phpclusters-61918-0.cloudclusters.net/Shopee/getTokenShopee';
		$date = new DateTime();
		$string = sprintf("%s%s%s", $this->partnerId, $path, $date->getTimestamp());
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		return $sign = $this->url.$path.'?partner_id='.$this->partnerId.'&timestamp='.$date->getTimestamp().'&sign='.$encrypt.'&redirect='.$redirect;
	}

	public function loginShopeeV1()
	{
		$path = '/api/v1/shop/auth_partner';
		$redirect = 'https://phpclusters-61918-0.cloudclusters.net/Shopee/getTokenShopee';
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
		print_r($body_array);
		print_r($body_array['access_token']);
		print_r($body_array['expire_in']);
		print_r($body_array['refresh_token']);
		$this->session->set_userdata('shopIdShopee', intval($data));
		$this->session->set_userdata('accessTokenShopee', $body_array['access_token']);
		$this->session->set_userdata('expiresTokenShopee', $body_array['expire_in']);
		$this->session->set_userdata('refreshTokenShopee', $body_array['refresh_token']);
		return $body_array;
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
		$this->session->set_userdata('accountShopee', $body_array['shop_name']);
		$this->session->set_userdata('statusAccountShopee', $body_array['status']);
		$this->session->set_userdata('waktuMasukShopee', $body_array['auth_time']);
		$this->session->set_userdata('expiresAccountShopee', $body_array['expire_time']);
		// return $body_array;
	}

	public function getOrdersShopeeUnpaidV2($data)
	{
		$path = '/api/v2/order/get_order_list';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$date = new DateTime();
		$dateFrom = $data['dateFrom'];
		$dateTo = $data['dateTo'];
		$type = $data['type'];
		$string = sprintf("%s%s%s%s%s", $this->partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $this->partnerKey);
		// var_dump('partnerId='.$this->partnerId.',timestamp='.$date->getTimestamp().',access_token='.$token.',shopid='.$shopId.',sign='.$encrypt.',time_range_field=created_time,time_from='.strtotime($dateFrom).',time_to='.strtotime($dateTo).',type='.$type);die();
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
		        'time_from' => $date->modify('-15 days')->getTimestamp(),
		        'time_to' => $date2->getTimestamp(),
		        'page_size' => 20,
		        'order_status' => $type
		    ]
		]);
		$body = $response->getBody();
		$body_json = $body->getContents();
		$body_array = json_decode($body, true);
		return $body_json;
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
		try {
			getDetailsOrderShopeeV2($body_array['response']);
		} catch ($e) {
			return $e;
		}
	}

	public function getDetailsOrderShopeeV2($data)
	{

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