<?php if(!defined('__ZBXE__')) exit();
$output->query_id = "file.getFiles";
$output->action = "select";
if(is_object($args->upload_target_srl)){ $args->upload_target_srl = array_values(get_method_vars($args->upload_target_srl)); }
if(is_array($args->upload_target_srl) && count($args->upload_target_srl)==0){ unset($args->upload_target_srl); };
if(isset($args->upload_target_srl)) { unset($_output); $_output = $this->checkFilter("upload_target_srl",$args->upload_target_srl,"number"); if(!$_output->toBool()) return $_output; } 
if(!isset($args->upload_target_srl)) return new Object(-1, sprintf($lang->filter->isnull, $lang->upload_target_srl?$lang->upload_target_srl:'upload_target_srl'));
$output->column_type["file_srl"] = "number";
$output->column_type["upload_target_srl"] = "number";
$output->column_type["upload_target_type"] = "char";
$output->column_type["sid"] = "varchar";
$output->column_type["module_srl"] = "number";
$output->column_type["member_srl"] = "number";
$output->column_type["download_count"] = "number";
$output->column_type["direct_download"] = "char";
$output->column_type["source_filename"] = "varchar";
$output->column_type["uploaded_filename"] = "varchar";
$output->column_type["file_size"] = "number";
$output->column_type["comment"] = "varchar";
$output->column_type["isvalid"] = "char";
$output->column_type["regdate"] = "date";
$output->column_type["ipaddress"] = "varchar";
$output->tables = array( "files"=>"files", );
$output->_tables = array( "files"=>"files", );
$output->conditions = array ( array("pipe"=>"",
"condition"=>array(array("column"=>"upload_target_srl", "value"=>$args->upload_target_srl,"pipe"=>"","operation"=>"equal",),
)),
 );
$output->order = array(array($args->sort_index?$args->sort_index:"",in_array($args->asc,array("asc","desc"))?$args->asc:("asc"?"asc":"asc")),);
return $output; ?>