<?php
    /**
     * @class  bodexController
     **/

    class bodexController extends bodex {

        /**
         * @brief 초기화
         **/
        function init() {
        }

        function _getGrant($cur_mid, $logged_info){
            if(!$cur_mid || !$logged_info) return;

            $oModuleModel = &getModel('module');
            $cur_module_info = $oModuleModel->getModuleInfoByMid($cur_mid);
            return $oModuleModel->getGrant($cur_module_info, $logged_info);
        }

        function _getModuleAdminInfo($module_srl, $site_srl = 0){
            $oMemberModel = &getModel('member');
            $oModuleModel = &getModel('module');

            $module_admin = $oModuleModel->getAdminId($module_srl);
            if(!$module_admin) $module_admin = $oModuleModel->getSiteAdmin($site_srl);

            $admin_info = $oMemberModel->getMemberInfoByMemberSrl($module_admin[0]->member_srl);

            return $admin_info;
        }

        function _setUserInfo($is_any, $sor_obj, $out_obj=null){
            // sor_obj 에 유저 정보가 없다면 기본값 리턴
            if(!$sor_obj || !$sor_obj->member_srl) return $out_obj;

            if(!$is_any){
                $out_obj->member_srl = $sor_obj->member_srl;
                $out_obj->email_address = $sor_obj->email_address;
                $out_obj->homepage = $sor_obj->homepage;
                $out_obj->user_id = $sor_obj->user_id;
                $out_obj->user_name = $sor_obj->user_name;
                $out_obj->nick_name = $sor_obj->nick_name;

            }else{
                $out_obj->user_id = '';
                $member_srl = $sor_obj->member_srl;

                // 보안 단계별 설정 (상담 사용시 1단계만)
                if((string)$this->module_info->use_anonymous_phase=='1'||$this->module_info->consultation == 'Y'){
                    $out_obj->member_srl = abs($member_srl);
                    $out_obj->user_id = 'anonymous';
                }elseif((string)$this->module_info->use_anonymous_phase=='3')
                    $out_obj->member_srl = 0;
                else $out_obj->member_srl = -1 * abs($member_srl);

                $out_obj->email_address = $out_obj->homepage = '';
                $out_obj->user_name = $out_obj->nick_name = 'anonymous';
            }

            return $out_obj;
        }

        function _sendMail($user_name, $email_address, $target_mails, $title, $content){
            if(!$target_mails) return false;

            $oMail = new Mail();
            $oMail->setTitle($title);
            $oMail->setContent($content);
            $oMail->setSender($user_name, $email_address);

            $target_mail = explode(',', $target_mails);
            for($i=0;$i<count($target_mail);$i++) {
                $target_email_address = $oMail->isVaildMailAddress(trim($target_mail[$i]));
                // 받는이가 없거나 보낸이와 같으면 패스
                if(!$target_email_address || ($email_address && ($target_email_address == $email_address))) continue;
                // 보낸이 메일주소가 없으면 자신의 메일 주소입력 (스팸으로 가는거 방지)
                if(!$email_address) $oMail->setSender($user_name, $target_email_address);

                $oMail->setReceiptor($target_email_address, $target_email_address);
                $oMail->send();
            }
        }

        function _InsertAutoReply($obj){
            $admin_info = $this->_getModuleAdminInfo($obj->module_srl, $this->module_info->site_srl);

            if($admin_info){
                $auto_obj->member_srl = $admin_info->member_srl;
                $auto_obj->email_address = $admin_info->email_address;
                $auto_obj->homepage = $admin_info->homepage;
                $auto_obj->user_id = $admin_info->user_id;
                $auto_obj->user_name = $admin_info->user_name;
                $auto_obj->nick_name =  $admin_info->nick_name;
            }else{
                // 게시판 관리자가 없다면
                $auto_obj->member_srl = 0;
                $auto_obj->email_address = $auto_obj->homepage = $auto_obj->user_id = '';
                $auto_obj->user_name = $auto_obj->nick_name = Context::getLang('admin');
                $auto_obj->password = date("Y-m-d-H-i-s", time()).crypt(rand(1000000,900000), rand(0,100));
            }

            $auto_obj->module_srl = $obj->module_srl;
            $auto_obj->document_srl = $obj->document_srl;
            $auto_obj->content = $this->module_info->auto_reply_text;
            if($this->module_info->use_secret == 'R') $auto_obj->is_secret = 'Y';

            $oCommentController = &getController('comment');

            $backup_avoid_log = $_SESSION['avoid_log'];
            $_SESSION['avoid_log'] = true;
            $output = $oCommentController->insertComment($auto_obj, true);
            $_SESSION['avoid_log'] = $backup_avoid_log;
            if(!$output->toBool()) return $output;

            $auto_obj->comment_srl = $output->variables['comment_srl'];

            $is_send_mail = $obj->notify_message == 'Y' && ($this->module_info->notify_message_type == 'A' || $this->module_info->notify_message_type == 'M');

            if($is_send_mail){
                $mail_user_name = $auto_obj->nick_name;
                $mail_email_address = $auto_obj->email_address;
                $mail_title = $obj->title;
                $mail_content = sprintf("From : <a href=\"%s#comment_%d\">%s#comment_%d</a><br/>\r\n%s", getFullUrl('','document_srl',$auto_obj->document_srl),$auto_obj->comment_srl, getFullUrl('','document_srl',$auto_obj->document_srl), $auto_obj->comment_srl, $auto_obj->content);

                $mail_target_mails = $obj->email_address;
                $this->_sendMail($mail_user_name, $mail_email_address, $mail_target_mails, $mail_title, $mail_content);
            }
        }

        function _checkFileDownload($obj, $insert = false){
            $oModuleModel = &getModel('module');
            $module_info = $oModuleModel->getModuleInfoByModuleSrl($obj->module_srl);

            $logged_info = Context::get('logged_info');
            $member_srl = $logged_info->member_srl;

            // 자신의 올린 파일이면 패스
            if($this->grant->manager || ($member_srl && abs($obj->member_srl) == abs($member_srl))) return new Object();

            // 다운로드 허용 옵션이 포인트가 아니면 패스
            if($module_info->use_allow_down != 'P'){

                // 다운로드 허용 옵션이 댓글이면 댓글 체크
                if($module_info->use_allow_down == 'Y' && $obj->upload_target_type != 'mod'){
                    $document_srl = $obj->upload_target_srl;

                    if(!$obj->upload_target_type || $obj->upload_target_type == 'com'){
                        $oCommentModel = &getModel('comment');
                        $oComment = $oCommentModel->getComment($obj->upload_target_srl);
                        // 댓글이면 패스
                        if($oComment->isExists()) //$document_srl = $oComment->document_srl;
                            return new Object();
                    }elseif($obj->upload_target_type != 'doc'){
                        return new Object(-1, 'msg_invalid_request');
                    }

                    $oBodexModel = &getModel('bodex');
                    if(!$oBodexModel->isMemberComment($document_srl, $member_srl))
                        return new Object(-1, 'Please enter your comment');
                }

                 return new Object();
            }

            if(!$member_srl) return new Object(-1, 'msg_please_login');

            // 이미지(미디어)이고 이미지(미디어)는 제외이면 패스
            if($obj->direct_download=='Y'){
                if(preg_match("/\.(swf|flv|mp[1234]|as[fx]|wm[av]|mpg|mpeg|avi|wav|mid|midi|mov|moov|qt|rm|ram|ra|rmm|m4v)$/i", $obj->source_filename)){
                    if($module_info->use_down_point_medias != 'Y') return new Object();
                }else{
                    if($module_info->use_down_point_images != 'Y') return new Object();
                }
            }

            // 로그인 사용자이면 member_srl, 비회원이면 ipaddress
            //if($logged_info->member_srl) {
                $args->member_srl = $member_srl;
            //} else {
             //   $args->ipaddress = $_SERVER['REMOTE_ADDR'];
            //}

            $args->file_srl = $obj->file_srl;
            $args->upload_target_srl = $obj->upload_target_srl;
            $output = executeQuery('bodex.getFileDownloadedLog', $args);

            // 이미 한번 받았던 사람
            if($output->data) {
                // 입력 모드시 다운 count 증가
                if($insert){
                    $args->download_count = $output->data->download_count + 1;
                    $output = executeQuery('bodex.updateFileDownloadedLog', $args);
                }
                // 매번이 아니면 패스
                if($module_info->use_down_point_always != 'Y') return new Object();
            }else{
                unset($args->download_count);
            }

            // 문서에 첨부된 파일이 아니면 패스
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($obj->upload_target_srl, false, false);
            if(!$oDocument->isExists()) return new Object();

            // 포인트 사용이 아니면 패스
            $reward_point = $oDocument->get('reward_point');
            if(!$reward_point || $reward_point <= 0) return new Object();

            // 포인트 저장 50%
            $point = round($reward_point / 2);

            // 입력 모드시 기록
            if($insert){
                // 다운로드자는 포인트 만큼 빼고 파일 주인은 얻고
                $oPointController = &getController('point');
                $oPointController->setPoint($args->member_srl, $point, 'minus');
                $oPointController->setPoint($obj->member_srl, $point, 'add');

                // 처음 다운로드시 기록
                if(!$args->download_count)
                    $output = executeQuery('bodex.insertFileDownloadedLog', $args);

            }else{
                $oMemberPoint = &getModel('point');
                // 다운로드 사용자의 포인트가 없으면 중단
                if($oMemberPoint->getPoint($member_srl) < $point){
                    return new Object(-1, 'msg_not_enough_point');
                }
            }

            return new Object();
        }

        /**
         * @brief 파일 연결 추가
         **/
        function procBoardInsertFileLink() {
            // 필요한 변수 설정
            $editor_sequence_srl = Context::get('editor_sequence_srl');
            $upload_target_srl = intval(Context::get('document_srl'));
            $module_srl = $this->module_srl;
            $filelink_url = Context::get('filelink_url');

            if(!preg_match("/^(https?|ftp|file|mms):\/\/[0-9a-z-]+(\.[_0-9a-z-\/\~]+)+(:[0-9]{2,4})*\/[^\/]+[a-zA-Z0-9\:\&\#\@\=\_\~\%\;\?\.\+\-]{3,}/i",$filelink_url))
                 return new Object(-1, Context::getLang('msg_invalid_format')."\r\nex: http://, ftp://, file://, mms://");

            $filename = basename($filelink_url);
            if(!$filename) return new Object(-1, 'msg_invalid_request');

            if(strpos($filename,'?')>3) $filename = substr($filename,0,strpos($filename,'?'));

            // 업로드 권한이 없거나 정보가 없을시 종료
            if(!$_SESSION['upload_info'][$editor_sequence_srl]->enabled) return new Object(-1, 'msg_not_permitted');

            // upload_target_srl 값이 명시되지 않았을 경우 세션정보에서 추출
            if(!$upload_target_srl) $upload_target_srl = $_SESSION['upload_info'][$editor_sequence_srl]->upload_target_srl;

            // 세션정보에도 정의되지 않았다면 새로 생성
            if(!$upload_target_srl) $_SESSION['upload_info'][$editor_sequence_srl]->upload_target_srl = $upload_target_srl = getNextSequence();

            // 이미지인지 기타 파일인지 체크
            if(preg_match("/\.(png|jpg|jpeg|bmp|gif|ico|swf|flv|mp[1234]|as[fx]|wm[av]|mpg|mpeg|avi|wav|mid|midi|mov|moov|qt|rm|ram|ra|rmm|m4v)$/i", $filename)) {
                // direct 파일에 해킹을 의심할 수 있는 확장자가 포함되어 있으면 바로 삭제함
                // 어차피 링크 파일이라 위험 없음...
                //if(preg_match("/\.(php|phtm|html|htm|cgi|pl|exe|jsp|asp|inc)/i",$filename)) return;
                $filename = str_replace(array('<','>'),array('%3C','%3E'),$filename);

                $direct_download = 'Y';
            } else {
                $direct_download = 'N';
            }

            // 사용자 정보를 구함
            $oMemberModel = &getModel('member');
            $member_srl = $oMemberModel->getLoggedMemberSrl();

            // 파일 정보를 정리
            $args->file_srl = getNextSequence();
            $args->upload_target_srl = $upload_target_srl;
            $args->module_srl = $module_srl;
            $args->direct_download = $direct_download;
            $args->source_filename = $filename;
            $args->uploaded_filename = $filelink_url;
            $args->download_count = 0;
            $args->file_size = 0;
            $args->comment = 'link';
            $args->member_srl = $member_srl;
            $args->sid = md5(rand(rand(1111111,4444444),rand(4444445,9999999)));

            $output = executeQuery('file.insertFile', $args);
            if(!$output->toBool()) return $output;

            $this->add('editor_sequence_srl', $editor_sequence_srl);
            $this->setMessage('success_registed');
        }

        /**
         * @brief 문서 입력
         **/
        function procBoardInsertDocument() {
            // GET 방식의 입력 유효성 체크가 안되는 글쓰기 막기
            if(Context::getRequestMethod() == 'GET') return new Object(-1, 'msg_invalid_request');

            // 권한 체크
            if(!$this->grant->write_document) return new Object(-1, 'msg_not_permitted');

            // 글작성시 필요한 변수를 세팅
            $obj = Context::getRequestVars();
            $obj->module_srl = $this->module_srl;

            if($obj->is_notice!='Y'||!$this->grant->manager) $obj->is_notice = 'N';
            if($this->module_info->use_allow_comment == 'R'||$this->module_info->use_allow_comment == 'N')
                $obj->allow_comment = ($this->module_info->use_allow_comment == 'R')?'Y':'N';
            if($this->module_info->use_allow_trackback == 'R'||$this->module_info->use_allow_trackback == 'N')
                $obj->allow_trackback = ($this->module_info->use_allow_trackback == 'R')?'Y':'N';

            // 비밀글 필수일때 공지는 비밀글 안되게
            if($this->module_info->use_secret == 'R') {
                $obj->is_secret = ($obj->is_notice == 'Y')?'N':'Y';
            }

            settype($obj->title, "string");
            if($obj->title == '') $obj->title = cut_str(strip_tags($obj->content),20,'...');
            // 그래도 없으면 Untitled
            if($obj->title == '') $obj->title = 'Untitled';

            // 관리자가 아니라면 게시글 색상/굵기 제거
            if(!$this->grant->manager) {
                unset($obj->title_color);
                unset($obj->title_bold);
            }

            // 익명 사용중인지 체크
            $is_anonymous = ((!$this->grant->manager && $this->module_info->use_anonymous == 'R') || (($this->module_info->use_anonymous == 'Y' || $this->grant->manager) && $obj->is_anonymous == 'Y'));

            // 익명 설정일 경우 알림 정보 제거
            if($is_anonymous) $obj->notify_message = 'N';

            $oDocumentModel = &getModel('document');
            $oDocumentController = &getController('document');

            // 이미 존재하는 글인지 체크
            $oDocument = $oDocumentModel->getDocument($obj->document_srl, $this->grant->manager, $this->module_info->use_load_extra_vars == 'Y');

            $logged_info = Context::get('logged_info');

            // 분류 사용시 권한이 없다면 오류
            if($this->module_info->use_category != 'N'){
                $category_list = $oDocumentModel->getCategoryList($this->module_srl);
                // 상위 분류 권한을 하위분류에도 적용
                foreach($category_list as $idx=>$cat_val){
                    if($cat_val->parent_srl)
                        $category_list[$idx]->grant = $category_list[$cat_val->parent_srl]->grant;
                }
                if(($obj->category_srl && !$category_list[$obj->category_srl]->grant)) return new Object(-1, 'msg_not_permitted');
            }

            // 포인트 글 작성전 먼저 에러 체크
            if($logged_info && $this->module_info->use_reward != 'N'){
                // 답변용 포인트시 신규 글일때 미채택 글이 3개 이상이면 중단
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P' && !$oDocument->isExists()){
                    $oBodexModel = &getModel('bodex');
                    if($oBodexModel->getNotAdoptedPostCount($oDocument->module_srl) > 2) return new Object(-1, 'msg_reward_please_adopt');
                }

                // 포인트 필수일때 0과 같거나 작으면
                if($obj->reward_point <= 0 && ($this->module_info->use_reward == 'R') ){
                    $msg_please_use = Context::getLang('msg_please_use');
                    return new Object(-1, sprintf($msg_please_use, Context::getLang('reward_point')));
                }

                $old_reward_point = $oDocument->isExists()?$oDocument->get('reward_point'):0;

                if($obj->reward_point > 0 && (!$old_reward_point || $obj->reward_point != $old_reward_point)){
                    // 포인트 부족 에러
                    $oPointModel = &getModel('point');
                    if($oPointModel->getPoint($logged_info->member_srl) < $obj->reward_point){
                        return new Object(-1, 'msg_not_enough_point');
                    }
                }
            }

            // 이미 존재하는 경우 수정
            if($oDocument->isExists()) {

                if(!$oDocument->isGranted()) return new Object(-1,'msg_not_permitted');

                // 포인트 답변 사용시 답변이 달리면 관리자 외에 불가
                if(!$this->grant->manager && (($this->module_info->use_reward == 'Y' && $oDocument->get('reward_point')) || $this->module_info->use_reward == 'R')){
                    if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                        $oCommentModel = &getModel('comment');
                        if($oCommentModel->getCommentCount($oDocument->document_srl)>0) return new Object(-1, 'msg_not_permitted');
                    }
                }

                // 확장 필드에 값이 있으면 새로 셋팅
                $extra_vars = unserialize($oDocument->get('extra_vars'));
                if($extra_vars) $obj->extra_vars = $extra_vars;

                $output = $oDocumentController->updateDocument($oDocument, $obj);
                $msg_code = 'success_updated';

                if(!$output->toBool()) return $output;

                $oDocument->member_srl = $oDocument->get('member_srl');

                if($this->module_info->use_reward != 'N'){
                    $old_reward_point = $obj->reward_point - $old_reward_point;

                    // 포인트 변화시 업데이트 (글쓴이, 최고관리자만 변경 가능)
                    if($old_reward_point != 0 && $logged_info && ($logged_info->is_admin == 'Y' || $logged_info->member_srl == abs($oDocument->member_srl))){
                        $this->updateRewardPoint($output->get('document_srl'), $oDocument->member_srl, $obj->reward_point, $old_reward_point);
                    }
                }

                // 히스토리 사용중인지 체크
                $module_srl = $oDocument->get('module_srl');
                $oModuleModel = &getModel('module');
                $document_config = $oModuleModel->getModulePartConfig('document', $module_srl);
                if(!isset($document_config->use_history)) $document_config->use_history = 'N';
                $bUseHistory = $document_config->use_history == 'Y' || $document_config->use_history == 'Trace';

                // 익명 사용시 익명 정보 갱신
                if($logged_info && ($bUseHistory || ($logged_info->member_srl == abs($oDocument->member_srl)) && (($is_anonymous && $oDocument->member_srl > 0)||(!$is_anonymous && $oDocument->member_srl < 0)))){
                    $any_args = $this->_setUserInfo($is_anonymous, $logged_info);
                    $any_args->document_srl = $output->get('document_srl');
                    $anonymous_output = executeQuery('bodex.updateDocumentUserInfo', $any_args);
                    if(!$anonymous_output->toBool()) return $anonymous_output;
                }

            } else { // 그렇지 않으면 신규 등록

                // 익명 사용시 글쓴이 정보를 모두 제거
                if($logged_info && $is_anonymous) $obj = $this->_setUserInfo($is_anonymous, $logged_info, $obj);

                // 모바일에서 작성시 정보 저장
                if($this->module_info->use_mobile_express && Mobile::isFromMobilePhone()){
                    unset($extra_vars);
                    $extra_vars->bodex->d->mp = true;
                    // Document 모듈에서 serialize($extra_vars) 자동으로 함
                    $obj->extra_vars = $extra_vars;
                }

                $output = $oDocumentController->insertDocument($obj, $is_anonymous);
                $msg_code = 'success_registed';

                if(!$output->toBool()) return $output;

                $obj->document_srl = $output->get('document_srl');

                /**
                * @brief 나중에 코어에서 해결될때 그땐 지우자 (phidel temp code)
                * 포인트가 있으면 업데이트, 게시판EX에서 만든 필드라 따로 업데이트를 해야함
                **/
                if($obj->reward_point > 0 && $logged_info){
                    $this->updateRewardPoint($obj->document_srl, $logged_info->member_srl, $obj->reward_point);
                }

                // 자동 댓글이 설정되어 있으면 댓글 입력
                if($this->module_info->auto_reply_text) $this->_InsertAutoReply($obj);

                // 문제가 없고 모듈 설정에 관리자 메일이 등록되어 있으면 메일 발송 (익명사용시 위에서 이미 정보 제거됨)
                if($this->module_info->admin_mail) {
                    $mail_user_name = $obj->nick_name;
                    $mail_email_address = $obj->email_address;
                    $mail_title = $obj->title;
                    $extra_content = '';

                    // 확장 변수가 있으면 같이 보냄
                    $extra_keys = $oDocumentModel->getExtraKeys($obj->module_srl);
                    if(count($extra_keys)) {
                        foreach($extra_keys as $idx => $extra_item) {
                            $value = '';
                            if(isset($obj->{'extra_vars'.$idx})) $value = trim($obj->{'extra_vars'.$idx});
                            elseif(isset($obj->{$extra_item->name})) $value = trim($obj->{$extra_item->name});
                            if(!isset($value)) continue;
                            $extra_content .= $extra_item->name.': '.str_replace('|@|',', ',$value)."<br/>\r\n";
                        }
                    }

                    $mail_content = sprintf("From : <a href=\"%s\">%s</a><br/>\r\n%s<br/>\r\n%s", getFullUrl('','document_srl',$obj->document_srl), getFullUrl('','document_srl',$obj->document_srl), $extra_content, $obj->content);
                    $mail_target_mails = $this->module_info->admin_mail;

                    $this->_sendMail($mail_user_name, $mail_email_address, $mail_target_mails, $mail_title, $mail_content);
                }
            }

            // 결과를 리턴
            $this->add('mid', Context::get('mid'));
            $this->add('document_srl', $output->get('document_srl'));

            // 성공 메세지 등록
            $this->setMessage($msg_code);
        }

        /**
         * @brief 문서 삭제
         **/
        function procBoardDeleteDocument() {
            $document_srl = Context::get('document_srl');
            // 문서 번호가 없다면 오류 발생
            if(!$document_srl) return $this->doError('msg_invalid_document');

            $oDocumentModel = &getModel('document');
            $oDocumentController = &getController('document');

            // 이미 존재하는 글인지 체크
            $oDocument = $oDocumentModel->getDocument($document_srl, $this->grant->manager, false);

            if(!$oDocument->isExists()) return new Object(-1,'msg_not_founded');

            // 포인트 답변 사용시 답변이 달리면 관리자 외에 불가
            if(!$this->grant->manager && (($this->module_info->use_reward == 'Y' && $oDocument->get('reward_point')) || $this->module_info->use_reward == 'R')){
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                    $oCommentModel = &getModel('comment');
                    if($oCommentModel->getCommentCount($document_srl)>0) return new Object(-1, 'msg_not_permitted');
                }
            }

            // 권한이 없으면 비밀번호
            if(!$oDocument->isGranted()){
                $result = $this->procBoardVerificationPassword();
                if(!$oDocument->isGranted()) return $result;
             }

            // 삭제 시도
            $output = $oDocumentController->deleteDocument($document_srl, $this->grant->manager);
            if(!$output->toBool()) return $output;

            // 결과를 리턴
            $this->add('mid', Context::get('mid'));
            $this->add('page', $output->get('page'));

            // 성공 메세지 등록
            $this->setMessage('success_deleted');
        }

        /**
         * @brief 코멘트 추가
         **/
        function procBoardInsertComment() {
            // 권한 체크
            if(!$this->grant->write_comment) return new Object(-1, 'msg_not_permitted');

            // 댓글 입력에 필요한 데이터 추출
            $obj = Context::gets('document_srl','comment_srl','parent_srl','content','password','nick_name','member_srl','email_address','homepage','is_secret','notify_message','vote_point','is_anonymous');
            $obj->module_srl = $this->module_srl;

            // 원글이 존재하는지 체크
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($obj->document_srl, false, false);

            if(!$oDocument->isExists()) return new Object(-1,'msg_not_founded');
            if($oDocument->isLocked() || !$oDocument->allowComment()) return new Object(-1,'msg_invalid_request');

            $is_anonymous = ((!$this->grant->manager && $this->module_info->use_anonymous_comment == 'R') || (($this->module_info->use_anonymous_comment == 'Y' || $this->grant->manager) && $obj->is_anonymous == 'Y'));

            // 익명 설정일 경우 알림 정보 제거
            if($is_anonymous) $obj->notify_message = 'N';

            // 비밀글 필수일때 비밀글 설정
            if($this->module_info->use_secret_comment == 'R') $obj->is_secret = 'Y';

            $oCommentModel = &getModel('comment');
            $oCommentController = &getController('comment');
            $logged_info = Context::get('logged_info');
            unset($oComment);

            if(!$obj->comment_srl){
                // getNextSequence() 다음 Sequence 얻어온다.
                $obj->comment_srl = getNextSequence();
            }else{
                $oComment = $oCommentModel->getComment($obj->comment_srl, $this->grant->manager);
            }

            if(!$obj->comment_srl) return new Object(-1,'msg_invalid_request');

            // comment_srl이 없으면 신규
            if($oComment->comment_srl != $obj->comment_srl) {

                // 별점, 추천, 글쓰기 전에 먼저 체크겸 업데이트, 글쓴이 제외
                if(($logged_info && ($logged_info->member_srl == abs($oDocument->get('member_srl')))) && $this->module_info->use_vote != 'N'){
                    // 0이 아니거나 필수일때는 들어감
                    if(($obj->vote_point && $obj->vote_point != 0) || $this->module_info->use_vote == 'Z' || $this->module_info->use_vote == 'R'){
                        $output = $this->updateVotedCount($obj->document_srl, $obj->vote_point);
                        if(!$output->toBool()) return $output;
                    }
                }

                // parent_srl이 있으면 답변으로
                if($obj->parent_srl) {
                    $parent_comment = $oCommentModel->getComment($obj->parent_srl);
                    if(!$parent_comment->comment_srl) return new Object(-1, 'msg_invalid_request');
                    $parent_comment->notify_message = $parent_comment->get('notify_message');
                }
                else unset($parent_comment);

                // 메일 보내기 체크
                $oDocument->notify_message = $oDocument->get('notify_message');
                $is_send_mail = $this->module_info->notify_message_type == 'M' && ($parent_comment->notify_message == 'Y' || $oDocument->notify_message == 'Y');

                // 익명 사용시 글쓴이 정보를 모두 제거
                if($logged_info && $is_anonymous) $obj = $this->_setUserInfo($is_anonymous, $logged_info, $obj);

                $output = $oCommentController->insertComment($obj, $is_anonymous || $is_send_mail);
                if(!$output->toBool()) return $output;

                // 보기, 다운로드 허용 옵션 사용시 비회원 체크를 위해 세션에 저장
                if(!$logged_info) $_SESSION[$_SERVER['REMOTE_ADDR']]['insert_comment'][$obj->document_srl] = true;

                // 모바일에서 작성시 정보 저장
                if($this->module_info->use_mobile_express && Mobile::isFromMobilePhone()){
                    $extra_vars = unserialize($oDocument->get('extra_vars'));
                    $extra_vars->bodex->c[$obj->comment_srl]->mp = true;
                    $extra_args->document_srl = $obj->document_srl;
                    $extra_args->extra_vars = serialize($extra_vars);
                    $tmp_output = executeQuery('bodex.updateDocumentExtra', $extra_args);
                }

                // 메일 보내기가 아니면 쪽지,메일 동시 보내기인지 다시 체크
                if(!$is_send_mail){
                    $is_send_mail = $this->module_info->notify_message_type == 'A' && ($parent_comment->notify_message == 'Y' || $oDocument->notify_message == 'Y');
                }

                // 문제가 없고 모듈 설정에 관리자 메일이 등록되어 있거나 메일 알림이면 메일 발송
                if($this->module_info->admin_mail_reply || $is_send_mail) {
                    $mail_user_name = $obj->nick_name;
                    $mail_email_address = $obj->email_address;
                    $mail_title = $oDocument->getTitleText();
                    $mail_content = sprintf("From : <a href=\"%s#comment_%d\">%s#comment_%d</a><br/>\r\n%s", getFullUrl('','document_srl',$obj->document_srl),$obj->comment_srl, getFullUrl('','document_srl',$obj->document_srl), $obj->comment_srl, $obj->content);

                    $mail_target_mails = ($this->module_info->admin_mail_reply)?$this->module_info->admin_mail_reply:'';
                    $mail_target_mails .= (($mail_target_mails)?',':'').($oDocument->notify_message == 'Y'?$oDocument->get('email_address'):'');
                    $mail_target_mails .= (($mail_target_mails)?',':'').($parent_comment->notify_message == 'Y'?$parent_comment->get('email_address'):'');

                    $this->_sendMail($mail_user_name, $mail_email_address, $mail_target_mails, $mail_title, $mail_content);
                }

            } else {

                // 권한이 없으면 비밀번호
                if(!$oComment->isGranted()){
                    $result = $this->procBoardVerificationPassword();
                    if(!$oComment->isGranted()) return $result;
                }

                // 비밀번호 변경 막기
                unset($obj->password);

                // 채택된 답변은 관리자 외에 불가
                if( !$this->grant->manager && ($this->module_info->use_reward == 'Y' || $this->module_info->use_reward == 'R')){
                    if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                        $oBodexModel = &getModel('bodex');
                        if($oBodexModel->isAdoptedComment($obj->comment_srl)) return new Object(-1, 'msg_not_permitted');
                    }
                }

                $obj->parent_srl = $oComment->parent_srl;
                $output = $oCommentController->updateComment($obj, $this->grant->manager);
                if(!$output->toBool()) return $output;

                // 익명 사용시 익명 정보 갱신
                if($logged_info && ($logged_info->member_srl == abs($oComment->member_srl)) && (($is_anonymous && $oComment->member_srl > 0)||(!$is_anonymous && $oComment->member_srl < 0))){
                    $any_args = $this->_setUserInfo($is_anonymous, $logged_info);
                    $any_args->comment_srl = $obj->comment_srl;
                    $anonymous_output = executeQuery('bodex.updateCommentUserInfo', $any_args);
                    if(!$anonymous_output->toBool()) return $anonymous_output;
                }
            }

            $this->add('mid', Context::get('mid'));
            $this->add('document_srl', $obj->document_srl);
            $this->add('comment_srl', $obj->comment_srl);

            $this->setMessage('success_registed');
        }

        /**
         * @brief 코멘트 삭제
         **/
        function procBoardDeleteComment() {
            // 댓글 번호 확인
            $comment_srl = Context::get('comment_srl');
            if(!$comment_srl) return $this->doError('msg_invalid_request');

            // 채택된 답변은 관리자 외에 불가
            if( !$this->grant->manager && ($this->module_info->use_reward == 'Y' || $this->module_info->use_reward == 'R')){
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                    $oBodexModel = &getModel('bodex');
                    if($oBodexModel->isAdoptedComment($comment_srl))  return new Object(-1, 'msg_not_permitted');
                }
            }

            $oCommentModel = &getModel('comment');
            $oComment = $oCommentModel->getComment($comment_srl);

            if(!$oComment->isExists()) return new Object(-1,'msg_not_founded');

            // 권한이 없으면 비밀번호
            if(!$oComment->isGranted()){
                $result = $this->procBoardVerificationPassword();
                if(!$oComment->isGranted()) return $result;
             }

            $oCommentController = &getController('comment');

            $output = $oCommentController->deleteComment($comment_srl, $this->grant->manager);
            if(!$output->toBool()) return $output;

            $document_srl = $output->get('document_srl');

            // 문제가 없고 채택된 글이면 미채택(0)으로
            $this->updateAdoptCommentSrl($document_srl);

            // 보기, 다운로드 허용 옵션 사용시 비회원 체크를 위해 세션에 삭제
            unset($_SESSION[$_SERVER['REMOTE_ADDR']]['insert_comment'][$document_srl]);

            // 확장변수에 값이 있으면 삭제 (모바일 정보)
            if($this->module_info->use_mobile_express){
                $oDocumentModel = &getModel('document');
                $oDocument = $oDocumentModel->getDocument($document_srl, false, false);
                if($oDocument->isExists()){
                    $extra_vars = unserialize($oDocument->get('extra_vars'));
                    if($extra_vars->bodex->c[$comment_srl]){
                        unset($extra_vars->bodex->c[$comment_srl]);
                        $extra_args->document_srl = $document_srl;
                        $extra_args->extra_vars = serialize($extra_vars);
                        $tmp_output = executeQuery('bodex.updateDocumentExtra', $extra_args);
                    }
                }
            }

            $this->add('mid', Context::get('mid'));
            $this->add('page', Context::get('page'));
            $this->add('document_srl', $document_srl);
            $this->add('parent_srl', $oComment->get('parent_srl'));

            $this->setMessage('success_deleted');
        }

        /**
         * @brief 엮인글 삭제
         **/
        function procBoardDeleteTrackback() {
            $trackback_srl = Context::get('trackback_srl');

            $oTrackbackController = &getController('trackback');
            $output = $oTrackbackController->deleteTrackback($trackback_srl, $this->grant->manager);
            if(!$output->toBool()) return $output;

            $this->add('mid', Context::get('mid'));
            $this->add('page', Context::get('page'));
            $this->add('document_srl', $output->get('document_srl'));

            $this->setMessage('success_deleted');
        }

        /**
         * @brief 문서와 댓글의 비밀번호를 확인
         **/
        function procBoardVerificationPassword() {
            // 비밀번호와 문서 번호를 받음
            $password = Context::get('password');

            $document_srl = Context::get('document_srl');
            $comment_srl = Context::get('comment_srl');

            $oMemberModel = &getModel('member');

            // comment_srl이 있을 경우 댓글이 대상
            if($comment_srl) {
                // 문서번호에 해당하는 글이 있는지 확인
                $oCommentModel = &getModel('comment');
                $oComment = $oCommentModel->getComment($comment_srl);
                if(!$oComment->isExists()) return new Object(-1, 'msg_not_founded');

                // 문서의 비밀번호와 입력한 비밀번호의 비교
                if(!$oMemberModel->isValidPassword($oComment->get('password'),$password)) return new Object(-1, 'msg_invalid_password');

                $oComment->setGrant();
            } else {
                // 문서번호에 해당하는 글이 있는지 확인
                $oDocumentModel = &getModel('document');
                $oDocument = $oDocumentModel->getDocument($document_srl, false, false);
                if(!$oDocument->isExists()) return new Object(-1, 'msg_not_founded');

                // 문서의 비밀번호와 입력한 비밀번호의 비교
                if(!$oMemberModel->isValidPassword($oDocument->get('password'),$password)) return new Object(-1, 'msg_invalid_password');

                $oDocument->setGrant();
            }
        }

        /**
        * @brief 포인트 걸린 게시물의 답변 채택
        **/
        function procBoardAdoptComment(){
            if(!Context::get('is_logged')) return new Object(-1, 'msg_please_login');

            $comment_srl = Context::get('target_srl');
            if(!$comment_srl) return new Object(-1, 'msg_invalid_request');

            $oCommentModel = &getModel('comment');
            $oComment = $oCommentModel->getComment($comment_srl);

            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($oComment->document_srl, false, false);
            if(!$oDocument->isExists()) return new Object(-1, 'msg_not_founded');

            $doc_member_srl = $oDocument->get('member_srl');
            $document_srl = $oDocument->get('document_srl');

            // 로그인 맴버와 글쓴이가 다르면 중단, 최고 관리자 제외
            $logged_info = Context::get('logged_info');
            if(!$logged_info || ($logged_info->is_admin != 'Y' && ($logged_info->member_srl != abs($doc_member_srl)))) return new Object(-1, 'msg_not_permitted_act');

            // 답글이 자기 자신이여도 중단
            if(abs($oComment->member_srl) == abs($doc_member_srl)) return new Object(-1, 'msg_not_permitted');

            $output = $this->updateAdoptCommentSrl($document_srl, $comment_srl);

            if(!$output->toBool()) return $output;

            // 포인트 저장 50%
            $point = round($output->data->point / 2);

            // 성공하면 글쓴이의 포인트를 분배
            $oPointController = &getController('point');
            $oPointController->setPoint(abs($oComment->member_srl), $point, 'add');
            $oPointController->setPoint(abs($doc_member_srl), $point, 'add');

            // 결과 리턴
            return new Object(0, 'success_adopt');
        }

        /**
        * @brief 나중에 코어에서 해결될때 그땐 지우자 (phidel temp code)
        * 포인트 입력, 따로 추가한 필드라 Document 모듈 insertDocument.xml 필드를 추가해야하나...
        * 다른 모듈 수정하기 싫어서 그냥 직접 입력 하기로 함
        **/
        function updateRewardPoint($document_srl, $member_srl, $point, $update  = 0){
            $args->document_srl = $document_srl;
            $args->reward_point = $point;
            $output = executeQuery('bodex.updateRewardPoint', $args);

            if(!$output->toBool()) return $output;

            // 포인트값 업데이트이면
            if($update != 0) $point = $update;

            // 글쓴이의 포인트를 제거
            $oPointController = &getController('point');
            $oPointController->setPoint($member_srl, $point, 'minus');

            return $output;
        }

        /**
        * @brief 포인트 기능 (0이면 아직 답글없음, 채택시 답글번호)
        **/
        function updateAdoptCommentSrl($document_srl, $comment_srl = 0){
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);

            if(!$oDocument->isExists()) return new Object(-1, 'msg_not_founded');

            // 이미 채택된 답글이 있다면 중단
            $reward_srl = $oDocument->get('reward_srl');
            if($reward_srl && $reward_srl != 0){
                $oCommentModel = &getModel('comment');
                $comment = $oCommentModel->getComment($reward_srl);
                if($comment->isExists()) return new Object(-1, 'msg_invalid_request');
            }

            // 채택된 답글번호 입력
            $args->document_srl = $document_srl;
            $args->reward_srl = $comment_srl;
            $output = executeQuery('bodex.updateAdoptCommentSrl', $args);

            // 채택시 포인트 갱신을 위해
            $output->data->point = $oDocument->get('reward_point');

            return $output;
        }

        /**
        * @brief 별점,추천 주기 기능, 해당 document의 추천수 증가
        **/
        function updateVotedCount($document_srl, $point){
            // 문서번호가 없으면 에러
            if(!$document_srl) return new Object(-1, 'msg_invalid_request');
            // 포인트가 없으면 넘어감
            if(!$point || $point === 0) return new Object();

            if($point > 0) $failed_voted = 'failed_voted';
            else $failed_voted = 'failed_blamed';

            if(!$this->module_info->use_vote){
                $oModuleModel = &getModel('module');
                $this->module_info = $oModuleModel->getModuleInfoByDocumentSrl($document_srl);
            }
            if(!$this->module_info->use_vote || $this->module_info->use_vote=='N') return new Object(-1, 'msg_invalid_request');

            // 문서 원본을 가져옴
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);

            // 원본 문서가 없으면 중단
            if(!$oDocument->isExists()) return new Object(-1, 'msg_not_founded');

            // 세션 정보에 추천 정보가 있으면 중단
            if($_SESSION['voted_document'][$document_srl]) return new Object(-1, $failed_voted);

            // 글의 작성 ip와 현재 접속자의 ip가 동일하면 패스
            if($this->module_info->use_vote_not_checkip != 'Y' && $oDocument->get('ipaddress') == $_SERVER['REMOTE_ADDR']) {
                $_SESSION['voted_document'][$document_srl] = true;
                return new Object(-1, 'msg_writer_same_user');
            }

            $document_member_srl = $oDocument->get('member_srl');

            if(!Context::get('is_logged')){
                unset($logged_member_srl);
            }else{
                // member model 객체 생성
                $oMemberModel = &getModel('member');
                $logged_member_srl = $oMemberModel->getLoggedMemberSrl();

                // 글쓴이와 현재 로그인 사용자의 정보가 일치하면 세션 등록후 패스
                if($logged_member_srl && (abs($logged_member_srl) == abs($document_member_srl))) {
                    $_SESSION['voted_document'][$document_srl] = true;
                    return new Object(-1, 'msg_writer_same_user');
                }
            }

            // 로그인 사용자이면 member_srl, 비회원이면 ipaddress로 판단
            if($logged_member_srl) {
                $args->member_srl = $logged_member_srl;
            } else {
                $args->ipaddress = $_SERVER['REMOTE_ADDR'];
            }

            $args->document_srl = $document_srl;
            $output = executeQuery('bodex.getDocumentVotedLog', $args);

            // 로그 정보에 추천 로그가 있으면 세션 등록후 패스
            if($output->data->point && $output->data->point != 0) {
                $_SESSION['voted_document'][$document_srl] = true;
                return new Object(-1, $failed_voted);
            }

            // 별점일경우 5점이상 못하게, 추천/비추천일 경우 1점이상 입력을 못하게
            if($this->module_info->use_vote == 'S' || $this->module_info->use_vote == 'Z'){
                if($point > 5) $point = 5;
                elseif($point < 0) return new Object(-1, 'msg_invalid_request');

                $args->voted_count = $oDocument->get('voted_count') + $point;
                // 별점은 평균 계산을 위한 쿼리를 하지않기 위해 비추천에 투표 인원수 넣기
                $args->blamed_count = $oDocument->get('blamed_count') - 1;
                $output = executeQuery('bodex.updateDocumentVote', $args);
            }
            else
            {
                if($point < 0 ){
                    $point =  - 1;
                    $args->blamed_count = $oDocument->get('blamed_count') - 1;
                    $output = executeQuery('document.updateBlamedCount', $args);
                }else{
                    $point =  1;
                    $args->voted_count = $oDocument->get('voted_count') + 1;
                    $output = executeQuery('document.updateVotedCount', $args);
                }
            }

            if(!$output->toBool()) return $output;

            // 로그 남기기
            $args->point = $point;
            $output = executeQuery('document.insertDocumentVotedLog', $args);
            if(!$output->toBool()) return $output;

            // 세션 정보에 남김
            $_SESSION['voted_document'][$document_srl] = true;

            // 추천을 받으면 점수받기 옵션이 있으면 점수만큼 포인트 추가
            if($this->module_info->use_vote_bonus == 'Y' && $document_member_srl){
                $oBodexModel = &getModel('bodex');

                if($point > 0 )
                    $point_config = $oBodexModel->getPointConfig('voted', $oDocument->get('module_srl'));
                else
                    $point_config = $oBodexModel->getPointConfig('blamed', $oDocument->get('module_srl'));

                if($point_config){
                    if($this->module_info->use_vote == 'S' || $this->module_info->use_vote == 'Z')
                        $point_config = $point_config * $point;

                    $oPointController = &getController('point');
                    $oPointController->setPoint(abs($document_member_srl), $point_config, 'add');
                }
            }

            // 결과 리턴
            if($point > 0)
                return new Object(0, 'success_voted');
            else
                return new Object(0, 'success_blamed');
        }

        /**
        * @brief 추천 점수 삭제
        **/
        function procBoardVoteEmpty(){
            // 문서번호가 없으면 에러
            $document_srl = Context::get('target_srl');
            if(!$document_srl) return new Object(-1, 'msg_invalid_request');

            $oModuleModel = &getModel('module');
            $module_info = $oModuleModel->getModuleInfoByDocumentSrl($document_srl);

            if($module_info->use_vote == 'N' || $module_info->use_vote_empty != 'Y') return new Object(-1, 'msg_invalid_request');

            if(!Context::get('is_logged')){
                unset($logged_member_srl);
            }else{
                $oMemberModel = &getModel('member');
                $logged_member_srl = $oMemberModel->getLoggedMemberSrl();
            }

            // 로그인 사용자이면 member_srl, 비회원이면 ipaddress로 판단
            if($logged_member_srl) {
                $args->member_srl = $logged_member_srl;
            } else {
                $args->ipaddress = $_SERVER['REMOTE_ADDR'];
            }

            $args->document_srl = $document_srl;

            // 문서에서 점수를 빼기위해 추천 점수를 기억해 두고
            $output = executeQuery('bodex.getDocumentVotedLog', $args);
            $point =$output->data->point;

            $output = executeQuery('bodex.deleteDocumentVotedLog', $args);
            if(!$output->toBool()) return $output;

            // 세션에 추천정보 삭제
            unset($_SESSION['voted_document'][$document_srl]);

            // 문서 원본을 가져옴
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);

            if($point && $oDocument->isExists()){
                // 별점일경우
                if($point > 0 && ($module_info->use_vote == 'S' || $module_info->use_vote == 'Z')){
                    $args->voted_count = $oDocument->get('voted_count') - $point;
                    // 평균 계산을 위한 투표 인원수 감소
                    $args->blamed_count = $oDocument->get('blamed_count') + 1;
                    $output = executeQuery('bodex.updateDocumentVote', $args);
                }
                else
                {
                    if($point < 0 ){
                        $args->blamed_count = $oDocument->get('blamed_count') + 1;
                        $output = executeQuery('document.updateBlamedCount', $args);
                    }elseif($point > 0 ){
                        $args->voted_count = $oDocument->get('voted_count') - 1;
                        $output = executeQuery('document.updateVotedCount', $args);
                    }
                }

                $document_member_srl = $oDocument->get('member_srl');
                // 추천을 받으면 점수받기 옵션이 있으면 점수만큼 포인트 삭제
                if($module_info->use_vote_bonus == 'Y' && $document_member_srl){
                    $oBodexModel = &getModel('bodex');

                    if($point > 0 )
                        $point_config = $oBodexModel->getPointConfig('voted', $oDocument->get('module_srl'));
                    else
                        $point_config = $oBodexModel->getPointConfig('blamed', $oDocument->get('module_srl'));

                    if($point_config){
                        if($module_info->use_vote == 'S' || $module_info->use_vote == 'Z')
                            $point_config = $point_config * $point;

                        $oPointController = &getController('point');
                        $oPointController->setPoint(abs($document_member_srl), $point_config, 'minus');
                    }
                }
            }

            // 결과 리턴
            return new Object(0, 'success_reset');
        }

        /**
        * @brief 문서의 추천 등록
        **/
        function procBoardVoteRegister(){
            $document_srl = Context::get('target_srl');
            $point = Context::get('point');

            if(!$point) return new Object(-1, 'msg_please_select_rating');

            return $this->updateVotedCount($document_srl, $point);
        }

        /**
        * @brief 문서의 보기 제한 포인트 사용
        **/
        function procBoardAllowView(){
            if(!Context::get('is_logged')) return new Object(-1, 'msg_please_login');

            $document_srl = Context::get('target_srl');
            if(!$document_srl) return new Object(-1, 'msg_invalid_request');

            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);

            // 자신의 올린 글이면 패스
            $logged_info = Context::get('logged_info');
            if($logged_info->member_srl == abs($oDocument->get('member_srl'))) return new Object();

            // 이미 조회했으면 패스
            $oBodexModel = &getModel('bodex');
            if($oBodexModel->getReadedLogInfo($document_srl)) return new Object();

            $reward_point=$oDocument->get('reward_point');

            // 포인트 사용이 아니면 패스
            if(!$reward_point || $reward_point <= 0) return new Object();

            // 포인트 저장 50%
            $point = round($reward_point / 2);

            $oMemberPoint = &getModel('point');
            // 포인트가 없으면 중단
            if($oMemberPoint->getPoint($logged_info->member_srl) < $point){
                return new Object(-1, 'msg_not_enough_point');
            }

            // 포인트 만큼 빼고, 얻고
            $oPointController = &getController('point');
            $oPointController->setPoint($logged_info->member_srl, $point, 'minus');
            $oPointController->setPoint($oDocument->get('member_srl'), $point, 'add');

            $args->member_srl = $logged_info->member_srl;
            $args->document_srl = $document_srl;
            $output = executeQuery('document.insertDocumentReadedLog', $args);

            return new Object();
        }

        function procBoardHistoryRestore(){
            if(!Context::get('is_logged')) return new Object(-1, 'msg_please_login');

            // 문서번호가 없으면 에러
            $history_srl = Context::get('target_srl');
            if(!$history_srl) return new Object(-1, 'msg_invalid_request');

            $oDocumentModel = &getModel('document');
            $history_data = $oDocumentModel->getHistory($history_srl);
            if(!$history_data->history_srl) return new Object(-1, 'msg_not_founded');

            $logged_info = Context::get('logged_info');
            $grant = $this->_getGrant(Context::get('cur_mid'), $logged_info);

            // 관리자와 글쓴이 본인이 아니면 오류
            if($logged_info->is_admin != 'Y' && !$grant->manager && ($logged_info->member_srl != abs($history_data->member_srl))) return new Object(-1, 'msg_not_permitted_act');

            // 이미 존재하는 글인지 체크
            $oDocument = $oDocumentModel->getDocument($history_data->document_srl, $grant->manager, false);
            if(!$oDocument->isExists()) return new Object(-1, 'msg_not_founded');

            $module_srl = $oDocument->get('module_srl');
            $oModuleModel = &getModel('module');
            $document_config = $oModuleModel->getModulePartConfig('document', $module_srl);
            if(!isset($document_config->use_history)) $document_config->use_history = 'N';
            $bUseHistory = $document_config->use_history == 'Y' || $document_config->use_history == 'Trace';

            if(!$bUseHistory) return new Object(-1, 'msg_not_use_history');

            // 같은 히스토리 문서 존재하는지 체크
            $args->regdate = $oDocument->get('last_update');
            $output = executeQuery('bodex.checkDocumentHistory', $args);

            // 같은 히스토리 문서가 없고 히스토리 기능 사용중이면 새로 기록
            if(!$output->data->count && $bUseHistory){
                $hArgs->history_srl = getNextSequence();
                $hArgs->module_srl = $module_srl;
                $hArgs->document_srl = $oDocument->get('document_srl');
                if($document_config->use_history == 'Y') $hArgs->content = $oDocument->get('content');
                $hArgs->nick_name = $oDocument->get('nick_name');
                $hArgs->member_srl = $oDocument->get('member_srl');
                $hArgs->regdate = $oDocument->get('last_update');
                $hArgs->ipaddress = $oDocument->get('ipaddress');
                $output = executeQuery('document.insertHistory', $hArgs);
            }

            $oDocumentController = &getController('document');

            // 맴버정보 구함
            $oMemberModel = &getModel('member');
            $member_info = $oMemberModel->getMemberInfoByMemberSrl(abs($history_data->member_srl), $this->module_info->site_srl);

            // 맴버가 있고 익명이 아니면 유저정보 입력
            if($member_info && $history_data->member_srl > 0)
                $obj = $this->_setUserInfo(false, $member_info);
            else{
                $obj->member_srl = $history_data->member_srl;
                $obj->email_address = $obj->homepage = $obj->user_id = '';
                $obj->user_name = $obj->nick_name = $history_data->nick_name;
            }

            $obj->document_srl = $history_data->document_srl;
            $obj->last_update = $history_data->regdate;
            $obj->content = $history_data->content;
            $obj->ipaddress = $history_data->ipaddress;
            $output = executeQuery('bodex.restoreDocumentHistory', $obj);
            if(!$output->toBool()) return $output;

            // 썸네일 파일 제거
            FileHandler::removeDir(sprintf('files/cache/thumbnails/%s',getNumberingPath($obj->document_srl, 3)));

             return new Object(0, 'success_restore');
        }

        function procBoardHistoryDelete(){
            if(!Context::get('is_logged')) return new Object(-1, 'msg_please_login');

            $logged_info = Context::get('logged_info');
            $grant = $this->_getGrant(Context::get('cur_mid'), $logged_info);

            // 관리자가 아니면 중단
            if($logged_info->is_admin != 'Y' && !$grant->manager) return new Object(-1, 'msg_not_permitted_act');

            // 문서번호가 없으면 에러
            $history_srl = Context::get('target_srl');
            if(!$history_srl) return new Object(-1, 'msg_invalid_request');

            $oDocumentModel = &getModel('document');
            $history_data = $oDocumentModel->getHistory($history_srl);
            if(!$history_data->history_srl) return new Object(-1, 'msg_not_founded');

            // 이미 존재하는 글인지 체크
            $oDocument = $oDocumentModel->getDocument($history_data->document_srl, $grant->manager, false);
            if(!$oDocument->isExists()) return new Object(-1, 'msg_not_founded');

            $module_srl = $oDocument->get('module_srl');
            $oModuleModel = &getModel('module');
            $document_config = $oModuleModel->getModulePartConfig('document', $module_srl);
            if(!isset($document_config->use_history)) $document_config->use_history = 'N';
            $bUseHistory = $document_config->use_history == 'Y' || $document_config->use_history == 'Trace';

            if(!$bUseHistory) return new Object(-1, 'msg_not_use_history');

            $args->history_srl = $history_data->history_srl;
            $args->module_srl = $history_data->module_srl;
            $args->document_srl = $history_data->document_srl;
            $output = executeQuery('document.deleteHistory', $args);

            if(!$output->toBool()) return $output;

             return new Object(0, 'success_deleted');
        }

        /**
        * @brief 문서의 상태 변경
        **/
        function procBoardChangeState(){
            if(!Context::get('is_logged')) return new Object(-1, 'msg_please_login');

            $logged_info = Context::get('logged_info');
            $grant = $this->_getGrant(Context::get('cur_mid'), $logged_info);

            // 관리자가 아니면 중단
            if($logged_info->is_admin != 'Y' && !$grant->manager) return new Object(-1, 'msg_not_permitted_act');

            $target_srls = explode(',',Context::get('target_srls'));
            if(!count($target_srls)) return false;

            // 상태값 유효성 체크
            $state_value = Context::get('state_value');
            if(!is_numeric($state_value)||($state_value>9&&$state_value<0)) return false;

            $args->is_notice = $state_value?$state_value:'N';

            // 문서 보기에서 변경한게 아니면 관리자 메뉴와 혼란을 피하기 위해 세션 삭제
            if(!Context::get('document_srl')) unset($_SESSION['document_management']);

             foreach($target_srls as $val){
                $args->document_srl = $val;
                $args->last_updater = $logged_info->nick_name.'('.Context::getLang('doc_state').')';
                $output = executeQuery('bodex.updateDocumentState', $args);
            }

            // 결과 리턴
            return new Object(0, 'success_updated');
        }


/**************************
* @brief triggers
**************************/

        /**
        * @brief 다운로드 후 trigger
        **/
        function triggerDownloadFile(&$obj){
            return $this->_checkFileDownload($obj, true);
        }

        /**
        * @brief 다운로드 전 trigger
        **/
        function triggerBeforeDownloadFile(&$obj){

            // 링크 파일은 바로 입력
            if(!$obj->media_player && preg_match("/^(https?|ftp|file|mms):\/\/[0-9a-z-]+(\.[_0-9a-z-\/\~]+)+(:[0-9]{2,4})*/i",$obj->uploaded_filename)){
                $output = $this->_checkFileDownload($obj, true);
                if(!$output->toBool()) return $output;

                // 이상이 없으면 download_count 증가
                $args->file_srl = $obj->file_srl;
                executeQuery('file.updateFileDownloadCount', $args);

                Context::close();
                exit("<script>location.href = (('".$obj->uploaded_filename."').replace(/&amp;/g,'&'));</script>");
            }

            return $this->_checkFileDownload($obj);
        }

        /**
        * @brief 나중에 코어에서 해결될때 그땐 지우자 (phidel temp code)
        * 이 게시물... 클릭시 나오는 메뉴 제어 trigger, 추천/비추천 메뉴 삭제
        **/
        function triggerDocumentMenu(&$obj){
            $mid = Context::get('cur_mid');
            $document_srl = Context::get('target_srl');

            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);
            if(!$oDocument->isExists()) return new Object();

            // 해당 모듈의 정보를 구함
            $oModuleModel = &getModel('module');
            $module_info = $oModuleModel->getModuleInfoByMid($mid);

            if($module_info->module != 'bodex') return new Object();

            // 추천방식이 일반일때만
            if($module_info->use_vote == 'Y'){
                // 글쓴이가 아니라면 추천/비추천 보여줌.
                $logged_info = Context::get('logged_info');
                if($logged_info && ($logged_info->member_srl != abs($oDocument->get('member_srl')))) return new Object();
             }

            $del_count = 0;

            $menus = Context::get('document_popup_menu_list');
            $menus_count = count($menus);
            for($i=0;$i<$menus_count;$i++) {
                if ($menus[$i]->str == 'cmd_vote' || $menus[$i]->str == 'cmd_vote_down'){
                    array_splice($menus,$i,1);
                    $del_count++;

                    // 다 찾았으면 쓸모없는 루프를 줄임
                    if($del_count == 2)break;
                    // 삭제하고 갯수를 줄이고 키값은 줄여서 에러를 방지
                    $menus_count--;
                    $i--;
                }
            }

            Context::set('document_popup_menu_list', $menus);

            return new Object();
        }

        /**
         * @brief 아이디 클릭시 나타나는 팝업메뉴에 "작성글 보기" 메뉴를 추가하는 trigger
         **/
        function triggerMemberMenu(&$obj) {
            $member_srl = abs(Context::get('target_srl'));
            $mid = Context::get('cur_mid');

            if(!$member_srl || !$mid) return new Object();

            $logged_info = Context::get('logged_info');

            // 호출된 모듈의 정보 구함
            $oModuleModel = &getModel('module');
            $cur_module_info = $oModuleModel->getModuleInfoByMid($mid);

            if($cur_module_info->module != 'bodex') return new Object();

            // 자신의 아이디를 클릭한 경우
            if($logged_info && (abs($member_srl) == abs($logged_info->member_srl))) {
                $member_info = $logged_info;
            } else {
                $oMemberModel = &getModel('member');
                $member_info = $oMemberModel->getMemberInfoByMemberSrl($member_srl);
            }

            $oMemberController = &getController('member');

            if($member_info->user_id){
                // 아이디로 검색기능 추가
                $url = getUrl('','mid',$mid,'search_target','user_id','search_keyword',$member_info->user_id);
                $oMemberController->addMemberPopupMenu($url, 'cmd_view_own_document', './modules/member/tpl/images/icon_view_written.gif');
            }

            return new Object();
        }
    }
?>
