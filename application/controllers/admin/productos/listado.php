<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Listado extends Admin_Controller{
	
	public function __construct(){
		parent::__construct();
		
		$this->load->model($this->constantData['ruta_modelo'],'',TRUE);
		$this->load->model('images_model');
		$this->load->model('productos/categorias_model');
		$this->load->model('productos/rel_producto_categoria_model','prod_mod');

		regiter_css(array('uploadifive','select2','select2-bootstrap'));
		regiter_script(array('jquery.uploadifive','bootbox.min','select2.min','catalogos'));
	}
	
	public function index(){
		
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['ver'];
		/**************************************************************
			Si quisieramos que una seccion tenga un titulo diferente:
			$data['titulo'] = 'Titulo de la seccion;
			$this->constantData['titulo'] = 'Titulo de la pagina';
		**************************************************************/
		$this->constantData['titulo'] = 'Listado de Prodcutos';
		$this->constantData['botones_r']['agregar']['text'] = 'Agregar Producto';
		$this->viewAdmin('comunes/top', $this->constantData);
		//if($this->flexi_auth->is_privileged($nivel)){

			$this->constantData['gridd']=$this->$modelo->Grid();
			$content['grid']= $this->viewAdmin('comunes/grid', $this->constantData, TRUE);
			$content['constantData'] = $this->constantData;
			$this->viewAdmin('comunes/contenido',$content);
			
		/*} else {
			$this->load->view('error/403');
		}*/
		$this->viewAdmin('comunes/bottom', $this->constantData);
	}
	
	
	public function agregar(){
		$modelo = $this->constantData['modelo'];
		$nivel = $this->constantData['privilegos']['insertar'];
		
		if ( !$this->input->is_ajax_request() /*|| !$this->flexi_auth->is_privileged($nivel) */) {
			show_error("No no no, así no se puede",403);
    	}
		
		$row['constant']=$this->constantData;
		$row['categoria']['list']=$this->categorias_model->getDatos(true);
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
		$row['images'] = $this->images_model->getDatosByRel($id);
		$row['categoria']['list']=$this->categorias_model->getDatos(true);
		$row['categoria']['select']=returnFieldByCommas($this->prod_mod->getDatosByRelExtended($id),'categoria_nombre');
		if($row){
			$this->viewAdmin($this->constantData['ruta'].'/edit', $row);
		}
	}
	
	
	function _rellenaSelect($tabla,$select='',$class=''){
		$modelo = $this->constantData['modelo'];
		$query = $this->$modelo->datosTabla($tabla);
		
		foreach($query->result_array() as $row){
			$id		= $row[$tabla.'_id'];
			$nombre	= $row[$tabla.'_nombre'];
			$selected = (($select!='' && $select==$id)? 'selected':'');
			$opts.="<option value='$id' $selected>$nombre</option>";
		}
		
		$html="<select name='producto[$tabla]' class='span12' data-rule-required='true'><option value=''>".ucfirst($tabla)." del producto</option>$opts</select>";
		
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

/* End of file listado.php */
/* Location: ./application/controllers/admin/productos/listado.php */