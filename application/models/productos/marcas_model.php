<?php
class Marcas_Model extends CI_Model {

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
		$ds_datos->SelectCommand = "SELECT * FROM producto_marca ORDER BY marca_nombre ASC";
		
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
		$column->DataField = "marca_id";
		$column->HeaderText = "ID";
		$column->CssClass = "c5";
		$column->Width = "50px";
		$column->Align = "center";
		$column->ReadOnly = true;
		$column->Filter = array("Exp"=>"Contain");
		$column->AllowFiltering = false;
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "marca_nombre";
		$column->HeaderText = "NOMBRE";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c30";
		$column->Width = "300px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "marca_rating";
		$column->HeaderText = "RATING";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c30";
		$column->Width = "300px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridCustomColumn();
		$column->ItemTemplate .= "<div class='btn-toolbar'><div class='btn-group'>";
		$column->ItemTemplate .= "<a href='admin/productos/marcas/editar/{marca_id}?randNum=".microtime(true)."' class='btn btn-round editar nofollow' title='Editar'><i class='icono fuge-medium users users-edit inline'></i></a>";
		$column->ItemTemplate .= "<a href='#' rel='nofollow' data-identificador='&#123; \"id\":\"{marca_id}\",\"seccion\":\"producto_marca\",\"nombre\":\"{marca_nombre}\" &#125;' class='btn btn-round eliminar nofollow'><i class='icono fuge-medium users users-del inline'></i></a>";
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
		$datos = $this->input->post('marca',TRUE);
		
		$data = array(
				'marca_nombre'=>$datos['nombre'],
				'marca_rating'=>$datos['rating']
			);
		
		$inserta = $this->db->insert('producto_marca', $data);
		
		if($inserta){
			return $datos;
		} else {
			return false;
		}
	}
	
	function editar(){
		$datos = $this->input->post('marca',TRUE);
		
		$data = array(
				'marca_nombre'=>$datos['nombre'],
				'marca_rating'=>$datos['rating']
			);
			
		$db_data = $this->datosInfo($datos['id']);
		
		$this->db->where('marca_id', $datos['id']);
		$actualiza = $this->db->update('producto_marca', $data);
		
		if($actualiza){
			return array_merge($datos,$db_data);
		} else {
			return false;
		}
		
	}
	
	function eliminar($id){		
		$datos = $this->datosInfo($id);
		
		$this->db->where('marca_id', $id);
		$elimina = $this->db->delete('producto_marca');
		
		if($elimina){
			return $datos;
		} else {
			return false;
		}		
	}
	
	function datosInfo($id){
		$this->db->where('marca_id',$id);
		$query = $this->db->get('producto_marca');
		
		if($query){
			return $query->row_array();
		} else {
			return false;
		}
	}
}