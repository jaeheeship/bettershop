<?php

	include "opage_xml_model.php";
	
	//header("Content-Type: text/xml; charset=utf-8");
	
	//http://www.bettershop.co.kr/xe14/opage/opage_json_content.php?document_srl=218

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();
	
	// 받은 인자 설정 , 정리.

	$document_srl = '218';	// 218 = 오이시 초밥
	$document_srl = '203';	// 203 = 로리 파스타
	$document_srl = $_GET['document_srl'];
	
	// 공통 초기화 작업
	
	$oDocumentModel = &getModel('document');
	
	$oDocument = $oDocumentModel->getDocument($document_srl, false, true);
	$document = $oDocument->variables;
	
	
	//기본정보 불러오기
	
	$content['document_srl'] = $document_srl;
	$content['member_srl'] = $oDocument->getMemberSrl();
	$content['regdate'] = $oDocument->getRegdate('Y-m-d');
	$content['title'] = $oDocument->getTitle();
	$content['title_text'] = $oDocument->getTitleText();
	//$content['content'] = $oDocument->getContent();
	//$content['contentText'] = $oDocument->getContentText();
	
	// subTitle 은 확장변수 10번.. 즉 11번째
	
	$query_scrapped = mysql_query("SELECT * FROM xe_member_scrap WHERE document_srl=".$document_srl);
	$scrapped_count = mysql_num_rows($query_scrapped);
	$content['scrapped_count'] = $scrapped_count;
	
	// 확장변수
	$extravars = array();
	$extravars_list = $oDocument->getExtraVars();
	$extravars_count = count($extravars_list);
		
	foreach($extravars_list as $key => $extravar)
	{
		$extravars[$key]['extravar_no'] = $key;
		$extravars[$key]['extravar_type'] = $extravars_list[$key]->type;
		$extravars[$key]['extravar_name'] = $extravars_list[$key]->name;
		$extravars[$key]['extravar_value'] = $oDocument->getExtraValue($key);
		$extravars[$key]['extravar_value_html'] = $oDocument->getExtraValueHTML($key);
		

	}
	// 확장변수에서 불러온 주요정보 정리 (확장변수 인덱스는 변경될 수 있음에 주의)
	$content['subtitle'] = $extravars[15]['extravar_value_html'];	// ""한번 맛보면 빠져나올 수 없는 최고의 초밥!"
	$content['phone'] = $extravars[3]['extravar_value_html'];	//  "가게 전화번호"
	$content['address'] = $extravars[4]['extravar_value_html'];	//  "가게 주소"
	$content['latitude'] = $extravars[5]['extravar_value_html'];	//  "가게 위도"
	$content['longitude'] = $extravars[6]['extravar_value_html'];	//  "가게 경도"
	$content['open'] = $extravars[7]['extravar_value_html'];	//  "가게 영업시간"


	// scrapper 목록 불러오기
	
	// j.kim  2012.10.12
	
	$document_scrap_member_homepage = array('','','','','','');
	$result_query = mysql_query("SELECT member_srl FROM xe_member_scrap WHERE document_srl='".$document_srl."' ORDER BY regdate DESC LIMIT 6");
	$rows = mysql_num_rows($result_query);
	
	for($i=0; $i<$rows; $i++) 
	{ 
		$row=mysql_fetch_array($result_query); 
		$result_query2 = mysql_query("SELECT homepage FROM xe_member WHERE member_srl='".$row["member_srl"]."'");
	  
		if(mysql_num_rows($result_query2)>0)
		{
			$row2 = mysql_fetch_array ($result_query2);
			$document_scrap_member_homepage[$i] = $row2["homepage"];
		}	
		else
		{
			$document_scrap_member_homepage[$i] = '';
		}
		
	}
	  
	$content['scrap_member_homepage0'] = $document_scrap_member_homepage[0];
	$content['scrap_member_homepage1'] = $document_scrap_member_homepage[1];
	$content['scrap_member_homepage2'] = $document_scrap_member_homepage[2];
	$content['scrap_member_homepage3'] = $document_scrap_member_homepage[3];
	$content['scrap_member_homepage4'] = $document_scrap_member_homepage[4];
	$content['scrap_member_homepage5'] = $document_scrap_member_homepage[5];
	
	$result_query = mysql_query("SELECT member_srl FROM xe_member_scrap WHERE document_srl='".$document_srl."' ORDER BY regdate DESC LIMIT 1");
	if(mysql_num_rows($result_query)>0){
		$row = mysql_fetch_array ($result_query);
		$document_last_scrap_member_srl = $row["member_srl"];
	}	
	else
	{
		$document_last_scrap_member_srl = '';
	}
	$content['last_scrap_member_srl'] = $document_last_scrap_member_srl;
	
	$result_query = mysql_query("SELECT user_name,homepage FROM xe_member WHERE member_srl='".$document_last_scrap_member_srl."'");
	if(mysql_num_rows($result_query)>0){
		$row = mysql_fetch_array ($result_query);
		$document_last_scrap_user_name = $row["user_name"];
		$document_last_scrap_homepage = $row["homepage"];
	}	
	else
	{
		$document_last_scrap_user_name = '';
		$document_last_scrap_homepage = '';
	}
	$content['last_scrap_user_name'] = $document_last_scrap_user_name;
	$content['last_scrap_member_homepage'] = $document_last_scrap_homepage;
	

	
	
	// 첨부화일 files 목록 불러오기..
	
	// 화일 목록 처리
	$files = array();
	$uploaded_list = $oDocument->getUploadedFiles();
	$file_count = count($uploaded_list);
	
	foreach($uploaded_list as $key => $file)
	{
		$files[$key]['file_no'] = $key + 1;
		$files[$key]['file_size'] = $file->file_size;
		$files[$key]['file_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/xe14'.substr($file->uploaded_filename, 1);
	}
	if($file_count>0) {
		$content['image_url'] = $files[0]['file_url'];
	}
	else {
		$content['image_url'] = '';
	}
	// 댓글 불러오기..
	$oCommentModel = &getModel('comment');

	$comments = array();
	
	//SELECT * FROM xe_comments ORDER BY last_update DESC LIMIT 0, 50
	////SELECT * FROM xe_comments ORDER BY last_update DESC LIMIT 0, 50
	//$result_query = mysql_query("SELECT comment_srl, module_srl, document_srl, content, user_name, member_srl, last_update FROM xe_comments ORDER BY last_update DESC");
	$result_query = mysql_query("SELECT * FROM xe_comments WHERE document_srl = '".$document_srl."' ORDER BY last_update DESC LIMIT 0, 50");	// 시작위치 0 갯수 50
	// $result_query2 = mysql_query("SELECT shop_name FROM bs_shop_info WHERE document_srl='".$document_srl."'");
	
	$rows = mysql_num_rows($result_query);
	
	
	for($i=0; $i<$rows; $i++) 	// 댓글 내용
	{ 
		$row = mysql_fetch_array($result_query); 

		$comments[$i]['comment_srl'] =  $row['comment_srl'];
		
		$comment_srl = $comments[$i]['comment_srl'];
		
		// comment_srl 로 첨부화일 목록과. 첫번째 화일에 대한 정보 얻어오기.
		//$comment_srl = '2891';
		
		$oComment = $oCommentModel->getComment($comment_srl, false, false);

		//$comments[$i]['getMemberSrl'] = $oComment->getMemberSrl();	// test ok
		
		if($oComment->hasUploadedFiles()){
			$comments[$i]['hasUploadedFiles'] = 'YES';
			$uploaded_list = $oComment->getUploadedFiles();
			$file_count = count($uploaded_list);

			foreach($uploaded_list as $key => $file)
			{
				//$files[$key]['file_no'] = $key + 1;
				//$files[$key]['file_size'] = $file->file_size;
				//$files[$key]['file_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/xe14'.substr($file->uploaded_filename, 1);
				//$comments[$i]['files'][$key]
				
				$comments[$i]['files'][$key]['file_no'] = $key + 1;
				$comments[$i]['files'][$key]['file_size'] = $file->file_size;
				$comments[$i]['files'][$key]['file_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/xe14'.substr($file->uploaded_filename, 1);
				$comments[$i]['files'][$key]['file_path'] = '..'.substr($file->uploaded_filename, 1);
				
				// http://www.bettershop.co.kr/xe14/files/attach/images/149/932/002/de26fb8ae0794c761c615b5d6ca9b64e.jpg
				
				// ../files/attach/images/149/932/002/de26fb8ae0794c761c615b5d6ca9b64e.jpg
			}
			
			// 0 번 화일을 대표 이미지로...
			
			$comments[$i]['image_url'] =  $comments[$i]['files'][0]['file_url'];
			
			// 이미지 너비, 높이 구하기.
			//$image_path = "../files/attach/images/149/932/002/de26fb8ae0794c761c615b5d6ca9b64e.jpg";
			
			$image_path = $comments[$i]['files'][0]['file_path'];
			
			list($width, $height, $type, $attr)= getimagesize($image_path); 
			
			$comments[$i]['height'] =  $height;
			$comments[$i]['width'] = $width;
			
		}
		else {
			$comments[$i]['hasUploadedFiles'] = 'NO';
			
			$comments[$i]['height'] =  25;
			$comments[$i]['width'] = 100;
		}
	
		$comments[$i]['module_srl'] =  $row['module_srl'];
		$comments[$i]['document_srl'] =  $row['document_srl'];	// 게시물.. 어느 가게 인지 정보...
		//$comments[$i]['content'] =  $row['content'];
		$comments[$i]['content'] =  $oComment->getSummary();
		
		$comments[$i]['user_name'] =  $row['user_name'];
		$comments[$i]['member_srl'] =  $row['member_srl'];
		$comments[$i]['last_update'] =  $row['last_update'];
		
		$comments[$i]['hash'] =  "4W0du";
		$comments[$i]['ext'] =  ".gif";
		//$comments[$i]['height'] =  336;
		//$comments[$i]['width'] = 252;
		//$comments[$i]['title'] = $row['content'];
		$comments[$i]['title'] = $oComment->getSummary();
		
		

	}

	// 결과 성공 메시지 설정
	
	$result = 'success';
	$error = 'none';
	$message = '성공하였습니다.';
	$date = date('Y-m-d H:i:s');

	$control = array('result' => $result, 'error' => $error, 'message' => $message, 'date' => $date);
	
	// 데이타 및 최종 결과 구성
	
	//$data = array('content'=> $content, 'extravars' => $extravars, 'comments' => $comments);		// extravars 는 직접 보내지 않고 정리해서 보낸다.
	$data = array('content'=> $content, 'comments' => $comments, 'files' => $files);

	$response = array('control' => $control, 'data' =>  $data);
	
	
	// 실제 출력
	
	header('Content-type: application/json');
	
	echo json_encode($response);

	$oContext->close();


?>
