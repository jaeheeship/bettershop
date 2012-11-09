<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "editor.isComponentInserted";
$output->action = "select";
if(is_object($args->component_name)){ $args->component_name = array_values(get_method_vars($args->component_name)); }
if(is_array($args->component_name) && count($args->component_name)==0){ unset($args->component_name); };
if(!isset($args->component_name)) return new Object(-1, sprintf($lang->filter->isnull, $lang->component_name?$lang->component_name:'component_name'));
$output->column_type["component_name"] = "varchar";
$output->column_type["enabled"] = "char";
$output->column_type["extra_vars"] = "text";
$output->column_type["list_order"] = "number";
$output->tables = array( "editor_components"=>"editor_components", );
$output->_tables = array( "editor_components"=>"editor_components", );
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"component_name", "value"=>$args->component_name,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>