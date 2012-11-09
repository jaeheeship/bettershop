<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "document.getNoticeList";
$output->action = "select";
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(is_object($args->category_srl)){ $args->category_srl = array_values(get_method_vars($args->category_srl)); }
if(is_array($args->category_srl) && count($args->category_srl)==0){ unset($args->category_srl); };
if(isset($args->module_srl)) { unset($_output); $_output = $this->checkFilter("module_srl",$args->module_srl,"number"); if(!$_output->toBool()) return $_output; } 
$output->column_type["document_srl"] = "number";
$output->column_type["module_srl"] = "number";
$output->column_type["category_srl"] = "number";
$output->column_type["lang_code"] = "varchar";
$output->column_type["is_notice"] = "char";
$output->column_type["is_secret"] = "char";
$output->column_type["title"] = "varchar";
$output->column_type["title_bold"] = "char";
$output->column_type["title_color"] = "varchar";
$output->column_type["content"] = "bigtext";
$output->column_type["readed_count"] = "number";
$output->column_type["voted_count"] = "number";
$output->column_type["blamed_count"] = "number";
$output->column_type["comment_count"] = "number";
$output->column_type["trackback_count"] = "number";
$output->column_type["uploaded_count"] = "number";
$output->column_type["password"] = "varchar";
$output->column_type["user_id"] = "varchar";
$output->column_type["user_name"] = "varchar";
$output->column_type["nick_name"] = "varchar";
$output->column_type["member_srl"] = "number";
$output->column_type["email_address"] = "varchar";
$output->column_type["homepage"] = "varchar";
$output->column_type["tags"] = "text";
$output->column_type["extra_vars"] = "text";
$output->column_type["regdate"] = "date";
$output->column_type["last_update"] = "date";
$output->column_type["last_updater"] = "varchar";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["list_order"] = "number";
$output->column_type["update_order"] = "number";
$output->column_type["allow_comment"] = "char";
$output->column_type["lock_comment"] = "char";
$output->column_type["allow_trackback"] = "char";
$output->column_type["notify_message"] = "char";
$output->tables = array( "documents"=>"documents", );
$output->_tables = array( "documents"=>"documents", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"module_srl", "value"=>$args->module_srl,"pipe"=>"","operation"=>"in",),
array("column"=>"is_notice", "value"=>"Y","pipe"=>"and","operation"=>"equal",),
array("column"=>"category_srl", "value"=>$args->category_srl,"pipe"=>"and","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"document_srl",in_array($args->desc,array("asc","desc"))?$args->desc:("desc"?"desc":"asc")),);
return $output; ?>