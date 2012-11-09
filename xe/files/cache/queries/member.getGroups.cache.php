<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.getGroups";
$output->action = "select";
if(is_object($args->site_srl)){ $args->site_srl = array_values(get_method_vars($args->site_srl)); }
if(is_array($args->site_srl) && count($args->site_srl)==0){ unset($args->site_srl); };
$output->column_type["site_srl"] = "number";
$output->column_type["group_srl"] = "number";
$output->column_type["list_order"] = "number";
$output->column_type["title"] = "varchar";
$output->column_type["regdate"] = "date";
$output->column_type["is_default"] = "char";
$output->column_type["is_admin"] = "char";
$output->column_type["image_mark"] = "text";
$output->column_type["description"] = "text";
$output->tables = array( "member_group"=>"member_group", );
$output->_tables = array( "member_group"=>"member_group", );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"site_srl", "value"=>$args->site_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"list_order",in_array($args->order_type,array("asc","desc"))?$args->order_type:("order_type"?"order_type":"asc")),);
return $output; ?>