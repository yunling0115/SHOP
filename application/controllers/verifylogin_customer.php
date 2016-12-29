<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// This controller does the actual validation of the fields and checks the credentials against the database.
class VerifyLogin_Customer extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('customer','',TRUE);
	}

	function index()
	{
		$this->load->helper(array('form')); 
		
		//This method will have the credentials validation
		$this->load->library('form_validation');

		// return true or false
		$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean'); 
		// return true or false: check_database function is defined below
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');   

		if($this->form_validation->run() == FALSE)
		{
			 //Field validation failed.  User redirected to login page
			 $this->load->view('login_customer_view');
		}
		else
		{
			 //Go to private area
			 redirect('product_select', 'refresh');
		}
	}

	function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$username = $this->input->post('username',true);

		//query the database
		// login function from user model
		$result = $this->customer->login($username, $password);

		if($result)
		{
			 $sess_array = array();
			 foreach($result as $row)
			 {
				$sess_array = array('username' => $row->UserID);
			   // set session variable
			   $this->session->set_userdata('logged_in', $sess_array);
			 }
			 return TRUE;
		}
		else
		{
			 $this->form_validation->set_message('check_database', 'Invalid username or Password');
			 return false;
		}
	}
}
?>