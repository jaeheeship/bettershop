<?php if(!defined("__ZBXE__")) exit();?><?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/module/tpl/filter/","insert_shortcut.xml");
$__Context->oXmlFilter->compile();
?>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/module/tpl/','header.html');
?>


<!-- 관리자 메뉴 바로가기 추가를 위한 임시 form -->
<form id="fo_shortcut" action="./" method="get">
    <input type="hidden" name="selected_module" value="" />
</form>
    <h4 class="xeAdmin"><?php @print($__Context->lang->module);?></h4>
    <table cellspacing="0" class="rowTable">
    <thead>
        <tr>
            <th class="wide"><div><?php @print($__Context->lang->module_name);?></div></th>
            <th><div><?php @print($__Context->lang->version);?></div></th>
            <th><div><?php @print($__Context->lang->author);?></div></th>
            <th><div><?php @print($__Context->lang->table_count);?></div></th>
            <th><div><?php @print($__Context->lang->path);?></div></th>
            <th><div><?php @print($__Context->lang->module_action);?></div></th>
        </tr>
    </thead>
    <tbody>
    <?php $__Context->Context->__idx[0]=0;if(count($__Context->module_list))  foreach($__Context->module_list as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
        <tr class="row<?php @print($__Context->cycle_idx);?>">
            <td><a href="<?php @print(getUrl('','module','module','act','dispModuleAdminInfo','selected_module',$__Context->val->module));?>" onclick="popopen(this.href,'module_info');return false"title="<?php @print(trim($__Context->val->description));?>"><?php @print($__Context->val->title);?></a> (<?php @print($__Context->val->module);?>)</td>
            <td class="center number"><?php @print($__Context->val->version);?></td>
            <td class="nowrap">
                <?php $__Context->Context->__idx[1]=0;if(count($__Context->val->author))  foreach($__Context->val->author as $__Context->author){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
                <?php  if($__Context->author->homepage){ ?><a href="<?php @print($__Context->author->homepage);?>" onclick="window.open(this.href);return false;"><?php  } ?><?php @print($__Context->author->name);?><?php  if($__Context->author->homepage){ ?></a><?php  } ?>
                <?php  } ?>
            </td>
            <td class="number center <?php  if($__Context->val->created_table_count != $__Context->val->table_count){ ?>alert<?php  } ?>">
                <?php @print($__Context->val->created_table_count);?>/<?php @print($__Context->val->table_count);?>
            </td>
            <td class="nowrap"><?php @print($__Context->val->path);?></td>
            <td class="nowrap center <?php  if($__Context->val->need_install || $__Context->val->need_update){ ?>alert<?php  } ?>">
                <?php  if($__Context->val->need_install){ ?>
                    <a href="#" onclick="doInstallModule('<?php @print($__Context->val->module);?>');return false;"><?php @print($__Context->lang->cmd_install);?></a>
                <?php  }elseif($__Context->val->need_update){ ?>
                    <a href="#" onclick="doUpdateModule('<?php @print($__Context->val->module);?>'); return false;"><?php @print($__Context->lang->cmd_update);?></a>
                <?php  }else{ ?>
                    -
                <?php  } ?>
            </td>
        </tr>
        <?php  } ?>
    </tbody>
    </table>
