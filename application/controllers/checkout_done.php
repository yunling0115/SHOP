<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Checkout_Done extends CI_Controller {

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
			$username = $data['username'];
			$totalprice = $this->cart->total();
			// insert cart and customer data into Orders
			$data['orderid'] = $this->report->insertOrder($username,$totalprice);
			$orderid = $data['orderid'];
			// insert Items data
			foreach ($this->cart->contents() as $items) {
				$name = $items['name'];
				$qty = $items['qty'];
				$price = $items['price'];
				$this->report->insertItems($orderid, $name, $qty, $price);
			}
			$this->load->view('checkout_done_view', $data);				
		}
		else
		{
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