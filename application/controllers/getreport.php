<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// This controller does the actual validation of the fields and checks the credentials against the database.
class GetReport extends CI_Controller {

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
			// get poasted data	
			$sales= $this->input->post('sales',true);
			$name= $this->input->post('name',true);
			$type= $this->input->post('type',true);
			$start= $this->input->post('start',true);
			$end= $this->input->post('end',true);
			// - get summary report
			$data['summary'] = $this->report->getsummary($sales, $name, $type, $start, $end);
			// - get detailed report (hidden)
			$data['details'] = $this->report->getdetails($sales, $name, $type, $start, $end);
			// load view (manager_report which loads manager_view)
			$this->load->view('manager_report', $data); 	 
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