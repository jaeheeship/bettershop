<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "point.updatePoint";
$output->action = "update";
if(is_object($args->member_srl)){ $args->member_srl = array_values(get_method_vars($args->member_srl)); }
if(is_array($args->member_srl) && count($args->member_srl)==0){ unset($args->member_srl); };
if(isset($args->member_srl)) { unset($_output); $_output = $this->checkFilter("member_srl",$args->member_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->member_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->member_srl?$lang->member_srl:'member_srl'));
$output->column_type["member_srl"] = "number";
$output->column_type["point"] = "number";
$output->tables = array( "point"=>"point", );
$output->_tables = array( "point"=>"point", );
$output->columns = array ( array("name"=>"point","alias"=>"","value"=>$args->point),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"member_srl", "value"=>$args->member_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
return $output; ?>