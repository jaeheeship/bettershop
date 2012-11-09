<?php if(!defined("__ZBXE__")) exit();?>
<?php  if($__Context->colorset=="black"){ ?>
    <!--#Meta:./widgets/login_info/skins/xe_official/css/black.css--><?php Context::addCSSFile("./widgets/login_info/skins/xe_official/css/black.css", true, "all", "", null); ?>
<?php  }elseif($__Context->colorset=="white"){ ?>
    <!--#Meta:./widgets/login_info/skins/xe_official/css/white.css--><?php Context::addCSSFile("./widgets/login_info/skins/xe_official/css/white.css", true, "all", "", null); ?>
<?php  }else{ ?>
    <!--#Meta:./widgets/login_info/skins/xe_official/css/default.css--><?php Context::addCSSFile("./widgets/login_info/skins/xe_official/css/default.css", true, "all", "", null); ?>
<?php  } ?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./widgets/login_info/skins/xe_official/./filter/","logout.xml");
$__Context->oXmlFilter->compile();
?>


<fieldset id="login" class="login_<?php @print($__Context->colorset);?>">
<legend><?php @print($__Context->lang->cmd_login);?></legend>
<form action="" method="post">

    <div class="userName">
        <div class="fl"><div class="member_<?php @print($__Context->logged_info->member_srl);?>"><strong><?php @print($__Context->logged_info->nick_name);?></strong></div></div>
        <div class="fr"><a href="<?php @print(getUrl('act','dispMemberLogout'));?>"><img src="/bettershop/xe/widgets/login_info/skins/xe_official/images/<?php @print($__Context->colorset);?>/buttonLogout.gif" alt="<?php @print($__Context->lang->cmd_logout);?>" width="47" height="18" /></a></div>
    </div>
    <ul class="userMenu">
        <?php $__Context->Context->__idx[0]=0;if(count($__Context->logged_info->menu_list))  foreach($__Context->logged_info->menu_list as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
        <li><a href="<?php @print(getUrl('act',$__Context->key,'member_srl','','page',''));?>"><?php @print(Context::getLang($__Context->val));?></a></li>
        <?php  } ?>

        <?php  if($__Context->logged_info->is_admin=="Y" && !$__Context->site_module_info->site_srl){ ?>
        <li><a href="<?php @print(getUrl('','module','admin'));?>" onclick="window.open(this.href);return false;"><?php @print($__Context->lang->cmd_management);?></a></li>
        <?php  } ?>
    </ul>
    <p class="latestLogin"><?php @print($__Context->lang->last_login);?><br /><span><?php @print(zDate($__Context->logged_info->last_login, "Y-m-d H:i"));?></span></p>
</form>
</fieldset>
