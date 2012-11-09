<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "layout.insertLayout";
$output->action = "insert";
$output->column_type["layout_srl"] = "number";
$output->column_type["site_srl"] = "number";
$output->column_type["layout"] = "varchar";
$output->column_type["title"] = "varchar";
$output->column_type["extra_vars"] = "text";
$output->column_type["layout_path"] = "varchar";
$output->column_type["module_srl"] = "number";
$output->column_type["regdate"] = "date";
$output->column_type["layout_type"] = "char";
$output->tables = array( "layouts"=>"layouts", );
$output->_tables = array( "layouts"=>"layouts", );
$output->columns = array ( array("name"=>"layout_srl","alias"=>"","value"=>$args->layout_srl),
array("name"=>"site_srl","alias"=>"","value"=>$args->site_srl?$args->site_srl:"0"),
array("name"=>"layout","alias"=>"","value"=>$args->layout),
array("name"=>"title","alias"=>"","value"=>$args->title),
array("name"=>"module_srl","alias"=>"","value"=>$args->module_srl),
array("name"=>"layout_path","alias"=>"","value"=>$args->layout_path),
array("name"=>"regdate","alias"=>"","value"=>$args->regdate?$args->regdate:date("YmdHis")),
array("name"=>"layout_type","alias"=>"","value"=>$args->layout_type?$args->layout_type:"P"),
 );
return $output; ?>