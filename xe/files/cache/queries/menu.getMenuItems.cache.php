<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "menu.getMenuItems";
$output->action = "select";
if(is_object($args->menu_srl)){ $args->menu_srl = array_values(get_method_vars($args->menu_srl)); }
if(is_array($args->menu_srl) && count($args->menu_srl)==0){ unset($args->menu_srl); };
if(isset($args->menu_srl)) { unset($_output); $_output = $this->checkFilter("menu_srl",$args->menu_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->menu_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->menu_srl?$lang->menu_srl:'menu_srl'));
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
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"menu_srl", "value"=>$args->menu_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"listorder",in_array($args->desc,array("asc","desc"))?$args->desc:("desc"?"desc":"asc")),);
return $output; ?>