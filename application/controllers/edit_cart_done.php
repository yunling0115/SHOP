<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Edit_Cart_Done extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('product','',TRUE);
	}

	function index()
	{
		$this->load->helper('form');
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['username']; 
		}
		$this->load->helper('array');
		$post = $this->input->post(null,true);;
		if (isset($post['check'])) unset($post['check']);
		foreach ($post as $rowid => $qty) {
			$p = array(
				'rowid' => $rowid,
				'qty' => $qty,
				);
			$this->cart->update($p);
		}
		$data['field_name'] = $p;
		$this->load->view('cart_view',$data);
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login_customer', 'refresh');
	}
}
?>