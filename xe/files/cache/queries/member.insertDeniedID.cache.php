<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.insertDeniedID";
$output->action = "insert";
$output->column_type["user_id"] = "varchar";
$output->column_type["regdate"] = "date";
$output->column_type["description"] = "text";
$output->column_type["list_order"] = "number";
$output->tables = array( "member_denied_user_id"=>"member_denied_user_id", );
$output->_tables = array( "member_denied_user_id"=>"member_denied_user_id", );
$output->columns = array ( array("name"=>"user_id","alias"=>"","value"=>$args->user_id),
array("name"=>"regdate","alias"=>"","value"=>date("YmdHis")),
array("name"=>"description","alias"=>"","value"=>$args->description?$args->description:""),
array("name"=>"list_order","alias"=>"","value"=>$args->list_order),
 );
return $output; ?>