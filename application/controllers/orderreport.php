<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// view order report controller
session_start(); //we need to call PHP's session object to access it through CI
class OrderReport extends CI_Controller {

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
			// get username	
			$username = $session_data['username'];
			// - get summary report
			$data['summary'] = $this->report->getsummary_customer($username);
			// - get detailed report (hidden)
			$data['details'] = $this->report->getdetails_customer($username);
			// load customer_report view
			$this->load->view('customer_report', $data);		 
		}
		else
		{
			//If no session, redirect to login page
			redirect('login_customer', 'refresh');
		}
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login_customer', 'refresh');
	}

}

?>