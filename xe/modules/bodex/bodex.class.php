<?php
    /**
     * @class  bodex
     **/

    require_once(_XE_PATH_.'modules/bodex/bodex.item.php');

    class bodex extends ModuleObject {

        var $order_target = array('list_order','regdate','last_update','update_order','readed_count','voted_count','comment_count','trackback_count','uploaded_count','title','category_srl'); // 정렬 옵션

        var $skin = "ex_default"; ///< 스킨 이름
        var $list_count = 20; ///< 한 페이지에 나타날 글의 수
        var $page_count = 10; ///< 페이지의 수
        var $category_list = NULL; ///< 카테고리 목록

        /**
         * @brief 설치시 추가 작업이 필요할시 구현
         **/
        function moduleInstall() {
            // 포인트 필드 추가 (쿼리로 인한 속도 저하를 줄이기 위해 테이블을 따로 사용안하고 필드를 사용)
            $oDB = &DB::getInstance();
            if(!$oDB->isColumnExists('documents', 'reward_point')){
                $oDB->addColumn('documents', 'reward_point', 'number', '11', '0', false);
                $oDB->addIndex('documents', 'idx_reward_point', array('module_srl','reward_point'));
            }
            if(!$oDB->isColumnExists('documents', 'reward_srl')){
                $oDB->addColumn('documents', 'reward_srl', 'number', '11', '0', false);
                $oDB->addIndex('documents', 'idx_reward_srl', 'reward_srl');
            }

            // action forward에 등록 (관리자 모드에서 사용하기 위함)
            $oModuleController = &getController('module');

            // 아이디 클릭시 나타나는 팝업메뉴에 작성글 보기 기능 추가
            $oModuleController->insertTrigger('member.getMemberMenu', 'bodex', 'controller', 'triggerMemberMenu', 'after');
            // 이 게시물... 클릭시 나오는 메뉴 제어
            $oModuleController->insertTrigger('document.getDocumentMenu', 'bodex', 'controller', 'triggerDocumentMenu', 'after');
            // 다운로드 로그
            $oModuleController->insertTrigger('file.downloadFile', 'bodex', 'controller', 'triggerBeforeDownloadFile', 'before');
            $oModuleController->insertTrigger('file.downloadFile', 'bodex', 'controller', 'triggerDownloadFile', 'after');

            // 기본 게시판 생성
            $args->site_srl = 0;
            $output = executeQuery('module.getSite', $args);
            if(!$output->data->index_module_srl) {
                $args->mid = 'bodex';
                $args->module = 'bodex';
                $args->browser_title = 'XpressEngine';
                $args->skin = 'ex_default';
                $args->site_srl = 0;
                $output = $oModuleController->insertModule($args);

                if($output->toBool()){
                    $module_srl = $output->get('module_srl');
                    $site_args->site_srl = 0;
                    $site_args->index_module_srl = $module_srl;
                    $oModuleController->updateSite($site_args);

                    //스킨 설정 기본값 입력
                    $oModuleModel = &getModel('module');
                    $skin_info = $oModuleModel->loadSkinInfo($this->module_path, $args->skin);
                    if($skin_info){
                        $oBodexAdminController = &getAdminController('bodex');
                        $skin_args = $oBodexAdminController->_skinDefaultVars($skin_info);
                        if($skin_args)
                            $oModuleController->insertModuleSkinVars($module_srl, $skin_args);
                    }
                }
            }

            return new Object();
        }

        /**
         * @brief 설치가 이상이 없는지 체크하는 method
         **/
        function checkUpdate() {
            $oDB = &DB::getInstance();
            if(!$oDB->isColumnExists('documents', 'reward_point')) return true;
            if(!$oDB->isColumnExists('documents', 'reward_srl')) return true;

            $oModuleModel = &getModel('module');
            if(!$oModuleModel->getTrigger('member.getMemberMenu', 'bodex', 'controller', 'triggerMemberMenu', 'after')) return true;
            if(!$oModuleModel->getTrigger('document.getDocumentMenu', 'bodex', 'controller', 'triggerDocumentMenu', 'after')) return true;
            if(!$oModuleModel->getTrigger('file.downloadFile', 'bodex', 'controller', 'triggerBeforeDownloadFile', 'before')) return true;
            if(!$oModuleModel->getTrigger('file.downloadFile', 'bodex', 'controller', 'triggerDownloadFile', 'after')) return true;

            return false;
        }

        /**
         * @brief 업데이트 실행
         **/
        function moduleUpdate() {
            $oDB = &DB::getInstance();
            if(!$oDB->isColumnExists('documents', 'reward_point')){
                $oDB->addColumn('documents', 'reward_point', 'number', '11', '0', false);
                $oDB->addIndex('documents', 'idx_reward_point', array('module_srl','reward_point'));
            }
            if(!$oDB->isColumnExists('documents', 'reward_srl')){
                $oDB->addColumn('documents', 'reward_srl', 'number', '11', '0', false);
                $oDB->addIndex('documents', 'idx_reward_srl', 'reward_srl');
            }

            $oModuleModel = &getModel('module');
            $oModuleController = &getController('module');
            if(!$oModuleModel->getTrigger('member.getMemberMenu', 'bodex', 'controller', 'triggerMemberMenu', 'after'))
                $oModuleController->insertTrigger('member.getMemberMenu', 'bodex', 'controller', 'triggerMemberMenu', 'after');
            if(!$oModuleModel->getTrigger('document.getDocumentMenu', 'bodex', 'controller', 'triggerDocumentMenu', 'after'))
                $oModuleController->insertTrigger('document.getDocumentMenu', 'bodex', 'controller', 'triggerDocumentMenu', 'after');
            if(!$oModuleModel->getTrigger('file.downloadFile', 'bodex', 'controller', 'triggerBeforeDownloadFile', 'before'))
                $oModuleController->insertTrigger('file.downloadFile', 'bodex', 'controller', 'triggerBeforeDownloadFile', 'before');
            if(!$oModuleModel->getTrigger('file.downloadFile', 'bodex', 'controller', 'triggerDownloadFile', 'after'))
                $oModuleController->insertTrigger('file.downloadFile', 'bodex', 'controller', 'triggerDownloadFile', 'after');

            return new Object(0, 'success_updated');
        }

        /**
         * @brief 캐시 파일 재생성
         **/
        function recompileCache() {
            //FileHandler::removeFilesInDir("./files/cache/template_compiled");
        }

    }
?>
