<?php if(!defined("__ZBXE__")) exit();?><!-- 설명 -->
<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/member/tpl/','header.html');
?>

<!--#Meta:./modules/member/tpl/css/member_list.css--><?php Context::addCSSFile("./modules/member/tpl/css/member_list.css", true, "all", "", null); ?>

<form action="./" method="get" class="adminSearch">
<input type="hidden" name="module" value="<?php @print($__Context->module);?>" />
<input type="hidden" name="act" value="<?php @print($__Context->act);?>" />

    <fieldset>

        <select name="is_admin">
            <option value="" <?php  if($__Context->is_admin!='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->total);?></option>
            <option value="Y" <?php  if($__Context->is_admin=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->is_admin);?></option>
        </select>
        <select name="is_denied">
            <option value="" <?php  if($__Context->is_denied!='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->total);?></option>
            <option value="Y" <?php  if($__Context->is_denied=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->denied);?></option>
        </select>
        <select name="selected_group_srl">
            <option value="0"><?php @print($__Context->lang->group);?></option>
            <?php $__Context->Context->__idx[0]=0;if(count($__Context->group_list))  foreach($__Context->group_list as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
            <option value="<?php @print($__Context->val->group_srl);?>" <?php  if($__Context->selected_group_srl==$__Context->val->group_srl){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?></option>
            <?php  } ?>
        </select>
        <select name="search_target">
            <option value=""><?php @print($__Context->lang->search_target);?></option>
            <?php $__Context->Context->__idx[1]=0;if(count($__Context->lang->search_target_list))  foreach($__Context->lang->search_target_list as $__Context->key => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
            <option value="<?php @print($__Context->key);?>" <?php  if($__Context->search_target==$__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
            <?php  } ?>
        </select>
        <input type="text" name="search_keyword" value="<?php @print(htmlspecialchars($__Context->search_keyword));?>" class="inputTypeText" />
        <span class="button black strong"><input type="submit" value="<?php @print($__Context->lang->cmd_search);?>" /></span>
        <a href="#" onclick="location.href='<?php @print(getUrl('','module',$__Context->module,'act',$__Context->act));?>';return false;" class="button"><span><?php @print($__Context->lang->cmd_cancel);?></span></a>
    </fieldset>
</form>

<!-- 목록 -->
<form method="get" action="./" id="member_fo">
    <table cellspacing="0" class="rowTable">
    <caption>Total <?php @print(number_format($__Context->total_count));?>, Page <?php @print(number_format($__Context->page));?>/<?php @print(number_format($__Context->total_page));?></caption>
    <thead>
        <tr>
            <th scope="col"><div><a href="<?php @print(getUrl('sort_index','','sort_order',$__Context->sort_index!='last_login'&&$__Context->sort_order=='desc'?'asc':''));?>"><?php @print($__Context->lang->no);?></a></div></th>
            <th scope="col"><div><input type="checkbox" onclick="XE.checkboxToggleAll(); return false;"/></div></th>
            <th scope="col" class="quarter_wide"><div><?php @print($__Context->lang->user_id);?></div></th>
            <th scope="col" class="quarter_wide"><div><?php @print($__Context->lang->user_name);?></div></th>
            <th scope="col" class="quarter_wide"><div><?php @print($__Context->lang->nick_name);?></div></th>
            <th scope="col" class="quarter_wide"><div><a href="<?php @print(getUrl('sort_index','','sort_order',$__Context->sort_index!='last_login'&&$__Context->sort_order=='desc'?'asc':''));?>"><?php @print($__Context->lang->signup_date);?></a></div></th>
            <th scope="col"><div><a href="<?php @print(getUrl('sort_index','last_login','sort_order',$__Context->sort_index=='last_login'&&$__Context->sort_order=='desc'?'asc':''));?>"><?php @print($__Context->lang->last_login);?></a></div></th>
            <th scope="col" colspan="2"><div>&nbsp;</div></th>
        </tr>
    </thead>
    <tbody>
        <?php $__Context->Context->__idx[2]=0;if(count($__Context->member_list))  foreach($__Context->member_list as $__Context->no => $__Context->val){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
        <?php @$__Context->val->group_list = implode(', ', $__Context->val->group_list);?>
        <tr class="row<?php @print($__Context->cycle_idx);?>">
            <td rowspan="2"><?php @print($__Context->no);?></td>
            <td rowspan="2"><input type="checkbox" name="cart" value="<?php @print($__Context->val->member_srl);?>"/></td>
            <td><a href="<?php @print(getUrl('act','dispMemberAdminInfo','member_srl',$__Context->val->member_srl));?>"><?php @print($__Context->val->user_id);?></a></td>
            <td><?php @print($__Context->val->user_name);?></td>
            <td><span class="member_<?php @print($__Context->val->member_srl);?>"><?php @print($__Context->val->nick_name);?></span></td>
            <td><?php @print(zdate($__Context->val->regdate,"Y-m-d H:i:s"));?></td>
            <td><?php @print(zdate($__Context->val->last_login,"Y-m-d H:i:s"));?></td>
            <td class="nowrap">
                <?php  if($__Context->val->homepage){ ?><a href="<?php @print(htmlspecialchars($__Context->val->homepage));?>" class="homepage" onclick="window.open(this.href);return false;"><img src="/bettershop/xe/modules/member/tpl/images/icon_homepage.gif" title="<?php @print($__Context->lang->homepage);?>" alt="<?php @print($__Context->lang->homepage);?>" /></a> <?php  } ?>
                <?php  if($__Context->val->blog){ ?><a href="<?php @print(htmlspecialchars($__Context->val->blog));?>" class="blog" onclick="window.open(this.href);return false;"><img src="/bettershop/xe/modules/member/tpl/images/icon_blog.gif" title="<?php @print($__Context->lang->blog);?>" alt="<?php @print($__Context->lang->blog);?>" /></a> <?php  } ?>&nbsp;
            </td>
            <td><?php  if($__Context->val->is_admin != 'Y'){ ?><a href="<?php @print(getUrl('act','dispMemberAdminDeleteForm','member_srl', $__Context->val->member_srl));?>" title="<?php @print($__Context->lang->cmd_delete);?>" class="buttonSet buttonDelete"><span><?php @print($__Context->lang->cmd_delete);?></span></a><?php  }else{ ?><img src="/bettershop/xe/modules/member/tpl/images/icon_management.gif" title="<?php @print($__Context->lang->is_admin);?>" alt="<?php @print($__Context->lang->is_admin);?>" /><?php  } ?></td>
        </tr>
        <tr>
            <td colspan="8"><p><?php @print($__Context->val->group_list);?>&nbsp;</p></td>
        </tr>
        <?php  } ?>
    </tbody>
    </table>

    <!-- 버튼 -->
    <div class="clear">
        <div class="fl">
            <a href="#" onclick="doManageMemberGroup(); return false;" class="button blue"><span><?php @print($__Context->lang->cmd_member_group);?></span></a>
            <a href="#" onclick="doDeleteMembers(); return false;" class="button red"><span><?php @print($__Context->lang->cmd_delete);?></span></a>
        </div>
        <div class="fr">
            <a href="<?php @print(getUrl('act','dispMemberAdminInsert','member_srl',''));?>" class="button black strong"><span><?php @print($__Context->lang->cmd_make);?></span></a>
        </div>
    </div>

    <!-- 페이지 네비게이션 -->
    <div class="pagination a1">
        <a href="<?php @print(getUrl('page','','module_srl',''));?>" class="prevEnd"><?php @print($__Context->lang->first_page);?></a> 
        <?php  while($__Context->page_no = $__Context->page_navigation->getNextPage()){ ?>
            <?php  if($__Context->page == $__Context->page_no){ ?>
                <strong><?php @print($__Context->page_no);?></strong> 
            <?php  }else{ ?>
                <a href="<?php @print(getUrl('page',$__Context->page_no,'module_srl',''));?>"><?php @print($__Context->page_no);?></a> 
            <?php  } ?>
        <?php  } ?>
        <a href="<?php @print(getUrl('page',$__Context->page_navigation->last_page,'module_srl',''));?>" class="nextEnd"><?php @print($__Context->lang->last_page);?></a>
    </div>
</form>

<form action="./" method="get" class="adminSearch">
<input type="hidden" name="module" value="<?php @print($__Context->module);?>" />
<input type="hidden" name="act" value="<?php @print($__Context->act);?>" />

    <fieldset>

        <select name="is_admin">
            <option value="" <?php  if($__Context->is_admin!='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->total);?></option>
            <option value="Y" <?php  if($__Context->is_admin=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->is_admin);?></option>
        </select>
        <select name="is_denied">
            <option value="" <?php  if($__Context->is_denied!='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->total);?></option>
            <option value="Y" <?php  if($__Context->is_denied=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->denied);?></option>
        </select>
        <select name="selected_group_srl">
            <option value="0"><?php @print($__Context->lang->group);?></option>
            <?php $__Context->Context->__idx[3]=0;if(count($__Context->group_list))  foreach($__Context->group_list as $__Context->key => $__Context->val){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
            <option value="<?php @print($__Context->val->group_srl);?>" <?php  if($__Context->selected_group_srl==$__Context->val->group_srl){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?></option>
            <?php  } ?>
        </select>
        <select name="search_target">
            <option value=""><?php @print($__Context->lang->search_target);?></option>
            <?php $__Context->Context->__idx[4]=0;if(count($__Context->lang->search_target_list))  foreach($__Context->lang->search_target_list as $__Context->key => $__Context->val){$__Context->__idx[5]=($__Context->__idx[5]+1)%2; $__Context->cycle_idx = $__Context->__idx[5]+1; ?>
            <option value="<?php @print($__Context->key);?>" <?php  if($__Context->search_target==$__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
            <?php  } ?>
        </select>
        <input type="text" name="search_keyword" value="<?php @print(htmlspecialchars($__Context->search_keyword));?>" class="inputTypeText" />
        <span class="button black strong"><input type="submit" value="<?php @print($__Context->lang->cmd_search);?>" /></span>
        <a href="#" onclick="location.href='<?php @print(getUrl('','module',$__Context->module,'act',$__Context->act));?>';return false;" class="button"><span><?php @print($__Context->lang->cmd_cancel);?></span></a>
    </fieldset>
</form>
