<?php if(!defined("__ZBXE__")) exit();?><?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/member/tpl/filter/","delete_profile_image.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/member/tpl/filter/","delete_image_name.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/member/tpl/filter/","delete_image_mark.xml");
$__Context->oXmlFilter->compile();
?>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/member/tpl/','header.html');
?>


<!-- 이미지 이름/마크를 삭제하기 위한 폼 -->
<form action="./" method="get" id="fo_image">
    <input type="hidden" name="member_srl" />
</form>

<table cellspacing="0" class="rowTable">
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->user_id);?></div></th>
    <td><?php @print($__Context->member_info->user_id);?></td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->user_name);?></div></th>
    <td><?php @print($__Context->member_info->user_name);?></td>
</tr>
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->nick_name);?></div></th>
    <td><?php @print($__Context->member_info->nick_name);?></td>
</tr>
<tr>
    <th scope="row" rowspan="2"><div><?php @print($__Context->lang->profile_image);?></div></th>
    <td>
        <?php  if($__Context->member_info->profile_image->src){ ?>
        <img src="<?php @print($__Context->member_info->profile_image->src);?>" border="0" alt="profile_image" />
        <a href="#" onclick="doDeleteProfileImage(<?php @print($__Context->member_info->member_srl);?>);return false;" class="button"><span><?php @print($__Context->lang->cmd_delete);?></span></a>
        <?php  }else{ ?>
        &nbsp;
        <?php  } ?>
    </td>
</tr>
<tr class="row2">
    <td>
        <form action="./" method="post" enctype="multipart/form-data" target="hidden_iframe">
        <input type="hidden" name="member_srl" value="<?php @print($__Context->member_info->member_srl);?>" />
        <input type="hidden" name="module" value="member" />
        <input type="hidden" name="act" value="procMemberInsertProfileImage" />
            <input type="file" name="profile_image" value="" />
            <span class="button"><input type="submit" value="<?php @print($__Context->lang->cmd_submit);?>" /></span>
        </form>
        <p><?php @print($__Context->lang->profile_image_max_width);?> : <?php @print($__Context->member_config->profile_image_max_width);?>px, <?php @print($__Context->lang->profile_image_max_height);?> : <?php @print($__Context->member_config->profile_image_max_height);?>px</p>
    </td>
</tr>
<tr>
    <th scope="row" rowspan="2"><div><?php @print($__Context->lang->image_name);?></div></th>
    <td>
        <?php  if($__Context->member_info->image_name->src){ ?>
        <img src="<?php @print($__Context->member_info->image_name->src);?>" border="0" alt="image_name" />
        <a href="#" onclick="doDeleteImageName(<?php @print($__Context->member_info->member_srl);?>);return false;" class="button"><span><?php @print($__Context->lang->cmd_delete);?></span></a>
        <?php  }else{ ?>
        &nbsp;
        <?php  } ?>
    </td>
</tr>
<tr class="row2">
    <td>
        <form action="./" method="post" enctype="multipart/form-data" target="hidden_iframe">
        <input type="hidden" name="member_srl" value="<?php @print($__Context->member_info->member_srl);?>" />
        <input type="hidden" name="module" value="member" />
        <input type="hidden" name="act" value="procMemberInsertImageName" />
            <input type="file" name="image_name" value="" />
            <span class="button"><input type="submit" value="<?php @print($__Context->lang->cmd_submit);?>" /></span>
        </form>
        <p><?php @print($__Context->lang->image_name_max_width);?> : <?php @print($__Context->member_config->image_name_max_width);?>px, <?php @print($__Context->lang->image_name_max_height);?> : <?php @print($__Context->member_config->image_name_max_height);?>px</p>
    </td>
</tr>
<tr>
    <th scope="row" rowspan="2"><div><?php @print($__Context->lang->image_mark);?></div></th>
    <td>
        <?php  if($__Context->member_info->image_mark->src){ ?>
        <img src="<?php @print($__Context->member_info->image_mark->src);?>" border="0" alt="image_mark" />
        <a href="#" onclick="doDeleteImageMark(<?php @print($__Context->member_info->member_srl);?>);return false;" class="button"><span><?php @print($__Context->lang->cmd_delete);?></span></a>
        <?php  }else{ ?>
        &nbsp;
        <?php  } ?>
    </td>
</tr>
<tr class="row2">
    <td>
        <form action="./" method="post" enctype="multipart/form-data" target="hidden_iframe">
        <input type="hidden" name="member_srl" value="<?php @print($__Context->member_info->member_srl);?>" />
        <input type="hidden" name="module" value="member" />
        <input type="hidden" name="act" value="procMemberInsertImageMark" />
        <input type="file" name="image_mark" value="" />
        <span class="button"><input type="submit" value="<?php @print($__Context->lang->cmd_submit);?>" /></span>
        </form>
        <p><?php @print($__Context->lang->image_mark_max_width);?> : <?php @print($__Context->member_config->image_mark_max_width);?>px, <?php @print($__Context->lang->image_mark_max_height);?> : <?php @print($__Context->member_config->image_mark_max_height);?>px</p>
    </td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->email_address);?></div></th>
    <td><?php @print($__Context->member_info->email_address);?></td>
</tr>
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->homepage);?></div></th>
    <td><?php  if($__Context->member_info->homepage){ ?><a href="<?php @print($__Context->member_info->homepage);?>" onclick="winopen(this.href); return false;"><?php @print($__Context->member_info->homepage);?></a><?php  } ?>&nbsp;</td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->blog);?></div></th>
    <td><?php  if($__Context->member_info->blog){ ?><a href="<?php @print($__Context->member_info->blog);?>" onclick="windopen(this.href); return false;"><?php @print($__Context->member_info->blog);?></a><?php  } ?>&nbsp;</td>
</tr>
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->birthday);?></div></th>
    <td><?php @print(zdate($__Context->member_info->birthday,'Y-m-d'));?>&nbsp;</td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->allow_mailing);?></div></th>
    <td><?php @print($__Context->member_info->allow_mailing);?>&nbsp;</td>
</tr>
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->allow_message);?></div></th>
    <td><?php @print($__Context->lang->allow_message_type[$__Context->member_info->allow_message]);?></td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->signature);?></div></th>
    <td><?php @print($__Context->member_info->signature);?>&nbsp;</td>
</tr>
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->denied);?></div></th>
    <td><?php @print($__Context->member_info->denied);?></td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->limit_date);?></div></th>
    <td>
        <?php  if($__Context->member_info->limit_date){ ?>
            <?php @print(zdate($__Context->member_info->limit_date,"Y-m-d H:i"));?>
        <?php  } ?>
        &nbsp;
    </td>
</tr>
<tr class="row2">
    <th scope="row"><div><?php @print($__Context->lang->is_admin);?></div></th>
    <td><?php @print($__Context->member_info->is_admin);?></td>
</tr>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->group);?></div></th>
    <td>
        <?php $__Context->Context->__idx[0]=0;if(count($__Context->member_info->group_list))  foreach($__Context->member_info->group_list as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
            <?php @print($__Context->val);?>
        <?php  } ?>
    </td>
</tr>
<?php  if($__Context->extend_form_list){ ?>
<?php $__Context->Context->__idx[1]=0;if(count($__Context->extend_form_list))  foreach($__Context->extend_form_list as $__Context->key => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
<tr class="row<?php @print($__Context->cycle_idx);?>">
    <th scope="row"><div><?php @print($__Context->val->column_title);?><?php  if($__Context->val->is_opened){ ?> <span class="publicItem">(<?php @print($__Context->lang->public);?>)</span><?php  } ?></div></th>
    <td>
        <?php  if($__Context->val->column_type=='tel'){ ?>
            <?php @print($__Context->val->value[0]);?>
                <?php  if($__Context->val->value[1]){ ?>-<?php  } ?>
            <?php @print($__Context->val->value[1]);?>
                <?php  if($__Context->val->value[2]){ ?>-<?php  } ?>
            <?php @print($__Context->val->value[2]);?>
        <?php  }elseif($__Context->val->column_type=='kr_zip'){ ?>
            <?php @print($__Context->val->value[0]);?><?php  if($__Context->val->value[1]&&$__Context->val->value[0]){ ?><br /><?php  } ?><?php @print($__Context->val->value[1]);?>
        <?php  }elseif($__Context->val->column_type=='checkbox' && is_array($__Context->val->value)){ ?>
            <?php @print(implode(", ",$__Context->val->value));?>
        <?php  }elseif($__Context->val->column_type=='date'){ ?>
            <?php @print(zdate($__Context->val->value, "Y-m-d"));?>
        <?php  }else{ ?>
            <?php @print(nl2br($__Context->val->value));?>
        <?php  } ?>
        &nbsp;
    </td>
</tr>
<?php  } ?>
<?php  } ?>
<tr>
    <th scope="row"><div><?php @print($__Context->lang->description);?></div></th>
    <td><?php @print($__Context->member_info->description);?>&nbsp;</td>
</tr>
<tr class="row2">
    <th colspan="2" class="button">
        <a href="<?php @print(getUrl('act','dispMemberAdminInsert'));?>" class="button black strong"><span><?php @print($__Context->lang->cmd_modify);?></span></a>
        <?php  if($__Context->member_info->is_admin!='Y'){ ?>
        <a href="<?php @print(getUrl('act','dispMemberAdminDeleteForm','member_srl',$__Context->member_info->member_srl));?>" class="button red"><span><?php @print($__Context->lang->cmd_delete);?></span></a>
        <?php  } ?>
        <?php  if($__Context->module=="admin"){ ?>
        <a href="<?php @print(getUrl('act','dispMemberAdminList','module_srl',''));?>" class="button"><span><?php @print($__Context->lang->cmd_back);?></span></a>
        <?php  } ?>
    </th>
</tr>
</table>

<iframe name="hidden_iframe" frameborder="0" style="display:none"></iframe>
