<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado extends Admin_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model($this->constantData['ruta_modelo'],'',TRUE);

		regiter_css(array('uploadifive'));
		regiter_script(array('vendor/bootbox.min','vendor/jquery.uploadifive.min','catalogos'));
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
		$this->constantData['botones_r']['agregar']['text'] = 'Agregar Producto';
		$this->viewAdmin('comunes/top', $this->constantData);
		//if($this->flexi_auth->is_privileged($nivel)){
			$this->constantData['gridd']=$this->$modelo->Grid();
			//echo '<pre>'.print_r($this->constantData,true).'</pre>';
			$content['grid']= $this->viewAdmin('comunes/grid', $this->constantData, TRUE);
			$content['constantData'] = $this->constantData;
			$this->viewAdmin('comunes/contenido',$content);
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom', $this->constantData);
	}
	
	
	public function agregar(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['insertar'];
		
		/*if ( !$this->input->is_ajax_request() || !$this->flexi_auth->is_privileged($nivel) ) {
			show_error("No no no, así no se puede",403);
    	}*/
		
		$row['constant']=$this->constantData;
		//$row['categoria']['list']=$this->categorias_model->getDatos(true);
		$this->viewAdmin($this->constantData['ruta'].'/add',$row);
	}
	
	public function editar($id){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		/*if ( !$this->input->is_ajax_request() || !$this->flexi_auth->is_privileged($nivel) ) {
			show_error("No no no, así no se puede",403);
    	}*/
    	
		$row['constant']=$this->constantData;
		$row['data'] = $this->$modelo->datosInfo($id);
		$row['data']['ingredientes'] = $this->ingredientes_model->getDatosByRel($id);
		$row['data']['instrucciones'] = $this->preparacion_model->getDatosByRel($id);
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
		}
	}
	
}

/* End of file listado.php */
/* Location: ./application/controllers/admin/productos/listado.php */