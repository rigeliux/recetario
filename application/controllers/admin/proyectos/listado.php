<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado extends Admin_Controller {
	var $ruta_array = array();
	
	public function __construct(){
		parent::__construct();
		$this->load->model('proyectos/proyecto_listado_model','',TRUE);
		
		$this->ruta_array[directorio]	= $this->router->fetch_directory();
		$this->ruta_array[clase]		= $this->router->fetch_class();
		$this->ruta_array[ruta]			= $this->ruta_array[directorio].$this->ruta_array[clase];
	}
	
	public function index(){

		$data['titulo'] = $this->constantData['titulo'] = 'Listado de Productos';
		$this->load->view('admin/comunes/top', $this->constantData);
		$nivel = 'Ver '.$this->ruta_array[clase];
		
		//if($this->flexi_auth->is_privileged($nivel)){

			$data = $this->proyecto_listado_model->Grid();
			if($data){
				$content['msg']	= $this->load->view('admin/comunes/grid', $data, TRUE);
				$content['ruta']=$this->ruta_array;
				$this->load->view($this->ruta_array[ruta].'/base',$content);
			}
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->load->view('admin/comunes/bottom');
	}
	
	
	public function agregar(){
		$nivel = 'Insertar '.$this->ruta_array[clase];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		$row['categorias']	= $this->_rellenaSelect();
		$row['consant']		= $this->constantData;
		$this->load->view($this->ruta_array[ruta].'/add',$row);
	}
	
	public function editar($id){
		$nivel = 'Editar '.$this->ruta_array[clase];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, asi no se puede",403);
    	}
		
		$row['proyecto']	= $this->proyecto_listado_model->datosInfo( $id );
		$row['images']		= $this->_rellenaImages( $id );
		$row['categorias']	= $this->_rellenaSelect( $row['proyecto']['pcat_id_fk'] );
		$row['consant']		= $this->constantData;
		if($row){
			$this->load->view($this->ruta_array[ruta].'/edit', $row);
		}
	}
	
	function _rellenaSelect($id=''){
		$query = $this->proyecto_listado_model->datosSelect();
		
		$html ='<option value="" >Seleccione uno...</option>';
		foreach($query->result_array() as $row){
			$html.='<option value="'.$row[id].'" '.( ($id!='' && $id==$row[id]) ? 'selected':'').'>'.$row[nombre].'</option>';
		}
		return $html;
	}
	
	function _rellenaImages($proyecto_id){
		$query = $this->proyecto_listado_model->datosImages($proyecto_id);
		$imgsArr = array();
		if($query->num_rows() > 0){
			foreach($query->result_array() as $row){
				$html .= '
					<li id="'.$row[nombre].'" data-nombre="'.$row[nombre].'">
						<div class="fotos-lista">
							<div class="eliminaImg"><a href="#" data-nombre="'.$row[nombre].'"></a></div>
							<img src="assets/images/proyectos/thumb-80x80/'.$row[nombre].'" class="fotos-img">
						</div>
					</li>';
					$imgsArr[]=$row['nombre'];
			}
			$return = array( 'listado'=>'<ul id="sortable">'.$html.'</ul>','imgarr'=>$imgsArr );
			//return '<ul id="sortable">'.$html.'</ul>';
			return $return;
		}
	}
	
}

/* End of file listado.php */
/* Location: ./application/controllers/admin/proyectos/listado.php */