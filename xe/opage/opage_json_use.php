<?php


	function save($time, $type, $point, $member_srl, $shop_code, $sales_time, $total_num, $coupon_srl)
	{		
		$sql = 
			"
			INSERT INTO `bs_point_log` (`time`, `type`, `point`, `member_srl`, `shop_code`, `sales_time`, `total_num`, `coupon_srl`) 
			VALUE ('$time', '$type', '$point', '$member_srl', '$shop_code', '$sales_time', '$total_num', '$coupon_srl');
			";
		$result = mysql_query($sql);
		if(!$result){
			return FALSE;
		}
		else{
			return TRUE;
		}
	}

	include "opage_xml_model.php";
	
	//header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();
	
	$member_srl='2879'; 	// 100003955432459@facebook.com 3개
	
	$member_srl='2883'; 	// 371619526@twitter.com 4개
	
	//$member_srl='2881'; 	// kjy1973ss@hanmail.net 2개
	//$member_srl='2983';		//kjy1973ss9@hanmail.net 찜 0 개
	//$member_srl='2975';		//kjy1973ss5@hanmail.net 찜 1 개
	
	//$member_srl = $_GET['member_srl'];
	// trim
	$coupon_srl = trim($_POST['coupon_srl']);
	$member_srl = trim($_POST['member_srl']);
	$user_id = trim($_POST['user_id']);
	
	
	$result_query0 = mysql_query("SELECT member_srl FROM xe_member WHERE user_id='".$user_id."'");
	if( mysql_num_rows($result_query0) > 0){
	
		$row0=mysql_fetch_array($result_query0); 
		$member_srl = $row0['member_srl'];
	}
	else {
		// 에러 비정상 종료.
	}

	//$sections = array();
	
	///////////
	
	// 요청 받은 쿠폰이... 적립 쿠폰인지.. 이벤트 쿠폰인지..
	
	// 적립쿠폰이면.
	
	/*
	$time = date('Y-m-d H:i:s');			// 사용시점.
	$type = 'coupon_use';
	//$point = '12000';						// coupon_srl 로 얻어오기
	$member_srl = $member_srl;
	//$shop_code = '0014';					// coupon_srl 로 얻어오기
	$sales_time = date('Y-m-d H:i:s');		// 의미없는 정보 그냥 현재시각으로.
	$total_num = '0';
	//$coupon_srl = '2';					// 이미 받은값.
	*/
	
	$result_query1 = mysql_query("SELECT type, point, shop_code FROM bs_coupon WHERE coupon_srl='".$coupon_srl."'");
	  
	if(mysql_num_rows($result_query1)>0)	// 해당 쿠폰이 존재하면.
	{
		$row1 = mysql_fetch_array ($result_query1);
		$point = $row1["point"];
		$shop_code = $row1["shop_code"];
		$coupon_type = $row1["type"];	// coupon or event
		
		if($coupon_type == 'coupon') { // 적립 푸폰이면
	
			$time = date('Y-m-d H:i:s');			// 사용시점.
			$type = 'coupon_use';
			$member_srl = $member_srl;
			$sales_time = date('Y-m-d H:i:s');		// 의미없는 정보 그냥 현재시각으로.
			$total_num = '0';
				
			if(save($time, $type, $point, $member_srl, $shop_code, $sales_time, $total_num, $coupon_srl)){
			
				$result = 'success';
				$error = 'none('.$coupon_srl.')';
				$message = '성공하였습니다.';
				$control = array('result' => $result, 'error' => $error, 'message' => $message);
			
				$data = array('used_coupon_srl' => $coupon_srl, 'status code' => '012345');
				
				$response = array('control' => $control, 'data' =>  $data);
			
				echo json_encode($response);
			}
			else{ // fail error
			
				$result = 'failure';
				$error = 'exist('.$coupon_srl.')';
				$message = '실패하였습니다.';
				$control = array('result' => $result, 'error' => $error, 'message' => $message);
			
				$data = array('used_coupon_srl' => $coupon_srl, 'status code' => '99999');
				
				$response = array('control' => $control, 'data' =>  $data);
			
				echo json_encode($response);
			}
		
		}
		else {	// 이벤트 쿠폰일 경우.
		
			$time = date('Y-m-d H:i:s');			// 사용시점.
			$type = 'event_use';
			$member_srl = $member_srl;
			$sales_time = date('Y-m-d H:i:s');		// 의미없는 정보 그냥 현재시각으로.
			$total_num = '0';
				
			if(save($time, $type, $point, $member_srl, $shop_code, $sales_time, $total_num, $coupon_srl)){
			
				$result = 'success';
				$error = 'none('.$coupon_srl.')';
				$message = '성공하였습니다.';
				$control = array('result' => $result, 'error' => $error, 'message' => $message);
			
				$data = array('used_coupon_srl' => $coupon_srl, 'status code' => '012345');
				
				$response = array('control' => $control, 'data' =>  $data);
			
				echo json_encode($response);
			}
			else{ // fail error
			
				$result = 'failure';
				$error = 'exist('.$coupon_srl.')';
				$message = '실패하였습니다.';
				$control = array('result' => $result, 'error' => $error, 'message' => $message);
			
				$data = array('used_coupon_srl' => $coupon_srl, 'status code' => '99999');
				
				$response = array('control' => $control, 'data' =>  $data);
			
				echo json_encode($response);
			}
		
		
		}
		
	}
	else {
		// 에러처리 TODO
		
		$result = 'failure';
		$error = 'no_coupon('.$coupon_srl.')';
		$message = '실패하였습니다.';
		$control = array('result' => $result, 'error' => $error, 'message' => $message);
	
		$data = array('used_coupon_srl' => $coupon_srl, 'status code' => '012345');
		
		$response = array('control' => $control, 'data' =>  $data);
	
		echo json_encode($response);
	}
	

	$oContext->close();
	
	

?>
