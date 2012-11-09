<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/tpl/','header.html');
?>


<!-- 정보 -->
<div class="summary">
    <strong>Total</strong> <em><?php @print(number_format($__Context->total_count));?></em>, Page <strong><?php @print(number_format($__Context->page));?></strong>/<?php @print(number_format($__Context->total_page));?>
</div>

<!-- 목록 -->
<form action="./" method="get" onsubmit="return doChangeCategory(this);" id="fo_list">
<table cellspacing="0" class="rowTable">
<thead>
    <tr>
        <th scope="col"><div><?php @print($__Context->lang->no);?></div></th>
        <th scope="col"><div><input type="checkbox" onclick="XE.checkboxToggleAll(); return false;" /></div></th>
        <th scope="col">
            <div>
                <input type="hidden" name="module" value="<?php @print($__Context->module);?>" />
                <input type="hidden" name="act" value="<?php @print($__Context->act);?>" />
                <select name="module_category_srl">
                    <option value=""><?php @print($__Context->lang->module_category);?></option>
                    <option value="0" <?php  if($__Context->module_category_srl==="0"){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->not_exists);?></option>
                    <?php $__Context->Context->__idx[0]=0;if(count($__Context->module_category))  foreach($__Context->module_category as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
                    <option value="<?php @print($__Context->key);?>" <?php  if($__Context->module_category_srl==$__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?></option>
                    <?php  } ?>
                    <option value="">---------</option>
                    <option value="-1"><?php @print($__Context->lang->cmd_management);?></option>
                </select>
                <input type="submit" name="go_button" id="go_button" value="GO" class="buttonTypeGo" />
            </div>
        </th>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->mid);?></div></th>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->browser_title);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->regdate);?></div></th>
        <th scope="col" colspan="3"><div>&nbsp;</div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[1]=0;if(count($__Context->bodex_list))  foreach($__Context->bodex_list as $__Context->no => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
    <tr>
        <td class="center number"><?php @print($__Context->no);?></td>
        <td class="center"><input type="checkbox" name="cart" value="<?php @print($__Context->val->module_srl);?>" /></td>
        <td>
            <?php  if(!$__Context->val->module_category_srl){ ?>
                <?php  if($__Context->val->site_srl){ ?>
                <?php @print($__Context->lang->virtual_site);?>
                <?php  }else{ ?>
                <?php @print($__Context->lang->not_exists);?>
                <?php  } ?>
            <?php  }else{ ?>
                <?php @print($__Context->module_category[$__Context->val->module_category_srl]->title);?>
            <?php  } ?>
        </td>
        <td><?php @print(htmlspecialchars($__Context->val->mid));?></td>
        <td><a href="<?php @print(getSiteUrl($__Context->val->domain,'','mid',$__Context->val->mid));?>" onclick="window.open(this.href); return false;"><?php @print($__Context->val->browser_title);?></a></td>
        <td><?php @print(zdate($__Context->val->regdate,"Y-m-d"));?></td>
        <td><a href="<?php @print(getUrl('act','dispBodexAdminBoardInfo','module_srl',$__Context->val->module_srl));?>" class="buttonSet buttonSetting"><span><?php @print($__Context->lang->cmd_setup);?></span></a></td>
        <td><a href="<?php @print(getUrl('','module','module','act','dispModuleAdminCopyModule','module_srl',$__Context->val->module_srl));?>" onclick="popopen(this.href);return false;" class="buttonSet buttonCopy"><span><?php @print($__Context->lang->cmd_copy);?></span></a></td>
        <td><a href="<?php @print(getUrl('act','dispBodexAdminDeleteBoard','module_srl', $__Context->val->module_srl));?>" class="buttonSet buttonDelete"><span><?php @print($__Context->lang->cmd_delete);?></span></a></td>
    </tr>
    <?php  } ?>
</tbody>
</table>
</form>

<div class="clear">
    <div class="fl">
        <a href="<?php @print(getUrl('','module','module','act','dispModuleAdminModuleSetup'));?>" onclick="doCartSetup(this.href); return false;" class="button green"><span><?php @print($__Context->lang->cmd_setup);?></span></a>
        <a href="<?php @print(getUrl('','module','module','act','dispModuleAdminModuleAdditionSetup'));?>" onclick="doCartSetup(this.href); return false;" class="button red"><span><?php @print($__Context->lang->cmd_addition_setup);?></span></a>
        <a href="<?php @print(getUrl('','module','module','act','dispModuleAdminModuleGrantSetup'));?>" onclick="doCartSetup(this.href); return false;" class="button blue"><span><?php @print($__Context->lang->cmd_manage_grant);?></span></a>
    </div>

    <div class="fr">
        <a href="<?php @print(getUrl('act','dispBodexAdminInsertBoard','module_srl',''));?>" class="button black strong"><span><?php @print($__Context->lang->cmd_make);?></span></a>
    </div>
</div>

<!-- 페이지 네비게이션 -->
<div class="pagination a1">
    <a href="<?php @print(getUrl('page','','module_srl',''));?>" class="prevEnd"><?php @print($__Context->lang->first_page);?></a>
    <?php  if($__Context->page_navigation){ ?>
        <?php  while($__Context->page_no = $__Context->page_navigation->getNextPage()){ ?>
            <?php  if($__Context->page == $__Context->page_no){ ?>
                <strong><?php @print($__Context->page_no);?></strong>
            <?php  }else{ ?>
                <a href="<?php @print(getUrl('page',$__Context->page_no,'module_srl',''));?>"><?php @print($__Context->page_no);?></a>
            <?php  } ?>
        <?php  } ?>
    <?php  } ?>
    <a href="<?php @print(getUrl('page',$__Context->page_navigation->last_page,'module_srl',''));?>" class="nextEnd"><?php @print($__Context->lang->last_page);?></a>
</div>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/tpl/','footer.html');
?>


