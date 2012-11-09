<?php if(!defined("__ZBXE__")) exit();?><!--#Meta:/bettershop/xe/layouts/xe_official/js/xe_official.js--><?php Context::addJsFile("/bettershop/xe/layouts/xe_official/js/xe_official.js",false,"",null,"head"); ?>
<?php if($__Context->layout_info->colorset=='default') { ?><!--#Meta:/bettershop/xe/layouts/xe_official/css/default.css--><?php Context::addCSSFile("/bettershop/xe/layouts/xe_official/css/default.css",false,"","",null); ?>
<?php } ?><?php if($__Context->layout_info->colorset=='white') { ?><!--#Meta:/bettershop/xe/layouts/xe_official/css/white.css--><?php Context::addCSSFile("/bettershop/xe/layouts/xe_official/css/white.css",false,"","",null); ?>
<?php } ?><?php if($__Context->layout_info->colorset=='black') { ?><!--#Meta:/bettershop/xe/layouts/xe_official/css/black.css--><?php Context::addCSSFile("/bettershop/xe/layouts/xe_official/css/black.css",false,"","",null); ?>
<?php } ?><?php if($__Context->layout_info->background_image) { ?><style type="text/css">
body{background:url(<?php @print(getUrl());?><?php @print($__Context->layout_info->background_image);?>) repeat-x left top;}
</style><?php } ?>
<?php  if(!$__Context->layout_info->colorset){ ?><?php @$__Context->layout_info->colorset = "default";?><?php  } ?>
<div class="xe">
	<div class="header">
		<h1>
			<?php if($__Context->layout_info->logo_image) { ?><a href="<?php @print($__Context->layout_info->index_url);?>"><img src="<?php @print($__Context->layout_info->logo_image);?>" alt="logo" border="0" class="iePngFix" /></a><?php } ?>
			<?php if(!$__Context->layout_info->logo_image) { ?><a href="<?php @print($__Context->layout_info->index_url);?>"><?php @print($__Context->layout_info->logo_image_alt);?></a><?php } ?>
		</h1>
		<div class="language">
			<strong title="<?php @print($__Context->lang_type);?>"><?php @print($__Context->lang_supported[$__Context->lang_type]);?></strong> <button type="button" class="toggle"><img src="/bettershop/xe/layouts/xe_official/images/<?php @print($__Context->layout_info->colorset);?>/buttonLang.gif" alt="Select Language" width="87" height="15" /></button>
			<ul class="selectLang">
				<?php if(count($__Context->lang_supported )) { foreach($__Context->lang_supported  as $__Context->key => $__Context->val) { ?><?php if($__Context->key!= $__Context->lang_type) { ?><li><button type="button" onclick="doChangeLangType('<?php @print($__Context->key);?>');return false;"><?php @print($__Context->val);?></button></li><?php } ?><?php } } ?>
			</ul>
		</div>
		<div class="gnb">
			<ul>
				<?php if(count($__Context->main_menu->list )) { foreach($__Context->main_menu->list  as $__Context->key1 => $__Context->val1) { ?><li<?php if($__Context->val1['selected']) {?> class="active"<?php }?>><a href="<?php @print($__Context->val1['href']);?>"<?php if($__Context->val1['open_window']=='Y') {?> target="_blank"<?php }?>><?php @print($__Context->val1['link']);?></a>
					<?php if($__Context->val1['list']) { ?><ul>
						<?php if(count($__Context->val1['list'] )) { foreach($__Context->val1['list']  as $__Context->key2 => $__Context->val2) { ?><li<?php if($__Context->val2['selected']) {?> class="active"<?php }?>><a href="<?php @print($__Context->val2['href']);?>"<?php if($__Context->val2['open_window']=='Y') {?> target="_blank"<?php }?>><?php @print($__Context->val2['link']);?></a></li><?php } } ?>
					</ul><?php } ?>
				</li><?php } } ?>
			</ul>
		</div>
		<form action="<?php @print(getUrl());?>" method="post" class="iSearch">
			<?php if($__Context->vid) { ?><input type="hidden" name="vid" value="<?php @print($__Context->vid);?>" />
			<?php } ?><input type="hidden" name="mid" value="<?php @print($__Context->mid);?>" />
			<input type="hidden" name="act" value="IS" />
			<input type="hidden" name="search_target" value="title_content" />
			<input name="is_keyword" type="text" class="iText" title="keyword" />
			<input type="image" src="/bettershop/xe/layouts/xe_official/images/<?php @print($__Context->layout_info->colorset);?>/buttonSearch.gif" alt="<?php @print($__Context->lang->cmd_search);?>" class="submit" />
		</form>
	</div>
	<div class="body">
		<div class="lnb">
			<img widget="login_info" skin="xe_official" colorset="<?php @print($__Context->layout_info->colorset);?>" />
			<?php if(count($__Context->main_menu->list )) { foreach($__Context->main_menu->list  as $__Context->key1 => $__Context->val1) { ?><?php if($__Context->val1['selected']) { ?><h2><a href="<?php @print($__Context->val1['href']);?>"<?php if($__Context->val1['open_window']=='Y') {?> target="_blank"<?php }?>><?php @print($__Context->val1['link']);?></a></h2><?php } ?><?php } } ?>
			<?php if(count($__Context->main_menu->list )) { foreach($__Context->main_menu->list  as $__Context->key1 => $__Context->val1) { ?><?php if($__Context->val1['selected'] && $__Context->val1['list']) { ?><ul class="locNav">
				<?php if(count($__Context->val1['list'] )) { foreach($__Context->val1['list']  as $__Context->key2 => $__Context->val2) { ?><li<?php if($__Context->val2['selected']) {?> class="active"<?php }?>><a href="<?php @print($__Context->val2['href']);?>"<?php if($__Context->val2['open_window']=='Y') {?> target="_blank"<?php }?>><?php @print($__Context->val2['link']);?></a>
					<?php if($__Context->val2['list']) { ?><ul>
						<?php if(count($__Context->val2['list'] )) { foreach($__Context->val2['list']  as $__Context->key3 => $__Context->val3) { ?><li<?php if($__Context->val3['selected']) {?> class="active"<?php }?>><a href="<?php @print($__Context->val3['href']);?>"<?php if($__Context->val3['open_window']=='Y') {?> target="_blank"<?php }?>><?php @print($__Context->val3['link']);?></a></li><?php } } ?>
					</ul><?php } ?>
				</li><?php } } ?>
			</ul><?php } ?><?php } } ?>
		</div>
		<div class="content xe_content">
			<?php @print($__Context->content);?>
		</div>
	</div>
	<div class="footer">
		<p><a href="http://xpressengine.com/" target="_blank">Powered by <strong>XE</strong></a></p>
	</div>
</div>
