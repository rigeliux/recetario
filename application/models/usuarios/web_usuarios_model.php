<?php
class Web_Usuarios_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	
	function insertar(){
		$datos = $this->input->post('usuario',TRUE);
		
		$user_data['email'] = $datos['email'];
		$user_data['username'] = $datos['email'];
		$user_data['password'] = $datos['password'];
		$user_data['nivel'] = '1';
		$user_data['activo'] = TRUE;

		$profile_data = array(
				'upro_name' => $datos['nombre'],
				'upro_apellidos' => $datos['apellido'],
				'upro_phone' => '0',
				'upro_noticias' => (bool)$datos['noticias']
			);
		
		$inserta = $this->flexi_auth->insert_user($user_data[email], $user_data[username], $user_data[password], $profile_data, $user_data[nivel], $user_data[activo]);
		
		if(!$inserta){
			return false;
		} else {
			return array_merge($user_data,$profile_data);
		}
	}
	
	function editar(){
		$datos = $this->input->post('usuarios',TRUE);
		
		$user_data = array(
				'uacc_username'	=> $datos['usuario'],
				'uacc_password'	=> $datos['pass'],
				'uacc_group_fk' => $datos['nivel'],
				'uacc_active'	=> (bool)$datos['activo'],
				'upro_uacc_fk'	=> $datos['id'],
				'upro_name' => $datos['nombre']
			);
		
		$inserta = $this->flexi_auth->update_user($datos['id'], $user_data);
		
		if(!$inserta){
			return false;
		} else {
			$user_data[id] = $datos['id'];
			return $user_data;
		}
	}
	
	function eliminar($id){		
		$datos = $this->flexi_auth->get_user_by_id_query($id)->row_array();

		$elimina = $this->flexi_auth->delete_user($id);
		
		if($elimina){
			return $datos;
		} else {
			return false;
		}		
	}
}