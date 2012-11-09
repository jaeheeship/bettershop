<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:./modules/member/tpl/js/member_admin.js--><?php Context::addJsFile("./modules/member/tpl/js/member_admin.js", true, "", null, "head"); ?>
<!--#Meta:./modules/member/tpl/css/member_admin.css--><?php Context::addCSSFile("./modules/member/tpl/css/member_admin.css", true, "all", "", null); ?>
<?php Context::loadJavascriptPlugin("ui"); ?>

<h3 class="xeAdmin"><?php @print($__Context->lang->member);?> <span class="gray"><?php @print($__Context->lang->cmd_management);?></span></h3>

<div class="infoText"><?php @print(nl2br($__Context->lang->about_member));?></div>

<div class="header4">
    <ul class="localNavigation">
        <li <?php  if($__Context->act=='dispMemberAdminList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispMemberAdminList','member_srl',''));?>"><?php @print($__Context->lang->cmd_member_list);?></a></li>
        <li <?php  if($__Context->act=='dispMemberAdminConfig'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispMemberAdminConfig'));?>"><?php @print($__Context->lang->cmd_module_config);?></a></li>
        <li <?php  if($__Context->act=='dispMemberAdminGroupList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispMemberAdminGroupList'));?>"><?php @print($__Context->lang->cmd_member_group);?></a></li>
        <li <?php  if($__Context->act=='dispMemberAdminJoinFormList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispMemberAdminJoinFormList'));?>"><?php @print($__Context->lang->cmd_manage_form);?></a></li>
        <li <?php  if($__Context->act=='dispMemberAdminDeniedIDList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispMemberAdminDeniedIDList'));?>"><?php @print($__Context->lang->cmd_manage_id);?></a></li>
    </ul>
</div>
