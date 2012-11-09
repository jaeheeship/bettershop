<?php if(!defined("__ZBXE__")) exit();?><div id="popHeader" class="wide">
    <h3 class="xeAdmin"><?php @print($__Context->lang->module_maker);?></h3>
</div>

<div id="popBody">

    <table cellspacing="0" class="rowTable">
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->title);?></div></th>
        <td><?php @print($__Context->module_info->title);?> ver <?php @print($__Context->module_info->version);?></td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->author);?></div></th>
        <td class="blue">
            <?php $__Context->Context->__idx[0]=0;if(count($__Context->module_info->author))  foreach($__Context->module_info->author as $__Context->author){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
            <?php @print($__Context->author->name);?> <?php  if($__Context->author->homepage || $__Context->author->email_address){ ?>(<?php  if($__Context->author->homepage){ ?><a href="<?php @print($__Context->author->homepage);?>" onclick="window.open(this.href);return false;"><?php @print($__Context->author->homepage);?></a><?php  } ?><?php  if($__Context->author->homepage && $__Context->author->email_address){ ?>, <?php  } ?><?php  if($__Context->author->email_address){ ?><a href="mailto:<?php @print($__Context->author->email_address);?>"><?php @print($__Context->author->email_address);?></a><?php  } ?>)<?php  } ?><br />
            <?php  } ?>
        </td>
    </tr>
    <?php  if($__Context->module_info->homepage){ ?>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->homepage);?></div></th>
        <td class="blue"><a href="<?php @print($__Context->module_info->homepage);?>" onclick="window.open(this.href);return false;"><?php @print($__Context->module_info->homepage);?></a></td>
    </tr>
    <?php  } ?>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->regdate);?></div></th>
        <td><?php @print(zdate($__Context->module_info->date, 'Y-m-d'));?></td>
    </tr>
    <?php  if($__Context->module_info->license || $__Context->module_info->license_link){ ?>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->module_license);?></div></th>
        <td>
            <?php @print(nl2br(trim($__Context->module_info->license)));?>
        <?php  if($__Context->module_info->license_link){ ?>
            <p><a href="<?php @print($__Context->module_info->license_link);?>" onclick="window.close(); return false;"><?php @print($__Context->module_info->license_link);?></a></p>
        <?php  } ?>
        </td>
    </tr>
    <?php  } ?><?php  if($__Context->module_info->description){ ?>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->description);?></div></th>
        <td><?php @print(nl2br(trim($__Context->module_info->description)));?></td>
    </tr>
    <?php  } ?>
    </table>

</div>

<?php  if($__Context->module_info->history){ ?>
<div id="popHistoryHeadder">
    <h3 class="xeAdmin"><?php @print($__Context->lang->module_history);?></h3>
</div>

<div id="popHistoryBody">
    <table cellspacing="0" class="rowTable">
    <col width="100" />
    <col />

    <?php $__Context->Context->__idx[1]=0;if(count($__Context->module_info->history))  foreach($__Context->module_info->history as $__Context->history){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
    <tr>
        <th scope="row">
            <?php @print($__Context->history->version);?><br />
            <?php @print($__Context->history->date);?>
        </th>
        <td>
            <?php $__Context->Context->__idx[2]=0;if(count($__Context->history->author))  foreach($__Context->history->author as $__Context->author){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
            <p><?php @print($__Context->author->name);?> (<a href="<?php @print($__Context->author->homepage);?>" onclick="window.open(this.href);return false;"><?php @print($__Context->author->homepage);?></a> / <a href="mailto:<?php @print($__Context->author->email_address);?>"><?php @print($__Context->author->email_address);?></a>)</p>
            <?php  } ?>
            <?php  if($__Context->addon_info->description){ ?>
            <p><?php @print(nl2br(trim($__Context->history->description)));?></p>
            <?php  } ?>
            <?php  if($__Context->history->logs){ ?>
            <ul>
                <?php $__Context->Context->__idx[3]=0;if(count($__Context->history->logs))  foreach($__Context->history->logs as $__Context->log){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
                <?php  if($__Context->log->link){ ?>
                <li><a href="<?php @print($__Context->log->text);?>" onclick="window.open(this.href);return false;"><?php @print($__Context->log->text);?></a></li>
                <?php  }else{ ?>
                <li><?php @print($__Context->log->text);?></li>
                <?php  } ?>
                <?php  } ?>
            </ul>
            <?php  } ?>
        </td>
    </tr>
    <?php  } ?>
    </table>
</div>
<?php  } ?>
