<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getModuleExtraVars";
$output->action = "select";
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(!isset($args->module_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->module_srl?$lang->module_srl:'module_srl'));
$output->column_type["module_srl"] = "number";
$output->column_type["name"] = "varchar";
$output->column_type["value"] = "text";
$output->tables = array( "module_extra_vars"=>"module_extra_vars", );
$output->_tables = array( "module_extra_vars"=>"module_extra_vars", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"module_srl", "value"=>$args->module_srl,"pipe"=>"","operation"=>"in",),
)),
 );
return $output; ?>