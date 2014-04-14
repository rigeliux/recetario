<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Provedores extends MY_Controller {
	var $clase;
	var $ruta;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Funciones','',TRUE);
		$this->load->model('provedor_model','',TRUE);
		$this->clase = $this->router->fetch_class();
		$this->ruta = $this->router->fetch_directory().$this->router->fetch_class();
		
	}
	
	public function index(){

		$data['titulo'] = $this->constantData['titulo'] = 'Listado de Proveedores';
		$this->load->view('comunes/top', $this->constantData);
		$nivel = 'Ver '.$this->clase;
		
		//if($this->flexi_auth->is_privileged($nivel)){

			$data = $this->provedor_model->Grid();
			if($data){
				$content['msg']= $this->load->view('comunes/grid', $data, TRUE);
				$this->load->view($this->ruta.'/base',$content);
			}
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->load->view('comunes/bottom');
	}
	
	
	public function agregar(){
		$nivel = 'Insertar '.$this->clase;
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		$row['consant'] = $this->constantData;
		$this->load->view($this->ruta.'/add',$row);
	}
	
	public function editar($id){
		$nivel = 'Editar '.$this->clase;
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, asi no se puede",403);
    	}
		
		$sql_where = array('id' => $id);
		$row['provedor'] = $this->db->get_where('provedores', $sql_where)->row_array();
		$row['consant'] = $this->constantData;
		if($row){
			$this->load->view($this->ruta.'/edit', $row);
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */