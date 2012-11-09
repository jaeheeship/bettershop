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
$__Context->oXmlFilter = new XmlJSFilter("./widgets/login_info/skins/xe_official/./filter/","login.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./widgets/login_info/skins/xe_official/./filter/","openid_login.xml");
$__Context->oXmlFilter->compile();
?>

<!--#Meta:./widgets/login_info/skins/xe_official/./js/login.js--><?php Context::addJsFile("./widgets/login_info/skins/xe_official/./js/login.js", true, "", null, "head"); ?>

<script type="text/javascript">
    var keep_signed_msg = "<?php @print($__Context->lang->about_keep_signed);?>";
    xAddEventListener(window, "load", function(){ doFocusUserId("fo_login_widget"); });
</script>

<fieldset id="login" class="login_<?php @print($__Context->colorset);?>">
<legend><?php @print($__Context->lang->cmd_login);?></legend>
<form action="./" method="post" onsubmit="return procFilter(this, widget_login)" id="fo_login_widget">

    <div class="idpwWrap">
        <div class="idpw">
            <input name="user_id" type="text" title="user id" />
            <input name="password" type="password" title="password" />
        </div>
        <input type="image" src="/bettershop/xe/widgets/login_info/skins/xe_official/images/<?php @print($__Context->colorset);?>/buttonLogin.gif" alt="login" class="login" />
    </div>
    <?php  if($__Context->member_config->enable_ssl=='Y'){ ?>
    <p class="securitySignIn <?php  if($__Context->ssl_mode){ ?>SSL<?php  }else{ ?>noneSSL<?php  } ?>">
        <a href="#" onclick="toggleSecuritySignIn(); return false;"><?php @print($__Context->lang->security_sign_in);?></a>
    </p>
    <?php  } ?>
    <p class="save">
        <input type="checkbox" name="keep_signed" id="keepid" value="Y" onclick="if(this.checked) return confirm(keep_signed_msg);" />
        <label for="keepid"><?php @print($__Context->lang->keep_signed);?></label>

        <?php  if($__Context->member_config->enable_openid=='Y'){ ?>
        <br />
        <input name="use_open_id" id="use_open_id" type="checkbox" value="Y" onclick="toggleLoginForm(this); return false;" />
        <label for="use_open_id">Open ID</label>
        <?php  } ?>
    </p>
    <ul class="help">
        <li class="first-child"><a href="<?php @print(getUrl('act','dispMemberSignUpForm'));?>"><?php @print($__Context->lang->cmd_signup);?></a></li>
        <li><a href="<?php @print(getUrl('act','dispMemberFindAccount'));?>"><?php @print($__Context->lang->cmd_find_member_account);?></a></li>
        <li><a href="<?php @print(getUrl('act','dispMemberResendAuthMail'));?>"><?php @print($__Context->lang->cmd_resend_auth_mail);?></a></li>
    </ul>
</form> 
</fieldset>

<!-- OpenID -->
<?php  if($__Context->member_config->enable_openid=='Y'){ ?>
<fieldset id="openid_login" class="openid_login_<?php @print($__Context->colorset);?>" style="display:none;">
<legend><?php @print($__Context->lang->cmd_login);?></legend>
  <form action="<?php @print(getUrl('module','member','act','procMemberOpenIDLogin'));?>" method="post" onsubmit="return procFilter(this, openid_login)" >
      <div class="idpwWrap">
        <div class="idpw">
          <p><?php @print($__Context->lang->openid);?></p>
          <input type="text" name="openid" class="openid_user_id" />
        </div>
        <input type="image" src="/bettershop/xe/widgets/login_info/skins/xe_official/images/<?php @print($__Context->colorset);?>/buttonLogin.gif" alt="login" class="login" />
      </div>
      <p class="save">
          <input name="use_open_id" id="use_open_id_2" type="checkbox" value="Y" onclick="toggleLoginForm(this); return false;"/>
          <label for="use_open_id_2">Open ID</label>
      </p>
  </form>
</fieldset>
<?php  } ?>

<script type="text/javascript">
  xAddEventListener(window, "load", function(){ doFocusUserId("fo_login_widget"); });
</script>
