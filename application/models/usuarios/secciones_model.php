<?php
class Secciones_Model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	
	function Grid(){
		
		
		$KoolControlsFolder = 'assets/class/KoolControls';
		
		require $KoolControlsFolder.'/KoolAjax/koolajax.php';
		$koolajax->scriptFolder = $KoolControlsFolder.'/KoolAjax';
		require $KoolControlsFolder.'/KoolGrid/koolgrid.php';
		
		$ds_datos = new MySQLDataSource($this->db->conn_id);
		$ds_datos->SelectCommand = "SELECT * FROM user_sections ORDER BY usec_name ASC";
		
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
		$column->DataField = "usec_id";
		$column->HeaderText = "ID";
		$column->CssClass = "c5";
		$column->Width = "50px";
		$column->Align = "center";
		$column->ReadOnly = true;
		$column->Filter = array("Exp"=>"Contain");
		$column->AllowFiltering = false;
		$grid->MasterTable->AddColumn($column);
		
		$column = new GridBoundColumn();
		$column->DataField = "usec_name";
		$column->HeaderText = "NOMBRE";
		$column->HeaderStyle->Align = "center";
		$column->CssClass = "c20";
		$column->Width = "200px";
		$column->Filter = array("Exp"=>"Contain");
		$grid->MasterTable->AddColumn($column);
		
		
		$column = new GridCustomColumn();
		$column->ItemTemplate .= "<div class='btn-toolbar'><div class='btn-group'>";
		$column->ItemTemplate .= "	<a href='admin/usuarios/secciones/editar/{usec_id}?randNum=".microtime(true)."' class='btn btn-round editar nofollow' title='Editar'><i class='icono fuge-medium users users-edit inline'></i></a>";
		$column->ItemTemplate .= "	<a href='#' data-identificador='&#123; \"id\":\"{usec_id}\",\"seccion\":\"usuario_secciones\",\"nombre\":\"{usec_name}\" &#125;' class='btn btn-round eliminar nofollow'><i class='icono fuge-medium users users-del inline'></i></a>";
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
		$datos = $this->input->post('seccion',TRUE);
		$arrData = array(
			0=>array(
				'short'	=>'Ver',
				'nombre'=>strtolower('Ver '.$datos[nombre]),
				'desc'	=>'El usuario puede ver la seccion '.$datos[nombre]
			),
			1=>array(
				'short'	=>'Insertar',
				'nombre'=>strtolower('Insertar '.$datos[nombre]),
				'desc'	=>'El usuario puede insertar en la seccion '.$datos[nombre]
			),
			2=>array(
				'short'	=>'Editar',
				'nombre'=>strtolower('Editar '.$datos[nombre]),
				'desc'	=>'El usuario puede editar en la seccion '.$datos[nombre]
			),
			3=>array(
				'short'	=>'Eliminar',
				'nombre'=>strtolower('Eliminar '.$datos[nombre]),
				'desc'	=>'El usuario puede eliminar en la seccion '.$datos[nombre]
			)
		);
		
		$inserta = $this->db->insert('user_sections', array(
														'usec_name'=>$datos['nombre'],
														'usec_desc'=>$datos['desc']
													));
		
		if($inserta){

			$secId=$this->db->insert_id();
			foreach($arrData as $i=>$e){
				$custom_data = array(
					'upriv_short'=>$e['short'],
					'upriv_usec_fk'=>$secId
				);
				$this->flexi_auth->insert_privilege($e['nombre'],$e['desc'],$custom_data);
			}
			return array_merge($datos,$arrData);
		} else {
			return false;
		}
		
	}
	
	function editar(){
		$datos = $this->input->post('seccion',TRUE);
		$db_data = $this->datosInfo( $datos['id'] );
		
		$arrData = array(
			0=>array(
				'short'	=>'Ver',
				'nombre'=>strtolower('Ver '.$datos[nombre]),
				'desc'	=>'El usuario puede ver la seccion '.$datos[nombre]
			),
			1=>array(
				'short'	=>'Insertar',
				'nombre'=>strtolower('Insertar '.$datos[nombre]),
				'desc'	=>'El usuario puede insertar en la seccion '.$datos[nombre]
			),
			2=>array(
				'short'	=>'Editar',
				'nombre'=>strtolower('Editar '.$datos[nombre]),
				'desc'	=>'El usuario puede editar en la seccion '.$datos[nombre]
			),
			3=>array(
				'short'	=>'Eliminar',
				'nombre'=>strtolower('Eliminar '.$datos[nombre]),
				'desc'	=>'El usuario puede eliminar en la seccion '.$datos[nombre]
			)
		);
		
		$data = array(
					'usec_name'=>$datos['nombre'],
					'usec_desc'=>$datos['desc']
				);
		$inserta = $this->db->update('user_sections', $data, "usec_id = $datos[id]");
		
		if($inserta){

			foreach($arrData as $i=>$e){
				$data = array(
							'upriv_name'=>$e['nombre'],
							'upriv_desc'=>$e['desc']
						);
				//$this->db->where('upriv_usec_fk =', $datos[id]);
				//$this->db->where('upriv_name LIKE %', $e[func]);
				//$this->db->update('user_privileges', $data);
				$this->db->update('user_privileges', $data, "upriv_usec_fk = $datos[id] AND upriv_short='$e[short]'");
			}
			return array_merge($datos,$db_data);
		} else {
			return false;
		}
		
	}
	
	function eliminar($id){
		$datos = $this->datosInfo($id);
		
		$this->db->where('usec_id', $id);
		$elimina = $this->db->delete('user_sections');
		
		if($elimina){
			$this->db->where('upriv_usec_fk', $id);
			$this->db->delete('user_privileges');
			return $datos;
		} else {
			return false;
		}
	}
	
	function datosInfo($id){		
		$this->db->where('usec_id',$id);
		$query = $this->db->get('user_sections');
		
		if($query){
			return $query->row_array();
		} else {
			return false;
		}
	}
}