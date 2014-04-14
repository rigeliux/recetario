<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categorias_Model extends CI_Model {
	public $fields;
	public $datos;

	function __construct()
	{
		parent::__construct();
		$this->fields = $this->initFields();
	}

	function initFields()
	{
		$datos = $this->input->post('categoria',TRUE);
		$fields = array(
			'database' => array(
					'table_name'	=>'producto_categoria',
					'primary_key'	=>'categoria_id',
					'primary_key_post'=> $datos['id'],
					'name_key' 		=>'categoria_nombre',
					'name_key_post' => ''
				),
			'crud' => array(
					'categoria_nombre'	=>$datos['nombre'],
					'categoria_slug'	=>getSlug($datos['slug'])
				),
			'fieldNames' => array(
					'categoria_nombre'	=> 'Nombre',
					'categoria_slug'	=> 'Slug'
				)
			);

		$this->datos = $datos;
		return $fields;

	}
	
	function Grid(){
		
		$this->load->model('grid_model');
		
		$grid_gen = array(
				'SelectCommand'=>"SELECT * FROM producto_categoria",
				'campos'=>array(
						array(
							'DataField' => 'categoria_id',
							'HeaderText' => 'ID'
						),
						array(
							'DataField' => 'categoria_nombre',
							'HeaderText' => 'NOMBRE'
						),
						array(
							'DataField' => 'categoria_slug',
							'HeaderText' => 'SLUG'
						)
					)
			);

		return $this->grid_model->init($grid_gen);
	}
	
	
	function insertar()
	{
		$fields = $this->fields;
		$inserta = $this->db->insert($fields['database']['table_name'], $fields['crud']);
		
		if ($inserta) {
			$data['form']=$fields['crud'];
			return $data;
		} else {
			return false;
		}
	}
	
	function editar()
	{
		$fields = $this->fields;
		$db_data = $this->datosInfo($fields['database']['primary_key_post']);
		
		$this->db->where($fields['database']['primary_key'], $fields['database']['primary_key_post']);
		$actualiza = $this->db->update($fields['database']['table_name'], $fields['crud']);
		
		if ($actualiza) {
			$data['db']=$db_data;
			$data['form']=$fields['crud'];
			return $data;
		} else {
			return false;
		}
		
	}
	
	function eliminar($id)
	{
		$fields = $this->fields;
		$db_data = $this->datosInfo($id);

		$this->db->where($fields['database']['primary_key'], $id);
		$elimina = $this->db->delete($fields['database']['table_name']);
		
		if($elimina){
			$data['db']=$db_data;
			return $data;
		} else {
			return false;
		}
	}
	
	function datosInfo($id)
	{
		$fields = $this->fields;
		
		$this->db->where($fields['database']['primary_key'], $id);
		$query = $this->db->get($fields['database']['table_name']);
		
		if($query){
			return $query->row_array();
		} else {
			return false;
		}
	}

	function getDatos($soloNameKey=fale)
	{
		$fields = $this->fields;
		
		if ($soloNameKey) {
			$this->db->select($fields['database']['name_key']);
		}
		$this->db->order_by($fields['database']['name_key']);
		$query = $this->db->get($fields['database']['table_name']);
		
		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getDatosByName($string)
	{
		$fields = $this->fields;
		
		$this->db->like($fields['database']['name_key'], $string);
		$query = $this->db->get($fields['database']['table_name']);
		
		if($query){
			return $query->row_array();
		} else {
			return false;
		}
	}

	function messages($args = array())
	{
		$fields = $this->fields;
		$msgs = array();
		$msgs['insertar']['error']	= "Hubo un problema al registrar, intente nuevamente.";
		$msgs['editar']['error']	= "Hubo un problema al actualizar, intente nuevamente.";
		$msgs['eliminar']['error']	= "Hubo un problema al eliminar, intente nuevamente.";
		$msgs['insertar']['exito']	= "La etiqueta se <strong>registró</strong> con exito:<br>".formatResultInsert($args,$fields['fieldNames']);
		$msgs['editar']['exito']	= "La etiqueta se actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "La etiqueta se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);

		return $msgs;
	}
}