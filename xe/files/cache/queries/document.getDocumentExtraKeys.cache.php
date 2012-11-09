<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "document.getDocumentExtraKeys";
$output->action = "select";
if(is_object($args->module_srl)){ $args->module_srl = array_values(get_method_vars($args->module_srl)); }
if(is_array($args->module_srl) && count($args->module_srl)==0){ unset($args->module_srl); };
if(is_object($args->var_idx)){ $args->var_idx = array_values(get_method_vars($args->var_idx)); }
if(is_array($args->var_idx) && count($args->var_idx)==0){ unset($args->var_idx); };
if(isset($args->module_srl)) { unset($_output); $_output = $this->checkFilter("module_srl",$args->module_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(isset($args->var_idx)) { unset($_output); $_output = $this->checkFilter("var_idx",$args->var_idx,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->module_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->module_srl?$lang->module_srl:'module_srl'));
$output->column_type["module_srl"] = "number";
$output->column_type["var_idx"] = "number";
$output->column_type["var_name"] = "varchar";
$output->column_type["var_type"] = "varchar";
$output->column_type["var_is_required"] = "char";
$output->column_type["var_search"] = "char";
$output->column_type["var_default"] = "text";
$output->column_type["var_desc"] = "text";
$output->column_type["eid"] = "varchar";
$output->tables = array( "document_extra_keys"=>"document_extra_keys", );
$output->_tables = array( "document_extra_keys"=>"document_extra_keys", );
$output->columns = array ( array("name"=>"module_srl","alias"=>"module_srl"),
array("name"=>"var_idx","alias"=>"idx"),
array("name"=>"var_name","alias"=>"name"),
array("name"=>"var_type","alias"=>"type"),
array("name"=>"var_is_required","alias"=>"is_required"),
array("name"=>"var_search","alias"=>"search"),
array("name"=>"var_default","alias"=>"default"),
array("name"=>"var_desc","alias"=>"desc"),
array("name"=>"eid","alias"=>"eid"),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"module_srl", "value"=>$args->module_srl,"pipe"=>"","operation"=>"equal",),
array("column"=>"var_idx", "value"=>$args->var_idx,"pipe"=>"and","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"var_idx",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
return $output; ?>