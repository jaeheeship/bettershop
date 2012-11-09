/**
* Copyright 2010 phiDel (FOXB.KR)
**/

function _exJsDownloadConfirm(dp){
    if(!dp){
        alert('error');
        return false;
    }

    if(dp === 'false'){
        if(typeof(_exJsMessage) != 'undefined')
            alert(_exJsMessage['enter_comment']);
        else
            alert('Please enter your comment');

        return false;
    } else if(parseInt(dp)>0){
        if(typeof(_exJsMessage) != 'undefined')
            var msg = _exJsMessage['download_point'];
        else
            var msg = 'Use when downloading '+dp+' point';

        return confirm(msg.replace('%s',dp));
    } else
        return parseInt(dp) <= 0;
}

function _exJsControllerFilter(form_obj, form_proc) {
    if(form_obj.password && !form_obj.password.disabled) {
        if(!form_obj.password.value){
            if(typeof(_exJsMessage) != 'undefined')
                alert(_exJsMessage['enter_password']);
            else
                alert('Please enter your password');
            form_obj.password.focus();
            return false;
        }
    }
    return procFilter(form_obj, form_proc);
}

var _exJsVarControllerSelectIndex = 0;
function _exJsControllerInitializatione(){
    jQuery('.exJsControllerContent[rel='+_exJsVarControllerSelectIndex+']').each( function() {
        jQuery(this).css('display','none');
        jQuery(this).empty();
    });
    jQuery('.exJsOriginalContent[rel='+_exJsVarControllerSelectIndex+']').css('display','block');
    _exJsVarControllerSelectIndex = 0;

    return false;
}

function _exJsControllerDeleteSimpleForm(target, target_srl, is_grant){
    _exJsControllerInitializatione();
    if(target_srl<1)return false;

    jQuery('.exJsControllerContent[rel='+target_srl+']').each( function() {
        jQuery('.exJsOriginalContent[rel='+target_srl+']').css('display','none');

        var controller_obj = jQuery(exJsDeleteForm_source);
        jQuery(this).append(controller_obj);

        _exJsVarControllerSelectIndex = target_srl;

        controller_obj.each( function(){
            jQuery('input[name='+target+']', this).val(target_srl);
            jQuery('input[name=password]', this).each( function() {
                jQuery(this).css('display',is_grant?'none':'block');
                this.disabled = is_grant? true:false;
            });
        });

        jQuery(this).css('display','block');
    });

    return false;
}

function _exJsControllerReplySimpleForm(target, target_srl){
    _exJsControllerInitializatione();
    if(target_srl<1)return false;

    jQuery('#waitingforserverresponse').html(waiting_message).css({
            left : jQuery(document).scrollLeft()+20 + 'px',
            top  : jQuery(document).scrollTop()+20 + 'px'
        }).css('visibility','visible');

    var iframe_src = current_url.setQuery('custom_layout_path','./common/tpl').setQuery('custom_layout_file','default_layout').setQuery('is_iframe','1');
    iframe_src = iframe_src.setQuery('comment_srl',target_srl);

    if(target == 'modify') iframe_src = iframe_src.setQuery('act','dispBoardModifyComment');
    else if(target == 'delete') iframe_src = iframe_src.setQuery('act','dispBoardDeleteComment');
    else iframe_src = iframe_src.setQuery('act','dispBoardReplyComment');

    jQuery('.exJsControllerContent[rel='+target_srl+']').each( function() {
        if(target == 'modify' || target == 'delete') jQuery('.exJsOriginalContent[rel='+target_srl+']').css('display','none');
        var controller_obj = jQuery('<iframe id="exJsControllerReplyIframe" allowTransparency="true" frameborder="0" src="'+iframe_src+'" scrolling="no" style="width:100%;">');
        jQuery(this).append(controller_obj);

        _exJsVarControllerSelectIndex = target_srl;
        jQuery(this).css('display','block');
    });

    return false;
}

/**
* Iframe 높이 변경
**/
var _exJsVarIframeHeight = 0;
function _exJsIframeResizeHeight() {
    if(!parent) return false;

    var iframe = jQuery('#exJsControllerReplyIframe', parent.document);
    if(!iframe.get(0)) return false;

    var h = jQuery('body').innerHeight();

    if(h != _exJsVarIframeHeight)  {
        iframe.height(h);
        if(!jQuery('div.exJsSMBox').get(0) && !_exJsVarIframeHeight) {
            iframe.get(0).scrollIntoView(false);
            //parent.scrollTo(0, (iframe.offset().top - iframe.height()) + 50);
        }
        _exJsVarIframeHeight = h;
        jQuery('#waitingforserverresponse', parent.document).css('visibility','hidden');
    }

    setTimeout(_exJsIframeResizeHeight, 300);
}

function _exJsIframeClose(select_index){
    if(!parent) return false;

    jQuery('.exJsControllerContent[rel='+select_index+']', parent.document).css('display','none');
    jQuery('.exJsOriginalContent[rel='+select_index+']', parent.document).css('display','block');

    return false;
}

/**
* 댓글 관련 제어 완료 콜백 함수
**/
function _exJsIframeCompleteComment(ret_obj) {
    if(!parent) return false;

    if(ret_obj) var mid = ret_obj['mid'];

    if(mid){
        var document_srl = ret_obj['document_srl'];
        var parent_srl = ret_obj['parent_srl'];
        var comment_srl = ret_obj['comment_srl'];
        var custom_layout_path = parent.location.href.getQuery('custom_layout_path');
        var custom_layout_file = parent.location.href.getQuery('custom_layout_file');

        var url = request_uri.setQuery('mid',mid);
        if(custom_layout_path) url = url.setQuery('custom_layout_path',custom_layout_path);
        if(custom_layout_file) url = url.setQuery('custom_layout_file',custom_layout_file);
        if(document_srl) url = url.setQuery('document_srl',document_srl);

        var query_str =  'comment_srl';
        //주소가 같으면 뒤에 # 인해 리로드가 안되서 주소를 살짝 바꿔줌
        if(parent.location.href.getQuery('comment_srl')) query_str = 'rnd';

        //comment_srl 이 넘어왔다면 입력 아니면 삭제
        if(comment_srl){
            url = url.setQuery(query_str,comment_srl)+'#comment_'+comment_srl;
        }else{
            if(parent_srl && parent_srl>0)
                url = url.setQuery(query_str,parent_srl)+'#comment_'+parent_srl;
            else
                url = url.setQuery(query_str,'1')+'#comment';
        }

        parent.location.href = url;
    }else parent.location.reload();
}

/**
* 상세 검색
**/
function _exJsExSearchFilter(th, ft){
    var val = jQuery('select[name=search_target]', th).val();

    if(val == 'ex_search')
    {
        var key = jQuery('input[name=search_keyword]', th).val();
        if(key.length < 2){
            alert('Please align the text length of Keyword(2~40)');
            jQuery('input[name=search_keyword]', th).focus();
            return false;
        }

        var sch_opts = new Array();
        jQuery('input[name=ex_search_option]:checked').each(function() {
            sch_opts[sch_opts.length] = jQuery(this).val();
        });

        if(sch_opts.length < 1){
            alert('Please select a value for target');
            return false;
        }
        var e_obj = jQuery('<input type="hidden" name="ex_search_targets" value="" />');
        e_obj.val(sch_opts.join(','));
        jQuery(th).append(e_obj);

        th.submit();
    }else{
        return procFilter(th, ft);
    }
}

function _exJsExSearchBoxToggle(th){
    var o = jQuery('div.exJsSchExBox');
    th.value=='ex_search'?o.slideDown():o.slideUp();
    return false;
}

/**
* 팝업창 리사이즈시 프레임 크기도 변경되게
**/
function _exJsPopupResize(){
    var _pContent = jQuery('#popup_content');   if(!_pContent.get(0)) return false;
    _pContent.height(jQuery(window).height()-5);

    var _mBox = jQuery('.exJsMidBox',_pContent);
    var _padding = parseFloat(jQuery.curCSS( _mBox.get(0), 'paddingTop', true));
    _padding += parseFloat(jQuery.curCSS( _mBox.get(0), 'paddingBottom', true));

    var _top = _mBox.find('.exJsMidTle').outerHeight(true);
    var _height = _pContent.innerHeight()- _top - _padding;

    jQuery('object',_pContent).attr('height',_height);
    jQuery('embed',_pContent).attr('height',_height);
}

/**
* 배경색 바꾸기 (그라데이션 깜빡임 방지 로딩이 완료된후 실행)
**/
function _exJsBgCache(th){
    var color = jQuery(th).attr('rev');
    if(!color) color = '#BBB';
    jQuery('[name='+jQuery(th).attr('rel')+']').css('background-color', color);
}

(function($) {

    $(function() {

        // 초기화 (새로고침 방지)
        $('input[name=vote_point]').each(function() {
            var val = $(this).attr('rel');
            if(val) $(this).val(val);
        });

        // 별점수 클릭시 이미지 바꾸기
        $('.exJsSPntBox').find('a').click(function() {
            var o = $(this);
            if(!o.attr('rel')) return true;

            var p = this.parentNode;
            //여러개의 exJsSPntBox 에서도 선택한 객체만 적용하기 위해 검사
            while (p && !$(p).hasClass('exJsSPntBox')){p = $(p).parent();}
            $(p).find('a').each( function(i) {
                if(i<o.attr('rel')) $(this).addClass('on'+o.attr('col'));
                else $(this).removeClass('on'+o.attr('col'));
            });
            $('input[name=vote_point]', p).val(o.attr('rel'));
        });

        // 핫 트랙 관련 셋팅
        $('.exJsHotTrackBox').mouseenter(function() {
            $(this).addClass('hot_track_css');
            if($(this).attr('rel')){
                var rel = $(this).attr('rel');
                $('.exJsHotTrackBox[rel='+rel+']').addClass('hot_track_css');
            }
        });

        $('.exJsHotTrackBox').mouseleave(function() {
            $(this).removeClass('hot_track_css');
            if($(this).attr('rel')){
                var rel = $(this).attr('rel');
                $('.exJsHotTrackBox[rel='+rel+']').removeClass('hot_track_css');
            }
        });

        $('.exJsHotTrackBox').click(function() {
            if($(this).attr('rel')){
                var rel = $(this).attr('rel');
                location.href = $('.exJsHotTrackA[rel='+rel+']').attr('href');
            }else{
                location.href = $('.exJsHotTrackA', this).attr('href');
            }
            return false;
        });

        // 첨부파일 클릭시 파일 목록 보여주기
        $('.exJsFileListButton').click(function(evt) {
            var area = $('#popup_menu_area');
            area.fadeOut().slideUp();

            var html = '';
            var flist = $('.exJsFileListBox[rel='+$(this).attr('rel')+']').html();
            var mdist = $('.exJsMediaListBox[rel='+$(this).attr('rel')+']').html();
            var imist = $('.exJsImageListBox[rel='+$(this).attr('rel')+']').html();

            if(imist) html = html + imist;
            if(mdist) html = html + mdist;
            if(flist) html = html + flist;
            area.html(html);

            var areaOffset = {top:evt.pageY, left:(evt.pageX-area.outerWidth())};
            if(area.outerHeight()+areaOffset.top > $(window).height()+$(window).scrollTop())
                areaOffset.top = $(window).height() - area.outerHeight() + $(window).scrollTop();
            if(areaOffset.left < $(window).scrollLeft()) areaOffset.left = $(window).scrollLeft();

            // 1.4.5 버전업 후론 2번 실행해야 한다 --; 나중에 원인을 찾자...
            area.css({ top:areaOffset.top, left:areaOffset.left }).fadeIn().slideDown();
        });

        // 댓글,트랙백창 접기 펼치기 (감출때 none 쓰면 처음에 플래시 먹통 버그걸림)
        $('.exJsReTrToggle').click(function(evt) {
            var JObj = $('.exJs'+$(this).attr('rel')+'Layout[rel='+$(this).attr('rev')+']');
            if(!JObj.get(0)) return false;
            if(JObj.hasClass('exJsDHideEx')){
                JObj.removeClass('exJsDHideEx');

                /**
                 * 본문 폭 구하기 위한 개체
                 * IE6에서 본문폭을 넘는 이미지가 있으면 그 크기로 구해지는 문제 우회용
                 **/
                var dummy = $('<div style="height:1; overflow:hidden; opacity:0; display:block; clear:both;"></div>');

                var regx_skip = /(?:(modules|addons|classes|common|layouts|libs|widgets|widgetstyles)\/)/i;
                var regx_allow_i6pngfix = /(?:common\/tpl\/images\/blank\.gif$)/i;

                $('img', JObj).each(function() {
                    dummy.appendTo($(this).parent());
                    var contentWidth = dummy.width();
                    dummy.remove();
                    var imgSrc = $(this).attr('src');
                    if(regx_skip.test(imgSrc) && !regx_allow_i6pngfix.test(imgSrc)) return;
                    if($(this).width()<=contentWidth) return;
                    $(this).removeAttr('width');
                    $(this).removeAttr('height');
                    $(this).css('width',contentWidth);
                    $(this).css('height','');
                });

                // IE6~7 에서 한번에 적용안되는 문제 해결용
                if($.browser.msie && parseInt($.browser.version) <= 7){
                    JObj.hide();
                    JObj.toggle();
                }
            }else{
                JObj.toggle();
            }
            return false;
        });

    });

})(jQuery);
