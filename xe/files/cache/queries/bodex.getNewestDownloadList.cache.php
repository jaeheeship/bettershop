<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "bodex.getNewestDownloadList";
$output->action = "select";
$output->column_type["file_srl"] = "number";
$output->column_type["upload_target_srl"] = "number";
$output->column_type["member_srl"] = "number";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["download_count"] = "number";
$output->column_type["regdate"] = "date";
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
$output->tables = array( "files_downloaded_log"=>"files_downloaded_log","files"=>"files", );
$output->_tables = array( "files_downloaded_log"=>"files_downloaded_log","files"=>"files", );
$output->columns = array ( array("name"=>"files_downloaded_log.*","alias"=>""),
array("name"=>"files.source_filename","alias"=>"source_filename"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"files.file_srl", "value"=>"files_downloaded_log.file_srl","pipe"=>"","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"files_downloaded_log.regdate",in_array($args->order_type,array("asc","desc"))?$args->order_type:("order_type"?"order_type":"asc")),);
$output->list_count = array("var"=>"list_count", "value"=>$args->list_count?$args->list_count:"10");
return $output; ?>