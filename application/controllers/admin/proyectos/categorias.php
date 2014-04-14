<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias extends Admin_Controller {
	var $ruta_array = array();
	//var $directorio;
	//var $clase;
	//var $ruta;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('proyectos/proyecto_categoria_model','',TRUE);
		
		$this->ruta_array[directorio] = $this->router->fetch_directory();
		$this->ruta_array[clase] = $this->router->fetch_class();
		$this->ruta_array[ruta] = $this->ruta_array[directorio].$this->ruta_array[clase];
	}
	
	public function index(){

		$data['titulo'] = $this->constantData['titulo'] = 'Listado de Categorias de Productos';
		$this->load->view('admin/comunes/top', $this->constantData);
		$nivel = 'Ver '.$this->ruta_array[clase];
		
		//if($this->flexi_auth->is_privileged($nivel)){

			$data = $this->proyecto_categoria_model->Grid();
			if($data){
				$content['msg']= $this->load->view('admin/comunes/grid', $data, TRUE);
				$content[ruta]=$this->ruta_array;
				$this->load->view($this->ruta_array[ruta].'/base',$content);
			}
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->load->view('admin/comunes/bottom');
	}
	
	
	public function agregar(){
		$nivel = 'Insertar '.$this->ruta_array[clase];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		$row['consant'] = $this->constantData;
		$this->load->view($this->ruta_array[ruta].'/add',$row);
	}
	
	public function editar($id){
		$nivel = 'Editar '.$this->ruta_array[clase];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, asi no se puede",403);
    	}
		
		$row['categoria']	= $this->proyecto_categoria_model->datosInfo( $id );
		$row['consant']		= $this->constantData;
		if($row){
			$this->load->view($this->ruta_array[ruta].'/edit', $row);
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */