<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "bodex.getCommentList";
$output->action = "select";
if(is_object($args->document_srl)){ $args->document_srl = array_values(get_method_vars($args->document_srl)); }
if(is_array($args->document_srl) && count($args->document_srl)==0){ unset($args->document_srl); };
if(is_object($args->best_secret)){ $args->best_secret = array_values(get_method_vars($args->best_secret)); }
if(is_array($args->best_secret) && count($args->best_secret)==0){ unset($args->best_secret); };
if(is_object($args->best_regdate)){ $args->best_regdate = array_values(get_method_vars($args->best_regdate)); }
if(is_array($args->best_regdate) && count($args->best_regdate)==0){ unset($args->best_regdate); };
if(is_object($args->best_voted_count)){ $args->best_voted_count = array_values(get_method_vars($args->best_voted_count)); }
if(is_array($args->best_voted_count) && count($args->best_voted_count)==0){ unset($args->best_voted_count); };
if(isset($args->document_srl)) { unset($_output); $_output = $this->checkFilter("document_srl",$args->document_srl,"number"); if(!$_output->toBool()) return $_output; } 
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
$output->tables = array( "comments"=>"comments", );
$output->_tables = array( "comments"=>"comments", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"document_srl", "value"=>$args->document_srl,"pipe"=>"","operation"=>"equal",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"is_secret", "value"=>$args->best_secret,"pipe"=>"and","operation"=>"equal",),
array("column"=>"regdate", "value"=>$args->best_regdate,"pipe"=>"and","operation"=>"more",),
array("column"=>"voted_count", "value"=>$args->best_voted_count,"pipe"=>"and","operation"=>"more",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"list_order",in_array($args->order_type,array("asc","desc"))?$args->order_type:("order_type"?"order_type":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"50");
$output->page_count = array("var"=>"page_count", "value"=>$args->page_count?$args->page_count:"50");
$output->page = array("var"=>"page", "value"=>$args->page?$args->page:"");
return $output; ?>