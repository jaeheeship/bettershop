<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getTrigger";
$output->action = "select";
if(is_object($args->trigger_name)){ $args->trigger_name = array_values(get_method_vars($args->trigger_name)); }
if(is_array($args->trigger_name) && count($args->trigger_name)==0){ unset($args->trigger_name); };
if(is_object($args->module)){ $args->module = array_values(get_method_vars($args->module)); }
if(is_array($args->module) && count($args->module)==0){ unset($args->module); };
if(is_object($args->type)){ $args->type = array_values(get_method_vars($args->type)); }
if(is_array($args->type) && count($args->type)==0){ unset($args->type); };
if(is_object($args->called_method)){ $args->called_method = array_values(get_method_vars($args->called_method)); }
if(is_array($args->called_method) && count($args->called_method)==0){ unset($args->called_method); };
if(is_object($args->called_position)){ $args->called_position = array_values(get_method_vars($args->called_position)); }
if(is_array($args->called_position) && count($args->called_position)==0){ unset($args->called_position); };
$output->column_type["trigger_name"] = "varchar";
$output->column_type["called_position"] = "varchar";
$output->column_type["module"] = "varchar";
$output->column_type["type"] = "varchar";
$output->column_type["called_method"] = "varchar";
$output->tables = array( "module_trigger"=>"module_trigger", );
$output->_tables = array( "module_trigger"=>"module_trigger", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"trigger_name", "value"=>$args->trigger_name,"pipe"=>"","operation"=>"equal",),
array("column"=>"module", "value"=>$args->module,"pipe"=>"and","operation"=>"equal",),
array("column"=>"type", "value"=>$args->type,"pipe"=>"and","operation"=>"equal",),
array("column"=>"called_method", "value"=>$args->called_method,"pipe"=>"and","operation"=>"equal",),
array("column"=>"called_position", "value"=>$args->called_position,"pipe"=>"and","operation"=>"equal",),
)),
 );
return $output; ?>