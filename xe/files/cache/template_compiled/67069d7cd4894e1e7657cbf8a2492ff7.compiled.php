<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:./modules/admin/tpl/css/layout.css--><?php Context::addCSSFile("./modules/admin/tpl/css/layout.css", true, "all", "", null); ?>
<!--#Meta:./modules/admin/tpl/js/admin.js--><?php Context::addJsFile("./modules/admin/tpl/js/admin.js", true, "", null, "head"); ?>
<div id="xeAdmin" class="<?php  if($__Context->package_selected || strstr($__Context->act,'Autoinstall')){ ?>c<?php  }elseif(!$__Context->act || ($__Context->act == 'dispAdminIndex' || $__Context->act == 'dispAdminConfig')){ ?>ece<?php  }else{ ?>ec<?php  } ?>">
	<div class="header">
		<h1 class="xeAdmin"><a href="<?php @print(getUrl('','module','admin'));?>">XpressEngine</a></h1>
		<ul class="gnb">
            <li><a href="<?php @print(getUrl('module','admin','act','procAdminLogout'));?>">Sign out</a></li>
			<?php  if($__Context->logged_info->is_admin=='Y'){ ?><li><a href="<?php @print(getUrl('','module','admin','act','dispAdminConfig'));?>">Settings</a></li><?php  } ?>
			<li><a href="#" onclick="toggleAdminLang();return false;">Language</a>
				<ul id="adminLang">
                    <?php $__Context->Context->__idx[7]=0;if(count($__Context->lang_supported))  foreach($__Context->lang_supported as $__Context->key => $__Context->val){$__Context->__idx[8]=($__Context->__idx[8]+1)%2; $__Context->cycle_idx = $__Context->__idx[8]+1; ?>
					<li <?php  if($__Context->key == $__Context->lang_type){ ?>class="open"<?php  } ?>><a href="#" onclick="doChangeLangType('<?php @print($__Context->key);?>'); return false;"><?php @print($__Context->val);?></a></li>
                    <?php  } ?>
				</ul>
			</li>
		</ul>
		<ul class="lnb">
			<li class="core <?php  if(!$__Context->package_selected && !strstr($__Context->act,'Autoinstall')){ ?>selected<?php  } ?>"><a href="<?php @print(getUrl('','module','admin'));?>"><?php @print($__Context->lang->control_panel);?></a></li>
			<li class="core <?php  if(strstr($__Context->act, 'Autoinstall')){ ?>selected<?php  } ?>"><a href="<?php @print(getUrl('','module','admin','act','dispAutoinstallAdminIndex'));?>"><?php @print($__Context->lang->autoinstall);?></a></li>

            <?php $__Context->Context->__idx[8]=0;if(count($__Context->package_modules))  foreach($__Context->package_modules as $__Context->key => $__Context->val){$__Context->__idx[9]=($__Context->__idx[9]+1)%2; $__Context->cycle_idx = $__Context->__idx[9]+1; ?>
                <li class="<?php @print($__Context->val->position);?> <?php  if($__Context->val->selected){ ?>selected<?php  } ?>"><a href="<?php @print(getUrl('','module','admin','act',$__Context->val->index_act));?>" title="<?php @print(trim($__Context->val->description));?>"><?php @print($__Context->val->title);?></a></li>
            <?php  } ?>
		</ul>
	</div>
	<hr />
	<div class="body">
		<div class="extension e1">
			<div class="section">

				<div id="search_nav">
					<input type="text" size="12" />
					<button type="button"></button>
				</div>

				<ul class="navigation">
					<?php @$__Context->_c = explode(',',$__Context->_COOKIE['XEAM']);?>
                    <?php $__Context->Context->__idx[9]=0;if(count($__Context->lang->module_category_title))  foreach($__Context->lang->module_category_title as $__Context->key => $__Context->val){$__Context->__idx[10]=($__Context->__idx[10]+1)%2; $__Context->cycle_idx = $__Context->__idx[10]+1; ?>
						<?php  if($__Context->key != 'migration' && $__Context->key != 'interlock' && $__Context->key != 'statistics'){ ?>

						<?php  if(in_array($__Context->key,$__Context->_c)&&$__Context->key!=$__Context->selected_module_category){ ?>
							<?php @$__Context->_cs = true;;?>
						<?php  }else{ ?>
							<?php @$__Context->_cs = false;;?>
						<?php  } ?>
					<li id="module_<?php @print($__Context->key);?>" class="parent <?php  if($__Context->_cs){ ?>close<?php  } ?> <?php  if($__Context->key==$__Context->selected_module_category){ ?>active<?php  } ?>"><a href="#"  onclick="toggleModuleMenu('<?php @print($__Context->key);?>'); return false;" class="parent"><?php @print($__Context->val);?></a>
						<ul>
                            <?php $__Context->Context->__idx[10]=0;if(count($__Context->installed_modules))  foreach($__Context->installed_modules as $__Context->k => $__Context->v){$__Context->__idx[11]=($__Context->__idx[11]+1)%2; $__Context->cycle_idx = $__Context->__idx[11]+1; ?>
                            <?php  if($__Context->v->category == $__Context->key){ ?>
                            <li <?php  if($__Context->v->selected){ ?>class="active"<?php  } ?>><a href="<?php @print(getUrl('','module','admin','act',$__Context->v->index_act));?>" title="<?php @print($__Context->v->description);?>"><?php @print($__Context->v->title);?></a></li>
                            <?php  } ?>
                            <?php  } ?>
						</ul>
					</li>
                    <?php  } ?>
                    <?php  } ?>
                </ul>
            </div>
		</div>
		<hr />
