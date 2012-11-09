<?php
    /**
     * @class  bodexItem
     **/

    class bodexItem extends Object {

        var $module_srl = 0;
        var $display_extra_images = null;

        function bodexItem($module_srl, $display_extra_images) {
            $this->module_srl = $module_srl;
            $this->display_extra_images = array_flip(explode('|@|', $display_extra_images));
            if(!is_array($this->display_extra_images)) $this->display_extra_images = array();
        }

        function getGrantGroups($site_srl = 0) {
            $oMemberModel = &getModel('member');
            return $oMemberModel->getGroups($site_srl);
        }

        function getDocumentDeclaredCount($document_srl){
            $args->document_srl = $document_srl;
            $output = executeQuery('document.getDeclaredDocument', $args);
            if(!$output->toBool()) return;
            return $output->data->declared_count;
        }

        function getCommentDeclaredCount($comment_srl){
            $args->comment_srl = $comment_srl;
            $output = executeQuery('comment.getDeclaredComment', $args);
            if(!$output->toBool()) return;
            return $output->data->declared_count;
        }

        function isMemberComment($document_srl, $member_srl=0) {
            $oBodexModel = &getModel('bodex');
            return $oBodexModel->isMemberComment($document_srl, $member_srl);
        }

        function getMemberPoint($member_srl=0) {
            $oBodexModel = &getModel('bodex');
            return $oBodexModel->getMemberPoint($member_srl);
        }

        function getPointConfig($name = null) {
            $oBodexModel = &getModel('bodex');
            return $oBodexModel->getPointConfig($name, $this->module_srl);
        }

        function getNotAdoptedPostCount() {
            $oBodexModel = &getModel('bodex');
            return $oBodexModel->getNotAdoptedPostCount($this->module_srl);
        }

        function getDocumentNavigation($document_srl=0, $list_count = 0) {
            $oBodexModel = &getModel('bodex');
            return $oBodexModel->getDocumentNavigation($document_srl, $list_count, $this->module_srl);
        }

        function getReadedLogInfo($document_srl = 0, $isMemberCheck = true) {
            $oBodexModel = &getModel('bodex');
            return $oBodexModel->getReadedLogInfo($document_srl, $isMemberCheck);
        }

        function getVotedLogInfo($document_srl = 0, $isMemberCheck = true) {
            if(!$document_srl) $document_srl = Context::get('document_srl');
            if(!$document_srl) return;

            if($isMemberCheck){
                $logged_info = Context::get('logged_info');
                if(!$logged_info) return;
                $args->member_srl = $logged_info->member_srl;
            }

            $args->document_srl = $document_srl;
            $output = executeQueryArray('bodex.getDocumentVotedLog', $args);
            if(!$output->toBool() || !$output->data) return;

            $re = array();
            // 검색이 쉽게 멤버번호 또는 ip주소를 키값으로 셋팅
            foreach($output->data as $val){
                if($val->member > 0){
                    $re[$val->member] = $val->point;
                }else{
                    $re[$val->ipaddress] = $val->point;
                }
            }

            return $re;
        }

        function getDownloadedLogInfo($document_srl = 0, $isMemberCheck = true) {
            if(!$document_srl) $document_srl = Context::get('document_srl');
            if(!$document_srl) return;

            if($isMemberCheck){
                $logged_info = Context::get('logged_info');
                if(!$logged_info) return;
                $args->member_srl = $logged_info->member_srl;
            }

            $args->upload_target_srl = $document_srl;
            $output = executeQueryArray('bodex.getFileDownloadedLog', $args);
            if(!$output->toBool() || !$output->data) return;

            $re = array();
            $Data = $output->data;
            // 검색이 쉽게 파일번호를 키값으로 셋팅
            foreach($Data as $val){
                $re[$val->file_srl] = $val->download_count;
            }

            return $re;
        }

        function getSplitFileList($buffs) {
            if(!is_array($buffs)||!count($buffs)) return;

            $re = array();
            foreach($buffs as $key => $file){
                if($file->direct_download=='Y'){
                    if(preg_match("/\.(swf|flv|mp[1234]|as[fx]|wm[av]|mpg|mpeg|avi|wav|mid|midi|mov|moov|qt|rm|ram|ra|rmm|m4v)$/i", $file->source_filename)){
                        $re['media'][]=$file;
                    }else{
                        $re['image'][]=$file;
                    }
                }else{
                    $re['binary'][]=$file;
                }
            }
            return $re;
        }

        function printExtraImages($buffs) {
            if(!is_array($buffs)) return;

            // 아이콘 디렉토리 구함
            $path = sprintf('%s%s',getUrl(), 'modules/document/tpl/icons/');

            if(!count($buffs)) return;

            $buff = null;
            foreach($buffs as $key => $val) {
                if(isset($this->display_extra_images['none']) && !$this->display_extra_images[$val]) continue;
                $lang_str = Context::getLang($val);
                $buff .= sprintf('<img src="%s%s.gif" alt="%s" title="%s" style="margin-right:2px;" />', $path, $val, $lang_str, $lang_str);
            }
            return $buff;
        }

        function getWith($obj, $arr) {
            if(!$obj || !is_array($obj->variables) || !is_array($arr)) return $obj;

            foreach($arr as $val){
                $obj->{$val} = $obj->variables[$val];
            }

            return $obj;
        }

        function cutStrEx($value, $cut_size = 0) {
            if(!$cut_size || $cut_size<1) return $value;

            if(preg_match('/(<a\s.+>)(http:\/\/)?(.+?)(<\/a>)/e', $value, $match)) {
                $value = $match[1].cut_str($match[3], $cut_size).$match[4];
            }else{
                $value = cut_str(strip_tags($value), $cut_size);
            }

            return $value;
        }

        function inArrayEx($needle, $haystack, $strict = false) {
            if(!is_array($needle) || !is_array($haystack))
                return false;

            foreach($needle as $val){
                if(in_array($val, $haystack, $strict))
                    return true;
            }

            return false;
        }

        function getTrackbackUrlEx($document_srl = 0) {
            if(!$document_srl) $document_srl = Context::get('document_srl');
            if(!$document_srl) return;

            // 스팸을 막기 위한 key 생성
            $oTrackbackModel = &getModel('trackback');
            $url = Context::getRequestUri();
            if(substr($url,-1) != '/') $url .= '/';

            if(Context::isAllowRewrite())
                return $url.$document_srl.'/'.$oTrackbackModel->getTrackbackKey($document_srl).'/trackback';
            else
                return $oTrackbackModel->getTrackbackUrl($document_srl);
        }
    }
?>
