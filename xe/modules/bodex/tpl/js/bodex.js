/**
 * @file   modules/bodex/js/bodex.js
 * @author phiDel (FOXB.KR)
 **/

function completeDocumentInserted(ret) {
    var err = ret['error'];
    var msg = ret['message'];
    var mid = ret['mid'];
    var doc_srl = ret['document_srl'];
    var cat_srl = ret['category_srl'];

    var url;
    if(!doc_srl)
    { url = current_url.setQuery('mid',mid).setQuery('act',''); }
    else
    { url = current_url.setQuery('mid',mid).setQuery('document_srl',doc_srl).setQuery('act',''); }
    if(cat_srl) url = url.setQuery('category',cat_srl);
    location.href = url;
}

function completeDeleteDocument(ret) {
    var err = ret['error'];
    var msg = ret['message'];
    var mid = ret['mid'];
    var page = ret['page'];

    var url = current_url.setQuery('mid',mid).setQuery('act','').setQuery('document_srl','');
    if(page) url = url.setQuery('page',page);

    location.href = url;
}

function completeSearch(ret, prm, frm){
    var url = current_url;
    if(frm.vid) url = url.setQuery('vid',frm.vid);
    if(frm.mid) url = url.setQuery('mid',frm.mid);
    if(frm.category) url = url.setQuery('category',frm.category);
    if(frm.search_target) url = url.setQuery('search_target',frm.search_target);
    if(frm.search_keyword) url = url.setQuery('search_keyword',frm.search_keyword);

    location.href = url;
}

function completeInsertComment(ret) {
    var err = ret['error'];
    var msg = ret['message'];
    var mid = ret['mid'];
    var doc_srl = ret['document_srl'];
    var com_srl = ret['comment_srl'];

    if(current_url.getQuery('is_poped') && opener){
        opener.location.reload();
        location.reload();
    }else{
        if(com_srl!=current_url.getQuery('rnd')){
            var url = current_url.setQuery('mid',mid).setQuery('document_srl',doc_srl).setQuery('act','');
            if(com_srl) url = url.setQuery('rnd',com_srl)+'#comment_'+com_srl;
            location.href = url;
        }else location.reload();
    }
}

function completeDeleteComment(ret) {
    var err = ret['error'];
    var msg = ret['message'];
    var mid = ret['mid'];
    var doc_srl = ret['document_srl'];
    var par_srl  = ret['parent_srl'];
    var page = ret['page'];

    if(current_url.getQuery('is_poped') && opener){
        opener.location.reload();
        location.reload();
    }else{
        if(current_url.getQuery('act')){
            var url = current_url.setQuery('mid',mid).setQuery('document_srl',doc_srl).setQuery('act','');
            if(page) url = url.setQuery('page',page);
            if(par_srl>0)
                url = url.setQuery('rnd',par_srl)+'#comment_'+par_srl;
            else
                url = url+'#comment';
            location.href = url;
        }else location.reload();
    }
}

function completeDeleteTrackback(ret) {
    var err = ret['error'];
    var msg = ret['message'];
    var mid = ret['mid'];
    var doc_srl = ret['document_srl'];
    var page = ret['page'];

    var url = current_url.setQuery('mid',mid).setQuery('document_srl',doc_srl).setQuery('act','');
    if(page) url = url.setQuery('page',page);

    location.href = url;
}

function completeInsertFileLink(ret, prm, frm) {
    var err = ret['error'];
    var msg = ret['message'];
    var editor_sequence_srl = ret['editor_sequence_srl'];
    if(err!=='0'){
        alert(msg);
        return false;
    }
    jQuery('input[name=filelink_url]').val('');
    var settings = uploaderSettings[editor_sequence_srl?editor_sequence_srl:'1'];
    reloadFileList(settings);
}

function _exJcCallAction(module,action,target_srl){
    var params=new Array();
    params['target_srl']=target_srl;
    params['cur_mid']=current_mid;
    exec_xml(module,action,params,_exJcCompleteCallAction);
    return false;
}

function _exJcCompleteCallAction(ret_obj,response_tags){
    if(ret_obj['message']!='success') alert(ret_obj['message']);
    return false;
}

/* XE 게시판 호환용 */
function doChangeCategory(){
    _exJcChangeCategory();
}

function _exJcChangeCategory() {
    var cat_srl = jQuery('#board_category option:selected').val();
    location.href = decodeURI(current_url).setQuery('category',cat_srl);
}

/*
function _exJcScrap(doc_srl) {
    var prm = new Array();
    prm['document_srl'] = doc_srl;
    exec_xml('member','procMemberScrapDocument', prm, null);
}
*/

function _exJcRestoreHistory(his_srl) {
    if(confirm('Are you sure to restore the history?'))
        doCallModuleAction('bodex','procBoardHistoryRestore',his_srl);
}

function _exJcDeleteHistory(his_srl) {
    if(confirm('Are you sure to delete the history?'))
        doCallModuleAction('bodex','procBoardHistoryDelete',his_srl);
}

function _exJcCopyClipboard(txt)
{
    if (window.clipboardData)
    {
        window.clipboardData.setData('Text', txt);
        alert('The text is copied to your clipboard...');
    }
    else
    { prompt('press CTRL+C copy it to clipboard...',txt); }
    return false;
}

function _exJcChangeDocumentsState(ste) {
    var doc_srls = new Array();
    jQuery('input[name=cart]:checked').each(function() {
        doc_srls[doc_srls.length] = jQuery(this).val();
    });

    if(doc_srls.length<1) {
        alert('Not selected documents');
        return false;
    }

    _exJcChangeDocumentState(doc_srls.join(','), ste);
}

function _exJcChangeDocumentState(doc_srls, ste) {
    if(!ste && ste!==0){
        alert('Not selected state');
        return false;
    }

    var prm = new Array();
    prm['cur_mid'] = current_url.getQuery('mid');
    prm['target_srls'] = doc_srls;
    prm['state_value'] = ste;
    // 문서 보기 인지 체크
    prm['document_srl'] = current_url.getQuery('document_srl');
    exec_xml('bodex', 'procBoardChangeState', prm, completeCallModuleAction);
}

function _exJcDocumentRating(point, doc_srl) {
    var prm = new Array();
    prm['cur_mid'] = current_url.getQuery('mid');
    prm['point'] = point;
    prm['target_srl'] = doc_srl?doc_srl:current_url.getQuery('document_srl');
    exec_xml('bodex', 'procBoardVoteRegister', prm, completeCallModuleAction);
}

function _exJcPopDisplayMedia(file_srl, sid) {
    if(!file_srl || !sid) return false;

    var mid = current_url.getQuery('mid');

    var url = request_uri.setQuery('module','bodex').setQuery('mid',mid).setQuery('act','dispBoardMediaPlayer');
    url = url.setQuery('file_srl',file_srl).setQuery('sid',sid).setQuery('is_poped','1');

    popopen(url, 'popDisplayMedia');
}

function _exJcPopCommentList(doc_srl) {
    var mid = current_url.getQuery('mid');

    var url = request_uri.setQuery('module','bodex').setQuery('mid',mid).setQuery('act','dispBoardContentCommentList');
    url = url.setQuery('document_srl',doc_srl).setQuery('is_poped','1');

    popopen(url, 'popCommentList');
}

function _exJcPopTagList(mid, count, cat_srl) {
    if(!mid) mid = current_url.getQuery('mid');
    if(!count) count = 200;

    var url = request_uri.setQuery('module','bodex').setQuery('mid',mid).setQuery('act','dispBoardTagList');
    url = url.setQuery('pop_list_count',count).setQuery('category',cat_srl).setQuery('is_poped','1');

    popopen(url, 'popTagList');
}

function _exJcPopImageList(mid, count, cat_srl, self) {
    if(!mid) mid = current_url.getQuery('mid');
    if(!count) count = 30;

    var url = request_uri.setQuery('module','bodex').setQuery('mid',mid).setQuery('act','dispBoardImageList');
    url = url.setQuery('pop_list_count',count).setQuery('category',cat_srl).setQuery('is_poped','1');

    if(self)
        location.href = url;
    else
        popopen(url, 'popImageList');
}

function _exJcSelectTag(tag) {
    if(!opener || !tag) {
        window.close();
        return;
    }

    var _obj = jQuery('input[name=tags]', opener.document);

    if(!_obj.get(0)) {
        alert('Input element not found. (need element "tags")');
        return;
    }

    var str = _obj.val();
    var len = str.length;
    if(len>0 && (str.substr((len-1),1) != ',')) str += ',';
    str += tag;

    _obj.val(str);
}

function _exJcSelectImage(url) {
    if(!opener || !url) {
        window.close();
        return;
    }

    var regUrl = /https?:\/\//gi;
    if (!regUrl.test(url)){
        if(url.indexOf('./') === 0)
            url = url.substring(2);
        url = request_uri+url;
    }

    var _obj = jQuery('input[name=filelink_url]', opener.document);
    if(!_obj.get(0)) {
        alert('Input element not found. (need element "filelink_url")');
        return;
    }

    _obj.val(url);
}
