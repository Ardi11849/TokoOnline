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
		echo crc32(md5('DemoAkun'));
	}

	public function login()
	{
		$data = $this->db->get_where('tbl_user', array('nm_user' => $this->input->post('namaUser'), 'password' => crc32(md5($this->input->post('password')))))->result_array();
		if (count($data) >= 1) {
			foreach ($data as $key) {
				$this->session->set_userdata('id', $key['id_user']);
				$this->session->set_userdata('namaUser', $key['nm_user']);
				$this->session->set_userdata('alamat', $key['alamat']);
				$this->session->set_userdata('telp', $key['tlp']);
				$this->session->set_userdata('status', $key['status']);
			}
			echo '1';
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
