<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getTotalSiteVisitors";
$output->action = "select";
$output->column_type["site_srl"] = "number";
$output->column_type["regdate"] = "number";
$output->column_type["unique_visitor"] = "number";
$output->column_type["pageview"] = "number";
$output->tables = array( "counter_site_status"=>"counter_site_status", );
$output->_tables = array( "counter_site_status"=>"counter_site_status", );
$output->columns = array ( array("name"=>"sum(unique_visitor)","alias"=>"count"),
 );
return $output; ?>