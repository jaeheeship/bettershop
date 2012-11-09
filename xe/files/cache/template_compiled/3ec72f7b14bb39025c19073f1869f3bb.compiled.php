<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:./modules/document/tpl/js/document_admin.js--><?php Context::addJsFile("./modules/document/tpl/js/document_admin.js", true, "", null, "head"); ?>

<h3 class="xeAdmin"><?php @print($__Context->lang->document);?> <span class="gray"><?php @print($__Context->lang->cmd_management);?></span></h3>

<div class="header4 gap1">
    <ul class="localNavigation">
        <li <?php  if($__Context->act=='dispDocumentAdminList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispDocumentAdminList'));?>"><?php @print($__Context->lang->document_list);?></a></li>
        <li <?php  if($__Context->act=='dispDocumentAdminConfig'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispDocumentAdminConfig'));?>"><?php @print($__Context->lang->cmd_module_config);?></a></li>
        <li <?php  if($__Context->act=='dispDocumentAdminDeclared'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispDocumentAdminDeclared'));?>"><?php @print($__Context->lang->cmd_declared_list);?></a></li>
        <li <?php  if($__Context->act=='dispDocumentAdminTrashList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispDocumentAdminTrashList'));?>"><?php @print($__Context->lang->cmd_trash);?></a></li>
    </ul>
</div>
