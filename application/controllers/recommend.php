<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// AJAX controller: recommend.php
class Recommend extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->model('report','',TRUE);
	}
	public function index()
	{
		$formname_text_ajax = $this->input->post('formname_text_ajax',true);
		$recommend = $this->report->getrecommend($formname_text_ajax);
		$formname_text = "";
		foreach ($recommend as $rec) {
			//echo $rec['Name'];
			if($formname_text=="") $formname_text = $rec['Name'];
			else $formname_text = $formname_text.", ".$rec['Name'];
		}
		echo $formname_text;
		if ($formname_text=="") echo "No Recommendation";
	}
}
?>