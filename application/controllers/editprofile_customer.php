<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// editprofile_customer controller
session_start(); 
class EditProfile_Customer extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('customer','',TRUE);
	}
	function index()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper(array('form'));
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
			// populate data and load view
			$username = $session_data['username'];
			$user = $this->customer->getuser($username);
			$data['user'] = $user[0];
			$this->load->view('edit_profile', $data);
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