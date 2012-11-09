<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "layout.getLayoutList";
$output->action = "select";
if(is_object($args->site_srl)){ $args->site_srl = array_values(get_method_vars($args->site_srl)); }
if(is_array($args->site_srl) && count($args->site_srl)==0){ unset($args->site_srl); };
if(is_object($args->layout_type)){ $args->layout_type = array_values(get_method_vars($args->layout_type)); }
if(is_array($args->layout_type) && count($args->layout_type)==0){ unset($args->layout_type); };
if(isset($args->site_srl)) { unset($_output); $_output = $this->checkFilter("site_srl",$args->site_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->site_srl)) $args->site_srl = "0";
if(!isset($args->layout_type)) $args->layout_type = "P";
if(!isset($args->site_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->site_srl?$lang->site_srl:'site_srl'));
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
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"site_srl", "value"=>$args->site_srl?$args->site_srl:"0","pipe"=>"","operation"=>"equal",),
array("column"=>"layout_type", "value"=>$args->layout_type?$args->layout_type:"P","pipe"=>"and","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"layout_srl",in_array($args->desc,array("asc","desc"))?$args->desc:("desc"?"desc":"asc")),);
return $output; ?>