<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado extends Admin_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model($this->constantData['ruta_modelo'],'',TRUE);
	}
	
	public function index(){
		
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['ver'];
		/**************************************************************
			Si quisieramos que una seccion tenga un titulo diferente:
			$data['titulo'] = 'Titulo de la seccion;
			$this->constantData['titulo'] = 'Titulo de la pagina';
		**************************************************************/
		$this->viewAdmin('comunes/top', $this->constantData);
		//if($this->flexi_auth->is_privileged($nivel)){

			$data = (count($data)>0 ? array_merge($this->$modelo->Grid(),$data):$this->$modelo->Grid());
			if($data){
				$content['msg']= $this->viewAdmin('comunes/grid', $data, TRUE);
				$this->viewAdmin($this->constantData['ruta'].'/base',$content);
			}
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom');
	}
	
	
	public function agregar(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['insertar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		
		$row['constant']=$this->constantData;
		$this->viewAdmin($this->constantData['ruta'].'/add',$row);
	}
	
	public function editar($id){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row['constant']=$this->constantData;
		$row['data'] = $this->$modelo->datosInfo($id);
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
		}
	}
	
	public function aplicar(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['editar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */ ) {
			show_error("No no no, asi no se puede",403);
    	}
		$row['constant']=$this->constantData;
		$row['tipo'] = $tipo;
		$row['select']['descuento']=$this->_rellenaSelect('descuento');
		$row['select']['marca']=$this->_rellenaSelect('marca','','minSel');
		$row['select']['categoria']=$this->_rellenaSelect('categoria','','minSel');
		$row['marcat'] = $this->_get_JS_CatMar();
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/descuentos', $row);
		}
	}
	
	function _rellenaSelect($tabla,$select='',$class=''){
		$modelo = $this->constantData['modelo'];
		$query = $this->$modelo->datosTabla($tabla);
		
		foreach($query->result_array() as $row){
			$id		= $row[$tabla.'_id'];
			$nombre	= $row[$tabla.'_nombre'];
			$apend	= '';
			$prepend= '';
			if($tabla=='descuento'){
				if($row[$tabla.'_tipo']==1){
					$apend = '%';
				} else {
					$prepend = '$';
				}
				$nombre.='( -'.$prepend.$row[$tabla.'_cantidad'].$apend.' )';
			}
			$selected = (($select!='' && $select==$id)? 'selected':'');
			$opts.="<option value='$id' $selected>$nombre</option>";
		}
		
		$html="<select name='producto[$tabla]' class='".($class!="" ? $class:"")."' data-rule-required='true'>$opts</select>";
		
		if($class!=''){
			$html="<select name='producto[$tabla][]' class='$class' data-rule-$class='1' multiple='multiple'>$opts</select>";
		}
		if($tabla=='descuento'){
			$html="<select name='producto[$tabla]' class='span12' data-rule-required='true'><option value=''>Seleccione uno...</option>$opts</select>";
		}
		return $html;
	}
	
	function _get_JS_CatMar(){
		$modelo = $this->constantData['modelo'];
		$query = $this->$modelo->getCategoriasMarcas();
		$json = array();
		foreach($query as $row){
			$r['id'] = $row['marca_id'];
			$r['nombre'] = $row['marca_nombre'];
			$json[ $row['categoria_nombre'] ][] = $r;
		}
		
		return base64_encode(json_encode($json));
	}
	
}

/* End of file marcas.php */
/* Location: ./application/controllers/admin/productos/marcas.php */