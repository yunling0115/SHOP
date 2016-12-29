<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// product_select controller
session_start(); //we need to call PHP's session object to access it through CI
class Product_Select extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('product','',TRUE);
	}

	function index()
	{
		$this->load->helper(array('form'));
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username'];
		}
		// get data
		$data['product'] = $this->product->getproduct();
		$this->load->view('product_view', $data);		 
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login_customer', 'refresh');
	}

}

?>