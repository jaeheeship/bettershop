<?php if(!defined("__ZBXE__")) exit();?><?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/document/tpl/filter/","delete_checked.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/document/tpl/filter/","manage_checked_document.xml");
$__Context->oXmlFilter->compile();
?>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/document/tpl/','header.html');
?>



<!-- 검색 -->
<div class="fl">
    <form action="./" method="get" class="adminSearch">
    <input type="hidden" name="module" value="<?php @print($__Context->module);?>" />
    <input type="hidden" name="act" value="<?php @print($__Context->act);?>" />
    <input type="hidden" name="module_srl" value="<?php @print($__Context->module_srl);?>" />

        <fieldset>
            <select name="search_target">
                <option value=""><?php @print($__Context->lang->search_target);?></option>
                <?php $__Context->Context->__idx[0]=0;if(count($__Context->lang->search_target_list))  foreach($__Context->lang->search_target_list as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->search_target==$__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
                <?php  } ?>
            </select>
            <input type="text" name="search_keyword" value="<?php @print(htmlspecialchars($__Context->search_keyword));?>" class="inputTypeText" />
            <span class="button blue"><input type="submit" value="<?php @print($__Context->lang->cmd_search);?>" /></span>
            <a href="<?php @print(getUrl('','module',$__Context->module,'act',$__Context->act));?>" class="button black"><span><?php @print($__Context->lang->cmd_cancel);?></span></a>
        </fieldset>
    </form>
</div>

<form id="fo_list" action="./" method="get" onsubmit="return procFilter(this, delete_checked)">
<input type="hidden" name="page" value="<?php @print($__Context->page);?>" />

<!-- 모듈 선택 -->
<div class="fr">
    <a href="<?php @print(getUrl('','module','module','act','dispModuleSelectList','id','target_module','type','single'));?>" onclick="popopen(this.href,'ModuleSelect');return false;" class="button green"><span><?php @print($__Context->lang->cmd_find_module);?></span></a>
    <a href="<?php @print(getUrl('','module','document','act','dispDocumentManageDocument'));?>" onclick="popopen(this.href,'manageDocument'); return false;" class="button blue"><span><?php @print($__Context->lang->cmd_manage_document);?></span></a>
</div>

<!-- 목록 -->
<table cellspacing="0" class="rowTable clear">
<caption>Total <?php @print(number_format($__Context->total_count));?>, Page <?php @print(number_format($__Context->page));?>/<?php @print(number_format($__Context->total_page));?></caption>
<thead>
    <tr>
        <th scope="col"><div><?php @print($__Context->lang->no);?></div></th>
        <th scope="col"><div><input type="checkbox" onclick="XE.checkboxToggleAll({ doClick:true }); return false;" /></div></th>
        <th scope="col" class="wide"><div><?php @print($__Context->lang->document);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->nick_name);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->readed_count);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->voted_count);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->date);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->ipaddress);?></div></th>
        <th scope="col"><div><?php @print($__Context->lang->alias);?></div></th>
    </tr>
</thead>
<tbody>
    <?php $__Context->Context->__idx[1]=0;if(count($__Context->document_list))  foreach($__Context->document_list as $__Context->no => $__Context->oDocument){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
    <tr>
        <td class="number center"><?php @print($__Context->no);?></td>
        <td class="center"><input type="checkbox" name="cart" value="<?php @print($__Context->oDocument->document_srl);?>" onclick="doAddDocumentCart(this)" <?php  if($__Context->oDocument->isCarted()){ ?>checked="checked"<?php  } ?>/></td>
        <td class="left subject">
            <?php  if($__Context->oDocument->get('module_srl') != 0){ ?>
                <?php  if($__Context->oDocument->get('module_srl')==$__Context->oDocument->get('member_srl')){ ?>
                    <?php @print($__Context->lang->cmd_save);?>
                <?php  }else{ ?>
                    <a href="<?php @print(getUrl('','document_srl',$__Context->oDocument->document_srl));?>" onclick="window.open(this.href);return false"><?php @print($__Context->oDocument->getTitle());?></a>
                <?php  } ?>
            <?php  }else{ ?>
                [<?php @print($__Context->lang->in_trash);?>] <?php @print($__Context->oDocument->getTitle());?>
            <?php  } ?>

            <?php  if($__Context->oDocument->getCommentCount()){ ?>
                [<?php @print($__Context->oDocument->getCommentCount());?>]
            <?php  } ?>

            <?php  if($__Context->oDocument->getTrackbackCount()){ ?>
                [<?php @print($__Context->oDocument->getTrackbackCount());?>]
            <?php  } ?>
        </td>
        <td class="nowrap"><span class="member_<?php @print($__Context->oDocument->get('member_srl'));?>"><?php @print($__Context->oDocument->getNickName());?></span></td>
        <td class="number center"><?php @print($__Context->oDocument->get('readed_count'));?></td>
        <td class="number center"><?php @print($__Context->oDocument->get('voted_count'));?> / <?php @print($__Context->oDocument->get('blamed_count'));?></td>
        <td class="date center nowrap"><?php @print($__Context->oDocument->getRegdate("Y-m-d H:i:s"));?></td>
        <td class="number center nowrap"><a href="<?php @print(getUrl('search_target','ipaddress','search_keyword',$__Context->oDocument->get('ipaddress')));?>"><?php @print($__Context->oDocument->get('ipaddress'));?></a></td>
        <td class="center"><a href="<?php @print(getUrl('act','dispDocumentAdminAlias','document_srl',$__Context->oDocument->document_srl));?>"><?php @print($__Context->lang->alias);?></a>
    </tr>
    <?php  } ?>
</tbody>
</table>

</form>

<!-- 페이지 네비게이션 -->
<div class="pagination a1">
    <a href="<?php @print(getUrl('page','','module_srl',$__Context->module_srl));?>" class="prevEnd"><?php @print($__Context->lang->first_page);?></a> 
    <?php  while($__Context->page_no = $__Context->page_navigation->getNextPage()){ ?>
        <?php  if($__Context->page == $__Context->page_no){ ?>
            <strong><?php @print($__Context->page_no);?></strong> 
        <?php  }else{ ?>
            <a href="<?php @print(getUrl('page',$__Context->page_no,'module_srl',$__Context->module_srl));?>"><?php @print($__Context->page_no);?></a> 
        <?php  } ?>
    <?php  } ?>
    <a href="<?php @print(getUrl('page',$__Context->page_navigation->last_page,'module_srl',$__Context->module_srl));?>" class="nextEnd"><?php @print($__Context->lang->last_page);?></a>
</div>
