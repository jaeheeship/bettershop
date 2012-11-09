<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.insertModuleConfig";
$output->action = "insert";
$output->column_type["module"] = "varchar";
$output->column_type["config"] = "text";
$output->column_type["regdate"] = "date";
$output->tables = array( "module_config"=>"module_config", );
$output->_tables = array( "module_config"=>"module_config", );
$output->columns = array ( array("name"=>"module","alias"=>"","value"=>$args->module),
array("name"=>"config","alias"=>"","value"=>$args->config),
array("name"=>"regdate","alias"=>"","value"=>date("YmdHis")),
 );
return $output; ?>