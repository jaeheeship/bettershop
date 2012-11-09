<?php if(!defined("__ZBXE__")) exit();?>
<!--#Meta:./modules/editor/skins/xpresseditor/css/default.css--><?php Context::addCSSFile("./modules/editor/skins/xpresseditor/css/default.css", true, "all", "", null); ?>

<!--#Meta:./modules/editor/skins/xpresseditor/../../tpl/js/editor_common.js--><?php Context::addJsFile("./modules/editor/skins/xpresseditor/../../tpl/js/editor_common.js", true, "", null, "head"); ?>

<?php  if($__Context->colorset == "black" || $__Context->colorset == "black_texteditor" || $__Context->colorset == "black_text_nohtml" || $__Context->colorset == "black_text_usehtml"){ ?>
    <!--#Meta:./modules/editor/skins/xpresseditor/css/black.css--><?php Context::addCSSFile("./modules/editor/skins/xpresseditor/css/black.css", true, "all", "", null); ?>
    <?php @$__Context->editor_class = "black";?>
<?php  } ?>

<?php  if($__Context->colorset == "white_texteditor" || $__Context->colorset == "black_texteditor" || $__Context->colorset == "white_text_nohtml" || $__Context->colorset == "black_text_nohtml" || $__Context->colorset == "white_text_usehtml" || $__Context->colorset == "black_text_usehtml"){ ?>
    <!--#Meta:./modules/editor/skins/xpresseditor/js/xe_textarea.js--><?php Context::addJsFile("./modules/editor/skins/xpresseditor/js/xe_textarea.js", true, "", null, "head"); ?>

    <div class="xeTextEditor <?php @print($__Context->editor_class);?>">
        <input type="hidden" id="htm_<?php @print($__Context->editor_sequence);?>" value="<?php  if($__Context->colorset == "white_text_nohtml" || $__Context->colorset == "black_text_nohtml"){ ?>n<?php  } ?><?php  if($__Context->colorset == "white_texteditor" || $__Context->colorset == "white_texteditor"){ ?>br<?php  } ?>" />
        <textarea id="editor_<?php @print($__Context->editor_sequence);?>" style="height:<?php @print($__Context->editor_height);?>px;" cols="50" rows="5" class="inputTextarea"></textarea>
    </div>
    <script type="text/javascript">//<![CDATA[
        editorStartTextarea(<?php @print($__Context->editor_sequence);?>, "<?php @print($__Context->editor_content_key_name);?>", "<?php @print($__Context->editor_primary_key_name);?>");
    //]]></script>

<?php  }else{ ?>

    <!--#Meta:./modules/editor/skins/xpresseditor/js/Xpress_Editor.js--><?php Context::addJsFile("./modules/editor/skins/xpresseditor/js/Xpress_Editor.js", true, "", null, "head"); ?>
    <!--#Meta:./modules/editor/skins/xpresseditor/js/xe_interface.js--><?php Context::addJsFile("./modules/editor/skins/xpresseditor/js/xe_interface.js", true, "", null, "head"); ?>

    <!-- 자동저장용 폼 -->

    <?php  if($__Context->enable_autosave){ ?>
    <input type="hidden" name="_saved_doc_title" value="<?php @print(htmlspecialchars($__Context->saved_doc->title));?>" />
    <input type="hidden" name="_saved_doc_content" value="<?php @print(htmlspecialchars($__Context->saved_doc->content));?>" />
    <input type="hidden" name="_saved_doc_message" value="<?php @print($__Context->lang->msg_load_saved_doc);?>" />
    <?php  } ?>
    <!-- 에디터 -->
    <div class="xpress-editor <?php @print($__Context->editor_class);?>">
        <div id="smart_content"> <a href="#xe-editor-container-<?php @print($__Context->editor_sequence);?>" class="skip">&raquo; <?php @print($__Context->lang->edit->jumptoedit);?></a>

        <?php  if($__Context->enable_default_component||$__Context->enable_component||$__Context->html_mode){ ?>
        <!-- 편집 컴포넌트 -->
        <div class="tool off">
            <?php  if($__Context->enable_default_component){ ?>
            <!-- 기본 컴포넌트 출력 -->
            <ul class="do item">
                <li class="xpress_xeditor_ui_undo undo"><button type="button" title="Ctrl+Z:<?php @print($__Context->lang->edit->undo);?>"><span><?php @print($__Context->lang->edit->undo);?></span></button></li>
                <li class="xpress_xeditor_ui_redo redo"><button type="button" title="Ctrl+Y:<?php @print($__Context->lang->edit->redo);?>"><span><?php @print($__Context->lang->edit->redo);?></span></button></li>
            </ul>
            <ul class="type">
                <li class="xpress_xeditor_ui_format">
                    <select class="xpress_xeditor_ui_format_select" disabled="disabled">
                        <option value=""><?php @print($__Context->lang->edit->header);?></option>
                        <?php $__Context->Context->__idx[0]=0;if(count($__Context->lang->edit->header_list))  foreach($__Context->lang->edit->header_list as $__Context->key=>$__Context->obj){$__Context->__idx[1]=($__Context->__idx[1]+1)%2; $__Context->cycle_idx = $__Context->__idx[1]+1; ?>
                        <option value="<?php @print($__Context->key);?>"><?php @print($__Context->obj);?></option>
                        <?php  } ?>
                    </select>
                </li>
                <li class="xpress_xeditor_ui_fontName">
                    <select class="xpress_xeditor_ui_fontName_select" disabled="disabled">
                        <option value=""><?php @print($__Context->lang->edit->fontname);?></option>
                        <?php $__Context->Context->__idx[1]=0;if(count($__Context->lang->edit->fontlist))  foreach($__Context->lang->edit->fontlist as $__Context->key=>$__Context->obj){$__Context->__idx[2]=($__Context->__idx[2]+1)%2; $__Context->cycle_idx = $__Context->__idx[2]+1; ?>
                        <option value="<?php @print($__Context->key);?>" style="font-family:<?php @print($__Context->key);?>"><?php @print($__Context->obj);?></option>
                        <?php  } ?>
                    </select>
                </li>
                <li class="xpress_xeditor_ui_fontSize">
                    <select class="xpress_xeditor_ui_fontSize_select" disabled="disabled">
                        <option value=""><?php @print($__Context->lang->edit->fontsize);?></option>
                        <option value="9px" style="font-size:9px">9px</option>
                        <option value="10px" style="font-size:10px">10px</option>
                        <option value="11px" style="font-size:11px">11px</option>
                        <option value="12px" style="font-size:12px">12px</option>
                        <option value="13px" style="font-size:13px">13px</option>
                        <option value="14px" style="font-size:14px">14px</option>
                        <option value="16px" style="font-size:16px">16px</option>
                        <option value="18px" style="font-size:18px">18px</option>
                        <option value="24px" style="font-size:24px">24px</option>
                        <option value="32px" style="font-size:32px">32px</option>
                    </select>
                </li>
                <li class="xpress_xeditor_ui_lineHeight">
                    <select class="xpress_xeditor_ui_lineHeight_select" disabled="disabled">
                        <option value=""><?php @print($__Context->lang->edit->lineheight);?></option>
                        <option value="1">100%</option>
                        <option value="1.2">120%</option>
                        <option value="1.4">140%</option>
                        <option value="1.6">160%</option>
                        <option value="1.8">180%</option>
                        <option value="2">200%</option>
                    </select>
                </li>
            </ul>
            <ul class="style">
                <li class="bold xpress_xeditor_ui_bold">
                    <button type="button" title="Ctrl+B:<?php @print($__Context->lang->edit->help_bold);?>"><span><?php @print($__Context->lang->edit->bold);?></span></button>
                </li>
                <li class="underline xpress_xeditor_ui_underline">
                    <button type="button" title="Ctrl+U:<?php @print($__Context->lang->edit->help_underline);?>"><span><?php @print($__Context->lang->edit->underline);?></span></button>
                </li>
                <li class="italic xpress_xeditor_ui_italic">
                    <button type="button" title="Ctrl+I:<?php @print($__Context->lang->edit->help_italic);?>"><span><?php @print($__Context->lang->edit->italic);?></span></button>
                </li>
                <li class="del xpress_xeditor_ui_lineThrough">
                    <button type="button" title="Ctrl+D:<?php @print($__Context->lang->edit->help_strike);?>"><span><?php @print($__Context->lang->edit->strike);?></span></button>
                </li>
                <li class="fcolor xpress_xeditor_ui_fontColor">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_fontcolor);?>"><span><?php @print($__Context->lang->edit->fontcolor);?></span></button>
                    <!-- 팔레트 레이어 -->
                    <div class="layer xpress_xeditor_fontcolor_layer" style="display:none;">
                        <ul class="palette xpress_xeditor_color_palette">
                            <li><button type="button" title="#ff0000" style="background:#ff0000"><span>#ff0000</span></button></li>
                            <li><button type="button" title="#ff6c00" style="background:#ff6c00"><span>#ff6c00</span></button></li>
                            <li><button type="button" title="#ffaa00" style="background:#ffaa00"><span>#ffaa00</span></button></li>
                            <li><button type="button" title="#ffef00" style="background:#ffef00"><span>#ffef00</span></button></li>
                            <li><button type="button" title="#a6cf00" style="background:#a6cf00"><span>#a6cf00</span></button></li>
                            <li><button type="button" title="#009e25" style="background:#009e25"><span>#009e25</span></button></li>
                            <li><button type="button" title="#00b0a2" style="background:#00b0a2"><span>#00b0a2</span></button></li>
                            <li><button type="button" title="#0075c8" style="background:#0075c8"><span>#0075c8</span></button></li>
                            <li><button type="button" title="#3a32c3" style="background:#3a32c3"><span>#3a32c3</span></button></li>
                            <li><button type="button" title="#7820b9" style="background:#7820b9"><span>#7820b9</span></button></li>
                            <li><button type="button" title="#ef007c" style="background:#ef007c"><span>#ef007c</span></button></li>
                            <li><button type="button" title="#000000" style="background:#000000"><span>#000000</span></button></li>
                            <li><button type="button" title="#252525" style="background:#252525"><span>#252525</span></button></li>
                            <li><button type="button" title="#464646" style="background:#464646"><span>#464646</span></button></li>
                            <li><button type="button" title="#636363" style="background:#636363"><span>#636363</span></button></li>
                            <li><button type="button" title="#7d7d7d" style="background:#7d7d7d"><span>#7d7d7d</span></button></li>
                            <li><button type="button" title="#9a9a9a" style="background:#9a9a9a"><span>#9a9a9a</span></button></li>
                            <li><button type="button" title="#ffe8e8" style="background:#ffe8e8"><span>#ffe8e8</span></button></li>
                            <li><button type="button" title="#f7e2d2" style="background:#f7e2d2"><span>#f7e2d2</span></button></li>
                            <li><button type="button" title="#f5eddc" style="background:#f5eddc"><span>#f5eddc</span></button></li>
                            <li><button type="button" title="#f5f4e0" style="background:#f5f4e0"><span>#f5f4e0</span></button></li>
                            <li><button type="button" title="#edf2c2" style="background:#edf2c2"><span>#edf2c2</span></button></li>
                            <li><button type="button" title="#def7e5" style="background:#def7e5"><span>#def7e5</span></button></li>
                            <li><button type="button" title="#d9eeec" style="background:#d9eeec"><span>#d9eeec</span></button></li>
                            <li><button type="button" title="#c9e0f0" style="background:#c9e0f0"><span>#c9e0f0</span></button></li>
                            <li><button type="button" title="#d6d4eb" style="background:#d6d4eb"><span>#d6d4eb</span></button></li>
                            <li><button type="button" title="#e7dbed" style="background:#e7dbed"><span>#e7dbed</span></button></li>
                            <li><button type="button" title="#f1e2ea" style="background:#f1e2ea"><span>#f1e2ea</span></button></li>
                            <li><button type="button" title="#acacac" style="background:#acacac"><span>#acacac</span></button></li>
                            <li><button type="button" title="#c2c2c2" style="background:#c2c2c2"><span>#c2c2c2</span></button></li>
                            <li><button type="button" title="#cccccc" style="background:#cccccc"><span>#cccccc</span></button></li>
                            <li><button type="button" title="#e1e1e1" style="background:#e1e1e1"><span>#e1e1e1</span></button></li>
                            <li><button type="button" title="#ebebeb" style="background:#ebebeb"><span>#ebebeb</span></button></li>
                            <li><button type="button" title="#ffffff" style="background:#ffffff"><span>#ffffff</span></button></li>
                            <li><button type="button" title="#e97d81" style="background:#e97d81"><span>#e97d81</span></button></li>
                            <li><button type="button" title="#e19b73" style="background:#e19b73"><span>#e19b73</span></button></li>
                            <li><button type="button" title="#d1b274" style="background:#d1b274"><span>#d1b274</span></button></li>
                            <li><button type="button" title="#cfcca2" style="background:#cfcca2"><span>#cfcca2</span></button></li>
                            <li><button type="button" title="#cfcca2" style="background:#cfcca2"><span>#cfcca2</span></button></li>
                            <li><button type="button" title="#61b977" style="background:#61b977"><span>#61b977</span></button></li>
                            <li><button type="button" title="#53aea8" style="background:#53aea8"><span>#53aea8</span></button></li>
                            <li><button type="button" title="#518fbb" style="background:#518fbb"><span>#518fbb</span></button></li>
                            <li><button type="button" title="#6a65bb" style="background:#6a65bb"><span>#6a65bb</span></button></li>
                            <li><button type="button" title="#9a54ce" style="background:#9a54ce"><span>#9a54ce</span></button></li>
                            <li><button type="button" title="#e573ae" style="background:#e573ae"><span>#e573ae</span></button></li>
                            <li><button type="button" title="#5a504b" style="background:#5a504b"><span>#5a504b</span></button></li>
                            <li><button type="button" title="#767b86" style="background:#767b86"><span>#767b86</span></button></li>
                            <li><button type="button" title="#00ffff" style="background:#00ffff"><span>#00ffff</span></button></li>
                            <li><button type="button" title="#00ff00" style="background:#00ff00"><span>#00ff00</span></button></li>
                            <li><button type="button" title="#a0f000" style="background:#a0f000"><span>#a0f000</span></button></li>
                            <li><button type="button" title="#ffff00" style="background:#ffff00"><span>#ffff00</span></button></li>
                            <li><button type="button" title="#951015" style="background:#951015"><span>#951015</span></button></li>
                            <li><button type="button" title="#6e391a" style="background:#6e391a"><span>#6e391a</span></button></li>
                            <li><button type="button" title="#785c25" style="background:#785c25"><span>#785c25</span></button></li>
                            <li><button type="button" title="#5f5b25" style="background:#5f5b25"><span>#5f5b25</span></button></li>
                            <li><button type="button" title="#4c511f" style="background:#4c511f"><span>#4c511f</span></button></li>
                            <li><button type="button" title="#1c4827" style="background:#1c4827"><span>#1c4827</span></button></li>
                            <li><button type="button" title="#0d514c" style="background:#0d514c"><span>#0d514c</span></button></li>
                            <li><button type="button" title="#1b496a" style="background:#1b496a"><span>#1b496a</span></button></li>
                            <li><button type="button" title="#2b285f" style="background:#2b285f"><span>#2b285f</span></button></li>
                            <li><button type="button" title="#45245b" style="background:#45245b"><span>#45245b</span></button></li>
                            <li><button type="button" title="#721947" style="background:#721947"><span>#721947</span></button></li>
                            <li><button type="button" title="#352e2c" style="background:#352e2c"><span>#352e2c</span></button></li>
                            <li><button type="button" title="#3c3f45" style="background:#3c3f45"><span>#3c3f45</span></button></li>
                            <li><button type="button" title="#00aaff" style="background:#00aaff"><span>#00aaff</span></button></li>
                            <li><button type="button" title="#0000ff" style="background:#0000ff"><span>#0000ff</span></button></li>
                            <li><button type="button" title="#a800ff" style="background:#a800ff"><span>#a800ff</span></button></li>
                            <li><button type="button" title="#ff00ff" style="background:#ff00ff"><span>#ff00ff</span></button></li>
                        </ul>
                    </div>
                    <!-- /팔레트 레이어 -->
                </li>
                <li class="bcolor xpress_xeditor_ui_bgColor">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_fontbgcolor);?>"><span><?php @print($__Context->lang->edit->fontbgcolor);?></span></button>
                    <!-- 배경색 + 팔레트 레이어 -->
                    <div class="layer xpress_xeditor_bgcolor_layer" style="display:none;">
                        <ul class="background">
                            <li><button type="button" title="#000000" style="background:#000000; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#9334d8" style="background:#9334d8; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#ff0000" style="background:#ff0000; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#333333" style="background:#333333; color:#ffff00"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#0000ff" style="background:#0000ff; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#ff6600" style="background:#ff6600; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#8e8e8e" style="background:#8e8e8e; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#009999" style="background:#009999; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#ffa700" style="background:#ffa700; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#ffdaed" style="background:#ffdaed; color:#000000"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#e4ff75" style="background:#e4ff75; color:#000000"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#cc9900" style="background:#cc9900; color:#ffffff"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#99dcff" style="background:#99dcff; color:#000000"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#a6ff4d" style="background:#a6ff4d; color:#000000"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                            <li><button type="button" title="#ffffff" style="background:#ffffff; color:#000000"><span><?php @print($__Context->lang->edit->fontbgsampletext);?></span></button></li>
                        </ul>
                    </div>
                    <!-- /배경색 + 팔레트 레이어 -->
                </li>
                <li class="sup xpress_xeditor_ui_superscript">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_sup);?>"><span><?php @print($__Context->lang->edit->sup);?></span></button>
                </li>
                <li class="sub xpress_xeditor_ui_subscript">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_sub);?>"><span><?php @print($__Context->lang->edit->sub);?></span></button>
                </li>
            </ul>
            <ul class="paragraph">
                <li class="left xpress_xeditor_ui_justifyleft">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_align_left);?>"><span><?php @print($__Context->lang->edit->align_left);?></span></button>
                </li>
                <li class="center xpress_xeditor_ui_justifycenter">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_align_center);?>"><span><?php @print($__Context->lang->edit->align_center);?></span></button>
                </li>
                <li class="right xpress_xeditor_ui_justifyright">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_align_right);?>"><span><?php @print($__Context->lang->edit->align_right);?></span></button>
                </li>
                <li class="justify xpress_xeditor_ui_justifyfull">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_align_justify);?>"><span><?php @print($__Context->lang->edit->align_justify);?></span></button>
                </li>
                <li class="ol xpress_xeditor_ui_orderedlist">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_list_number);?>"><span><?php @print($__Context->lang->edit->list_number);?></span></button>
                </li>
                <li class="ul xpress_xeditor_ui_unorderedlist">
                    <button type="button" title="<?php @print($__Context->lang->edit->help_list_bullet);?>"><span><?php @print($__Context->lang->edit->list_bullet);?></span></button>
                </li>
                <li class="outdent xpress_xeditor_ui_outdent">
                    <button type="button" title="Shift+Tab:<?php @print($__Context->lang->edit->help_remove_indent);?>"><span><?php @print($__Context->lang->edit->help_remove_indent);?></span></button>
                </li>
                <li class="indent xpress_xeditor_ui_indent">
                    <button type="button" title="Tab:<?php @print($__Context->lang->edit->help_add_indent);?>"><span><?php @print($__Context->lang->edit->add_indent);?></span></button>
                </li>
            </ul>
            <ul class="extra1">
                <li class="blockquote xpress_xeditor_ui_quote">
                    <button type="button" title="<?php @print($__Context->lang->edit->blockquote);?>"><span><?php @print($__Context->lang->edit->blockquote);?></span></button>
                    <!-- 인용 레이어 -->
                    <div class="layer xpress_xeditor_blockquote_layer" style="display:none">
                        <ul>
                            <li class="q1"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle1);?></span></button></li>
                            <li class="q2"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle2);?></span></button></li>
                            <li class="q3"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle3);?></span></button></li>
                            <li class="q4"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle4);?></span></button></li>
                            <li class="q5"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle5);?></span></button></li>
                            <li class="q6"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle6);?></span></button></li>
                            <li class="q7"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle7);?></span></button></li>
                            <li class="q8"><button type="button"><span><?php @print($__Context->lang->edit->quotestyle8);?></span></button></li>
                        </ul>
                    </div>
                    <!-- /인용 레이어 -->
                </li>
                <li class="url xpress_xeditor_ui_hyperlink">
                    <button type="button" title="<?php @print($__Context->lang->edit->url);?>"><span><?php @print($__Context->lang->edit->url);?></span></button>
                    <!-- URL 레이어 -->
                    <div class="layer xpress_xeditor_hyperlink_layer" style="display:none;">
                        <fieldset>
                            <h3><?php @print($__Context->lang->edit->hyperlink);?></h3>
                            <input name="" class="link" type="text" value="http://" title="URL" />
                            <p><input name="" id="target" type="checkbox" value="" /><label for="target"><?php @print($__Context->lang->edit->target_blank);?></label></p>
                        </fieldset>
                        <div class="btn_area">
                            <button type="button" class="confirm" title="<?php @print($__Context->lang->cmd_confirm);?>"><span><?php @print($__Context->lang->cmd_confirm);?></span></button>
                            <button type="button" class="cancel" title="<?php @print($__Context->lang->cmd_cancel);?>"><span><?php @print($__Context->lang->cmd_cancel);?></span></button>

                        </div>

                    </div>
                    <!-- /URL 레이어 -->
                </li>
                <li class="character xpress_xeditor_ui_sCharacter">
                    <button type="button" title="<?php @print($__Context->lang->edit->special_character);?>"><span><?php @print($__Context->lang->edit->special_character);?></span></button>
                    <!-- 특수문자 레이어 -->
                    <div class="layer xpress_xeditor_sCharacter_layer" style="display:none">
                        <h3><?php @print($__Context->lang->edit->insert_special_character);?></h3>
                        <button type="button" class="close" title="<?php @print($__Context->lang->edit->close_special_character);?>"><span><?php @print($__Context->lang->edit->close_special_character);?></span></button>
                        <ul class="nav">
                            <li><a href="#character1" class="on"><?php @print($__Context->lang->edit->symbol);?></a></li>
                            <li><a href="#character2"><?php @print($__Context->lang->edit->number_unit);?></a></li>
                            <li><a href="#character3"><?php @print($__Context->lang->edit->circle_bracket);?></a></li>
                            <li><a href="#character4"><?php @print($__Context->lang->edit->korean);?></a></li>
                            <li><a href="#character5"><?php @print($__Context->lang->edit->greece);?>,<?php @print($__Context->lang->edit->Latin);?></a></li>
                            <li><a href="#character6"><?php @print($__Context->lang->edit->japan);?></a></li>
                        </ul>
                        <ul style="display: block;" id="character1" class="list"></ul>
                        <ul style="display: none;" id="character2" class="list"></ul>
                        <ul style="display: none;" id="character3" class="list"></ul>
                        <ul style="display: none;" id="character4" class="list"></ul>
                        <ul style="display: none;" id="character5" class="list"></ul>
                        <ul style="display: none;" id="character6" class="list"></ul>
                        <p>
                            <label for="preview"><?php @print($__Context->lang->edit->selected_symbol);?></label>
                            <input id="preview" name="" type="text" />
                            <button type="button" title="<?php @print($__Context->lang->confirm);?>"><span><?php @print($__Context->lang->confirm);?></span></button>
                        </p>
                        <button type="button" class="close" title="<?php @print($__Context->lang->edit->close_special_character);?>"><span><?php @print($__Context->lang->edit->close_special_character);?></span></button>
                    </div>
                    <!-- /특수문자 레이어 -->
                </li>
            </ul>

            <ul class="table">
                <li class="table xpress_xeditor_ui_table">
                    <button type="button" title="<?php @print($__Context->lang->edit->table);?>"><span><?php @print($__Context->lang->edit->table);?></span></button>
                    <!-- 표 레이어 -->
                    <div class="layer xpress_xeditor_table_layer" style="display:none;">
                        <fieldset class="num">
                            <h3><?php @print($__Context->lang->edit->set_sel);?></h3>
                            <dl>
                                <dt>
                                    <label for="row"><?php @print($__Context->lang->edit->row);?></label>
                                </dt>
                                <dd>
                                    <input id="row" name="" type="text" maxlength="2" value="4" />
                                    <button type="button" class="add"><span><?php @print($__Context->lang->edit->add_one_row);?></span></button>
                                    <button type="button" class="del"><span><?php @print($__Context->lang->edit->del_one_row);?></span></button>
                                </dd>
                                <dt>
                                    <label for="col"><?php @print($__Context->lang->edit->col);?></label>
                                </dt>
                                <dd>
                                    <input id="col" name="" type="text" maxlength="2" value="4" />
                                    <button type="button" class="add"><span><?php @print($__Context->lang->edit->add_one_col);?></span></button>
                                    <button type="button" class="del"><span><?php @print($__Context->lang->edit->del_one_col);?></span></button>
                                </dd>
                            </dl>
                            <table border="1">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                        </fieldset>
                        <fieldset class="color">
                            <h3><?php @print($__Context->lang->edit->table_config);?></h3>
                            <dl>
                                <dt>
                                    <label for="table_border_width"><?php @print($__Context->lang->edit->border_width);?></label>
                                </dt>
                                <dd>
                                    <input id="table_border_width" name="" type="text" maxlength="2" value="1" />
                                    <button type="button" class="add"><span>1px <?php @print($__Context->lang->edit->add);?></span></button>
                                    <button type="button" class="del"><span>1px <?php @print($__Context->lang->edit->del);?></span></button>
                                </dd>
                                <dt>
                                    <label for="table_border_color"><?php @print($__Context->lang->edit->border_color);?></label>
                                </dt>
                                <dd>
                                    <span class="preview_palette"><button type="button" style="background:#cccccc;"><?php @print($__Context->lang->edit->search_color);?></button></span>
                                    <input id="table_border_color" name="" type="text" maxlength="7" value="#CCCCCC" />
                                    <button type="button" class="find_palette"><span><?php @print($__Context->lang->edit->search_color);?></span></button>
                                </dd>
                                <dt>
                                    <label for="table_bg_color"><?php @print($__Context->lang->edit->table_backgroundcolor);?></label>
                                </dt>
                                <dd>
                                    <span class="preview_palette"><button type="button" style="background:#000000;"><?php @print($__Context->lang->edit->search_color);?></button></span>
                                    <input id="table_bg_color" name="" type="text" maxlength="7" value="#000000" />
                                    <button type="button" class="find_palette"><span><?php @print($__Context->lang->edit->search_color);?></span></button>
                                </dd>
                            </dl>
                        </fieldset>
                        <div class="btn_area">
                            <button type="button" class="confirm" title="<?php @print($__Context->lang->confirm);?>"><span><?php @print($__Context->lang->confirm);?></span></button>
                            <button type="button" class="cancel" title="<?php @print($__Context->lang->cancel);?>"><span><?php @print($__Context->lang->cancel);?></span></button>
                        </div>
                    </div>
                    <!-- /표 레이어 -->
                </li>
                <li class="merge xpress_xeditor_ui_merge_cells"><button type="button" title="<?php @print($__Context->lang->edit->merge_cells);?>"><span><?php @print($__Context->lang->edit->merge_cells);?></span></button></li>
                <li class="splitCol xpress_xeditor_ui_split_col"><button type="button" title="<?php @print($__Context->lang->edit->split_col);?>"><span><?php @print($__Context->lang->edit->split_col);?></span></button></li>
                <li class="splitRow xpress_xeditor_ui_split_row"><button type="button" title="<?php @print($__Context->lang->edit->split_row);?>"><span><?php @print($__Context->lang->edit->split_row);?></span></button></li>
            </ul>
            <?php  } ?>

            <?php  if($__Context->enable_component){ ?>
            <ul class="extra2">
                <!-- 확장 컴포넌트 출력 -->
                <li class="extensions xpress_xeditor_ui_extension">
                    <span class="exButton"><button type="button" title="<?php @print($__Context->lang->edit->extension);?>"><?php @print($__Context->lang->edit->extension);?></button></span>
                    <div class="layer extension2 xpress_xeditor_extension_layer" id="editorExtension_<?php @print($__Context->editor_sequence);?>">
                        <ul id="editor_component_<?php @print($__Context->editor_sequence);?>" class="editorComponent">
                            <?php $__Context->Context->__idx[2]=0;if(count($__Context->component_list))  foreach($__Context->component_list as $__Context->component_name => $__Context->component){$__Context->__idx[3]=($__Context->__idx[3]+1)%2; $__Context->cycle_idx = $__Context->__idx[3]+1; ?>
                                <li><?php  if($__Context->component->component_icon){ ?><img src="/bettershop/xe/modules/editor/components/<?php @print($__Context->component_name);?>/component_icon.gif" alt="" width="13" height="12"/> <?php  } ?><a href="#" onclick="return false;" id="component_<?php @print($__Context->editor_sequence);?>_<?php @print($__Context->component_name);?>"><?php @print($__Context->component->title);?></a></li>
                            <?php  } ?>
                        </ul>
                    </div>
                </li>
            </ul>
            <?php  } ?>

            <ul class="extra3"<?php  if(!$__Context->html_mode){ ?> style="display:none"<?php  } ?>>
                <li class="html"><span><button class="xpress_xeditor_mode_toggle_button" type="button" title="<?php @print($__Context->lang->edit->html_editor);?>"><?php @print($__Context->lang->edit->html_editor);?></button></span></li>
            </ul>
            

        </div>
        <?php  }else{ ?>
            <div class="tool off disable"></div>
        <?php  } ?>

        <!-- 에디터 출력 -->
        <div id="xe-editor-container-<?php @print($__Context->editor_sequence);?>" class="input_area xpress_xeditor_editing_area_container">
            <textarea id="xpress-editor-<?php @print($__Context->editor_sequence);?>" cols="10" rows="10"></textarea>
        </div>

        <?php  if($__Context->enable_autosave){ ?>
        <p class="editor_autosaved_message autosave_message" id="editor_autosaved_message_<?php @print($__Context->editor_sequence);?>">&nbsp;</p>
        <?php  } ?>

        <!-- /입력 -->
        <button type="button" class="input_control xpress_xeditor_editingArea_verticalResizer" title="<?php @print($__Context->lang->edit->edit_height_control);?>"><span><?php @print($__Context->lang->edit->edit_height_control);?></span></button>

        </div>

        <?php  if($__Context->allow_fileupload){ ?>
            <!--#Meta:./modules/editor/skins/xpresseditor/../../tpl/js/uploader.js--><?php Context::addJsFile("./modules/editor/skins/xpresseditor/../../tpl/js/uploader.js", true, "", null, "head"); ?>
            <!--#Meta:./modules/editor/skins/xpresseditor/../../tpl/js/swfupload.js--><?php Context::addJsFile("./modules/editor/skins/xpresseditor/../../tpl/js/swfupload.js", true, "", null, "head"); ?>
            <script type="text/javascript">//<![CDATA[
            editorUploadInit(
                {
                    "editorSequence" : <?php @print($__Context->editor_sequence);?>,
                    "sessionName" : "<?php @print(session_name());?>",
                    "allowedFileSize" : "<?php @print($__Context->file_config->allowed_filesize);?>",
                    "allowedFileTypes" : "<?php @print($__Context->file_config->allowed_filetypes);?>",
                    "allowedFileTypesDescription" : "<?php @print($__Context->file_config->allowed_filetypes);?>",
                    "insertedFiles" : <?php @print((int)$__Context->files_count);?>,
                    "replaceButtonID" : "swfUploadButton<?php @print($__Context->editor_sequence);?>",
                    "fileListAreaID" : "uploaded_file_list_<?php @print($__Context->editor_sequence);?>",
                    "previewAreaID" : "preview_uploaded_<?php @print($__Context->editor_sequence);?>",
                    "uploaderStatusID" : "uploader_status_<?php @print($__Context->editor_sequence);?>"
                }
            );
        //]]></script>
        <!-- 파일 업로드 영역 -->
        <div id="fileUploader_<?php @print($__Context->editor_sequence);?>" class="fileUploader">
            <div class="preview <?php @print($__Context->btn_class);?>" id="preview_uploaded_<?php @print($__Context->editor_sequence);?>"></div>
            <div class="fileListArea <?php @print($__Context->btn_class);?>">
                <select id="uploaded_file_list_<?php @print($__Context->editor_sequence);?>" multiple="multiple" class="fileList" title="Attached File List"><option></option></select>
            </div>
            <div class="fileUploadControl">
                <span class="button <?php @print($__Context->btn_class);?>" id="swfUploadButton<?php @print($__Context->editor_sequence);?>"><button type="button"><?php @print($__Context->lang->edit->upload_file);?></button></span>
                <span class="button <?php @print($__Context->btn_class);?>"><button type="button" onclick="removeUploadedFile('<?php @print($__Context->editor_sequence);?>');return false;"><?php @print($__Context->lang->edit->delete_selected);?></button></span>
                <span class="button <?php @print($__Context->btn_class);?>"><button type="button" onclick="insertUploadedFile('<?php @print($__Context->editor_sequence);?>');return false;"><?php @print($__Context->lang->edit->link_file);?></button></span>
            </div>
            <div class="file_attach_info" id="uploader_status_<?php @print($__Context->editor_sequence);?>"><?php @print($__Context->upload_status);?></div>
        </div>
        <?php  } ?>
    </div>
    <!-- 에디터 활성화 -->
    <script type="text/javascript">//<![CDATA[
        var editor_path = "<?php @print($__Context->editor_path);?>";
        var auto_saved_msg = "<?php @print($__Context->lang->msg_auto_saved);?>";
        var oEditor = editorStart_xe("<?php @print($__Context->editor_sequence);?>", "<?php @print($__Context->editor_primary_key_name);?>", "<?php @print($__Context->editor_content_key_name);?>", "<?php @print($__Context->editor_height);?>", "<?php @print($__Context->colorset);?>", "<?php @print($__Context->content_style);?>",'<?php @print($__Context->content_font);?>','<?php @print($__Context->content_font_size);?>');
    //]]></script>

<?php  } ?>
