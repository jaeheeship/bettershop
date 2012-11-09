<?php if(!defined("__ZBXE__")) exit();?>

<?php Context::loadLang("./modules/bodex/skins/ex_default/lang"); ?>

<?php @$__Context->iframe_include = (Context::get('is_iframe') == '1');
    $__Context->default_style = $__Context->module_info->default_style?$__Context->module_info->default_style:($__Context->listStyle?$__Context->listStyle:'list');
    $__Context->module_info->duration_new = 60 * 60 * $__Context->module_info->duration_new;;?>

<?php if(!in_array($__Context->module_info->default_style,array('memo','blog')) && in_array($__Context->listStyle, array('list','webzine','gallery','review','download'))) { ?>
    <?php @$__Context->default_style = $__Context->listStyle;?>
<?php } ?>

<?php if($__Context->default_style == 'review') { ?>
    <?php @$__Context->default_style = 'download';
        $__Context->module_info->use_media_player=='Y';;?>
<?php } ?>

<?php if($__Context->best_document_list && count($__Context->best_document_list)) { ?>
    <?php @$__Context->notice_list = array_merge((array)$__Context->notice_list, (array)$__Context->best_document_list);?>
<?php } ?>

<?php if($__Context->module_info->use_allow_view == 'Y' && ($__Context->module_info->content_cut_size < 1 || $__Context->module_info->content_cut_size > $__Context->module_info->allow_view_cut_size)) { ?>
    <?php @$__Context->module_info->content_cut_size = $__Context->module_info->allow_view_cut_size;?>
<?php } ?>

<?php @// download, review 일땐 리뷰 셋팅
    $__Context->is_review = ($__Context->module_info->display_review_style == 'Y' || $__Context->default_style == 'download');

    // 보조 컬러셋 설정
    $__Context->arr_sub_colorset1 = explode(',',$__Context->module_info->sub_colorset1);
    $__Context->arr_sub_colorset2 = explode(',',$__Context->module_info->sub_colorset2);

    // 컬러셋 체크
    $__Context->module_info->colorset = ($__Context->module_info->colorset)?$__Context->module_info->colorset:'white';
    $__Context->btn_class = ($__Context->module_info->colorset == 'black')? 'black':'';

    // 정렬 바꿈
    $__Context->order_type = ($__Context->order_type == 'desc')?'asc':'desc';

    // 닉네임 색상
    $__Context->arr_login_nickname_color = explode(',',$__Context->module_info->login_nickname_color);

    // 분류 넓이
    $__Context->arr_category_width = explode(',',$__Context->module_info->category_width);;?>

<!--#Meta:./modules/bodex/skins/ex_default/css/common.css--><?php Context::addCSSFile("./modules/bodex/skins/ex_default/css/common.css", true, "all", "", null); ?>
<?php if($__Context->act == 'dispBoardWrite' || $__Context->module_info->display_simple_writer != 'N') { ?><!--#Meta:./modules/bodex/skins/ex_default/css/write.css--><?php Context::addCSSFile("./modules/bodex/skins/ex_default/css/write.css", true, "all", "", null); ?><?php } ?>
<?php if($__Context->module_info->default_style == 'blog' || in_array($__Context->act,array('dispBoardReplyComment','dispBoardModifyComment')) || ($__Context->oDocument && $__Context->oDocument->isExists())) { ?><!--#Meta:./modules/bodex/skins/ex_default/css/view.css--><?php Context::addCSSFile("./modules/bodex/skins/ex_default/css/view.css", true, "all", "", null); ?><?php } ?>

<?php @Context::addCSSFile($__Context->tpl_path.'css/'.$__Context->default_style.'.css');
    Context::addCSSFile($__Context->tpl_path.'css/'.$__Context->module_info->colorset.'.css');;?>

<?php if($__Context->arr_category_width[1] || $__Context->arr_sub_colorset1[0] || $__Context->arr_sub_colorset2[0] || $__Context->module_info->document_custom_css) { ?><style type="text/css">
    <?php if($__Context->module_info->document_custom_css) { ?><?php @print($__Context->module_info->document_custom_css);?><?php } ?>
    <?php if($__Context->arr_category_width[1] || $__Context->arr_sub_colorset1[0] || $__Context->arr_sub_colorset2[0]) { ?><?php
$__Context->oTemplate = &TemplateHandler::getInstance();
print $__Context->oTemplate->compile('./modules/bodex/skins/ex_default/','css/_custom.html');
?>

<?php } ?></style><?php } ?>

<?php if(($__Context->oDocument && $__Context->oDocument->isExists()) || $__Context->default_style == 'download' || $__Context->module_info->default_style == 'memo') { ?><script>
    var _exJsMessage = new Array();
    _exJsMessage['enter_password'] = '<?php @print($__Context->lang->msg_enter_password);?>';
    _exJsMessage['download_point'] = '<?php @print($__Context->lang->msg_download_point);?>';
    _exJsMessage['enter_comment'] = '<?php @print($__Context->lang->msg_not_allow_down);?>';
</script><?php } ?>

<!--#Meta:./modules/bodex/skins/ex_default/css/skin.js--><?php Context::addJsFile("./modules/bodex/skins/ex_default/css/skin.js", true, "", null, "head"); ?>

<?php if($__Context->iframe_include) { ?><script type="text/javascript">
    completeInsertComment = _exJsIframeCompleteComment;
    completeDeleteComment = _exJsIframeCompleteComment;
    xAddEventListener(window, 'load', _exJsIframeResizeHeight);
</script><?php } ?>

