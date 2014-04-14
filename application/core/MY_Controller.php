<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $constantData = array();
	
    function __construct()
    {
        parent::__construct();
		$common = $this->common;
		$site = $common->conectaDB();
		//$this->config->set_item('hide_number', 'your value');
		$this->load->database($site);
		
		
		$this->constantData[siteName]=' | Creatibooks';
    }
}