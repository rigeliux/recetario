<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Niveles extends MY_Controller {
	var $clase;
	var $ruta;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Funciones','',TRUE);
		$this->load->model('NivelModel','',TRUE);
		$this->clase = $this->router->fetch_class();
		$this->ruta = $this->router->fetch_directory().$this->router->fetch_class();
	}
	
	public function index(){
		$this->load->model('Flexi_auth_model','',TRUE);
		$data = $this->NivelModel->nivelGrid();
		if($data){
			$data['titulo'] = $this->constantData['titulo'] = 'Listado de Niveles de Usuario';
			$content['msg']= $this->load->view('comunes/grid', $data, TRUE);
			
			$this->load->view('comunes/top', $this->constantData);
			$this->load->view($this->ruta.'/base',$content);
			$this->load->view('comunes/bottom');
		}
	}
	
	
	public function agregar(){
		//$this->load->model('Flexi_auth_model','',TRUE);
		
		$data['relgas']=$this->flexi_auth->get_privileges()->result_array();
		
		$this->load->view($this->ruta.'/add',$data);
	}
	
	public function editar($id){
		$sql_where = array('ugrp_id' => $id);
		$row[grupo] = $this->flexi_auth->get_groups('',$sql_where)->row_array();
		
		if($row){
			$this->load->view($this->ruta.'/edit', $row);
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */