<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getMemberStatus";
$output->action = "select";
if(is_object($args->date)){ $args->date = array_values(get_method_vars($args->date)); }
if(is_array($args->date) && count($args->date)==0){ unset($args->date); };
if(!isset($args->date)) return new Object(-1, sprintf($lang->filter->isnull, $lang->date?$lang->date:'date'));
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
$output->columns = array ( array("name"=>"substr(regdate,1,8)","alias"=>"date"),
array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"regdate", "value"=>$args->date,"pipe"=>"","operation"=>"more",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"substr(regdate,1,8)",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"2");
$output->groups = array("substr(regdate,1,8)");
return $output; ?>