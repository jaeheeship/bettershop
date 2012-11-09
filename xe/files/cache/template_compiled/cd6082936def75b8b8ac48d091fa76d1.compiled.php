<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','__header.html');
?>


<?php @$__Context->not_adopted_post_count=$__Context->oBodex->getNotAdoptedPostCount();
    $__Context->my_member_point=$__Context->oBodex->getMemberPoint();

    $__Context->oDocument = $__Context->oBodex->getWith($__Context->oDocument, array('category_srl','email_address','homepage','title_color','title_bold','reward_point','module_srl','member_srl','nick_name'));;?>

<form action="./" method="post" onsubmit="return procFilter(this, insert)" id="fo_write">
<input type="hidden" name="mid" value="<?php @print($__Context->mid);?>" />
<input type="hidden" name="document_srl" value="<?php @print($__Context->document_srl);?>" />

    <div name="_col_sc_1" class="exWriteHeader">
        <?php  if($__Context->module_info->use_category!= 'N'){ ?>
            <select name="category_srl" class="category exISt">
                <?php if($__Context->module_info->category_total_caption) { ?><option value=""><?php @print($__Context->module_info->category_total_caption);?></option><?php } ?>
                <?php if(count($__Context->category_list )) { foreach($__Context->category_list  as $__Context->val ) { ?><?php if($__Context->val->grant) { ?><option value="<?php @print($__Context->val->category_srl);?>"<?php if(($__Context->val->grant&&$__Context->val->selected)||($__Context->oDocument->category_srl && $__Context->val->category_srl==$__Context->oDocument->category_srl)) {?> selected="selected"<?php }?>>
                    <?php @print(str_repeat("&nbsp;&nbsp;",$__Context->val->depth));?> <?php @print($__Context->val->title);?> (<?php @print($__Context->val->document_count);?>)
                </option><?php } ?><?php } } ?>
            </select>
        <?php  }else{ ?>
            <label class="title"><?php @print($__Context->lang->title);?></label>
        <?php  } ?>
        <?php if($__Context->module_info->document_default_title) { ?>
            <?php @$__Context->module_info->document_default_title = preg_replace(array('/%MID%/','/%LOGIN%/','/%URL%/'),array($__Context->mid,($__Context->logged_info?$__Context->logged_info->nick_name:$__Context->lang->visitor),getFullUrl('','mid',$__Context->mid)),$__Context->module_info->document_default_title);?>
        <?php } ?>
        <?php  if($__Context->module_info->display_title_writer!='N'){ ?>
        <input type="text" name="title" maxlength="250" class="title exISt" value="<?php @print(($__Context->document_srl)?htmlspecialchars($__Context->oDocument->getTitleText()):htmlspecialchars($__Context->module_info->document_default_title));?>" />
        <?php  }elseif($__Context->module_info->document_default_title){ ?>
        <input type="hidden" name="title" value="<?php @print(htmlspecialchars($__Context->module_info->document_default_title));?>" />
        <?php  } ?>
    </div>

    <div class="exWrite">
        <?php if(!$__Context->is_logged) { ?><div class="exWtIfo">
            <label for="userName"><?php @print($__Context->lang->writer);?></label>
            <input type="text" maxlength="20" name="nick_name" value="<?php @print($__Context->oDocument->getNickName());?>" class="userName exISt" id="userName"/>

            <label for="userPw"><?php @print($__Context->lang->password);?></label>
            <input type="password" name="password" value="" id="userPw" class="userPw exISt" />

            <label for="emailAddress"><?php @print($__Context->lang->email_address);?></label>
            <input type="text" name="email_address" value="<?php @print(htmlspecialchars($__Context->oDocument->email_address));?>" id="emailAddress" class="emailAddress exISt"/>

            <label for="homePage"><?php @print($__Context->lang->homepage);?></label>
            <input type="text" name="homepage" value="<?php @print(htmlspecialchars($__Context->oDocument->homepage));?>" id="homePage" class="homePage exISt"/>
        </div><?php } ?>

        <?php  if($__Context->is_logged && $__Context->module_info->use_reward && $__Context->module_info->use_reward != 'N'){ ?>
            <?php @$__Context->w_reward_point_list = explode(',',$__Context->module_info->use_reward_value);
                $__Context->w_is_disabled = ($__Context->module_info->use_allow_view != 'P' && $__Context->module_info->use_allow_down != 'P');

                $__Context->w_check_member_point = ($__Context->w_is_disabled && $__Context->module_info->use_reward == 'Y')?0:($__Context->w_reward_point_list[0]>0?$__Context->w_reward_point_list[0]:0);
                $__Context->w_reward_point_val = ($__Context->w_is_disabled && $__Context->module_info->use_reward == 'R')? '' : '0';
                $__Context->w_is_disabled = !$__Context->is_logged || $__Context->my_member_point < $__Context->w_check_member_point || ($__Context->w_is_disabled && $__Context->oDocument->get('comment_count') > 0 && $__Context->oDocument->reward_point > 0);;?>

            <div class="exWtPoint">
                <div class="reward_point">
                    <select name="reward_point" class="category exISt">
                        <?php  if($__Context->w_is_disabled){ ?>
                            <?php  if(!$__Context->is_logged){ ?>
                                <option value="<?php @print($__Context->w_reward_point_val);?>" selected="selected"><?php @print($__Context->lang->cmd_reward);?>: <?php @print($__Context->lang->msg_please_login);?></option>
                            <?php  }elseif($__Context->my_member_point < $__Context->w_check_member_point){ ?>
                                <option value="<?php @print($__Context->w_reward_point_val);?>" selected="selected"><?php @print($__Context->lang->msg_not_enough_point);?></option>
                            <?php  }elseif($__Context->oDocument->reward_point || $__Context->oDocument->isExists()){ ?>
                                <option value="<?php @print($__Context->oDocument->reward_point ? $__Context->oDocument->reward_point:'0');?>" selected="selected">
                                <?php @print($__Context->lang->cmd_reward);?>: <?php @print($__Context->oDocument->reward_point ? $__Context->oDocument->reward_point:'0');?>
                                </option>
                            <?php  } ?>
                        <?php  }else{ ?>
                            <?php  if($__Context->oDocument->reward_point > 0 && $__Context->oDocument->isExists()){ ?>
                                <option value="<?php @print($__Context->oDocument->reward_point);?>">
                                <?php @print($__Context->lang->cmd_reward);?>: <?php @print($__Context->oDocument->reward_point);?>
                                </option>
                            <?php  }else{ ?>
                                <option value="<?php @print($__Context->oDocument->reward_point ? $__Context->oDocument->reward_point:$__Context->w_reward_point_val);?>">
                                <?php @print($__Context->lang->my_point);?>/<?php @print($__Context->my_member_point ? $__Context->my_member_point : '0');?>
                                </option>
                            <?php  } ?>

                            <?php if($__Context->module_info->use_reward == 'Y') { ?><option value="0">0</option><?php } ?>
                            <?php if(count($__Context->w_reward_point_list )) { foreach($__Context->w_reward_point_list  as $__Context->val ) { ?><?php if($__Context->my_member_point >= $__Context->val) { ?><option value="<?php @print($__Context->val);?>"><?php @print($__Context->val);?></option><?php } ?><?php } } ?>
                        <?php  } ?>
                    </select>
                    <?php if(($__Context->module_info->use_allow_view != 'P' && $__Context->module_info->use_allow_down != 'P')&&$__Context->not_adopted_post_count>0) { ?><span class="bodex_9<?php @print($__Context->oDocument->module_srl);?> button <?php @print($__Context->btn_class);?>"><input type="button" value="<?php @print($__Context->lang->cmd_search_not_adopt_post.' ('.$__Context->not_adopted_post_count.')');?>" /></span><?php } ?>
                    <p class="info"><?php @print($__Context->module_info->use_allow_down == 'P'?($__Context->lang->about_download_point.' ('.(($__Context->module_info->use_down_point_always=='Y')?$__Context->lang->use_down_point_always:$__Context->lang->use_down_point_one).')'):$__Context->lang->about_reward_point);?></p>
                </div>
            </div>
        <?php  }else{ ?>
            <input type="hidden" name="reward_point" value="0" />
        <?php  } ?>

        <dl class="option">
            <?php if($__Context->grant->manager) { ?>
                <?php @$__Context->w_color = array('555555','222288','226622','2266EE','8866CC','88AA66','EE2222','EE6622','EEAA22','EEEE22');?>
                <dd><select class="exISt" name="title_color" id="title_color"<?php if($__Context->oDocument->title_color) {?> style="background-color:#<?php @print($__Context->oDocument->title_color);?>;"<?php }?> onchange="this.style.backgroundColor=this.options[this.selectedIndex].style.backgroundColor;">
                        <option value="" style="background-color:#FFFFFF;"><?php @print($__Context->lang->title_color);?></option>
                        <?php if(count($__Context->w_color )) { foreach($__Context->w_color  as $__Context->w_col ) { ?><option value="<?php @print($__Context->w_col);?>" style="background-color:#<?php @print($__Context->w_col);?>"<?php if($__Context->oDocument->title_color==$__Context->w_col) {?> selected="selected"<?php }?>><?php @print($__Context->lang->title_color);?></option><?php } } ?>
                    </select></dd>
                <dd>
                    <input type="checkbox" name="title_bold" id="title_bold" value="Y"<?php if($__Context->oDocument->title_bold=='Y') {?> checked="checked"<?php }?> />
                    <label for="title_bold"><?php @print($__Context->lang->title_bold);?></label>
                </dd>
                <dd>
                    <input type="checkbox" name="is_notice" value="Y"<?php if($__Context->oDocument->isNotice()) {?> checked="checked"<?php }?> id="is_notice" />
                    <label for="is_notice"><?php @print($__Context->lang->notice);?></label>
                </dd>
                <dd>
                    <input type="checkbox" name="lock_comment" value="Y" id="lock_comment"<?php if($__Context->oDocument->isLocked()) {?> checked="checked"<?php }?> />
                    <label for="lock_comment"><?php @print($__Context->lang->lock_comment);?></label>
                </dd>
            <?php } ?>
            <dd>
                <input type="checkbox" name="notify_message" value="Y" id="notify_message"<?php if($__Context->oDocument->useNotify()) {?> checked="checked"<?php }?> />
                <label for="notify_message"><?php @print($__Context->lang->notify);?></label>
            </dd>
            <?php  if($__Context->grant->manager || $__Context->module_info->use_secret=='Y'){ ?>
                <dd>
                    <input type="checkbox" name="is_secret" value="Y" id="is_secret"<?php if($__Context->oDocument->isSecret()||(!$__Context->document_srl && $__Context->module_info->use_secret=='R')) {?> checked="checked"<?php }?> />
                    <label for="is_secret"><?php @print($__Context->lang->secret);?></label>
                </dd>
            <?php  }elseif($__Context->module_info->use_secret=='R'){ ?>
                <input type="hidden" name="is_secret" value="Y" />
            <?php  } ?>
            <?php  if($__Context->grant->manager || $__Context->module_info->use_anonymous=='Y'){ ?>
                <dd>
                    <input type="checkbox" name="is_anonymous" value="Y" id="is_anonymous"<?php if(((($__Context->oDocument->get('member_srl') && $__Context->oDocument->get('user_id') == 'anonymous') || ($__Context->oDocument->get('member_srl') < 1)) && $__Context->oDocument->get('nick_name') == 'anonymous') || (!$__Context->document_srl && $__Context->module_info->use_anonymous=='R')) {?> checked="checked"<?php }?> />
                    <label for="is_anonymous"><?php @print($__Context->lang->anonymous);?></label>
                </dd>
            <?php  }elseif($__Context->module_info->use_anonymous=='R'){ ?>
                <input type="hidden" name="is_anonymous" value="Y" />
            <?php  } ?>
            <?php  if($__Context->grant->manager || $__Context->module_info->use_allow_comment=='Y'){ ?>
                <dd>
                    <input type="checkbox" name="allow_comment" value="Y" id="allow_comment"<?php if(($__Context->document_srl&&$__Context->oDocument->allowComment())||(!$__Context->document_srl&&$__Context->module_info->use_allow_comment!='N')) {?> checked="checked"<?php }?> />
                    <label for="allow_comment"><?php @print($__Context->lang->allow_comment);?></label>
                </dd>
            <?php  }else{ ?>
                <input type="hidden" name="allow_comment" value="Y" />
            <?php  } ?>
            <?php  if($__Context->grant->manager || $__Context->module_info->use_allow_trackback=='Y'){ ?>
                <dd>
                    <input type="checkbox" name="allow_trackback" value="Y" id="allow_trackback"<?php if(($__Context->document_srl&&$__Context->oDocument->allowTrackback())||(!$__Context->document_srl&&$__Context->module_info->use_allow_trackback!='N')) {?> checked="checked"<?php }?> />
                    <label for="allow_trackback"><?php @print($__Context->lang->allow_trackback);?></label>
                </dd>
            <?php  }else{ ?>
                <input type="hidden" name="allow_trackback" value="Y" />
            <?php  } ?>
        </dl>

        <?php if(count($__Context->extra_keys)) { ?><table cellspacing="0" summary="" class="extVLst">
        <col width="150px" />
        <col />
            <?php if(count($__Context->extra_keys )) { foreach($__Context->extra_keys  as $__Context->key => $__Context->val) { ?><tr>
                <th scope="row"><?php @print($__Context->val->name);?><?php @print(($__Context->val->is_required=='Y')?'*':'');?></th>
                <?php  if($__Context->val->eid=='writer_display_ccl'){ ?>
                    <?php @$__Context->writer_display_ccl = explode('|@|',$__Context->val->value);?>
                    <td><ul>
                            <li><input type="checkbox" value="attribution" name="extra_vars<?php @print($__Context->val->idx);?>" id="extra_vars_<?php @print($__Context->val->idx);?>_1"<?php if(!$__Context->oDocument->isExists()||in_array('attribution', $__Context->writer_display_ccl)) {?> checked="checked"<?php }?> /><label for="extra_vars_<?php @print($__Context->val->idx);?>_1"><?php @print($__Context->lang->ccl->attribution);?></label></li>
                            <li><input type="checkbox" value="commercial" name="extra_vars<?php @print($__Context->val->idx);?>" id="extra_vars_<?php @print($__Context->val->idx);?>_2"<?php if(in_array('commercial', $__Context->writer_display_ccl)) {?> checked="checked"<?php }?> /><label for="extra_vars_<?php @print($__Context->val->idx);?>_2"><?php @print($__Context->lang->ccl->commercial);?></label></li>
                            <li><input type="checkbox" value="derivatives" name="extra_vars<?php @print($__Context->val->idx);?>" id="extra_vars_<?php @print($__Context->val->idx);?>_3"<?php if(in_array('derivatives', $__Context->writer_display_ccl)) {?> checked="checked"<?php }?> /><label for="extra_vars_<?php @print($__Context->val->idx);?>_3"><?php @print($__Context->lang->ccl->derivatives);?></label></li>
                            <li><input type="checkbox" value="sharealike" name="extra_vars<?php @print($__Context->val->idx);?>" id="extra_vars_<?php @print($__Context->val->idx);?>_4"<?php if(!$__Context->oDocument->isExists()||in_array('sharealike', $__Context->writer_display_ccl)) {?> checked="checked"<?php }?> /><label for="extra_vars_<?php @print($__Context->val->idx);?>_4"><?php @print($__Context->lang->ccl->sharealike);?></label></li>
                        </ul><p><?php @print($__Context->val->desc);?></p>
                    </td>
                <?php  }else{ ?>
                    <td><?php @print($__Context->val->getFormHTML());?></td>
                <?php  } ?>
            </tr><?php } } ?>
        </table><?php } ?>

        <?php if($__Context->module_info->display_content_writer!='N') { ?>
            <?php if($__Context->module_info->document_default_text) { ?>
                <?php @$__Context->module_info->document_default_text = preg_replace(array('/%MID%/','/%LOGIN%/','/%URL%/'),array($__Context->mid,($__Context->logged_info?$__Context->logged_info->nick_name:$__Context->lang->visitor),getFullUrl('','mid',$__Context->mid)),$__Context->module_info->document_default_text);?>
            <?php } ?>
            <input type="hidden" name="content" value="<?php @print((!$__Context->oDocument->isExists()&&$__Context->module_info->document_default_text)?htmlspecialchars($__Context->module_info->document_default_text):$__Context->oDocument->getContentText());?>" />
            <div class="editor"><?php @print($__Context->oDocument->getEditor());?></div>

            <?php if($__Context->module_info->display_link_input!='N') { ?><div class="tag fileLink">
                <input type="hidden" name="editor_sequence_srl" value="<?php @print(Context::get('editor_sequence'));?>"  class="exISt" />
                <input type="text" name="filelink_url" class="exISt" />
                <span class="button <?php @print($__Context->btn_class);?>">
                    <input type="button" value="<?php @print($__Context->lang->cmd_file_link);?>"  onclick="return procFilter(xGetElementById('fo_write'), insert_filelink);" />
                </span>
                <a class="button <?php @print($__Context->btn_class);?>" title="<?php @print($__Context->lang->cmd_get_images);?>" onclick="_exJcPopImageList(); return false;">
                    <span><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/iconAllImgs.gif" border="0" /></span>
                </a>
                <p class="info"><?php @print($__Context->lang->about_file_link);?></p>
            </div><?php } ?>
        <?php } ?>

        <?php if($__Context->module_info->display_tag_input!='N') { ?><div class="tag">
            <input type="text" name="tags" maxlength="500" class="exISt" value="<?php @print(htmlspecialchars($__Context->oDocument->get('tags')));?>" />
            <a class="button <?php @print($__Context->btn_class);?>" title="<?php @print($__Context->lang->cmd_get_tags);?>" onclick="_exJcPopTagList(); return false;">
            <span><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/iconAllTags.gif" border="0" /></span>
            </a>
            <p class="info"><?php @print($__Context->lang->about_tag);?></p>
        </div><?php } ?>
    </div>

    <div class="fl gap1">
        <?php if($__Context->is_logged) { ?>
            <span class="button <?php @print($__Context->btn_class);?>"><input type="button" value="<?php @print($__Context->lang->cmd_temp_save);?>"  onclick="doDocumentSave(this); return false;" /></span>
            <span class="button <?php @print($__Context->btn_class);?>"><input type="button" value="<?php @print($__Context->lang->cmd_load);?>"  onclick="doDocumentLoad(this); return false;" /></span>
        <?php } ?>
        <span class="button <?php @print($__Context->btn_class);?>"><input type="button" value="<?php @print($__Context->lang->cmd_preview);?>" onclick="doDocumentPreview(this); return false;" /></span>
    </div>

    <div class="fr gap1">
        <span class="button <?php @print($__Context->btn_class);?>"><input type="button" value="<?php @print($__Context->lang->cmd_back);?>" onclick="location.href='<?php @print(getUrl('act',''));?>'" /></span>
        <span class="button black"><input type="submit" value="<?php @print($__Context->lang->cmd_registration);?>" accesskey="s" /></span>
    </div>

</form>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','__footer.html');
?>

