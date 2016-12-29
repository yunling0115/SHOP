<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// manager controller
session_start(); //we need to call PHP's session object to access it through CI
class Manager extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('report','',TRUE);
	}

	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper(array('form'));
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			// populate data
			// - form name
			$data['name'] = $this->report->getname();
			// - form type
			$data['type'] = $this->report->gettype();
			// - sales form name
			$data['salesname'] = $this->report->getsalesname();
			 
			// load 'manager_view'
			$this->load->view('manager_view', $data);		 
		}
		else
		{
			//If no session, redirect to login page
			redirect('login', 'refresh');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login', 'refresh');
	}

}

?>
