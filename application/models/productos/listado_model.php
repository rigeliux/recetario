<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado_Model extends CI_Model {
	public $fields;
	public $datos;

	function __construct()
	{
		parent::__construct();
		$this->fields = $this->initFields();
		$this->load->model('images_model');
		$this->load->model('productos/rel_producto_categoria_model');
	}

	function initFields()
	{
		$datos = $this->input->post('producto',TRUE);
		$fields = array(
			'database' => array(
					'table_name'=>'producto_listado',
					'primary_key'=>'producto_id',
					'primary_key_post'=> $datos['id'],
					'name_key' =>'producto_nombre'
				),
			'crud' => array(
					'producto_clave'	=>$datos['clave'],
					'producto_nombre'	=>$datos['nombre'],
					'producto_detalles'	=>$datos['detalles'],
					'producto_datos_tecnicos'=>$datos['datos_tecnicos'],
					'producto_precio'	=>clean_number($datos['precio']),
					'producto_rating'	=>$datos['rating'],
					'producto_destacado'=>$datos['destacado']
				),
			'fieldNames' => array(
					'producto_clave'	=> 'Clave',
					'producto_nombre'	=> 'Nombre',
					'producto_detalles'	=> 'Detalles',
					'producto_datos_tecnicos'=> 'Datos Técnicos',
					'producto_precio'	=> 'Precio'
				)
			);

		$this->datos = $datos;
		return $fields;

	}
	
	function Grid()
	{
		$this->load->model('grid_model');
		
		$grid_gen = array(
				'SelectCommand'=>"SELECT * FROM producto_listado",
				'campos'=>array(
						array(
							'DataField' => 'producto_clave',
							'HeaderText' => 'CLAVE'
						),
						array(
							'DataField' => 'producto_nombre',
							'HeaderText' => 'NOMBRE'
						),
						array(
							'DataField' => 'producto_precio',
							'HeaderText' => 'PRECIO'
						),
						array(
							'columnType' => 'GridCalculatedColumn',
							'expresionFunction' => 'rating',
							'expresionValues'	=>	array(
														'entero'=>"{producto_rating}"
													),
							'DataField' => 'producto_rating',
							'HeaderText' => 'RATING'
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
			$images_args = array(
					'tipo_id'=>'1',
					'rel_key_post' => $this->db->insert_id(),
					'images' => $this->datos['imagenes']
				);
			$this->images_model->initialize($images_args);
			$ins_img = $this->images_model->insertar();

			$data['form']=$fields['crud'];
			$data['insert_img'] = $ins_img;
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
			$images_args = array(
					'tipo_id'=>'1',
					'rel_key_post' => $fields['database']['primary_key_post'],
					'images' => $this->datos['imagenes']
				);
			$this->images_model->initialize($images_args);
			$ins_img = $this->images_model->insertar();

			$tags_args = array(
					'rel_key_post' => $fields['database']['primary_key_post'],
					'lista' => $this->datos['tags']
				);
			$this->rel_producto_categoria_model->initialize($tags_args);
			$ins_tag = $this->rel_producto_categoria_model->insertar();

			$data['db']=$db_data;
			$data['form']=$fields['crud'];
			$data['insert_img'] = $ins_img;
			$data['insert_tag'] = $ins_tag;
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
	
	function datosTabla($tabla){
		//$this->db->where($tabla.'_id',$id);
		$query = $this->db->get('producto_'.$tabla);
		
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
		$msgs['insertar']['exito']	= "El libro: <strong>".$args['form']['producto_nombre']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "El libro actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		//$msgs['editar']['exito']	= print_r($args,true);
		$msgs['eliminar']['exito']	= "El libro se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);

		return $msgs;
	}
}