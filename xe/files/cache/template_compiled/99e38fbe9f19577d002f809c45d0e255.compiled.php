<?php if(!defined("__ZBXE__")) exit();?><?php if(!$__Context->form_include) { ?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','__header.html');
?>
<?php } ?>
<?php if($__Context->iframe_include) { ?><style type="text/css">body {border:0;margin:1px;padding:1px}</style><?php } ?>

<?php if(!$__Context->iframe_include && $__Context->oSourceComment && $__Context->oSourceComment->isExists()) { ?><div class="exRepBox">
    <div class="repItm">
        <?php @$__Context->oSourceComment->nickName = $__Context->oSourceComment->getNickName();
            $__Context->oSourceComment->member_srl = $__Context->oSourceComment->getMemberSrl();
            $__Context->oSourceComment->nickName = ($__Context->oSourceComment->nickName=='anonymous'?$__Context->lang->anonymous:$__Context->oSourceComment->nickName);
            $__Context->oSourceComment->member_srl = (!$__Context->grant->manager && $__Context->oSourceComment->member_srl && $__Context->oSourceComment->get('user_id')=='anonymous')?0:$__Context->oSourceComment->member_srl;;?>
        <div class="author"><div class="member_<?php @print($__Context->oSourceComment->member_srl);?>"><?php @print($__Context->oSourceComment->nickName);?></div></div>
        <div class="date">
            <?php @print($__Context->oSourceComment->getRegdate("Y.m.d H:i"));?>
            <?php if($__Context->grant->manager) { ?>
                (<?php @print($__Context->oSourceComment->get('ipaddress'));?>)
            <?php } ?>
        </div>
        <div class="clear"></div>

        <div class="repCnt gap1">
            <?php @print($__Context->oSourceComment->getContent(false));?>
        </div>
    </div>
</div><?php } ?>

<?php if($__Context->oComment) { ?>
    <?php @$__Context->oComment = $__Context->oBodex->getWith($__Context->oComment, array('document_srl','parent_srl','comment_srl','member_srl','user_id','nick_name','email_address','homepage','content'));

        $__Context->oComment->email_address = htmlspecialchars($__Context->oComment->email_address);
        $__Context->oComment->homepage = htmlspecialchars($__Context->oComment->homepage);
        $__Context->oComment->content = htmlspecialchars($__Context->oComment->content);

        $__Context->oComment->is_secret = $__Context->oComment->isSecret();
        $__Context->oComment->use_notify = $__Context->oComment->useNotify();;?>
<?php } ?>
    <form action="./" method="post" onsubmit="return procFilter(this, insert_comment)" class="bodexEditor" >
        <input type="hidden" name="mid" value="<?php @print($__Context->mid);?>" />
        <input type="hidden" name="document_srl" value="<?php @print(($__Context->oComment)?$__Context->oComment->document_srl:$__Context->oDocument->document_srl);?>" />
        <input type="hidden" name="comment_srl" value="<?php @print($__Context->oComment->comment_srl);?>" />
        <input type="hidden" name="content" value="<?php @print($__Context->oComment->content);?>" />
        <input type="hidden" name="parent_srl" value="<?php @print($__Context->oComment->parent_srl);?>" />

        <div class="exWrite exCWrite <?php  if($__Context->iframe_include){ ?>exIfmInc<?php  } ?>">
            <div class="exWtIfo">

                <?php if(!$__Context->oComment) { ?>
                    <?php  if(!$__Context->is_logged || $__Context->module_info->use_vote == 'N' || ($__Context->module_info->display_review_comment != 'Y' && abs($__Context->oDocument->member_srl) == abs($__Context->logged_info->member_srl))){ ?>
                        <input type="hidden" name="vote_point" value="0" />
                    <?php  }else{ ?>
                        <div class="votePoint">
                        <?php  if($__Context->logged_user_voted_star && $__Context->logged_user_voted_star != 0){ ?>
                            <?php  if($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z'){ ?>
                                <div class="exSPFrm fl" title="<?php @print(sprintf($__Context->lang->msg_acted_current_document,$__Context->lang->cmd_vote));?>">
                                    <span class="exSCol<?php @print($__Context->module_info->star_color);?> exBg0" style="width:<?php @print($__Context->logged_user_voted_star*15);?>px">&nbsp;</span>
                                </div>
                            <?php  }else{ ?>
                                <div class="fl"><?php @print(sprintf($__Context->lang->msg_acted_current_document,($__Context->logged_user_voted_star < 0? $__Context->lang->cmd_vote_down:$__Context->lang->cmd_vote)));?></div>
                            <?php  } ?>
                            <?php if($__Context->module_info->use_vote_empty == 'Y') { ?><div class="voteEmpty">
                                <a href="#" onclick="doCallModuleAction('<?php @print($__Context->module_info->module);?>','procBoardVoteEmpty','<?php @print($__Context->oDocument->document_srl);?>'); return false; " title="<?php @print($__Context->lang->cmd_vote_empty);?>"><span><?php @print($__Context->lang->cmd_vote_empty);?></span></a>
                            </div><?php } ?>
                        <?php  }elseif($__Context->is_logged && $__Context->module_info->use_vote == 'Y'){ ?>
                            <input type="hidden" name="vote_point" value="0" />
                            <a class="up" href="#" onclick="return _exJcCallAction('document','procDocumentVoteUp','<?php @print($__Context->oDocument->document_srl);?>');"><?php @print($__Context->lang->cmd_vote);?></a>
                            <a class="down" href="#" onclick="return _exJcCallAction('document','procDocumentVoteDown','<?php @print($__Context->oDocument->document_srl);?>');"><?php @print($__Context->lang->cmd_vote_down);?></a>
                        <?php  }elseif($__Context->is_logged && $__Context->module_info->use_vote == 'R'){ ?>
                            <input name="vote_point" value="1" id="votePoint_0" type="radio">
                            <label class="up" for="votePoint_0"><?php @print($__Context->lang->cmd_vote);?></label>
                            <input name="vote_point" value="-1" id="votePoint_1" type="radio">
                            <label class="down" for="votePoint_1"><?php @print($__Context->lang->cmd_vote_down);?></label>
                        <?php  }elseif($__Context->is_logged && ($__Context->module_info->use_vote == 'S' || $__Context->module_info->use_vote == 'Z')){ ?>
                            <ul class="exJsSPntBox">
                            <li><input type="hidden" name="vote_point" value="<?php @print($__Context->module_info->use_vote == 'S'?'0':'');?>" rel="<?php @print($__Context->module_info->use_vote == 'S'?'0':'');?>" /></li>
                            <?php @$__Context->j=1;?><?php for($__Context->i=1;$__Context->i<6;$__Context->i++){ ?><li><a href="#" onclick="return false;" rel="<?php @print($__Context->j++);?>" col="<?php @print($__Context->module_info->star_color);?>">&nbsp;</a></li><?php } ?>
                            <?php if($__Context->module_info->use_vote == 'S') { ?>
                                <li><a class="vote_cancel" href="#" onclick="return false;" rel="0" col="<?php @print($__Context->module_info->star_color);?>" title="<?php @print($__Context->lang->cancel);?>"><span><?php @print($__Context->lang->cancel);?></span></a></li>
                                <li><a class="vote_register" href="#" onclick="_exJcDocumentRating(jQuery('input[name=vote_point]').val()); return false;" title="<?php @print($__Context->lang->rating);?>"><span><?php @print($__Context->lang->rating);?></span></a></li>
                            <?php } ?>
                            </ul>
                        <?php  } ?>
                        </div>
                    <?php  } ?>
                <?php } ?>

                <dl class="option">
                    <?php if(!$__Context->is_logged) { ?>
                        <dd><label for="userName"><?php @print($__Context->lang->writer);?></label>
                        <input class="userName exISt" type="text" name="nick_name" maxlength="20" value="<?php @print($__Context->oComment->nick_name);?>" id="userName"/></dd>
                        <dd><label for="userPw"><?php @print($__Context->lang->password);?></label>
                        <input class="userPw exISt" type="password" name="password" id="userPw" /></dd>
                        <dd><label for="emailAddress"><?php @print($__Context->lang->email_address);?></label>
                        <input class="emailAddress exISt" type="text" name="email_address" value="<?php @print($__Context->oComment->email_address);?>" id="emailAddress"/></dd>
                        <dd><label for="homePage"><?php @print($__Context->lang->homepage);?></label>
                        <input class="homePage exISt" type="text" name="homepage" value="<?php @print($__Context->oComment->homepage);?>" id="homePage"/></dd>
                        </dl><dl class="option">
                    <?php } ?>
                    <dd>
                        <input type="checkbox" name="notify_message" value="Y"<?php if($__Context->oComment->use_notify) {?> checked="checked"<?php }?> id="notify_message" />
                        <label for="notify_message"><?php @print($__Context->lang->notify);?></label>
                    </dd>
                    <?php  if($__Context->grant->manager || $__Context->module_info->use_secret_comment=="Y"){ ?>
                        <dd><input type="checkbox" name="is_secret" value="Y"<?php if($__Context->oComment->is_secret||(!$__Context->oComment && $__Context->module_info->use_secret_comment=='R')) {?> checked="checked"<?php }?> id="is_secret" />
                        <label for="is_secret"><?php @print($__Context->lang->secret);?></label></dd>
                    <?php  }elseif($__Context->module_info->use_secret_comment=="R"){ ?>
                        <input type="hidden" name="is_secret" value="Y" />
                    <?php  } ?>
                    <?php  if($__Context->grant->manager || $__Context->module_info->use_anonymous_comment=="Y"){ ?>
                        <dd><input type="checkbox" name="is_anonymous" value="Y"<?php if(((($__Context->oComment->member_srl && $__Context->oComment->user_id == 'anonymous') || ($__Context->oComment->member_srl < 1)) && $__Context->oComment->nick_name == 'anonymous') || (!$__Context->oComment && $__Context->module_info->use_anonymous_comment=='R')) {?> checked="checked"<?php }?> id="is_anonymous" />
                            <label for="is_anonymous"><?php @print($__Context->lang->anonymous);?></label></dd>
                    <?php  }elseif($__Context->module_info->use_anonymous_comment=="R"){ ?>
                        <input type="hidden" name="is_anonymous" value="Y" />
                    <?php  } ?>

                    <?php if(!$__Context->oComment && $__Context->module_info->use_reward != 'N' && $__Context->oDocument->reward_point > 0) { ?><dd class="rePoint">
                    <?php  if($__Context->module_info->use_allow_view != 'P' && $__Context->module_info->use_allow_down != 'P'){ ?>
                        <?php if(!$__Context->oDocument->reward_srl) { ?>
                            (<?php @print(sprintf($__Context->lang->msg_reward_point_adopt, '<strong>'.$__Context->adopted_reward_point.'</strong>'));?>)
                        <?php } ?>
                    <?php  }elseif($__Context->module_info->use_allow_down == 'P'){ ?>
                        (<?php @print(($__Context->module_info->use_down_point_always=='Y')?$__Context->lang->always:$__Context->lang->first);?> <?php @print(sprintf($__Context->lang->msg_reward_point_download, '<strong>'.$__Context->adopted_reward_point.'</strong>'.($__Context->download_file_point>0?' + '.$__Context->lang->always.': <strong>'.$__Context->download_file_point.'</strong>':'')));?>)
                        <?php if($__Context->module_info->use_down_point_medias == 'Y' || $__Context->module_info->use_down_point_images == 'Y') { ?>
                            (<?php @print(sprintf($__Context->lang->msg_apply_with, (($__Context->module_info->use_down_point_medias == 'Y')?($__Context->lang->media.(($__Context->module_info->use_down_point_images == 'Y')?', ':'')):'').(($__Context->module_info->use_down_point_images == 'Y')?$__Context->lang->image:'')));?>)
                        <?php } ?>
                    <?php  } ?>
                    </dd><?php } ?>
                <dl>
            </div>

            <div class="editor"><?php @print(($__Context->oComment)?$__Context->oComment->getEditor():$__Context->oDocument->getCommentEditor());?></div>

        </div>

        <div class="commentButton tRight">
            <?php if($__Context->oComment) { ?><span class="button <?php @print($__Context->btn_class);?>"><input type="button" value="<?php @print($__Context->lang->cmd_back);?>" onclick="<?php  if($__Context->iframe_include){ ?>_exJsIframeClose(<?php @print($__Context->oSourceComment->isExists()?$__Context->oComment->parent_srl:$__Context->oComment->comment_srl);?>);<?php  }else{ ?>location.href='<?php @print(getUrl('act',''));?>';<?php  } ?> return false;"/></span><?php } ?>
            <span class="button black"><input type="submit" value="<?php @print($__Context->lang->cmd_comment_registration);?>" accesskey="s" /></span>
        </div>
    </form>
<?php if(!$__Context->form_include) { ?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','__footer.html');
?>
<?php } ?>
