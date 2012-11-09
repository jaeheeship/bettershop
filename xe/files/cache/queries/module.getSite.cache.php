<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getSite";
$output->action = "select";
if(is_object($args->site_srl)){ $args->site_srl = array_values(get_method_vars($args->site_srl)); }
if(is_array($args->site_srl) && count($args->site_srl)==0){ unset($args->site_srl); };
if(!isset($args->site_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->site_srl?$lang->site_srl:'site_srl'));
$output->column_type["site_srl"] = "number";
$output->column_type["index_module_srl"] = "number";
$output->column_type["domain"] = "varchar";
$output->column_type["default_language"] = "varchar";
$output->column_type["regdate"] = "date";
$output->tables = array( "sites"=>"sites", );
$output->_tables = array( "sites"=>"sites", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"site_srl", "value"=>$args->site_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>