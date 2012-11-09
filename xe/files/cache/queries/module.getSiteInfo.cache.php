<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getSiteInfo";
$output->action = "select";
if(is_object($args->site_srl)){ $args->site_srl = array_values(get_method_vars($args->site_srl)); }
if(is_array($args->site_srl) && count($args->site_srl)==0){ unset($args->site_srl); };
if(!isset($args->site_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->site_srl?$lang->site_srl:'site_srl'));
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
$output->tables = array( "sites"=>"sites", );
$output->_tables = array( "sites"=>"sites","modules"=>"modules", );
$output->left_tables = array( "modules"=>"left join", );
$output->columns = array ( array("name"=>"modules.site_srl","alias"=>"module_site_srl"),
array("name"=>"modules.module_srl","alias"=>"module_srl"),
array("name"=>"modules.module","alias"=>"module"),
array("name"=>"modules.module_category_srl","alias"=>"module_category_srl"),
array("name"=>"modules.layout_srl","alias"=>"layout_srl"),
array("name"=>"modules.mlayout_srl","alias"=>"mlayout_srl"),
array("name"=>"modules.use_mobile","alias"=>"use_mobile"),
array("name"=>"modules.menu_srl","alias"=>"menu_srl"),
array("name"=>"modules.mid","alias"=>"mid"),
array("name"=>"modules.skin","alias"=>"skin"),
array("name"=>"modules.mskin","alias"=>"mskin"),
array("name"=>"modules.browser_title","alias"=>"browser_title"),
array("name"=>"modules.description","alias"=>"description"),
array("name"=>"modules.is_default","alias"=>"is_default"),
array("name"=>"modules.content","alias"=>"content"),
array("name"=>"modules.mcontent","alias"=>"mcontent"),
array("name"=>"modules.open_rss","alias"=>"open_rss"),
array("name"=>"modules.header_text","alias"=>"header_text"),
array("name"=>"modules.footer_text","alias"=>"footer_text"),
array("name"=>"modules.regdate","alias"=>"regdate"),
array("name"=>"sites.site_srl","alias"=>"site_srl"),
array("name"=>"sites.domain","alias"=>"domain"),
array("name"=>"sites.index_module_srl","alias"=>"index_module_srl"),
array("name"=>"sites.default_language","alias"=>"default_language"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"sites.site_srl", "value"=>$args->site_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
$output->left_conditions = array ( 'modules' => array ( array("pipe"=>"",
"condition"=>array(array("column"=>"modules.module_srl", "value"=>"sites.index_module_srl","pipe"=>"and","operation"=>"equal",),
)),
),
 );
return $output; ?>