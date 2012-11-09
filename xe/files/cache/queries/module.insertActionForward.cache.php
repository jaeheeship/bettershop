<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.insertActionForward";
$output->action = "insert";
$output->column_type["act"] = "varchar";
$output->column_type["module"] = "varchar";
$output->column_type["type"] = "varchar";
$output->tables = array( "action_forward"=>"action_forward", );
$output->_tables = array( "action_forward"=>"action_forward", );
$output->columns = array ( array("name"=>"act","alias"=>"","value"=>$args->act),
array("name"=>"module","alias"=>"","value"=>$args->module),
array("name"=>"type","alias"=>"","value"=>$args->type),
 );
return $output; ?>