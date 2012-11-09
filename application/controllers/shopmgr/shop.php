<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Shop extends CI_Controller {

    function __construct(){

    }

    public function getShopInfo($shop_srl){

    }

    public function shopInfo(){
        parent::__construct() ; 
        $this->load->library('aglayout') ;

        $this->aglayout->layout('shopmgr/layout'); 
        $this->aglayout->moduleViewPath('shopmgr/shop/') ; 
        $this->aglayout->add('header') ; 
        $this->aglayout->add('shopInfo') ; 
        $this->aglayout->add('footer') ; 

        $logged_info = $this->bsxe->getLoggedInfo() ;  

        $this->load->model('tank_auth/users') ; 
        $shop = $this->users->getShop($logged_info['bs_user_id']) ; 

        $document_model = &getModel('document') ; 
        $shopInfo = $document_model->getDocument($shop->document_srl) ; 

        $data = array() ; 
        $data['shopInfo'] = $shopInfo ; 

        $this->aglayout->show($data) ; 
    }
}
