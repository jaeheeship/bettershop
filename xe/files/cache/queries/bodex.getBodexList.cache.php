<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "bodex.getBodexList";
$output->action = "select";
if(is_object($args->s_mid)){ $args->s_mid = array_values(get_method_vars($args->s_mid)); }
if(is_array($args->s_mid) && count($args->s_mid)==0){ unset($args->s_mid); };
if(is_object($args->s_title)){ $args->s_title = array_values(get_method_vars($args->s_title)); }
if(is_array($args->s_title) && count($args->s_title)==0){ unset($args->s_title); };
if(is_object($args->s_comment)){ $args->s_comment = array_values(get_method_vars($args->s_comment)); }
if(is_array($args->s_comment) && count($args->s_comment)==0){ unset($args->s_comment); };
if(is_object($args->s_module)){ $args->s_module = array_values(get_method_vars($args->s_module)); }
if(is_array($args->s_module) && count($args->s_module)==0){ unset($args->s_module); };
if(is_object($args->s_module_category_srl)){ $args->s_module_category_srl = array_values(get_method_vars($args->s_module_category_srl)); }
if(is_array($args->s_module_category_srl) && count($args->s_module_category_srl)==0){ unset($args->s_module_category_srl); };
$output->column_type["module_srl"] = "number";
$output->column_type["module"] = "varchar";
$output->column_type["module_category_srl"] = "number";
$output->column_type["layout_srl"] = "number";
$output->column_type["use_mobile"] = "char";
$output->column_type["mlayout_srl"] = "number";
$output->column_type["menu_srl"] = "number";
$output->column_type["site_srl"] = "number";
$output->column_type["mid"] = "varchar";
$output->column_type["skin"] = "varchar";
$output->column_type["mskin"] = "varchar";
$output->column_type["browser_title"] = "varchar";
$output->column_type["description"] = "text";
$output->column_type["is_default"] = "char";
$output->column_type["content"] = "bigtext";
$output->column_type["mcontent"] = "bigtext";
$output->column_type["open_rss"] = "char";
$output->column_type["header_text"] = "text";
$output->column_type["footer_text"] = "text";
$output->column_type["regdate"] = "date";
$output->tables = array( "modules"=>"modules", );
$output->_tables = array( "modules"=>"modules", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"module", "value"=>"bodex","pipe"=>"","operation"=>"equal",),
)),
array("pipe"=>"and",
"condition"=>array(array("column"=>"mid", "value"=>$args->s_mid,"pipe"=>"or","operation"=>"like",),
array("column"=>"title", "value"=>$args->s_title,"pipe"=>"or","operation"=>"like",),
array("column"=>"comment", "value"=>$args->s_comment,"pipe"=>"or","operation"=>"like",),
array("column"=>"module", "value"=>$args->s_module,"pipe"=>"or","operation"=>"equal",),
array("column"=>"module_category_srl", "value"=>$args->s_module_category_srl,"pipe"=>"or","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"module_srl",in_array($args->desc,array("asc","desc"))?$args->desc:("desc"?"desc":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"20");
$output->page_count = array("var"=>"page_count", "value"=>$args->page_count?$args->page_count:"20");
$output->page = array("var"=>"page", "value"=>$args->page?$args->page:"");
return $output; ?>