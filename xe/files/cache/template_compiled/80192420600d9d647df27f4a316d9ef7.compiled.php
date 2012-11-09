<?php if(!defined("__ZBXE__")) exit();?>
<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','___setting.html');
?>


<?php if(!$__Context->iframe_include) { ?>
    <?php @print($__Context->module_info->header_text);?>

    <?php if($__Context->module_info->title) { ?><div name="_had_sc_1" class="exHad">
        <div><h3><a href="<?php @print(getFullUrl('','mid',$__Context->mid,'custom_layout_path',$__Context->custom_layout_path,'custom_layout_file',$__Context->custom_layout_file));?>"><?php @print($__Context->module_info->title);?></a></h3></div>
        <h4><?php @print($__Context->module_info->sub_title?$__Context->module_info->sub_title:'&nbsp;');?></h4>
    </div><?php } ?>

    <?php if($__Context->module_info->comment || $__Context->module_info->display_point_configs == 'Y') { ?><div class="exDes">
        <?php if($__Context->module_info->display_point_configs == 'Y' && ($__Context->point_configs = $__Context->oBodex->getPointConfig())) { ?><div class="exDPCfg">
            <ul>
                <li><div>Post<br /><?php @print($__Context->point_configs['insert_document']);?></div></li>
                <li><div>Reply<br /><?php @print($__Context->point_configs['insert_comment']);?></div></li>
                <li><div>Read<br /><?php @print($__Context->point_configs['read_document']);?></div></li>
                <li><div>Up<br /><?php @print($__Context->point_configs['upload_file']);?></div></li>
                <li><div>Down<br /><?php if($__Context->module_info->use_reward != 'N' && $__Context->module_info->use_allow_down == 'P') { ?>?<?php } ?><?php @print($__Context->point_configs['download_file']);?></div></li>
            </ul>
        </div><?php } ?>
        <?php if($__Context->module_info->comment) { ?><div><?php @print(preg_replace(array('/%MID%/','/%LOGIN%/','/%URL%/'),array($__Context->mid,($__Context->logged_info?$__Context->logged_info->nick_name:$__Context->lang->visitor),getFullUrl('','mid',$__Context->mid)),$__Context->module_info->comment));?></div><?php } ?>
    </div><?php } ?>

    <?php if($__Context->module_info->display_login_info != 'N' || $__Context->module_info->display_setup_button != 'N' || $__Context->module_info->display_quick_type_button != 'N') { ?><div class="exIfo">

        <?php if($__Context->total_count) { ?><span class="exANum"><?php @print($__Context->lang->document_count);?>&nbsp;<strong><?php @print(number_format($__Context->total_count));?></strong></span><?php } ?>

        <ul class="exANav">
            <?php  if($__Context->is_logged){ ?>
                <?php if(($__Context->logged_info->is_admin == 'Y' || $__Context->grant->manager) && $__Context->module_info->display_setup_button != 'N') { ?>
                    <?php @$__Context->module_title = ucfirst($__Context->module_info->module);?>
                    <?php if($__Context->grant->manager) { ?><li class="setup"><a href="<?php @print(getUrl('mid',$__Context->mid,'act','disp'.$__Context->module_title.'AdminBoardInfo'));?>"><?php @print($__Context->lang->cmd_setup);?></a></li><?php } ?>
                    <?php if($__Context->logged_info->is_admin == 'Y') { ?><li class="exLgin"><a href="<?php @print(getUrl('','module','admin','act','disp'.$__Context->module_title.'AdminContent'));?>" onclick="window.open(this.href); return false;"><?php @print($__Context->lang->cmd_management);?></a></li><?php } ?>
                <?php } ?>
                <?php if($__Context->module_info->display_login_info != 'N') { ?>
                    <li class="exJoin"><a href="<?php @print(getUrl('act','dispMemberInfo'));?>"><?php @print($__Context->lang->member_info);?></a></li>
                    <li class="exLgin"><a href="<?php @print(getUrl('act','dispMemberLogout'));?>"><?php @print($__Context->lang->cmd_logout);?></a></li>
                <?php } ?>

            <?php  }elseif(!$__Context->is_logged && $__Context->module_info->display_login_info != 'N'){ ?>
                <li class="exJoin"><a href="<?php @print(getUrl('act','dispMemberSignUpForm'));?>"><?php @print($__Context->lang->cmd_signup);?></a></li>
                <li class="exLgin"><a href="<?php @print(getUrl('act','dispMemberLoginForm'));?>"><?php @print($__Context->lang->cmd_login);?></a></li>
            <?php  } ?>

            <?php if($__Context->rss_url) { ?><li class="exTIco exRss"><a href="<?php @print($__Context->rss_url);?>" title="RSS"><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/blank.gif" alt="RSS" /><span>RSS</span></a></li><?php } ?>

            <?php if($__Context->module_info->display_quick_type_button != 'N' && !in_array($__Context->module_info->default_style,array('memo','blog'))) { ?>
                <?php if(!$__Context->rss_url) { ?><li style="width:0px">&nbsp;</li><?php } ?>

                <?php  if($__Context->module_info->default_style=='download' || $__Context->module_info->default_style=='review'){ ?>
                    <li class="exLTZin<?php @print($__Context->default_style=='download'?'A':'');?> exTIco"><a href="<?php @print(getUrl('mid',$__Context->mid,'listStyle',$__Context->module_info->default_style));?>" title="Review Style"><span>Review Style</span></a></li>
                <?php  }else{ ?>
                    <li class="exLTCls<?php @print($__Context->default_style=='list'?'A':'');?> exTIco"><a href="<?php @print(getUrl('mid',$__Context->mid,'listStyle','list'));?>" title="Classic Style"><span>Classic Style</span></a></li>
                    <li class="exLTZin<?php @print($__Context->default_style=='webzine'?'A':'');?> exTIco"><a href="<?php @print(getUrl('mid',$__Context->mid,'listStyle','webzine'));?>" title="Zine Style"><span>Zine Style</span></a></li>
                <?php  } ?>
                <li class="exLTGal<?php @print($__Context->default_style=='gallery'?'A':'');?> exTIco"><a href="<?php @print(getUrl('mid',$__Context->mid,'listStyle','gallery'));?>" title="Gallery Style"><span>Gallery Style</span></a></li>
            <?php } ?>
        </ul>
    </div><?php } ?>
<?php } ?>
