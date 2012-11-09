<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "document.getDocumentExtraVars";
$output->action = "select";
if(is_object($args->document_srl)){ $args->document_srl = array_values(get_method_vars($args->document_srl)); }
if(is_array($args->document_srl) && count($args->document_srl)==0){ unset($args->document_srl); };
if(!isset($args->document_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->document_srl?$lang->document_srl:'document_srl'));
$output->column_type["module_srl"] = "number";
$output->column_type["document_srl"] = "number";
$output->column_type["var_idx"] = "number";
$output->column_type["lang_code"] = "varchar";
$output->column_type["value"] = "bigtext";
$output->column_type["eid"] = "varchar";
$output->tables = array( "extra_vars"=>"document_extra_vars", );
$output->_tables = array( "extra_vars"=>"document_extra_vars", );
$output->columns = array ( array("name"=>"*","alias"=>""),
 );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"extra_vars.module_srl", "value"=>"-1","pipe"=>"and","operation"=>"more",),
array("column"=>"extra_vars.document_srl", "value"=>$args->document_srl,"pipe"=>"and","operation"=>"in",),
array("column"=>"extra_vars.var_idx", "value"=>"-2","pipe"=>"and","operation"=>"more",),
)),
 );
return $output; ?>