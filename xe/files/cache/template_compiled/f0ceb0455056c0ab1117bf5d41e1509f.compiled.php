<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:./modules/module/tpl/js/module_admin.js--><?php Context::addJsFile("./modules/module/tpl/js/module_admin.js", true, "", null, "head"); ?>

<h3 class="xeAdmin"><?php @print($__Context->lang->module);?> <span class="gray"><?php @print($__Context->lang->cmd_management);?></span></h3>

<?php  if($__Context->act == 'dispModuleAdminContent'){ ?>
<div class="infoText"><?php @print(nl2br($__Context->lang->about_module));?></div>
<?php  } ?>

<ul class="localNavigation">
    <li <?php  if($__Context->act=='dispModuleAdminContent'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispModuleAdminContent'));?>"><?php @print($__Context->lang->module_index);?></a></li>
    <li <?php  if($__Context->act=='dispModuleAdminCategory'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispModuleAdminCategory'));?>"><?php @print($__Context->lang->module_category);?></a></li>
</ul>
