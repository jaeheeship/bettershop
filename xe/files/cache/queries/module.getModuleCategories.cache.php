<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "module.getModuleCategories";
$output->action = "select";
$output->column_type["module_category_srl"] = "number";
$output->column_type["title"] = "varchar";
$output->column_type["regdate"] = "date";
$output->tables = array( "module_categories"=>"module_categories", );
$output->_tables = array( "module_categories"=>"module_categories", );
$output->order = array(array($args->sort_index?$args->sort_index:"title",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
return $output; ?>