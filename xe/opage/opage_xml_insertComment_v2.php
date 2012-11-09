<?PHP

	include "opage_xml_model.php";

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();
/////////

	if($_GET['act'])
	{
		$act = $_GET['act'];
	}

	$debug=false;
	if($debug){
	
		$valid = true;	// true/false

		$module_srl = @"149";
		
		$document_srl = '218';		// 문서 		
		$content ='좋아요';				// 글쓴 내용
		$member_srl = '2883';
		$user_id = '371619526';
		// 2012.9.21 j.kim
		$facebook = '0';
		$twitter = '0'; 
		$shop_code = '0014';	 
		$type = 'happy';

	
	}
	else {
	
		$valid = true;	// true/false
		// 인자의 유효성 체크
		
		//$module_srl = $_POST['module_srl'];			// 게시판 ... 가게정보 게시판이니.. 서버 PHP에서 값 정하자.
		$module_srl = @"149";
		$document_srl = $_POST['document_srl'];		// 문서 		
		$content = $_POST['content'];				// 글쓴 내용
		$member_srl = $_POST['member_srl'];
		$user_id = $_POST['user_id'];
		$shop_code = $_POST['shop_code'];	// document_srl에서 역추적 할수도 잇으나 그냥 받는것으로 일단 처리. 
		// $comment_srl  // oCommentController->insertComment($arg); 처리하는 과정에서 받을수 있을까? 받는다.
		$type = $_POST['type'];
		$facebook = $_POST['facebook'];
		$twitter = $_POST['twitter'];

	
	}	
	


	$valid = true;
	if($valid){
	
	
	
		
		
		$oCommentController = &getController('comment');
		
		$arg->module_srl = $module_srl;		// 게시판 모듈
		$arg->document_srl = $document_srl;	// 대상 글
		$arg->content = $content; 			// 내용
		
		
		
		$output = $oCommentController->insertComment($arg);
	
		
		
		if(strcmp($output->message,'success') == 0){

			$time = date('Y-m-d H:i:s');

			$comment_srl = $output->get('comment_srl');
	
			// 에러 있음.. 디버깅 요망.. j.kim 2012.10.13
			
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

			$result['result'] = 'error';
			$result['error'] = 'comment_failed';
			$result['message'] = 'exception!('.$output->message.')';
		}


	} // end if
	else {
		$result['result'] = 'error';
		$result['error'] = 'invalid_request';
		$result['message'] = '유효하지 않은 요청입니다';	
	}

/////////////
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

	// 실제 출력
	
	header("Content-Type: text/xml; charset=utf-8");
	
	echo '<?xml version="1.0" encoding="utf-8"?>';

	echo $xmls;

	$oContext->close();
?>
