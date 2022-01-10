<?php
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Webhook extends CI_Controller {

	public function Shopee()
	{
		header("HTTP/1.1 200 OK");

		echo $data = file_get_contents('php://input');
		if (isset($data)) {
			$this->sendNotif('Shopee', 'https://www.pngmart.com/files/12/Shopee-Logo-Transparent-Background.png', $data, 60);
		}
	}

	public function Lazada()
	{
		header("HTTP/1.1 200 OK");

		echo $data = file_get_contents('php://input');
		if (isset($data)) {
			$this->sendNotif('Lazada', 'https://i.pinimg.com/originals/32/94/98/329498a465defb414b7860fc4e86310c.jpg', $data, 0.7);
		}
	}

	public function sendNotif($platform, $image, $data, $timeout)
	{
		$client = new Client([
		    'timeout'  => $timeout,
		]);
		 
		$response = $client->request('POST', 'https://12b60059-f1a5-4f32-9cd8-eac3defaaa55.pushnotifications.pusher.com/publish_api/v1/instances/12b60059-f1a5-4f32-9cd8-eac3defaaa55/publishes', [
			'headers' => [
			    'Authorization' => 'Bearer D730045068179B5B3E5D4514C8C3DDAEA591BEA93BA6B8A30730DCF6BA5F421D'
			    ],
			'json' => [
				"interests" => ['hello'],
				"web" => ["notification" => ['title' => $platform, 'icon'=> $image, 'body' => $data]],
				"data" => $data
			]
		]);
	}

	public function SetPusher()
	{
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
	  	$decode = json_decode(file_get_contents('php://input'));
	  	var_dump($decode);
	  	$result = [];
	  	$result['platform'] = $decode->platform;
	  	$result['image'] = $decode->image;
	  	$result['data'] = $decode->data;

	  	$date = new DateTime();
	  	$pusher->trigger('webhook', 'my-event', json_encode($result));
	}

}

/* End of file Webhook.php */
/* Location: ./application/controllers/Webhook.php */