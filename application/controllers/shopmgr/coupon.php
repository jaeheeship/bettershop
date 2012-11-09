<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Coupon extends CI_Controller { 
    function __construct(){
        parent::__construct() ; 
        $this->load->library('aglayout') ; 
    } 

    public function getUsedCouponHistory(){
        $this->load->model('bettershop/coupon_model') ; 
        $page = 1 ; 
        $list_count = 100 ; 
        $coupon_list = $this->coupon_model->getCouponList(4444,$page,$list_count) ; 
        
        $data = array() ; 
        $data['coupon_list'] = $coupon_list ; 
        //$this->aglayout->show($data) ; 

        $response = array() ; 

        $response['items'] = $coupon_list ; 

        echo json_encode($response) ; 
    }

    public function couponHistory(){

        $this->aglayout->layout('shopmgr/layout'); 
        $this->aglayout->moduleViewPath('shopmgr/coupon/') ; 
        $this->aglayout->add('header') ; 
        $this->aglayout->add('couponHistory') ; 
        $this->aglayout->add('footer') ; 
        
        $this->load->model('bettershop/coupon_model') ; 

        $logged_info = $this->bsxe->getLoggedInfo() ; 

        $this->load->model('tank_auth/users') ; 

        $shop = $this->users->getShop($logged_info['bs_user_id']) ; 
        $page = 1 ; 
        $list_count = 100 ; 
        $coupon_list = $this->coupon_model->getCouponList($shop->shop_code,$page,$list_count) ; 
        
        $data = array() ; 
        $data['coupon_list'] = $coupon_list ; 
        $this->aglayout->show($data) ; 
    } 

    public function batchCoupon(){
        $data = $this->input->get('data') ; 
        $this->load->model('bettershop/coupon_model') ; 

        $item = $data ; 
        
        if($item['command'] == 'delete'){
            $coupon_data->coupon_srl = getNextSequence() ; 
            $coupon_data->valid = 'no' ; 

            $this->coupon_model->updateCoupon($coupon_data) ; 

            print_r($coupon_data) ; 

        }

        if($item['command'] == 'insert'){
            $coupon_data = new stdClass ; 
            $coupon_data->title = $item['title'] ; 
            $coupon_data->type = 'coupon' ; 
            $coupon_data->point = $item['point'] ; 
            $coupon_data->coupon_srl = getNextSequence() ; 
            $coupon_data->write_time = date("Y-m-d H:i:s") ; 
            $coupon_data->shop_code = 4444; 
            $coupon_data->valid = 'yes' ; 

            $this->coupon_model->insertCoupon($coupon_data) ; 

            print_r(json_encode($coupon_data)) ; 
        } 
    } 
}


