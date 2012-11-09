<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/admin/tpl/','_header.html');
?>


<!--#Meta:./modules/admin/tpl/./css/dashboard.css--><?php Context::addCSSFile("./modules/admin/tpl/./css/dashboard.css", true, "all", "", null); ?>
<?php Context::loadLang("./modules/admin/tpl/../../install/lang"); ?>
<!--#Meta:./modules/admin/tpl/../../module/tpl/js/module_admin.js--><?php Context::addJsFile("./modules/admin/tpl/../../module/tpl/js/module_admin.js", true, "", null, "head"); ?>
<!--#Meta:./modules/admin/tpl/../../session/tpl/js/session.js--><?php Context::addJsFile("./modules/admin/tpl/../../session/tpl/js/session.js", true, "", null, "head"); ?>
<!--#Meta:./modules/admin/tpl/../../addon/tpl/js/addon.js--><?php Context::addJsFile("./modules/admin/tpl/../../addon/tpl/js/addon.js", true, "", null, "head"); ?>
<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/admin/tpl/../../addon/tpl/filter/","toggle_activate_addon.xml");
$__Context->oXmlFilter->compile();
?>


<div class="content">
	<!-- Dashboard Header -->
	<div class="dashboardHeader">
		<h3 class="h3"><?php @print($__Context->lang->admin_index);?></h3>
	</div>
	<!-- /Dashboard Header -->

	<!-- Dashboard Statistic -->
	<div class="section dashboardStatistic">
		<div class="statistic">
			<h4><span>TODAY <em><?php @print(date('Y.m.d'));?></em></span></h4>
			<dl class="visit">
				<dt><?php @print($__Context->lang->today_visitor);?></dt>

				<dd>
					<object title="visitor" height="50" width="100%" align="middle" id="count_red" class="F1239845427590201480_undefined" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<param value="<?php @print(getUrl());?>modules/admin/tpl/swf/count.swf" name="movie"/>
						<param value="high" name="quality"/>
						<param value="#FFFFFF" name="bgColor"/>
						<param value="always" name="allowScriptAccess"/>
						<param value="transparent" name="wmode"/>
						<param value="false" name="menu"/>
						<param value="true" name="allowFullScreen"/>
						<param value="colorType=red&amp;viewNum=<?php @print($__Context->status->visitor);?>" name="flashVars"/>
						<!--[if !IE]> <-->
						<object title="<?php @print($__Context->status->visitor);?>" height="50" width="100%" align="middle" name="count_red" class="F1239845427590201480_undefined" data="<?php @print(getUrl());?>modules/admin/tpl/swf/count.swf" type="application/x-shockwave-flash">
							<param value="colorType=red&amp;viewNum=<?php @print($__Context->status->visitor);?>" name="flashVars"/>
							<param value="transparent" name="wmode"/>
							<?php @print($__Context->status->visitor);?>
						</object>
						<!--> <![endif]-->
					</object>
				</dd>
			</dl>
			<dl class="reply">
				<dt><?php @print($__Context->lang->today_comments);?></dt>
				<dd>
					<object title="<?php @print($__Context->status->comment->today);?>" height="50" width="100%" align="middle" id="count_blue" class="F1239845427590201480_undefined" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<param value="<?php @print(getUrl());?>modules/admin/tpl/swf/count.swf" name="movie"/>
						<param value="high" name="quality"/>
						<param value="#FFFFFF" name="bgColor"/>
						<param value="always" name="allowScriptAccess"/>
						<param value="transparent" name="wmode"/>
						<param value="false" name="menu"/>
						<param value="true" name="allowFullScreen"/>
						<param value="colorType=blue&amp;viewNum=<?php @print($__Context->status->comment_count);?>" name="flashVars"/>
						<!--[if !IE]> <-->
						<object title="<?php @print($__Context->status->comment->today);?>" height="50" width="100%" align="middle" name="count_blue" class="F1239845427590201480_undefined" data="<?php @print(getUrl());?>modules/admin/tpl/swf/count.swf" type="application/x-shockwave-flash">
							<param value="colorType=blue&amp;viewNum=<?php @print($__Context->status->comment_count);?>" name="flashVars"/>
							<param value="transparent" name="wmode"/>
							<?php @print($__Context->status->comment->today);?>
						</object>
						<!--> <![endif]-->
					</object>
				</dd>
			</dl>
			<dl class="trackback">
				<dt><?php @print($__Context->lang->today_trackbacks);?></dt>
				<dd>
					<object title="<?php @print($__Context->status->trackback->today);?>" height="50" width="100%" align="middle" id="count_gray" class="F1239845427590201480_undefined" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000">
						<param value="<?php @print(getUrl());?>modules/admin/tpl/swf/count.swf" name="movie"/>
						<param value="high" name="quality"/>
						<param value="#FFFFFF" name="bgColor"/>
						<param value="always" name="allowScriptAccess"/>
						<param value="transparent" name="wmode"/>
						<param value="false" name="menu"/>
						<param value="true" name="allowFullScreen"/>
						<param value="colorType=gray&amp;viewNum=<?php @print($__Context->status->trackback_count);?>" name="flashVars"/>
						<!--[if !IE]> <-->
						<object title="<?php @print($__Context->status->trackback->today);?>" height="50" width="100%" align="middle" name="count_gray" class="F1239845427590201480_undefined" data="<?php @print(getUrl());?>modules/admin/tpl/swf/count.swf" type="application/x-shockwave-flash">
							<param value="colorType=gray&amp;viewNum=<?php @print($__Context->status->trackback_count);?>" name="flashVars"/>
							<param value="transparent" name="wmode"/>
							<?php @print($__Context->status->trackback->today);?>
						</object>
						<!--> <![endif]-->
					</object>
				</dd>
			</dl>
			<div class="summary">
				<table border="1" cellspacing="0">
					<tr>
						<th scope="row"><a href="<?php @print(getUrl('','module','admin','act','dispMemberAdminList'));?>"><?php @print($__Context->lang->member);?></a></th>
						<td><strong><?php @print(number_format($__Context->status->member->total));?></strong> <span class="description">(+<a href="<?php @print(getUrl('','module','admin','act','dispMemberAdminList','search_target','regdate','search_keyword',date("Ymd")));?>"><strong><?php @print(number_format($__Context->status->member->today));?></strong></a>)</span></td>
					</tr>
					<tr>
						<th scope="row"><a href="<?php @print(getUrl('','module','admin','act','dispDocumentAdminList'));?>"><?php @print($__Context->lang->document);?></a></th>
						<td><strong><?php @print(number_format($__Context->status->document->total));?></strong> <span class="description">(+<a href="<?php @print(getUrl('','module','admin','act','dispDocumentAdminList','search_target','regdate','search_keyword',date("Ymd")));?>"><strong><?php @print(number_format($__Context->status->document->today));?></strong></a>,-<a href="<?php @print(getUrl('','module','admin','act','dispDocumentAdminDeclared'));?>"><strong><?php @print(number_format($__Context->status->documentDeclared->total));?></strong></a>)</span></td>
					</tr>
					<tr>
						<th scope="row"><a href="<?php @print(getUrl('','module','admin','act','dispCommentAdminList'));?>"><?php @print($__Context->lang->comment);?></a></th>
						<td><strong><?php @print(number_format($__Context->status->comment->total));?></strong> <span class="description">(+<a href="<?php @print(getUrl('','module','admin','act','dispCommentAdminList','search_target','regdate','search_keyword',date("Ymd")));?>"><strong><?php @print(number_format($__Context->status->comment->today));?></strong></a>,-<a href="<?php @print(getUrl('','module','admin','act','dispCommentAdminDeclared'));?>"><strong><?php @print(number_format($__Context->status->commentDeclared->total));?></strong></a>)</span></td>
					</tr>
					<tr>
						<th scope="row"><a href="<?php @print(getUrl('','module','admin','act','dispTrackbackAdminList'));?>"><?php @print($__Context->lang->trackback);?></a></th>
						<td><strong><?php @print(number_format($__Context->status->trackback->total));?></strong> <span class="description">(+<a href="<?php @print(getUrl('','module','admin','act','dispTrackbackAdminList','search_target','regdate','search_keyword',date("Ymd")));?>"><strong><?php @print(number_format($__Context->status->trackback->today));?></strong></a>)</span></td>
					</tr>
					<tr>
						<th scope="row"><a href="<?php @print(getUrl('','module','admin','act','dispFileAdminList'));?>"><?php @print($__Context->lang->file);?></a></th>
						<td><strong><?php @print(number_format($__Context->status->file->total));?></strong> <span class="description">(+<a href="<?php @print(getUrl('','module','admin','act','dispFileAdminList','search_target','regdate','search_keyword',date("Ymd")));?>"><strong><?php @print(number_format($__Context->status->file->today));?></strong></a>)</span></td>
					</tr>
				</table>
			</div>
		</div>
		<span class="outline ml"></span>
		<span class="outline mr"></span>
		<span class="outline tc"></span>
		<span class="outline bc"></span>
		<span class="outline tl"></span>
		<span class="outline tr"></span>

		<span class="outline bl"></span>
		<span class="outline br"></span>
	</div>
	<!-- /Dashboard Statistic -->

	<!-- Visotors Graph -->
	<div class="section">

		<h4 class="dashboardH4"><?php @print($__Context->lang->counter);?> <em><?php @print(date("Y.m.d"));?></em></h4>
		<div class="dashboardWire">
			<dl class="legend">
				<dt class="past"><img src="/bettershop/xe/common/tpl/images/blank.gif" width="5" height="5" alt="<?php @print($__Context->lang->yesterday);?>" /></dt>
				<dd><?php @print($__Context->lang->last_week);?></dd>
				<dt class="today"><img src="/bettershop/xe/common/tpl/images/blank.gif" width="5" height="5" alt="<?php @print($__Context->lang->today);?>" /></dt>
				<dd><?php @print($__Context->lang->this_week);?></dd>

			</dl>
			<dl class="summary">
				<dt><?php @print($__Context->lang->today);?></dt>
				<dd><?php @print(number_format($__Context->status->visitor));?></dd>
				<dt><?php @print($__Context->lang->this_week);?></dt>
				<dd><?php @print(number_format($__Context->status->thisWeekSum));?></dd>
				<dt><?php @print($__Context->lang->total);?></dt>
				<dd><?php @print(number_format($__Context->status->total_visitor));?></dd>
			</dl>
			<div class="graph">
				<?php $__Context->Context->__idx[0]=0;if(count($__Context->status->week))  foreach($__Context->status->week as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
				<dl>
					<dt><?php  if($__Context->key==date("Ymd")){ ?><strong><?php @print($__Context->key);?></strong><?php  }else{ ?><?php @print($__Context->key);?><?php  } ?></dt>
					<dd class="past" style="height:<?php @print($__Context->val->last/$__Context->status->week_max * 100);?>%" title="<?php @print($__Context->lang->last_week);?>:<?php @print(number_format($__Context->val->last));?>"><span><?php @print($__Context->lang->last_week);?>:<?php @print(number_format($__Context->val->last));?></span></dd>
					<dd class="today" style="height:<?php @print($__Context->val->this/$__Context->status->week_max * 100);?>%" title="<?php @print($__Context->lang->this_week);?>:<?php @print(number_format($__Context->val->this));?>"><span><?php @print($__Context->lang->this_week);?>:<?php @print(number_format($__Context->val->this));?></span></dd>

				</dl>
				<?php  } ?>
			</div>
		</div>
	</div>
	<!-- /Visotors Graph -->

	<div class="section">
	<h4 class="dashboardH4"><?php @print($__Context->lang->env_information);?> <a href="<?php @print(getUrl('','module','admin','act','dispAdminConfig'));?>"><?php @print($__Context->lang->cmd_setup);?></a></h4>
        <?php  if(version_compare($__Context->current_version, $__Context->released_version, '<')){ ?>
        <p class="summary red"><?php @print(nl2br($__Context->lang->about_download_link));?> [<a href="<?php @print($__Context->download_link);?>" onclick="window.open(this.href);return false;"><?php @print($__Context->lang->cmd_download);?></a>]</p>
        <?php  } ?>
        <table>
		<col width="160" />
		<col width="*" />
        <tbody>
        <tr>
            <th><div><?php @print($__Context->lang->current_version);?></div></th>
            <td class="wide">
                <strong><?php @print($__Context->current_version);?></strong><?php  if($__Context->current_version == $__Context->released_version){ ?> [<a href="<?php @print($__Context->download_link);?>" onclick="window.open(this.href);return false;"><?php @print($__Context->lang->cmd_view);?></a>]<?php  } ?>
            </td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->current_path);?></div></th>
            <td><?php @print($__Context->installed_path);?>/</td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->start_module);?></div></th>
            <td><a href="<?php @print(getSiteUrl('','','mid',$__Context->start_module->mid));?>" onclick="window.open(this.href);return false;"><?php @print($__Context->start_module->browser_title);?></a></td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->time_zone);?></div></th>
            <td><?php $__Context->Context->__idx[1]=0;if(count($__Context->time_zone_list))  foreach($__Context->time_zone_list as $__Context->key => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?><?php  if($__Context->time_zone==$__Context->key){ ?><?php @print(substr($__Context->val,1,10));?><?php  } ?><?php  } ?></td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->use_rewrite);?></div></th>
            <td><?php  if($__Context->use_rewrite=='Y'){ ?><?php @print($__Context->lang->use);?><?php  }else{ ?><?php @print($__Context->lang->notuse);?><?php  } ?></td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->use_sso);?></div></th>
            <td><?php  if($__Context->use_sso=='Y'){ ?><?php @print($__Context->lang->use);?><?php  }else{ ?><?php @print($__Context->lang->notuse);?><?php  } ?></td>
        </tr>
		<tr>
			<th><div><?php @print($__Context->lang->mobile_view);?></div></th>
			<td><?php  if($__Context->use_mobile_view=='Y'){ ?><?php @print($__Context->lang->use);?><?php  }else{ ?><?php @print($__Context->lang->notuse);?><?php  } ?></td>
		</tr>
        <tr>
            <th><div>Language</div></th>
            <td><?php $__Context->Context->__idx[2]=0;if(count($__Context->lang_supported))  foreach($__Context->lang_supported as $__Context->key => $__Context->val){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?><?php  if($__Context->key == $__Context->selected_lang){ ?><?php @print($__Context->val);?><?php  } ?><?php  } ?></td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->qmail_compatibility);?></div></th>
            <td><?php  if($__Context->qmail_compatibility=='Y'){ ?><?php @print($__Context->lang->use);?><?php  }else{ ?><?php @print($__Context->lang->notuse);?><?php  } ?></td>
        </tr>
        <tr>
            <th><div><?php @print($__Context->lang->use_db_session);?></div></th>
            <td><?php  if($__Context->use_db_session =='Y'){ ?><?php @print($__Context->lang->use);?><?php  }else{ ?><?php @print($__Context->lang->notuse);?><?php  } ?></td>
        </tr>
        </tbody>
        </table>
	</div>
</div>

<div class="extension e2">
    <div class="section">
		<div class="contentBox">
			<span class="button"><input type="button" value="<?php @print($__Context->lang->cmd_remake_cache);?>" onclick="doRecompileCacheFile(); return false;"/></span>
			<span class="button"><input type="button" value="<?php @print($__Context->lang->cmd_clear_session);?>" onclick="doClearSession(); return false; "/></span>
		</div>
	</div>

	<?php @$__Context->_show_modules = false;;?>
	<?php $__Context->Context->__idx[3]=0;if(count($__Context->module_list))  foreach($__Context->module_list as $__Context->key => $__Context->val){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
		<?php  if($__Context->val->need_install || $__Context->val->need_update){ ?>
			<?php @$__Context->_show_modules = true;;?>
		<?php  } ?>
	<?php  } ?>
	<?php  if($__Context->_show_modules){ ?>
	<div class="section">
        <table>
		<thead>
			<th colspan="2"><?php @print($__Context->lang->module);?></th>
		</thead>
        <tbody>
        <?php $__Context->Context->__idx[4]=0;if(count($__Context->module_list))  foreach($__Context->module_list as $__Context->key => $__Context->val){$__Context->__idx[5]=($__Context->__idx[5]+1)%2; $__Context->cycle_idx = $__Context->__idx[5]+1; ?>
			<?php  if($__Context->val->need_install || $__Context->val->need_update){ ?>
            <tr>
                <th><a href="<?php @print(getUrl('','module','admin','act',$__Context->val->admin_index_act));?>" title="<?php @print(trim(htmlspecialchars($__Context->val->description)));?>"><?php @print($__Context->val->title);?></a> (<?php @print($__Context->val->module);?>)</th>
                <td class="alert">
                    <?php  if($__Context->val->need_install){ ?>
                        <a href="#" onclick="doInstallModule('<?php @print($__Context->val->module);?>');return false;" title="<?php @print(htmlspecialchars($__Context->lang->cmd_install));?>"><?php @print($__Context->lang->cmd_install);?></a>
                    <?php  }elseif($__Context->val->need_update){ ?>
                        <a href="#" onclick="doUpdateModule('<?php @print($__Context->val->module);?>'); return false;" title="<?php @print(htmlspecialchars($__Context->lang->cmd_update));?>"><?php @print($__Context->lang->cmd_update);?></a>
                    <?php  }else{ ?>
					&nbsp;
                    <?php  } ?>
                </td>
            </tr>
			<?php  } ?>
        <?php  } ?>
        </tbody>
        </table>
	</div>
	<?php  } ?>

	<?php  if($__Context->news){ ?>
    <div class="section">
        <table>
		<thead>
			<th colspan="2"><?php @print($__Context->lang->newest_news);?></th>
		</thead>
        <tbody>
        <?php $__Context->Context->__idx[5]=0;if(count($__Context->news))  foreach($__Context->news as $__Context->key => $__Context->val){$__Context->__idx[6]=($__Context->__idx[6]+1)%2; $__Context->cycle_idx = $__Context->__idx[6]+1; ?>
        <tr>
			<th><a href="<?php @print($__Context->val->url);?>" onclick="window.open(this.href);return false;" class="fl"><?php @print(cut_str($__Context->val->title,36));?></a></th>
            <td><span class="date fr"><?php @print(zdate($__Context->val->date,"y-m-d"));?></span></td>
        </tr>
        <?php  } ?>
        </tbody>
        </table>
	</div>
	<?php  } ?>

	<div class="section">
		<form id="fo_addon" action="./" method="get">
			<input type="hidden" name="addon" value="" />
		</form>
		<table>
		<thead>
			<tr>
				<th><?php @print($__Context->lang->addon);?></th>
				<th><?php @print($__Context->lang->cmd_setup);?></th>
				<th>PC</th>
				<th>Mobile</th>
			</tr>
		</thead>
		<tbody>
		<?php $__Context->Context->__idx[6]=0;if(count($__Context->addon_list))  foreach($__Context->addon_list as $__Context->key => $__Context->val){$__Context->__idx[7]=($__Context->__idx[7]+1)%2; $__Context->cycle_idx = $__Context->__idx[7]+1; ?>
		<tr>
			<th><a href="<?php @print(getUrl('','module','addon','act','dispAddonAdminInfo','selected_addon',$__Context->val->addon));?>" onclick="popopen(this.href,'addon_info');return false"><?php @print(cut_str($__Context->val->title,24));?></a></th>
			<td class="center"><a href="<?php @print(getUrl('','module','addon','act','dispAddonAdminSetup','selected_addon',$__Context->val->addon));?>" onclick="popopen(this.href,'addon_info');return false" class="buttonSet buttonSetting"><span><?php @print($__Context->lang->cmd_setup);?></span></a></td>
			<td class="center">
				<?php  if($__Context->val->activated){ ?>
				<a href="#" onclick="doToggleAddonInAdmin(this, '<?php @print($__Context->val->addon);?>');return false;" title="<?php @print(htmlspecialchars($__Context->lang->use));?>" class="buttonSet buttonActive"><span><?php @print($__Context->lang->use);?></span></a>
				<?php  }else{ ?>
				<a href="#" onclick="doToggleAddonInAdmin(this, '<?php @print($__Context->val->addon);?>');return false;" title="<?php @print(htmlspecialchars($__Context->lang->notuse));?>" class="buttonSet buttonDisable"><span><?php @print($__Context->lang->notuse);?></span></a>
				<?php  } ?>
			</td>
			<td class="center">
				<?php  if($__Context->val->mactivated){ ?>
				<a href="#" onclick="doToggleAddonInAdmin(this, '<?php @print($__Context->val->addon);?>', 'mobile');return false;" title="<?php @print(htmlspecialchars($__Context->lang->use));?>" class="buttonSet buttonActive"><span><?php @print($__Context->lang->use);?></span></a>
				<?php  }else{ ?>
				<a href="#" onclick="doToggleAddonInAdmin(this, '<?php @print($__Context->val->addon);?>', 'mobile');return false;" title="<?php @print(htmlspecialchars($__Context->lang->notuse));?>" class="buttonSet buttonDisable"><span><?php @print($__Context->lang->notuse);?></span></a>
				<?php  } ?>
			</td>
		</tr>
		<?php  } ?>
		</tbody>
		</table>
    </div>
</div>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/admin/tpl/','_footer.html');
?>

