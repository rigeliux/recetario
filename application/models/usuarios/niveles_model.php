<?php
class Niveles_Model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function Grid(){
		
		
		$KoolControlsFolder = 'assets/class/KoolControls';
		
		require $KoolControlsFolder.'/KoolAjax/koolajax.php';
		$koolajax->scriptFolder = $KoolControlsFolder.'/KoolAjax';
		require $KoolControlsFolder.'/KoolGrid/koolgrid.php';
		
		$ds_datos = new MySQLDataSource($this->db->conn_id);
		$ds_datos->SelectCommand = "SELECT * FROM user_groups ORDER BY ugrp_name ASC";
		
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
		$column->DataField = "ugrp_id";
		$column->HeaderText = "ID";
		$column->CssClass = "c5";
		$column->Width = "50px";
		$column->Align = "center";
		$column->ReadOnly = true;
		$column->Filter = array("Exp"=>"Contain");
		$column->AllowFiltering = false;
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "ugrp_name";
		$column->HeaderText = "NOMBRE";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c20";
		$column->Width = "200px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "ugrp_desc";
		$column->HeaderText = "USUARIO";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c20";
		$column->Width = "200px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridCustomColumn();
		$column->ItemTemplate .= "<div class='btn-toolbar'><div class='btn-group'>";
		$column->ItemTemplate .= "	<a href='admin/usuarios/niveles/editar/{ugrp_id}?randNum=".microtime(true)."' class='btn btn-round editar nofollow' title='Editar'><i class='icono fuge-medium users users-edit inline'></i></a>";
		$column->ItemTemplate .= "	<a href='#' data-identificador='&#123; \"id\":\"{ugrp_id}\",\"seccion\":\"usuario_nivel\",\"nombre\":\"{ugrp_name}\" &#125;' class='btn btn-round eliminar nofollow'><i class='icono fuge-medium users users-del inline'></i></a>";
		$column->ItemTemplate .= "</div></div>";
		//$column->ItemTemplate .= "<a href='metodos/vehiculos/edit.php?id={id}&amp;randNum=".microtime(true)."' class=\"editbutton_css\" title='Editar'></a>";
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
		$grid->Localization->Load($KoolControlsFolder."/KoolGrid/localization/es.xml");
		
		$grid->Process();
		
		$data['koolajax']=$koolajax;
		$data['grid']=$grid;
		return $data;
	}
	
	function insertar(){
		$datos = $this->input->post('nivel',TRUE);
		
		$inserta = $this->flexi_auth->insert_group($datos['nombre'], $datos['desc'], $is_admin);
		
		if($inserta){
			return $datos;
		} else {
			return false;
		}
	}
	
	function editar(){
		$datos = $this->input->post('nivel',TRUE);
		$db_data = $this->flexi_auth->get_groups(FALSE, array('ugrp_id'=>$datos['id']) )->row_array();
		
		$group_data = array(
			'ugrp_name' => $datos['nombre'],
			'ugrp_desc' => $datos['desc']
		);
		
		$edita = $this->flexi_auth->update_group($datos['id'], $group_data);
		
		if($edita){
			return array_merge($datos,$db_data);
		} else {
			return false;
		}
	}
	
	function eliminar($id){		
		$datos = $this->flexi_auth->get_groups(FALSE, array('ugrp_id'=>$id) )->row_array();

		$elimina = $this->flexi_auth->delete_group($id);
		
		if($elimina){
			return $datos;
		} else {
			return false;
		}		
	}
}