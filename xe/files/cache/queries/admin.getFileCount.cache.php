<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getFileCount";
$output->action = "select";
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
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
return $output; ?>