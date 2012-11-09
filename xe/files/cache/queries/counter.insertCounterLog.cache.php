<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "counter.insertCounterLog";
$output->action = "insert";
$output->column_type["site_srl"] = "number";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["regdate"] = "date";
$output->column_type["user_agent"] = "varchar";
$output->tables = array( "counter_log"=>"counter_log", );
$output->_tables = array( "counter_log"=>"counter_log", );
$output->columns = array ( array("name"=>"site_srl","alias"=>"","value"=>$args->site_srl?$args->site_srl:"0"),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
array("name"=>"ipaddress","alias"=>"","value"=>$args->ipaddress?$args->ipaddress:$_SERVER['REMOTE_ADDR']),
array("name"=>"user_agent","alias"=>"","value"=>$args->user_agent),
 );
return $output; ?>