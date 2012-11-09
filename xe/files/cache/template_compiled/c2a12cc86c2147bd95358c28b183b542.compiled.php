<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:./modules/bodex/tpl/css/bodex_admin.css--><?php Context::addCSSFile("./modules/bodex/tpl/css/bodex_admin.css", true, "all", "", null); ?>
<!--#Meta:./modules/bodex/tpl/js/bodex_admin.js--><?php Context::addJsFile("./modules/bodex/tpl/js/bodex_admin.js", true, "", null, "head"); ?>
<?php  if($__Context->module!='admin'){ ?>
<style type="text/css">
#xeAdmin .localNavigation li a {padding: 7px 13px 0 13px;}
#xeAdmin table.rowTable td p {white-space:normal;}
#xeAdmin table.crossTable #sel_editor_colorset,
#xeAdmin table.crossTable #sel_comment_editor_colorset {width:95%;}
</style>
<?php  } ?>
<div id="bodexAdmin" <?php  if($__Context->module=='admin'){ ?>class="bodexAdminBody"<?php  } ?>>
    <div <?php  if($__Context->module=='admin'){ ?>class="left"<?php  } ?>>
        <?php  if($__Context->module=='admin'){ ?><h3 class="xeAdmin"><?php @print($__Context->lang->bodex);?> <span class="gray"><?php @print($__Context->lang->cmd_management);?></span></h3><?php  } ?>

            <ul class="<?php  if($__Context->module=='admin'){ ?>navigation<?php  }else{ ?>localNavigation<?php  } ?>">
                <?php  if($__Context->module=='admin'){ ?>
                    <li <?php  if($__Context->act=='dispBodexAdminContent'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminContent','module_srl',''));?>"><?php @print($__Context->lang->cmd_bodex_content);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminInsertBoard'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminInsertBoard','module_srl',''));?>"><?php @print($__Context->lang->cmd_Insert_bodex);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminBoardList'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminBoardList','module_srl',''));?>"><?php @print($__Context->lang->cmd_bodex_list);?></a></li>
                <?php  }else{ ?>
                    <li><a href="<?php @print(getUrl('act',''));?>"><?php @print($__Context->lang->cmd_back);?></a></li>
                <?php  } ?>
                <?php  if($__Context->module_srl){ ?>
                    <?php  if($__Context->module=='admin'){ ?><li class="module"><a href="<?php @print(getSiteUrl($__Context->module_info->domain,'','mid',$__Context->module_info->mid));?>" onclick="window.open(this.href); return false;"><?php @print(cut_str($__Context->module_info->mid,13));?></a></li><?php  } ?>
                    <li <?php  if($__Context->act=='dispBodexAdminBoardInfo'||$__Context->act=='dispBodexAdminInsertBoard'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminBoardInfo'));?>"><?php @print($__Context->lang->cmd_view_info);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminCategoryInfo'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminCategoryInfo'));?>"><?php @print($__Context->lang->cmd_manage_category);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminSearchSetup'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminSearchSetup'));?>"><?php @print($__Context->lang->cmd_search_setting);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminListSetup'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminListSetup'));?>"><?php @print($__Context->lang->cmd_list_setting);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminExtraVars'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminExtraVars'));?>"><?php @print($__Context->lang->extra_vars);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminGrantInfo'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminGrantInfo'));?>"><?php @print($__Context->lang->cmd_manage_grant);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminBoardAdditionSetup'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminBoardAdditionSetup'));?>"><?php @print($__Context->lang->cmd_addition_setup);?></a></li>
                    <li <?php  if($__Context->act=='dispBodexAdminSkinInfo'){ ?>class="on"<?php  } ?>><a href="<?php @print(getUrl('act','dispBodexAdminSkinInfo'));?>"><?php @print($__Context->lang->cmd_manage_skin);?></a></li>
                <?php  } ?>
            </ul>

    </div>
    <div <?php  if($__Context->module=='admin'){ ?>class="right"<?php  } ?>>
        <?php  if($__Context->module=='admin'){ ?>
            <div class="infoText"><?php  if($__Context->module_info && $__Context->module_info->mid){ ?><h4><?php @print($__Context->module_info->mid);?> <span class="vr">|</span> <a href="<?php @print(getSiteUrl($__Context->module_info->domain,'','mid',$__Context->module_info->mid));?>" onclick="window.open(this.href); return false;" class="view">View</a></h4><?php  }else{ ?><?php @print(nl2br($__Context->lang->about_bodex));?><?php  } ?></div>
        <?php  } ?>


