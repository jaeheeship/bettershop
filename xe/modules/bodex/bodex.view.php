<?php
    /**
     * @class  bodexView
     **/

    class bodexView extends bodex {

        /**
         * @brief 초기화
         **/
        function init() {
            // 설정이 정상적으로 완료되지 않았으면 기본 값 정리
            if(!$this->module_info->use_reward){
                if(!in_array($this->module_info->use_category,array('N','Y','T','L','R'))) $this->module_info->use_category = 'N';
                if(!in_array($this->module_info->use_allow_view,array('Y','P','N'))) $this->module_info->use_allow_view = 'N';
                if(!in_array($this->module_info->use_allow_down,array('Y','P','N'))) $this->module_info->use_allow_down = 'N';
                if(!in_array($this->module_info->use_reward,array('N','Y','R'))) $this->module_info->use_reward = 'N';
                if(!in_array($this->module_info->use_vote,array('N','Y','R','S','Z'))) $this->module_info->use_vote = 'N';
                if(!in_array($this->module_info->use_secret,array('N','Y','R'))) $this->module_info->use_secret = 'N';
                if(!in_array($this->module_info->use_secret_comment,array('N','Y','R'))) $this->module_info->use_secret_comment = 'N';
                if(!in_array($this->module_info->use_allow_comment,array('N','Y','R'))) $this->module_info->use_allow_comment = 'Y';
                if(!in_array($this->module_info->use_allow_trackback,array('N','Y','R'))) $this->module_info->use_allow_trackback = 'Y';
                if(!in_array($this->module_info->use_anonymous,array('N','Y','R'))) $this->module_info->use_anonymous = 'N';
                if(!in_array($this->module_info->use_anonymous_comment,array('N','Y','R'))) $this->module_info->use_anonymous_comment = 'N';

                if($this->module_info->consultation!='Y') $this->module_info->consultation = 'N';
                if($this->module_info->use_doc_state!='Y') $this->module_info->use_doc_state = 'N';
                if(!$this->module_info->use_reward_value) $this->module_info->use_reward_value = '20,40,60,80,100,200,400,600,800,1000';
            }

            $this->except_notice = $this->module_info->except_notice == 'N' ? false : true;

            // 기본 게시판용 스킨과 옵션 맞춤
            $this->module_info->secret = $this->module_info->use_secret;

            // 기본 모듈 정보들 설정 (list_count, page_count는 게시판 모듈 전용 정보이고 기본 값에 대한 처리를 함)
            if($this->module_info->list_count) $this->list_count = $this->module_info->list_count;
            if($this->module_info->search_list_count) $this->search_list_count = $this->module_info->search_list_count;
            if($this->module_info->page_count) $this->page_count = $this->module_info->page_count;

            // 상담 기능 체크. 현재 게시판의 관리자이면 상담기능을 off시킴
            // 현재 사용자가 비로그인 사용자라면 글쓰기/댓글쓰기/목록보기/글보기 권한을 제거함
            if($this->module_info->consultation == 'Y' && !$this->grant->manager) {
                $this->consultation = true;
                if(!Context::get('is_logged')) $this->grant->list = $this->grant->write_document = $this->grant->write_comment = $this->grant->view = false;
            } else {
                $this->consultation = false;
            }

            // 스킨 경로를 미리 template_path 라는 변수로 설정함, 스킨이 존재하지 않는다면 ex_default로 변경
            $template_path = sprintf("%sskins/%s/",$this->module_path, $this->module_info->skin);
            if(!is_dir($template_path)||!$this->module_info->skin) {
                $this->module_info->skin = 'ex_default';
                $template_path = sprintf("%sskins/%s/",$this->module_path, $this->module_info->skin);
            }
            $this->setTemplatePath($template_path);

            // 사용자 레이아웃 있다면 설정
            $custom_layout_path = urldecode(Context::get('custom_layout_path'));
            $custom_layout_file = urldecode(Context::get('custom_layout_file'));

            // 보안 관계상 절대경로 파일폴더 제외
            // !stristr($custom_layout_path,'files/attach') - 파일명이 자동 변경되서 체크안함
            if($custom_layout_path && !strpos($custom_layout_path,':')){
                $this->setLayoutPath($custom_layout_path);
            }
            if($custom_layout_file) $this->setLayoutFile($custom_layout_file);

            // 확장 변수 사용시 미리 확장변수의 대상 키들을 가져와서 context set
            $oDocumentModel = &getModel('document');
            $extra_keys = $oDocumentModel->getExtraKeys($this->module_srl);
            Context::set('extra_keys', $extra_keys);

            $oModuleModel = &getModel('module');
            $document_config = $oModuleModel->getModulePartConfig('document', $this->module_srl);
            $this->module_info->use_history = $document_config->use_history;

            // 게시판 전반적으로 사용되는 javascript, JS 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'input_password.xml');
            Context::addJsFile($this->module_path.'tpl/js/bodex.js');

            // bodex 모듈 함수 사용을 위해 셋팅
            $oBodex = new bodexItem($this->module_srl, $this->module_info->display_extra_images);
            Context::set('oBodex', $oBodex);
        }

        function dispBoardHistoryList(){
            $document_srl = Context::get('document_srl');
            if(!$document_srl) return $this->dispBoardMessage('msg_invalid_request');

            $hpage = Context::get('hpage');
            $list_count = Context::get('list_count');
            if(!$list_count) $list_count = 5;

            $oDocumentModel = &getModel('document');
            $oHistory = $oDocumentModel->getHistories($document_srl, $list_count, $hpage);

            Context::set('history_list', $oHistory->data);
            Context::set('total_hcount', $oHistory->total_count);
            Context::set('total_hpage', $oHistory->total_page);
            Context::set('hpage', $oHistory->page);
            Context::set('hpage_navigation', $oHistory->page_navigation);

            $history_srl = Context::get('history_srl');
            if($history_srl) {
                $history_data = $oDocumentModel->getHistory($history_srl);
                Context::set('history_data', $history_data);

                // 레이아웃을 popup_layout으로 설정
                if(Context::get('is_poped')) $this->setLayoutFile('popup_layout');
                $this->setTemplateFile('history');
            }else{
                $this->dispBoardContent();
            }
        }

        /**
         * @brief 목록 및 선택된 글 출력
         **/
        function dispBoardContent() {
            // 목록보기 권한 체크 (모든 권한은 ModuleObject에서 xml 정보와 module_info의 grant 값을 비교하여 미리 설정하여 놓음)
            if(!$this->grant->access || !$this->grant->list) return $this->dispBoardMessage('msg_not_permitted');

            // 카테고리를 사용하는지 확인후 사용시 카테고리 목록을 구해와서 Context에 세팅
            $this->dispBoardCategoryList();

            /**
             * @brief 목록이 노출될때 같이 나오는 검색 옵션을 정리하여 스킨에서 쓸 수 있도록 context set
             * 확장변수에서 검색 선택된 항목이 있으면 역시 추가
             **/
            $oBodexModel = &getModel('bodex');
            $search_option = $oBodexModel->getSearchConfig($this->module_srl, $this->module_info->search_config);
            Context::set('search_option', $search_option);
            Context::set('doc_state_list', explode(',',$this->module_info->use_doc_state_value));

            // 게시글을 가져옴
            $re = $this->dispBoardContentView();
            if($re && $re->error) return $this->dispBoardMessage($re->message);

            // 공지사항 목록을 구해서 context set (공지사항을 매페이지 제일 상단에 위치하기 위해서)
            $this->dispBoardNoticeList();

            // 목록
            $this->dispBoardContentList();

            // 사용되는 javascript 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'search_document.xml');

            // template_file을 list.html로 지정
            $this->setTemplateFile('list');
        }

        /**
         * @brief 카테고리 항목을 구해와서 스킨에서 사용할 수 있도록 세팅
         **/
        function dispBoardCategoryList(){
            // 카테고리를 사용할때에만 데이터를 추출
            if($this->module_info->use_category!='N') {
                $oDocumentModel = &getModel('document');
                $category_list = $oDocumentModel->getCategoryList($this->module_srl);
                // 상위 분류 권한을 하위분류에도 적용
                foreach($category_list as $idx=>$cat_val){
                    if($cat_val->parent_srl)
                        $category_list[$idx]->grant = $category_list[$cat_val->parent_srl]->grant;
                }
                Context::set('category_list', $category_list);
            }
        }

        /**
         * @brief 선택된 게시글이 있을 경우 글을 가져와서 스킨에서 사용하도록 세팅
         **/
        function dispBoardContentView(){
            // 요청된 변수 값들을 정리
            $document_srl = Context::get('document_srl');
            $page = Context::get('page');

            // document model 객체 생성
            $oDocumentModel = &getModel('document');

            // 요청된 문서 번호가 있다면 문서를 구함
            if($document_srl) {
                $oDocument = $oDocumentModel->getDocument($document_srl, $this->grant->manager, $this->module_info->use_load_extra_vars == 'Y');

                // 해당 문서가 존재할 경우 필요한 처리를 함
                if($oDocument->isExists()) {
                    // 글과 요청된 모듈이 다르다면 오류 표시
                    if($oDocument->get('module_srl') != $this->module_srl) return $this->stop('msg_invalid_request');

                    // 관리 권한이 있거나 공지라면 권한을 부여
                    if($this->grant->manager) $oDocument->setGrant();

                    // 상담기능이 사용되고 공지사항이 아니고 사용자의 글도 아니면 무시
                    if($this->consultation && !$oDocument->isNotice()) {
                        if(!$oDocument->isEditable()) $oDocument = $oDocumentModel->getDocument(0, false, false);
                    }
                // 요청된 문서번호의 문서가 없으면 document_srl null 처리 및 경고 메세지 출력
                } else {
                    Context::set('document_srl','',true);
                    return new Object(-1, 'msg_not_permitted');
                }

            // 요청된 문서 번호가 아예 없다면 빈 문서 객체 생성
            } else {
                $oDocument = $oDocumentModel->getDocument(0, false, false);
            }

            if($oDocument->isExists()) {
                // 글 보기 권한을 체크해서 권한이 없으면 오류 메세지 출력하도록 처리
                if(!$this->grant->view && !$oDocument->isGranted() && !$oDocument->isNotice()) {
                    $oDocument = $oDocumentModel->getDocument(0, false, false);
                    Context::set('document_srl','',true);
                    return new Object(-1, 'msg_not_permitted');
                } else {
                    // 브라우저 타이틀에 글의 제목을 추가
                    Context::addBrowserTitle($oDocument->getTitleText());
                    $is_updateReadedCount = (!$oDocument->isSecret() || $oDocument->isGranted());

                    $logged_info = Context::get('logged_info');

                    // 비밀글일때 컨텐츠를 보여주지 말자.
                    if(!$this->grant->manager && !$oDocument->isGranted() && (!$logged_info || $logged_info->member_srl != abs($oDocument->get('member_srl')))){
                        if($oDocument->isSecret()){
                            $oDocument->add('content',Context::getLang('thisissecret'));
                            $is_updateReadedCount = false;
                        }elseif(($this->module_info->use_reward != 'N' && $this->module_info->use_allow_view == 'P') || ($this->module_info->use_allow_view == 'Y')){
                            // 보기 제한시 글 잘라 보여줌
                            $oBodexModel = &getModel('bodex');

                            if($this->module_info->use_allow_view == 'P' && $oDocument->get('reward_point')>0 && !$oBodexModel->getReadedLogInfo($oDocument->document_srl)){
                                $oDocument->add('content',$oDocument->getSummary($this->module_info->allow_view_cut_size));
                                $is_updateReadedCount = false;
                            }elseif($this->module_info->use_allow_view == 'Y' && !$oBodexModel->isMemberComment($oDocument->document_srl)){
                                $oDocument->add('content',$oDocument->getSummary($this->module_info->allow_view_cut_size));
                                $is_updateReadedCount = false;
                            }
                        }
                    }

                    if($is_updateReadedCount) $oDocument->updateReadedCount();

                    // 베스트 댓글 출력 사용중이면 세팅
                    if($this->module_info->display_best_comment=='Y') {
                        $oBodexModel = &getModel('bodex');
                        Context::set('best_comment_list', $oBodexModel->getBestCommentList($oDocument, $this->module_info));
                    }
                }
            }

            // 스킨에서 사용할 oDocument 변수 세팅
            $oDocument->add('module_srl', $this->module_srl);

            Context::set('oDocument', $oDocument);
            // 사용되는 javascript 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert_comment.xml');
        }

        /**
         * @brief 선택된 글이 있을 경우 첨부파일에 대한 정보를 API 에서 사용할 수 있도록 세팅
         **/
        function dispBoardContentFileList(){
            $oDocumentModel = &getModel('document');
            $document_srl = Context::get('document_srl');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);
            Context::set('file_list',$oDocument->getUploadedFiles());
        }

        /**
         * @brief 공지사항이 있을 경우 API에서 사용할 수 있게 하기 위해서 세팅
         **/
        function dispBoardNoticeList(){
            $oDocumentModel = &getModel('document');
            $args->module_srl = $this->module_srl;
            $notice_output = $oDocumentModel->getNoticeList($args);
            Context::set('notice_list', $notice_output->data);
        }

        /**
         * @brief 선택된 글이 있을 경우 그 글의 댓글 목록을 API 에서 사용할 수 있도록 세팅
         **/
        function dispBoardContentCommentList(){
            $oDocumentModel = &getModel('document');
            $document_srl = Context::get('document_srl');
            $oDocument = $oDocumentModel->getDocument($document_srl, false, false);

            if(Context::get('is_poped')){
                Context::set('oDocument',$oDocument);

                // 레이아웃을 popup_layout으로 설정
                $this->setLayoutFile('popup_layout');
                $this->setTemplateFile('comment_list');
            }else{
                $comment_list = $oDocument->getComments();

                // 비밀글일때 컨텐츠를 보여주지 말자.
                foreach($comment_list as $key => $val){
                    if(!$val->isAccessible()){
                        $val->add('content',Context::getLang('thisissecret'));
                    }
                }
                Context::set('comment_list',$comment_list);
            }

            // 사용되는 javascript 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert_comment.xml');
        }

        /**
         * @brief 게시글 목록
         **/
        function dispBoardContentList(){
            // 목록 보기 권한이 없을 경우 목록을 보여주지 않음
            if(!$this->grant->list) {
                Context::set('document_list', array());
                Context::set('total_count', 0);
                Context::set('total_page', 1);
                Context::set('page', 1);
                Context::set('page_navigation', new PageHandler(0,0,1,10));
                return;
            }

            // 목록을 구하기 위한 대상 모듈/ 페이지 수/ 목록 수/ 페이지 목록 수에 대한 옵션 설정
            $args->module_srl = $this->module_srl;
            $args->page = Context::get('page');
            $args->list_count = $this->list_count;
            $args->page_count = $this->page_count;

            // 카테고리를 사용한다면 카테고리 값을 받음
            if($this->module_info->use_category!='N') $args->category_srl = Context::get('category');

            $args->sort_index = Context::get('sort_index');
            $args->order_type = Context::get('order_type');

            // 별점일 경우 sort_index 를 바꿔 직접 구하게 유도
            if($args->sort_index == 'voted_count' && ($this->module_info->use_vote=='S'||$this->module_info->use_vote=='Z')) $args->sort_index = 'star_count';

            // 정렬 없으면 기본값 입력 // 확장 검색으로 검사 안함 if(!in_array($args->sort_index, $this->order_target))
            if(!$args->sort_index) $args->sort_index = $this->module_info->order_target?$this->module_info->order_target:'list_order';
            if(!in_array($args->order_type, array('asc','desc'))) $args->order_type = $this->module_info->order_type?$this->module_info->order_type:'asc';

            // 상담 기능이 on되어 있으면 현재 로그인 사용자의 글만 나타나도록 옵션 변경
            if($this->consultation) {
                $logged_info = Context::get('logged_info');
                $args->member_srl = $logged_info->member_srl;
            }

            // 검색과 정렬을 위한 변수 설정
            $args->search_target = Context::get('search_target');
            $args->search_keyword = Context::get('search_keyword');

            // 상세 검색시 옵션 받음
            if($args->search_target == 'ex_search') $args->ex_search_targets = Context::get('ex_search_targets');

            // 만약 카테고리가 있거나 검색어가 있으면list_count를 search_list_count 로 이용
            if($args->category_srl || $args->search_keyword) $args->list_count = $this->search_list_count;

            // 날짜일 경우 숫자만 남기고 제거, 상태일 경우 explode 키값 구함
            if($args->search_target == 'regdate' || $args->search_target == 'last_update'){
                $args->search_keyword = preg_replace(array('/\s/','/:/','/-/'),array('','',''),$args->search_keyword);
            }elseif($args->search_target=='doc_state') {
                $doc_state_list = explode(',',$this->module_info->use_doc_state_value);
                $args->search_keyword = (string) array_search($args->search_keyword, $doc_state_list);
            }

            $oDocumentModel = &getModel('document');
            $oBodexModel = &getModel('bodex');

            // 특정 문서의 permalink로 직접 접속할 경우 page값을 직접 구함
            $_get = $_GET;
            if(count($_get)==2) unset($_get['mid']);
            if(count($_get)==1 && ($_GET['document_srl'] || $_GET['entry'])) {
                $oDocument = $oDocumentModel->getDocument(Context::get('document_srl'), false, false);
                if($oDocument->isExists() && !$oDocument->isNotice()) {
                    $page = $oDocumentModel->getDocumentPage($oDocument, $args);
                    Context::set('page', $page);
                    $args->page = $page;
                }
            }

            $output = $oBodexModel->getDocumentList($args, $this->except_notice, $this->module_info->use_load_extra_vars == 'Y');

            Context::set('document_list', $output->data);
            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('page_navigation', $output->page_navigation);

            // 목록 설정값을 세팅
            Context::set('list_config', $oBodexModel->getListConfig($this->module_srl));
            // 베스트 글 출력 사용중이면 세팅
            if($this->module_info->display_best_document=='Y') {
                Context::set('best_document_list', $oBodexModel->getBestDocumentList($this->module_srl, $this->module_info));
            }
        }

        /**
         * %brief 미디어 목록
         **/
        function dispBoardMediaPlayer() {
            $file_srl = Context::get('file_srl');
            $sid = Context::get('sid');
            $upload_target_srl = Context::get('document_srl');

            $oFileModel = &getModel('file');

            if($file_srl){
                $file_obj = $oFileModel->getFile($file_srl);

                // 지정된 글이 있는지 확인
                if($file_obj->upload_target_srl) {
                    $oDocumentModel = &getModel('document');
                    $oDocument = $oDocumentModel->getDocument($file_obj->upload_target_srl, false, false);
                }

                // 만약 보기 권한 없을 경우 보여주지 않음
                if((!$oDocument ||  $oDocument->isSecret() || !$this->grant->view) && !$this->grant->manager && !$this->grant->is_admin) {
                    if(!$oDocument || !$oDocument->isGranted()) return $this->dispBoardMessage('msg_not_permitted');
                }

                // 요청된 파일 정보가 잘못되었다면 파일을 찾을 수 없다는 오류 출력
                if($file_obj->file_srl!=$file_srl || $file_obj->sid!=$sid) return $this->dispBoardMessage('msg_file_not_found');

                // 미디어 아니면 패스
                if($file_obj->direct_download!='Y') return $this->dispBoardMessage('msg_invalid_request');

                if(!preg_match("/\.(swf|flv|mp[1234]|as[fx]|wm[av]|mpg|mpeg|avi|wav|mid|midi|mov|moov|qt|rm|ram|ra|rmm|m4v)$/i", $file_obj->source_filename))
                    return $this->dispBoardMessage('msg_invalid_request');

            }elseif($upload_target_srl){
                // 나중에 리스트도 추가 해야지...
                return $this->dispBoardMessage('msg_invalid_request');
                $file_objs = $oFileModel->getFiles($upload_target_srl);
            }else{
                return $this->dispBoardMessage('msg_invalid_request');
            }

            //% 트리거 호출 이전에 미디어 플레이임을 알림
            //$file_obj->media_player = true;

            $oBodexController = &getController('bodex');
            // 현재 포인트 체크및 기록
            $output = $oBodexController->_checkFileDownload($file_obj, true);
            if(!$output->toBool()) return $this->dispBoardMessage($output->message);

            // 이상이 없으면 download_count 증가
            $args->file_srl = $file_srl;
            executeQuery('file.updateFileDownloadCount', $args);

            Context::set('file', $file_obj);

            // 레이아웃을 popup_layout으로 설정
            if(Context::get('is_poped')) $this->setLayoutFile('popup_layout');

            $this->setTemplateFile('multimedia');
        }

        /**
         * @brief 태그 목록 모두 보기
         **/
        function dispBoardTagList() {
            // 만약 목록, 보기 권한 없을 경우 보여주지 않음
            if(!$this->grant->list || !$this->grant->view) return $this->dispBoardMessage('msg_not_permitted');

            $pop_list_count = Context::get('pop_list_count');
            $args->mid = $this->module_info->mid;
            $args->list_count = ($pop_list_count)?$pop_list_count:5000;
            $args->sort_index = 'rand()';
            //$args->order_type = 'asc';

            // 태그 모델 객체에서 태그 목록을 구해옴
            $oTagModel = &getModel('tag');
            $output = $oTagModel->getTagList($args);

            // 내용을 랜덤으로 정렬
            if(count($output->data)) {
                $numbers = array_keys($output->data);
                shuffle($numbers);

                if(count($output->data)) {
                    foreach($numbers as $k => $v) {
                        $tag_list[] = $output->data[$v];
                    }
                }
            }

            Context::set('tag_list', $tag_list);

            // 레이아웃을 popup_layout으로 설정
            if(Context::get('is_poped')) $this->setLayoutFile('popup_layout');
            $this->setTemplateFile('tag_list');
        }

        /**
         * @brief 이미지 목록 모두 보기
         **/
        function dispBoardImageList() {
            // 만약 목록, 보기 권한 없을 경우 보여주지 않음
            if(!$this->grant->list || !$this->grant->view) return $this->dispBoardMessage('msg_not_permitted');

            $pop_list_count = Context::get('pop_list_count');
            $category_srl = Context::get('category');

            $args->module_srl = $this->module_info->module_srl;
            $args->list_count = ($pop_list_count)?$pop_list_count:100;
            $args->sort_index = 'rand()';
            $args->order_type = 'asc';
            if($category_srl) $args->category_srl = $category_srl;
            if(!$this->grant->manager) $args->is_secret = 'N';
            $output = executeQuery('bodex.getImageList', $args);

            $image_list = $output->data;
            if($image_list && !is_array($image_list)) $image_list = array($image_list);

            Context::set('image_list', $image_list);

            // 카테고리를 사용할때에만 데이터를 추출
            if($this->module_info->use_category!='N') {
                $oDocumentModel = &getModel('document');
                $category_list = $oDocumentModel->getCategoryList($this->module_srl);
                // 상위 분류 권한을 하위분류에도 적용
                foreach($category_list as $idx=>$cat_val){
                    if($cat_val->parent_srl)
                        $category_list[$idx]->grant = $category_list[$cat_val->parent_srl]->grant;
                }
                Context::set('category_list', $category_list);
            }

            // 레이아웃을 popup_layout으로 설정
            if(Context::get('is_poped')) $this->setLayoutFile('popup_layout');
            $this->setTemplateFile('image_list');
        }

        /**
         * @brief 글 작성 화면 출력
         **/
        function dispBoardWrite() {
            // 권한 체크
            if(!$this->grant->write_document) return $this->dispBoardMessage('msg_not_permitted');

            $oDocumentModel = &getModel('document');

            // 카테고리를 사용하는지 확인후 사용시 카테고리 목록을 구해와서 Context에 세팅
            $this->dispBoardCategoryList();

            // GET parameter에서 document_srl을 가져옴
            $document_srl = Context::get('document_srl');
            $oDocument = $oDocumentModel->getDocument(0, $this->grant->manager, $this->module_info->use_load_extra_vars == 'Y');
            $oDocument->setDocument($document_srl);
            $oDocument->add('module_srl', $this->module_srl);

            // 수정하기 포인트 답변 사용시 답변이 달리면 관리자 외에 불가
            if(!$this->grant->manager && $oDocument->isExists() && ($this->module_info->use_reward == 'Y' || $this->module_info->use_reward == 'R')){
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                    $oCommentModel = &getModel('comment');
                    if($oCommentModel->getCommentCount($document_srl)>0) return $this->dispBoardMessage('msg_not_permitted');
                }
            }

            // 글을 수정하려고 할 경우 권한이 없는 경우 비밀번호 입력화면으로
            if($oDocument->isExists()&&!$oDocument->isGranted()) return $this->setTemplateFile('input_password_form');

            if(!$oDocument->isExists()) {
                $oModuleModel = &getModel('module');
                $point_config = $oModuleModel->getModulePartConfig('point',$this->module_srl);

                $pointForInsert = $point_config['insert_document'];
                if($pointForInsert < 0) {
                    // 내 포인트 가져오기
                    $logged_info = Context::get('logged_info');
                    $oPointModel = &getModel('point');
                    $my_member_point = $oPointModel->getPoint($logged_info->member_srl);

                    if( !$logged_info ) return $this->dispBoardMessage('msg_not_permitted');
                    else if (($my_member_point + $pointForInsert )< 0 ) return $this->dispBoardMessage('msg_not_enough_point');
                }
            }else{
                // 존재하는 글이면 확장변수 값을 context set
                $extra_keys = $oDocumentModel->getExtraVars($this->module_srl, $document_srl);
                Context::set('extra_keys', $extra_keys);
            }

            Context::set('document_srl',$document_srl);
            Context::set('oDocument', $oDocument);

            // 확장변수처리를 위해 xml_js_filter를 직접 header에 적용
            $oDocumentController = &getController('document');
            $oDocumentController->addXmlJsFilter($this->module_srl);

            // 사용되는 javascript 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert.xml');
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert_filelink.xml');

            $this->setTemplateFile('write_form');
        }

        /**
         * @brief 문서 삭제 화면 출력
         **/
        function dispBoardDelete() {
            // 권한 체크
            if(!$this->grant->write_document) return $this->dispBoardMessage('msg_not_permitted');

            // 삭제할 문서번호를 가져온다
            $document_srl = Context::get('document_srl');

            // 지정된 글이 있는지 확인
            if($document_srl) {
                $oDocumentModel = &getModel('document');
                $oDocument = $oDocumentModel->getDocument($document_srl, $this->grant->manager, $this->module_info->use_load_extra_vars == 'Y');
            }

            // 삭제하려는 글이 없으면 에러
            if(!$oDocument->isExists()) return $this->dispBoardContent();

            // 포인트 사용시 답변이 달리면 관리자 외에 불가
            if(!$this->grant->manager && ($this->module_info->use_reward == 'Y' || $this->module_info->use_reward == 'R')){
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                    $oCommentModel = &getModel('comment');
                    if($oCommentModel->getCommentCount($document_srl)>0) return $this->dispBoardMessage('msg_not_permitted');
                }
            }

            // 권한이 없는 경우 비밀번호 입력화면으로
            if(!$oDocument->isGranted()) return $this->setTemplateFile('input_password_form');

            Context::set('oDocument',$oDocument);

            // 필요한 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'delete_document.xml');

            $this->setTemplateFile('delete_form');
        }

        /**
         * @brief 댓글의 답글 화면 출력
         **/
        function dispBoardWriteComment() {
            $document_srl = Context::get('document_srl');

            // 권한 체크
            if(!$this->grant->write_comment) return $this->dispBoardMessage('msg_not_permitted');

            // 원본글을 구함
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($document_srl, $this->grant->manager, $this->module_info->use_load_extra_vars == 'Y');
            if(!$oDocument->isExists()) return $this->dispBoardMessage('msg_invalid_request');

            // 해당 댓글를 찾아본다 (comment_form을 같이 쓰기 위해서 빈 객체 생성)
            $oCommentModel = &getModel('comment');
            $oSourceComment = $oComment = $oCommentModel->getComment(0);
            $oComment->add('document_srl', $document_srl);
            $oComment->add('module_srl', $this->module_srl);

            // 필요한 정보들 세팅
            Context::set('oDocument',$oDocument);
            Context::set('oSourceComment',$oSourceComment);
            Context::set('oComment',$oComment);

            // 필요한 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert_comment.xml');

            $this->setTemplateFile('comment_form');
        }

        /**
         * @brief 댓글의 답글 화면 출력
         **/
        function dispBoardReplyComment() {
            // 권한 체크
            if(!$this->grant->write_comment) return $this->dispBoardMessage('msg_not_permitted');

            // 목록 구현에 필요한 변수들을 가져온다
            $parent_srl = Context::get('comment_srl');

            // 지정된 원 댓글이 없다면 오류
            if(!$parent_srl) return $this->dispBoardMessage('msg_invalid_request');

            // 해당 댓글를 찾아본다
            $oCommentModel = &getModel('comment');
            $oSourceComment = $oCommentModel->getComment($parent_srl, $this->grant->manager);

            // 댓글이 없다면 오류
            if(!$oSourceComment->isExists()) return $this->dispBoardMessage('msg_invalid_request');
            if(Context::get('document_srl') && $oSourceComment->get('document_srl') != Context::get('document_srl')) return $this->dispBoardMessage('msg_invalid_request');

            // 대상 댓글을 생성
            $oComment = $oCommentModel->getComment();
            $oComment->add('parent_srl', $parent_srl);
            $oComment->add('document_srl', $oSourceComment->get('document_srl'));

            // 필요한 정보들 세팅
            Context::set('oSourceComment',$oSourceComment);
            Context::set('oComment',$oComment);
            Context::set('module_srl',$this->module_srl);

            // 사용되는 javascript 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert_comment.xml');

            $this->setTemplateFile('comment_form');
        }

        /**
         * @brief 댓글 수정 폼 출력
         **/
        function dispBoardModifyComment() {
            // 권한 체크
            if(!$this->grant->write_comment) return $this->dispBoardMessage('msg_not_permitted');

            // 목록 구현에 필요한 변수들을 가져온다
            $document_srl = Context::get('document_srl');
            $comment_srl = Context::get('comment_srl');

            // 지정된 댓글이 없다면 오류
            if(!$comment_srl) return $this->dispBoardMessage('msg_invalid_request');

            // 해당 댓글를 찾아본다
            $oCommentModel = &getModel('comment');
            $oComment = $oCommentModel->getComment($comment_srl, $this->grant->manager);

            // 댓글이 없다면 오류
            if(!$oComment->isExists()) return $this->dispBoardMessage('msg_invalid_request');

            // 수정하기 채택된 답변은 관리자 외에 불가
            if( !$this->grant->manager && $oComment->isExists() && ($this->module_info->use_reward == 'Y' || $this->module_info->use_reward == 'R')){
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                    $oBodexModel = &getModel('bodex');
                    if($oBodexModel->isAdoptedComment($comment_srl)) return $this->dispBoardMessage('msg_not_permitted');
                }
            }

            // 글을 수정하려고 할 경우 권한이 없는 경우 비밀번호 입력화면으로
            if(!$oComment->isGranted()) return $this->setTemplateFile('input_password_form');

            // 필요한 정보들 세팅
            Context::set('oSourceComment', $oCommentModel->getComment());
            Context::set('oComment', $oComment);

            // 사용되는 javascript 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'insert_comment.xml');

            $this->setTemplateFile('comment_form');
        }

        /**
         * @brief 댓글 삭제 화면 출력
         **/
        function dispBoardDeleteComment() {
            // 권한 체크
            if(!$this->grant->write_comment) return $this->dispBoardMessage('msg_not_permitted');

            // 삭제할 댓글번호를 가져온다
            $comment_srl = Context::get('comment_srl');

            // 삭제하려는 댓글이 있는지 확인
            if($comment_srl) {
                $oCommentModel = &getModel('comment');
                $oComment = $oCommentModel->getComment($comment_srl, $this->grant->manager);
            }

            // 삭제하려는 글이 없으면 에러
            if(!$oComment->isExists() ) return $this->dispBoardContent();

            // 채택된 답변은 관리자 외에 불가
            if( !$this->grant->manager && ($this->module_info->use_reward == 'Y' || $this->module_info->use_reward == 'R')){
                if($this->module_info->use_allow_view != 'P' && $this->module_info->use_allow_down != 'P'){
                    $oBodexModel = &getModel('bodex');
                    if($oBodexModel->isAdoptedComment($comment_srl)) return $this->dispBoardMessage('msg_not_permitted');
                }
            }

            // 권한이 없는 경우 비밀번호 입력화면으로
            if(!$oComment->isGranted()) return $this->setTemplateFile('input_password_form');

            Context::set('oComment',$oComment);

            // 필요한 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'delete_comment.xml');

            $this->setTemplateFile('delete_comment_form');
        }

        /**
         * @brief 엮인글 삭제 화면 출력
         **/
        function dispBoardDeleteTrackback() {
            // 삭제할 댓글번호를 가져온다
            $trackback_srl = Context::get('trackback_srl');

            // 삭제하려는 댓글가 있는지 확인
            $oTrackbackModel = &getModel('trackback');
            $output = $oTrackbackModel->getTrackback($trackback_srl);
            $trackback = $output->data;

            // 삭제하려는 글이 없으면 에러
            if(!$trackback) return $this->dispBoardContent();

            Context::set('trackback',$trackback);

            // 필요한 필터 추가
            Context::addJsFilter($this->module_path.'tpl/filter', 'delete_trackback.xml');

            $this->setTemplateFile('delete_trackback_form');
        }

        /**
         * @brief 메세지 출력
         **/
        function dispBoardMessage($msg_code) {
            $msg = Context::getLang($msg_code);
            if(!$msg) $msg = $msg_code;
            Context::set('message', $msg);
            if(Context::get('is_poped')) $this->setLayoutFile('popup_layout');
            $this->setTemplateFile('message');
        }
    }
?>
