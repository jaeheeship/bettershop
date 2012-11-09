<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Customer extends CI_Controller { 
    function __construct(){
        parent::__construct() ; 
        $this->load->library('aglayout') ; 
    } 
    
    public function purchaseHistory(){

        $this->aglayout->layout('shopmgr/layout'); 
        $this->aglayout->moduleViewPath('shopmgr/customer/') ; 
        $this->aglayout->add('header') ; 
        $this->aglayout->add('purchaseHistory') ; 
        $this->aglayout->add('footer') ; 

        $this->aglayout->show() ; 
    } 

    public function getPurchaseHistory($page=1){
        $this->load->model('bettershop/point_model') ;  
        $logged_info = $this->bsxe->getLoggedInfo() ; 
        $result = $this->point_model->getPointLogList('qr_scan',$logged_info['shop']->shop_code ,$page) ; 
        //$result = $this->point_model->getPointLogList('qr_scan',14 ,$page) ; 
        $response =array() ; 
        $response['items'] = $result ; 
        echo json_encode($response) ; 
    }

    public function getCommentList($page=1){
        $logged_info = $this->bsxe->getLoggedInfo() ; 
        $shop = $logged_info['shop'] ; 

        $document_srl = $shop->document_srl ; 

        $comment_list = array() ; 
        
        $items = array() ; 

        if($document_srl) { 
            $oDocumentModel = &getModel('document') ; 
            $oDocument = $oDocumentModel->getDocument($document_srl) ; 
            $comment_list = $oDocument->getComments() ; 

            foreach($comment_list as $key => $row){
                $content = $row->getContent(false) ; 
                $obj = new stdClass ; 
                $obj->content = $row->getContent(false) ; 
                $obj->username = $row->getUserName() ; 
                $obj->thumbnail = $row->getThumbnail() ; 
                $items[] = $obj ; 
            }
        }

        $response = array() ; 
        $response['items'] = $items ; 

        echo json_encode($response) ; 
    }

    public function comment(){

        $this->aglayout->layout('shopmgr/layout'); 
        $this->aglayout->moduleViewPath('shopmgr/customer/') ; 
        $this->aglayout->add('header') ; 
        $this->aglayout->add('comment') ; 
        $this->aglayout->add('footer') ; 

        $data = array() ; 

        $this->aglayout->show($data) ; 
    }
}


/* End of file Customer.php */
/* Location: ./application/controllers/shopmgr/customer.php */
