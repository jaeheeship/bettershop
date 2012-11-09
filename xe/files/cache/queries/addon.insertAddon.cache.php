<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "addon.insertAddon";
$output->action = "insert";
$output->column_type["addon"] = "varchar";
$output->column_type["is_used"] = "char";
$output->column_type["is_used_m"] = "char";
$output->column_type["extra_vars"] = "text";
$output->column_type["regdate"] = "date";
$output->tables = array( "addons"=>"addons", );
$output->_tables = array( "addons"=>"addons", );
$output->columns = array ( array("name"=>"addon","alias"=>"","value"=>$args->addon),
array("name"=>"is_used","alias"=>"","value"=>$args->is_used?$args->is_used:"N"),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
 );
return $output; ?>