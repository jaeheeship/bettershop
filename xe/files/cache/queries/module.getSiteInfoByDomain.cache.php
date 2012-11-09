<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getSiteInfoByDomain";
$output->action = "select";
if(is_object($args->domain)){ $args->domain = array_values(get_method_vars($args->domain)); }
if(is_array($args->domain) && count($args->domain)==0){ unset($args->domain); };
if(!isset($args->domain)) return new Object(-1, sprintf($lang->filter->isnull, $lang->domain?$lang->domain:'domain'));
$output->column_type["site_srl"] = "number";
$output->column_type["index_module_srl"] = "number";
$output->column_type["domain"] = "varchar";
$output->column_type["default_language"] = "varchar";
$output->column_type["regdate"] = "date";
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
$output->tables = array( "sites"=>"sites","modules"=>"modules", );
$output->_tables = array( "sites"=>"sites","modules"=>"modules", );
$output->columns = array ( array("name"=>"sites.site_srl","alias"=>"site_srl"),
array("name"=>"sites.domain","alias"=>"domain"),
array("name"=>"sites.index_module_srl","alias"=>"index_module_srl"),
array("name"=>"sites.default_language","alias"=>"default_language"),
array("name"=>"modules.*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"sites.domain", "value"=>$args->domain,"pipe"=>"","operation"=>"equal",),
array("column"=>"modules.module_srl", "value"=>"sites.index_module_srl","pipe"=>"and","operation"=>"equal",),
)),
 );
return $output; ?>