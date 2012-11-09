<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getTotalVisitors";
$output->action = "select";
$output->column_type["regdate"] = "number";
$output->column_type["unique_visitor"] = "number";
$output->column_type["pageview"] = "number";
$output->tables = array( "counter_status"=>"counter_status", );
$output->_tables = array( "counter_status"=>"counter_status", );
$output->columns = array ( array("name"=>"sum(unique_visitor)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"regdate", "value"=>"1","pipe"=>"","operation"=>"more",),
)),
 );
return $output; ?>