<?php if(!defined("__ZBXE__")) exit();?>
<?php @$__Context->oDocument = $__Context->oBodex->getWith($__Context->oDocument, array('category_srl','readed_count','voted_count','member_srl','blamed_count','reward_srl','reward_point','comment_count','is_notice'));
    $__Context->oDocument->reward_point=round($__Context->oDocument->reward_point/2);

    $__Context->oDocument->title=$__Context->oDocument->getTitle();
    $__Context->oDocument->permanentUrl = $__Context->oDocument->getPermanentUrl();
    $__Context->oDocument->member_srl = $__Context->oDocument->getMemberSrl();
    $__Context->oDocument->nickName = $__Context->oBodex->cutStrEx($__Context->oDocument->getNickName(), $__Context->module_info->nick_name_cut_size);
    $__Context->oDocument->nickName = ($__Context->oDocument->nickName=='anonymous'?$__Context->lang->anonymous:$__Context->oDocument->nickName);
    $__Context->oDocument->member_srl = (!$__Context->grant->manager && $__Context->oDocument->member_srl && $__Context->oDocument->get('user_id')=='anonymous')?0:$__Context->oDocument->member_srl;

    $__Context->oDocument->profileImage = $__Context->oDocument->getProfileImage();
    $__Context->oDocument->signature = $__Context->oDocument->getSignature();

    $__Context->is_document_secret = ($__Context->oDocument->isSecret() && !$__Context->oDocument->isGranted());
    $__Context->is_document_blind = (((int)$__Context->module_info->declare_blind_document > 0 && !$__Context->oDocument->isGranted())?((int)$__Context->module_info->declare_blind_document<=$__Context->oBodex->getDocumentDeclaredCount($__Context->oDocument->document_srl)):false);
    $__Context->is_document_logged = $__Context->logged_info && (abs($__Context->logged_info->member_srl) == abs($__Context->oDocument->member_srl));

    $__Context->is_display_image = (!$__Context->module_info->display_file_list || $__Context->module_info->display_file_list=='A'||$__Context->module_info->display_file_list=='I'||$__Context->module_info->display_file_list=='BI'||$__Context->module_info->display_file_list=='MI');
    $__Context->is_display_media = (!$__Context->module_info->display_file_list || $__Context->module_info->display_file_list=='A'||$__Context->module_info->display_file_list=='M'||$__Context->module_info->display_file_list=='BM'||$__Context->module_info->display_file_list=='MI');
    $__Context->is_display_binary = (!$__Context->module_info->display_file_list || $__Context->module_info->display_file_list=='A'||$__Context->module_info->display_file_list=='B'||$__Context->module_info->display_file_list=='BM'||$__Context->module_info->display_file_list=='BI');

    $__Context->adopted_reward_point = ($__Context->module_info->use_reward != 'N' && $__Context->oDocument->reward_point > 0)?$__Context->oDocument->reward_point:0;
    $__Context->download_file_point = abs($__Context->oBodex->getPointConfig('download_file'));
    $__Context->extra_key_list = $__Context->writer_rating_list = $__Context->writer_display_ccl = array();

    $__Context->not_allow_down = $__Context->not_allow_view = false;;?>

<?php if(count($__Context->oDocument->getExtraVars() )) { foreach($__Context->oDocument->getExtraVars()  as $__Context->key => $__Context->val) { ?>
    <?php  if(substr($__Context->val->eid,0,13) == 'writer_rating'){ ?>
        <?php @$__Context->writer_rating_list[$__Context->key] = $__Context->val;?>
    <?php  }elseif($__Context->val->eid=='writer_display_ccl'){ ?>
        <?php @$__Context->writer_display_ccl = explode('|@|',$__Context->val->value);?>
    <?php  }else{ ?>
        <?php @$__Context->extra_key_list[$__Context->key] = $__Context->val;?>
    <?php  } ?>
<?php } } ?>

<?php if($__Context->oDocument->isNotice()) { ?><?php @$__Context->grant->view = true;?><?php } ?>

<?php if($__Context->module_info->use_vote != 'N') { ?>
    <?php @$__Context->oDocument->voted_list = $__Context->oBodex->getVotedLogInfo($__Context->oDocument->document_srl, false);
        $__Context->logged_user_voted_star = $__Context->oDocument->voted_list[$__Context->logged_info->member_srl];;?>
    <?php if(!$__Context->is_logged && ($__Context->module_info->use_vote == 'R' || $__Context->module_info->use_vote == 'Z')) { ?>
        <?php @$__Context->grant->write_comment = false;?>
    <?php } ?>
<?php } ?>

<?php if(!$__Context->grant->manager && (!$__Context->is_logged || $__Context->logged_info->member_srl != abs($__Context->oDocument->member_srl))) { ?>
    <?php if($__Context->module_info->use_allow_down == 'Y' || $__Context->module_info->use_allow_view == 'Y') { ?>
        <?php @$__Context->not_allow_down = $__Context->not_allow_view = !$__Context->oBodex->isMemberComment($__Context->oDocument->document_srl);
            $__Context->not_allow_down = ($__Context->not_allow_down && $__Context->module_info->use_allow_down == 'Y');
            $__Context->not_allow_view = ($__Context->not_allow_view && $__Context->module_info->use_allow_view == 'Y');;?>
    <?php } ?>
    <?php if($__Context->module_info->use_reward != 'N' && $__Context->module_info->use_allow_view == 'P' && $__Context->oDocument->reward_point > 0) { ?>
        <?php @$__Context->not_allow_view = !$__Context->oBodex->getReadedLogInfo($__Context->oDocument->document_srl);?>
    <?php } ?>
<?php } ?>

<?php  if(!$__Context->grant->view || $__Context->is_document_secret || $__Context->is_document_blind){ ?>
    <?php @$__Context->oDocument->add('content',sprintf($__Context->lang->msg_act_not_permitted,$__Context->lang->col_read));
        $__Context->oDocument->add('allow_comment','N');
        $__Context->oDocument->add('allow_Trackback','N');
        $__Context->file_list = $__Context->extra_key_list = array();;?>
<?php  }elseif($__Context->oDocument->hasUploadedFiles() && !$__Context->is_document_secret){ ?>
    <?php @$__Context->file_list = $__Context->oBodex->getSplitFileList($__Context->oDocument->getUploadedFiles());
        $__Context->downloaded_list = ($__Context->module_info->use_down_point_always=='Y') ? array():$__Context->oBodex->getDownloadedLogInfo($__Context->oDocument->document_srl);;?>
<?php  } ?>

<div class="exRead">
    <div class="oriCnt">

        <div class="readHeader">
            <div name="_col_sc_1" class="tleAusr">

                <div class="title<?php  if($__Context->blog_style_doc_no && $__Context->grant->manager){ ?> checkbox<?php  } ?>">
                    <h4>
                        <?php  if($__Context->blog_style_doc_no && $__Context->grant->manager){ ?>
                            <input type="checkbox" name="cart" value="<?php @print($__Context->oDocument->document_srl);?>" onclick="doAddDocumentCart(this)"<?php if($__Context->oDocument->isCarted()) {?> checked="checked"<?php }?> />
                        <?php  }else{ ?>
                            <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/iconTitle.gif" border="0" alt="" />
                        <?php  } ?>
                        <a href="<?php @print(getFullUrl('','document_srl',$__Context->oDocument->document_srl,'custom_layout_path',$__Context->custom_layout_path,'custom_layout_file',$__Context->custom_layout_file));?>"><?php @print($__Context->oDocument->title);?></a>
                    </h4>
                </div>

                <?php if($__Context->module_info->display_author!='N') { ?><div class="userInfo">
                    <div class="nick_name">
                        <span class="<?php @print(($__Context->oDocument->member_srl?'member_'.$__Context->oDocument->member_srl:'bodex_0'.$__Context->oDocument->document_srl).($__Context->oDocument->member_srl?($__Context->is_document_logged?' logged':''):' anonym'));?>"><?php @print($__Context->oDocument->nickName);?></span>
                    </div>
                </div><?php } ?>
            </div>

            <div class="dayACut exBg1">
                <?php if(!$__Context->is_review) { ?>
                    <?php  if($__Context->module_info->use_vote == 'Y' || $__Context->module_info->use_vote == 'R'){ ?>
                        <div class="votedCount">
                            <?php @print($__Context->lang->voted_count);?> : <strong><?php @print($__Context->oDocument->voted_count);?> / <?php @print($__Context->oDocument->blamed_count);?></strong>
                        </div>
                    <?php  }elseif($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z'){ ?>
                        <?php @$__Context->average = number_format($__Context->oDocument->voted_count / abs($__Context->oDocument->blamed_count), 1);?>
                        <div class="exSPFrm fr" title="<?php @print($__Context->average?$__Context->average:'0');?>/<?php @print(abs($__Context->oDocument->blamed_count));?>">
                            <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->average*15);?>px">&nbsp;</span>
                        </div>
                        <div class="votedCount average"><span>(<?php @print($__Context->average?$__Context->average:'0');?>/<?php @print(abs($__Context->oDocument->blamed_count));?>)</span></div>
                    <?php  } ?>
                <?php } ?>

                <div class="readedCount"><?php @print($__Context->lang->readed_count);?> : <?php @print($__Context->oDocument->readed_count);?></div>

                <div class="date" title="<?php @print($__Context->lang->regdate);?>">
                    <strong><?php @print($__Context->oDocument->getRegdate('Y.m.d'));?></strong> (<?php @print($__Context->oDocument->getRegdate('H:i:s'));?>)
                </div>

                <?php if($__Context->oDocument->isSecret()) { ?><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/iconSecret.gif" class="secret" border="0" title="<?php @print($__Context->lang->secret);?>" />

                <?php } ?><?php if(count($__Context->writer_display_ccl)) { ?>
                    <?php @$__Context->ccl['attribution'] = in_array('attribution', $__Context->writer_display_ccl)?'yes':'no';
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
                <?php } ?>

                <?php if($__Context->module_info->use_category != 'N' && $__Context->oDocument->category_srl) { ?><div class="category" title="<?php @print($__Context->lang->category);?>">
                    <a href="<?php @print(getUrl('','mid',$__Context->mid,'category',$__Context->oDocument->category_srl));?>"<?php if($__Context->category_list[$__Context->oDocument->category_srl]->color != 'transparent') {?> style="color:<?php @print($__Context->category_list[$__Context->oDocument->category_srl]->color);?>;"<?php }?>><?php @print($__Context->category_list[$__Context->oDocument->category_srl]->title);?></a>
                </div><?php } ?>
            </div>
        </div>

        <div class="infoBox">
            <?php if($__Context->is_review) { ?><div class="exJsThumbnailFrame thumb <?php  if($__Context->module_info->thumbnail_position=='R'){ ?>thumbfr<?php  } ?>" style="width:<?php @print($__Context->module_info->thumbnail_width+4);?>px;<?php  if($__Context->module_info->thumbnail_type!='ratio'){ ?>height:<?php @print($__Context->module_info->thumbnail_height+4);?>px;<?php  } ?>">
                <?php  if($__Context->is_document_secret || $__Context->is_document_blind){ ?>
                    <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/<?php @print($__Context->is_document_blind?'blind':'secret');?>img.png" border="0" alt="<?php @print($__Context->is_document_blind?'blind':'secret');?>" title="<?php @print($__Context->is_document_blind?'blind':'secret');?>" height="<?php @print($__Context->module_info->thumbnail_height);?>" width="<?php @print($__Context->module_info->thumbnail_width);?>"/>
                <?php  }else{ ?>
                    <?php  if($__Context->oDocument->thumbnailExists($__Context->module_info->thumbnail_width, $__Context->module_info->thumbnail_height, $__Context->module_info->thumbnail_type)){ ?>
                        <img src="<?php @print($__Context->oDocument->getThumbnail($__Context->module_info->thumbnail_width, $__Context->module_info->thumbnail_height, $__Context->module_info->thumbnail_type));?>" border="0" alt="" />
                    <?php  }else{ ?>
                        <img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/noimg.png" border="0" alt="no image" title="no image" class="thumb" width="<?php @print($__Context->module_info->thumbnail_width);?>" height="<?php @print($__Context->module_info->thumbnail_height);?>" />
                    <?php  } ?>
                <?php  } ?>
            </div><?php } ?>

            <div class="extVLst">
                <?php if($__Context->is_review) { ?>
                    <a name="binaryfilelist"></a>
                    <div class="staRat">
                        <?php if(in_array($__Context->module_info->display_download_button, array('Y','V')) && ((count($__Context->file_list['image']) && $__Context->is_display_image)||(count($__Context->file_list['media']) && $__Context->is_display_media)||(count($__Context->file_list['binary']) && $__Context->is_display_binary))) { ?><div class="fr">
                            <span class="button <?php @print($__Context->btn_class);?>"><input class="exJsFileListButton" rel="<?php @print($__Context->oDocument->document_srl);?>" type="button" value="<?php @print(htmlspecialchars($__Context->module_info->download_button_caption));?>" /></span>
                        </div><?php } ?>

                        <table cellspacing="0">
                        <?php if(count($__Context->writer_rating_list )) { foreach($__Context->writer_rating_list  as $__Context->val ) { ?><tr>
                            <th><?php @print($__Context->val->name);?>:&nbsp;</th>
                            <td>
                                <?php @$__Context->val->value = (float)$__Context->val->value;?>
                                <div class="exSPFrm" title="<?php @print($__Context->val->value);?>">
                                    <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->val->value*15);?>px">&nbsp;</span>
                                </div>
                            </td>
                        </tr><?php } } ?>
                        <?php if($__Context->module_info->use_vote != 'N') { ?><tr>
                            <th><?php @print($__Context->lang->user.' '.$__Context->lang->rating);?>:&nbsp;</th>
                            <td>
                            <?php  if($__Context->module_info->use_vote == 'Y' || $__Context->module_info->use_vote == 'R'){ ?>
                                <div class="votedCount">
                                    <?php @print($__Context->lang->voted_count);?> : <strong><?php @print($__Context->oDocument->voted_count);?> / <?php @print($__Context->oDocument->blamed_count);?></strong>
                                </div>
                            <?php  }elseif($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z'){ ?>
                                <?php @$__Context->average = number_format($__Context->oDocument->voted_count / abs($__Context->oDocument->blamed_count), 1);?>
                                <div class="exSPFrm" title="<?php @print($__Context->average?$__Context->average:'0');?>/<?php @print(abs($__Context->oDocument->blamed_count));?>">
                                    <div class="fl"><span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->average*15);?>px">&nbsp;</span></div>
                                    <span class="average">(<?php @print($__Context->average?$__Context->average:'0');?>/<?php @print(abs($__Context->oDocument->blamed_count));?>)</span>
                                </div>
                            <?php  } ?>
                            </td>
                        </tr><?php } ?>
                        </table>
                    </div>
                <?php } ?>

                <?php if($__Context->oDocument->isExtraVarsExists()) { ?><table cellspacing="0"<?php if(!$__Context->is_review) {?> class="extVTbl"<?php }?>>
                <?php if(!$__Context->is_review) { ?>
                    <col width="150" />
                    <?php if(count($__Context->writer_rating_list )) { foreach($__Context->writer_rating_list  as $__Context->val ) { ?><tr>
                        <th><?php @print($__Context->val->name);?>:&nbsp;</th>
                        <td>
                            <div class="exSPFrm" title="<?php @print($__Context->val->value);?>">
                                <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->val->value*15);?>px">&nbsp;</span>
                            </div>
                        </td>
                    </tr><?php } } ?>
                <?php } ?>
                    <?php if(count($__Context->extra_key_list )) { foreach($__Context->extra_key_list  as $__Context->key => $__Context->val) { ?><tr>
                        <th><?php @print($__Context->val->name);?>:&nbsp;</th>
                        <td><?php @print($__Context->val->getValueHTML());?>&nbsp;</td>
                    </tr><?php } } ?>
                </table><?php } ?>
            </div>
        </div>

        <div class="readBody <?php  if($__Context->is_review){ ?>review<?php  } ?>">
            <div class="cntBody">

                <?php if($__Context->module_info->document_top_text) { ?>
                    <?php @print(preg_replace(array('/%MID%/','/%LOGIN%/','/%URL%/','/%TITLE%/','/%NAME%/','/%SRL%/'),array($__Context->mid,($__Context->logged_info?$__Context->logged_info->nick_name:$__Context->lang->visitor),$__Context->oDocument->permanentUrl,$__Context->oDocument->title,$__Context->oDocument->nickName,$__Context->oDocument->document_srl),$__Context->module_info->document_top_text));?>
                <?php } ?>

                <?php  if($__Context->is_document_secret || $__Context->is_document_blind){ ?>
                    <div class="exSrCnt">
                        <form action="./" method="get" onsubmit="return procFilter(this, input_password)">
                            <input type="hidden" name="mid" value="<?php @print($__Context->mid);?>" />
                            <input type="hidden" name="page" value="<?php @print($__Context->page);?>" />
                            <input type="hidden" name="document_srl" value="<?php @print($__Context->oDocument->document_srl);?>" />

                            <div class="title"><?php @print($__Context->is_document_secret?$__Context->lang->msg_is_secret:$__Context->lang->msg_is_blind);?></div>
                            <div>
                                <input type="password" name="password" id="cpw" class="userPw exISt" />
                                <span class="button <?php @print($__Context->btn_class);?>">
                                    <input type="submit" value="<?php @print($__Context->lang->cmd_input);?>" accesskey="s" />
                                </span>
                            </div>
                        </form>
                    </div>
                <?php  }else{ ?>
                    <?php  if($__Context->grant->view && !$__Context->is_document_secret){ ?>
                        <?php  if($__Context->not_allow_view){ ?>
                            <div class="exAVCnt">
                                <div class="title">
                                <?php  if($__Context->module_info->use_allow_view == 'Y'){ ?>
                                    <?php @print($__Context->lang->msg_not_allow_view.'<br />'.$__Context->lang->msg_not_allow_comment);?>
                                <?php  }else{ ?>
                                    <?php @print($__Context->lang->msg_not_allow_view);?><br />
                                    <a href="#" class="button <?php @print($__Context->btn_class);?>" onclick="return doCallModuleAction('bodex','procBoardAllowView','<?php @print($__Context->oDocument->document_srl);?>');"><span><?php @print(sprintf($__Context->lang->msg_not_allow_view_point, round($__Context->oDocument->get('reward_point')/2)));?></span></a>
                                <?php  } ?>
                                </div>
                                <div class="content">
                                <?php @print($__Context->oDocument->getContent(false));?>
                                </div>
                            </div>
                        <?php  }else{ ?>
                            <?php @print($__Context->oDocument->getContent());?>
                        <?php  } ?>
                        <?php if($__Context->is_logged && !$__Context->logged_user_voted_star && ($__Context->module_info->display_vote_button == 'A' || $__Context->module_info->display_vote_button == 'D')) { ?><div class="voteBtn">
                            <a class="button black" href="#" onclick="return _exJcCallAction('document','procDocumentVoteUp','<?php @print($__Context->oDocument->document_srl);?>');"><span><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/vote_up.gif" width="13" height="13" /><?php @print($__Context->lang->col_vote);?></span></a>
                            <a class="button black" href="#" onclick="return _exJcCallAction('document','procDocumentVoteDown','<?php @print($__Context->oDocument->document_srl);?>');"><span><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/vote_down.gif" width="13" height="13" /><?php @print($__Context->lang->col_blame);?></span></a>
                        </div><?php } ?>
                    <?php  }else{ ?>
                        <?php @$__Context->message=sprintf($__Context->lang->msg_act_not_permitted,$__Context->lang->col_read); $__Context->is_poped=1;?>
                        <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','message.html');
?>

                    <?php  } ?>
                <?php  } ?>

                <div class="clear"></div>

                <?php if($__Context->module_info->document_bottom_text) { ?>
                    <?php @print(preg_replace(array('/%MID%/','/%LOGIN%/','/%URL%/','/%TITLE%/','/%NAME%/','/%SRL%/'),array($__Context->mid,($__Context->logged_info?$__Context->logged_info->nick_name:$__Context->lang->visitor),$__Context->oDocument->permanentUrl,$__Context->oDocument->title,$__Context->oDocument->nickName,$__Context->oDocument->document_srl),$__Context->module_info->document_bottom_text));?>
                <?php } ?>

                <?php if($__Context->module_info->display_sign != 'N' && $__Context->oDocument->member_srl && ($__Context->oDocument->profileImage || $__Context->oDocument->signature)) { ?><div class="exMbSign">
                    <?php if($__Context->module_info->display_sign != 'S' && $__Context->oDocument->profileImage) { ?><div class="profile">
                        <img src="<?php @print($__Context->oDocument->profileImage);?>" alt="profile" />
                    </div><?php } ?>
                    <?php if($__Context->oDocument->signature) { ?><div class="signature"><?php @print($__Context->oDocument->signature);?></div><?php } ?>
                </div><?php } ?>

                <div class="dRIpAUrl">
                    <span class="dRUrl" title="<?php @print($__Context->lang->document_url);?>"><a onclick="return _exJcCopyClipboard(this.href);" href="<?php @print($__Context->oDocument->permanentUrl);?>"><?php @print($__Context->oDocument->permanentUrl);?></a></span>
                    <?php if($__Context->grant->manager || $__Context->module_info->display_ip_address=='Y') { ?><span class="dRIp">(<?php @print($__Context->oDocument->getIpaddress());?>)</span><?php } ?>
                </div>
            </div>

        </div>

        <a name="tagfilelist"></a>
        <?php if(count($__Context->tag_list = $__Context->oDocument->get('tag_list'))) { ?><div class="tag">
            <ul>
                <?php @$__Context->j=0; $__Context->count=count($__Context->tag_list);;?> <?php for($__Context->i=0;$__Context->i<$__Context->count;$__Context->i++){ ?><li> <?php @$__Context->tag = $__Context->tag_list[$__Context->j++];;?>
                    <a href="<?php @print(getUrl('','mid',$__Context->mid,'search_target','tag','search_keyword',$__Context->tag));?>" rel="tag"><?php @print(htmlspecialchars($__Context->tag));?></a><?php  if($__Context->j < $__Context->count){ ?>,&nbsp;<?php  } ?>
                </li><?php } ?>
            </ul>
        </div><?php } ?>

        <?php if(count($__Context->file_list['image']) || count($__Context->file_list['binary']) || count($__Context->file_list['media'])) { ?>
            <?php if(count($__Context->file_list['image']) && $__Context->is_display_image) { ?><div class="<?php  if($__Context->is_review && in_array($__Context->module_info->display_download_button, array('Y','V'))){ ?>exDHide<?php  }else{ ?>fileAtt<?php  } ?> exJsImageListBox" rel="<?php @print($__Context->oDocument->document_srl);?>"><a name="imagefilelist"></a>
                <ul>
                <?php @$__Context->downpoint = $__Context->idx = 0;?>
                <?php if(count($__Context->file_list['image'] )) { foreach($__Context->file_list['image']  as $__Context->file ) { ?>
                    <?php if($__Context->module_info->use_reward != 'N' && $__Context->module_info->use_allow_down == 'P' && $__Context->module_info->use_down_point_images=='Y') { ?>
                        <?php @$__Context->downpoint = (!$__Context->file->file_size)?0:(($__Context->downloaded_list[$__Context->file->file_srl]>0 || (abs($__Context->file->member_srl) == $__Context->logged_info->member_srl))?'0':$__Context->adopted_reward_point);?>
                    <?php } ?>

                    <?php  if($__Context->not_allow_down){ ?>
                        <?php @$__Context->msg_download = '_exJsDownloadConfirm(\'false\')';?>
                    <?php  }elseif($__Context->module_info->use_reward != 'N' && $__Context->module_info->use_allow_down == 'P' && $__Context->module_info->use_down_point_images=='Y' && $__Context->module_info->download_point_confirm=='Y' && $__Context->downpoint){ ?>
                        <?php @$__Context->msg_download = '_exJsDownloadConfirm(\''.$__Context->downpoint.'\')';?>
                    <?php  }else{ ?>
                        <?php @$__Context->msg_download = '';?>
                    <?php  } ?>

                    <li style="background-image:url('<?php @print($__Context->tpl_path);?>images/<?php @print($__Context->module_info->colorset);?>/<?php @print($__Context->file->isvalid=='Y'?'iconImage':'iconError');?>.gif')">
                        <a href="<?php @print(getUrl('').$__Context->file->download_url);?>" <?php @print((!$__Context->file->file_size)?'target="_bodexLink"':'');?> onclick="return <?php @print($__Context->file->isvalid=='Y'?(($__Context->msg_download)?$__Context->msg_download:'true'):'false');?>">
                            <span <?php @print($__Context->file->isvalid=='Y'?($__Context->downloaded_list[$__Context->file->file_srl]>0?'class="fileDownloaded"':''):'class="fileError" title="invalid"');?>><?php @print($__Context->file->source_filename);?>(<?php @print(($__Context->file->file_size)?FileHandler::filesize($__Context->file->file_size):'link');?>)[<?php @print(number_format($__Context->file->download_count));?>]<?php @print(($__Context->downpoint > 0)?'($'.($__Context->downpoint).')':'');?></span>
                        </a>
                    </li>
                <?php } } ?>
                </ul>
            </div><?php } ?>

            <?php if(count($__Context->file_list['media']) && $__Context->is_display_media) { ?><div class="<?php  if($__Context->is_review && in_array($__Context->module_info->display_download_button, array('Y','V'))){ ?>exDHide<?php  }else{ ?>fileAtt<?php  } ?> exJsMediaListBox" rel="<?php @print($__Context->oDocument->document_srl);?>"><a name="mediafilelist"></a>
                <ul>
                <?php @$__Context->downpoint = 0;?>
                <?php if(count($__Context->file_list['media'] )) { foreach($__Context->file_list['media']  as $__Context->file ) { ?>
                    <?php if($__Context->module_info->use_reward != 'N' && $__Context->module_info->use_allow_down == 'P' && $__Context->module_info->use_down_point_medias=='Y') { ?>
                        <?php @$__Context->downpoint = (!$__Context->file->file_size)?0:(($__Context->downloaded_list[$__Context->file->file_srl]>0 || (abs($__Context->file->member_srl) == $__Context->logged_info->member_srl))?'0':$__Context->adopted_reward_point);?>
                    <?php } ?>

                    <?php  if($__Context->not_allow_down){ ?>
                        <?php @$__Context->msg_download = '_exJsDownloadConfirm(\'false\')';?>
                    <?php  }elseif($__Context->module_info->use_reward != 'N' &&$__Context->module_info->use_allow_down == 'P' && $__Context->module_info->use_down_point_medias=='Y' && $__Context->module_info->download_point_confirm=='Y' && $__Context->downpoint){ ?>
                        <?php @$__Context->msg_download = '_exJsDownloadConfirm(\''.$__Context->downpoint.'\')';?>
                    <?php  }else{ ?>
                        <?php @$__Context->msg_download = '';?>
                    <?php  } ?>

                    <li style="background-image:url('<?php @print($__Context->tpl_path);?>images/<?php @print($__Context->module_info->colorset);?>/<?php @print($__Context->file->isvalid=='Y'?'iconMedia':'iconError');?>.gif')">
                        <?php  if($__Context->module_info->use_media_player=='Y'){ ?>
                            <a href="#" onclick="<?php @print($__Context->file->isvalid=='Y'?'_exJcPopDisplayMedia(\''.$__Context->file->file_srl.'\',\''.$__Context->file->sid.'\');':'');?> return false">
                        <?php  }else{ ?>
                            <a href="<?php @print(getUrl('').$__Context->file->download_url);?>" <?php @print((!$__Context->file->file_size)?'target="_bodexLink"':'');?> onclick="return <?php @print($__Context->file->isvalid=='Y'?(($__Context->msg_download)?$__Context->msg_download:'true'):'false');?>">
                        <?php  } ?>
                            <span <?php @print($__Context->file->isvalid=='Y'?($__Context->downloaded_list[$__Context->file->file_srl]>0?'class="fileDownloaded"':''):'class="fileError" title="invalid"');?>><?php @print($__Context->file->source_filename);?>(<?php @print(($__Context->file->file_size)?FileHandler::filesize($__Context->file->file_size):'link');?>)[<?php @print(number_format($__Context->file->download_count));?>]<?php @print(($__Context->downpoint > 0)?'($'.($__Context->downpoint).')':'');?></span>
                        </a>
                    </li>
                <?php } } ?>
                </ul>
            </div><?php } ?>

            <?php if(count($__Context->file_list['binary']) && $__Context->is_display_binary) { ?><div class="<?php  if($__Context->is_review && in_array($__Context->module_info->display_download_button, array('Y','V'))){ ?>exDHide<?php  }else{ ?>fileAtt<?php  } ?> exJsFileListBox" rel="<?php @print($__Context->oDocument->document_srl);?>"><a name="binaryfilelist"></a>
                <ul>
                <?php @$__Context->downpoint = 0;?>
                <?php if(count($__Context->file_list['binary'] )) { foreach($__Context->file_list['binary']  as $__Context->file ) { ?>
                    <?php @$__Context->downpoint = (($__Context->module_info->use_reward != 'N' && $__Context->module_info->use_allow_down == 'P' && $__Context->downloaded_list[$__Context->file->file_srl]<1)?$__Context->adopted_reward_point:'0');
                        $__Context->downpoint = (!$__Context->file->file_size)?0:((abs($__Context->file->member_srl) == $__Context->logged_info->member_srl)?'0':$__Context->downpoint+$__Context->download_file_point);;?>

                    <?php  if($__Context->not_allow_down){ ?>
                        <?php @$__Context->msg_download = '_exJsDownloadConfirm(\'false\')';?>
                    <?php  }elseif($__Context->module_info->use_reward != 'N' &&$__Context->module_info->use_allow_down == 'P' && $__Context->module_info->download_point_confirm=='Y' && $__Context->downpoint){ ?>
                        <?php @$__Context->msg_download = '_exJsDownloadConfirm(\''.$__Context->downpoint.'\')';?>
                    <?php  }else{ ?>
                        <?php @$__Context->msg_download = '';?>
                    <?php  } ?>

                    <li style="background-image:url('<?php @print($__Context->tpl_path);?>images/<?php @print($__Context->module_info->colorset);?>/<?php @print($__Context->file->isvalid=='Y'?($__Context->file->direct_download =='M'?'iconMedia':'iconFile'):'iconError');?>.gif')">
                        <a href="<?php @print(getUrl('').$__Context->file->download_url);?>" <?php @print((!$__Context->file->file_size)?'target="_bodexLink"':'');?> onclick="return <?php @print($__Context->file->isvalid=='Y'?(($__Context->msg_download)?$__Context->msg_download:'true'):'false');?>">
                            <span <?php @print($__Context->file->isvalid=='Y'?($__Context->downloaded_list[$__Context->file->file_srl]>0?'class="fileDownloaded"':''):'class="fileError" title="invalid"');?>><?php @print($__Context->file->source_filename);?>(<?php @print(($__Context->file->file_size)?FileHandler::filesize($__Context->file->file_size):'link');?>)[<?php @print(number_format($__Context->file->download_count));?>]<?php @print(($__Context->downpoint >0)?'($'.($__Context->downpoint).')':'');?></span>
                        </a>
                    </li>
                <?php } } ?>
                </ul>
            </div><?php } ?>
        <?php } ?>
    </div>

    <div class="cntBtn">
        <div class="repAtbc">
            <?php if($__Context->oDocument->allowComment()) { ?><div class="replyCount">
                <a class="exJsReTrToggle" href="#" rel="Comment" rev="<?php @print($__Context->blog_style_doc_no);?>" onclick="return false;">
                    <strong><?php @print($__Context->lang->comment);?></strong>
                    <span class="replies">[<?php @print($__Context->oDocument->getCommentcount());?>]</span>
                </a>
            </div><?php } ?>
            <?php if($__Context->oDocument->allowTrackback()) { ?><div class="trackbackCount">
                <a class="exJsReTrToggle" href="#" rel="Trackback" rev="<?php @print($__Context->blog_style_doc_no);?>" onclick="return false;">
                    <strong><?php @print($__Context->lang->trackback);?></strong>
                    <span class="trackbacks">(<?php @print($__Context->oDocument->getTrackbackCount());?>)</span>
                </a>
            </div><?php } ?>
        </div>

        <span class="button" style="background-image:none;">&nbsp;</span>

        <?php if(!$__Context->oDocument->isNotice()&&$__Context->grant->manager&&$__Context->module_info->use_doc_state=='Y') { ?><brock>
            <select name="doc_state" class="doc_state exISt">
                <?php if(count($__Context->doc_state_list )) { foreach($__Context->doc_state_list  as $__Context->key => $__Context->val) { ?><option<?php if($__Context->oDocument->is_notice==$__Context->key) {?> selected="selected"<?php }?> value="<?php @print($__Context->key);?>"><?php @print(strip_tags($__Context->val));?></option><?php } } ?>
            </select>
            <a href="#" onclick="_exJcChangeDocumentState('<?php @print($__Context->oDocument->document_srl);?>',document.getElementsByName('doc_state')[0].value); return false;" class="button <?php @print($__Context->btn_class);?>">
                <span><?php @print($__Context->lang->cmd_change_state);?></span>
            </a>
        </brock><?php } ?>
        <?php if(($__Context->module_info->use_reward != 'N' && ($__Context->module_info->use_allow_view != 'P' || $__Context->module_info->use_allow_down != 'P')) && $__Context->oDocument->reward_point > 0 && $__Context->oDocument->reward_srl > 0) { ?><a href="<?php @print(getUrl('comment_srl',$__Context->oDocument->reward_srl));?>#comment_<?php @print($__Context->oDocument->reward_srl);?>" class="button <?php @print($__Context->btn_class);?>">
            <span><?php @print($__Context->lang->cmd_adopted_comment_view);?></span>
        </a><?php } ?>

        <?php if($__Context->module_info->use_history == 'Y' || $__Context->module_info->use_history == 'Trace') { ?><a href="<?php @print(getUrl('act','dispBoardHistoryList'));?>#history" class="button <?php @print($__Context->btn_class);?>">
            <span><?php @print($__Context->lang->cmd_history_all);?></span>
        </a><?php } ?>

        <?php if(!$__Context->blog_style_doc_no || ($__Context->blog_style_doc_no && $__Context->document_srl)) { ?><a href="<?php @print(getUrl('act','','document_srl','','page',($__Context->page>1)?$__Context->page:''));?>" class="button black">
            <span><?php  if($__Context->blog_style_doc_no){ ?><?php @print($__Context->lang->cmd_view_all);?><?php  }else{ ?><?php @print($__Context->lang->cmd_list);?><?php  } ?></span>
        </a><?php } ?>

        <?php if($__Context->oDocument->isEditable() && ($__Context->grant->manager || !(($__Context->module_info->use_allow_view != 'P' || $__Context->module_info->use_allow_down != 'P') && (($__Context->module_info->use_reward == 'Y' && $__Context->oDocument->reward_point) || $__Context->module_info->use_reward == 'R') && $__Context->oDocument->comment_count > 0))) { ?>
            <a href="<?php @print(getUrl('act','dispBoardWrite','document_srl',$__Context->oDocument->document_srl));?>" class="button black">
                <span><?php @print($__Context->lang->cmd_modify);?></span>
            </a>
            <a href="<?php @print(getUrl('act','dispBoardDelete','document_srl',$__Context->oDocument->document_srl));?>" class="button black">
                <span><?php @print($__Context->lang->cmd_delete);?></span>
            </a>
        <?php } ?>
    </div>

    <?php @$__Context->d_display_comment = $__Context->d_display_trackback = '';?>
    <?php if((!$__Context->cpage && !$__Context->rnd && !$__Context->comment_srl) || ($__Context->blog_style_doc_no)) { ?>
        <?php  if($__Context->module_info->display_comment_box == 'C'){ ?>
        <?php @$__Context->d_display_trackback = 'exDHide';?>
        <?php  }elseif($__Context->module_info->display_comment_box == 'T'){ ?>
        <?php @$__Context->d_display_comment = 'exJsDHideEx';?>
        <?php  }elseif($__Context->module_info->display_comment_box == 'N'){ ?>
        <?php @$__Context->d_display_trackback = 'exDHide';
            $__Context->d_display_comment =  'exJsDHideEx';;?>
        <?php  } ?>
    <?php } ?>


    <?php if($__Context->oDocument->allowTrackback()) { ?>
        <a name="trackback<?php @print($__Context->blog_style_doc_no);?>"></a>
        <div class="exJsTrackbackLayout <?php @print($__Context->d_display_trackback);?>" rel="<?php @print($__Context->blog_style_doc_no);?>">
            <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.trackback.html');
?>

        </div>
    <?php } ?>


    <?php if($__Context->oDocument->allowComment()) { ?>
        <a name="comment<?php @print($__Context->blog_style_doc_no);?>"></a>
        <div class="exJsCommentLayout <?php @print($__Context->d_display_comment);?>" rel="<?php @print($__Context->blog_style_doc_no);?>">
            <?php if($__Context->oDocument->getCommentCount()>0) { ?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','_view.comment.html');
?>
<?php } ?>
            <a name="comment_form"></a>
            <?php if($__Context->grant->write_comment && $__Context->oDocument->isEnableComment()) { ?>
                <?php @$__Context->form_include = true;?>
                <?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','comment_form.html');
?>

            <?php } ?>
        </div>
    <?php } ?>
</div>
