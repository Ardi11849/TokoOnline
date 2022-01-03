<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Webhook extends CI_Controller {

	public function index()
	{
		header("HTTP/1.1 200 OK");
		
	  	$data = [];
		if($json = json_decode(file_get_contents("php://input"), true)) {
		    $data['json'] = $json;
		} else {
		    $data['POST'] = $_POST;
		}
		try {
			$this->pusher($data);		
		} catch (Exception $e) {
			echo $e;
		}
	}

	private function pusher($data){
		$options = array(
	    	'cluster' => 'ap1',
	    	'forceTLS' => true
	  	);
	  	$pusher = new Pusher\Pusher(
	    	'b334013a027b1e65077f',
	    	'e35e548190f16797ca42',
	    	'1317506',
	    	$options
	  	);

	  	$date = new DateTime();
	  	if ($data['site'] == 'lazada_vn') $data['image'] = 'https://id-test-11.slatic.net/p/4a228af142e2ac36658fccb1961a2bb8.png';
	  	// if ($data['site'] == 'shopee_vn') 
	  		$data['image'] = 'https://i.pinimg.com/originals/6d/b9/31/6db931827443a7455a4b805fe5829820.png';
	  	$pusher->trigger('webhook', 'my-event', $data);
	  	return http_response_code(200);
	}

}

/* End of file Webhook.php */
/* Location: ./application/controllers/Webhook.php */