<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "bodex.getDocumentList";
$output->action = "select";
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(is_object($args->exclude_module_srl)){ $args->exclude_module_srl = array_values(get_method_vars($args->exclude_module_srl)); }
if(is_array($args->exclude_module_srl) && count($args->exclude_module_srl)==0){ unset($args->exclude_module_srl); };
if(is_object($args->category_srl)){ $args->category_srl = array_values(get_method_vars($args->category_srl)); }
if(is_array($args->category_srl) && count($args->category_srl)==0){ unset($args->category_srl); };
if(is_object($args->s_is_notice)){ $args->s_is_notice = array_values(get_method_vars($args->s_is_notice)); }
if(is_array($args->s_is_notice) && count($args->s_is_notice)==0){ unset($args->s_is_notice); };
if(is_object($args->member_srl)){ $args->member_srl = array_values(get_method_vars($args->member_srl)); }
if(is_array($args->member_srl) && count($args->member_srl)==0){ unset($args->member_srl); };
if(is_object($args->division)){ $args->division = array_values(get_method_vars($args->division)); }
if(is_array($args->division) && count($args->division)==0){ unset($args->division); };
if(is_object($args->last_division)){ $args->last_division = array_values(get_method_vars($args->last_division)); }
if(is_array($args->last_division) && count($args->last_division)==0){ unset($args->last_division); };
if(is_object($args->s_title)){ $args->s_title = array_values(get_method_vars($args->s_title)); }
if(is_array($args->s_title) && count($args->s_title)==0){ unset($args->s_title); };
if(is_object($args->s_content)){ $args->s_content = array_values(get_method_vars($args->s_content)); }
if(is_array($args->s_content) && count($args->s_content)==0){ unset($args->s_content); };
if(is_object($args->s_user_name)){ $args->s_user_name = array_values(get_method_vars($args->s_user_name)); }
if(is_array($args->s_user_name) && count($args->s_user_name)==0){ unset($args->s_user_name); };
if(is_object($args->s_user_id)){ $args->s_user_id = array_values(get_method_vars($args->s_user_id)); }
if(is_array($args->s_user_id) && count($args->s_user_id)==0){ unset($args->s_user_id); };
if(is_object($args->s_nick_name)){ $args->s_nick_name = array_values(get_method_vars($args->s_nick_name)); }
if(is_array($args->s_nick_name) && count($args->s_nick_name)==0){ unset($args->s_nick_name); };
if(is_object($args->s_email_addres)){ $args->s_email_addres = array_values(get_method_vars($args->s_email_addres)); }
if(is_array($args->s_email_addres) && count($args->s_email_addres)==0){ unset($args->s_email_addres); };
if(is_object($args->s_homepage)){ $args->s_homepage = array_values(get_method_vars($args->s_homepage)); }
if(is_array($args->s_homepage) && count($args->s_homepage)==0){ unset($args->s_homepage); };
if(is_object($args->s_tags)){ $args->s_tags = array_values(get_method_vars($args->s_tags)); }
if(is_array($args->s_tags) && count($args->s_tags)==0){ unset($args->s_tags); };
if(is_object($args->s_doc_state)){ $args->s_doc_state = array_values(get_method_vars($args->s_doc_state)); }
if(is_array($args->s_doc_state) && count($args->s_doc_state)==0){ unset($args->s_doc_state); };
if(is_object($args->s_is_secret)){ $args->s_is_secret = array_values(get_method_vars($args->s_is_secret)); }
if(is_array($args->s_is_secret) && count($args->s_is_secret)==0){ unset($args->s_is_secret); };
if(is_object($args->s_member_srl)){ $args->s_member_srl = array_values(get_method_vars($args->s_member_srl)); }
if(is_array($args->s_member_srl) && count($args->s_member_srl)==0){ unset($args->s_member_srl); };
if(is_object($args->s_readed_count)){ $args->s_readed_count = array_values(get_method_vars($args->s_readed_count)); }
if(is_array($args->s_readed_count) && count($args->s_readed_count)==0){ unset($args->s_readed_count); };
if(is_object($args->s_voted_count)){ $args->s_voted_count = array_values(get_method_vars($args->s_voted_count)); }
if(is_array($args->s_voted_count) && count($args->s_voted_count)==0){ unset($args->s_voted_count); };
if(is_object($args->s_comment_count)){ $args->s_comment_count = array_values(get_method_vars($args->s_comment_count)); }
if(is_array($args->s_comment_count) && count($args->s_comment_count)==0){ unset($args->s_comment_count); };
if(is_object($args->s_trackback_count)){ $args->s_trackback_count = array_values(get_method_vars($args->s_trackback_count)); }
if(is_array($args->s_trackback_count) && count($args->s_trackback_count)==0){ unset($args->s_trackback_count); };
if(is_object($args->s_uploaded_count)){ $args->s_uploaded_count = array_values(get_method_vars($args->s_uploaded_count)); }
if(is_array($args->s_uploaded_count) && count($args->s_uploaded_count)==0){ unset($args->s_uploaded_count); };
if(is_object($args->s_regdate)){ $args->s_regdate = array_values(get_method_vars($args->s_regdate)); }
if(is_array($args->s_regdate) && count($args->s_regdate)==0){ unset($args->s_regdate); };
if(is_object($args->s_last_update)){ $args->s_last_update = array_values(get_method_vars($args->s_last_update)); }
if(is_array($args->s_last_update) && count($args->s_last_update)==0){ unset($args->s_last_update); };
if(is_object($args->s_ipaddress)){ $args->s_ipaddress = array_values(get_method_vars($args->s_ipaddress)); }
if(is_array($args->s_ipaddress) && count($args->s_ipaddress)==0){ unset($args->s_ipaddress); };
if(is_object($args->best_regdate)){ $args->best_regdate = array_values(get_method_vars($args->best_regdate)); }
if(is_array($args->best_regdate) && count($args->best_regdate)==0){ unset($args->best_regdate); };
if(is_object($args->best_voted_count)){ $args->best_voted_count = array_values(get_method_vars($args->best_voted_count)); }
if(is_array($args->best_voted_count) && count($args->best_voted_count)==0){ unset($args->best_voted_count); };
if(is_object($args->best_readed_count)){ $args->best_readed_count = array_values(get_method_vars($args->best_readed_count)); }
if(is_array($args->best_readed_count) && count($args->best_readed_count)==0){ unset($args->best_readed_count); };
if(is_object($args->best_comment_count)){ $args->best_comment_count = array_values(get_method_vars($args->best_comment_count)); }
if(is_array($args->best_comment_count) && count($args->best_comment_count)==0){ unset($args->best_comment_count); };
if(is_object($args->start_date)){ $args->start_date = array_values(get_method_vars($args->start_date)); }
if(is_array($args->start_date) && count($args->start_date)==0){ unset($args->start_date); };
if(is_object($args->end_date)){ $args->end_date = array_values(get_method_vars($args->end_date)); }
if(is_array($args->end_date) && count($args->end_date)==0){ unset($args->end_date); };
if(isset($args->module_srl)) { unset($_output); $_output = $this->checkFilter("module_srl",$args->module_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->exclude_module_srl)) { unset($_output); $_output = $this->checkFilter("exclude_module_srl",$args->exclude_module_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->member_srl)) { unset($_output); $_output = $this->checkFilter("member_srl",$args->member_srl,"number"); if(!$_output->toBool()) return $_output; } 
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
array("column"=>"module_srl", "value"=>$args->exclude_module_srl,"pipe"=>"and","operation"=>"notin",),
array("column"=>"category_srl", "value"=>$args->category_srl,"pipe"=>"and","operation"=>"in",),
array("column"=>"is_notice", "value"=>$args->s_is_notice,"pipe"=>"and","operation"=>"equal",),
array("column"=>"member_srl", "value"=>$args->member_srl,"pipe"=>"and","operation"=>"equal",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"list_order", "value"=>$args->division,"pipe"=>"and","operation"=>"more",),
array("column"=>"list_order", "value"=>$args->last_division,"pipe"=>"and","operation"=>"below",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"title", "value"=>$args->s_title,"pipe"=>"","operation"=>"like",),
array("column"=>"content", "value"=>$args->s_content,"pipe"=>"or","operation"=>"like",),
array("column"=>"user_name", "value"=>$args->s_user_name,"pipe"=>"or","operation"=>"like",),
array("column"=>"user_id", "value"=>$args->s_user_id,"pipe"=>"or","operation"=>"like",),
array("column"=>"nick_name", "value"=>$args->s_nick_name,"pipe"=>"or","operation"=>"like",),
array("column"=>"email_address", "value"=>$args->s_email_addres,"pipe"=>"or","operation"=>"like",),
array("column"=>"homepage", "value"=>$args->s_homepage,"pipe"=>"or","operation"=>"like",),
array("column"=>"tags", "value"=>$args->s_tags,"pipe"=>"or","operation"=>"like",),
array("column"=>"is_notice", "value"=>$args->s_doc_state,"pipe"=>"or","operation"=>"in",),
array("column"=>"is_secret", "value"=>$args->s_is_secret,"pipe"=>"or","operation"=>"equal",),
array("column"=>"member_srl", "value"=>$args->s_member_srl,"pipe"=>"or","operation"=>"equal",),
array("column"=>"readed_count", "value"=>$args->s_readed_count,"pipe"=>"or","operation"=>"more",),
array("column"=>"voted_count", "value"=>$args->s_voted_count,"pipe"=>"or","operation"=>"more",),
array("column"=>"comment_count", "value"=>$args->s_comment_count,"pipe"=>"or","operation"=>"more",),
array("column"=>"trackback_count", "value"=>$args->s_trackback_count,"pipe"=>"or","operation"=>"more",),
array("column"=>"uploaded_count", "value"=>$args->s_uploaded_count,"pipe"=>"or","operation"=>"more",),
array("column"=>"regdate", "value"=>$args->s_regdate,"pipe"=>"or","operation"=>"like_prefix",),
array("column"=>"last_update", "value"=>$args->s_last_update,"pipe"=>"or","operation"=>"like_prefix",),
array("column"=>"ipaddress", "value"=>$args->s_ipaddress,"pipe"=>"or","operation"=>"like_prefix",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"regdate", "value"=>$args->best_regdate,"pipe"=>"and","operation"=>"more",),
array("column"=>"voted_count", "value"=>$args->best_voted_count,"pipe"=>"and","operation"=>"more",),
array("column"=>"readed_count", "value"=>$args->best_readed_count,"pipe"=>"and","operation"=>"more",),
array("column"=>"comment_count", "value"=>$args->best_comment_count,"pipe"=>"and","operation"=>"more",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"last_update", "value"=>$args->start_date,"pipe"=>"and","operation"=>"more",),
array("column"=>"last_update", "value"=>$args->end_date,"pipe"=>"and","operation"=>"less",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"list_order",in_array($args->order_type,array("asc","desc"))?$args->order_type:("order_type"?"order_type":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"20");
$output->page_count = array("var"=>"page_count", "value"=>$args->page_count?$args->page_count:"20");
$output->page = array("var"=>"page", "value"=>$args->page?$args->page:"");
return $output; ?>