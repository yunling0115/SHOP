<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// createprofile_done controller
session_start();
class CreateProfile_Done extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('customer','',TRUE);
	}
	function index()
	{
		$this->load->helper(array('form'));
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username']; 
		}
		// get poasted data and change db		
		$username = $this->input->post('userid',true);
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
		$this->customer->createuser($username, $password, $name, $cik, $fyr, $irs, $sic_code, 
									$street, $city, $state, $zip, $email, $phone,
									$street2, $city2, $state2, $zip2, $email2, $phone2);
		$data['suc'] = 1;
		$this->load->view('create_profile',$data);
	}
}
?>