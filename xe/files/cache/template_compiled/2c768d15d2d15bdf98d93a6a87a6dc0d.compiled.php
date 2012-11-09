<?php if(!defined("__ZBXE__")) exit();?>

<div class="exTbcBox">
    <div class="tbcUrl"><?php @print($__Context->lang->trackback_url);?> : <a name="trackback" href="<?php @print($__Context->oBodex->getTrackbackUrlEx());?>" onclick="return _exJcCopyClipboard(this.href);"><?php @print($__Context->oBodex->getTrackbackUrlEx());?></a><div class="clear"></div></div>

    <?php if($__Context->oDocument->getTrackbackCount()) { ?>
        <hr size="1" noshade />
        <?php if(count($__Context->oDocument->getTrackbacks() )) { foreach($__Context->oDocument->getTrackbacks()  as $__Context->key => $__Context->val) { ?><div class="tbcItm">
            <a name="trackback_<?php @print($__Context->val->trackback_srl);?>"></a>
            <address>
                <a href="<?php @print($__Context->val->url);?>" onclick="winopen(this.href);return false;"><?php @print(htmlspecialchars($__Context->val->title).' - '.htmlspecialchars($__Context->val->blog_name));?></a>
                <a class="date" href="<?php @print(getUrl('act','dispBoardDeleteTrackback','trackback_srl',$__Context->val->trackback_srl));?>"><img src="/bettershop/xe/modules/bodex/skins/ex_default/images/common/buttonDeleteX.gif" border="0" alt="delete" width="12" height="13" /></a>
                <span class="date">
                    <?php @print(zdate($__Context->val->regdate, "Y.m.d H:i").'('.$__Context->val->ipaddress.')');?>
                </span>
            </address>
            <p>
                <a href="<?php @print($__Context->val->url);?>" onclick="winopen(this.href);return false;"><?php @print($__Context->val->excerpt);?></a>
            </p>
        </div><?php } } ?>
    <?php } ?>
</div>
