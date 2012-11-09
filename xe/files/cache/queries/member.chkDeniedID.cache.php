<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.chkDeniedID";
$output->action = "select";
if(is_object($args->user_id)){ $args->user_id = array_values(get_method_vars($args->user_id)); }
if(is_array($args->user_id) && count($args->user_id)==0){ unset($args->user_id); };
$output->column_type["user_id"] = "varchar";
$output->column_type["regdate"] = "date";
$output->column_type["description"] = "text";
$output->column_type["list_order"] = "number";
$output->tables = array( "member_denied_user_id"=>"member_denied_user_id", );
$output->_tables = array( "member_denied_user_id"=>"member_denied_user_id", );
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"user_id", "value"=>$args->user_id,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>