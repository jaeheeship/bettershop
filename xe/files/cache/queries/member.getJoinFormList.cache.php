<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.getJoinFormList";
$output->action = "select";
$output->column_type["member_join_form_srl"] = "number";
$output->column_type["column_type"] = "varchar";
$output->column_type["column_name"] = "varchar";
$output->column_type["column_title"] = "varchar";
$output->column_type["required"] = "char";
$output->column_type["default_value"] = "text";
$output->column_type["is_active"] = "char";
$output->column_type["description"] = "text";
$output->column_type["list_order"] = "number";
$output->column_type["regdate"] = "date";
$output->tables = array( "member_join_form"=>"member_join_form", );
$output->_tables = array( "member_join_form"=>"member_join_form", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"list_order",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
return $output; ?>