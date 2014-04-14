<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado_model extends CI_Model {

	public $fields;
	public $datos;

	function __construct(){
		parent::__construct();
		$this->fields = $this->initFields();
	}

	function initFields()
	{
		$datos = $this->input->post('carrito',TRUE);
		$fields = array(
			'database' => array(
					'table_name'	=>'pedido_listado',
					'primary_key'	=>'pedido_id',
					'name_key'		=>'pedido_usuario'
				),
			'crud' => array(
					'pedido_id' 		=> null,
					'pedido_usuario'	=> $datos['nombre'],
					'pedido_usuario_info'=> base64_encode(serialize($datos)),
					'pedido_carrito'	=> '',
					'pedido_total'		=> ''
				),
			'fieldNames' => array(
					'pedido_usuario'=> 'Nombre',
					'pedido_total'	=> 'Total'
				)
			);

		$this->datos = $datos;
		return $fields;

	}
	
	function Grid()
	{
		$this->load->model('grid_model');
		
		$grid_gen = array(
				'SelectCommand'=>"SELECT * FROM pedido_listado ORDER BY pedido_id DESC",
				'campos'=>array(
						array(
							'DataField' => 'pedido_id',
							'HeaderText' => 'PEDIDO'
						),
						array(
							'DataField' => 'pedido_usuario',
							'HeaderText' => 'NOMBRE'
						),
						array(
							'DataField' => 'pedido_total',
							'HeaderText' => 'TOTAL'
						)
					),
				''
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

	function messages($args = array())
	{
		$fields = $this->fields;
		$msgs = array();
		$msgs['insertar']['error']	= "Hubo un problema al registrar, intente nuevamente.";
		$msgs['editar']['error']	= "Hubo un problema al actualizar, intente nuevamente.";
		$msgs['eliminar']['error']	= "Hubo un problema al eliminar, intente nuevamente.";
		$msgs['insertar']['exito']	= "El pedido se registró con exito.";
		$msgs['eliminar']['exito']	= "El pedido se eliminó con exito:<br>".formatResultDelete($args,$fields['fieldNames']);


		return $msgs;
	}
}