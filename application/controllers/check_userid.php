<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// AJAX controller: check_userid.php
class Check_UserID extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('customer','',TRUE);
	}
	public function index()
	{
		$username = $this->input->post('username',true);
		if ($this->customer->getuser($username)) {
			echo '1';
		}
		else {
			echo '0';
		}
	}
}
?>