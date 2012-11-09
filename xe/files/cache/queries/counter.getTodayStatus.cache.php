<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "counter.getTodayStatus";
$output->action = "select";
if(is_object($args->regdate)){ $args->regdate = array_values(get_method_vars($args->regdate)); }
if(is_array($args->regdate) && count($args->regdate)==0){ unset($args->regdate); };
if(!isset($args->regdate)) return new Object(-1, sprintf($lang->filter->isnull, $lang->regdate?$lang->regdate:'regdate'));
$output->column_type["regdate"] = "number";
$output->column_type["unique_visitor"] = "number";
$output->column_type["pageview"] = "number";
$output->tables = array( "counter_status"=>"counter_status", );
$output->_tables = array( "counter_status"=>"counter_status", );
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"regdate", "value"=>$args->regdate,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>