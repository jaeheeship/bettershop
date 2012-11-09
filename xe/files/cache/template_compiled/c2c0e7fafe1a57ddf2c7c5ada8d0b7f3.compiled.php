<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','__header.html');
?>


<?php @$__Context->is_view_document = ($__Context->oDocument->isExists() && ($__Context->module_info->default_style != 'memo' || $__Context->oDocument->isNotice() && $__Context->module_info->default_style == 'memo'));?>

<?php  if($__Context->is_view_document){ ?>
    <div class="viewDocument"><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.document.html');
?>
</div>
<?php  }elseif($__Context->module_info->display_simple_writer == "H" || (!$__Context->grant->manager && $__Context->module_info->display_simple_writer == "S")){ ?>
    <div class="exWSimFrmHead"><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','write_simple_form.html');
?>
</div>
<?php  } ?>

<?php  if($__Context->history_list || $__Context->act == 'dispBoardHistoryList'){ ?>
    <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.history.html');
?>

<?php  }elseif($__Context->module_info->display_simple_writer != "S" || ($__Context->grant->manager && $__Context->module_info->display_simple_writer == "S" )){ ?>
    <?php  if($__Context->is_view_document && $__Context->module_info->display_foot_list == "S"){ ?>
        <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.navigation.html');
?>

    <?php  }elseif(!$__Context->is_view_document || ($__Context->is_view_document && $__Context->module_info->display_foot_list == "Y")){ ?>
        <div class="exCat">
            <?php  if($__Context->module_info->use_category == "T"){ ?>
                <div class="exCatTab"><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.categorymenu.html');
?>
</div>
            <?php  }elseif($__Context->module_info->use_category == "L" || $__Context->module_info->use_category == "R"){ ?>
                <table cellspacing="0" class="exCatMnu">
                <col<?php if($__Context->module_info->use_category == 'L') {?> width="<?php @print($__Context->arr_category_width[0]);?>"<?php }?> />
                <col<?php if($__Context->module_info->use_category == 'R') {?> width="<?php @print($__Context->arr_category_width[0]);?>"<?php }?> />
                <tbody>
                <tr>
                    <?php if($__Context->module_info->use_category == 'L') { ?><td><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.categorymenu.html');
?>
</td><?php } ?>
                    <td>
            <?php  } ?>

            <?php  if($__Context->module_info->default_style == 'memo'){ ?>
                <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.memo.html');
?>

            <?php  }elseif($__Context->module_info->default_style == 'blog'){ ?>
                <?php  if($__Context->is_view_document || $__Context->search_keyword){ ?>
                    <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.list.html');
?>

                <?php  }else{ ?>
                    <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.blog.html');
?>

                <?php  } ?>
            <?php  }elseif($__Context->default_style == 'webzine'){ ?>
                <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.webzine.html');
?>

            <?php  }elseif($__Context->default_style == 'gallery'){ ?>
                <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.gallery.html');
?>

            <?php  }elseif($__Context->default_style == 'download'){ ?>
                <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.download.html');
?>

            <?php  }else{ ?>
                <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_style.list.html');
?>

            <?php  } ?>

            <?php  if($__Context->module_info->use_category == 'L' || $__Context->module_info->use_category == 'R'){ ?>
                    </td>
                    <?php if($__Context->module_info->use_category == 'R') { ?><td><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.categorymenu.html');
?>
</td><?php } ?>
                </tr></tbody></table>
            <?php  } ?>
        </div>

        <div class="exPage">
            <div class="fl"><?php if($__Context->grant->manager) { ?><a href="<?php @print(getUrl('','module','document','act','dispDocumentManageDocument'));?>" onclick="popopen(this.href,'manageDocument'); return false;" class="button <?php @print($__Context->btn_class);?>"><span><?php @print($__Context->lang->cmd_manage_document);?></span></a><?php } ?></div>

            <div class="fr">
                <?php if($__Context->grant->manager&&!$__Context->is_view_document&&$__Context->module_info->use_doc_state=='Y') { ?>
                    <select name="doc_state" class="doc_state exISt">
                        <option value=""><?php @print($__Context->lang->cmd_select);?></option>
                        <?php if(count($__Context->doc_state_list )) { foreach($__Context->doc_state_list  as $__Context->key => $__Context->val) { ?><option value="<?php @print($__Context->key);?>"><?php @print(strip_tags($__Context->val));?></option><?php } } ?>
                    </select>
                    <a href="#" onclick="_exJcChangeDocumentsState(document.getElementsByName('doc_state')[0].value); return false;" class="button <?php @print($__Context->btn_class);?>">
                        <span><?php @print($__Context->lang->cmd_change_state);?></span>
                    </a>
                <?php } ?>
                <?php if($__Context->module_info->display_search_position == 'H' && ($__Context->module_info->default_style != 'memo' && $__Context->module_info->display_simple_writer!='H' && $__Context->module_info->display_simple_writer!='F')) { ?><a href="<?php @print(getUrl('act','dispBoardWrite','document_srl',''));?>" class="button black"><span><?php @print($__Context->lang->cmd_write);?></span></a><?php } ?>
            </div>

            <?php @$__Context->pagination_navigation = $__Context->page_navigation;
                $__Context->pagination_name='list';;?>
            <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.pagination.html');
?>

        </div>

        <?php if(!$__Context->is_view_document&&$__Context->module_info->display_simple_writer == 'F') { ?><div class="exWSimFrmFoot"><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','write_simple_form.html');
?>
</div><?php } ?>
    <?php  } ?>

    <?php if($__Context->module_info->display_search_position != 'H') { ?><div class="exBtom">
        <?php if($__Context->module_info->use_ex_search == 'Y') { ?><div class="exJsSchExBox exDHide">
            <?php if(count($__Context->search_option )) { foreach($__Context->search_option  as $__Context->key => $__Context->val) { ?><?php if(strpos($__Context->key,'extra_vars')===0) { ?><label>
                <input type="checkbox" name="ex_search_option" value="<?php @print(substr($__Context->key, strlen('extra_vars')));?>" /><?php @print($__Context->val);?>
            </label><?php } ?><?php } } ?>
        </div><?php } ?>

        <div class="exSchBox"<?php if($__Context->module_info->display_search_position == 'R') {?> style="float:right"<?php }?>>
            <a href="<?php @print(getUrl('act','dispBoardTagList'));?>" title="<?php @print($__Context->lang->tag.' '.$__Context->lang->cmd_list);?>" class="exTSch"<?php if($__Context->module_info->display_search_position == 'R') {?> style="float:right"<?php }?>><span>Tag List</span></a>
            <form action="<?php @print(getUrl());?>" method="get" onsubmit="return _exJsExSearchFilter(this, search_document)" id="fo_search" class="exDSch <?php  if($__Context->module_info->display_search_position == 'R'){ ?>fr<?php  }else{ ?>fl<?php  } ?>">
                <?php if($__Context->vid) { ?><input type="hidden" name="vid" value="<?php @print($__Context->vid);?>" />
                <?php } ?><input type="hidden" name="mid" value="<?php @print($__Context->mid);?>" />
                <input type="hidden" name="category" value="<?php @print($__Context->category);?>" />
                <select name="search_target" class="exISt"<?php if($__Context->module_info->use_ex_search == 'Y') {?> onchange="_exJsExSearchBoxToggle(this)"<?php }?>>
                    <?php  if($__Context->module_info->default_style == 'memo'){ ?>
                        <option value="title"<?php if($__Context->search_target=='title') {?> selected="selected"<?php }?>><?php @print($__Context->lang->title);?></option>
                        <option value="nick_name"<?php if($__Context->search_target=='nick_name') {?> selected="selected"<?php }?>><?php @print($__Context->lang->nick_name);?></option>
                        <option value="user_id"<?php if($__Context->search_target=='user_id') {?> selected="selected"<?php }?>><?php @print($__Context->lang->user_id);?></option>
                    <?php  }else{ ?>
                        <?php if(count($__Context->search_option )) { foreach($__Context->search_option  as $__Context->key => $__Context->val) { ?><?php if($__Context->module_info->use_ex_search != 'Y'||strpos($__Context->key,'extra_vars')===false) { ?><option value="<?php @print($__Context->key);?>"<?php if($__Context->search_target==$__Context->key) {?> selected="selected"<?php }?>><?php @print($__Context->val);?></option><?php } ?><?php } } ?>
                    <?php  } ?>
                    <?php if($__Context->module_info->use_ex_search == 'Y') { ?><option value="ex_search"<?php if($__Context->search_target=='ex_search') {?> selected="selected"<?php }?>>* <?php @print($__Context->lang->ex_search);?> *</option><?php } ?>
                </select>
                <input type="text" maxlength="40" class="exISt" name="search_keyword" value="<?php @print(htmlspecialchars($__Context->search_keyword));?>" />
                <?php if($__Context->last_division) { ?><a href="<?php @print(getUrl('page',1,'document_srl','','division',$__Context->last_division,'last_division','','entry',''));?>" class="button <?php @print($__Context->btn_class);?>"><span><?php @print($__Context->lang->cmd_search_next);?></span></a><?php } ?>
                <span class="button <?php @print($__Context->btn_class);?>"><input type="submit" value="<?php @print($__Context->lang->cmd_search);?>" accesskey="s" /></span>
                <?php if($__Context->search_keyword) { ?><a href="<?php @print(getUrl('search_target','','search_keyword',''));?>" class="button <?php @print($__Context->btn_class);?>"><span><?php @print($__Context->lang->cmd_cancel);?></span></a><?php } ?>
            </form>
        </div>

        <div class="exWBBox"<?php if($__Context->module_info->display_search_position == 'R') {?> style="float:left"<?php }?>>
            <a href="<?php @print(getUrl('document_srl','','mid',$__Context->mid,'page',($__Context->page>1)?$__Context->page:''));?>" class="button black"><span><?php @print($__Context->lang->cmd_list);?></span></a>
            <?php if($__Context->module_info->default_style != 'memo' && $__Context->module_info->display_simple_writer!='H' && $__Context->module_info->display_simple_writer!='F') { ?><a href="<?php @print(getUrl('act','dispBoardWrite','document_srl',''));?>" class="button black"><span><?php @print($__Context->lang->cmd_write);?></span></a><?php } ?>
        </div>
    </div><?php } ?>
<?php  } ?>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','__footer.html');
?>

