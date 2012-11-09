<?PHP

	include "opage_xml_model.php";

	function updateReviewLog($time, $type, $member_srl, $shop_code, $comment_srl, $facebook, $twitter)     
	{	
		$link = mysql_connect('localhost', 'root', 'root');
		if (!$link) {
			//die('Could not connect: ' . mysql_error());
			return FALSE;
		}
		//echo 'Connected successfully';
		
		
		if(!mysql_select_db('bs01',$link)){
			//die('Could not select db: ' . mysql_error());
			return FALSE;
		}
		
		mysql_query("set session character_set_connection=utf8;");
		mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");
		
		/*
		$sql = 
			"
			INSERT INTO `member_front` (`from`, `name`, `user_id`, `pass`, `mail`, `user_tel`, `profile`, `sex`, `birth`) VALUES
			('Facebook', 'chanhopark', '100000111111', '123456', '1111100000@facebook.com', '01075800889', 'http://www.bettershop.co.kr/image.jpg','male','2012. 8. 20');
			";	
		*/
		$sql = 
			"
			INSERT INTO `review_log` (`time`, `type`, `member_srl`, `shop_code`, `comment_srl`, `facebook`, `twitter`) VALUES
			('$time', '$type', '$member_srl', '$shop_code', '$comment_srl', '$facebook', '$twitter');
			";	
		
		/*
		$sql = 
			"
			INSERT INTO `member_front` (`from`, `name`, `user_id`, `pass`, `mail`, `user_tel`, `profile`, `sex`, `birth`) VALUES
			('"+$from+"', '"+$name+"', '"+$user_id+"', '"+$pass+"', '"+$mail+"', '"+$user_tel+"', '"+$profile+"','"+$sex+"','"+$birth+"');
			
			";
		*/
		
		$db_result = mysql_query($sql,$link);
		
		if(!db_result){
			//die('Could not query: ' . mysql_error());
			mysql_close($link);
			return FALSE;
		}
		else {
			mysql_close($link);
			return TRUE;
		}
		
		
	}


	header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	if($_GET['act'])
	{
		$act = $_GET['act'];
	}

	$is_logged = Context::get('is_logged');

	$valid = true;	// true/false
	// 인자의 유효성 체크
	
	$module_srl = $_POST['module_srl'];			// 게시판 
	$document_srl = $_POST['document_srl'];		// 문서 		
	$content = $_POST['content'];				// 글쓴 내용
	//$nick_name = $_POST['nick_name'];	// 1~200 email
	//$user_name = $_POST['user_name'];			// 2~40
	//$member_srl = $_POST['member_srl'];
	// 2012.9.21 j.kim
	//$facebook = '1';
	//$twitter = '1'; // 이단계서 하면.. sns시도 정보이고. 실제로 쓰엿는지는 모르니까 그냥 두자. 글쓰기 토탈 결과 나온다음에 처리하자.
	$shop_code = $_POST['shop_code'];	// document_srl에서 역추적 할수도 잇으나 그냥 받는것으로 일단 처리. 
	// $comment_srl  // oCommentController->insertComment($arg); 처리하는 과정에서 받을수 있을까?
	$type = $_POST['type'];
	$facebook = $_POST['facebook'];
	$twitter = $_POST['twitter'];
	
	//$valid=false;
	
	if($valid){
	
		if($is_logged){	// 로그인 되어 있을 경우만 처리
		
			$oCommentController = &getController('comment');
			
			/*
			$arg->module_srl = '149';	// 게시판 모듈
			$arg->document_srl = '218';	// 대상 글
			$arg->content = '모바일에서 댓글 쓰기 성공!'; // 내용
			$arg->nick_name = '노하우';   // 닉네임
			$arg->user_name = '김진용';	// 이름
			$arg->member_srl = '713';	// 회원 srl
			
			*/
			$arg->module_srl = $module_srl;		// 게시판 모듈
			$arg->document_srl = $document_srl;	// 대상 글
			$arg->content = $content; 			// 내용
			//$arg->nick_name = $nick_name;  		// 닉네임
			//$arg->user_name = $user_name;		// 이름
			//$arg->member_srl = $member_srl;		// 회원 srl
			
			$output = $oCommentController->insertComment($arg);
		
			if(strcmp($output->message,'success') == 0){
			
			/*
				// 찜하기
				$args->document_srl = $document_srl;
				$args->member_srl = $logged_info->member_srl;
				$scrap_output = xmlDocumentScrap($args);
				$result['scrapped'] = $scrap_output->message;
			*/
			
			/*
				$is_scrapped = getIsScrappedDocument($args);
				if($is_scrapped == 0){	// not scrapped
					$scrap_output = xmlDocumentScrap($args);
					if(strcmp($scrap_output->message,'msg_alreay_scrapped]') == 0){
						$result['scrapped'] = '스크랩을 시도하였스나 실패했습니다.'.$scrap_output->message;
						//$result['scrapped'] = $scrap_output->message;
					}
					else {
						
						$result['scrapped'] = '새로 스크랩했습니다.'.$scrap_output->message;
					}
				}
				else {
					// do nothing
					$result['scrapped'] = '이미 스크랩되어 있습니다.';
				}
			*/
				$time = date('Y-m-d H:i:s');
				//$type = 
				
				$logged_info = Context::get('logged_info');
				$member_srl = $logged_info->member_srl;
				$comment_srl = $output->get('comment_srl');
				//$facebook = '1';
				//$twitter = '1';
			
				if(updateReviewLog($time, $type, $member_srl, $shop_code, $comment_srl, $facebook, $twitter)){
					$result['result'] = 'success';
					$result['message'] = '댓글을 등록하였습니다.(review_log성공)shop_code='.$shop_code.' type='.$type.'comment_srl='.$comment_srl;
				}
				else {
					$result['result'] = 'success';
					$result['message'] = '댓글을 등록하였습니다.(review_log실패)shop_code='.$shop_code.' type='.$type.'comment_srl='.$comment_srl;
				}

				
			}
			else {
	
			
				$result['result'] = 'unknown';
				$result['message'] = 'exception!('.$output->message.')';
			}
		
		
		
		}
		else {	// 로그인 안된 상태라면
		
			$result['result'] = 'error';
			$result['error'] = 'not_login';
			$result['message'] = '로그인을 하지 않으셨습니다.';
		
		}



	} // end if
	else {
		$result['result'] = 'error';
		$result['error'] = 'arguement value error';
		$result['message'] = 'post data is invalid '.mb_strlen($user_id, "UTF-8").'/'.mb_strlen($password, "UTF-8").'/'.mb_strlen($user_name, "UTF-8").'/'.mb_strlen($email_address, "UTF-8").'/'.mb_strlen($nick_name, "UTF-8");	
	}
	
//======
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


	echo '<?xml version="1.0" encoding="utf-8"?>';

	echo $xmls;

	$oContext->close();
?>
