<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getTrackbackCount";
$output->action = "select";
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
return $output; ?>