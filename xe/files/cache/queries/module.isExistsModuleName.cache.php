<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.isExistsModuleName";
$output->action = "select";
if(is_object($args->site_srl)){ $args->site_srl = array_values(get_method_vars($args->site_srl)); }
if(is_array($args->site_srl) && count($args->site_srl)==0){ unset($args->site_srl); };
if(is_object($args->mid)){ $args->mid = array_values(get_method_vars($args->mid)); }
if(is_array($args->mid) && count($args->mid)==0){ unset($args->mid); };
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(!isset($args->site_srl)) $args->site_srl = "0";
if(!isset($args->module_srl)) $args->module_srl = "0";
if(!isset($args->site_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->site_srl?$lang->site_srl:'site_srl'));
if(!isset($args->mid)) return new Object(-1, sprintf($lang->filter->isnull, $lang->mid?$lang->mid:'mid'));
if(!isset($args->module_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->module_srl?$lang->module_srl:'module_srl'));
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
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"site_srl", "value"=>$args->site_srl?$args->site_srl:"0","pipe"=>"","operation"=>"equal",),
array("column"=>"mid", "value"=>$args->mid,"pipe"=>"and","operation"=>"equal",),
array("column"=>"module_srl", "value"=>$args->module_srl?$args->module_srl:"0","pipe"=>"and","operation"=>"notequal",),
)),
 );
return $output; ?>