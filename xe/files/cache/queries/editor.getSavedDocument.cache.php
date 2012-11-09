<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "editor.getSavedDocument";
$output->action = "select";
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(is_object($args->member_srl)){ $args->member_srl = array_values(get_method_vars($args->member_srl)); }
if(is_array($args->member_srl) && count($args->member_srl)==0){ unset($args->member_srl); };
if(is_object($args->ipaddress)){ $args->ipaddress = array_values(get_method_vars($args->ipaddress)); }
if(is_array($args->ipaddress) && count($args->ipaddress)==0){ unset($args->ipaddress); };
$output->column_type["member_srl"] = "number";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["module_srl"] = "number";
$output->column_type["document_srl"] = "number";
$output->column_type["title"] = "varchar";
$output->column_type["content"] = "bigtext";
$output->column_type["regdate"] = "date";
$output->tables = array( "editor_autosave"=>"editor_autosave", );
$output->_tables = array( "editor_autosave"=>"editor_autosave", );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"module_srl", "value"=>$args->module_srl,"pipe"=>"","operation"=>"equal",),
array("column"=>"member_srl", "value"=>$args->member_srl,"pipe"=>"and","operation"=>"equal",),
array("column"=>"ipaddress", "value"=>$args->ipaddress,"pipe"=>"and","operation"=>"equal",),
)),
 );
return $output; ?>