<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "bodex.getNotAdoptedPost";
$output->action = "select";
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(is_object($args->member_srl)){ $args->member_srl = array_values(get_method_vars($args->member_srl)); }
if(is_array($args->member_srl) && count($args->member_srl)==0){ unset($args->member_srl); };
if(is_object($args->minus_member_srl)){ $args->minus_member_srl = array_values(get_method_vars($args->minus_member_srl)); }
if(is_array($args->minus_member_srl) && count($args->minus_member_srl)==0){ unset($args->minus_member_srl); };
if(is_object($args->member_srl)){ $args->member_srl = array_values(get_method_vars($args->member_srl)); }
if(is_array($args->member_srl) && count($args->member_srl)==0){ unset($args->member_srl); };
if(is_object($args->minus_member_srl)){ $args->minus_member_srl = array_values(get_method_vars($args->minus_member_srl)); }
if(is_array($args->minus_member_srl) && count($args->minus_member_srl)==0){ unset($args->minus_member_srl); };
if(isset($args->module_srl)) { unset($_output); $_output = $this->checkFilter("module_srl",$args->module_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->module_srl)) { unset($_output); $_output = $this->checkFilter("module_srl",$args->module_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->member_srl)) { unset($_output); $_output = $this->checkFilter("member_srl",$args->member_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->minus_member_srl)) { unset($_output); $_output = $this->checkFilter("minus_member_srl",$args->minus_member_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->member_srl)) { unset($_output); $_output = $this->checkFilter("member_srl",$args->member_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->minus_member_srl)) { unset($_output); $_output = $this->checkFilter("minus_member_srl",$args->minus_member_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->module_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->module_srl?$lang->module_srl:'module_srl'));
if(!isset($args->module_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->module_srl?$lang->module_srl:'module_srl'));
if(!isset($args->member_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->member_srl?$lang->member_srl:'member_srl'));
if(!isset($args->minus_member_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->minus_member_srl?$lang->minus_member_srl:'minus_member_srl'));
if(!isset($args->member_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->member_srl?$lang->member_srl:'member_srl'));
if(!isset($args->minus_member_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->minus_member_srl?$lang->minus_member_srl:'minus_member_srl'));
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
$output->tables = array( "documents"=>"documents","comments"=>"comments", );
$output->_tables = array( "documents"=>"documents","comments"=>"comments", );
$output->columns = array ( array("name"=>"distinct(documents.document_srl)","alias"=>"document_srl"),
array("name"=>"documents.title","alias"=>"title"),
array("name"=>"documents.comment_count","alias"=>"comment_count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"documents.module_srl", "value"=>$args->module_srl,"pipe"=>"","operation"=>"equal",),
array("column"=>"comments.module_srl", "value"=>$args->module_srl,"pipe"=>"and","operation"=>"equal",),
array("column"=>"documents.document_srl", "value"=>"comments.document_srl","pipe"=>"and","operation"=>"equal",),
array("column"=>"documents.comment_count", "value"=>"0","pipe"=>"and","operation"=>"excess",),
array("column"=>"documents.reward_point", "value"=>"0","pipe"=>"and","operation"=>"excess",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"documents.reward_srl", "value"=>"0","pipe"=>"or","operation"=>"equal",),
array("column"=>"documents.reward_srl", "value"=>"0","pipe"=>"or","operation"=>"null",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"documents.member_srl", "value"=>$args->member_srl,"pipe"=>"or","operation"=>"equal",),
array("column"=>"documents.member_srl", "value"=>$args->minus_member_srl,"pipe"=>"or","operation"=>"equal",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"comments.member_srl", "value"=>$args->member_srl,"pipe"=>"or","operation"=>"notequal",),
array("column"=>"comments.member_srl", "value"=>$args->minus_member_srl,"pipe"=>"or","operation"=>"notequal",),
)),
 );
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"999");
return $output; ?>