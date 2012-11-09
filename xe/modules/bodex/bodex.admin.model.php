<?php
    /**
     * @class  bodexAdminModel
     **/

    class bodexAdminModel extends bodex {

        /**
         * @brief 기본 목록 설정값을 return
         **/
        function getDefaultListConfig($module_srl) {
            // 가상번호, 제목, 등록일, 수정일, 닉네임, 아이디, 이름, 조회수, 추천수 추가
            $virtual_vars = array('no', 'category', 'title', 'regdate', 'last_update', 'last_updater', 'nick_name', 'user_id', 'user_name', 'email_address', 'homepage', 'ipaddress', 'readed_count', 'voted_count','blamed_count','reward_point','doc_state','thumbnail','summary');
            foreach($virtual_vars as $key) {
                $extra_vars[$key] = new ExtraItem($module_srl, -1, Context::getLang($key), $key, 'N', 'N', 'N', null);
            }

            $oDocumentModel = &getModel('document');
            $inserted_extra_vars = $oDocumentModel->getExtraKeys($module_srl);

            if(count($inserted_extra_vars)) foreach($inserted_extra_vars as $obj) $extra_vars['extra_vars'.$obj->idx] = $obj;

            return $extra_vars;
        }

        /**
         * @brief 기본 검색 설정값을 return
         **/
        function getDefaultSearchConfig($module_srl) {
            // 검색 항목
            $virtual_vars = array('title','content','title_content','user_id','user_name','nick_name','email_address','homepage','ipaddress','comment','tag','regdate','last_update','doc_state');

            // 목록이 노출될때 같이 나오는 검색 옵션을 정리하여 스킨에서 쓸 수 있도록 context set (확장변수에서 검색 선택된 항목이 있으면 역시 추가)
            // 템플릿에서 사용할 검색옵션 세팅 (검색옵션 key값은 미리 선언되어 있는데 이에 대한 언어별 변경을 함)
            foreach($virtual_vars as $key) {
                $search_option[$key] = Context::getLang($key);
            }

            $oDocumentModel = &getModel('document');
            $inserted_extra_vars = $oDocumentModel->getExtraKeys($module_srl);

            if(count($inserted_extra_vars))
                foreach($inserted_extra_vars as $key => $val){
                    if($val->search == 'Y') $search_option['extra_vars'.$val->idx] = $val->name;
                }

            return $search_option;
        }

    }
?>
