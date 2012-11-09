<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getTodayTrackbackCount";
$output->action = "select";
if(is_object($args->regdate)){ $args->regdate = array_values(get_method_vars($args->regdate)); }
if(is_array($args->regdate) && count($args->regdate)==0){ unset($args->regdate); };
if(!isset($args->regdate)) return new Object(-1, sprintf($lang->filter->isnull, $lang->regdate?$lang->regdate:'regdate'));
$output->column_type["trackback_srl"] = "number";
$output->column_type["module_srl"] = "number";
$output->column_type["document_srl"] = "number";
$output->column_type["url"] = "varchar";
$output->column_type["title"] = "varchar";
$output->column_type["blog_name"] = "varchar";
$output->column_type["excerpt"] = "text";
$output->column_type["regdate"] = "date";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["list_order"] = "number";
$output->tables = array( "trackbacks"=>"trackbacks", );
$output->_tables = array( "trackbacks"=>"trackbacks", );
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"regdate", "value"=>$args->regdate,"pipe"=>"and","operation"=>"like_prefix",),
)),
 );
return $output; ?>