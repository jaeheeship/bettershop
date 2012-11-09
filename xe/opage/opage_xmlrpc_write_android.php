<?php

	header("Content-Type: text/xml; charset=utf-8");
	
    //if(!defined("__ZBXE__")) exit();
    define('__ZBXE__', true);
    
    require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	// act가 api가 아니면 그냥 리턴~
    //if($_REQUEST['act']!='api') return;

    // 관련 func 파일 읽음
    //require_once('./addons/blogapi/blogapi.func.php');
	//require_once('blogapi.func.php');
	include "blogapi.func.php";
	
	//$oXmlParser = new XmlParser();
	
    // xmlprc 파싱
    // 요청된 xmlrpc를 파싱
    $oXmlParser = new XmlParser();
    $xmlDoc = $oXmlParser->parse();

    $method_name = $xmlDoc->methodcall->methodname->body;
    $params = $xmlDoc->methodcall->params->param;
    if($params && !is_array($params)) $params = array($params);


	switch($method_name) {


		case 'bettershop.newComment' :
		
		// 받은 인자 정리
		
		$access_id = trim($params[0]->value->string->body);
		$member_srl = trim($params[1]->value->string->body);
		$user_id = trim($params[2]->value->string->body);
		$password = trim($params[3]->value->string->body);
		$document_srl = trim($params[4]->value->string->body);
		$content = trim($params[5]->value->string->body);
		$shop_code = trim($params[6]->value->string->body);
		$type = trim($params[7]->value->string->body);
		$facebook = trim($params[8]->value->string->body);
		$twitter = trim($params[9]->value->string->body);
		$fileinfo = $params[10]->value->struct->member;	// dictionary
		
		$time = date('Y-m-d H:i:s'); // 서버 시간
		
		$module_srl= '149';
		
		// 임시 파일 저장 장소 지정
		$tmp_uploaded_path = sprintf('./files/cache/blogapi/%s/%s/', $document_srl, $member_srl);
		$uploaded_target_path = sprintf('/files/cache/blogapi/%s/%s/', $document_srl, $member_srl);
		
		
		// 강제 로그인			
						
		$oMemberController = &getController('member');
		
		//$user_id2 = '371619526';
		//$password2 = '371619526';
		
		$output2 = $oMemberController->doLogin($user_id, $password);
		
		if($output2->toBool()) {	// 로그인 성공했을때. 로그인하는 이유는 XE의 함수를 사용해야 하므로
			$login_error = 'none';
			
			
			// 화일 쓰기
			//$param[10] = imageDic
	
			$oFileModel = &getModel('file');
			
			//$fileinfo = $params[10]->value->struct->member;	// dictionary
			foreach($fileinfo as $key => $val) {
				$nodename = $val->name->body;
				if($nodename == 'bits') $filedata = base64_decode($val->value->string->body);
				elseif($nodename == 'name') $filename = $val->value->string->body;
			}
	
			$tmp_arr = explode('/',$filename);
			$filename = array_pop($tmp_arr);
	
			if(!is_dir($tmp_uploaded_path)) FileHandler::makeDir($tmp_uploaded_path);
	
			$target_filename = sprintf('%s%s', $tmp_uploaded_path, $filename);
			FileHandler::writeFile($target_filename, $filedata);
			
			// 글쓰기
			
			// 화일 카운트 구하기
			
			$file_list = FileHandler::readDir($tmp_uploaded_path);
			$file_count = count($file_list);
			
			// 댓글쓰기
			
			$arg->module_srl = $module_srl;		// 게시판 모듈
			$arg->document_srl = $document_srl;	// 대상 글
			$arg->content = $content; 			// 내용
			$arg->uploaded_count = $file_count;
			
			$oCommentController = &getController('comment');
			$output = $oCommentController->insertComment($arg);
			
			// 화일 추가하기
			
			if(strcmp($output->message,'success') == 0){ // 성공했을때
	
				$comment_srl = $output->get('comment_srl');
		
				// 게시물에 첨부화일 추가
				$return_count = 0;
				if($file_count) {
					$oFileController = &getController('file');
					for($i=0;$i<$file_count;$i++) {
						$file_info['tmp_name'] = sprintf('%s%s', $tmp_uploaded_path, $file_list[$i]);
						$file_info['name'] = $file_list[$i];
	
						$return_value = $oFileController->insertFileBS2($file_info, $module_srl, $comment_srl, 0, true, $member_srl);
						if($return_value) $return_count += 1;
	
					}
	
				}
				// bs_review_log에 기록
				
				$sql0 = 
				"
				INSERT INTO `bs_review_log` (`time`, `type`, `member_srl`, `shop_code`, `comment_srl`, `facebook`, `twitter`) VALUES
				('$time', '$type', '$member_srl', '$shop_code', '$comment_srl', '$facebook', '$twitter');
				";
				
				$query_result0 = mysql_query($sql0);
				
				if(query_result0){ // 성공
					$result['result'] = 'success';
					$result['error'] = 'none';
					$result['message'] = 'review log 등록이 성공했습니다.';
				}
				else { 				// 실패
					$result['result'] = 'error';
					$result['error'] = 'comment_log_failed';
					$result['message'] = 'review log 등록이 실패했습니다.';
				}

			}
			else {
			
				// 댓글 등록 실패
				$result['result'] = 'error';
				$result['error'] = 'comment_failed';
				$result['message'] = 'exception!('.$output->message.')';
			
			}
			
			// 임시 화일 정리
			
			// 잘끝났으면 또는 실패 했을 경우에도 임시화일들 지워준다.
			if($file_count >= $return_count){
				FileHandler::removeDir($tmp_uploaded_path);
			}
			else {
				FileHandler::removeDir($tmp_uploaded_path);
			}
				
		}
		else{
			$login_error = 'login_error';
			
			$result['result'] = 'error';
			$result['error'] = 'login failed';
			$result['message'] = '인증에 실패하였습니다.';	
			
		}



	   
			break;
			
		// 좋은가게 bettershop.newCommentNoImage	
		case 'bettershop.newCommentNoImage' :
		
				// 받은 인자 정리
		
		$access_id = trim($params[0]->value->string->body);
		$member_srl = trim($params[1]->value->string->body);
		$user_id = trim($params[2]->value->string->body);
		$password = trim($params[3]->value->string->body);
		$document_srl = trim($params[4]->value->string->body);
		$content = trim($params[5]->value->string->body);
		$shop_code = trim($params[6]->value->string->body);
		$type = trim($params[7]->value->string->body);
		$facebook = trim($params[8]->value->string->body);
		$twitter = trim($params[9]->value->string->body);
		//$fileinfo = $params[10]->value->struct->member;	// dictionary
		
		$time = date('Y-m-d H:i:s'); // 서버 시간
		
		$module_srl= '149';
		
		// 임시 파일 저장 장소 지정
		
		// 강제 로그인			
						
		$oMemberController = &getController('member');
		
		//$user_id2 = '371619526';
		//$password2 = '371619526';
		
		$output2 = $oMemberController->doLogin($user_id, $password);
		
		if($output2->toBool()) {	// 로그인 성공했을때. 로그인하는 이유는 XE의 함수를 사용해야 하므로
			$login_error = 'none';
			
			
			// 화일 쓰기
			
			
			// 글쓰기
			

			
			// 댓글쓰기
			
			$arg->module_srl = $module_srl;		// 게시판 모듈
			$arg->document_srl = $document_srl;	// 대상 글
			$arg->content = $content; 			// 내용
			$arg->uploaded_count = $file_count;
			
			$oCommentController = &getController('comment');
			$output = $oCommentController->insertComment($arg);
			
			// 화일 추가하기
			
			if(strcmp($output->message,'success') == 0){ // 성공했을때
	
				$comment_srl = $output->get('comment_srl');
		
				
				// bs_review_log에 기록
				
				$sql0 = 
				"
				INSERT INTO `bs_review_log` (`time`, `type`, `member_srl`, `shop_code`, `comment_srl`, `facebook`, `twitter`) VALUES
				('$time', '$type', '$member_srl', '$shop_code', '$comment_srl', '$facebook', '$twitter');
				";
				
				$query_result0 = mysql_query($sql0);
				
				if(query_result0){ // 성공
					$result['result'] = 'success';
					$result['error'] = 'none';
					$result['message'] = 'review log 등록이 성공했습니다.';
				}
				else { 				// 실패
					$result['result'] = 'error';
					$result['error'] = 'comment_log_failed';
					$result['message'] = 'review log 등록이 실패했습니다.';
				}

			}
			else {
			
				// 댓글 등록 실패
				$result['result'] = 'error';
				$result['error'] = 'comment_failed';
				$result['message'] = 'exception!('.$output->message.')';
			
			}
			
			// 임시 화일 정리
	
		}
		else{
			$login_error = 'login_error';
			
			$result['result'] = 'error';
			$result['error'] = 'login failed';
			$result['message'] = '인증에 실패하였습니다.';	
			
		}

			break;
			

		// 아무런 요청이 없을 경우 RSD 출력
		default :
		
			$result['result'] = 'error';
			$result['error'] = 'no request';
			$result['message'] = '요청이 없습니다.';

			break;
	}

    
    	///////////// 결과 출력
    	
    	/*
		foreach($result as $key => $val)
		{
			$xml_data = $xml_data.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
		}
	
		$xmls = '
		<items>
			<item>
				'.$xml_data.'
			</item>
		</items>';
		*/
		
		if(strcmp($result['result'],'success') == 0){
	
		$xmls = '
				<methodResponse>
				   <fault>
					  <value>
						 <struct>
							<member>
							   <name>faultCode</name>
							   <value><int>0</int></value>
							   </member>
							<member>
							   <name>faultString</name>
							   <value><string>success</string></value>
							   </member>
							</struct>
					  </value>
				   </fault>
				</methodResponse>
			';		
	
		}
		
		else {
		
			$xmls = '
					<methodResponse>
					   <fault>
						  <value>
							 <struct>
								<member>
								   <name>faultCode</name>
								   <value><int>1</int></value>
								   </member>
								<member>
								   <name>faultString</name>
								   <value><string>error</string></value>
								   </member>
								</struct>
						  </value>
					   </fault>
					</methodResponse>
			';	
		
		}
	
		// 실제 출력
		
		header("Content-Type: text/xml; charset=utf-8");
		
		echo '<?xml version="1.0" encoding="utf-8"?>';
	
		echo $xmls;
	
		$oContext->close();

    
?>
