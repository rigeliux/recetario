<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends MY_Controller {
	var $clase;
	var $ruta;
	
	public function __construct(){
		parent::__construct();
		$this->load->model('Funciones','',TRUE);
		$this->load->model('UsuariosModel','',TRUE);
		$this->clase = $this->router->fetch_class();
		$this->ruta = $this->router->fetch_directory().$this->router->fetch_class();
	}
	
	public function index(){

		$data['titulo'] = $this->constantData['titulo'] = 'Listado de Usuarios';
		$this->load->view('comunes/top', $this->constantData);
		$nivel = 'Ver '.$this->clase;
		
		//if($this->flexi_auth->is_privileged($nivel)){

			$data = $this->UsuariosModel->usuariosGrid();
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
		$row['nivelSelect'] = $this->_rellenaSelect( $this->flexi_auth_model->get_groups()->result_array(), 0 );
		$this->load->view($this->ruta.'/add',$row);
	}
	
	public function editar($id){
		$nivel = 'Insertar '.$this->clase;
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row[usuario] = $this->flexi_auth->get_user_by_id_query($id)->row_array();
		$row[grupo] = $this->flexi_auth->get_groups()->result_array();
		
		$row['nivelSelect'] = $this->_rellenaSelect($row[grupo],$row[usuario][ugrp_id]);
		if($row){
			$this->load->view($this->ruta.'/edit', $row);
		}
	}
	
	public function _rellenaSelect($query,$seleccionado){
		foreach($query as $row){
			$html.='<option value="'.$row[ugrp_id].'" '.($row[ugrp_id]==$seleccionado ? 'selected':'').'>'.$row[ugrp_name].'</option>';
		}
		return $html;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */