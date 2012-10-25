<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function useq(){
    $ci = &get_instance() ; 
    $ci->db->insert('seq',array('seq'=>0)); 
    $id = $ci->db->insert_id() ; 

    if($id % 10000 == 0) {
        $ci->db->where('seq < ',$id) ; 
        $ci->db->delete('seq') ;   
    }

    return $id ; 
}

?>
