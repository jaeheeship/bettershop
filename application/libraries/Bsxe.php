<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require_once('../../xe/config/config.inc.php') ; 
//require_once('../../xe/config/func.inc.php') ; 


define('__ZBXE__', true);
require_once 'xe/config/config.inc.php';
//require_once '/xe/config/func.inc.php';

$ctx = &Context::getInstance() ; 
$ctx->init() ; 

class Bsxe { 

    function __construct(){

    } 

    public function login($user_id,$password,$remember=false){
        $ci = &get_instance() ; 

        $ci->load->library('tank_auth') ; 

        $is_success = $ci->tank_auth->login($user_id,$password,$remember,false,true) ;

        if($is_success){
            $oMemberController = &getController('member') ; 
            $output = $oMemberController->doLogin($user_id,$password ) ; 
        }

        $logged_info = Context::get('logged_info') ; 

        $data = array(
            'logged_info' => $logged_info ,
            'bs_user_id' => $ci->tank_auth->get_user_id() 
        ) ; 

        $this->setLoggedInfo($data) ; 

        return $is_success ; 
    }

    public function getLoggedInfo(){
        $ci = &get_instance() ; 
        return $ci->session->userdata( 'logged_info' ); 
    }

    public function setLoggedInfo($logged_info){ 
        $ci = &get_instance() ; 
        $ci->session->set_userdata( 'logged_info' , $logged_info ) ; 
    }
} 
