<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/autoload.php';
use GuzzleHttp\Client;

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function enc()
	{
		echo crc32(md5('1n1p@ssw0rdSA!'));
	}

	public function timestamp()
	{
		$currentDate = date("Y-m-d");
		$currentTime = date("H:i:s");
		echo $currentDate.'<br>';
		echo $currentTime.'<br>';

		$currentDate =  strtotime($currentDate . $currentTime);

		echo $currentDate.'<br>';
		echo strtotime("3000-12-31 00:00:00");
	}

	public function login()
	{
		$result = $this->db->query('SELECT t.Status, t.Telp, t.MaxAkun, t.NamaToko, t.Alamat, t.Expired, t.IdToko, u.IdUser, u.Username, u.Password FROM user as u, toko as t WHERE u.Username = "'.$this->input->post('namaUser').'" AND u.Password = '.crc32(md5($this->input->post('password'))).' AND u.IdToko = t.IdToko')->result_array();
		if (count($result) == 1) {
			$currentDate = date("Y-m-d");
			$currentTime = date("H:i:s");
			$now =  strtotime($currentDate . $currentTime);
			if ($result[0]['Status'] == 0) {
				echo 403;
			}else if ($result[0]['Expired'] <= $now) {
				echo 402;
			} else {
				foreach ($result as $key) {
					$this->session->set_userdata('id', $key['IdUser']);
					$this->session->set_userdata('idtoko', $key['IdToko']);
					$this->session->set_userdata('alamat', $key['Alamat']);
					$this->session->set_userdata('telp', $key['Telp']);
					$this->session->set_userdata('status', $key['Status']);
					$this->session->set_userdata('namatoko', $key['NamaToko']);
					$this->session->set_userdata('maxakun', $key['MaxAkun']);
					$this->session->set_userdata('expired', $key['Expired']);
				}
				echo '1';
			}
		}else{
			echo '0';
		}

	}

	public function logout()
	{
		session_destroy();
		redirect(base_url(),'refresh');
	}
}
