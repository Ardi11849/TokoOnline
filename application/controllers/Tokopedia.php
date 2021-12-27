<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'vendor/lazada/php/LazopSdk.php';

class Tokopedia extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('id')) redirect(base_url(),'refresh');
	}

	public function index()
	{
		$this->load->view('tokopedia/start');
	}

}

/* End of file Tokopedia.php */
/* Location: ./application/controllers/Tokopedia.php */