<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Dashboard_m');
		if (!$this->session->userdata('id')) redirect(base_url(),'refresh');
	}

	public function index()
	{
		$this->load->view('dashboard/start');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */