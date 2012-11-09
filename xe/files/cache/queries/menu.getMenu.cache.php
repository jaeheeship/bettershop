<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "menu.getMenu";
$output->action = "select";
if(is_object($args->menu_srl)){ $args->menu_srl = array_values(get_method_vars($args->menu_srl)); }
if(is_array($args->menu_srl) && count($args->menu_srl)==0){ unset($args->menu_srl); };
if(isset($args->menu_srl)) { unset($_output); $_output = $this->checkFilter("menu_srl",$args->menu_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->menu_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->menu_srl?$lang->menu_srl:'menu_srl'));
$output->column_type["menu_srl"] = "number";
$output->column_type["site_srl"] = "number";
$output->column_type["title"] = "varchar";
$output->column_type["listorder"] = "number";
$output->column_type["regdate"] = "date";
$output->tables = array( "menu"=>"menu", );
$output->_tables = array( "menu"=>"menu", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"menu_srl", "value"=>$args->menu_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>