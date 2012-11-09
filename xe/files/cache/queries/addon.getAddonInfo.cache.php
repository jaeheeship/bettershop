<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "addon.getAddonInfo";
$output->action = "select";
if(is_object($args->addon)){ $args->addon = array_values(get_method_vars($args->addon)); }
if(is_array($args->addon) && count($args->addon)==0){ unset($args->addon); };
if(!isset($args->addon)) return new Object(-1, sprintf($lang->filter->isnull, $lang->addon?$lang->addon:'addon'));
$output->column_type["addon"] = "varchar";
$output->column_type["is_used"] = "char";
$output->column_type["is_used_m"] = "char";
$output->column_type["extra_vars"] = "text";
$output->column_type["regdate"] = "date";
$output->tables = array( "addons"=>"addons", );
$output->_tables = array( "addons"=>"addons", );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"addon", "value"=>$args->addon,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>