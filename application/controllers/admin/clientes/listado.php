<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado extends Admin_Controller {
	
	public function __construct(){
		parent::__construct();
		
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
	
	
	public function agregar(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['insertar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		
		$row['constant']=$this->constantData;
		$row['nivelSelect'] = $this->_rellenaSelect( $this->flexi_auth_model->get_groups()->result_array() );
		$row['estados'] = $this->_prepareEdos();
		$row['ciudades'] = $this->_prepareCid();
		$this->viewAdmin($this->constantData['ruta'].'/add',$row);
	}
	
	public function editar($id){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row['constant']=$this->constantData;
		$row['usuario'] = $this->flexi_auth->get_user_by_id_query($id)->row_array();
		$row['grupo'] = $this->flexi_auth->get_groups()->result_array();
		$row['estados'] = $this->_prepareEdos($row['usuario']['upro_estado_fk']);
		
		$cid_arr = array(
			'edo'=>$row['usuario']['upro_estado_fk'],
			'cid'=>$row['usuario']['upro_ciudad_fk']
		);
		$row['ciudades'] = $this->_prepareCid($cid_arr);
		
		$row['nivelSelect'] = $this->_rellenaSelect($row['grupo'],$row['usuario']['ugrp_id']);
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
		}
	}
	
	public function direccion(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row['constant']=$this->constantData;
		$row['estados'] = $this->_prepareEdos();
		$row['ciudades'] = $this->_prepareCid();
		
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/direccion', $row);
		}
	}
	
	
	private function _rellenaSelect($query,$seleccionado=''){
		foreach($query as $row){
			$id		= $row['ugrp_id'];
			$nombre	= $row['ugrp_name'];
			$selected = (($seleccionado!='' && $seleccionado==$id)? 'selected':'');
			$opts.='<option value="'.$row[ugrp_id].'" '.$selected.'>'.$nombre.'</option>';
		}
		
		$html="<select name='usuario[nivel]' class='span12' data-rule-required='true'><option value=''>Nivel del usuario</option>$opts</select>";
		return $html;
	}
	
	private function _prepareEdos($select=0){
		$modelo = $this->constantData['modelo'];
		$query = $this->$modelo->getEdos();
		
		foreach($query as $row){
			$id		= $row['sysedo_id'];
			$nombre	= $row['sysedo_nombre'];
			$selected = (($select!='' && $select==$id)? 'selected':'');
			$opts.="<option value='$id' $selected>$nombre</option>";
		}
		
		return $opts;
	}
	
	private function _prepareCid($select=0){
		$modelo = $this->constantData['modelo'];
		$query = $this->$modelo->getCid();
		$cids = array();
		
		foreach($query as $row){
			$cids[] = array(
						'id'=>$row['syscid_id'],
						'nombre'=>$row['syscid_nombre'],
						'pertenece'=>$row['sysedo_id_fk']
					);
					
			if(is_array($select)){
				$edo = $select['edo'];
				$cid = $select['cid'];
				if($edo == $row['sysedo_id_fk']){
					$selected = (($cid==$row['syscid_id'])? 'selected':'');
					$opts.="<option value='$row[syscid_id]' $selected>$row[syscid_nombre]</option>";
				}
			}
		}
		
		$ret['ciudades']=$cids;
		$arr['cids'] = json_encode($ret);
		$arr['opts'] = $opts;
		
		return $arr;
	}
	
}

/* End of file listado.php */
/* Location: ./application/controllers/admin/usuarios/listado.php */