<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getModuleExtend";
$output->action = "select";
if(is_object($args->parent_module)){ $args->parent_module = array_values(get_method_vars($args->parent_module)); }
if(is_array($args->parent_module) && count($args->parent_module)==0){ unset($args->parent_module); };
if(is_object($args->extend_module)){ $args->extend_module = array_values(get_method_vars($args->extend_module)); }
if(is_array($args->extend_module) && count($args->extend_module)==0){ unset($args->extend_module); };
if(is_object($args->type)){ $args->type = array_values(get_method_vars($args->type)); }
if(is_array($args->type) && count($args->type)==0){ unset($args->type); };
if(is_object($args->kind)){ $args->kind = array_values(get_method_vars($args->kind)); }
if(is_array($args->kind) && count($args->kind)==0){ unset($args->kind); };
$output->column_type["parent_module"] = "varchar";
$output->column_type["extend_module"] = "varchar";
$output->column_type["type"] = "varchar";
$output->column_type["kind"] = "varchar";
$output->tables = array( "module_extend"=>"module_extend", );
$output->_tables = array( "module_extend"=>"module_extend", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"parent_module", "value"=>$args->parent_module,"pipe"=>"","operation"=>"equal",),
array("column"=>"extend_module", "value"=>$args->extend_module,"pipe"=>"and","operation"=>"equal",),
array("column"=>"type", "value"=>$args->type,"pipe"=>"and","operation"=>"equal",),
array("column"=>"kind", "value"=>$args->kind,"pipe"=>"and","operation"=>"equal",),
)),
 );
return $output; ?>