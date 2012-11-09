<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getFileStatus";
$output->action = "select";
if(is_object($args->date)){ $args->date = array_values(get_method_vars($args->date)); }
if(is_array($args->date) && count($args->date)==0){ unset($args->date); };
if(!isset($args->date)) return new Object(-1, sprintf($lang->filter->isnull, $lang->date?$lang->date:'date'));
$output->column_type["file_srl"] = "number";
$output->column_type["upload_target_srl"] = "number";
$output->column_type["upload_target_type"] = "char";
$output->column_type["sid"] = "varchar";
$output->column_type["module_srl"] = "number";
$output->column_type["member_srl"] = "number";
$output->column_type["download_count"] = "number";
$output->column_type["direct_download"] = "char";
$output->column_type["source_filename"] = "varchar";
$output->column_type["uploaded_filename"] = "varchar";
$output->column_type["file_size"] = "number";
$output->column_type["comment"] = "varchar";
$output->column_type["isvalid"] = "char";
$output->column_type["regdate"] = "date";
$output->column_type["ipaddress"] = "varchar";
$output->tables = array( "files"=>"files", );
$output->_tables = array( "files"=>"files", );
$output->columns = array ( array("name"=>"substr(regdate,1,8)","alias"=>"date"),
array("name"=>"count(*)","alias"=>"count"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"regdate", "value"=>$args->date,"pipe"=>"","operation"=>"more",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"substr(regdate,1,8)",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"2");
$output->groups = array("substr(regdate,1,8)");
return $output; ?>