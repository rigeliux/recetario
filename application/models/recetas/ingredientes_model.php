<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ingredientes_model extends CI_Model {
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
					'table_name'		=>'receta_ingrediente',
					'primary_key'		=>'receta_ingrediente_id',
					'primary_key_post'	=>'',
					'rel_key'			=>'receta_id',
					'rel_key_post'		=>''
				),
			'relations' => array(
					array(
						//'prefix'		=> 'producto',
						'table_name'	=> 'producto_listado',
						'fk'			=> 'producto_id',
						'dataFields'	=> 'producto_clave,producto_nombre,producto_detalles,producto_datos_tecnicos,producto_precio,producto_rating,producto_destacado'
					),
					array(
						//'prefix'		=> 'producto',
						'table_name'	=> 'producto_categoria',
						'fk'			=> 'categoria_id',
						'dataFields'	=> 'categoria_nombre,categoria_slug'
					)
				),
			'modelInsert' => array(
					'receta_ingrediente_id'=>NULL,
					'receta_id'	=>'',
					'ingrediente'=>''
				)
			);

		return $fields;
	}

	function initialize($args=array())
	{
		$this->fields['database']['primary_key_post'] = $args['primary_key_post'];	// id unico de la tabla
		$this->fields['database']['rel_key_post']	  = $args['rel_key_post'];		// id de la columna de la relacion...en este caso, producto_id
		$this->fields['crud'] = $args['crud'];
	}

	function insertar()
	{
		$this->db->where($this->fields['database']['rel_key'], $this->fields['database']['rel_key_post']);
		$this->db->delete($this->fields['database']['table_name']); 

		$inserta = $this->db->insert_batch($this->fields['database']['table_name'], $this->fields['crud']);

		if($inserta){
			return true;
		} else {
			return false;
		}
		
		return $this->fields['crud'];
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
		$this->db->order_by($this->fields['database']['primary_key']);
		$query = $this->db->get($this->fields['database']['table_name']);

		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}

	function getDatosByRelExtended($rel_id)
	{
		$fields = $this->fields;
		$rel_key_field = $this->fields['database']['table_name'].'.'.$this->fields['database']['rel_key'];

		$this->db->from($fields['database']['table_name']);
		
		foreach ($fields['relations'] as $relacion) {
			$rel = createArrayForDbJoins($relacion,$fields);
			$this->db->join($rel['table_name'], $rel['join'], $rel['type']);
		}

		$this->db->where($rel_key_field, $rel_id);
		$query = $this->db->get();

		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}
}