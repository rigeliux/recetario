<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends MY_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->constantData['titulo'] = 'Catálogos';
		$this->load->view('comunes/top', $this->constantData);
		$this->load->view('inicio/dashboard');
		$this->load->view('comunes/bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */