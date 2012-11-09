<?php

	include "opage_xml_model.php";
	
	//header("Content-Type: text/xml; charset=utf-8");
	
	//http://www.bettershop.co.kr/xe14/opage/opage_json_comments.php

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();
	
	$oCommentModel = &getModel('comment');

	
	$comments = array();
	
	
	//SELECT * FROM xe_comments ORDER BY last_update DESC LIMIT 0, 50
	////SELECT * FROM xe_comments ORDER BY last_update DESC LIMIT 0, 50
	//$result_query = mysql_query("SELECT comment_srl, module_srl, document_srl, content, user_name, member_srl, last_update FROM xe_comments ORDER BY last_update DESC");
	$result_query = mysql_query("SELECT * FROM xe_comments ORDER BY last_update DESC LIMIT 0, 50");	// 시작위치 0 갯수 50
	
	
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

	$result = 'success';
	$error = 'none';
	$message = '성공하였습니다.';
	$date = date('Y-m-d H:i:s');

	$control = array('result' => $result, 'error' => $error, 'message' => $message, 'date' => $date);
	
	$data = array('comments' => $comments );

	$response = array('control' => $control, 'data' =>  $data);
	
	header('Content-type: application/json');
	
	echo json_encode($response);

	$oContext->close();


?>
