<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// editprofile_done controller
session_start(); 
class EditProfile_Done extends CI_Controller {
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
			// get poasted data and change db		
			$username = $session_data['username'];
			$password = $this->input->post('password',true);
			$name = $this->input->post('name',true);
			$cik = $this->input->post('cik',true);
			$fyr = $this->input->post('fyr',true);
			$irs = $this->input->post('irs',true);
			$sic_code = $this->input->post('sic_enter',true);
			$street = $this->input->post('street',true);
			$city = $this->input->post('city',true);
			$state = $this->input->post('state',true);
			$zip = $this->input->post('zip',true);
			$email = $this->input->post('email',true);
			$phone = $this->input->post('phone',true);
			$street2 = $this->input->post('street2',true);
			$city2 = $this->input->post('city2',true);
			$state2 = $this->input->post('state2',true);
			$zip2 = $this->input->post('zip2',true);
			$email2 = $this->input->post('email2',true);
			$phone2 = $this->input->post('phone2',true);
			$this->customer->edituser($username, $password, $name, $cik, $fyr, $irs, $sic_code, 
										$street, $city, $state, $zip, $email, $phone,
										$street2, $city2, $state2, $zip2, $email2, $phone2);
			// populate data and load view
			$username = $session_data['username'];
			$user = $this->customer->getuser($username);
			$data['user'] = $user[0];
			$data['suc'] = 1;
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