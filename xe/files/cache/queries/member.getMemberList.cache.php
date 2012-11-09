<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.getMemberList";
$output->action = "select";
if(is_object($args->is_admin)){ $args->is_admin = array_values(get_method_vars($args->is_admin)); }
if(is_array($args->is_admin) && count($args->is_admin)==0){ unset($args->is_admin); };
if(is_object($args->is_denied)){ $args->is_denied = array_values(get_method_vars($args->is_denied)); }
if(is_array($args->is_denied) && count($args->is_denied)==0){ unset($args->is_denied); };
if(is_object($args->s_user_id)){ $args->s_user_id = array_values(get_method_vars($args->s_user_id)); }
if(is_array($args->s_user_id) && count($args->s_user_id)==0){ unset($args->s_user_id); };
if(is_object($args->s_user_name)){ $args->s_user_name = array_values(get_method_vars($args->s_user_name)); }
if(is_array($args->s_user_name) && count($args->s_user_name)==0){ unset($args->s_user_name); };
if(is_object($args->s_nick_name)){ $args->s_nick_name = array_values(get_method_vars($args->s_nick_name)); }
if(is_array($args->s_nick_name) && count($args->s_nick_name)==0){ unset($args->s_nick_name); };
if(is_object($args->html_nick_name)){ $args->html_nick_name = array_values(get_method_vars($args->html_nick_name)); }
if(is_array($args->html_nick_name) && count($args->html_nick_name)==0){ unset($args->html_nick_name); };
if(is_object($args->s_email_address)){ $args->s_email_address = array_values(get_method_vars($args->s_email_address)); }
if(is_array($args->s_email_address) && count($args->s_email_address)==0){ unset($args->s_email_address); };
if(is_object($args->s_extra_vars)){ $args->s_extra_vars = array_values(get_method_vars($args->s_extra_vars)); }
if(is_array($args->s_extra_vars) && count($args->s_extra_vars)==0){ unset($args->s_extra_vars); };
if(is_object($args->s_regdate)){ $args->s_regdate = array_values(get_method_vars($args->s_regdate)); }
if(is_array($args->s_regdate) && count($args->s_regdate)==0){ unset($args->s_regdate); };
if(is_object($args->s_last_login)){ $args->s_last_login = array_values(get_method_vars($args->s_last_login)); }
if(is_array($args->s_last_login) && count($args->s_last_login)==0){ unset($args->s_last_login); };
if(is_object($args->s_regdate_more)){ $args->s_regdate_more = array_values(get_method_vars($args->s_regdate_more)); }
if(is_array($args->s_regdate_more) && count($args->s_regdate_more)==0){ unset($args->s_regdate_more); };
if(is_object($args->s_regdate_less)){ $args->s_regdate_less = array_values(get_method_vars($args->s_regdate_less)); }
if(is_array($args->s_regdate_less) && count($args->s_regdate_less)==0){ unset($args->s_regdate_less); };
if(is_object($args->s_last_login_more)){ $args->s_last_login_more = array_values(get_method_vars($args->s_last_login_more)); }
if(is_array($args->s_last_login_more) && count($args->s_last_login_more)==0){ unset($args->s_last_login_more); };
if(is_object($args->s_last_login_less)){ $args->s_last_login_less = array_values(get_method_vars($args->s_last_login_less)); }
if(is_array($args->s_last_login_less) && count($args->s_last_login_less)==0){ unset($args->s_last_login_less); };
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
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"is_admin", "value"=>$args->is_admin,"pipe"=>"","operation"=>"equal",),
array("column"=>"denied", "value"=>$args->is_denied,"pipe"=>"and","operation"=>"equal",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"user_id", "value"=>$args->s_user_id,"pipe"=>"","operation"=>"like",),
array("column"=>"user_name", "value"=>$args->s_user_name,"pipe"=>"or","operation"=>"like",),
array("column"=>"nick_name", "value"=>$args->s_nick_name,"pipe"=>"or","operation"=>"like",),
array("column"=>"nick_name", "value"=>$args->html_nick_name,"pipe"=>"or","operation"=>"like",),
array("column"=>"email_address", "value"=>$args->s_email_address,"pipe"=>"or","operation"=>"like",),
array("column"=>"extra_vars", "value"=>$args->s_extra_vars,"pipe"=>"or","operation"=>"like",),
array("column"=>"regdate", "value"=>$args->s_regdate,"pipe"=>"or","operation"=>"like_prefix",),
array("column"=>"last_login", "value"=>$args->s_last_login,"pipe"=>"or","operation"=>"like_prefix",),
array("column"=>"member.regdate", "value"=>$args->s_regdate_more,"pipe"=>"or","operation"=>"more",),
array("column"=>"member.regdate", "value"=>$args->s_regdate_less,"pipe"=>"or","operation"=>"less",),
array("column"=>"member.last_login", "value"=>$args->s_last_login_more,"pipe"=>"or","operation"=>"more",),
array("column"=>"member.last_login", "value"=>$args->s_last_login_less,"pipe"=>"or","operation"=>"less",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"list_order",in_array($args->sort_order,array("asc","desc"))?$args->sort_order:("sort_order"?"sort_order":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"20");
$output->page_count = array("var"=>"page_count", "value"=>$args->page_count?$args->page_count:"20");
$output->page = array("var"=>"page", "value"=>$args->page?$args->page:"");
return $output; ?>