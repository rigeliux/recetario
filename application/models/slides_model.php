<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slides_model extends CI_Model {

	public $fields;
	public $datos;

	function __construct(){
		parent::__construct();
		$this->fields = $this->initFields();
	}

	function initFields()
	{
		$datos = $this->input->post('slide',TRUE);
		$fields = array(
			'database' => array(
					'table_name'	=>'image_listado',
					'primary_key'	=>'image_id',
					'primary_key_post'=> $datos['id'],
					'name_key'		=>'image_nombre'
				),
			'crud' => array(
					'image_tipo'	=>2,
					'image_rel_id'	=>0,
					'image_orden'	=>$datos['orden'],
					'image_nombre'	=>$datos['imagenes'],
					'image_titulo'	=>$datos['titulo'],
					'image_ref'		=>str_replace('https://','',str_replace('http://','',$datos['link']))
				),
			'fieldNames' => array(
					'image_orden'	=> 'Orden',
					'image_nombre'	=> 'Nombre',
					'image_titulo'	=> 'Titulo',
					'image_ref'		=> 'Enlace'
				)
			);

		$this->datos = $datos;
		return $fields;

	}
	
	function Grid()
	{
		$this->load->model('grid_model');
		
		$grid_gen = array(
				'SelectCommand'=>"SELECT * FROM image_listado WHERE image_tipo='2' ORDER BY image_orden",
				'campos'=>array(
						array(
							'DataField' => 'image_orden',
							'HeaderText' => 'ORDEN'
						),
						array(
							'columnType' => 'GridCalculatedColumn',
							'expresionFunction' => 'imageZoom',
							'expresionValues'	=>	array(
														'nombre'=>"{image_nombre}",
														'tipo'	=>'slides',
														'thumb'	=>'thumb-720x137',
														'big'	=>'thumb-940x440'
													),
							'DataField' => 'image_nombre',
							'HeaderText' => 'IMAGEN'
						),
						array(
							'DataField' => 'image_titulo',
							'HeaderText' => 'TITULO'
						),
						array(
							'DataField' => 'image_ref',
							'HeaderText' => 'LINK'
						)
					)
			);

		return $this->grid_model->init($grid_gen);
	}
	
	function insertar()
	{

		$fields = $this->fields;
		$inserta = $this->db->insert($fields['database']['table_name'], $fields['crud']);
		
		if($inserta){
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

		
		if($actualiza){
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
	
	function getSlider(){
		$this->db->order_by('slide_orden','asc');
		$query = $this->db->get('slide_listado');
		
		if($query){
			return $query;
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
		$msgs['insertar']['exito']	= "El Slide: <strong>".$args['form']['image_nombre']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "El Slide actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		$msgs['eliminar']['exito']	= "El Slide se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);


		return $msgs;
	}
}