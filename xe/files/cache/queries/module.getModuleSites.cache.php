<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getModuleSites";
$output->action = "select";
if(is_object($args->module_srls)){ $args->module_srls = array_values(get_method_vars($args->module_srls)); }
if(is_array($args->module_srls) && count($args->module_srls)==0){ unset($args->module_srls); };
if(!isset($args->module_srls)) return new Object(-1, sprintf($lang->filter->isnull, $lang->module_srls?$lang->module_srls:'module_srls'));
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
$output->column_type["site_srl"] = "number";
$output->column_type["index_module_srl"] = "number";
$output->column_type["domain"] = "varchar";
$output->column_type["default_language"] = "varchar";
$output->column_type["regdate"] = "date";
$output->tables = array( "modules"=>"modules","sites"=>"sites", );
$output->_tables = array( "modules"=>"modules","sites"=>"sites", );
$output->columns = array ( array("name"=>"modules.module_srl","alias"=>"module_srl"),
array("name"=>"sites.domain","alias"=>"domain"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"modules.module_srl", "value"=>$args->module_srls,"pipe"=>"","operation"=>"in",),
array("column"=>"sites.site_srl", "value"=>"modules.site_srl","pipe"=>"and","operation"=>"equal",),
)),
 );
return $output; ?>