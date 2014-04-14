<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Niveles extends Admin_Controller {
	
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
		$this->viewAdmin($this->constantData['ruta'].'/add',$row);
	}
	
	public function editar($id){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		$privilegios = $this->_reArrangePrivileges();
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row['constant']=$this->constantData;
		$row['data'] = $this->flexi_auth->get_groups(FALSE, array('ugrp_id'=>$id) )->row_array();
		
		$row['privileges'] = $this->_tablePrivileges($privilegios);
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
		}
	}
	
	function _reArrangePrivileges(){
		
		$sql_select = array(
			'user_privileges.upriv_id',
			'user_privileges.upriv_name',
			'user_privileges.upriv_desc',
			'user_privileges.upriv_short',
			'user_privileges.upriv_usec_fk',
			'user_sections.usec_name'
		);
		$sql_join = 'user_sections';
		$sql_join_on = 'user_privileges.upriv_usec_fk = user_sections.usec_id';
		$this->flexi_auth->sql_select($sql_select);
		$this->flexi_auth->sql_join($sql_join, $sql_join_on);
		
		$privileges = $this->flexi_auth->get_privileges()->result_array();
		$final;
		foreach($privileges as $privs){
			$final[ $privs['usec_name'] ][] = $privs;
		}
		$this->flexi_auth->sql_clear();
		return $final;
	}
	
	function _tablePrivileges($array){
		$html;
		$tds;
		foreach($array as $seccion=>$permisos){
			$msg = '<tr><td class="c40">'.$seccion.'</td>';
			foreach($permisos as $permiso){
				$msg.='<td class="text-center c10"><input type="checkbox" value="'.$permiso['upriv_id'].'" name="nivel[privilegios][]"></td>';
			}
			$msg.='</tr>';
			$tds.=$msg;
		}
		
		$html = '
			<table class="table table-striped table-media table-bordered tbody">
				<tbody>
					'.$tds.$tds.$tds.'
				</tbody>
			</table>';
		
		return $html;
	}
}

/* End of file niveles.php */
/* Location: ./application/controllers/admin/usuarios/niveles.php */