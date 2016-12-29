<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Controller - autoload 
class Login extends CI_Controller {

 function __construct()
 {
   parent::__construct();
 }

 function index()
 {
	// load form helper -> to be used in login_view to call verifylogin controller
   $this->load->helper(array('form')); 
    // load login_view view
   $this->load->view('login_view');
 }

}

?>