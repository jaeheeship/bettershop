<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.getMemberSrl";
$output->action = "select";
if(is_object($args->user_id)){ $args->user_id = array_values(get_method_vars($args->user_id)); }
if(is_array($args->user_id) && count($args->user_id)==0){ unset($args->user_id); };
if(is_object($args->email_address)){ $args->email_address = array_values(get_method_vars($args->email_address)); }
if(is_array($args->email_address) && count($args->email_address)==0){ unset($args->email_address); };
if(is_object($args->nick_name)){ $args->nick_name = array_values(get_method_vars($args->nick_name)); }
if(is_array($args->nick_name) && count($args->nick_name)==0){ unset($args->nick_name); };
$output->column_type["member_srl"] = "number";
$output->column_type["user_id"] = "varchar";
$output->column_type["email_address"] = "varchar";
$output->column_type["password"] = "varchar";
$output->column_type["email_id"] = "varchar";
$output->column_type["email_host"] = "varchar";
$output->column_type["user_name"] = "varchar";
$output->column_type["nick_name"] = "varchar";
$output->column_type["find_account_question"] = "number";
$output->column_type["find_account_answer"] = "varchar";
$output->column_type["homepage"] = "varchar";
$output->column_type["blog"] = "varchar";
$output->column_type["birthday"] = "char";
$output->column_type["allow_mailing"] = "char";
$output->column_type["allow_message"] = "char";
$output->column_type["denied"] = "char";
$output->column_type["limit_date"] = "date";
$output->column_type["regdate"] = "date";
$output->column_type["last_login"] = "date";
$output->column_type["change_password_date"] = "date";
$output->column_type["is_admin"] = "char";
$output->column_type["description"] = "text";
$output->column_type["extra_vars"] = "text";
$output->column_type["list_order"] = "number";
$output->tables = array( "member"=>"member", );
$output->_tables = array( "member"=>"member", );
$output->columns = array ( array("name"=>"member_srl","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"user_id", "value"=>$args->user_id,"pipe"=>"and","operation"=>"equal",),
array("column"=>"email_address", "value"=>$args->email_address,"pipe"=>"and","operation"=>"equal",),
array("column"=>"nick_name", "value"=>$args->nick_name,"pipe"=>"and","operation"=>"equal",),
)),
 );
return $output; ?>