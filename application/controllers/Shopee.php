<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Shopee extends CI_Controller {

	public function index()
	{
		$this->load->view('shopee/start');
	}

	public function loginShopee()
	{
		$path = '/api/v2/shop/auth_partner';
		$redirect = 'https://phpclusters-61918-0.cloudclusters.net/Shopee/getTokenShopee';
		$partnerId = 1005144;
		$partnerKey = 'aeb211b6ed846a8139c6529ccf510cbf1bdfa5fdf09a643cc05c7f5d12a74510';
		$date = new DateTime();
		$string = sprintf("%s%s%s", $partnerId, $path, $date->getTimestamp());
		$encrypt = hash_hmac('sha256', $string, $partnerKey);
		$sign = 'https://partner.test-stable.shopeemobile.com'.$path.'?partner_id='.$partnerId.'&timestamp='.$date->getTimestamp().'&sign='.$encrypt.'&redirect='.$redirect;
		redirect($sign,'refresh');
	}

	public function getTokenShopee()
	{
		$path = '/api/v2/auth/token/get';
		$code = $this->input->get('code');
		$shopId = intval($this->input->get('shop_id'));
		$partnerId = 1005144;
		$partnerKey = 'aeb211b6ed846a8139c6529ccf510cbf1bdfa5fdf09a643cc05c7f5d12a74510';
		$date = new DateTime();
		$string = sprintf("%s%s%s", $partnerId, $path, $date->getTimestamp());
		$encrypt = hash_hmac('sha256', $string, $partnerKey);
		$client = new Client([
		    'base_uri' => 'https://partner.test-stable.shopeemobile.com',
		    // default timeout 5 detik
		    'timeout'  => 5,
		]);
		 
		$response = $client->request('POST', $path.'?sign='.$encrypt.'&partner_id='.$partnerId.'&timestamp='.$date->getTimestamp(), [
		    'json' => [
		        'shop_id' => $shopId,
		        'code' => $code,
		        'partner_id' => $partnerId
		    ]
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		print_r($body_array);
		print_r($body_array['access_token']);
		print_r($body_array['expire_in']);
		print_r($body_array['refresh_token']);
		$this->session->set_userdata('shopIdShopee', intval($this->input->get('shop_id')));
		$this->session->set_userdata('accessTokenShopee', $body_array['access_token']);
		$this->session->set_userdata('expiresTokenShopee', $body_array['expire_in']);
		$this->session->set_userdata('refreshTokenShopee', $body_array['refresh_token']);
		redirect(base_url().'Shopee', 'refresh');
	}

	public function getOrdersShopee()
	{
		$path = '/api/v2/order/get_order_list';
		$redirect = 'https://phpclusters-61918-0.cloudclusters.net/Shopee/getTokenShopee';
		$token = $this->session->userdata('accessTokenShopee');
		$shopId = $this->session->userdata('shopIdShopee');
		$partnerId = 1005144;
		$partnerKey = 'aeb211b6ed846a8139c6529ccf510cbf1bdfa5fdf09a643cc05c7f5d12a74510';
		$date = new DateTime();
		$string = sprintf("%s%s%s%s%s", $partnerId, $path, $date->getTimestamp(), $token, $shopId);
		$encrypt = hash_hmac('sha256', $string, $partnerKey);
		$client = new Client([
		    'base_uri' => 'https://partner.test-stable.shopeemobile.com',
		    // default timeout 5 detik
		    'timeout'  => 5,
		]);
		 
		$response = $client->request('GET', $path, [
		    'query' => [
		        'shop_id' => $shopId,
		        'access_token' => $token,
		        'partner_id' => $partnerId,
		        'timestamp' => $date->getTimestamp(),
		        'sign' => $encrypt,
		        'time_range_field' => 'create_time',
		        'time_from' => $date->modify('-15 days')->getTimestamp(),
		        'time_to' => $date->getTimestamp(),
		        'page_size' => '100'
		    ]
		]);
		$body = $response->getBody();
		$body_array = json_decode($body, true);
		print_r($body_array);
		// redirect(base_url(),'refresh');
	}

}

/* End of file Shopee.php */
/* Location: ./application/controllers/Shopee.php */