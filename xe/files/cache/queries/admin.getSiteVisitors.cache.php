<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getSiteVisitors";
$output->action = "select";
if(is_object($args->start_date)){ $args->start_date = array_values(get_method_vars($args->start_date)); }
if(is_array($args->start_date) && count($args->start_date)==0){ unset($args->start_date); };
if(is_object($args->end_date)){ $args->end_date = array_values(get_method_vars($args->end_date)); }
if(is_array($args->end_date) && count($args->end_date)==0){ unset($args->end_date); };
if(!isset($args->start_date)) return new Object(-1, sprintf($lang->filter->isnull, $lang->start_date?$lang->start_date:'start_date'));
if(!isset($args->end_date)) return new Object(-1, sprintf($lang->filter->isnull, $lang->end_date?$lang->end_date:'end_date'));
$output->column_type["site_srl"] = "number";
$output->column_type["regdate"] = "number";
$output->column_type["unique_visitor"] = "number";
$output->column_type["pageview"] = "number";
$output->tables = array( "counter_site_status"=>"counter_site_status", );
$output->_tables = array( "counter_site_status"=>"counter_site_status", );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"regdate", "value"=>$args->start_date,"pipe"=>"and","operation"=>"more",),
array("column"=>"regdate", "value"=>$args->end_date,"pipe"=>"and","operation"=>"less",),
)),
 );
return $output; ?>