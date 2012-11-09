<?php
    /**
     * @class  bodexAdminView
     **/

    class bodexAdminView extends bodex {

        /**
         * @brief 초기화
         **/
        function init() {
            // module_srl이 있으면 미리 체크하여 존재하는 모듈이면 module_info 세팅
            $module_srl = Context::get('module_srl');
            if(!$module_srl && $this->module_srl) {
                $module_srl = $this->module_srl;
                Context::set('module_srl', $module_srl);
            }

            // module model 객체 생성
            $oModuleModel = &getModel('module');

            // module_srl이 넘어오면 해당 모듈의 정보를 미리 구해 놓음
            if($module_srl) {
                $module_info = $oModuleModel->getModuleInfoByModuleSrl($module_srl);
                if(!$module_info) {
                    Context::set('module_srl','');
                    $this->act = 'list';
                } else {
                    ModuleModel::syncModuleToSite($module_info);
                    $this->module_info = $module_info;
                    Context::set('module_info',$module_info);
                }
            }

            if($module_info && $module_info->module != 'bodex') return $this->stop("msg_invalid_request");

            // 메모리 절약 차원에서 관리자용 언어팩은 따로 읽기
            Context::loadLang($this->module_path.'lang/admin');

            // 모듈 카테고리 목록을 구함
            $module_category = $oModuleModel->getModuleCategories();
            Context::set('module_category', $module_category);

            // 템플릿 경로 지정 (bodex의 경우 tpl에 관리자용 템플릿 모아놓음)
            $template_path = sprintf("%stpl/",$this->module_path);
            $this->setTemplatePath($template_path);

            // 정렬 옵션을 세팅
            foreach($this->order_target as $key) $order_target[$key] = Context::getLang($key);
            $order_target['list_order'] = Context::getLang('document_srl');
            $order_target['update_order'] = Context::getLang('last_update');
            $order_target['random'] = Context::getLang('random');
            unset($order_target['last_update']);

            Context::set('order_target', $order_target);
        }

        /**
         * @brief 사용자 확장 변수 설정
         **/
        function dispBodexAdminSimpleExtra() {
            $mode = Context::get('mode');
            $tpl_file = urldecode(Context::get('tpl_file'));
            if(!$tpl_file) return $this->stop("msg_invalid_request");
            if($mode=='insert'){


            }
            $oDocumentAdminModel = &getModel('document');
            $extra_keys = $oDocumentAdminModel->getExtraKeys($this->module_info->module_srl);
            Context::set('extra_keys', $extra_keys);

            $this->setLayoutFile('');
            $template_path = sprintf("%sskins/%s/",$this->module_path,$this->skin);
            $this->setLayoutPath($template_path);
            $this->setLayoutFile($tpl_file);
        }

        /**
         * @brief 게시판 관리 초기 화면 보여줌
         **/
        function dispBodexAdminContent() {
            $args->page = 1;
            $args->list_count = 5;
            $args->page_count = 1;
            $args->sort_index = 'list_order';
            $args->order_type = 'asc';
            $output = executeQueryArray('bodex.getDocumentList', $args);
            ModuleModel::syncModuleToSite($output->data);

            Context::set('new_documents', $output->data);

            $args->page = 1;
            $args->list_count = 7;
            $args->page_count = 1;
            $args->sort_index = 'list_order';
            $args->order_type = 'asc';
            $output = executeQueryArray('bodex.getCommentList', $args);
            ModuleModel::syncModuleToSite($output->data);

            Context::set('new_comments', $output->data);

            $args->page = 1;
            $args->list_count = 3;
            $args->page_count = 1;
            $args->sort_index = 'regdate';
            $args->order_type = 'desc';
            $output = executeQueryArray('bodex.getNewestDeclaredList', $args);

            if($output->data && count($output->data)) {
                $document_list = array();
                foreach($output->data as $key => $document) {
                    $args->member_srl = $document->member_srl;
                    $mput = executeQuery('member.getMemberInfoByMemberSrl', $args);
                    $document->nick_name = ($mput->data)?$mput->data->nick_name:('MemberSrl_'.$document->member_srl);
                    $document_list[$key] = $document;
                }
                $output->data = $document_list;
            }

            ModuleModel::syncModuleToSite($output->data);

            Context::set('new_declareds', $output->data);

            $args->page = 1;
            $args->list_count = 3;
            $args->page_count = 1;
            $args->sort_index = 'regdate';
            $args->order_type = 'desc';
            $output = executeQueryArray('bodex.getNewestDeclaredCommentList', $args);

            if($output->data && count($output->data)) {
                $document_list = array();
                foreach($output->data as $key => $document) {
                    $args->member_srl = $document->member_srl;
                    $mput = executeQuery('member.getMemberInfoByMemberSrl', $args);
                    $document->nick_name = ($mput->data)?$mput->data->nick_name:('MemberSrl_'.$document->member_srl);
                    $document_list[$key] = $document;
                }
                $output->data = $document_list;
            }

            ModuleModel::syncModuleToSite($output->data);

            Context::set('new_declareds_comment', $output->data);

            $args->list_count = 5;
            $args->sort_index = 'regdate';
            $args->order_type = 'desc';
            $output = executeQueryArray('bodex.getNewestDownloadList', $args);

            if($output->data && count($output->data)) {
                $document_list = array();
                foreach($output->data as $key => $document) {
                    $args->member_srl = $document->member_srl;
                    $mput = executeQuery('member.getMemberInfoByMemberSrl', $args);
                    $document->nick_name = ($mput->data)?$mput->data->nick_name:('MemberSrl_'.$document->member_srl);
                    $document_list[$key] = $document;
                }
                $output->data = $document_list;
            }

            ModuleModel::syncModuleToSite($output->data);

            Context::set('new_downloads', $output->data);

            $this->setTemplateFile('index');
        }


        /**
         * @brief 게시판 관리 목록 보여줌
         **/
        function dispBodexAdminBoardList() {
            // 등록된 bodex 모듈을 불러와 세팅
            $args->sort_index = "module_srl";
            $args->page = Context::get('page');
            $args->list_count = 20;
            $args->page_count = 10;
            $args->s_module_category_srl = Context::get('module_category_srl');
            $output = executeQueryArray('bodex.getBodexList', $args);
            ModuleModel::syncModuleToSite($output->data);

            // 템플릿에 쓰기 위해서 context::set
            Context::set('total_count', $output->total_count);
            Context::set('total_page', $output->total_page);
            Context::set('page', $output->page);
            Context::set('bodex_list', $output->data);
            Context::set('page_navigation', $output->page_navigation);

            $this->setTemplateFile('bodex_list');
        }

        /**
         * @brief 선택된 게시판의 정보 출력 (바로 정보 입력으로 변경)
         **/
        function dispBodexAdminBoardInfo() {
            $this->dispBodexAdminInsertBoard();
        }

        /**
         * @brief 게시판 추가 폼 출력
         **/
        function dispBodexAdminInsertBoard() {
            if(!in_array($this->module_info->module, array('admin', 'bodex'))) {
                return $this->alertMessage('msg_invalid_request');
            }

            // 스킨 목록을 구해옴
            $oModuleModel = &getModel('module');
            $skin_list = $oModuleModel->getSkins($this->module_path);
            Context::set('skin_list',$skin_list);

            $mskin_list = $oModuleModel->getSkins($this->module_path, "m.skins");
            Context::set('mskin_list', $mskin_list);

            // 레이아웃 목록을 구해옴
            $oLayoutModel = &getModel('layout');
            $layout_list = $oLayoutModel->getLayoutList();
            Context::set('layout_list', $layout_list);

            $mobile_layout_list = $oLayoutModel->getLayoutList(0,"M");
            Context::set('mlayout_list', $mobile_layout_list);

            $config = $oModuleModel->getModuleConfig('point');
            $point_config = $oModuleModel->getModulePartConfig('point', $this->module_info->module_srl);
            Context::set('point_config', $point_config);

            $this->setTemplateFile('bodex_insert');
        }

        /**
         * @brief 게시판 추가 설정 보여줌
         **/
        function dispBodexAdminBoardAdditionSetup() {
            // content는 다른 모듈에서 call by reference로 받아오기에 미리 변수 선언만 해 놓음
            $content = '';

            // 추가 설정을 위한 트리거 호출
            // 게시판 모듈이지만 차후 다른 모듈에서의 사용도 고려하여 trigger 이름을 공용으로 사용할 수 있도록 하였음
            $output = ModuleHandler::triggerCall('module.dispAdditionSetup', 'before', $content);
            $output = ModuleHandler::triggerCall('module.dispAdditionSetup', 'after', $content);

            $logged_info = Context::get('logged_info');
            $isSiteAdmin = false;

            // 최고관리자나 사이트 관리자 아니면 몇가지 중요 추가설정 감춤
            if($logged_info->is_admin!='Y'){
                $oModuleModel = &getModel('module');
                $isSiteAdmin = $oModuleModel->isSiteAdmin($logged_info, $this->module_info->site_srl);
            }
            if($logged_info->is_admin!='Y' && !$isSiteAdmin){
                $content = preg_replace('/(<form\s.+insert_file_module_config.+>)/', '<form style="display:none"><script>insert_file_module_config=null;</script>', $content);
                $content = preg_replace('/(<form\s.+insert_rss_module_config.+>)/', '<form style="display:none"><script>insert_rss_module_config=null;</script>', $content);
                $content = preg_replace('/(<form\s.+insert_trackback_module_config.+>)/', '<form style="display:none"><script>insert_trackback_module_config=null;</script>', $content);
                $content = preg_replace('/(<form\s.+insert_point_module_config.+>)/', '<form style="display:none"><script>insert_point_module_config=null;</script>', $content);
            }

            Context::set('setup_content', $content);

            $this->setTemplateFile('addition_setup');
        }

        /**
         * @brief 게시판 삭제 화면 출력
         **/
        function dispBodexAdminDeleteBoard() {
            if(!Context::get('module_srl')) return $this->dispBodexAdminContent();
            if(!in_array($this->module_info->module, array('admin', 'bodex'))) {
                return $this->alertMessage('msg_invalid_request');
            }

            $module_info = Context::get('module_info');

            $oDocumentModel = &getModel('document');
            $document_count = $oDocumentModel->getDocumentCount($module_info->module_srl);
            $module_info->document_count = $document_count;

            Context::set('module_info',$module_info);

            $this->setTemplateFile('bodex_delete');
        }

        /**
         * @brief 게시판의 목록 설정
         **/
        function dispBodexAdminListSetup() {
            $oBodexAdminModel = &getAdminModel('bodex');
            $oBodexModel = &getModel('bodex');

            Context::set('extra_vars', $oBodexAdminModel->getDefaultListConfig($this->module_info->module_srl));
            Context::set('list_config', $oBodexModel->getListConfig($this->module_info->module_srl));

            $this->setTemplateFile('list_setting');
        }

        /**
         * %brief 게시판의 검색 설정
         **/
        function dispBodexAdminSearchSetup() {
            $oBodexAdminModel = &getAdminModel('bodex');
            $oBodexModel = &getModel('bodex');

            Context::set('extra_vars', $oBodexAdminModel->getDefaultSearchConfig($this->module_info->module_srl));
            Context::set('search_config', $oBodexModel->getSearchConfig($this->module_info->module_srl));

            $this->setTemplateFile('search_setting');
        }

        /**
         * @brief 카테고리의 정보 출력
         **/
        function dispBodexAdminCategoryInfo() {
            $oDocumentModel = &getModel('document');
            $catgegory_content = $oDocumentModel->getCategoryHTML($this->module_info->module_srl);
            Context::set('category_content', $catgegory_content);

            Context::set('module_info', $this->module_info);
            $this->setTemplateFile('category_list');
        }

        /**
         * @brief 권한 목록 출력
         **/
        function dispBodexAdminGrantInfo() {
            $oModuleAdminModel = &getAdminModel('module');
            $grant_content = $oModuleAdminModel->getModuleGrantHTML($this->module_info->module_srl, $this->xml_info->grant);
            Context::set('grant_content', $grant_content);

            $this->setTemplateFile('grant_list');
        }

        /**
         * @brief 확장 변수 설정
         **/
        function dispBodexAdminExtraVars() {
            $oDocumentAdminModel = &getModel('document');
            $extra_vars_content = $oDocumentAdminModel->getExtraVarsHTML($this->module_info->module_srl);
            Context::set('extra_vars_content', $extra_vars_content);

            $this->setTemplateFile('extra_vars');
        }

        /**
         * @brief 스킨 정보 보여줌
         **/
        function dispBodexAdminSkinInfo() {
            $oModuleAdminModel = &getAdminModel('module');
            $skin_content = $oModuleAdminModel->getModuleSkinHTML($this->module_info->module_srl);

            if(!Context::get('skin_info')) {
                $this->alertMessage('msg_not_skin_info');
            }

            $skin_content = preg_replace('/\%POPUP\_\((.+?)\)\_\((.+?)\)\%/', '<a href="#" onclick="popopen(\'./modules/'.$this->module.'/skins/'.$this->skin.'/\\2.html\',\'_bodexSkinHelp\'); return false">\\1</a>', $skin_content);
            $skin_content = preg_replace('/\%EXTRA\_\((.+?)\)\_\((.+?)\)\%/', '<a href="#" onclick="popopen(\'./?module=bodex&act=dispBodexAdminSimpleExtra&module_srl='.$this->module_info->module_srl.'&tpl_file=\\2\',\'_bodexSkinHelp\'); return false">\\1</a>', $skin_content);

            Context::set('skin_content', $skin_content);

            $this->setTemplateFile('skin_info');
        }


        /**
         * @brief bodex module용 메시지 출력
         **/
        function alertMessage($message) {
            $script =  sprintf('<script type="text/javascript"> xAddEventListener(window,"load", function() { alert("%s"); } );</script>', str_replace("\n","\\n",Context::getLang($message)));
            Context::addHtmlHeader( $script );
        }
    }
?>
