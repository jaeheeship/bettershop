<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Coupon_model extends CI_Model { 
    var $coupon_table = 'bs_coupon' ;     
    function __construct() {
		parent::__construct();
        $this->load->database() ; 
    }

    public function getEventList($shop_code,$page=1,$list_count=100){

    }

    public function getCouponList($shop_code,$page=1,$list_count=100){ 
        $this->db->limit($list_count , ($page-1)*$list_count ) ; 
        $this->db->where('shop_code' ,$shop_code ) ; 
        $query = $this->db->get($this->coupon_table) ; 

        return $query->result() ; 
    }

    public function insertCoupon($coupon_data){
        $this->db->insert($this->coupon_table,$coupon_data) ; 
    }

    public function deleteCoupon($coupon_data){

    }

    public function updateCoupon($coupon_data){
        $this->db->where('coupon_srl',$coupon_data->coupon_srl ) ; 
        $this->db->update($this->coupon_table,$coupon_data) ; 
    } 
}
