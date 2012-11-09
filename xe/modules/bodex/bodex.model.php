<?php
    /**
     * @class  bodexModel
     **/

    class bodexModel extends bodex {

        /**
         * @brief 채택된 답변인지 체크
         **/
        function isAdoptedComment($comment_srl) {
            if(!$comment_srl) return false;

            $oCommentModel = &getModel('comment');
            $oComment = $oCommentModel->getComment($comment_srl);
            $oDocumentModel = &getModel('document');
            $oDocument = $oDocumentModel->getDocument($oComment->document_srl, false, false);

            if(!$oDocument->isExists()) return false;
            if(abs($oDocument->get('reward_srl')) != abs($comment_srl)) return false;

            return true;
        }

        /**
         * @brief 목록 설정 값을 가져옴
         **/
        function getListConfig($module_srl) {
            $oModuleModel = &getModel('module');
            $oDocumentModel = &getModel('document');

            // 저장된 목록 설정값을 구하고 없으면 기본 값으로 설정
            $list_config = $oModuleModel->getModulePartConfig('bodex', $module_srl);
            if(!$list_config || !count($list_config)) $list_config = array( 'no'=>'-', 'title'=>'-', 'nick_name'=>'-','readed_count'=>'N','regdate'=>'N','thumbnail'=>'-','summary'=>'-');

            // 사용자 선언 확장변수 구해와서 배열 변환후 return
            $inserted_extra_vars = $oDocumentModel->getExtraKeys($module_srl);

            foreach($list_config as $key=>$val) {
                if(preg_match('/^(_)([0-9]+)$/',$key)){
                    $key = substr($key,1);
                    $output['extra_vars'.$key] = $inserted_extra_vars[$key];
                    $output['extra_vars'.$key]->sort = $val;
                }else{
                    $output[$key] = new ExtraItem($module_srl, -1, Context::getLang($key), $key, 'N', 'N', 'N', null);
                    $output[$key]->sort = $val;
                }
            }
            return $output;
        }

        /**
         * %brief 검색 설정 값을 가져옴
         **/
        function getSearchConfig($module_srl, $search_config = null) {
            if(!$search_config){
                // 검색 항목
                $oModuleModel = &getModel('module');
                $module_info = $oModuleModel->getModuleInfoByModuleSrl($module_srl);
                $search_config = $module_info->search_config;
            }

            $search_config = explode(',', $search_config);

            if(!$search_config[0])
                $search_config = array('title','content','title_content','comment','user_name','nick_name','user_id','tag');

            // 사용자 선언 확장변수 구해서 검색이 쉽게 설정
            $oDocumentModel = &getModel('document');
            $inserted_extra_vars = $oDocumentModel->getExtraKeys($module_srl);
            $extra_vars = array();

            if(count($inserted_extra_vars))
                foreach($inserted_extra_vars as $key => $val){
                    // 검색 옵션이 Y 이면 구함
                    if($val->search == 'Y') $extra_vars['extra_vars'.$val->idx] = $val->name;
                }

            // 템플릿에서 사용할 검색옵션 세팅 (검색옵션 key값은 미리 선언되어 있는데 이에 대한 언어별 변경을 함)
            foreach($search_config as $key) {
                if(strpos($key,'extra_vars')!==false) {
                    if($extra_vars[$key]) $output[$key] = $extra_vars[$key];
                }else{
                    $output[$key] = Context::getLang($key);
                }
            }

            return $output;
        }

        /**
         * %brief 미채택 글 가져와 메뉴로 보여줌
         **/
        function getBodexMenu() {
            // 요청된 모듈 번호와 현재 로그인 정보 구함
            $target_srl = Context::get('target_srl');
            $mid = Context::get('cur_mid');
            $act = Context::get('cur_act');
            $logged_info = Context::get('logged_info');

            // 첫번째 숫자는 어떤걸 요구하는지 파악
            $is_type=substr($target_srl,0,1);
            $target_srl=substr($target_srl,1);

            if(!$target_srl) return false;
            if(!in_array($is_type,array('0','1','9'))) return false;

            // menu_list 에 "표시할글,target,url" 을 배열로 넣는다
            $menu_list = array();

            // act=='dispBoardWrite' 이면 미채택글 보여줌
            if($is_type=='9'){
                // 로그인 멤버가 아니면 중단
                if(!$logged_info) return false;

                // trigger 호출
                ModuleHandler::triggerCall('bodex.getBodexNotAdoptedMenu', 'before', $menu_list);

                $args->module_srl = $target_srl;
                $args->member_srl = $logged_info->member_srl;
                $args->minus_member_srl = -1*$logged_info->member_srl;
                $args->list_count = 20;
                $output = executeQueryArray('bodex.getNotAdoptedPost', $args);

                if(!$output->toBool() || !$output->data) return false;

                $oDocumentController = &getController('document');

                foreach($output->data as $val){
                    $url = getUrl('','document_srl',$val->document_srl);
                    $oDocumentController->addDocumentPopupMenu($url,htmlspecialchars(cut_str($val->title,22,'...')).' ('.$val->comment_count.')','./modules/member/tpl/images/icon_view_written.gif', 'NotAdoptedPost');
                }

                // trigger 호출 (after)
                ModuleHandler::triggerCall('bodex.getBodexNotAdoptedMenu', 'after', $menu_list);

                $menus = Context::get('document_popup_menu_list');

            }else{
                // 본문, 댓글 에서 정보 가져옴
                if($is_type=='1'){
                    $oCommentModel = &getModel('comment');
                    $oComment = $oCommentModel->getComment($target_srl);
                    if(!$oComment->isExists()) return false;
                    $ipaddress=$oComment->getIpaddress();
                    $email_address=$oComment->get('email_address');
                    $Homepage=$oComment->isExistsHomepage()?$oComment->getHomepageUrl():null;
                }else{
                    $oDocumentModel = &getModel('document');
                    $oDocument = $oDocumentModel->getDocument($target_srl, false, false);
                    if(!$oDocument->isExists()) return false;
                    $ipaddress=$oDocument->getIpaddress();
                    $email_address=$oDocument->get('email_address');
                    $Homepage=$oDocument->isExistsHomepage()?$oDocument->getHomepageUrl():null;
                }

                // trigger 호출
                ModuleHandler::triggerCall('bodex.getBodexMenu', 'before', $menu_list);

                $oMemberController = &getController('member');

                // 메일 보기
                if($email_address)
                    $oMemberController->addMemberPopupMenu('mailto:'.$email_address, 'cmd_send_email', './modules/member/tpl/images/icon_sendmail.gif','blank');

                // 홈페이지 보기
                if($Homepage)
                    $oMemberController->addMemberPopupMenu($Homepage, 'homepage', './modules/member/tpl/images/icon_homepage.gif','blank');

                // 최고 관리자라면 ip를 보여줌
                if($logged_info->is_admin == 'Y') {
                    $url = getUrl('','module','admin','act','dispDocumentAdminList','search_target','ipaddress','search_keyword',$ipaddress);
                    $icon_path = './modules/member/tpl/images/icon_trace_document.gif';
                    $oMemberController->addMemberPopupMenu($url,'cmd_trace_document',$icon_path,'TraceMemberDocument');

                    $url = getUrl('','module','admin','act','dispCommentAdminList','search_target','ipaddress','search_keyword',$ipaddress);
                    $icon_path = './modules/member/tpl/images/icon_trace_comment.gif';
                    $oMemberController->addMemberPopupMenu($url,'cmd_trace_comment',$icon_path,'TraceMemberComment');
                }

                // trigger 호출 (after)
                ModuleHandler::triggerCall('bodex.getBodexMenu', 'after', $menu_list);

                // 팝업메뉴의 언어 변경
                $menus = Context::get('member_popup_menu_list');
                $menus_count = count($menus);
                for($i=0;$i<$menus_count;$i++) {
                    $menus[$i]->str = Context::getLang($menus[$i]->str);
                }

            }

            // 최종적으로 정리된 팝업메뉴 목록을 구함
            $this->add('menus', $menus);
        }

        /**
         * %brief 회원의 댓글이 있는지 체크
         **/
        function isMemberComment($document_srl, $member_srl=0){
            if(!$document_srl) return false;

            if(!$member_srl){
                $logged_info = Context::get('logged_info');
                $member_srl=$logged_info->member_srl;
            }

            // 맴버가 아니면 세션 체크
            if(!$member_srl && $_SESSION[$_SERVER['REMOTE_ADDR']]['insert_comment'][$document_srl])
                return true;

            return $this->getMemberCommentCount($member_srl, $document_srl) > 0;
        }

        /**
         * %brief 회원의 댓글 수를 가져옴
         **/
        function getMemberCommentCount($member_srl=0, $document_srl=0){
            if(!$member_srl){
                $logged_info = Context::get('logged_info');
                $member_srl=$logged_info->member_srl;
            }

            if(!$member_srl) return 0;

            $args->member_srl = $member_srl;
            if($document_srl) $args->document_srl = $document_srl;

            $output = executeQuery('bodex.getCommentCount', $args);
            $total_count = $output->data->count;
            return (int)$total_count;
        }

        /**
         * %brief 회원의 포인트 값 가져옴
         **/
        function getMemberPoint($member_srl=0){
            if(!$member_srl){
                $logged_info = Context::get('logged_info');
                $member_srl=$logged_info->member_srl;
            }

            if(!$member_srl) return 0;

            $oPointModel = &getModel('point');
            return $oPointModel->getPoint($member_srl);
        }

        /**
         * %brief 포인트 설정 가져옴
         **/
        function getPointConfig($name = null, $module_srl = 0) {
            $oModuleModel = &getModel('module');

            if(!$module_srl){
                $mid = Context::get('mid');

                if($mid){
                    $module_info = $oModuleModel->getModuleInfoByMid($mid);
                    $module_srl = $module_info->module_srl;
                }
            }
            if(!$module_srl)  return 0;

            $config = $oModuleModel->getModuleConfig('point');
            $module_config = $oModuleModel->getModulePartConfig('point', $module_srl);

            if($name){
                $point = $module_config[$name];
                if(!isset($point)) $point = $config->{$name};

                return $point;
            }else{
                foreach($config as $key=>$val){
                    if(!$module_config[$key] && $module_config[$key] !== 0)
                        $module_config[$key] = $config->{$key};
                }
                return $module_config;
            }
        }

        /**
         * %brief 미채택된 글 수 구함
         **/
        function getNotAdoptedPostCount($module_srl=0) {
            $logged_info = Context::get('logged_info');
            if(!$logged_info) return 0;

            if(!$module_srl){
                $mid = Context::get('mid');

                if($mid){
                    $oModuleModel = &getModel('module');
                    $module_info = $oModuleModel->getModuleInfoByMid($mid);
                    $module_srl = $module_info->module_srl;
                }
            }
            if(!$module_srl)  return 0;

            $args->module_srl = $module_srl;
            $args->member_srl = $logged_info->member_srl;
            $args->minus_member_srl = -1*$logged_info->member_srl;
            $output = executeQueryArray('bodex.getNotAdoptedPost', $args);

            if(!$output->toBool() || !$output->data) return 0;

            return (int)count($output->data);
        }

        /**
         * @brief 이전/다음 페이지 구하기
         **/
        function getDocumentNavigation($document_srl = 0, $list_count = 0, $module_srl = 0) {
            if(!$document_srl) $document_srl = Context::get('document_srl');
            if(!$document_srl) return 0;

            if(!$module_srl){
                $mid = Context::get('mid');

                if($mid){
                    $oModuleModel = &getModel('module');
                    $module_info = $oModuleModel->getModuleInfoByMid($mid);
                    $module_srl = $module_info->module_srl;
                }
            }
            if(!$module_srl)  return 0;

            $re = array();

            $args->module_srl = $module_srl;
            $args->list_count = $list_count?$list_count:1;

            $category = Context::get('category');
            if($category) $args->category_srl = $category;

            $args->order_type = 'desc';
            $args->excess_document_srl = $document_srl;
            $excess_document = executeQueryArray('bodex.getDocument', $args);

            // 0.8 <= 구버전 호환을 위해 목록 수가 없으면 배열 안씀
            if(count($excess_document->data)){
                if($list_count){
                    krsort($excess_document->data);
                    $re['previous'] = $excess_document->data;
                }else
                    $re['previous'] = $excess_document->data[0];
            }

            unset($args->excess_document_srl);

            $args->order_type = 'asc';
            $args->below_document_srl = $document_srl;
            $below_document = executeQueryArray('bodex.getDocument', $args);

            if(count($below_document->data)){
                if($list_count)
                    $re['next'] = $below_document->data;
                else
                    $re['next'] = $below_document->data[0];
            }

            return $re;
        }

        /**
         * @brief 베스트 문서 구하기
         **/
        function getBestDocumentList($module_srl = 0, $opt_args = null) {
            $oModuleModel = &getModel('module');

            if(!$module_srl){
                $mid = Context::get('mid');
                if($mid){
                    $module_info = $oModuleModel->getModuleInfoByMid($mid);
                    $module_srl = $module_info->module_srl;
                }
            }
            else
            {
                $module_info = $oModuleModel->getModuleInfoByModuleSrl($module_srl);
                $module_srl = $module_info->module_srl;
            }

            if(!$module_srl)  return;

            $best_date_range = $opt_args->best_date_range;
            $best_list_count = $opt_args->best_list_count;
            $best_sort_index = $opt_args->best_sort_index;
            if(!is_numeric($best_date_range)||$best_date_range<='0') $best_date_range = '7';
            if(!is_numeric($best_list_count)||$best_list_count<='0') $best_list_count = '2';
            if(!in_array($best_sort_index, array('voted_count','readed_count','comment_count'))) $best_sort_index = 'voted_count';

            $args->module_srl = $module_srl;
            $args->list_count = $best_list_count;
            $args->page_count = 1;
            $args->sort_index =  $best_sort_index;
            $args->order_type = 'desc';

            $week = date("YmdHis", strtotime("-$best_date_range day"));
            $args->search_target = 'best_'.$best_sort_index;
            $args->search_keyword = $week;

            $output = $this->getDocumentList($args, true, $module_info->use_load_extra_vars == 'Y');

            return $output->data;
        }

        /**
         * @brief 베스트 댓글 구하기
         **/
        function getBestCommentList($document = null, $opt_args = null) {
            if(!$document) $document_srl = Context::get('document_srl');

            if($document_srl){
                $oDocumentModel = &getModel('document');
                $document = $oDocumentModel->getDocument($document_srl, false, false);
            }

            if(!$document || !$document->isExists())  return;


            if(!$document->allowComment() || !$document->getCommentCount()) return;
            if(!$document->isGranted() && $document->isSecret()) return;

            $best_date_range = $opt_args->best_date_range;
            $best_list_count = $opt_args->best_list_count;
            if(!is_numeric($best_date_range)||$best_date_range<='0') $best_date_range = '7';
            if(!is_numeric($best_list_count)||$best_list_count<='0') $best_list_count = '2';

            $args->document_srl = $document->document_srl;
            $args->list_count = $best_list_count;
            $args->page_count = 1;
            $args->sort_index =  'voted_count';
            $args->order_type = 'desc';

            $week = date("YmdHis", strtotime("-$best_date_range day"));
            $args->best_voted_count = '1';
            $args->best_regdate = $week;
            $args->best_secret = 'N';

            $output = executeQueryArray('bodex.getCommentList', $args);
            if(!$output->toBool() || !count($output->data)) return;

            // 구해온 목록을 commentItem 객체로 만듬
            // 계층구조에 따라 부모글에 관리권한이 있으면 자식글에는 보기 권한을 줌
            $accessible = array();
            require_once(_XE_PATH_.'modules/comment/comment.item.php');

            foreach($output->data as $key => $val) {
                $oCommentItem = new commentItem();
                $oCommentItem->setAttribute($val);

                // 권한이 있는 글에 대해 임시로 권한이 있음을 설정
                if($oCommentItem->isGranted()) $accessible[$val->comment_srl] = true;

                // 현재 댓글이 비밀글이고 부모글이 있는 답글이고 부모글에 대해 관리 권한이 있으면 보기 가능하도록 수정
                if($val->parent_srl>0 && $val->is_secret == 'Y' && !$oCommentItem->isAccessible() && $accessible[$val->parent_srl] === true) {
                    $oCommentItem->setAccessible();
                }
                $comment_list[$val->comment_srl] = $oCommentItem;
            }

            return $comment_list;
        }

        function getReadedLogInfo($document_srl = 0, $isMemberCheck = true) {
            if(!$document_srl) $document_srl = Context::get('document_srl');
            if(!$document_srl) return;

            if($isMemberCheck){
                $logged_info = Context::get('logged_info');
                if(!$logged_info) return;
                $args->member_srl = $logged_info->member_srl;
            }

            $args->document_srl = $document_srl;
            $output = executeQueryArray('bodex.getDocumentReadedLog', $args);
            if(!$output->toBool() || !$output->data) return;

            $re = array();
            // 검색이 쉽게 멤버번호 또는 ip주소를 키값으로 셋팅
            foreach($output->data as $val){
                if($val->member > 0){
                    $re[$val->member] = $val->regdate;
                }else{
                    $re[$val->ipaddress] = $val->regdate;
                }
            }

            return $re;
        }

        /**
         * @brief 문서 목록 구하기
         **/
        function getDocumentList($obj, $except_notice = false, $load_extra_vars=true) {
            // 직접 처리해야할 검색 타겟
            $bodex_search_target = array('doc_state','ex_search','best_voted_count','best_readed_count','best_comment_count');
            $bodex_order_target = array('random','star_count','doc_state','reward_point','last_updater', 'nick_name', 'user_id', 'user_name', 'email_address', 'homepage', 'ipaddress','blamed_count','thumbnail','summary');
            // 도큐먼트 모듈로 넘길 정렬 대상
            $arr_order_target = array('no','list_order','regdate','last_update','update_order','readed_count','voted_count','comment_count','trackback_count','uploaded_count','title','category_srl');
            if(!in_array($obj->order_type, array('desc','asc'))) $obj->order_type = 'asc';

            $oDocumentModel = &getModel('document');

            // 지원되는 정렬 대상이면 도큐먼트 모듈 함수 사용
            if(!in_array($obj->search_target, $bodex_search_target) && in_array($obj->sort_index, $arr_order_target)){
                return $oDocumentModel->getDocumentList($obj, $except_notice, $load_extra_vars);
            }

            // 기본으로 사용할 query id 지정 (몇가지 옵션에 따라 query id가 변경됨)
            $query_id = 'bodex.getDocumentList';

            $sort_index = $obj->sort_index;
            $search_target = $obj->search_target;
            $search_keyword = $obj->search_keyword;

            // module_srl 대신 mid가 넘어왔을 경우는 직접 module_srl을 구해줌
            if($obj->mid) {
                $oModuleModel = &getModel('module');
                $obj->module_srl = $oModuleModel->getModuleSrlByMid($obj->mid);
                unset($obj->mid);
            }

            // 넘어온 module_srl은 array일 수도 있기에 array인지를 체크
            if(is_array($obj->module_srl)) $args->module_srl = implode(',', $obj->module_srl);
            else $args->module_srl = $obj->module_srl;

            // 제외 module_srl에 대한 검사
            if(is_array($obj->exclude_module_srl)) $args->exclude_module_srl = implode(',', $obj->exclude_module_srl);
            else $args->exclude_module_srl = $obj->exclude_module_srl;

            // 변수 체크
            $args->sort_index = (in_array($obj->sort_index, $arr_order_target) || in_array($obj->sort_index, $bodex_order_target))?$obj->sort_index:'list_order';
            $args->order_type = $obj->order_type;
            $args->category_srl = $obj->category_srl?$obj->category_srl:null;
            $args->page = $obj->page?$obj->page:1;
            $args->list_count = $obj->list_count?$obj->list_count:20;
            $args->page_count = $obj->page_count?$obj->page_count:10;
            $args->start_date = $obj->start_date?$obj->start_date:null;
            $args->end_date = $obj->end_date?$obj->end_date:null;
            $args->member_srl = $obj->member_srl;

            // 카테고리가 선택되어 있으면 하부 카테고리까지 모두 조건에 추가
            if($args->category_srl) {
                $category_list = $oDocumentModel->getCategoryList($args->module_srl);
                $category_info = $category_list[$args->category_srl];
                $category_info->childs[] = $args->category_srl;
                $args->category_srl = implode(',',$category_info->childs);
            }

            // 정렬 옵션 정리
            switch($sort_index) {
                case 'star_count' :
                    $args->sort_index = 'voted_count';
                    break;
                case 'doc_state' :
                    $args->sort_index = 'is_notice';
                    break;
                case 'random' :
                    $args->sort_index = 'rand()';
                    break;
                default :
                        if(strpos($sort_index,'extra_vars') === 0) {
                            $args->sort_index = 'extra_vars.value';
                            $args->var_idx = substr($sort_index, strlen('extra_vars'));
                            $query_id = 'bodex.getDocumentListWithExtraVars';
                        }
                    break;
            }

            // 검색 옵션 정리
            if($search_target && ($search_keyword || (string) $search_keyword === '0')) {
                // 지원하는 검색이므로 위에 도큐먼트 모듈 함수에서 처리됨
                //$use_division = ($args->sort_index == 'list_order' && $args->order_type == 'asc') && in_array($search_target, array('title','content','title_content','comment'));

                switch($search_target) {
                    case 'title_content' :
                            if($search_keyword) $search_keyword = str_replace(' ','%',$search_keyword);
                            $args->s_title = $search_keyword;
                            $args->s_content = $search_keyword;
                        break;
                    case 'is_notice' :
                    case 'is_secret' :
                            if($search_keyword=='N') $args->{"s_".$search_target} = 'N';
                            elseif($search_keyword=='Y') $args->{"s_".$search_target} = 'Y';
                            else $args->{"s_".$search_target} = '';
                        break;
                    case 'member_srl' :
                    case 'readed_count' :
                    case 'voted_count' :
                    case 'comment_count' :
                    case 'trackback_count' :
                    case 'uploaded_count' :
                            $args->{"s_".$search_target} = (int)$search_keyword;
                        break;
                    case 'doc_state' :
                            if((string) $search_keyword === '0') $search_keyword = "'0','N'";
                            $args->s_doc_state = $search_keyword;
                        break;
                    case 'best_voted_count' :
                    case 'best_readed_count' :
                    case 'best_comment_count' :
                            $args->{$search_target} = '1';
                            $args->best_regdate = $search_keyword;
                        break;
                    case 'comment' :
                            $args->s_comment = $search_keyword;
                            $query_id = 'document.getDocumentListWithinComment';
                        break;
                    case 'tag' :
                            $args->s_tags = str_replace(' ','%',$search_keyword);
                            $query_id = 'document.getDocumentListWithinTag';
                        break;
                    case 'ex_search' :
                            $args->var_idx = $obj->ex_search_targets;
                            $args->var_value = str_replace(' ','%',$search_keyword);
                            if($args->sort_index != 'extra_vars.value') $args->sort_index = 'documents.'.$args->sort_index;
                            $query_id = 'bodex.getDocumentListWithExtraVars';
                        break;
                    default :
                            if(strpos($search_target,'extra_vars') === 0) {
                                $args->var_idx = substr($search_target, strlen('extra_vars'));
                                $args->var_value = str_replace(' ','%',$search_keyword);
                                if($args->sort_index != 'extra_vars.value') $args->sort_index = 'documents.'.$args->sort_index;
                                $query_id = 'bodex.getDocumentListWithExtraVars';
                            }else{
                                if($search_keyword) $search_keyword = str_replace(' ','%',$search_keyword);
                                $args->{"s_".$search_target} = $search_keyword;
                            }
                        break;
                }
            }

            $output = executeQueryArray($query_id, $args);
            // 결과가 없거나 오류 발생시 그냥 return
            if(!$output->toBool()||!count($output->data)) return $output;

            $idx = 0;
            $data = $output->data;
            unset($output->data);

            if(!isset($virtual_number)) {
                $keys = array_keys($data);
                $virtual_number = $keys[0];
            }

            if($except_notice) {
                foreach($data as $key => $attribute) {
                    if($attribute->is_notice == 'Y') $virtual_number --;
                }
            }

            foreach($data as $key => $attribute) {
                if($except_notice && $attribute->is_notice == 'Y') continue;
                $document_srl = $attribute->document_srl;
                if(!$GLOBALS['XE_DOCUMENT_LIST'][$document_srl]) {
                    $oDocument = null;
                    $oDocument = new documentItem();
                    $oDocument->setAttribute($attribute, false);
                    if($is_admin) $oDocument->setGrant();
                    $GLOBALS['XE_DOCUMENT_LIST'][$document_srl] = $oDocument;
                }

                $output->data[$virtual_number] = $GLOBALS['XE_DOCUMENT_LIST'][$document_srl];
                $virtual_number --;

            }

            if($load_extra_vars) $oDocumentModel->setToAllDocumentExtraVars();

            if(count($output->data)) {
                foreach($output->data as $number => $document) {
                    $output->data[$number] = $GLOBALS['XE_DOCUMENT_LIST'][$document->document_srl];
                }
            }

            return $output;
        }
    }
?>
