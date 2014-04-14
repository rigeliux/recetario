<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$common = $this->common;
		$this->auth = new stdClass;
		$this->load->library('flexi_auth');
		$this->load->helper('admin_helper');
		$this->load->helper('grid_helper');
		$this->constantData['scripts']=array();
		$this->constantData['css']=array();
		
		
			/*if(!$this->flexi_auth->is_admin()){
				redirect('admin/login');
			}*/
			if ( !$this->input->is_ajax_request() ){
				$this->session->sess_update();
			}
			//$this->constantData['siteName'] = ' | Sistma Integral de Administración';
			$this->constantData['padre'] = $this->uri->segment(2);
			$this->constantData['hijo'] = $this->uri->segment(3);
			$this->constantData['menu'] = $this->viewAdmin('comunes/menu', $this->constantData,TRUE);
			
			$this->constantData['clase']		= $this->router->fetch_class();
			$this->constantData['modelo']		= $this->constantData['clase'].'_model';
			//$this->constantData['ruta']			= $this->constantData['padre'].'/'.$this->constantData[clase];
			//$this->constantData['ruta']			= $this->_ruta();
			$this->constantData['ruta']			= $this->_ruta();
			$this->constantData['ruta_modelo']	= $this->constantData['ruta'].'_model';
			$this->constantData['site_url']		= siteUrlAdmin();
			$this->constantData['site_url_simple']			= siteUrlAdmin($this->constantData['padre']);
			$this->constantData['privilegos']['ver']		= 'Ver '.$this->constantData['clase'];
			$this->constantData['privilegos']['insertar']	= 'Insertar '.$this->constantData['clase'];
			$this->constantData['privilegos']['editar']		= 'Editar '.$this->constantData['clase'];
			$this->constantData['privilegos']['eliminar']	= 'Eliminar '.$this->constantData['clase'];
			
			$this->constantData['titulo'] = 'Listado de '.$this->constantData['clase'];
			$this->constantData['botones_l'] = array(
					'buscar' => array(
								'css-class'=>'nofollow buscar',
								'icon' => '<i class="fa fa-search-plus fa-3x"></i>',
								'text' => 'Buscar',
								'href' => ''
							)
				);
			$this->constantData['botones_r'] = array(
					'agregar' => array(
								'css-class'=>'addNew',
								'icon' => '<i class="fa fa-plus-square fa-3x"></i>',
								'text' => 'Agregar',
								'href' => 'agregar'
							)
				);
			//$this->output->enable_profiler();
		
	}
	
	public function viewAdmin($path, $data = '', $return = false)
	{
		return $this->load->view("admin/".$path, $data, $return);
	}

	public function _ruta()
	{
		$ruta = $this->constantData['padre'];
		if($this->constantData['hijo']!='' && $this->constantData['hijo']!='agregar' && $this->constantData['hijo']!='editar')
		{
			$ruta.= '/'.$this->constantData[clase];
		}
		return $ruta;
	}
}