<?php if(!defined("__ZBXE__")) exit();?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/admin/tpl/','_header.html');
?>


<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/admin/tpl/./filter/","update_env_config.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/admin/tpl/./filter/","update_lang_select.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/admin/tpl/./filter/","install_ftp_info.xml");
$__Context->oXmlFilter->compile();
?>

<?php
require_once("./classes/xml/XmlJsFilter.class.php");
$__Context->oXmlFilter = new XmlJSFilter("./modules/admin/tpl/./filter/","install_ftp_path.xml");
$__Context->oXmlFilter->compile();
?>

<?php Context::loadLang("./modules/admin/tpl/../../install/lang"); ?>
<!--#Meta:./modules/admin/tpl/../../install/tpl/js/install_admin.js--><?php Context::addJsFile("./modules/admin/tpl/../../install/tpl/js/install_admin.js", false, "", null, "head"); ?>
<!--#Meta:./modules/admin/tpl/./js/config.js--><?php Context::addJsFile("./modules/admin/tpl/./js/config.js", true, "", null, "head"); ?>

<script type="text/javascript">
    function insertSelectedModule(id, module_srl, mid, browser_title) {
        var obj= xGetElementById('_'+id);
        var sObj = xGetElementById(id);
        sObj.value = module_srl;
        obj.value = decodeURIComponent(browser_title.replace(/\+/g," "))+' ('+mid+')';
    }
    var xe_root = "<?php @print(_XE_PATH_);?>";
</script>

<div class="content">

    <h4 class="xeAdmin"><?php @print($__Context->lang->cmd_setup);?></h4>

    <form action="./" method="get" onsubmit="return procFilter(this, update_env_config);">
    <table cellspacing="0" class="rowTable">
    <tr>
        <th><div><?php @print($__Context->lang->use_rewrite);?></div></th>
        <td>
            <input type="checkbox" name="use_rewrite" value="Y"  <?php  if($__Context->use_rewrite=='Y'){ ?>checked="checked"<?php  } ?> />
            <p><?php @print($__Context->lang->about_rewrite);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->use_sso);?></div></th>
        <td>
            <input type="checkbox" name="use_sso" value="Y"  <?php  if($__Context->use_sso=='Y'){ ?>checked="checked"<?php  } ?> />
			<p><?php @print($__Context->lang->about_sso);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->default_url);?></div></th>
        <td>
            <input type="text" name="default_url" value="<?php @print($__Context->default_url);?>" class="inputTypeText w300"/>
            <p><?php @print($__Context->lang->about_default_url);?></p>
        </td>
    </tr>
    <tr>
        <th scope="row"><div><?php @print($__Context->lang->start_module);?></div></th>
        <td>
            <input type="hidden" name="index_module_srl" id="target_module" value="<?php @print($__Context->start_module->index_module_srl);?>" />
            <input type="text" name="_target_module" id="_target_module" class="inputTypeText w300" value="<?php @print($__Context->start_module->mid);?> (<?php @print(htmlspecialchars($__Context->start_module->browser_title));?>)" readonly="readonly" />
			<a href="<?php @print(getUrl('','module','module','act','dispModuleSelectList','id','target_module','type','single'));?>" onclick="popopen(this.href,'ModuleSelect');return false;" class="button green"><span><?php @print($__Context->lang->cmd_select);?></span></a>
        </td>
    </tr>
    <tr>
        <th><div>Language</div></th>
        <td>
            <select name="change_lang_type">
                <?php $__Context->Context->__idx[0]=0;if(count($__Context->lang_supported))  foreach($__Context->lang_supported as $__Context->key => $__Context->val){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
                    <option value="<?php @print($__Context->key);?>" <?php  if($__Context->key==$__Context->selected_lang){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
                <?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_lang_env);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->time_zone);?></div></th>
        <td>
            <select name="time_zone" class="fullWidth">
                <?php $__Context->Context->__idx[1]=0;if(count($__Context->time_zone_list))  foreach($__Context->time_zone_list as $__Context->key => $__Context->val){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->time_zone==$__Context->key){ ?>selected="selected"<?php  } ?>><?php @print($__Context->val);?></option>
                <?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_time_zone);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->qmail_compatibility);?></div></th>
        <td>
            <input type="checkbox" name="qmail_compatibility" value="Y"  <?php  if($__Context->qmail_compatibility=='Y'){ ?>checked="checked"<?php  } ?> />
            <p><?php @print($__Context->lang->about_qmail_compatibility);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->use_db_session);?></div></th>
        <td>
            <input type="checkbox" name="use_db_session" value="Y"  <?php  if($__Context->use_db_session=='Y'){ ?>checked="checked"<?php  } ?> />
            <p><?php @print($__Context->lang->about_db_session);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->use_ssl);?></div></th>
        <td>
            <select name="use_ssl">
            <?php $__Context->Context->__idx[2]=0;if(count($__Context->lang->ssl_options))  foreach($__Context->lang->ssl_options as $__Context->key => $__Context->val){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
                <option value="<?php @print($__Context->key);?>" <?php  if($__Context->key == $__Context->use_ssl){ ?>selected<?php  } ?> ><?php @print($__Context->val);?></option>
            <?php  } ?>
            </select>
            <p><?php @print($__Context->lang->about_use_ssl);?></p>
        </td>
    </tr>
    <tr>
        <th><div><?php @print($__Context->lang->server_ports);?></div></th>
        <td>
            HTTP : <input type="text" name="http_port" class="inputTypeText" size="5" value="<?php @print($__Context->http_port);?>">, 
            HTTPS: <input type="text" name="https_port" class="inputTypeText" size="5" value="<?php @print($__Context->https_port);?>">
            <p><?php @print($__Context->lang->about_server_ports);?></p>
        </td>
    </tr>
	<tr>
		<th><div><?php @print($__Context->lang->mobile_view);?></div></th>
        <td>
            <input type="checkbox" name="use_mobile_view" value="Y"  <?php  if($__Context->use_mobile_view=='Y'){ ?>checked="checked"<?php  } ?> />
            <p><?php @print($__Context->lang->about_mobile_view);?></p>
        </td>
	</tr>
    <tr>
        <th colspan="2" class="button">
            <span class="button black strong"><input type="submit" value="<?php @print($__Context->lang->cmd_save);?>" /></span>
        </th>
    </tr>
    </table>
    </form>


    <h4 class="xeAdmin" id="ftpSetup"><?php @print($__Context->lang->ftp_form_title);?></h4>
    <p class="summary"><?php @print($__Context->lang->about_ftp_info);?></p>
    <form action="./" method="post" onsubmit="return procFilter(this, install_ftp_info);" id="ftp_form">
    <table cellspacing="0" class="rowTable">

    <tr>
        <th scope="col"><div><label for="textfield21"><?php @print($__Context->lang->user_id);?></label></div></th>
        <td><input type="text" id="textfield21" name="ftp_user" value="<?php @print($__Context->ftp_info->ftp_user);?>" class="inputTypeText" />
    </tr>
    <tr>
        <th scope="col"><div><label for="textfield22"><?php @print($__Context->lang->password);?> (<?php @print($__Context->lang->about_ftp_password);?>)</label></div></th>
        <td><input id="textfield22" type="password" name="ftp_password" value="" class="inputTypeText" /></td>
    </tr>
    <tr>
        <th scope="col"><div><label for="textfield23"><?php @print($__Context->lang->ftp_host);?> (default: 127.0.0.1)</label></div></th>
        <td><input id="textfield23" type="text" name="ftp_host" value="<?php @print($__Context->ftp_info->ftp_host);?>" class="inputTypeText" /></td> 
    </tr>
    <tr>
        <th scope="col"><div><label for="textfield24"><?php @print($__Context->lang->ftp_port);?> (default: 21) </label></div></th>
        <td><input id="textfield24" type="text" name="ftp_port" value="<?php @print($__Context->ftp_info->ftp_port);?>" class="inputTypeText" /></td>
    </tr>
	<tr>
		<th scope="col"><div><label for="checkboxpasv">FTP Passive mode</label></div></th>
		<td><input type="checkbox" id="checkboxpasv" name="ftp_pasv" value="Y" <?php  if($__Context->ftp_info->ftp_pasv!="N"){ ?>checked="checked"<?php  } ?> /></td>
	</tr>
    <?php  if($__Context->sftp_support){ ?>
    <tr>
        <th scope="col"><div><label for="checkbox25"><?php @print($__Context->lang->sftp);?></label></div></th>
        <td><input type="checkbox" id="checkbox25" name="sftp" value="Y" <?php  if($__Context->ftp_info->sftp=="Y"){ ?>checked="checked"<?php  } ?> /></td>
    </tr>
    <?php  } ?>
    <tr>
        <th scope="col" rowspan="2"><div><?php @print($__Context->lang->msg_ftp_installed_ftp_realpath);?><br /><br/><?php @print($__Context->lang->msg_ftp_installed_realpath);?>:<br/> <?php @print(_XE_PATH_);?></div></th>
        <td>
            <input type="text" name="ftp_root_path" value="<?php @print($__Context->ftp_info->ftp_root_path);?>" class="inputTypeText w400" /> 
        </td>
    </tr>
    <tr id="ftplist">
        <td>
            <div>
					<span class="button blue strong"><input type="button" onclick="getFTPList(); return false;" value="<?php @print($__Context->lang->ftp_get_list);?>"></span>
            </div>
        </td>
    </tr>
    <tr>
        <th colspan="2" class="button">
            <span class="button blue strong"><input type="button" onclick="removeFTPInfo(); return false;" value="<?php @print($__Context->lang->ftp_remove_info);?>"></span>
            <span class="button black strong"><input type="submit" value="<?php @print($__Context->lang->cmd_registration);?>" /></span>
        </th>
    </tr>
    </table>
    </form>
</div>

<hr />

<div class="extension e2">
    <div class="section">

        <h4 class="xeAdmin"><?php @print($__Context->lang->cmd_lang_select);?></h4>
        <p class="summary"><?php @print($__Context->lang->about_cmd_lang_select);?></p>
        <form action="./" method="get" onsubmit="return procFilter(this, update_lang_select);">
        <table cellspacing="0" class="rowTable">
        <?php $__Context->Context->__idx[3]=0;if(count($__Context->langs))  foreach($__Context->langs as $__Context->key => $__Context->val){$__Context->__idx[4]=($__Context->__idx[4]+1)%2; $__Context->cycle_idx = $__Context->__idx[4]+1; ?>
        <tr>
            <td>
				<?php  if($__Context->key==$__Context->selected_lang){ ?>
					<input type="hidden" name="selected_lang[]" value="<?php @print($__Context->key);?>" />
					<input type="checkbox" checked="checked" disabled="disabled" />
					<label><?php @print($__Context->val);?></label>
				<?php  }else{ ?>
					<input id="lang_<?php @print($__Context->key);?>" type="checkbox" name="selected_lang[]" value="<?php @print($__Context->key);?>" <?php  if(isset($__Context->lang_selected[$__Context->key])){ ?>checked="checked"<?php  } ?> />
					<label for="lang_<?php @print($__Context->key);?>"><?php @print($__Context->val);?></label>
				<?php  } ?>
            </td>
        </tr>
        <?php  } ?>
        <tr>
            <th class="button">
                <span class="button black strong"><input type="submit" value="<?php @print($__Context->lang->cmd_save);?>" /></span>
            </th>
        </tr>
        </table>
        </form>

        <h4 class="xeAdmin"><?php @print($__Context->lang->cmd_remake_cache);?></h4>
        <p class="summary"><?php @print($__Context->lang->about_recompile_cache);?></p>
        <table cellspacing="0" class="colTable">
        <tr>
            <th class="button">
                <span class="button black strong"><input type="button" value="<?php @print($__Context->lang->cmd_remake_cache);?>" onclick="doRecompileCacheFile(); return false;"/></span>
            </th>
        </tr>
        </table>
    </div>
</div>

<?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/admin/tpl/','_footer.html');
?>

