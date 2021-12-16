<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Chat extends CI_Controller {

	public function index()
	{
		$this->load->view('chat/start');
	}

	public function loginLazada()
	{
		redirect('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri=https://phpclusters-61918-0.cloudclusters.net/Chat/getTokenLazada/&client_id=105624','refresh');
	}
	public function getTokenLazada()
	{
		$c = new LazopClient('https://api.lazada.com/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/auth/token/create');
		$request->addApiParam('code', $this->input->get('code'));
		$token = $c->execute($request);
		$decode = json_decode($token, true);
		$this->session->set_userdata('accessChatTokenLazada', $decode['access_token']);
		$this->session->set_userdata('refreshChatTokenLazada', $decode['refresh_token']);
		$this->session->set_userdata('userChatIdLazada', $decode["country_user_info"][0]['user_id']);
		$this->session->set_userdata('sellerChatIdLazada', $decode["country_user_info"][0]['seller_id']);
		$this->session->set_userdata('refreshChatExpiresInTokenLazada', $decode['refresh_expires_in']);
		$this->session->set_userdata('expiresChatTokenLazada', $decode['expires_in']);
		$this->session->set_userdata('accountChatLazada', $decode['account']);
		redirect(base_url().'Chat', 'refresh');
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
		$request->addApiParam('last_read_message_id', $this->input->post('last_message_id'));
		echo $c->execute($request, $this->session->userdata('accessChatTokenLazada'));
	}

	public function getMessageChatLazada()
	{
		$unixNow2 = strtotime("-1 month") * 1234;
		$c = new LazopClient('https://api.lazada.co.id/rest','105624','XDlDsB4PvALpmMlUfsvGX8XVgiFTtIG8');
		$request = new LazopRequest('/im/message/list','GET');
		$request->addApiParam('session_id', $this->input->post('sessionId'));
		$request->addApiParam('start_time', $unixNow2);
		$request->addApiParam('page_size','999999');
		echo $c->execute($request, $this->session->userdata('accessChatTokenLazada'));
	}

}

/* End of file Chat.php */
/* Location: ./application/controllers/Chat.php */