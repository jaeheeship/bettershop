<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "admin.getDocumentDeclaredCount";
$output->action = "select";
$output->column_type["document_srl"] = "number";
$output->column_type["member_srl"] = "number";
$output->column_type["ipaddress"] = "varchar";
$output->column_type["regdate"] = "date";
$output->tables = array( "document_declared_log"=>"document_declared_log", );
$output->_tables = array( "document_declared_log"=>"document_declared_log", );
$output->columns = array ( array("name"=>"count(*)","alias"=>"count"),
 );
return $output; ?>