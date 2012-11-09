<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Shop_model extends CI_Model { 
    var $shop_table = 'bs_shop_info' ;     

    function __construct() {
		parent::__construct();
        $this->load->database() ; 
    }

    public function insertShop($obj){ 
		$this->db->insert('bs_shop_info', $obj);
    } 

    public function updateShop($obj){

    }

    public function getShopById(){

    } 

    public function getShopByUserId(){

    }
}
