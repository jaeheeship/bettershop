<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/tpl/','header.html');
?>


<table cellspacing="0" class="rowTable">
<thead>
    <tr>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->recent.' '.$__Context->lang->document);?></div></th>
        <th scope="col" colspan="3"><div>&nbsp;</div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[0]=0;if(count($__Context->new_documents))  foreach($__Context->new_documents as $__Context->no => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
    <tr>
        <td class="title">
            <a href="<?php @print(getSiteUrl($__Context->val->domain,'','mid',$__Context->val->mid,'document_srl',$__Context->val->document_srl));?>" onclick="window.open(this.href); return false;">
            <?php @print(trim(cut_str($__Context->val->title, 80, '...')));?>
            </a>
        </td>
        <td><div class="<?php @print('member_'.$__Context->val->member_srl);?>" style="cursor:pointer"><?php @print($__Context->val->nick_name);?></div></td>
        <td><?php @print(zdate($__Context->val->regdate,"Y-m-d"));?></td>
        <td class="ipaddress"><?php @print($__Context->val->ipaddress);?></td>
    </tr>
    <?php  } ?>
</tbody>
</table>

<table cellspacing="0" class="rowTable">
<thead>
    <tr>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->recent.' '.$__Context->lang->comment);?></div></th>
        <th scope="col" colspan="3"><div>&nbsp;</div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[1]=0;if(count($__Context->new_comments))  foreach($__Context->new_comments as $__Context->no => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
    <tr>
        <td class="title">
            <a href="<?php @print(getSiteUrl($__Context->val->domain,'','mid',$__Context->val->mid,'document_srl',$__Context->val->document_srl));?>#comment_<?php @print($__Context->val->comment_srl);?>" onclick="window.open(this.href); return false;">
            <?php @print(trim(cut_str(strip_tags($__Context->val->content), 80, '...')));?>
            </a>
        </td>
        <td><div class="<?php @print('member_'.$__Context->val->member_srl);?>" style="cursor:pointer"><?php @print($__Context->val->nick_name);?></div></td>
        <td><?php @print(zdate($__Context->val->regdate,"Y-m-d"));?></td>
        <td class="ipaddress"><?php @print($__Context->val->ipaddress);?></td>
    </tr>
    <?php  } ?>
</tbody>
</table>

<table cellspacing="0" class="rowTable">
<thead>
    <tr>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->recent.' '.$__Context->lang->download.' '.$__Context->lang->about_new_download);?></div></th>
        <th scope="col" colspan="3"><div>&nbsp;</div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[2]=0;if(count($__Context->new_downloads))  foreach($__Context->new_downloads as $__Context->no => $__Context->val){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
    <tr>
        <td class="title">
            <a href="<?php @print(getSiteUrl($__Context->val->domain,'','mid',$__Context->val->mid,'document_srl',$__Context->val->upload_target_srl));?>" onclick="window.open(this.href); return false;">
            <?php @print(trim(cut_str($__Context->val->source_filename, 80, '...')));?>
            </a>
        </td>
        <td><div class="<?php @print('member_'.$__Context->val->member_srl);?>" style="cursor:pointer"><?php @print($__Context->val->nick_name);?></div></td>
        <td><?php @print(zdate($__Context->val->regdate,"Y-m-d"));?></td>
        <td class="ipaddress"><?php @print($__Context->val->ipaddress);?></td>
    </tr>
    <?php  } ?>
</tbody>
</table>

<table cellspacing="0" class="rowTable">
<thead>
    <tr>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->document.' '.$__Context->lang->recent.' '.$__Context->lang->cmd_declare);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->declared_count);?></div></th>
        <th scope="col" colspan="3"><div>&nbsp;</div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[3]=0;if(count($__Context->new_declareds))  foreach($__Context->new_declareds as $__Context->no => $__Context->val){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
    <tr>
        <td class="title">
            <a href="<?php @print(getSiteUrl($__Context->val->domain,'','mid',$__Context->val->mid,'document_srl',$__Context->val->document_srl));?>" onclick="window.open(this.href); return false;">
            <?php @print(trim(cut_str($__Context->val->title, 80, '...')));?>
            </a>
        </td>
        <td><?php @print($__Context->val->declared_count);?></td>
        <td><div class="<?php @print('member_'.$__Context->val->member_srl);?>" style="cursor:pointer"><?php @print($__Context->val->nick_name);?></div></td>
        <td><?php @print(zdate($__Context->val->regdate,"Y-m-d"));?></td>
        <td class="ipaddress"><?php @print($__Context->val->ipaddress);?></td>
    </tr>
    <?php  } ?>
</tbody>
</table>

<table cellspacing="0" class="rowTable">
<thead>
    <tr>
        <th scope="col" class="half_wide"><div><?php @print($__Context->lang->comment.' '.$__Context->lang->recent.' '.$__Context->lang->cmd_declare);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->declared_count);?></div></th>
        <th scope="col" colspan="3"><div>&nbsp;</div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[4]=0;if(count($__Context->new_declareds_comment))  foreach($__Context->new_declareds_comment as $__Context->no => $__Context->val){$__Context->__idx[5]=($__Context->__idx[5]+1)%2; $__Context->cycle_idx = $__Context->__idx[5]+1; ?>
    <tr>
        <td class="title">
            <a href="<?php @print(getSiteUrl($__Context->val->domain,'','mid',$__Context->val->mid,'document_srl',$__Context->val->document_srl));?>#comment_<?php @print($__Context->val->comment_srl);?>" onclick="window.open(this.href); return false;">
            <?php @print(trim(cut_str(strip_tags($__Context->val->content), 80, '...')));?>
            </a>
        </td>
        <td><?php @print($__Context->val->declared_count);?></td>
        <td><div class="<?php @print('member_'.$__Context->val->member_srl);?>" style="cursor:pointer"><?php @print($__Context->val->nick_name);?></div></td>
        <td><?php @print(zdate($__Context->val->regdate,"Y-m-d"));?></td>
        <td class="ipaddress"><?php @print($__Context->val->ipaddress);?></td>
    </tr>
    <?php  } ?>
</tbody>
</table>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/tpl/','footer.html');
?>

