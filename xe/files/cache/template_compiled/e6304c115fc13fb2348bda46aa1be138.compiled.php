<?php if(!defined("__ZBXE__")) exit();?>
<table border="1" cellspacing="0" class="exList">
    <?php  if($__Context->module_info->display_list_head == 'Y'){ ?>
    <thead>
        <tr name="_col_sc_1">
            <?php if($__Context->grant->manager) { ?><th scope="col" class="checkbox"><input type="checkbox" onclick="XE.checkboxToggleAll({ doClick:true }); return false;" /></th><?php } ?>
            <?php if(count($__Context->list_config )) { foreach($__Context->list_config  as $__Context->key => $__Context->val) { ?>
                <?php  if($__Context->val->idx == -1){ ?>
                    <?php  if(in_array($__Context->val->type,array('no','nick_name','user_id','user_name', 'email_address', 'homepage', 'ipaddress','doc_state','regdate','last_update','last_updater','readed_count','voted_count','blamed_count'))){ ?>
                        <?php  if($__Context->val->type=='readed_count') $__Context->t_lang = $__Context->lang->col_read;
                            elseif($__Context->val->type=='voted_count') $__Context->t_lang = ($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z')?$__Context->lang->col_star:$__Context->lang->col_vote;
                            elseif($__Context->val->type=='blamed_count'){
                                if($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z') continue;
                                $__Context->t_lang = $__Context->lang->col_blame;
                            }else $__Context->t_lang = Context::getLang($__Context->val->type);{ ?>
                            <th scope="col" class="<?php @print($__Context->val->type);?> <?php @print($__Context->val->sort=='Y'?'sort':'');?>">
                                <?php  if($__Context->val->sort=='Y'){ ?>
                                    <a class="<?php @print(($__Context->sort_index==$__Context->val->type)?$__Context->order_type:'');?>" href="<?php @print(getUrl('sort_index',$__Context->val->type,'order_type',$__Context->order_type));?>"><?php @print($__Context->t_lang);?></a>
                                <?php  }else{ ?>
                                    <?php @print($__Context->t_lang);?>
                                <?php  } ?>
                            </th>
                        <?php  } ?>
                    <?php  }elseif($__Context->val->type == 'title'){ ?>
                        <th scope="col" class="title <?php @print($__Context->val->sort=='Y'?'sort':'');?>">
                                <?php  if($__Context->module_info->use_category == 'Y'){ ?>
                                    <div class="category">
                                        <select name="category" id="board_category" onchange="_exJcChangeCategory(); return false;" class="exISt" style="width:<?php @print($__Context->arr_category_width[0]);?>;">
                                            <?php if($__Context->module_info->category_total_caption) { ?><option value=""><?php @print($__Context->module_info->category_total_caption);?></option><?php } ?>
                                            <?php if(count($__Context->category_list )) { foreach($__Context->category_list  as $__Context->cat_val ) { ?><option value="<?php @print($__Context->cat_val->category_srl);?>"<?php if($__Context->category==$__Context->cat_val->category_srl) {?> selected="selected"<?php }?>><?php @print(str_repeat("&nbsp;&nbsp;",$__Context->cat_val->depth));?>&nbsp;<?php @print($__Context->cat_val->title.($__Context->cat_val->document_count?'&nbsp;('.$__Context->cat_val->document_count.')':''));?></option><?php } } ?>
                                        </select>
                                        &nbsp;
                                    </div>
                                <?php  }else{ ?>
                                    <?php  if($__Context->val->sort=='Y'){ ?>
                                        <a class="<?php @print(($__Context->sort_index==$__Context->val->type)?$__Context->order_type:'');?>" href="<?php @print(getUrl('sort_index',$__Context->val->type,'order_type',$__Context->order_type));?>"><?php @print($__Context->lang->title);?></a>
                                    <?php  }else{ ?>
                                        <?php @print($__Context->lang->title);?>
                                    <?php  } ?>
                                <?php  } ?>
                        </th>
                    <?php  }elseif($__Context->val->type == 'category'){ ?>
                        <?php @$__Context->is_category = true;;?>
                    <?php  } ?>
                <?php  }else{ ?>
                    <th scope="col" class="extravalue <?php @print($__Context->val->sort=='Y'?'sort':'');?>">
                        <?php  if($__Context->val->sort=='Y'){ ?>
                            <a class="<?php @print(($__Context->sort_index=='extra_vars'.$__Context->val->idx)?$__Context->order_type:'');?>" href="<?php @print(getUrl('sort_index','extra_vars'.$__Context->val->idx,'order_type',$__Context->order_type));?>"><?php @print($__Context->val->name);?></a>
                        <?php  }else{ ?>
                            <?php @print($__Context->val->name);?>
                        <?php  } ?>
                    </th>
                <?php  } ?>
            <?php } } ?>
        </tr>
    </thead>
    <?php  }else{ ?>
        <?php if(count($__Context->list_config )) { foreach($__Context->list_config  as $__Context->key => $__Context->val) { ?><?php if($__Context->val->type == 'category') { ?>
            <?php @$__Context->is_category = true;;?>
        <?php } ?><?php } } ?>
    <?php  } ?>
    <tbody>

    <?php  if(!$__Context->document_list && !$__Context->notice_list){ ?>
        <tr class="exBg0 tCenter">
            <td colspan="<?php @print($__Context->grant->manager?count($__Context->list_config)+1:count($__Context->list_config));?>" class="title">
                <?php @print($__Context->lang->no_documents);?>
            </td>
        </tr>
    <?php  }else{ ?>

        <?php if(!$__Context->is_view_document || ($__Context->is_view_document && $__Context->module_info->display_foot_list_ex == 'Y')) { ?>
            <?php if(count($__Context->notice_list )) { foreach($__Context->notice_list  as $__Context->no => $__Context->document) { ?>
                <?php @$__Context->document = $__Context->oBodex->getWith($__Context->document, array('category_srl','last_update','readed_count','voted_count','blamed_count','member_srl','reward_srl','reward_point','is_notice'));
                    $__Context->document->reward_point=round($__Context->document->reward_point/2);
                    $__Context->document->permanentUrl=getUrl('mid','','document_srl',$__Context->document->document_srl);
                    $__Context->is_grant = $__Context->grant->view && (!$__Context->document->isSecret() || $__Context->document->isGranted());
                    $__Context->doc_logged = $__Context->logged_info && (abs($__Context->logged_info->member_srl) == abs($__Context->document->member_srl));;?>
                <tr class="notice exBg1">
                    <?php if($__Context->grant->manager) { ?><td class="checkbox"><input type="checkbox" name="cart" value="<?php @print($__Context->document->document_srl);?>" onclick="doAddDocumentCart(this)"<?php if($__Context->document->isCarted()) {?> checked="checked"<?php }?> /></td><?php } ?>

                    <?php if(count($__Context->list_config )) { foreach($__Context->list_config  as $__Context->key => $__Context->val) { ?>
                        <?php  if($__Context->val->idx == -1){ ?>
                            <?php  if(in_array($__Context->val->type,array('no','user_id','nick_name','user_name', 'email_address', 'homepage', 'ipaddress','doc_state','regdate','last_update','last_updater','readed_count'))){ ?>
                                <?php  if($__Context->val->type == 'no')
                                        $__Context->l_value='<img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/'.(($__Context->document_srl == $__Context->document->document_srl)?'arrowNextB2.gif" alt="Selected"':($__Context->document->is_notice == 'Y'?'notice.gif" title="Notice" alt="Notice"':'iconBest.gif" title="Best" alt="Best"')).' border="0" />';
                                    elseif($__Context->val->type == 'user_id')
                                        $__Context->l_value=$__Context->document->getUserID();
                                    elseif($__Context->val->type == 'nick_name'){
                                        $__Context->l_value=$__Context->oBodex->cutStrEx($__Context->document->getNickName(), $__Context->module_info->nick_name_cut_size);
                                        $__Context->document->member_srl = (!$__Context->grant->manager && $__Context->document->member_srl && $__Context->document->get('user_id')=='anonymous')?0:$__Context->document->member_srl;
                                        $__Context->l_value='<div class="'.($__Context->document->member_srl?'member_'.$__Context->document->member_srl:'bodex_0'.$__Context->document->document_srl).(($__Context->document->member_srl)?($__Context->doc_logged?' logged':''):' anonym').'">'.($__Context->l_value=='anonymous'?$__Context->lang->anonymous:$__Context->l_value).'</div>';
                                    }elseif($__Context->val->type == 'user_name'){
                                        $__Context->l_value=$__Context->document->getUserName();
                                        $__Context->l_value=($__Context->l_value=='anonymous'?$__Context->lang->anonymous:$__Context->l_value);
                                    }elseif($__Context->val->type == 'doc_state')
                                        $__Context->l_value=$__Context->document->isSecret()?$__Context->lang->secret:'--';
                                    elseif($__Context->val->type == 'regdate')
                                        $__Context->l_value=$__Context->document->getRegdate('Y-m-d');
                                    elseif($__Context->val->type == 'last_update')
                                        $__Context->l_value=zdate($__Context->document->last_update,'Y-m-d H:i');
                                    elseif($__Context->val->type == 'readed_count')
                                        $__Context->l_value=($__Context->document->readed_count>0)?$__Context->document->readed_count:'&nbsp;';
                                    elseif($__Context->val->type == 'email_address'){
                                        $__Context->l_value=$__Context->document->get('email_address');
                                        $__Context->l_value=sprintf('<a href="mailto:%s">%s</a>', $__Context->l_value, $__Context->l_value);
                                    }elseif($__Context->val->type == 'homepage'){
                                        $__Context->l_value=$__Context->document->getHomepageUrl();
                                        $__Context->l_value=sprintf('<a href="%s" onclick="window.open(this.href); return false;">%s</a>', $__Context->l_value, $__Context->l_value);
                                    }elseif($__Context->val->type == 'ipaddress')
                                        $__Context->l_value=$__Context->document->getIpaddress();
                                    else $__Context->l_value= $__Context->document->get($__Context->val->type);{ ?>
                                    <td class="<?php @print($__Context->val->type);?>"><?php @print($__Context->l_value);?></td>
                                <?php  } ?>
                            <?php  }elseif($__Context->val->type == 'title'){ ?>
                                <td class="title">
                                    <?php if($__Context->module_info->display_notice_category == 'Y' && $__Context->is_category && $__Context->module_info->use_category != 'N' && $__Context->document->category_srl) { ?><span class="category"<?php if($__Context->category_list[$__Context->document->category_srl]->color != 'transparent') {?> style="color:<?php @print($__Context->category_list[$__Context->document->category_srl]->color);?>;"<?php }?>><?php @print($__Context->category_list[$__Context->document->category_srl]->title);?></span><?php } ?>

                                    <?php if($__Context->module_info->use_reward && $__Context->module_info->use_reward != 'N' && $__Context->document->reward_point > 0) { ?><span class="rePoint <?php @print(($__Context->document->reward_srl > 0 || $__Context->document->reward_point === 0)?'reAdopt':'');?>" title="<?php @print(($__Context->document->reward_srl > 0 || $__Context->document->reward_point === 0)?$__Context->lang->adopted:$__Context->lang->not_adopted);?>"><?php @print($__Context->document->reward_point);?></span><?php } ?>
                                    <a href="<?php @print($__Context->document->permanentUrl);?>"><?php @print($__Context->document->getTitle($__Context->module_info->subject_cut_size));?></a>
                                    <?php @print($__Context->oBodex->printExtraImages($__Context->document->getExtraImages($__Context->module_info->duration_new)));?>
                                    <?php @$__Context->r_count=$__Context->document->getCommentCount();
                                        $__Context->t_count=$__Context->document->getTrackbackCount();;?>
                                    <?php if($__Context->r_count || $__Context->t_count) { ?><span class="repAtbc">
                                        <?php  if($__Context->is_grant){ ?>
                                            <?php if($__Context->r_count) { ?><a href="<?php @print($__Context->document->permanentUrl);?>#comment"><span class="replies" title="Replies">[<?php @print($__Context->r_count);?>]</span></a><?php } ?>
                                            <?php if($__Context->t_count) { ?><a href="<?php @print($__Context->document->permanentUrl);?>#trackback"><span class="trackbacks" title="Trackbacks">(<?php @print($__Context->t_count);?>)</span></a><?php } ?>
                                        <?php  }else{ ?>
                                            <?php if($__Context->r_count) { ?><span class="replies" title="Replies">[<?php @print($__Context->r_count);?>]</span><?php } ?>
                                            <?php if($__Context->t_count) { ?><span class="trackbacks" title="Trackbacks">(<?php @print($__Context->t_count);?>)</span><?php } ?>
                                        <?php  } ?>
                                    </span><?php } ?>
                                </td>
                            <?php  }elseif($__Context->val->type == 'voted_count'){ ?>
                                <?php  if($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z'){ ?>
                                    <?php @$__Context->average = number_format($__Context->document->voted_count / abs($__Context->document->blamed_count),1);?>
                                    <td class="voted_count">
                                        <div class="exSPFrm small" title="<?php @print($__Context->average?$__Context->average:'0');?>/<?php @print(abs($__Context->document->blamed_count));?>">
                                            <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg1" style="width:<?php @print($__Context->average*8);?>px"></span>
                                            <i><?php @print(($__Context->average?$__Context->average:'0').'/'.(abs($__Context->document->blamed_count)));?></i>
                                        </div>
                                    </td>
                                <?php  }else{ ?>
                                    <td class="voted_count"><?php @print($__Context->document->voted_count!=0?$__Context->document->voted_count:'&nbsp;');?></td>
                                <?php  } ?>
                            <?php  }elseif($__Context->module_info->use_vote != 'S' && $__Context->module_info->use_vote != 'Z' && $__Context->val->type == 'blamed_count'){ ?>
                                <td class="blamed_count"><?php @print($__Context->document->blamed_count!=0?$__Context->document->blamed_count:'&nbsp;');?></td>
                            <?php  } ?>
                        <?php  }else{ ?>
                            <td class="extravalue">
                                <?php  if(!$__Context->is_grant && $__Context->module_info->display_secret_extravalue=='N'){ ?>
                                    <?php @print($__Context->lang->secret);?>
                                <?php  }else{ ?>
                                    <?php  if(substr($__Context->val->eid,0,13)=='writer_rating'){ ?>
                                        <?php @$__Context->writer_rating_value = (float)$__Context->document->getExtraValue($__Context->val->idx);?>
                                        <div class="exSPFrm small" title="<?php @print($__Context->writer_rating_value);?>">
                                            <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg1" style="width:<?php @print($__Context->writer_rating_value*8);?>px"></span>
                                            <i><?php @print($__Context->writer_rating_value);?></i>
                                        </div>
                                    <?php  }elseif($__Context->val->eid=='writer_display_ccl'){ ?>
                                        <?php @$__Context->writer_display_ccl = explode('|@|',$__Context->document->getExtraValue($__Context->val->idx));
                                            $__Context->ccl['attribution'] = in_array('attribution', $__Context->writer_display_ccl)?'yes':'no';
                                            $__Context->ccl['commercial'] = in_array('commercial', $__Context->writer_display_ccl)?'yes':'no';
                                            $__Context->ccl['derivatives'] = in_array('sharealike', $__Context->writer_display_ccl)?'alike':(in_array('derivatives', $__Context->writer_display_ccl)?'yes':'no');

                                            $__Context->ccl['licenses'] = ($__Context->ccl['attribution']=='yes')?'by':'';
                                            $__Context->ccl['licenses'] .= ($__Context->ccl['commercial']=='no')?'-nc':'';
                                            $__Context->ccl['licenses'] .= ($__Context->ccl['derivatives']=='no')?'-nd':'';
                                            $__Context->ccl['licenses'] .= ($__Context->ccl['derivatives']=='alike')?'-sa':'';;?>
                                        <?php if($__Context->ccl['licenses']) { ?><div class="ccl">
                                            <a href="#" onclick="winopen('http://creativecommons.org/licenses/<?php @print($__Context->ccl['licenses']);?>/3.0/deed.<?php @print($__Context->lang_type);?>','cclInfo','width=800, height=600, scrollbars=yes')">
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/ccl_attribution_<?php @print($__Context->ccl['attribution']);?>.png" border="0" title="<?php @print($__Context->lang->ccl->attribution);?>: <?php @print(Context::getLang('cmd_'.$__Context->ccl['attribution']));?>" />
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/ccl_commercial_<?php @print($__Context->ccl['commercial']);?>.png" border="0" title="<?php @print($__Context->lang->ccl->commercial);?>: <?php @print(Context::getLang('cmd_'.$__Context->ccl['commercial']));?>" />
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/ccl_derivatives_<?php @print($__Context->ccl['derivatives']);?>.png" border="0" title="<?php @print($__Context->lang->ccl->derivatives);?>: <?php @print(Context::getLang('cmd_'.$__Context->ccl['derivatives']));?>" />
                                            </a>
                                        </div><?php } ?>
                                    <?php  }else{ ?>
                                        <?php  if($__Context->val->type=='homepage'){ ?>
                                            <?php @$__Context->tmp_value = $__Context->document->getExtraValue($__Context->val->idx);?>
                                            <?php  if($__Context->tmp_value){ ?>
                                                <?php  if($__Context->tmp_value && !preg_match('/^([a-z]+):\/\//i',$__Context->tmp_value)){ ?><?php @$__Context->tmp_value = 'http://'.$__Context->tmp_value;?><?php  } ?>
                                                <a href="<?php @print($__Context->tmp_value);?>" onclick="window.open(this.href); return false;">URL</a>
                                            <?php  }else{ ?>
                                                --
                                            <?php  } ?>
                                        <?php  }elseif($__Context->val->type=='email_address'){ ?>
                                            <?php @$__Context->tmp_value = $__Context->document->getExtraValue($__Context->val->idx);?>
                                            <?php  if($__Context->tmp_value){ ?>
                                                <a href="mailto:<?php @print($__Context->tmp_value);?>">MAIL</a>
                                            <?php  }else{ ?>
                                                --
                                            <?php  } ?>
                                        <?php  }else{ ?>
                                            <?php @print($__Context->oBodex->cutStrEx($__Context->document->getExtraValueHTML($__Context->val->idx), $__Context->module_info->content_extravalue_size));?>
                                        <?php  } ?>
                                    <?php  } ?>
                                <?php  } ?>
                            </td>
                        <?php  } ?>
                    <?php } } ?>
                </tr>
            <?php } } ?>
        <?php } ?>

        <?php if(count($__Context->document_list )) { foreach($__Context->document_list  as $__Context->no => $__Context->document) { ?>
                <?php @$__Context->document = $__Context->oBodex->getWith($__Context->document, array('category_srl','last_update','readed_count','voted_count','blamed_count','member_srl','reward_srl','reward_point','is_notice'));
                    $__Context->document->reward_point=round($__Context->document->reward_point/2);
                    $__Context->document->permanentUrl=getUrl('mid','','document_srl',$__Context->document->document_srl);
                    $__Context->is_blind = (((int)$__Context->module_info->declare_blind_document > 0)?((int)$__Context->module_info->declare_blind_document<=$__Context->oBodex->getDocumentDeclaredCount($__Context->document->document_srl)):false);
                    $__Context->is_grant = !$__Context->is_blind && $__Context->grant->view && (!$__Context->document->isSecret() || $__Context->document->isGranted());
                    $__Context->doc_logged = $__Context->logged_info && (abs($__Context->logged_info->member_srl) == abs($__Context->document->member_srl));;?>
                <tr class="docList exBg0 <?php @print($__Context->module_info->use_hot_track?'exJsHotTrackBox':'');?>">
                    <?php if($__Context->grant->manager) { ?><td class="checkbox"><input type="checkbox" name="cart" value="<?php @print($__Context->document->document_srl);?>" onclick="doAddDocumentCart(this)"<?php if($__Context->document->isCarted()) {?> checked="checked"<?php }?> /></td><?php } ?>

                    <?php if(count($__Context->list_config )) { foreach($__Context->list_config  as $__Context->key => $__Context->val) { ?>
                        <?php  if($__Context->val->idx == -1){ ?>
                            <?php  if(in_array($__Context->val->type,array('no','user_id','nick_name','user_name', 'email_address', 'homepage', 'ipaddress','doc_state','regdate','last_update','last_updater','readed_count'))){ ?>
                                <?php  if($__Context->val->type == 'no')
                                        $__Context->l_value=($__Context->document_srl == $__Context->document->document_srl)?'<img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/arrowNextB2.gif" border="0" alt="Selected" />':($__Context->document->no?$__Context->document->no:$__Context->no);
                                    elseif($__Context->val->type == 'user_id')
                                        $__Context->l_value=$__Context->document->getUserID();
                                    elseif($__Context->val->type == 'nick_name'){
                                        $__Context->l_value=$__Context->oBodex->cutStrEx($__Context->document->getNickName(), $__Context->module_info->nick_name_cut_size);
                                        $__Context->document->member_srl = (!$__Context->grant->manager && $__Context->document->member_srl && $__Context->document->get('user_id')=='anonymous')?0:$__Context->document->member_srl;
                                        $__Context->l_value='<div class="'.($__Context->document->member_srl?'member_'.$__Context->document->member_srl:'bodex_0'.$__Context->document->document_srl).(($__Context->document->member_srl)?($__Context->doc_logged?' logged':''):' anonym').'">'.($__Context->l_value=='anonymous'?$__Context->lang->anonymous:$__Context->l_value).'</div>';
                                    }elseif($__Context->val->type == 'user_name'){
                                        $__Context->l_value=$__Context->document->getUserName();
                                        $__Context->l_value=($__Context->l_value=='anonymous'?$__Context->lang->anonymous:$__Context->l_value);
                                    }elseif($__Context->val->type == 'doc_state')
                                        $__Context->l_value=($__Context->module_info->use_doc_state=="Y"?($__Context->document->is_notice>0?$__Context->doc_state_list[$__Context->document->is_notice]:$__Context->doc_state_list[0]):($__Context->document->isSecret()?$__Context->lang->secret:'--'));
                                    elseif($__Context->val->type == 'regdate')
                                        $__Context->l_value=$__Context->document->getRegdate('Y-m-d');
                                    elseif($__Context->val->type == 'last_update')
                                        $__Context->l_value=zdate($__Context->document->last_update,'Y-m-d H:i');
                                    elseif($__Context->val->type == 'readed_count')
                                        $__Context->l_value=($__Context->document->readed_count>0)?$__Context->document->readed_count:'&nbsp;';
                                    elseif($__Context->val->type == 'email_address'){
                                        $__Context->l_value=$__Context->document->get('email_address');
                                        $__Context->l_value=sprintf('<a href="mailto:%s">%s</a>', $__Context->l_value, $__Context->l_value);
                                    }elseif($__Context->val->type == 'homepage'){
                                        $__Context->l_value=$__Context->document->getHomepageUrl();
                                        $__Context->l_value=sprintf('<a href="%s" onclick="window.open(this.href); return false;">%s</a>', $__Context->l_value, $__Context->l_value);
                                    }elseif($__Context->val->type == 'ipaddress')
                                        $__Context->l_value=$__Context->document->getIpaddress();
                                    else $__Context->l_value= $__Context->document->get($__Context->val->type);{ ?>
                                    <td class="<?php @print($__Context->val->type);?>"><?php @print($__Context->l_value);?></td>
                                <?php  } ?>
                            <?php  }elseif($__Context->val->type == 'title'){ ?>
                                <td class="title">
                                    <?php if($__Context->is_category && $__Context->module_info->use_category != 'N' && $__Context->document->category_srl) { ?><span class="category"<?php if($__Context->category_list[$__Context->document->category_srl]->color != 'transparent') {?> style="color:<?php @print($__Context->category_list[$__Context->document->category_srl]->color);?>;"<?php }?>><?php @print($__Context->category_list[$__Context->document->category_srl]->title);?></span><?php } ?>
                                    <?php if($__Context->module_info->use_reward && $__Context->module_info->use_reward != 'N' && $__Context->document->reward_point > 0) { ?><span class="rePoint <?php @print(($__Context->document->reward_srl > 0 || $__Context->document->reward_point === 0)?'reAdopt':'');?>" title="<?php @print(($__Context->document->reward_srl > 0 || $__Context->document->reward_point === 0)?$__Context->lang->adopted:$__Context->lang->not_adopted);?>"><?php @print($__Context->document->reward_point);?></span><?php } ?>
                                    <?php  if($__Context->is_blind && !$__Context->document->isGranted()){ ?>
                                        <span class="blind"><?php @print($__Context->lang->msg_is_blind);?></span>
                                    <?php  }else{ ?>
                                        <a class="exJsHotTrackA" href="<?php @print($__Context->document->permanentUrl);?>"><?php @print($__Context->is_blind?$__Context->lang->msg_is_blind:$__Context->document->getTitle($__Context->module_info->subject_cut_size));?></a>
                                    <?php  } ?>
                                    <?php if($__Context->module_info->display_pang_point == 'Y' || $__Context->module_info->use_mobile_express == 'Y') { ?>
                                        <?php @$__Context->arr_extra=unserialize($__Context->document->get('extra_vars'));?>
                                        <?php if($__Context->module_info->display_pang_point == 'Y' && $__Context->arr_extra && $__Context->arr_extra->ppang->d->p > 0) { ?>
                                            <?php @$__Context->pangpang_point = sprintf($__Context->lang->pang_pang, $__Context->arr_extra->ppang->d->p);?>
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/<?php @print($__Context->module_info->colorset);?>/coin.gif" title="<?php @print($__Context->pangpang_point);?>" alt="<?php @print($__Context->pangpang_point);?>" />
                                        <?php } ?>
                                        <?php if($__Context->module_info->use_mobile_express == 'Y' && $__Context->arr_extra && $__Context->arr_extra->bodex->d->mp) { ?><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/mobile.gif" title="<?php @print($__Context->lang->mobile);?>" alt="<?php @print($__Context->lang->mobile);?>" />
                                    <?php } ?><?php } ?>
                                    <?php @print($__Context->oBodex->printExtraImages($__Context->document->getExtraImages($__Context->module_info->duration_new)));?>
                                    <?php @$__Context->r_count=$__Context->document->getCommentCount();
                                        $__Context->t_count=$__Context->document->getTrackbackCount();;?>
                                    <?php if($__Context->r_count || $__Context->t_count) { ?><span class="repAtbc">
                                        <?php  if($__Context->is_grant){ ?>
                                            <?php if($__Context->r_count) { ?><a href="<?php @print($__Context->document->permanentUrl);?>#comment"><span class="replies" title="Replies">[<?php @print($__Context->r_count);?>]</span></a><?php } ?>
                                            <?php if($__Context->t_count) { ?><a href="<?php @print($__Context->document->permanentUrl);?>#trackback"><span class="trackbacks" title="Trackbacks">(<?php @print($__Context->t_count);?>)</span></a><?php } ?>
                                        <?php  }else{ ?>
                                            <?php if($__Context->r_count) { ?><span class="replies" title="Replies">[<?php @print($__Context->r_count);?>]</span><?php } ?>
                                            <?php if($__Context->t_count) { ?><span class="trackbacks" title="Trackbacks">(<?php @print($__Context->t_count);?>)</span><?php } ?>
                                        <?php  } ?>
                                    </span><?php } ?>
                                </td>
                            <?php  }elseif($__Context->val->type == 'voted_count'){ ?>
                                <?php  if($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z'){ ?>
                                    <?php @$__Context->average = number_format($__Context->document->voted_count / abs($__Context->document->blamed_count),1);?>
                                    <td class="voted_count">
                                        <div class="exSPFrm small" title="<?php @print($__Context->average?$__Context->average:'0');?>/<?php @print(abs($__Context->document->blamed_count));?>">
                                            <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->average*8);?>px"></span>
                                            <i><?php @print(($__Context->average?$__Context->average:'0').'/'.(abs($__Context->document->blamed_count)));?></i>
                                        </div>
                                    </td>
                                <?php  }else{ ?>
                                    <td class="voted_count"><?php @print($__Context->document->voted_count!=0?$__Context->document->voted_count:'&nbsp;');?></td>
                                <?php  } ?>
                            <?php  }elseif($__Context->module_info->use_vote != 'S' && $__Context->module_info->use_vote != 'Z' && $__Context->val->type == 'blamed_count'){ ?>
                                <td class="blamed_count"><?php @print($__Context->document->blamed_count!=0?$__Context->document->blamed_count:'&nbsp;');?></td>
                            <?php  } ?>

                        <?php  }else{ ?>
                            <td class="extravalue">
                                <?php  if(!$__Context->is_grant && $__Context->module_info->display_secret_extravalue=='N'){ ?>
                                    <?php @print($__Context->lang->secret);?>
                                <?php  }else{ ?>
                                    <?php  if(substr($__Context->val->eid,0,13)=='writer_rating'){ ?>
                                        <?php @$__Context->writer_rating_value = (float)$__Context->document->getExtraValue($__Context->val->idx);?>
                                        <div class="exSPFrm small" title="<?php @print($__Context->writer_rating_value);?>">
                                            <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->writer_rating_value*8);?>px"></span>
                                            <i><?php @print($__Context->writer_rating_value);?></i>
                                        </div>
                                    <?php  }elseif($__Context->val->eid=='writer_display_ccl'){ ?>
                                        <?php @$__Context->writer_display_ccl = explode('|@|',$__Context->document->getExtraValue($__Context->val->idx));
                                            $__Context->ccl['attribution'] = in_array('attribution', $__Context->writer_display_ccl)?'yes':'no';
                                            $__Context->ccl['commercial'] = in_array('commercial', $__Context->writer_display_ccl)?'yes':'no';
                                            $__Context->ccl['derivatives'] = in_array('sharealike', $__Context->writer_display_ccl)?'alike':(in_array('derivatives', $__Context->writer_display_ccl)?'yes':'no');

                                            $__Context->ccl['licenses'] = ($__Context->ccl['attribution']=='yes')?'by':'';
                                            $__Context->ccl['licenses'] .= ($__Context->ccl['commercial']=='no')?'-nc':'';
                                            $__Context->ccl['licenses'] .= ($__Context->ccl['derivatives']=='no')?'-nd':'';
                                            $__Context->ccl['licenses'] .= ($__Context->ccl['derivatives']=='alike')?'-sa':'';;?>
                                        <?php if($__Context->ccl['licenses']) { ?><div class="ccl">
                                            <a href="#" onclick="winopen('http://creativecommons.org/licenses/<?php @print($__Context->ccl['licenses']);?>/3.0/deed.<?php @print($__Context->lang_type);?>','cclInfo','width=800, height=600, scrollbars=yes')">
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/ccl_attribution_<?php @print($__Context->ccl['attribution']);?>.png" border="0" title="<?php @print($__Context->lang->ccl->attribution);?>: <?php @print(Context::getLang('cmd_'.$__Context->ccl['attribution']));?>" />
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/ccl_commercial_<?php @print($__Context->ccl['commercial']);?>.png" border="0" title="<?php @print($__Context->lang->ccl->commercial);?>: <?php @print(Context::getLang('cmd_'.$__Context->ccl['commercial']));?>" />
                                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/ccl_derivatives_<?php @print($__Context->ccl['derivatives']);?>.png" border="0" title="<?php @print($__Context->lang->ccl->derivatives);?>: <?php @print(Context::getLang('cmd_'.$__Context->ccl['derivatives']));?>" />
                                            </a>
                                        </div><?php } ?>
                                    <?php  }else{ ?>
                                        <?php  if($__Context->val->type=='homepage'){ ?>
                                            <?php @$__Context->tmp_value = $__Context->document->getExtraValue($__Context->val->idx);?>
                                            <?php  if($__Context->tmp_value){ ?>
                                                <?php  if($__Context->tmp_value && !preg_match('/^([a-z]+):\/\//i',$__Context->tmp_value)){ ?><?php @$__Context->tmp_value = 'http://'.$__Context->tmp_value;?><?php  } ?>
                                                <a href="<?php @print($__Context->tmp_value);?>" onclick="window.open(this.href); return false;">URL</a>
                                            <?php  }else{ ?>
                                                --
                                            <?php  } ?>
                                        <?php  }elseif($__Context->val->type=='email_address'){ ?>
                                            <?php @$__Context->tmp_value = $__Context->document->getExtraValue($__Context->val->idx);?>
                                            <?php  if($__Context->tmp_value){ ?>
                                                <a href="mailto:<?php @print($__Context->tmp_value);?>">MAIL</a>
                                            <?php  }else{ ?>
                                                --
                                            <?php  } ?>
                                        <?php  }else{ ?>
                                            <?php @print($__Context->oBodex->cutStrEx($__Context->document->getExtraValueHTML($__Context->val->idx), $__Context->module_info->content_extravalue_size));?>
                                        <?php  } ?>
                                    <?php  } ?>
                                <?php  } ?>
                            </td>
                        <?php  } ?>
                    <?php } } ?>
                </tr>
        <?php } } ?>
    <?php  } ?>
    </tbody>
</table>
