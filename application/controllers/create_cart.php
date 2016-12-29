<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// create_cart controller
session_start(); //we need to call PHP's session object to access it through CI
class Create_Cart extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('product','',TRUE);
	}

	function index()
	{
		$this->load->helper('array');
		$post = $this->input->post(null,true);
		if (isset($post['regulation'])) unset($post['regulation']);
		if (isset($post['check'])) unset($post['check']);
		foreach ($post as $value) {
			$result= $this->product->getprice($value);
			if (!(isset($result[0]->SalesPrice))) $price=$result[0]->Price;
			else $price=$result[0]->SalesPrice;
			$p = array(
				'id' => $value,
				'name' => $value,
				'qty' => 1,
				'price' => $price
				);
			$this->cart->insert($p);
		}
		redirect('edit_cart', 'refresh');
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');
		session_destroy();
		redirect('login_customer', 'refresh');
	}
}
?>