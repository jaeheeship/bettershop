<?php if(!defined("__ZBXE__")) exit();?><?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/bodex/tpl/filter/","insert_bodex.xml");
$__Context->oXmlFilter->compile();
?>

<!--#Meta:./modules/bodex/tpl/js/bodex_admin.js--><?php Context::addJsFile("./modules/bodex/tpl/js/bodex_admin.js", true, "", null, "head"); ?>
<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/tpl/','header.html');
?>

<!--#Meta:./modules/bodex/tpl/css/bodex.css--><?php Context::addCSSFile("./modules/bodex/tpl/css/bodex.css", true, "all", "", null); ?>

<form action="./" method="post" onsubmit="return procFilter(this, insert_bodex)" enctype="multipart/form-data">
<input type="hidden" name="page" value="<?php @print($__Context->page);?>" />
<input type="hidden" name="module_srl" value="<?php @print($__Context->module_info->module_srl);?>" />

    <?php  if($__Context->logged_info->is_admin!='Y'){ ?>
    <input type="hidden" name="mid" value="<?php @print($__Context->module_info->mid);?>" />
    <input type="hidden" name="module_category_srl" value="<?php @print($__Context->module_info->module_category_srl);?>" />
    <input type="hidden" name="layout_srl" value="<?php @print($__Context->module_info->layout_srl);?>" />
    <?php  }else{ ?>
    <h4 class="xeAdmin"><?php @print($__Context->lang->module);?></h4>
    <table cellspacing="0" class="rowTable">

    <tr>
        <th scope="row"><div><?php @print($__Context->lang->mid);?></div></th>
        <td class="wide">
            <input type="text" name="mid" value="<?php @print($__Context->module_info->mid);?>" class="inputTypeText w200" />
            <p><?php @print($__Context->lang->about_mid);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->module_category);?></div></th>
        <td class="wide">
            <select name="module_category_srl">
                <option value="0"><?php @print($__Context->lang->notuse);?></option>
                <?php $__Context->Context->__idx[0]=0;if(count($__Context->module_category))  foreach($__Context->module_category as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->module_info->module_category_srl==$__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?></option>
                <?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_module_category);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_load_extra_vars);?></div></th>
        <td class="wide">
            <select name="use_load_extra_vars">
                <option value="Y" <?php  if($__Context->module_info->use_load_extra_vars == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_load_extra_vars != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <p><?php @print($__Context->lang->about_load_extra_vars);?></p>
        </td>
    </tr>
    </table>
    <?php  } ?>

    <h4 class="xeAdmin"><?php @print($__Context->lang->skin);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->layout);?></div></th>
        <td class="wide">
            <select name="layout_srl">
            <option value="0"><?php @print($__Context->lang->notuse);?></option>
            <?php $__Context->Context->__idx[1]=0;if(count($__Context->layout_list))  foreach($__Context->layout_list as $__Context->key => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
            <option value="<?php @print($__Context->val->layout_srl);?>" <?php  if($__Context->module_info->layout_srl==$__Context->val->layout_srl){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?> (<?php @print($__Context->val->layout);?>)</option>
            <?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_layout);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->skin);?></div></th>
        <td class="wide">
            <select name="skin">
                <?php @$__Context->is_skin=false;?>
                <?php $__Context->Context->__idx[2]=0;if(count($__Context->skin_list))  foreach($__Context->skin_list as $__Context->key=>$__Context->val){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->module_info->skin==$__Context->key){ ?>selected="selected" <?php @$__Context->is_skin=true;?><?php  } ?>><?php @print($__Context->val->title);?></option>
                <?php  } ?>
                <?php  if(!$__Context->is_skin){ ?><option value="" selected="selected"><?php @print($__Context->lang->notuse);?></option><?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_skin);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->browser_title);?></div></th>
        <td class="wide">
            <input type="text" name="browser_title" value="<?php @print(htmlspecialchars($__Context->module_info->browser_title));?>"  class="inputTypeText w400" id="browser_title"/>
            <a href="<?php @print(getUrl('','module','module','act','dispModuleAdminLangcode','target','browser_title'));?>" onclick="popopen(this.href);return false;" class="buttonSet buttonSetting"><span><?php @print($__Context->lang->cmd_find_langcode);?></span></a>
            <p><?php @print($__Context->lang->about_browser_title);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->count);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->list_count);?></div></th>
        <td class="wide">
            <input type="text" name="list_count" value="<?php @print($__Context->module_info->list_count?$__Context->module_info->list_count:20);?>"  class="inputTypeText" />
            <p><?php @print($__Context->lang->about_list_count);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->search_list_count);?></div></th>
        <td class="wide">
            <input type="text" name="search_list_count" value="<?php @print($__Context->module_info->search_list_count?$__Context->module_info->search_list_count:20);?>"  class="inputTypeText" />
            <p><?php @print($__Context->lang->about_search_list_count);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->page_count);?></div></th>
        <td class="wide">
            <input type="text" name="page_count" value="<?php @print($__Context->module_info->page_count?$__Context->module_info->page_count:10);?>"  class="inputTypeText" />
            <p><?php @print($__Context->lang->about_page_count);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->sort);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->order_target);?></div></th>
        <td class="wide">
            <select name="order_target">
                <?php $__Context->Context->__idx[3]=0;if(count($__Context->order_target))  foreach($__Context->order_target as $__Context->key => $__Context->val){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->module_info->order_target == $__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
                <?php  } ?>
            </select>

        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->order_type);?></div></th>
        <td class="wide">
            <select name="order_type">
                <option value="asc" <?php  if($__Context->module_info->order_type != 'desc'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->order_asc);?></option>
                <option value="desc" <?php  if($__Context->module_info->order_type == 'desc'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->order_desc);?></option>
            </select>
            <p><?php @print($__Context->lang->about_order_target);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->display);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->except_notice);?></div></th>
        <td class="wide">
            <select name="except_notice">
                <option value="Y" <?php  if($__Context->module_info->except_notice != 'N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->except_notice == 'N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <p><?php @print($__Context->lang->about_except_notice);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_category);?></div></th>
        <td class="wide">
            <select name="use_category">
                <option value="N" <?php  if($__Context->module_info->use_category=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_category=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_cat_comb);?></option>
                <option value="T" <?php  if($__Context->module_info->use_category=='T'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_cat_tab);?></option>
                <option value="L" <?php  if($__Context->module_info->use_category=='L'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_cat_left);?></option>
                <option value="R" <?php  if($__Context->module_info->use_category=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_cat_right);?></option>
            </select>
            <p><?php @print($__Context->lang->about_use_category);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->display_extra_images);?></div></th>
        <td class="wide">
            <?php @$__Context->display_extra_images=array_flip(explode('|@|',$__Context->module_info->display_extra_images));?>
            <input type="hidden" name="display_extra_images[]" value="none" checked="checked" />
            <label><input type="checkbox" name="display_extra_images[]" value="new" <?php  if(!isset($__Context->display_extra_images['none']) || $__Context->display_extra_images['new']){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->new);?></label>
            &nbsp;<label><input type="checkbox" name="display_extra_images[]" value="update" <?php  if(!isset($__Context->display_extra_images['none']) || $__Context->display_extra_images['update']){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->update);?></label>
            &nbsp;<label><input type="checkbox" name="display_extra_images[]" value="secret" <?php  if(!isset($__Context->display_extra_images['none']) || $__Context->display_extra_images['secret']){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->secret);?></label>
            &nbsp;<label><input type="checkbox" name="display_extra_images[]" value="image" <?php  if(!isset($__Context->display_extra_images['none']) || $__Context->display_extra_images['image']){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->image);?></label>
            &nbsp;<label><input type="checkbox" name="display_extra_images[]" value="movie" <?php  if(!isset($__Context->display_extra_images['none']) || $__Context->display_extra_images['movie']){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->media);?></label>
            &nbsp;<label><input type="checkbox" name="display_extra_images[]" value="file" <?php  if(!isset($__Context->display_extra_images['none']) || $__Context->display_extra_images['file']){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->file);?></label>
            <p><?php @print($__Context->lang->about_display_extra_images);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->best.' '.$__Context->lang->document);?></div></th>
        <td class="wide">
            <select name="display_best_document">
                <option value="Y" <?php  if($__Context->module_info->display_best_document == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->display_best_document != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->notuse);?></option>
            </select>&nbsp;&nbsp;&nbsp;
            <select name="display_best_comment">
                <option value="Y" <?php  if($__Context->module_info->display_best_comment == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->display_best_comment != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->notuse);?></option>
            </select>
            <div class="useValue">
            <p><?php @print($__Context->lang->order_target);?>:
            <select name="best_sort_index">
                <option value="voted_count" <?php  if($__Context->module_info->best_sort_index=='voted_count'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->voted_count);?></option>
                <option value="readed_count" <?php  if($__Context->module_info->best_sort_index=='readed_count'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->readed_count);?></option>
                <option value="comment_count" <?php  if($__Context->module_info->best_sort_index=='comment_count'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment_count);?></option>
            </select>
            &nbsp;<label><?php @print($__Context->lang->date_range);?> (day):&nbsp;<input type="text" name="best_date_range" class="inputTypeText w60" value="<?php @print($__Context->module_info->best_date_range?$__Context->module_info->best_date_range:'7');?>" /></label>
            &nbsp;<label><?php @print($__Context->lang->list_count);?>:&nbsp;<input type="text" name="best_list_count" class="inputTypeText w60" value="<?php @print($__Context->module_info->best_list_count?$__Context->module_info->best_list_count:'2');?>" /></label>
            </p>
            </div>
            <p><?php @print($__Context->lang->about_best_document);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->use_allow);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->cmd_declare.' '.$__Context->lang->blind);?></div></th>
        <td class="wide">
            <label><?php @print($__Context->lang->document);?> : <input name="declare_blind_document" value="<?php @print($__Context->module_info->declare_blind_document);?>" class="inputTypeText w80" type="text"></label>
            &nbsp;&nbsp;<label><?php @print($__Context->lang->comment);?> : <input name="declare_blind_comment" value="<?php @print($__Context->module_info->declare_blind_comment);?>" class="inputTypeText w80" type="text"></label>
            <p><?php @print($__Context->lang->about_declare_blind);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_secret);?></div></th>
        <td class="wide">
            <select name="use_secret">
                <option value="N" <?php  if($__Context->module_info->use_secret=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_secret=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_secret=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use_require);?></option>
            </select>&nbsp;&nbsp;&nbsp;
            <select name="use_secret_comment">
                <option value="N" <?php  if($__Context->module_info->use_secret_comment=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_secret_comment=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_secret_comment=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use_require);?></option>
            </select>
            <p><?php @print($__Context->lang->about_secret);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->comment.' '.$__Context->lang->use_allow);?></div></th>
        <td class="wide">
            <select name="use_allow_comment">
                <option value="N" <?php  if($__Context->module_info->use_allow_comment=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment);?>: <?php @print($__Context->lang->use_allow_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_allow_comment!='N'&&$__Context->module_info->use_allow_comment!='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment);?>: <?php @print($__Context->lang->use_allow_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_allow_comment=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment);?>: <?php @print($__Context->lang->use_allow_require);?></option>
            </select>&nbsp;&nbsp;&nbsp;
            <select name="use_allow_trackback">
                <option value="N" <?php  if($__Context->module_info->use_allow_trackback=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->trackback);?>: <?php @print($__Context->lang->use_allow_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_allow_trackback!='N'&&$__Context->module_info->use_allow_trackback!='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->trackback);?>: <?php @print($__Context->lang->use_allow_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_allow_trackback=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->trackback);?>: <?php @print($__Context->lang->use_allow_require);?></option>
            </select>
            <p><?php @print($__Context->lang->about_allow_comment);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->document.' '.$__Context->lang->constraint);?></div></th>
        <td class="wide">
            <select name="use_allow_view" onchange="var o = jQuery('div.use_allow_view_option');this.value=='P'?o.removeClass('hide'):o.addClass('hide');">
                <option value="Y" <?php  if($__Context->module_info->use_allow_view == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.' '.$__Context->lang->use);?></option>
                <option value="P" <?php  if($__Context->module_info->use_allow_view == 'P'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->reward_point.' '.$__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_allow_view != 'Y'&&$__Context->module_info->use_allow_view != 'P'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            &nbsp;<label><?php @print($__Context->lang->char_count);?>:&nbsp;<input type="text" name="allow_view_cut_size" class="inputTypeText w60" value="<?php @print($__Context->module_info->allow_view_cut_size?$__Context->module_info->allow_view_cut_size:'500');?>" /></label>
            <div class="use_allow_view_option useValue <?php  if($__Context->module_info->use_allow_view != 'P'){ ?>hide<?php  } ?>">
                <p><?php @print($__Context->lang->about_point_view);?></p>
            </div>
            <p><?php @print($__Context->lang->about_constraint_document);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->download.' '.$__Context->lang->constraint);?></div></th>
        <td class="wide">
            <select name="use_allow_down" onchange="var o = jQuery('div.use_allow_down_option');this.value=='P'?o.removeClass('hide'):o.addClass('hide');">
                <option value="Y" <?php  if($__Context->module_info->use_allow_down == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.' '.$__Context->lang->use);?></option>
                <option value="P" <?php  if($__Context->module_info->use_allow_down == 'P'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->reward_point.' '.$__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_allow_down != 'Y'&&$__Context->module_info->use_allow_down != 'P'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <div class="use_allow_down_option useValue <?php  if($__Context->module_info->use_allow_down != 'P'){ ?>hide<?php  } ?>">
            <p><label><input type="checkbox" name="use_down_point_medias" value="Y" <?php  if($__Context->module_info->use_down_point_medias!='N'){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->use_down_point_medias);?></label>
            &nbsp;<label><input type="checkbox" name="use_down_point_images" value="Y" <?php  if($__Context->module_info->use_down_point_images=='Y'){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->use_down_point_images);?></label>
            &nbsp;<label><input type="checkbox" name="use_down_point_always" value="Y" <?php  if($__Context->module_info->use_down_point_always=='Y'){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->use_down_point_always);?></label>
            </p><p><?php @print($__Context->lang->about_point_download);?><?php @print($__Context->point_config['download_file']?' ($'.$__Context->point_config['download_file'].')':'');?></p>
            </div>
            <p><?php @print($__Context->lang->about_constraint_download);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->option);?></h4>
    <table cellspacing="0" class="rowTable">
     <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_reward);?></div></th>
        <td class="wide">
            <select name="use_reward">
                <option value="N" <?php  if($__Context->module_info->use_reward=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_reward=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_reward=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_require);?></option>
            </select>
            <div class="useValue">
            <p><input type="text" name="use_reward_value" value="<?php @print($__Context->module_info->use_reward_value?$__Context->module_info->use_reward_value:'20,40,60,80,100,200,400,600,800,1000');?>"  class="inputTypeText w400" /></p>
            <p><?php @print($__Context->lang->about_use_reward_value);?></p>
            </div>
            <p><?php @print($__Context->lang->about_use_reward);?></p>
        </td>
    </tr>
     <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_vote);?></div></th>
        <td class="wide">
            <select name="use_vote">
                <option value="N" <?php  if($__Context->module_info->use_vote=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_vote=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->cmd_vote.':'.$__Context->lang->use_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_vote=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->cmd_vote.':'.$__Context->lang->use_require);?></option>
                <option value="S" <?php  if($__Context->module_info->use_vote=='S'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->star_point.':'.$__Context->lang->use_yes);?></option>
                <option value="Z" <?php  if($__Context->module_info->use_vote=='Z'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->star_point.':'.$__Context->lang->use_require);?></option>
            </select>
            &nbsp;&nbsp;&nbsp;<span class="button"><input type="button" value="<?php @print($__Context->lang->cmd_recount_voted);?>" onclick="doRecountVoted('<?php @print($__Context->module_info->module_srl);?>','<?php @print($__Context->module_info->use_vote);?>'); return false;" /></span>
            <div class="useValue">
            <p><label><?php @print($__Context->lang->cmd_vote);?> : <?php  if($__Context->logged_info->is_admin!='Y'){ ?><?php @print($__Context->point_config['voted']);?> point<input type="hidden" name="point_voted" value="<?php @print($__Context->point_config['voted']);?>" /><?php  }else{ ?><input name="point_voted" value="<?php @print($__Context->point_config['voted']);?>" class="inputTypeText w80" type="text"><?php  } ?></label>
            &nbsp;&nbsp;<label><?php @print($__Context->lang->cmd_vote_down);?> : <?php  if($__Context->logged_info->is_admin!='Y'){ ?><?php @print($__Context->point_config['blamed']);?> point<input type="hidden" name="point_blamed" value="<?php @print($__Context->point_config['blamed']);?>" /><?php  }else{ ?><input name="point_blamed" value="<?php @print($__Context->point_config['blamed']);?>" class="inputTypeText w80" type="text"><?php  } ?></label></p>
            <p><label><input type="checkbox" name="use_vote_bonus" value="Y" <?php  if($__Context->module_info->use_vote_bonus=='Y'){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->use_vote_bonus);?></label>
            <br /><label><input type="checkbox" name="use_vote_empty" value="Y" <?php  if($__Context->module_info->use_vote_empty=='Y'){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->use_vote_empty);?></label>
            <br /><label><input type="checkbox" name="use_vote_not_checkip" value="Y" <?php  if($__Context->module_info->use_vote_not_checkip=='Y'){ ?>checked="checked"<?php  } ?> /><?php @print($__Context->lang->use_vote_not_checkip);?></label></p>
            </div>
            <p><?php @print($__Context->lang->about_use_vote);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_doc_state);?></div></th>
        <td class="wide">
            <select name="use_doc_state">
                <option value="Y" <?php  if($__Context->module_info->use_doc_state == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_doc_state != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <div class="useValue">
            <p><input type="text" name="use_doc_state_value" value="<?php @print(htmlspecialchars($__Context->module_info->use_doc_state_value?$__Context->module_info->use_doc_state_value:$__Context->lang->use_doc_state_default_value));?>"  class="inputTypeText w400" /></p>
            <p><?php @print($__Context->lang->about_use_doc_state_value);?></p>
            </div>
            <p><?php @print($__Context->lang->about_use_doc_state);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_anonymous);?></div></th>
        <td class="wide">
            <select name="use_anonymous">
                <option value="N" <?php  if($__Context->module_info->use_anonymous=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_anonymous=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_anonymous=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->document.':'.$__Context->lang->use_require);?></option>
            </select>&nbsp;&nbsp;&nbsp;
            <select name="use_anonymous_comment">
                <option value="N" <?php  if($__Context->module_info->use_anonymous_comment=='N'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use_none);?></option>
                <option value="Y" <?php  if($__Context->module_info->use_anonymous_comment=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use_yes);?></option>
                <option value="R" <?php  if($__Context->module_info->use_anonymous_comment=='R'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->comment.':'.$__Context->lang->use_require);?></option>
            </select>
            <div class="useValue">
            <p><?php @print($__Context->lang->anonymous_phase);?>: <label><input type="radio" <?php  if($__Context->module_info->use_anonymous_phase=='1'){ ?>checked="checked"<?php  } ?> name="use_anonymous_phase" value="1" />1&nbsp;</label>
            <label><input type="radio" <?php  if(!$__Context->module_info->use_anonymous_phase || $__Context->module_info->use_anonymous_phase=='2'){ ?>checked="checked"<?php  } ?> name="use_anonymous_phase" value="2" />2&nbsp;</label>
            <label><input type="radio" <?php  if($__Context->module_info->use_anonymous_phase=='3'){ ?>checked="checked"<?php  } ?> name="use_anonymous_phase" value="3" />3&nbsp;</label></p>
            <p><?php @print($__Context->lang->about_use_anonymous_phase);?></p>
            </div>
            <p><?php @print($__Context->lang->about_use_anonymous);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->consultation);?></div></th>
        <td class="wide">
            <select name="consultation">
                <option value="Y" <?php  if($__Context->module_info->consultation == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->consultation != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <p><?php @print($__Context->lang->about_consultation);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_ex_search);?></div></th>
        <td class="wide">
            <select name="use_ex_search">
                <option value="Y" <?php  if($__Context->module_info->use_ex_search == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_ex_search != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <p><?php @print($__Context->lang->about_use_ex_search);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->notify);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->notify_message_type);?></div></th>
        <td class="wide">
            <select name="notify_message_type">
                <option value="Y" <?php  if($__Context->module_info->notify_message_type=='Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->send_notify);?></option>
                <option value="M" <?php  if($__Context->module_info->notify_message_type=='M'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->send_mail);?></option>
                <option value="A" <?php  if($__Context->module_info->notify_message_type=='A'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->send_notify);?> + <?php @print($__Context->lang->send_mail);?></option>
            </select>
            <p><?php @print($__Context->lang->about_notify_message_type);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->admin_mail);?></div></th>
        <td class="wide">
            <label><?php @print($__Context->lang->recent.' '.$__Context->lang->document);?>: <input type="text" name="admin_mail" value="<?php @print($__Context->module_info->admin_mail);?>"  class="inputTypeText w400" /></label>
            <br />
            <label><?php @print($__Context->lang->recent.' '.$__Context->lang->comment);?>: <input type="text" name="admin_mail_reply" value="<?php @print($__Context->module_info->admin_mail_reply);?>"  class="inputTypeText w400" /></label>
            <p><?php @print($__Context->lang->about_admin_mail);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->auto_reply);?></div></th>
        <td class="wide">
            <textarea name="auto_reply_text" class="inputTypeTextArea fullWidth"><?php @print(htmlspecialchars($__Context->module_info->auto_reply_text));?></textarea>
            <p><?php @print($__Context->lang->about_auto_reply);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->mobile);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_mobile);?></div></th>
        <td class="wide">
            <select name="use_mobile">
                <option value="Y" <?php  if($__Context->module_info->use_mobile == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_mobile != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>&nbsp;&nbsp;&nbsp;
            <?php @print($__Context->lang->use_mobile_express);?>: <select name="use_mobile_express">
                <option value="Y" <?php  if($__Context->module_info->use_mobile_express == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_mobile_express != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <p><?php @print($__Context->lang->about_use_mobile);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->mobile_layout);?></div></th>
        <td class="wide">
            <select name="mlayout_srl">
            <option value="0"><?php @print($__Context->lang->notuse);?></option>
            <?php $__Context->Context->__idx[4]=0;if(count($__Context->mlayout_list))  foreach($__Context->mlayout_list as $__Context->key => $__Context->val){$__Context->__idx[5]=($__Context->__idx[5]+1)%2; $__Context->cycle_idx = $__Context->__idx[5]+1; ?>
            <option value="<?php @print($__Context->val->layout_srl);?>" <?php  if($__Context->module_info->mlayout_srl==$__Context->val->layout_srl){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?> (<?php @print($__Context->val->layout);?>)</option>
            <?php  } ?>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->mobile_skin);?></div></th>
        <td class="wide">
            <select name="mskin">
                <?php $__Context->Context->__idx[5]=0;if(count($__Context->mskin_list))  foreach($__Context->mskin_list as $__Context->key=>$__Context->val){$__Context->__idx[6]=($__Context->__idx[6]+1)%2; $__Context->cycle_idx = $__Context->__idx[6]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->module_info->mskin==$__Context->key ||(!$__Context->module_info->mskin && $__Context->key=='default')){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val->title);?></option>
                <?php  } ?>
            </select>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->use_mobile_doc_navigation);?></div></th>
        <td class="wide">
            <select name="use_mobile_dnav">
                <option value="Y" <?php  if($__Context->module_info->use_mobile_dnav == 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->use);?></option>
                <option value="N" <?php  if($__Context->module_info->use_mobile_dnav != 'Y'){ ?>selected="selected"<?php  } ?>><?php @print($__Context->lang->notuse);?></option>
            </select>
            <p><?php @print($__Context->lang->about_use_mobile_doc_navigation);?></p>
        </td>
    </tr>
    </table>

    <h4 class="xeAdmin"><?php @print($__Context->lang->etcetera);?></h4>
    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->description);?></div></th>
        <td class="wide">
            <textarea name="description" class="inputTypeTextArea fullWidth"><?php @print(htmlspecialchars($__Context->module_info->description));?></textarea>
            <p><?php @print($__Context->lang->about_description);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->header_text);?></div></th>
        <td class="wide">
            <textarea name="header_text" class="inputTypeTextArea fullWidth" id="header_text"><?php @print(htmlspecialchars($__Context->module_info->header_text));?></textarea>
            <a href="<?php @print(getUrl('','module','module','act','dispModuleAdminLangcode','target','header_text'));?>" onclick="popopen(this.href);return false;" class="buttonSet buttonSetting"><span><?php @print($__Context->lang->cmd_find_langcode);?></span></a>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->footer_text);?></div></th>
        <td class="wide">
            <textarea name="footer_text" class="inputTypeTextArea fullWidth" id="footer_text"><?php @print(htmlspecialchars($__Context->module_info->footer_text));?></textarea>
            <a href="<?php @print(getUrl('','module','module','act','dispModuleAdminLangcode','target','footer_text'));?>" onclick="popopen(this.href);return false;" class="buttonSet buttonSetting"><span><?php @print($__Context->lang->cmd_find_langcode);?></span></a>
            <p><?php @print($__Context->lang->about_module_text);?></p>
        </td>
    </tr>
    <tr>
        <th colspan="2" class="button">
            <span class="button black strong"><input type="submit" value="<?php @print($__Context->lang->cmd_registration);?>" accesskey="s" /></span>
            <span class="button"><input type="button" value="<?php @print($__Context->lang->cmd_back);?>" onclick="history.back(); return false;" /></span>
        </th>
    </tr>
    </table>

</form>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/tpl/','footer.html');
?>

