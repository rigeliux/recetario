<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends Admin_Controller {

	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$this->constantData['titulo'] = 'Catálogos';
		$this->load->view('admin/comunes/top', $this->constantData);
		$this->load->view('admin/inicio/dashboard');
		$this->load->view('admin/comunes/bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */