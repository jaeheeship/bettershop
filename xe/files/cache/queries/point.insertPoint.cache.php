<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "point.insertPoint";
$output->action = "insert";
$output->column_type["member_srl"] = "number";
$output->column_type["point"] = "number";
$output->tables = array( "point"=>"point", );
$output->_tables = array( "point"=>"point", );
$output->columns = array ( array("name"=>"member_srl","alias"=>"","value"=>$args->member_srl),
array("name"=>"point","alias"=>"","value"=>$args->point?$args->point:"0"),
 );
return $output; ?>