<?php
class Listado_Model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function Grid(){
		
		function cambia($entero){
			$entero = intval($entero);
			$texto;
			switch($entero){
				case 0:
					$texto = "Desactivado";
					break;
				case 1:
					$texto = "Activo";
					break;
				default:
					$texto = "nopaso";
					break;
			}
			return $texto;
		}
		
		$KoolControlsFolder = 'assets/class/KoolControls';
		
		require $KoolControlsFolder.'/KoolAjax/koolajax.php';
		$koolajax->scriptFolder = $KoolControlsFolder.'/KoolAjax';
		require $KoolControlsFolder.'/KoolGrid/koolgrid.php';
		
		$ds_datos = new MySQLDataSource($this->db->conn_id);
		$ds_datos->SelectCommand = "SELECT t1.uacc_id,t3.upro_name,t1.uacc_username,t2.ugrp_name AS nivel,t1.uacc_active FROM user_accounts AS t1 INNER JOIN user_groups AS t2 ON t2.ugrp_id=t1.uacc_group_fk INNER JOIN user_profiles AS t3 ON t3.upro_uacc_fk=t1.uacc_id WHERE t2.ugrp_admin = 1 ORDER BY t1.uacc_username ASC";
		
		$grid = new KoolGrid("grid");
		$grid->scriptFolder = $KoolControlsFolder."/KoolGrid";
		$grid->styleFolder="office2010blue";
		$grid->Width = "100%";
		$grid->PageSize = "10";
		$grid->RowAlternative = true;
		$grid->AjaxEnabled = true;
		$grid->AjaxLoadingImage =  $KoolControlsFolder."/KoolAjax/loading/4.gif";
		
		$grid->ColumnWrap = true;
		$grid->AllowSorting = true;
		$grid->AllowEditing = true;
		$grid->AllowDeleting = true;
		$grid->AllowSelecting = false;
		$grid->AllowResizing = true;
		$grid->AllowHtmlRender = true; 
		$grid->AllowFiltering = true;
		$grid->AllowScrolling = true;
		$grid->KeepSelectedRecords = true;
		
		$column = new GridBoundColumn();
		$column->DataField = "uacc_id";
		$column->HeaderText = "ID";
		$column->CssClass = "c5";
		$column->Width = "50px";
		$column->Align = "center";
		$column->ReadOnly = true;
		$column->Filter = array("Exp"=>"Contain");
		$column->AllowFiltering = false;
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "upro_name";
		$column->HeaderText = "NOMBRE";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c30";
		$column->Width = "300px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "uacc_username";
		$column->HeaderText = "USUARIO";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c30";
		$column->Width = "300px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		$base_url = base_url_admin($this->constantData['ruta']);
		$column = new GridCustomColumn();
		$column->ItemTemplate .= "<div class='btn-toolbar'><div class='btn-group'>";
		$column->ItemTemplate .= "<a href='$base_url/editar/{uacc_id}?randNum=".microtime(true)."' class='btn btn-round editar nofollow' title='Editar'><i class='fa fa-pencil-square-o fa-lg'></i></a>";
		$column->ItemTemplate .= "<a href='#' data-identificador='&#123; \"id\":\"{uacc_id}\",\"seccion\":\"usuario_listado\",\"nombre\":\"{upro_name}\" &#125;' class='btn btn-round eliminar nofollow'><i class='fa fa-minus-square-o fa-lg'></i></a>";
		$column->ItemTemplate .= "</div></div>";
		$column->Align = "center";
		$column->CssClass = "c20";
		$column->Width = "200px";
		$column->AllowResizing = false;
		$column->AllowFiltering = false;
		$grid->MasterTable->AddColumn($column);
		
		$grid->DataSource = $ds_datos;
		$grid->ClientSettings->ClientEvents["OnInit"] = "Handle_OnInit";
		$grid->ClientSettings->ClientEvents["OnLoad"] = "Handle_OnInit";
	
		
		$grid->MasterTable->Pager = new GridPrevNextAndNumericPager();
		$grid->MasterTable->Pager->ShowPageSize = TRUE;
		$grid->Localization->Load($KoolControlsFolder."/KoolGrid/localization/es.xml");
		
		$grid->Process();
		
		$data['koolajax']=$koolajax;
		$data['grid']=$grid;
		return $data;
	}
	
	function insertar_admin(){
		$datos = $this->input->post('usuarios',TRUE);
		
		$user_data[email] = 'admin@asd.com';
		$user_data[username] = 'admin';
		$user_data[password] = 'admin';
		$user_data[nivel] = '1';
		$user_data[activo] = TRUE;

		$profile_data = array(
				'upro_name' => 'Admin',
				'upro_apellidos' => '',
				'upro_tel' => '0'
			);
		
		$inserta = $this->flexi_auth->insert_user($user_data[email], $user_data[username], $user_data[password], $profile_data, $user_data[nivel], $user_data[activo]);
		
		if(!$inserta){
			return false;
		} else {
			return array_merge($user_data,$profile_data);
		}
	}
	
	function insertar(){
		$datos = $this->input->post('usuarios',TRUE);
		
		$user_data[email] = $datos['usuario'].'@asd.com';
		$user_data[username] = $datos['usuario'];
		$user_data[password] = $datos['pass'];
		$user_data[nivel] = $datos['nivel'];
		$user_data[activo] = (bool)$datos['activo'];

		$profile_data = array(
				'upro_name' => $datos['nombre'],
				'upro_phone' => '0',
				'upro_noticias' => ''
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

	function messages($args = array())
	{
		$msgs = array();

		$msgs['insertar']['exito'] = "El usuario: <strong>$args[upro_name]</strong> se registró con el usuario: <strong>$args[username]</strong>";
		$msgs['insertar']['error'] = "Hubo un problema al regsitrar el usuario, intente nuevamente. <br>".$this->flexi_auth->get_messages();
		$msgs['editar']['exito'] = "El usuario: <strong>$args[upro_name]</strong> con ID:$args[id] se actualizó con exito.";
		$msgs['editar']['error'] = "Hubo un problema al actualizar el usuario, intente nuevamente. <br>".$this->flexi_auth->get_messages();
		$msgs['eliminar']['exito'] = "El usuario: <strong>$args[upro_name]</strong> se eliminó con exito.";
		$msgs['eliminar']['error'] = "Hubo un problema al eliminar, intente nuevamente.";

		return $msgs;
	}
}