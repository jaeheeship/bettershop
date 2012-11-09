<?PHP

	include "opage_xml_model.php";
	
	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();


	$user_id = $_POST['user_id'];
	
	// 강제 로그인 시키자. (안드로이드버젼.. 스크랩 하는쪽에서.. 로그인 안되잇다고 에러 )
	
	$user_id = $_POST['user_id'];
	$password = $_POST['password'];
	
	// 로그인 한번 해주고.
	
	$oMemberController = &getController('member');
	$output2 = $oMemberController->doLogin($user_id, $password);
		
	if($output2->toBool()) {	// 로그인 성공했을때. 로그인하는 이유는 XE의 함수를 사용해야 하므로
		$login_success = true;
	}
	else {
		$login_success = false;;
	}
	
	
	if($login_success){
		
		//$logged_info = Context::get('logged_info');
		
		// $user_id 로 $member_srl을 구하자.
		
		$sql0 = 
			"
			SELECT `member_srl` FROM `xe_member` WHERE `user_id`='$user_id';
			";
			
		$query_result0 = mysql_query($sql0);
		
		$rows0 = mysql_num_rows($query_result0);
		
		if($rows0>0){
			$row0 = mysql_fetch_array($query_result0);
			$member_srl = $row0['member_srl'];
			
			/// 다음 단계
			
			$time = date('Y-m-d H:i:s');	// MySQL의 Datetime 형에 맞게.
			$type = $_POST['type'];
			$point = $_POST['point'];
			//$member_srl = $logged_info->member_srl;
			$shop_code = $_POST['shop_code'];
			$sales_time = $_POST['sales_time'];
			$total_num = $_POST['total_num'];
			$coupon_srl = $_POST['coupon_srl'];
			
			$sql = 
				"
				SELECT `document_srl`,`shop_name` FROM `bs_shop_info` WHERE `shop_code`='$shop_code';
				";
				
			$query_result = mysql_query($sql);
			
			$rows = mysql_num_rows($query_result);
			
			if($rows>0){
				$row = mysql_fetch_array($query_result);
				$document_srl = $row['document_srl'];
				$shop_name = $row['shop_name'];
				
				// 다음 단계로..
				
				$sql2 = 
					"
					INSERT INTO `bs_point_log` (`time`, `type`, `point`, `member_srl`, `shop_code`, `sales_time`, `total_num`, `coupon_srl`) 
					VALUE ('$time', '$type', '$point', '$member_srl', '$shop_code', '$sales_time', '$total_num', '$coupon_srl');
					";
				
	
				$query_result2 = mysql_query($sql2);
				
				if($query_result2){	// 성공
					$result['result'] = 'success';
					$result['error'] = 'none';	// notlogin?
					$result['message'] = '적립내역을 기록하였습니다.';
					$result['document_srl'] = $document_srl;
					$result['shop_name'] = $shop_name;
					// scrap 하자.
					
					// 찜하기
					$args->document_srl = $document_srl;
					$args->member_srl = $member_srl;
					$scrap_output = xmlDocumentScrap($args);
					$result['scrapped'] = $scrap_output->message;
				
				}
				else { // 실패
					$result['result'] = 'error';
					$result['error'] = 'not_save';	// 
					$result['message'] = '적립내역을 기록하지 못했습니다.';
				}
				
			}
			else {
				$result['result'] = 'error';
				$result['error'] = 'shop_info_table_error';	// 
				$result['message'] = 'shop_info 테이블에 해당 shop_code값이 없습니다.';
			}
	
				
				
	 	}
	 	else {
	 		// 에러 처리. -- 아이디가 없으니.. 새 아이디로 로그인하도록 연결. (거의 발생확률 없음)
	 	
			$result['result'] = 'error';
			$result['error'] = 'not_login';	// notlogin?
			$result['message'] = '로그인하지 않았습니다.';
	 	}
	 	

	}
	else {
		$result['result'] = 'error';
		$result['error'] = 'not_login';	// notlogin?
		$result['message'] = '로그인하지 않았습니다.';
	}

//======

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


	header("Content-Type: text/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="utf-8"?>';

	echo $xmls;

	$oContext->close();
	*/
	
	if(strcmp($result['result'],'success') == 0){	// 성공시 
	
		$info["shop_name"] = $result['shop_name'];
		$info["document_srl"] = $result['document_srl'];
		
		$result = 'success';
		$error = 'none';
		$message = '성공하였습니다.';
	
	}
	else {	// 실패시 
	
		$result = 'failure';
		$error = $result['error'];
		$message = $result['message'];
	}

	$control = array('result' => $result, 'error' => $error, 'message' => $message);
	
	$data = array('info' => $info );

	$response = array('control' => $control, 'data' =>  $data);
	
	header('Content-type: application/json');
	
	echo json_encode($response);
	//echo json_encode($sections);

	$oContext->close();

	
?>
