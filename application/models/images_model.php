<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images_Model extends CI_Model {
	public $fields;
	public $datos;

	function __construct()
	{
		parent::__construct();
		$this->fields = $this->initFields();
	}

	function initFields()
	{
		$fields = array(
			'database' => array(
					'table_name'		=>'image_listado',
					'primary_key'		=>'image_id',
					'primary_key_post'	=>'',
					'rel_key'			=>'image_rel_id',
					'rel_key_post'		=>'',
					'tipo_key'			=>'image_tipo',
					'tipo_id_post'		=>'1'
				),
			'modelInsert' => array(
					'image_id'		=>NULL,
					'image_tipo'	=>'',
					'image_rel_id'	=>'',
					'image_orden'	=>'',
					'image_nombre'	=>'',
					'image_titulo'	=>'',
					'image_ref'		=>''
				)
			);

		return $fields;
	}

	function initialize($args=array())
	{
		$this->fields['database']['primary_key_post'] = $args['primary_key_post'];	//id unico de la tabla
		$this->fields['database']['rel_key_post']	  = $args['rel_key_post'];		// id de la columna de la relacion
		$this->fields['database']['tipo_id_post']	  = $args['tipo_id'];		// id de la columna de la relacion
		$this->fields['crud'] = $this->createArrayInert($args['images']);
	}

	function createArrayInert($lista)
	{
		$id = $this->fields['database']['rel_key_post'];
		$tipo = $this->fields['database']['tipo_id_post'];
		$images = explode(',',$lista);
		$insert = array();

		foreach ($images as $orden => $imagen) {
			$modelo = $this->fields['modelInsert'];
			$modelo['image_tipo'] = $tipo;
			$modelo['image_rel_id'] = $id;
			$modelo['image_orden'] = $orden+1;
			$modelo['image_nombre'] = $imagen;
			$modelo['image_titulo'] = '';
			$modelo['image_ref'] = '';

			$insert[]=$modelo;
		}

		return $insert;
	}

	function insertar()
	{
		$this->db->where($this->fields['database']['rel_key'], $this->fields['database']['rel_key_post']);
		$this->db->where($this->fields['database']['tipo_key'], $this->fields['database']['tipo_id_post']);
		$this->db->delete($this->fields['database']['table_name']); 

		$inserta = $this->db->insert_batch($this->fields['database']['table_name'], $this->fields['crud']);

		if($inserta){
			return true;
		} else {
			return false;
		}
	}

	function getDatosById($id)
	{
		$this->db->where($this->fields['database']['primary_key'], $id);
		$query = $this->db->get($this->fields['database']['table_name']);

		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getDatosByRel($id)
	{
		$this->db->where($this->fields['database']['rel_key'], $id);
		$this->db->where($this->fields['database']['tipo_key'], $this->fields['database']['tipo_id_post']);
		$this->db->order_by('image_orden');
		$query = $this->db->get($this->fields['database']['table_name']);

		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}
}