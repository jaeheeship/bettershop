<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "menu.insertMenu";
$output->action = "insert";
$output->column_type["menu_srl"] = "number";
$output->column_type["site_srl"] = "number";
$output->column_type["title"] = "varchar";
$output->column_type["listorder"] = "number";
$output->column_type["regdate"] = "date";
$output->tables = array( "menu"=>"menu", );
$output->_tables = array( "menu"=>"menu", );
$output->columns = array ( array("name"=>"menu_srl","alias"=>"","value"=>$args->menu_srl),
array("name"=>"site_srl","alias"=>"","value"=>$args->site_srl?$args->site_srl:"0"),
array("name"=>"title","alias"=>"","value"=>$args->title),
array("name"=>"listorder","alias"=>"","value"=>$args->listorder),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
 );
return $output; ?>