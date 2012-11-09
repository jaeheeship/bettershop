<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Statistics extends CI_Controller { 
    function __construct(){
        parent::__construct() ; 
        $this->load->library('aglayout') ; 
    } 

    public function info(){
        $this->aglayout->layout('shopmgr/layout'); 
        $this->aglayout->moduleViewPath('shopmgr/statistics/') ; 
        $this->aglayout->add('header') ; 
        $this->aglayout->add('statistics') ; 
        $this->aglayout->add('footer') ; 
        
        /*$this->load->model('bettershop/coupon_model') ; 
        $page = 1 ; 
        $list_count = 100 ; 
        $coupon_list = $this->coupon_model->getCouponList('0001',$page,$list_count) ; 
        
        $data = array() ; 
        $data['coupon_list'] = $coupon_list ; */
        $this->aglayout->show() ; 
    } 
} 
