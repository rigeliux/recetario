<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado extends Admin_Controller {
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model($this->constantData['ruta_modelo'],'',TRUE);
		regiter_script(array('bootbox.min','catalogos'));
		//$this->output->enable_profiler();
	}
	
	public function index(){

		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['ver'];
		/**************************************************************
			Si quisieramos que una seccion tenga un titulo diferente:
			$data['titulo'] = 'Titulo de la seccion;
			$this->constantData['titulo'] = 'Titulo de la pagina';
		**************************************************************/
		$this->constantData['titulo'] = 'Listado de Prodcutos';
		$this->constantData['botones_r'] = '';
		$this->viewAdmin('comunes/top', $this->constantData);
		//if($this->flexi_auth->is_privileged($nivel)){

			$this->constantData['gridd']=$this->$modelo->Grid();
			$content['grid']= $this->viewAdmin('comunes/grid', $this->constantData, TRUE);
			$content['constantData'] = $this->constantData;
			$this->viewAdmin('comunes/contenido',$content);
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom', $this->constantData);
	}
	
	
	public function editar($id){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
    	
		$row['constant']=$this->constantData;
		$row['data'] = $this->$modelo->datosInfo($id);
		$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
	}
	
}

/* End of file listado.php */
/* Location: ./application/controllers/admin/pedidos/listado.php */