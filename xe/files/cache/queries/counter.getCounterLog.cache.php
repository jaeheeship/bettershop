<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "counter.getCounterLog";
$output->action = "select";
if(is_object($args->site_srl)){ $args->site_srl = array_values(get_method_vars($args->site_srl)); }
if(is_array($args->site_srl) && count($args->site_srl)==0){ unset($args->site_srl); };
if(is_object($args->ipaddress)){ $args->ipaddress = array_values(get_method_vars($args->ipaddress)); }
if(is_array($args->ipaddress) && count($args->ipaddress)==0){ unset($args->ipaddress); };
if(is_object($args->regdate)){ $args->regdate = array_values(get_method_vars($args->regdate)); }
if(is_array($args->regdate) && count($args->regdate)==0){ unset($args->regdate); };
if(!isset($args->site_srl)) $args->site_srl = "0";
if(!isset($args->regdate)) return new Object(-1, sprintf($lang->filter->isnull, $lang->regdate?$lang->regdate:'regdate'));
$output->column_type["site_srl"] = "number";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["regdate"] = "date";
$output->column_type["user_agent"] = "varchar";
$output->tables = array( "counter_log"=>"counter_log", );
$output->_tables = array( "counter_log"=>"counter_log", );
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"site_srl", "value"=>$args->site_srl?$args->site_srl:"0","pipe"=>"and","operation"=>"equal",),
array("column"=>"ipaddress", "value"=>$args->ipaddress,"pipe"=>"and","operation"=>"equal",),
array("column"=>"regdate", "value"=>$args->regdate,"pipe"=>"and","operation"=>"like_prefix",),
)),
 );
return $output; ?>