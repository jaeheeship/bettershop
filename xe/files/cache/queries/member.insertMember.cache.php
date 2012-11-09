<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.insertMember";
$output->action = "insert";
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
$output->columns = array ( array("name"=>"member_srl","alias"=>"","value"=>$args->member_srl),
array("name"=>"user_id","alias"=>"","value"=>$args->user_id),
array("name"=>"email_address","alias"=>"","value"=>$args->email_address),
array("name"=>"password","alias"=>"","value"=>$args->password),
array("name"=>"email_id","alias"=>"","value"=>$args->email_id),
array("name"=>"email_host","alias"=>"","value"=>$args->email_host),
array("name"=>"user_name","alias"=>"","value"=>$args->user_name),
array("name"=>"nick_name","alias"=>"","value"=>$args->nick_name),
array("name"=>"find_account_question","alias"=>"","value"=>$args->find_account_question),
array("name"=>"find_account_answer","alias"=>"","value"=>$args->find_account_answer),
array("name"=>"homepage","alias"=>"","value"=>$args->homepage),
array("name"=>"blog","alias"=>"","value"=>$args->blog),
array("name"=>"birthday","alias"=>"","value"=>$args->birthday),
array("name"=>"allow_mailing","alias"=>"","value"=>$args->allow_mailing?$args->allow_mailing:"Y"),
array("name"=>"allow_message","alias"=>"","value"=>$args->allow_message?$args->allow_message:"Y"),
array("name"=>"denied","alias"=>"","value"=>$args->denied?$args->denied:"N"),
array("name"=>"limit_date","alias"=>"","value"=>$args->limit_date),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
array("name"=>"change_password_date","alias"=>"","value"=>$args->change_password_date?$args->change_password_date:date("YmdHis")),
array("name"=>"last_login","alias"=>"","value"=>$args->last_login?$args->last_login:date("YmdHis")),
array("name"=>"is_admin","alias"=>"","value"=>$args->is_admin?$args->is_admin:"N"),
array("name"=>"description","alias"=>"","value"=>$args->description),
array("name"=>"extra_vars","alias"=>"","value"=>$args->extra_vars),
array("name"=>"list_order","alias"=>"","value"=>$args->list_order),
 );
return $output; ?>