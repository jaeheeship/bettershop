<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/admin/tpl/','_header.html');
?>


		<div class="content">
            <?php  if($__Context->logged_info->is_admin == 'Y'){ ?>
            <p class="path">
                <a href="<?php @print(getUrl('','module','admin'));?>"><?php @print($__Context->lang->admin_index);?></a> 
                <?php  if($__Context->selected_module_info){ ?>
                &gt; <a href="<?php @print(getUrl('','mid',$__Context->mid,'module',$__Context->module,'act',$__Context->selected_module_info->admin_index_act));?>"><?php @print($__Context->selected_module_info->title);?></a>
                <?php  } ?>
                <?php  if($__Context->module_info){ ?>
                &gt; <a href="<?php @print(getUrl('','mid',$__Context->mid,'module',$__Context->module,'act',$__Context->selected_module_info->admin_index_act));?>"><?php @print($__Context->module_info->browser_title);?></a>
                [<a href="<?php @print(getSiteUrl($__Context->module_info->domain,'','mid',$__Context->module_info->mid));?>" onclick="window.open(this.href);return false;"><?php @print($__Context->lang->cmd_view);?></a>]
                <?php  } ?>
            </p>
            <?php  } ?>
            <?php @print($__Context->content);?>
        </div>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/admin/tpl/','_footer.html');
?>

