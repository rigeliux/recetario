<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relacion extends Admin_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->constantData['modelo'] = 'rel_producto_descuento_model';
		$this->constantData['ruta_modelo']='descuentos/rel_producto_descuento_model';
		$this->load->model($this->constantData['ruta_modelo'],'',TRUE);
	}
	
	public function index(){
		
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['ver'];
		/**************************************************************
			Si quisieramos que una seccion tenga un titulo diferente:
			$data['titulo'] = 'Titulo de la seccion;
			$this->constantData['titulo'] = 'Titulo de la pagina';
		**************************************************************/
		$this->viewAdmin('comunes/top', $this->constantData);
		//if($this->flexi_auth->is_privileged($nivel)){

			$data = (count($data)>0 ? array_merge($this->$modelo->Grid(),$data):$this->$modelo->Grid());
			if($data){
				$content['msg']= $this->viewAdmin('comunes/grid', $data, TRUE);
				$this->viewAdmin($this->constantData['ruta'].'/base',$content);
			}
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom');
	}	
}

/* End of file marcas.php */
/* Location: ./application/controllers/admin/productos/marcas.php */