<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// createprofile_customer controller
session_start();
class CreateProfile_Customer extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('customer','',TRUE);
	}
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username']; 
		}
		else
		{
			$data['r'] = 0;
		}
		$this->load->helper(array('form'));
		$this->load->view('create_profile',$data);
	}
}
?>