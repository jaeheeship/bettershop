<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "session.getSession";
$output->action = "select";
if(is_object($args->session_key)){ $args->session_key = array_values(get_method_vars($args->session_key)); }
if(is_array($args->session_key) && count($args->session_key)==0){ unset($args->session_key); };
if(!isset($args->session_key)) return new Object(-1, sprintf($lang->filter->isnull, $lang->session_key?$lang->session_key:'session_key'));
$output->column_type["session_key"] = "varchar";
$output->column_type["member_srl"] = "number";
$output->column_type["expired"] = "date";
$output->column_type["val"] = "bigtext";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["last_update"] = "date";
$output->column_type["cur_mid"] = "varchar";
$output->tables = array( "session"=>"session", );
$output->_tables = array( "session"=>"session", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"session_key", "value"=>$args->session_key,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>