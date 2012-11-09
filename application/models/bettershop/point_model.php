<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Point_model extends CI_Model { 
    var $point_table = 'bs_point_log' ; 
    
    function __construct(){
        parent::__construct() ; 
        $this->load->database() ;
    }

    public function getPointLogList($type,$shop_code,$page=1,$list_count=20){ 
        $this->db->limit($list_count , ($page-1)*$list_count ) ; 
        $this->db->where('shop_code' ,$shop_code ) ; 
        $this->db->where('type' ,$type ) ; 

        $query = $this->db->get($this->point_table) ; 

        return $query->result() ; 
    }
}
