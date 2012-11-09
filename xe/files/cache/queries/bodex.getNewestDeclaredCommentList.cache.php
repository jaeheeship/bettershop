<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "bodex.getNewestDeclaredCommentList";
$output->action = "select";
$output->column_type["comment_srl"] = "number";
$output->column_type["member_srl"] = "number";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["regdate"] = "date";
$output->column_type["comment_srl"] = "number";
$output->column_type["declared_count"] = "number";
$output->column_type["comment_srl"] = "number";
$output->column_type["module_srl"] = "number";
$output->column_type["document_srl"] = "number";
$output->column_type["parent_srl"] = "number";
$output->column_type["is_secret"] = "char";
$output->column_type["content"] = "bigtext";
$output->column_type["voted_count"] = "number";
$output->column_type["blamed_count"] = "number";
$output->column_type["notify_message"] = "char";
$output->column_type["password"] = "varchar";
$output->column_type["user_id"] = "varchar";
$output->column_type["user_name"] = "varchar";
$output->column_type["nick_name"] = "varchar";
$output->column_type["member_srl"] = "number";
$output->column_type["email_address"] = "varchar";
$output->column_type["homepage"] = "varchar";
$output->column_type["uploaded_count"] = "number";
$output->column_type["regdate"] = "date";
$output->column_type["last_update"] = "date";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["list_order"] = "number";
$output->tables = array( "declared_log"=>"comment_declared_log","declared"=>"comment_declared","comments"=>"comments", );
$output->_tables = array( "declared_log"=>"comment_declared_log","declared"=>"comment_declared","comments"=>"comments", );
$output->columns = array ( array("name"=>"declared_log.*","alias"=>""),
array("name"=>"declared.declared_count","alias"=>"declared_count"),
array("name"=>"comments.content","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"comments.comment_srl", "value"=>"declared_log.comment_srl","pipe"=>"","operation"=>"equal",),
array("column"=>"declared.comment_srl", "value"=>"declared_log.comment_srl","pipe"=>"and","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"regdate",in_array($args->order_type,array("asc","desc"))?$args->order_type:("order_type"?"order_type":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"10");
return $output; ?>