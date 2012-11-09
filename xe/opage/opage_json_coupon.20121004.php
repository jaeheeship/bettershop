<?php

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
	
	$member_srl = $_GET['member_srl'];
	
	$scrap_shop_title = array();	// 찜한 가게 제목.
	$shop_coupons = array();	// 해당가게 쿠폰 리스트
	
	$sections = array();
	//SELECT document_srl FROM xe_member_scrap WHERE member_srl='2883' ORDER BY regdate DESC
	$result_query = mysql_query("SELECT document_srl FROM xe_member_scrap WHERE member_srl='".$member_srl."' ORDER BY regdate DESC");
	
	$rows = mysql_num_rows($result_query);
	
	for($i=0; $i<$rows; $i++) 	// 찜한 가계 목록.
	{ 
		$row=mysql_fetch_array($result_query); 
		$document_srl = $row['document_srl'];
		
		// document_srl를 인자로 shop_code 얻어내기.
		
		$result_query3 = mysql_query("SELECT shop_code FROM bs_shop_info WHERE document_srl='".$document_srl."'");
	  
		if(mysql_num_rows($result_query3)>0)
		{
			$row3 = mysql_fetch_array ($result_query3);
			$shop_code = $row3["shop_code"];	
		}	
		//else
		//{
		//	$shop_code = nil;
			// shop code error
		//}
		
		// 가게 제목 얻어내기.
		/*
		$result_query2 = mysql_query("SELECT title FROM xe_documents WHERE document_srl='".$document_srl."'");
	  
		if(mysql_num_rows($result_query2)>0)
		{
			$row2 = mysql_fetch_array ($result_query2);
			//$scrap_shop_title[$i] = $row2["title"];	
			
			$sections[$i]['shop_name']= $row2["title"];
		}
		*/	
		//else
		//{
		//	$sections[$i]['shop_name']= nil;
		//}
		// 가게 쿠폰 포인트 얻어내기 ($member_srl, $shop_code 로 .. 회원의 그 가게에 대한 누적 포인트 알아내기.
		
		$result_query2 = mysql_query("SELECT shop_name FROM bs_shop_info WHERE document_srl='".$document_srl."'");
	  
		if(mysql_num_rows($result_query2)>0)
		{
			$row2 = mysql_fetch_array ($result_query2);	
			$sections[$i]['shop_name']= $row2["shop_name"];
		}

		
		$sections[$i]['shop_document_srl']=$document_srl;	// 가게 정보가 있는 게시물을 지정함.
		
		
		// 해당가게에서 누적 포인트 얻기. 0014 오이시 초밥 2883 이영애
		
		// SELECT `point` FROM `bs_point_log` WHERE `shop_code`='0014' AND `member_srl`='2883';	// 11개
		// SELECT `point` FROM `bs_point_log` WHERE `shop_code`='0014' AND `member_srl`='2879';	// 0개
		// SELECT `point` FROM `bs_point_log` WHERE `shop_code`='0014' AND `member_srl`='2881';	// 8개
		
		
		$query_result6 = mysql_query("SELECT point FROM bs_point_log WHERE shop_code='".$shop_code."' AND member_srl='".$member_srl."'");
		$rows6 = mysql_num_rows($query_result6);
	    
	    $total_point = 0;
		for($j=0; $j<$rows6; $j++){	// 쿠폰 목록.
			$row6 = mysql_fetch_array ($query_result6);
			$total_point += $row6['point'];

		}
		
		
		//$sections[$i]['shop_point']='21000';	// 실제로 계산해서 넣어야한다.. log에 있는 + - 값을 더해서..
		$sections[$i]['shop_point']=$total_point;	// 실제로 계산해서 넣어야한다.. log에 있는 + - 값을 더해서..
		
		// 가게 적립 쿠폰 얻어내기

		$result_query4 = mysql_query("SELECT * FROM bs_coupon WHERE type='coupon' AND shop_code='".$shop_code."'");
	  
	    $rows4 = mysql_num_rows($result_query4);
	    
		for($j=0; $j<$rows4; $j++){	// 쿠폰 목록.
			$row4 = mysql_fetch_array ($result_query4);
			$sections[$i]['coupons'][$j]['coupon_coupon_srl']= $row4["coupon_srl"];
			$sections[$i]['coupons'][$j]['coupon_write_time']= $row4["write_time"];
			$sections[$i]['coupons'][$j]['coupon_type']= $row4["type"];
			$sections[$i]['coupons'][$j]['coupon_shop_code']= $row4["shop_code"];
			$sections[$i]['coupons'][$j]['coupon_title']= $row4["title"];
			$sections[$i]['coupons'][$j]['coupon_info']= $row4["info"];
			$sections[$i]['coupons'][$j]['coupon_image']= $row4["image"];
			
			$sections[$i]['coupons'][$j]['coupon_point']= $row4["point"];
			$sections[$i]['coupons'][$j]['coupon_valid']= $row4["valid"];
			$sections[$i]['coupons'][$j]['coupon_act_date']= $row4["act_date"];
			$sections[$i]['coupons'][$j]['coupon_exp_date']= $row4["exp_date"];
		}	
		
		// 가게 이벤트 쿠폰 얻어내기

		$result_query5 = mysql_query("SELECT * FROM bs_coupon WHERE type='event' AND shop_code='".$shop_code."'");
	  
	    $rows5 = mysql_num_rows($result_query5);
	    
		for($j=0; $j<$rows5; $j++){	// 쿠폰 목록.
			$row5 = mysql_fetch_array ($result_query5);
			$sections[$i]['events'][$j]['coupon_coupon_srl']= $row5["coupon_srl"];
			$sections[$i]['events'][$j]['coupon_write_time']= $row5["write_time"];
			$sections[$i]['events'][$j]['coupon_type']= $row5["type"];
			$sections[$i]['events'][$j]['coupon_shop_code']= $row5["shop_code"];
			$sections[$i]['events'][$j]['coupon_title']= $row5["title"];
			$sections[$i]['events'][$j]['coupon_info']= $row5["info"];
			$sections[$i]['events'][$j]['coupon_image']= $row5["image"];
			
			$sections[$i]['events'][$j]['coupon_point']= $row5["point"];
			$sections[$i]['events'][$j]['coupon_valid']= $row5["valid"];
			$sections[$i]['events'][$j]['coupon_act_date']= $row5["act_date"];
			$sections[$i]['events'][$j]['coupon_exp_date']= $row5["exp_date"];
		}	
		
		
	}
	
	echo json_encode($sections);

	$oContext->close();
	
	

?>
