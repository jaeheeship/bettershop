<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.insertTrigger";
$output->action = "insert";
$output->column_type["trigger_name"] = "varchar";
$output->column_type["called_position"] = "varchar";
$output->column_type["module"] = "varchar";
$output->column_type["type"] = "varchar";
$output->column_type["called_method"] = "varchar";
$output->tables = array( "module_trigger"=>"module_trigger", );
$output->_tables = array( "module_trigger"=>"module_trigger", );
$output->columns = array ( array("name"=>"trigger_name","alias"=>"","value"=>$args->trigger_name),
array("name"=>"module","alias"=>"","value"=>$args->module),
array("name"=>"type","alias"=>"","value"=>$args->type),
array("name"=>"called_method","alias"=>"","value"=>$args->called_method),
array("name"=>"called_position","alias"=>"","value"=>$args->called_position),
 );
return $output; ?>