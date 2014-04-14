<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado_Model extends CI_Model {
	public $fields;
	public $datos;

	function __construct()
	{
		parent::__construct();
		$this->fields = $this->initFields();
		$this->load->model('recetas/ingredientes_model');
		$this->load->model('recetas/preparacion_model');
	}

	function initFields()
	{
		$datos = $this->input->post('receta',TRUE);
		$fields = array(
			'database' => array(
					'table_name'=>'receta',
					'primary_key'=>'receta_id',
					'primary_key_post'=> $datos['id'],
					'name_key' =>'receta_nombre'
				),
			'crud' => array(
					'receta_nombre'	=>$datos['nombre'],
					'tiempo_preparacion'=>getTiempoPreparacion($datos['hrs'],$datos['mins']),
					'imagen'=>$datos['imagen']
				),
			'fieldNames' => array(
					'receta_id'	=> 'Clave',
					'receta_nombre'	=> 'Nombre',
					'tiempo_preparacion'=> 'Tiempo de Preparación',
					'imagen'=> 'Imagen'
				)
			);

		$this->datos = $datos;
		return $fields;

	}
	
	function Grid()
	{
		$this->load->model('grid_model');
		
		$grid_gen = array(
				'SelectCommand'=>"SELECT * FROM receta",
				'campos'=>array(
						array(
							'DataField' => 'receta_id',
							'HeaderText' => 'CLAVE'
						),
						array(
							'DataField' => 'receta_nombre',
							'HeaderText' => 'NOMBRE'
						),
						array(
							'DataField' => 'tiempo_preparacion',
							'HeaderText' => 'Tiempo'
						)/*,
						array(
							'columnType' => 'GridCalculatedColumn',
							'expresionFunction' => 'imageZoomSimple',
							'expresionValues'	=>	array(
														'nombre'=>"{imagen}",
														'tipo'	=> 'recetas',
														'thumb'	=> 'thumb-80x80'
													),
							'DataField' => 'imagen',
							'HeaderText' => 'IMAGEN'
						)*/
					)
			);

		return $this->grid_model->init($grid_gen);
	}
	
	function insertar()
	{
		$fields = $this->fields;
		$inserta = $this->db->insert($fields['database']['table_name'], $fields['crud']);
		
		if($inserta){
			$primary_key_id = $this->db->insert_id();
			$insert_prep = $this->preparaPreparacion($primary_key_id );
			$insert_ingr = $this->preparaIngredientes($primary_key_id );
			
			$data['form']=$fields['crud'];
			$data['insert_prep'] = $insert_prep;
			$data['insert_ingr'] = $insert_ingr;
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
			$primary_key_id = $fields['database']['primary_key_post'];
			$insert_prep = $this->preparaPreparacion($primary_key_id );
			$insert_ingr = $this->preparaIngredientes($primary_key_id );

			$data['db']=$db_data;
			$data['form']=$fields['crud'];
			$data['insert_prep'] = $ins_img;
			$data['insert_ingr'] = $ins_tag;
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
		$query = $this->db->get($tabla);
		
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
		$msgs['insertar']['exito']	= "La receta: <strong>".$args['form']['receta_nombre']."</strong> se registró con exito.";
		$msgs['editar']['exito']	= "La receta actualizó con exito:<br>".formatResultUpdate($args,$fields['fieldNames']);
		//$msgs['editar']['exito']	= print_r($args,true);
		$msgs['eliminar']['exito']	= "La receta se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);

		return $msgs;
	}

	function preparaIngredientes($primary_key_id) 
	{

		$crud = array();
		foreach(preg_split('/\r\n|[\r\n]/', $this->datos['ingredientes']) as $ingrediente) {
			if ($ingrediente!='') {
				$fields = array(
						'receta_ingrediente_id'=>null,
						'receta_id' => $primary_key_id,
						'ingrediente' => $ingrediente
					);
				$crud[]=$fields;
			}
		}

		$model_args = array(
				'rel_key_post' => $primary_key_id,
				'crud'=>$crud
			);

		$this->ingredientes_model->initialize($model_args);
		$insertar = $this->ingredientes_model->insertar();

		return $insertar;
	}

	function preparaPreparacion($primary_key_id) 
	{
		$crud = array();
		foreach($this->datos['preparacion'] as $index=>$instruccion) {
			if ($instruccion!='') {
				$fields = array(
						'receta_forma_preparacion_id'=>null,
						'receta_id' => $primary_key_id,
						'instruccion' => $instruccion
					);
				$crud[]=$fields;
			}
		}

		$model_args = array(
				'rel_key_post' => $primary_key_id,
				'crud'=>$crud
			);

		$this->preparacion_model->initialize($model_args);
		$insertar = $this->preparacion_model->insertar();

		return $insertar;
	}
}