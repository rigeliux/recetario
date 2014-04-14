<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Web_Listado_Model extends CI_Model {
	var $getvars;
	
	public function __construct() {
		parent::__construct();
		$this->getvars = $this->input->get(NULL, TRUE);
	}
	
	function getCategorias(){
		$categoria = $this->getvars['g'];
		$this->db->select("t2.categoria_id AS id,t2.categoria_nombre AS nombre, Count(*) AS conteo");
		$this->db->from("producto_listado t1");
		$this->db->join("producto_categoria t2", "t2.categoria_id = t1.producto_categoria","inner");
		$this->db->group_by("t1.producto_categoria");
		$this->db->order_by("nombre", "ASC");
		
		$query = $this->db->get();
		
		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	
	function getProductos($cur_page,$limit,$string=NULL){
		$start	= ($cur_page-1) * $limit;
		$this->db->select("SQL_CALC_FOUND_ROWS null as rows,producto_id,producto_nombre,producto_detalles,producto_precio",FALSE);
		$this->db->from("producto_listado t1");

		if($string!=NULL){
			$this->db->where('MATCH (producto_nombre,producto_detalles) AGAINST ("'. $string .'" IN BOOLEAN MODE)', NULL, FALSE);
		}

		$this->db->order_by("t1.producto_id", "orderby, direction"); 
		$this->db->limit($limit,$start); 
		$query = $this->db->get();
		
		if($query){
			return $query;
		} else {
			return false;
		}
	}

	function getProductosTags($start,$limit,$string){
		$this->db->select("SQL_CALC_FOUND_ROWS null as rows,t2.producto_id,t2.producto_nombre,t2.producto_detalles,t2.producto_precio,t3.categoria_nombre",FALSE);
		$this->db->from("rel_producto_categoria t1");
		$this->db->join("producto_listado t2","t2.producto_id = t1.producto_id","inner");
		$this->db->join("producto_categoria t3","t3.categoria_id = t1.categoria_id","inner");
		$this->db->like("t3.categoria_slug",$string);
		$this->db->order_by("t2.producto_nombre"); 
		$this->db->limit($limit,$start); 
		$query = $this->db->get();
		
		if($query){
			return $query;
		} else {
			return false;
		}
	}

	function getImagenProducto($id)
	{
		$this->db->select("image_nombre");
		$this->db->from("image_listado");
		$this->db->where("image_tipo",1);
		$this->db->where("image_rel_id",$id);
		$this->db->order_by("image_orden"); 
		$this->db->limit(1); 
		$query = $this->db->get();

		if($query){
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	function getTotalRows(){
		return $this->db->query('SELECT FOUND_ROWS() count;')->row()->count;
	}
	
	function getProducto($item){
		$id = getId($item);
		
		$this->db->select("*");
		$this->db->from("producto_listado t1");
		$this->db->where("t1.producto_id",$id); 
		$this->db->limit('1'); 
		$query = $this->db->get();
		
		if($query){
			return $query->row_array();
		} else {
			return false;
		}
	}
	
	function getProductoCart($ids){
		
		$this->db->select("t1.producto_id,t2.marca_id,t2.marca_nombre,t3.categoria_id,t3.categoria_nombre,t1.producto_clave,t1.producto_nombre,t1.producto_presentacion,t1.producto_detalles,t1.producto_precio");
		$this->db->from("producto_listado t1");
		$this->db->join("producto_marca t2", "t2.marca_id = t1.producto_marca","inner");
		$this->db->join("producto_categoria t3", "t3.categoria_id = t1.producto_categoria","inner");
		$this->db->where_in("t1.producto_id",$id); 
		$query = $this->db->get();
		
		if($query){
			return $query->result_array();
		} else {
			return false;
		}
	}
	
	function getRelacionados()
	{
		$sql_rand = "
					SELECT 
						t1.categoria_id,
						t1.categoria_nombre,
						t1.categoria_slug
					FROM producto_categoria AS t1
					JOIN
						(
						 SELECT ABS(
						 			FLOOR(
										(RAND() * (SELECT 
														MAX(categoria_id) 
													FROM 
														producto_categoria
													)
										)
									)
								) AS id
						) AS t2
					WHERE 
						t1.categoria_id >= t2.id
					ORDER BY 
						t2.id ASC
					LIMIT 1";
		
		$sql_id_rand = "($sql_rand) UNION ($sql_rand) UNION ($sql_rand) UNION ($sql_rand) UNION ($sql_rand) UNION ($sql_rand)";
		$rand = $this->db->query($sql_id_rand);

		if($rand->num_rows()>0){
			return $rand->result_array();
		} else {
			return false;
		}
		
	}
	
}