<?php
    /**
     * @class  bodexAdminController
     **/

    class bodexAdminController extends bodex {

        /**
         * @brief 초기화
         **/
        function init() {
            // 메모리 절약 차원에서 관리자용 언어팩은 따로 읽기
            Context::loadLang($this->module_path.'lang/admin');
        }

        /**
        * @brief 스킨 설정에 빠진 기본값 입력
        **/
        function _skinDefaultVars($skin_info, $out_args=null){
            if(!$skin_info) return;

            unset($skin_args);
            $is_update =false;

            if($out_args){
                $is_update = true;
                foreach($out_args as $val) {
                    if($val->name) $skin_args->{$val->name} = $val->value;
                }
            }

            foreach($skin_info->extra_vars as $val) {
                // 이미 설정된 값이 없고 기본값이 있으면
                if($val->name && !$skin_args->{$val->name} && $val->default){
                    // 검색이 쉽게 배열 미리 정렬
                    $arr_value = array('getLang'=>false, 'notReq'=>false);
                    $get_default = explode('::',$val->default);
                    for($i=0;$i<count($get_default);$i++) $arr_value[$get_default[$i]] = $get_default[$i];

                    // 값이 없거나, 업데이트시에 'notReq'가 있어 필수가 아니면 넘어감
                    if(count($arr_value)<3 || ($is_update && $arr_value['notReq'])) continue;

                    if($value = array_pop($arr_value)){
                        // 'getLang' 있으면 언어 교체
                        if($arr_value['getLang'])
                            $val->default =Context::getLang($value);
                        else
                            $val->default = $value;

                        $skin_args->{$val->name} = $val->default;
                    }
                }
            }

            if($skin_info->extra_vars && !$skin_args->colorset){
                $skin_args->colorset = $skin_info->colorset[0]->name; // 컬러셋팅
            }

            return $skin_args;
        }

        /**
         * @brief 게시판 추가
         **/
        function procBodexAdminInsertBoard($args = null) {
            $logged_info = Context::get('logged_info');

            // 게시판 모듈의 정보 설정
            $args = Context::getRequestVars();
            $args->module = 'bodex';
            $args->mid = $args->bodex_name;
            unset($args->bodex_name);

            // 기본 값외의 것들을 정리
            if(!$args->skin) $args->skin='ex_default';

            if(!in_array($args->use_category,array('N','Y','T','L','R'))) $args->use_category = 'N';
            if(!in_array($args->use_allow_view,array('Y','P','N'))) $args->use_allow_view = 'N';
            if(!in_array($args->use_allow_down,array('Y','P','N'))) $args->use_allow_down = 'N';
            if(!in_array($args->use_reward,array('N','Y','R'))) $args->use_reward = 'N';
            if(!in_array($args->use_vote,array('N','Y','R','S','Z'))) $args->use_vote = 'N';
            if(!in_array($args->use_secret,array('N','Y','R'))) $args->use_secret = 'N';
            if(!in_array($args->use_secret_comment,array('N','Y','R'))) $args->use_secret_comment = 'N';
            if(!in_array($args->use_allow_comment,array('N','Y','R'))) $args->use_allow_comment = 'Y';
            if(!in_array($args->use_allow_trackback,array('N','Y','R'))) $args->use_allow_trackback = 'Y';
            if(!in_array($args->use_anonymous,array('N','Y','R'))) $args->use_anonymous = 'N';
            if(!in_array($args->use_anonymous_comment,array('N','Y','R'))) $args->use_anonymous_comment = 'N';
            if(!in_array($args->use_anonymous_phase,array('1','2','3'))) $args->use_anonymous_phase = '2';

            $display_extra_images=explode('|@|',$args->display_extra_images);
            if($display_extra_images[0]!='none') $args->display_extra_images = '';

            if($args->except_notice!='Y') $args->except_notice = 'N';
            if($args->consultation!='Y') $args->consultation = 'N';
            if($args->use_doc_state!='Y') $args->use_doc_state = 'N';
            if($args->use_ex_search!='Y') $args->use_ex_search = 'N';

            if($args->use_down_point_medias!='Y') $args->use_down_point_medias = 'N';
            if($args->use_down_point_images!='Y') $args->use_down_point_images = 'N';
            if($args->use_down_point_always!='Y') $args->use_down_point_always = 'N';
            if($args->display_best_document!='Y') $args->display_best_document = 'N';
            if($args->display_best_comment!='Y') $args->display_best_comment = 'N';

            if(!is_numeric($args->best_date_range)||$args->best_date_range<='0') $args->best_date_range = '7';
            if(!is_numeric($args->best_list_count)||$args->best_list_count<='0') $args->best_list_count = '2';

            if(!in_array($args->best_sort_index,array('voted_count','readed_count','comment_count'))) $args->best_sort_index = 'voted_count';

            if(!is_numeric($args->point_voted)) $args->point_voted = 0;
            if(!is_numeric($args->point_blamed)) $args->point_blamed = 0;

            if(!$args->use_reward_value) $args->use_reward_value = '20,40,60,80,100,200,400,600,800,1000';
            if(!$args->use_doc_state_value) $args->use_doc_state_value = Context::getLang('use_doc_state_default_value');

            if($args->order_target!='random' && !in_array($args->order_target,$this->order_target)) $args->order_target = 'list_order';
            if(!in_array($args->order_type,array('asc','desc'))) $args->order_type = 'asc';

            // 첫번째 숫자는 내 포인트와 비교되니 가장 작아야함, 포인트 목록 정렬
            $use_reward_value=explode(',',$args->use_reward_value);
            sort($use_reward_value);
            $args->use_reward_value = implode(',',$use_reward_value);

            // use_doc_state_value 값이 10개 보다 많으면  10개로 맞춤
            $use_doc_state_value=explode(',',$args->use_doc_state_value);
            if(count($use_doc_state_value)>10){
                for($i=count($use_doc_state_value)-1; 9 < $i  ;$i--){
                    array_pop($use_doc_state_value);
                }
                $args->use_doc_state_value = implode(',',$use_doc_state_value);
            }

            // module 모듈의 model/controller 객체 생성
            $oModuleController = &getController('module');
            $oModuleModel = &getModel('module');
            $skin_info = $oModuleModel->loadSkinInfo($this->module_path, $args->skin);

            if(!$skin_info) return new Object(-1, 'msg_not_skin_info');

            // module_srl이 넘어오면 원 모듈이 있는지 확인
            if($args->module_srl) {
                $module_info = $oModuleModel->getModuleInfoByModuleSrl($args->module_srl);
                if($module_info->module_srl != $args->module_srl){
                    unset($args->module_srl);
                }else{
                    // 업데이트이면 검색 설정 가져와서 따로 입력
                    $args->search_config = $module_info->search_config;
                    // 최고 관리자가 아니면 중요한 정보는 이전 정보 입력
                    if($logged_info->is_admin!='Y'){
                        $args->mid = $module_info->mid;
                        $args->module_category_srl = $module_info->module_category_srl;
                        $args->layout_srl = $module_info->layout_srl;
                        $args->skin = $module_info->skin;
                    }
                }
            }

            // module_srl의 값에 따라 insert/update
            if(!$args->module_srl) {
                $output = $oModuleController->insertModule($args);

                // 스킨설정 초기화 하기
                if($output->toBool()){
                    $skin_args = $this->_skinDefaultVars($skin_info);
                    if($skin_args) $oModuleController->insertModuleSkinVars($output->get('module_srl'), $skin_args);
                }

                $msg_code = 'success_registed';

            } else {
                $output = $oModuleController->updateModule($args);

                // 중요한 스킨설정 없으면 입력
                if($output->toBool()){
                    $out_args = $oModuleModel->getModuleSkinVars($args->module_srl);
                    $skin_args = $this->_skinDefaultVars($skin_info, $out_args);
                    if($skin_args) $oModuleController->insertModuleSkinVars($args->module_srl, $skin_args);
                }

                $msg_code = 'success_updated';
            }

            if(!$output->toBool()) return $output;

            $this->add('page',Context::get('page'));
            $this->add('module_srl',$output->get('module_srl'));

            // 최고 관리자 포인트 수정도 가능
            if($logged_info->is_admin=='Y'){
                $point_config = $oModuleModel->getModulePartConfig('point', $output->get('module_srl'));

                $point_config['voted'] = $args->point_voted;
                $point_config['blamed'] = $args->point_blamed;
                $oModuleController->insertModulePartConfig('point',$output->get('module_srl'),$point_config);
            }

            $this->setMessage($msg_code);
        }

        /**
         * @brief 게시판 삭제
         **/
        function procBodexAdminDeleteBoard() {
            $module_srl = Context::get('module_srl');

            // 원본을 구해온다
            $oModuleController = &getController('module');
            $output = $oModuleController->deleteModule($module_srl);
            if(!$output->toBool()) return $output;

            $this->add('module','bodex');
            $this->add('page',Context::get('page'));
            $this->setMessage('success_deleted');
        }

        /**
         * @brief 게시판 목록 지정
         **/
        function procBodexAdminInsertListConfig() {
            $module_srl = Context::get('module_srl');
            $list = explode(',',Context::get('list'));
            $sort_list = explode(',',Context::get('sort_list'));
            if(!count($list)) return new Object(-1, 'msg_invalid_request');

            // sort 값을 찾기 쉽게 정렬
            $sort_val = array();
            foreach($sort_list as $val) {
                $val = trim($val);
                if(!$val) continue;
                if(substr($val,0,10)=='extra_vars') $val = '_'.substr($val,10);
                $sort_val[$val] = true;
            }

            $list_arr = array();
            foreach($list as $val) {
                $val = trim($val);
                if(!$val) continue;
                if(substr($val,0,10)=='extra_vars') $val = '_'.substr($val,10);
                $list_arr[$val] = $sort_val[$val] ? 'Y':'N';
            }

            $oModuleController = &getController('module');
            $oModuleController->insertModulePartConfig('bodex', $module_srl, $list_arr);
        }

        /**
         * @brief 게시판 검색 지정
         **/
        function procBodexAdminInsertSearchConfig() {
            $module_srl = Context::get('module_srl');
            $list = Context::get('list');
            if(!$list || !$module_srl) return new Object(-1, 'msg_invalid_request');

            $oModuleModel = &getModel('module');
            $module_info = $oModuleModel->getModuleInfoByModuleSrl($module_srl);
            if($module_info->module_srl != $module_srl) return new Object(-1, 'msg_invalid_request');

            $module_info->search_config = $list;
            $oModuleController = &getController('module');
            $output = $oModuleController->updateModule($module_info);
            if(!$output->toBool()) return $output;
        }

        /**
         * @brief 추천 수 새로 갱신
         **/
        function procBodexAdminRecountVoted(){
            $module_srl = Context::get('module_srl');
            $use_vote = Context::get('use_vote');
            if(!$module_srl||!$use_vote||$use_vote=='N') return false;

            $oDB = &DB::getInstance();

            $query=sprintf("select document_srl from %sdocuments where module_srl='%d'",$oDB->prefix,$module_srl);
            $result = $oDB->_query($query);
            $output = $oDB->_fetch($result);

            if($use_vote=='S'||$use_vote=='Z'){
                $q_sum1="sum(case when point>0 then point else 1 end) as sum_p";
                $q_sum2="count(point) as sum_m";
            }elseif($use_vote=='Y'||$use_vote=='R'){
                $q_sum1="sum(case when point>0 then 1 else 0 end) as sum_p";
                $q_sum2="sum(case when point<0 then 1 else 0 end) as sum_m";
            }

            if(!is_array($output) && count($output) > 0){
                $output = array($output);
            }

            foreach($output as $val){
                $query=sprintf("select %s, %s from %sdocument_voted_log where document_srl='%d'",$q_sum1,$q_sum2,$oDB->prefix,$val->document_srl);
                $result = $oDB->_query($query);
                $output = $oDB->_fetch($result);

                $args->voted_count = $output->sum_p;
                $args->blamed_count = -abs($output->sum_m);
                $args->document_srl = $val->document_srl;
                $output = executeQuery('bodex.updateDocumentVote', $args);
            }

            return new Object(-1, 'success_restore');
        }
    }
?>
