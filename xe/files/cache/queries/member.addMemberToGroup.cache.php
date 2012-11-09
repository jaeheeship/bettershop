<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "member.addMemberToGroup";
$output->action = "insert";
$output->column_type["site_srl"] = "number";
$output->column_type["group_srl"] = "number";
$output->column_type["member_srl"] = "number";
$output->column_type["regdate"] = "date";
$output->tables = array( "member_group_member"=>"member_group_member", );
$output->_tables = array( "member_group_member"=>"member_group_member", );
$output->columns = array ( array("name"=>"group_srl","alias"=>"","value"=>$args->group_srl),
array("name"=>"member_srl","alias"=>"","value"=>$args->member_srl),
array("name"=>"site_srl","alias"=>"","value"=>$args->site_srl?$args->site_srl:"0"),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
 );
return $output; ?>