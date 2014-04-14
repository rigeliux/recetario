<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use Moltin\Cart\Cart;
use Moltin\Cart\Storage\Session;
use Moltin\Cart\Identifier\Cookie;

class Public_Controller extends MY_Controller
{
	public $cart;
	public $cartSessionStore;

	public function __construct()
	{
		parent::__construct();
		$this->cart = new Cart(new Session, new Cookie);
		
		$this->auth = new stdClass;
		$this->load->library('flexi_auth_lite', FALSE, 'flexi_auth');
		//$this->load->model('slides/slides_model');
		$this->constantData['padre']= $this->uri->rsegment(1);
		$this->constantData['total_items']=$this->cart->totalItems();
		$this->constantData['total']=$this->cart->total(false);
		//$this->constantData['hijo']= $this->uri->segment(2);
		//$this->constantData[cambiaLang]= $this->changeLang( $this->lang->lang(), $this->uri->segment(2), $this->uri->segment(3) );
		
		if($this->flexi_auth->is_logged_in()){
			$this->constantData['usuario'] = $this->flexi_auth->get_user_by_id_row_array();
		}
		//$this->output->enable_profiler(TRUE);
	}
	
	public function viewWeb($path, $data = '', $return = false)
	{
		return $this->load->view("web/".$path, $data, $return);
	}
	
	public function getKeywords($html)
	{
				
		$params['content'] = $html;
		$params['min_word_length'] = 5;
		$params['min_word_occur'] = 2;

		$params['min_2words_length'] = 4;
		$params['min_2words_phrase_length'] = 8;
		$params['min_2words_phrase_occur'] = 2;

		$params['min_3words_length'] = 3;
		$params['min_3words_phrase_length'] = 10;
		$params['min_3words_phrase_occur'] = 2;

		$this->load->library('Autokeyword',$params);
		
		$keywords = $this->autokeyword->get_keywords();
		
		return $keywords;
	}
}