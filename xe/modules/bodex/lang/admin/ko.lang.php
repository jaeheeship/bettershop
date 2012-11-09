<?php
    /**
     * @file   ko.lang.php
     * @brief  게시판 EX (bodex) 관리자 모듈의 기본 언어팩
     **/
    $lang->cmd_view_filelist = '첨부된 파일 목록 보기';
    $lang->use_doc_state_default_value = '대기,검토,완료,보류';


    $lang->best = '베스트';
    $lang->recent = '최근';
    $lang->download = '다운로드';
    $lang->blind = '블라인드';

    $lang->declared_count = '신고된 횟수';
    $lang->about_new_download = '(포인트 사용 방식이 다운로드이면 기록됩니다)';

    $lang->search_display_item = '검색 항목';
    $lang->list_target_item = '대상 항목';
    $lang->list_display_item = '표시 항목';
    $lang->list_sort_item = '정렬 사용';
    $lang->date_range = '날짜범위';
    $lang->except_notice = '공지 제외';
    $lang->consultation = '상담 기능';
    $lang->admin_mail = '관리자 메일';
    $lang->auto_reply = '자동 댓글';
    $lang->anonymous_phase = '익명 단계';
    $lang->notify_message_type = '알림 방법';
    $lang->use_load_extra_vars = '다국어 지원';

    $lang->cmd_bodex_content = '초기 페이지';
    $lang->cmd_bodex_list = '게시판 목록';
    $lang->cmd_Insert_bodex = '게시판 생성';
    $lang->cmd_view_info = '게시판 정보';
    $lang->cmd_list_setting = '목록 설정';
    $lang->cmd_search_setting = '검색 설정';
    $lang->cmd_recount_voted = '추천 수 새로 갱신';

    $lang->send_notify = '쪽지 보내기';
    $lang->send_mail = '메일 보내기';

    $lang->use_none = '사용안함';
    $lang->use_yes = '선택사용';
    $lang->use_require = '필수사용';

    $lang->use_cat_comb = '콤보박스';
    $lang->use_cat_tab = '탭페이지';
    $lang->use_cat_left = '좌측메뉴';
    $lang->use_cat_right = '우측메뉴';

    $lang->use_vote = '추천 사용';
    $lang->use_vote_bonus = '추천/비추천 받으면 위의 점수만큼 포인트 보너스 받기 (별점시, 추천점수 * 별점수)';
    $lang->use_vote_empty = '추천/비추천 점수를 삭제(초기화) 가능하도록 허용 하기';
    $lang->use_vote_not_checkip = '추천/비추천시 IP 체크를 하지 않기 (사설 네트워크 처럼 같은 IP를 사용해야하는 환경에 사용)';

    $lang->use_doc_state ='상태 기능';
    $lang->use_reward = '포인트 사용';
    $lang->use_secret = '비밀글 기능';
    $lang->use_anonymous = '익명 사용';

    $lang->use_down_point_images = '이미지 파일에도 포인트 적용';
    $lang->use_down_point_medias = '미디어 파일에도 포인트 적용';
    $lang->use_down_point_always = '파일별로 매번 적용';

    $lang->use_allow = '허용';
    $lang->use_allow_none = '허용안함';
    $lang->use_allow_require = '항상허용';
    $lang->use_allow_yes = '선택허용';

    $lang->use_ex_search = '상세 검색 사용';

    $lang->display_extra_images = '아이콘 표시';

    // 메세지에 사용되는 언어

    $lang->confirm_recount_voted = "데이터량에 따라 다소 시간이 걸릴 수 있습니다.\n추천 수 갱신을 계속하시겠습니까?";
    $lang->msg_not_skin_info = "스킨 정보를 읽어올 수 없습니다.\n게시판 정보의 스킨 선택을 확인해 주세요.";

    // 주절 주절..
    $lang->about_bodex = '게시판을 생성하고 관리할 수 있는 모듈입니다. 세부 옵션 수정은 게시판 목록에서 해당 게시판의 설정 버튼을 눌러 주세요.';
    $lang->about_except_notice = '목록 상단에 늘 나타나는 공지사항을 하단의 일반 목록에선 출력하지 않도록 제외시킵니다.';
    $lang->about_use_anonymous = '글쓴이의 정보를 없애고 익명으로 게시판 사용을 할 수 있게 합니다.';
    $lang->about_consultation = '상담 기능은 관리 권한이 없는 회원은 자신이 쓴 글만 보이도록 하는 기능입니다.<br />회원만 글쓰기가 허용되며 익명 기능 사용시 보안 단계는 1단계로 조정됩니다.';
    $lang->about_secret = '게시판 및 댓글에 비밀글을 사용할 수 있도록 합니다. 필수일 경우 해당글은 자동으로 비밀글이 됩니다.';
    $lang->about_admin_mail = '글이나 댓글이 등록될때 메일주소로 메일이 발송됩니다.<br />,(콤마)로 연결시 다수의 메일주소로 발송할 수 있습니다. (보낸이와 받는이가 같을 경우엔 제외됩니다.)';
    $lang->about_search_setting = '게시판의 검색을 원하는 항목들을 설정할 수 있습니다. (확장변수 검색은 확장변수의 검색 항목을 선택하셔야 보입니다)';
    $lang->about_list_config = '게시판의 목록을 원하는 항목들로 배치를 할 수 있습니다. (항목을 더블 클릭하면 추가/제거가 됩니다)';
    $lang->about_use_category = '분류의 스타일을 콤보박스, 탭페이지, 좌측메뉴, 우측메뉴 형태로 지정할 수 있습니다.';
    $lang->about_use_vote = '추천을 하는 방법을 지정할 수 있습니다.  (단, 비회원은 투표에서 제외)<br /><br /><span style="color:red">추천 수 새로 갱신</span>: 추천 형태가 바뀌었을때 현 상태에 맞게 수를 갱신합니다.<br />* 주의 * 추천 수 새로 갱신은 디비의 값을 직접 수정하는 것이므로 안전을 위해서 백업후 실행 하세요.';
    $lang->about_use_doc_state_value = '사용할 수 있는 상태 값의 목록을 지정할 수 있습니다. (HTML 태그 사용 가능)<br />복수 등록은 ,(콤마) 로 구분합니다. (최대 10개 사용 가능 ex: 대기,검토,완료,보류)';
    $lang->about_use_doc_state = '문서의 상태를 설정하고 보여줍니다. (목록에서  현재 상태를 보려면 목록설정에서 상태를 사용해주세요.)';
    $lang->about_auto_reply = '새로운 글이 등록되면 그 글에 자동으로 해당 내용의 댓글을 입력합니다. (HTML 태그 사용 가능)';
    $lang->about_notify_message_type = '새로운 글이나 댓글이 등록될때 상위 문서에 알림 기능이 있다면 알려줄 알림 방법을 지정할 수 있습니다.';
    $lang->about_module_text = '해당 게시판 모듈의 상, 하단에 출력될 내용을 지정할 수 있습니다.';
    $lang->about_constraint_document = '문서의 일부만 보여주고 댓글을 입력하거나 포인트를 지불해야 보여줄지 선택할 수 있습니다.';
    $lang->about_constraint_download = '첨부파일을 다운로드할 때 댓글을 입력하거나 포인트를 지불해야 할 수 있게 선택할 수 있습니다.';
    $lang->about_allow_comment = '게시판에 댓글 또는 엮인글을 허용할지 선택할 수 있습니다.';
    $lang->about_use_anonymous_phase = '익명 사용시 보안을 어느 정도로 할지 설정할 수 있습니다.<br /><br />1. 가장 낮은 단계로 관리자에겐 회원 정보가 보입니다. (상담 게시판에서도 보입니다)<br />2. 기본적인 단계로 모든 회원 정보를 감추지만 최고 관리자는 디비를 분석해 알수있는 방법이 있습니다.<br />3. 최고 단계로 회원 정보를 그 누구도 알수없고 로그아웃 후엔 글 작성자도 수정/삭제가 불가능합니다.';
    $lang->about_category_list = '그룹 제한을 사용한 분류의 글은 해당 그룹만 쓰기가 가능합니다.';
    $lang->about_extra_vars = '검색을 체크하시면 검색설정을 통해 검색이 가능해 집니다.';
    $lang->about_order_target = '목록의 기본 정렬 항목과 정렬 방식을 지정합니다.<br />랜덤을 선택하시면 항상 무작위로 출력합니다.';
    $lang->about_best_document = '선택한 옵션에 해당하는 글을 상단에 올려 여러 사람이 볼 수 있게 합니다. (댓글의 정렬 대상은 추천 수로 고정)';
    $lang->about_load_extra_vars = '문서의 다국어를 지원합니다. (언어 설정에 따라 저장된 내용을 따로 출력)<br />다국어 지원이 필요하지 않을 경우 사용 안함으로 설정시 사이트의 과부하를 조금 줄일 수 있습니다.';
    $lang->about_display_extra_images = '목록의 제목 옆에 출력되는 아이콘들을 지정할 수 있습니다.';
    $lang->about_declare_blind = '신고 수가 정해진 수 이상이면 해당 문서가 블라인드 처리됩니다. (0 또는 비워두면 사용안함)';
    $lang->about_point_download = '첨부파일을 다운받는 맴버가 배팅된 포인트의 50%만큼 파일 소유자에게 지불하도록 합니다.<br />옵션 "<B>포인트 사용</B>" 항목의 설정값을 조정해 주세요. (기본 포인트 설정값과 중복됩니다)';
    $lang->about_point_view = '문서를 열람하는 맴버가 배팅된 포인트의 50%만큼 문서 소유자에게 지불하도록 합니다.<br />옵션 "<B>포인트 사용</B>" 을 선택하시고 항목의 설정값을 조정해 주세요.';
    $lang->about_use_reward_value = '사용할 수 있는 포인트 값의 목록을 지정할 수 있습니다. (ex: 20,40,60,80,100)';
    $lang->about_use_reward = '<B>문서 제한 옵션 사용시:</B> 문서를 열람할때 50%만큼 문서 소유자에게 지불하도록 합니다.<br /><B>다운로드 제한 옵션 사용시:</B> 다운로드할 때 50%만큼 파일 소유자에게 지불하도록 합니다.<br /><B>그외 사용시:</B> 글쓴이가 답변을 채택하면 채택된 멤버에게 50%, 글쓴이에게 다시 50%의 포인트가 돌아갑니다.';
    $lang->about_use_ex_search = '원하는 여러 확장변수를 묶어 검색 가능하게 도와줍니다.<br />검색 설정에서 원하는 확장변수를 검색 항목에 등록한 후 사용하세요.';

    // 모바일
    $lang->use_mobile = '모바일 뷰 사용';
    $lang->use_mobile_express = '모바일 표시';
    $lang->mobile_skin = '모바일 스킨';
    $lang->about_use_mobile = '스마트폰 등을 이용하여 접속할 때 모바일 화면에 최적화된 레이아웃을 이용하도록 합니다.<br />모바일 표시: 모바일 화면에서 작성된글은 아이콘으로 표시해 보여줍니다.';
    $lang->use_mobile_doc_navigation = '이전/다음 출력';
    $lang->about_use_mobile_doc_navigation = '모바일 레이아웃 사용시 본문 하단에 이전/다음 페이지를 출력할지 설정할 수 있습니다.';

?>
