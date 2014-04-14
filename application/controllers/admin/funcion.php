<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Funcion extends Admin_Controller {
	var $dataloca =array();
	public function __construct(){
		parent::__construct();
		if ( !$this->input->is_ajax_request() ) {
			show_error("No no no, el señor no 'ta");
			//or redirect to wherever you would like
    	}
		$dataloca = $this->input->post(NULL,TRUE);
		//$this->output->enable_profiler();
	}
	
	public function index(){
		switch($this->input->post('funcion',TRUE)){
			case "elimina_images":
				//$args['tipo'] 	= $this->dataloca[tipo];
				//$args['images'] = $this->dataloca[images];
				echo $this->_elimina_images();
				break;
			case "bd-update":
				//$args['tipo'] 	= $this->dataloca[tipo];
				//$args['images'] = $this->dataloca[images];
				$step = $this->input->post('step',TRUE);
				echo $this->bd_update($step);
				break;
		}
	}
	
	public function doLogin(){

		$usuario = $this->input->post('usuario',TRUE);
		$password = $this->input->post('password',TRUE);
		$remember = FALSE;
		
		$login = $this->flexi_auth->login($usuario, $password, $remember);
		
		if($login){
			$usuario = $this->flexi_auth->get_user_by_id_row_array();
			$json['error'] = 0;
			$json['msg'] = 'Hola Usuario';
			$json['desc'] = 'Bienvenido: <strong>'.$usuario[uacc_username].'</strong>';
		} else {
			$json['error'] = 104;
			$json['msg'] = 'El nombre de usuario y/o contraseña son incorrectos.';
			$json['desc'] = $this->flexi_auth->get_messages();
		}
		echo json_encode($json);
	}
	
	public function doLogout(){
		$usuario = $this->flexi_auth->get_user_by_id_row_array();
		if($this->flexi_auth->logout(TRUE)){
			$json['error'] = 0;
			$json['msg'] = 'Adios '.$usuario[uacc_username];
			$json['desc'] = 'Nos vemos: <strong>'.$usuario[uacc_username].'</strong>';
		} else {
			$json['error'] = 104;
			$json['titulo'] = 'Problema Interno del Servidor';
			$json['msg'] = 'Hubo un problema con el servidor, vuelva a intentar.';
			$json['desc'] = 'Hubo un problema con el servidor, vuelva a intentar.';
		}
		echo json_encode($json);
	}
	
	public function doRegister(){
		//if( $this->flexi_auth->is_logged_in()){
			
			$seccion = $this->input->post('info',TRUE);
			$modelo = $this->_obtenModel($seccion);
			$this->load->model($modelo['ruta']);
			
			$inserta = $this->$modelo['nombre']->insertar();
			$msgs = $this->$modelo['nombre']->messages($inserta);
			
			if(!$inserta || $inserta['error']){
				$json['error'] = 1;
				$json['msg'] = $msgs[insertar][error];
				$json['titulo'] = 'Error al insertar';
				$json['desc'] = $msgs[insertar][error];
			} else {
				$json['error'] = 0;
				$json['msg'] = ucfirst($seccion).' registrado con exito';
				$json['desc'] = '<div class="function_result">'.$msgs[insertar][exito].'</div>';
				//$json['extra'] = $inserta[0];
			}
			
		//} else {
		//	$json['error'] = 104;
		//	$json['msg'] = 'No has iniciado sesión.';
		//	$json['desc'] = 'Porfavor inicia sesión antes de intentar guardar nada.';
		//}
		
		echo json_encode($json);
	}
	
	public function doUpdate(){
		//if( $this->flexi_auth->is_logged_in()){
			
			$seccion = $this->input->post('info',TRUE);
			$modelo = $this->_obtenModel($seccion);
			$this->load->model($modelo['ruta']);
			
			$edita = $this->$modelo['nombre']->editar();
			$msgs = $this->$modelo['nombre']->messages($edita);
			
			if(!$edita){
				$json['error'] = 1;
				$json['msg'] = $this->input->post('usuarios',TRUE);
				$json['titulo'] = 'Error al actualizar';
				$json['desc'] = $msgs[editar][error];
			} else {
				$json['error'] = 0;
				$json['msg'] = ucfirst($seccion).' actualizado con exito';
				$json['desc'] = '<div class="function_result">'.$msgs[editar][exito].'</div>';
				//$json['debug'] = print_r($edita,true);
			}
			
		//} else {
		//	$json['error'] = 104;
		//	$json['msg'] = 'No has iniciado sesión.';
		//	$json['desc'] = 'Porfavor inicia sesión antes de intentar guardar nada.';
		//}
		
		echo json_encode($json);
	}
	
	public function doDelete(){
		//if( $this->flexi_auth->is_logged_in()){
			
			$seccion = $this->input->post('info',TRUE);
			$id = $this->input->post('id',TRUE);
			$modelo = $this->_obtenModel($seccion);
			$this->load->model($modelo['ruta']);
			
			$elimina = $this->$modelo['nombre']->eliminar($id);
			$msgs = $this->$modelo['nombre']->messages($elimina);
			
			if(!$elimina){
				$json['error'] = 1;
				$json['msg'] = $this->input->post(NULL,TRUE);
				$json['titulo'] = 'Error al eliminar';
				$json['desc'] = $msgs[eliminar][error];
			} else {
				$json['error'] = 200;
				$json['msg'] = ucfirst($seccion).' eliminado con exito';
				$json['desc'] = '<div class="function_result">'.$msgs[eliminar][exito].'</div>';
				//$json['extra'] = $elimina;
			}
			
		//} else {
		//	$json['error'] = 104;
		//	$json['msg'] = 'No has iniciado sesión.';
		//	$json['desc'] = 'Porfavor inicia sesión antes de intentar guardar nada.';
		//}
		
		echo json_encode($json);
	}
	
	public function elimina_imagen_once(){
		$file = $this->input->post('borrar',TRUE);
		$carpeta = $this->input->post('tipo',TRUE);
		
		$path = 'assets/images/'.$carpeta;
		$directories = glob($path . '/*' , GLOB_ONLYDIR);
		foreach($directories as $dir){
			unlink($dir.'/'.$file);
			$a++;
		}
		unlink($path.'/'.$file);
		
		$this->db->where('nombre', $file);
		$this->db->delete('proyecto_imagen');
		
		echo $a;
	}
	
	function _elimina_images(){
		$files = json_decode($this->input->post('images',TRUE));
		$carpeta = $this->input->post('tipo',TRUE);
		$carpeta = ($carpeta!='' ? $carpeta:'proyectos');
		//$carpeta = 'proyectos';
		
		$path = 'assets/images/'.$carpeta;
		$directories = glob($path . '/*' , GLOB_ONLYDIR);
		foreach($directories as $dir){
			foreach($files as $file){
				@unlink($dir.'/'.$file);
				$a++;
			}
		}
		foreach($files as $file){
			@unlink($path.'/'.$file);
			$a++;
		}
		$json['msg']=$a;
		$json['error']=200;
		//$json['extra']=$carpeta;
		return json_encode($json);
	}
	
	function bd_update($step){
		$this->load->library('Productos_updater');
		//$updater = $this->Productos_updater;
		$file = json_decode($this->input->post('file',TRUE));
		switch($step){
			case "1":
				$unzip = $this->productos_updater->init($file);
				$json['error'] = $unzip['error'];
				$json['msg'] = $unzip['msg'];
				break;
			case "2":
				//$unzip = $updater->initUpdate();
				$json['error'] = $unzip['error'];
				$json['msg'] = $unzip['msg'];
				break;
		}
		
		echo json_encode($json);
	}
	
	
	function _obtenModel($seccion){
		/*
		To Do:
		- Inflector en español---- Listo
		- Convertir el Switch statico, a dinámico con el inflector.
		*/
		
		switch($seccion){
			case "cliente_listado":
				$nombre = 'listado_model';
				$ruta = 'clientes/'.$nombre;
				break;
			case "usuario_listado":
				$nombre = 'listado_model';
				$ruta = 'usuarios/'.$nombre;
				break;
			case "usuario_secciones":
				$nombre = 'secciones_model';
				$ruta = 'usuarios/'.$nombre;
				break;
			case "usuario_nivel":
				$nombre = 'niveles_model';
				$ruta = 'usuarios/'.$nombre;
				break;
			case "producto_marca":
				$nombre = 'marcas_model';
				$ruta = 'productos/'.$nombre;
				break;
			case "producto_categoria":
				$nombre = 'categorias_model';
				$ruta = 'productos/'.$nombre;
				break;
			case "receta_listado":
				$nombre = 'listado_model';
				$ruta = 'recetas/'.$nombre;
				break;
			case "producto_descuento":
				$nombre = 'listado_model';
				$ruta = 'descuentos/'.$nombre;
				break;
			case "rel_producto_descuento":
				$nombre = 'rel_producto_descuento_model';
				$ruta = 'descuentos/'.$nombre;
				break;
			case "image_listado":
			case "slide_listado":
				$nombre = 'slides_model';
				$ruta = $nombre;
				break;
		}
		
		$arg['nombre'] = $nombre;
		$arg['ruta'] = $ruta;
		
		return $arg;
	}
		
	function _msgDesc($seccion,$args=array()){
		/*
		To Do:
		- Pasar los mensajes a los modelos.
		- Localizar los mensajes dinamicamente.
		*/
		$arg=array();
		$arg['insertar']['error']	= "Hubo un problema al registrar, intente nuevamente.";
		$arg['editar']['error']		= "Hubo un problema al actualizar, intente nuevamente.";
		$arg['eliminar']['error']	= "Hubo un problema al eliminar, intente nuevamente.";
		switch($seccion){
			case "cliente_listado":
			case "usuario_listado":
				$arg['insertar']['exito'] = "El usuario: <strong>$args[upro_name]</strong> se registró con el usuario: <strong>$args[username]</strong>";
				$arg['insertar']['error'] = "Hubo un problema al regsitrar el usuario, intente nuevamente. <br>".$this->flexi_auth->get_messages();
				$arg['editar']['exito'] = "El usuario: <strong>$args[upro_name]</strong> con ID:$args[id] se actualizó con exito.";
				$arg['editar']['error'] = "Hubo un problema al actualizar el usuario, intente nuevamente. <br>".$this->flexi_auth->get_messages();
				$arg['eliminar']['exito'] = "El usuario: <strong>$args[upro_name]</strong> se eliminó con exito.";
				break;
			case "usuario_secciones":
				$arg['insertar']['exito'] = "La seccion: <strong>$args[nombre]</strong> se registró con exito.";
				$arg['insertar']['error'] = "Hubo un problema al regsitrar la seccion, intente nuevamente. <br>".$this->flexi_auth->get_messages();
				$arg['editar']['exito'] = "La seccion: <strong>$args[usec_name]</strong> se actualizó a <strong>$args[nombre]</strong> con exito.";
				$arg['editar']['error'] = "Hubo un problema al actualizar la seccion, intente nuevamente. <br>".$this->flexi_auth->get_messages();
				$arg['eliminar']['exito'] = "La seccion: <strong>$args[usec_name]</strong> se eliminó con exito.";
				break;
			case "usuario_nivel":
				$arg['insertar']['exito'] = "El nivel: <strong>$args[nombre]</strong> se registró con exito.";
				$arg['editar']['exito'] = "El nivel: <strong>$args[ugrp_name]</strong> se actualizó a <strong>$args[nombre]</strong> con exito.";
				$arg['editar']['error'] = "Hubo un problema al actualizar la seccion, intente nuevamente. <br>".$this->flexi_auth->get_messages();
				$arg['eliminar']['exito'] = "El nivel: <strong>$args[nombre]</strong> se eliminó con exito.";
				break;
			case "producto_marca":
				$arg['insertar']['exito'] = "La marca: <strong>$args[nombre]</strong> se registró con exito.";
				$arg['editar']['exito'] = "La marca: <strong>$args[marca_nombre]</strong> se actualizó a <strong>$args[nombre]</strong> con exito.";
				$arg['eliminar']['exito'] = "La marca: <strong>$args[marca_nombre]</strong> se eliminó con exito.";
				break;
			case "producto_categoria":
				$arg['insertar']['exito'] = "La categoria: <strong>$args[nombre]</strong> se registró con exito.";
				$arg['editar']['exito'] = "La categoria: <strong>$args[categoria_nombre]</strong> se actualizó a <strong>$args[nombre]</strong> con exito.";
				$arg['eliminar']['exito'] = "La categoria: <strong>$args[categoria_nombre]</strong> se eliminó con exito.";
				break;
			case "producto_descuento":
				$arg['insertar']['exito'] = "El descuento: <strong>$args[nombre]</strong> se registró con exito.";
				$arg['editar']['exito'] = "El descuento: <strong>$args[descuento_nombre]</strong> se actualizó a <strong>$args[nombre]</strong> con exito.";
				$arg['eliminar']['exito'] = "El descuento: <strong>$args[descuento_nombre]</strong> se eliminó con exito.";
				break;
			case "producto_listado":
				$arg['insertar']['exito'] = "El perfume: <strong>$args[nombre]</strong> se registró con exito.";
				$arg['editar']['exito'] = "El perfume: <strong>$args[producto_nombre]</strong> se actualizó a <strong>$args[nombre]</strong> con exito.";
				$arg['eliminar']['exito'] = "El perfume: <strong>$args[producto_nombre]</strong> se eliminó con exito.";
				break;
			case "rel_producto_descuento":
				//$arg['insertar']['exito'] = '<pre>'.print_r($args,true).'</pre>';
				$arg['insertar']['exito'] = $args['final'];
				$arg['insertar']['error'] = $args['final'];
				$arg['eliminar']['exito'] = $args['final'];
				break;
			case "slide_listado":
				$arg['insertar']['exito'] = "La imagen: <strong>$args[fotos]</strong> se registró con exito.";
				$arg['editar']['exito'] = "La imagen: <strong>$args[slide_titulo]</strong> se actualizó a <strong>$args[titulo]</strong> con exito.";
				$arg['eliminar']['exito'] = "La imagen: <strong>$args[slide_titulo]</strong> se eliminó con exito.";
				break;
			
		}
		return $arg;
	}
	
}