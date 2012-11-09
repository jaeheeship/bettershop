<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "counter.insertTodayStatus";
$output->action = "insert";
$output->column_type["regdate"] = "number";
$output->column_type["unique_visitor"] = "number";
$output->column_type["pageview"] = "number";
$output->tables = array( "counter_status"=>"counter_status", );
$output->_tables = array( "counter_status"=>"counter_status", );
$output->columns = array ( array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:"0"),
array("name"=>"unique_visitor","alias"=>"","value"=>"0"),
array("name"=>"pageview","alias"=>"","value"=>"0"),
 );
return $output; ?>