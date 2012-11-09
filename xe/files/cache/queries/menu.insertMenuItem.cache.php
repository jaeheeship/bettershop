<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "menu.insertMenuItem";
$output->action = "insert";
$output->column_type["menu_item_srl"] = "number";
$output->column_type["parent_srl"] = "number";
$output->column_type["menu_srl"] = "number";
$output->column_type["name"] = "text";
$output->column_type["url"] = "varchar";
$output->column_type["open_window"] = "char";
$output->column_type["expand"] = "char";
$output->column_type["normal_btn"] = "varchar";
$output->column_type["hover_btn"] = "varchar";
$output->column_type["active_btn"] = "varchar";
$output->column_type["group_srls"] = "text";
$output->column_type["listorder"] = "number";
$output->column_type["regdate"] = "date";
$output->tables = array( "menu_item"=>"menu_item", );
$output->_tables = array( "menu_item"=>"menu_item", );
$output->columns = array ( array("name"=>"menu_item_srl","alias"=>"","value"=>$args->menu_item_srl),
array("name"=>"parent_srl","alias"=>"","value"=>$args->parent_srl?$args->parent_srl:"0"),
array("name"=>"menu_srl","alias"=>"","value"=>$args->menu_srl),
array("name"=>"name","alias"=>"","value"=>$args->name),
array("name"=>"url","alias"=>"","value"=>$args->url),
array("name"=>"open_window","alias"=>"","value"=>$args->open_window),
array("name"=>"expand","alias"=>"","value"=>$args->expand),
array("name"=>"normal_btn","alias"=>"","value"=>$args->normal_btn),
array("name"=>"hover_btn","alias"=>"","value"=>$args->hover_btn),
array("name"=>"active_btn","alias"=>"","value"=>$args->active_btn),
array("name"=>"group_srls","alias"=>"","value"=>$args->group_srls),
array("name"=>"listorder","alias"=>"","value"=>$args->listorder),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
 );
return $output; ?>