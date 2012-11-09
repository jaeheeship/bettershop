<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:./modules/message/skins/default/message.css--><?php Context::addCSSFile("./modules/message/skins/default/message.css", true, "all", "", null); ?>

<div id="loginAccess" class="gLogin">
	<h1><?php @print($__Context->system_message);?></h1>
	<?php  if(!$__Context->is_logged){ ?>
    <!--#Meta:./modules/message/skins/default/../../../../common/js/jquery.js--><?php Context::addJsFile("./modules/message/skins/default/../../../../common/js/jquery.js", true, "", null, "head"); ?>
	<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/message/skins/default/./filter/","login.xml");
$__Context->oXmlFilter->compile();
?>

	<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/message/skins/default/./filter/","openid_login.xml");
$__Context->oXmlFilter->compile();
?>

	<!--#Meta:./modules/message/skins/default/./message.js--><?php Context::addJsFile("./modules/message/skins/default/./message.js", true, "", null, "head"); ?>
	<div class="mLogin" id="gLogin">
		<form action="./" method="post" onsubmit="return doLogin(this, message_login)" id="gForm">
			<fieldset>
				<ul class="idpw">
					<li><input type="text" name="user_id" id="uid" value="" class="inputText" title="<?php @print($__Context->lang->user_id);?>" /></li>
					<li><input type="password" name="password" id="upw" value="" class="inputText" title="<?php @print($__Context->lang->password);?>" /></li>
				</ul>
				<div class="buttonArea">
					<p class="keeping">
						<input type="checkbox" name="keep_signed" id="keepid" class="inputCheck" value="Y" onclick="jQuery('#warning')[(jQuery('#keepid:checked').size()>0?'addClass':'removeClass')]('open');" />						
						<label for="keepid"><?php @print($__Context->lang->keep_signed);?></label>
					</p>
					<div id="warning" class="">
						<p><?php @print($__Context->lang->about_keep_warning);?></p>
					</div>
					<span class="buttonAccount"><input type="submit" value="<?php @print($__Context->lang->cmd_login);?>" /></span>
				</div>
			</fieldset>
		</form>
		<ul class="help">
			<li class="first"><a href="<?php @print(getUrl('','act','dispMemberFindAccount'));?>"><span><?php @print($__Context->lang->cmd_find_member_account);?></span></a></li>
			<li><a href="<?php @print(getUrl('','act','dispMemberSignUpForm'));?>"><span><?php @print($__Context->lang->cmd_signup);?></span></a></li>
			<?php  if($__Context->member_config->enable_openid=='Y'){ ?>
			<li><a href="#oLogin" onclick="jQuery('#loginAccess').removeClass('gLogin'); jQuery('#loginAccess').addClass('oLogin'); return false;">Open ID</a></li>
			<?php  } ?>
		</ul>
	</div>
	
	<!-- OpenID -->
	<?php  if($__Context->member_config->enable_openid=='Y'){ ?>
	<div class="mLogin" id="oLogin">
		<form action="<?php @print(getUrl('module','member','act','procMemberOpenIDLogin'));?>" method="post" onsubmit="return doLogin(this, openid_login)" id="oForm">
			<fieldset>
					<div class="oid">
						<input type="text" name="openid" class="inputText" title="Open ID" value="" />
					</div>
					<div class="buttonArea">
					<span class="buttonAccount"><input type="submit" value="<?php @print($__Context->lang->cmd_login);?>" /></span>
				</div>
			</fieldset>
		</form>
		<div class="help"><a href="#gLogin" onclick="jQuery('#loginAccess').removeClass('oLogin'); jQuery('#loginAccess').addClass('gLogin'); return false;"><?php @print($__Context->lang->cmd_common_id);?></a></div>
	</div>
	<?php  } ?>
	<?php  } ?>
	<?php  if($__Context->is_logged){ ?>
	<div class="logOut">
		<span class="buttonAccount"><a href="<?php @print(getUrl('act','dispMemberLogout','module',''));?>"><?php @print($__Context->lang->cmd_logout);?></a></span>
	</div>
	<?php  } ?>
</div>
