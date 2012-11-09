<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "addon.getAddons";
$output->action = "select";
$output->column_type["addon"] = "varchar";
$output->column_type["is_used"] = "char";
$output->column_type["is_used_m"] = "char";
$output->column_type["extra_vars"] = "text";
$output->column_type["regdate"] = "date";
$output->tables = array( "addons"=>"addons", );
$output->_tables = array( "addons"=>"addons", );
$output->order = array(array($args->list_order?$args->list_order:"addon",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
return $output; ?>