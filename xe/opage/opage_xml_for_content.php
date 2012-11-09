<?PHP
	header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	$oDocumentModel = &getModel('document');
	$oModuleModel = &getModel('module');
	$oAroundmapControl = &getController('aroundmap');
	$logged_info = Context::get('logged_info');

	$is_xml = true;
	$get_mid = '';
	$thumbnail_width = '160';
	$thumbnail_height = '120';
	$thumbnail_type = 'crop';
	$title_cut_size = '';

	if($_GET['document_srl'] && ctype_digit($_GET['document_srl']))
	{
		$args->document_srl = $_GET['document_srl'];
	}

	$args->member_srl = $logged_info->member_srl;

/*
	if($_GET['mid'] == 'foryou')
	{
		$args->module_srl = '100';
		$get_mid = 'foryou';
	}
	elseif($_GET['mid'] == 'forme')
	{
		$args->module_srl = '163';
		$get_mid = 'forme';
	}
	else
	{
		$args->module_srl[0] = '100';
		$args->module_srl[1] = '163';
	}

	if($_GET['page'] > 0 && ctype_digit($_GET['page']))
	{
		$args->page = $_GET['page'];
	}
	else
	{
		$args->page = '1';
	}
*/

	$oDocument = $oDocumentModel->getDocument($args->document_srl, false, true);

	$document = $oDocument->variables;

//print_r($oDocument);

	$xml_item = '';

	if(!$oDocument->isNotice() && !$oDocument->isSecret())
	{
		include "opage_xml_model.php";

		$xml_data = '';

		// 로그인한 사용자의 해당 스티커 지원 여부 확인
		$output_is_voted = getIsVotedDocument($args);

		if($output_is_voted == 0)
		{
			$is_voted = 0;
			$voted_url = 'http://'.$_SERVER['HTTP_HOST'].'/opage/opage_xml_controller.php?document_srl='.$args->document_srl.'&act=procDocumentVoteUp';
		}
		elseif($output_is_voted > 0)
		{
			$is_voted = 1;
			$voted_url = 'http://'.$_SERVER['HTTP_HOST'].'/opage/opage_xml_controller.php?document_srl='.$args->document_srl.'&act=procDocumentVoteUpCancel';
		}

		// 로그인한 사용자의 해당 스티커 찜 여부 확인
		$output_is_scrapped = getIsScrappedDocument($args);

		if($output_is_scrapped == 0)
		{
			$is_scrapped = 0;
			$scrapped_url = 'http://'.$_SERVER['HTTP_HOST'].'/opage/opage_xml_controller.php?document_srl='.$args->document_srl.'&act=procMemberScrapDocument';
		}
		elseif($output_is_scrapped > 0)
		{
			$is_scrapped = 1;
			$scrapped_url = 'http://'.$_SERVER['HTTP_HOST'].'/opage/opage_xml_controller.php?document_srl='.$args->document_srl.'&act=procMemberScrapDocument';
		}




		$start_date = $oDocument->getRegdate('Y-m-d');
		$end_date   = $oDocument->getUpdate('Y-m-d');
		$now_date   = date("Y-m-d");
		$remain_day  = round((strtotime($end_date) - strtotime($now_date)) / (60*60*24));

		// 조회 여부 확인
		if($_SESSION['readed_document'][$args->document_srl])
		{
			$document_readed_plus = 0;
		}
		else
		{
			$document_readed_plus = 1;
		}

		// 조회수 증가
		if(!$oDocument->isSecret() || $oDocument->isGranted()) $oDocument->updateReadedCount();

		$readed_count = $oDocument->get('readed_count');
		$voted_count = $oDocument->get('voted_count');


		$uploaded_list = $oDocument->getUploadedFiles();
		$file_count = count($uploaded_list);
//print_r($uploaded_list);

		foreach($uploaded_list as $key => $file)
		{
			$files[$key]['file_no'] = $key + 1;
			$files[$key]['file_size'] = $file->file_size;
			$files[$key]['file_url'] = 'http://'.$_SERVER['HTTP_HOST'].substr($file->uploaded_filename, 1);
		}

		$comment_count = $oDocument->getCommentCount();
		$comment_list = $oDocument->getComments();
//print_r($comment_list);

		$comment_no = 0;
		foreach($comment_list as $key => $comment)
		{
			$comments[$key]['comment_no'] = ++$comment_no;
			$comments[$key]['comment_srl'] = $comment->get('comment_srl');
			$comments[$key]['comment_parent_srl'] = $comment->get('parent_srl');
			$comments[$key]['comment_depth'] = $comment->get('depth');
			$comments[$key]['comment_content'] = $comment->getContent(false, false, false);
			$comments[$key]['comment_member_srl'] = $comment->getMemberSrl();
			$comments[$key]['comment_nick_name'] = $comment->getNickName();
			$comments[$key]['comment_regdate'] = $comment->getRegdate("Y.m.d");
		}

		$module_output = $oModuleModel->getModuleInfoByModuleSrl($oDocument->get('module_srl'));
		$document_mid = $module_output->mid;

		$map_output = $oAroundmapControl->setAroundmapValues($args->document_srl);

		$query_scrapped = mysql_query("SELECT * FROM xe_member_scrap WHERE document_srl=".$args->document_srl);
		$scrapped_count = mysql_num_rows($query_scrapped);

		if($readed_count < 1)
		{
			$readed_count = '0';
		}

		if($scrapped_count < 1)
		{
			$scrapped_count = '0';
		}

		if($voted_count < 1)
		{
			$voted_count = '0';
		}



/*
		$document_thumbnail = $oDocument->getThumbnail($thumbnail_width, $thumbnail_height, $thumbnail_type, $is_xml);

		if(!$document_thumbnail)
		{
			$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].'/images/none_thumb.png';
		}
*/

		if($oDocument->hasUploadedFiles())
		{
			$uploaded_list = $oDocument->getUploadedFiles();

			$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].substr($uploaded_list[0]->uploaded_filename, 1);
		}
		else
		{
			$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].'/images/default/none_thumb_l.png';
		}



		$result['result'] = 'success';
		$result['message'] = 'ok';

		$result['login_member_srl'] = $logged_info->member_srl;
		$result['login_user_id'] = $logged_info->user_id;
		$result['login_nick_name'] = $logged_info->nick_name;

		$result['document_srl'] = $args->document_srl;
		$result['document_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.'mid='.$document_mid.'&'.'document_srl='.$args->document_srl;

		$result['document_module_srl'] = $oDocument->get('module_srl');
		$result['document_mid'] = $document_mid;

		$result['document_member_srl'] = $oDocument->getMemberSrl();
		$result['document_nick_name'] = $oDocument->getNickName();

		$result['document_thumbnail'] = $document_thumbnail;

		$result['document_price'] = $oDocument->getExtraEidValue('price');
		$result['document_title'] = $oDocument->getTitle($title_cut_size);

		$result['document_regdate'] = $start_date;		// 시작 날짜
		$result['document_last_update'] = $end_date;		// 종료 날짜
		$result['document_remain_day'] = $remain_day;		// 남은 일 수

		$result['document_ext_val_sticker'] = $oDocument->getExtraEidValue('sticker');		// 1. 배경색 선택
		$result['document_ext_val_icon'] = $oDocument->getExtraEidValue('icon');		// 2. 아이콘 선택
		$result['document_ext_val_price'] = $oDocument->getExtraEidValue('price');		// 3. 가격
		$result['document_ext_val_hopedate'] = $oDocument->getExtraEidValue('hopedate');		// 4. 희망 날짜
		$result['document_ext_val_address'] = $oDocument->getExtraEidValue('address');		// 5. 주소
		$result['document_ext_val_sticker_cash'] = $oDocument->getExtraEidValue('sticker_cash');		// 6. 배경색 캐시
		$result['document_ext_val_icon_cash'] = $oDocument->getExtraEidValue('icon_cash');		// 7. 아이콘 캐시
		$result['document_ext_val_summary'] = $oDocument->getExtraEidValue('summary');		// 8. 설명
		$result['document_ext_val_term'] = $oDocument->getExtraEidValue('term');		// 9. 지속기간
		$result['document_ext_val_value'] = $oDocument->getExtraEidValue('value');		// 10. 가치
		$result['document_ext_val_cash'] = $oDocument->getExtraEidValue('cash');		// 11. 총소모 캐시
		$result['document_ext_val_hope'] = $oDocument->getExtraEidValue('hope');		// 12. 상세조건
		$result['document_ext_val_start'] = $oDocument->getExtraEidValue('start');		// 13. 스티커 시작일

		$result['document_readed_plus'] = $document_readed_plus;
		$result['document_readed_count'] = $readed_count;
		$result['document_scrapped_count'] = $scrapped_count;
		$result['document_voted_count'] = $voted_count;

		$result['document_map_x'] = $map_output->data->lat;
		$result['document_map_y'] = $map_output->data->lon;

		$result['document_file_count'] = $file_count;
		$result['document_comment_count'] = $comment_count;

		$result['document_is_voted'] = $is_voted;
		$result['document_is_scrapped'] = $is_scrapped;

		$result['document_voted_url'] = $voted_url;
		$result['document_scrapped_url'] = $scrapped_url;
		
		// j.kim 2012/04/02
		
		//$logged_info->member_srl
		//$oDocument = $oDocumentModel->getDocument($args->document_srl, false, true);
		//$document = $oDocument->variables;
		// if(!$oDocument->isSecret() || $oDocument->isGranted())
		
		//if($oDocument->isGranted()) {
		// $result['document_member_srl'] = $oDocument->getMemberSrl();
		if($logged_info->member_srl == $oDocument->getMemberSrl()) {
		
			$document_srl = $args->document_srl;	
			$result_query = mysql_query("SELECT document_srl FROM xe_document_voted_log WHERE document_srl='".$document_srl."'");
			$vote_result_cnt = mysql_num_rows($result_query);
		
			$result_query = mysql_query("SELECT document_srl FROM xe_member_scrap WHERE document_srl='".$document_srl."'");
			$scrap_result_cnt = mysql_num_rows($result_query);
			
			$total_result_count = $vote_result_cnt + $scrap_result_cnt;
			
			if($total_result_count > 0){
				$result['document_is_editable'] = 'no'; // yes or no		
			}
			else{
				$result['document_is_editable'] = 'yes'; // yes or no
			}
		
		}
		else {
			$result['document_is_editable'] = 'no'; // yes or no
		}
		
		/*
		$document_srl = $args->document_srl;	
		$result_query = mysql_query("SELECT document_srl FROM xe_document_voted_log WHERE document_srl='".$document_srl."'");
		$vote_result_cnt = mysql_num_rows($result_query);
	
		$result_query = mysql_query("SELECT document_srl FROM xe_member_scrap WHERE document_srl='".$document_srl."'");
		$scrap_result_cnt = mysql_num_rows($result_query);
		
		$total_result_count = $vote_result_cnt + $scrap_result_cnt;
		
		if($total_result_count > 0){
			$result['document_is_editable'] = 'no'; // yes or no		
		}
		else{
			$result['document_is_editable'] = 'yes'; // yes or no
		}
		
		*/
/*
print "01 : ".$oDocument->getExtraEidValue('sticker')."<br>";
print "02 : ".$oDocument->getExtraEidValue('icon')."<br>";
print "03 : ".$oDocument->getExtraEidValue('price')."<br>";
print "04 : ".$oDocument->getExtraEidValue('hopedate')."<br>";
print "05 : ".$oDocument->getExtraEidValue('address')."<br>";
print "06 : ".$oDocument->getExtraEidValue('sticker_cash')."<br>";
print "07 : ".$oDocument->getExtraEidValue('icon_cash')."<br>";
print "08 : ".$oDocument->getExtraEidValue('summary')."<br>";
print "09 : ".$oDocument->getExtraEidValue('term')."<br>";
print "10 : ".$oDocument->getExtraEidValue('value')."<br>";
print "11 : ".$oDocument->getExtraEidValue('cash')."<br>";
print "12 : ".$oDocument->getExtraEidValue('hope')."<br>";
print "13 : ".$oDocument->getExtraEidValue('start')."<br>";
*/


/*
		$result['document_'] = '';
		$result['document_'] = '';
		$result['document_'] = '';
		$result[''] = '';
		$result[''] = '';
*/


		foreach($result as $key => $val)
		{
			if(!$val)
			{
				$val = '';
			}

//print $key." : ".$val."<br>";

			$xml_data = $xml_data.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
		}

		// 파일 목록
		$xml_files = '';
		foreach($files as $idx)
		{
			$xml_files = $xml_files.'<file>';

			foreach($idx as $key => $val)
			{
				if(!$val)
				{
					$val = '';
				}

//print $key." : ".$val."<br>";

				$xml_files = $xml_files.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
			}

			$xml_files = $xml_files.'</file>';
		}

		$xml_files = '
		<files>
			'.$xml_files.'
		</files>';

		// 댓글 목록
		$xml_comments = '';
		foreach($comments as $idx)
		{
			$xml_comments = $xml_comments.'<comment>';

			foreach($idx as $key => $val)
			{
				if(!$val)
				{
					$val = '';
				}

//print $key." : ".$val."<br>";

				$xml_comments = $xml_comments.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
			}

			$xml_comments = $xml_comments.'</comment>';
		}

		$xml_comments = '
		<comments>
			'.$xml_comments.'
		</comments>';



		$xml_item = $xml_item.'
	<item>
		'.$xml_data.$xml_files.$xml_comments.'
		<document_end><![CDATA[]]></document_end>
	</item>';

	}

	$xml_items = '';

	foreach($items as $key => $val)
	{
		if(!$val)
		{
			$val = '';
		}

		$xml_items = $xml_items.'		<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
	}

	$xml_items = $xml_items.$xml_item;

	$xmls = '
	<items>
'.$xml_items.'
	</items>';



	echo '<?xml version="1.0" encoding="utf-8"?>';

	echo $xmls;

	$oContext->close();
?>
