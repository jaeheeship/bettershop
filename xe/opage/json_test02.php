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
	
	$scrap_shop_title = array();	// 찜한 가게 제목.
	$shop_coupons = array();	// 해당가게 쿠폰 리스트
	
	$sections = array();
	
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
		else
		{
			$shop_code = nil;
			// shop code error
		}
		
		// 가게 제목 얻어내기.
		$result_query2 = mysql_query("SELECT title FROM xe_documents WHERE document_srl='".$document_srl."'");
	  
		if(mysql_num_rows($result_query2)>0)
		{
			$row2 = mysql_fetch_array ($result_query2);
			//$scrap_shop_title[$i] = $row2["title"];	
			
			$sections[$i]['shop_name']= $row2["title"];
		}	
		else
		{
			$sections[$i]['shop_name']= nil;
		}
		// 가게 쿠폰 포인트 얻어내기 ($member_srl, $shop_code 로 .. 회원의 그 가게에 대한 누적 포인트 알아내기.
		
		$sections[$i]['shop_document_srl']=$document_srl;	// 가게 정보가 있는 게시물을 지정함.
		$sections[$i]['shop_point']='21000';	// 실제로 계산해서 넣어야한다.. log에 있는 + - 값을 더해서..
		
		
		// 가게 쿠폰 얻어내기
		
		
		
			
		// shop_code로 coupons 얻어내기
		
		//$coupons = getCouponsByShopCode($shop_code);
		//$result_query4 = mysql_query("SELECT coupon_srl, writetype, shop_code, title, info, image, point, valid, act_data, exp_date FROM bs_coupon WHERE type='coupon' AND shop_code='".$shop_code."'");
	  
		
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
	}
	
	echo json_encode($sections);

	$oContext->close();
	
	
/*	

$output[0]='이것은';
$output[1]='테스트';
$output[2]='입니다';

$output[0]=$scrap_shop_title[0];
$output[1]=$scrap_shop_title[1];
$output[2]=$scrap_shop_title[2];

//////////////

$result = '<![CDATA[success]]>';
$error = '<![CDATA[none]]>';
$message = '<![CDATA[성공하였습니다.]]>';

$control = array('result' => $result, 'error' => $error, 'message' => $message);

$coupon11 = array('coupon_title' => '<녹차 무료!!', 'coupon_point' => '10000');
//$coupon11['coupon_title'] = 'total_count='.$items['total_count'];
$coupon11['coupon_title'] = $output[0];

$coupon12 = array('coupon_title' => '<음료수 무료!!', 'coupon_point' => '5000');
//$coupon12['coupon_title'] = 'doc_list_count='.$items['doc_list_count'];
$coupon12['coupon_title'] = $output[1];

$coupon13 = array('coupon_title' => '<초밥세트 무료!!', 'coupon_point' => '7000');
$coupon13['coupon_title'] = $output[2];

$coupons = array($coupon11, $coupon12, $coupon13);

$section1 = array('shop_name' => '오이시 초밥!!', 'shop_point' => '21077', 'coupons' => $coupons);

$sections = array($section1, $section1, $section1);

$data = array('sections' => $sections );

$response = array('control' => $control, 'data' =>  $data);

echo json_encode($response);
*/

/*
//$coupon11 = array('coupon_title' => '<녹차 무료!!', 'coupon_point' => '10000');
$coupon11['coupon_title']='^^녹차 무료!>';
$coupon11['coupon_point']='10000';

//$coupon12 = array('coupon_title' => '<음료수 무료!!', 'coupon_point' => '5000');
$coupon12['coupon_title']='<<음료수 무료!!>';
$coupon12['coupon_point']='5000';

//$coupon13 = array('coupon_title' => '<초밥세트 무료!!', 'coupon_point' => '7000');
$coupon13['coupon_title']='<<초밥세트 무료!>';
$coupon13['coupon_point']='7000';

//$coupons = array($coupon11, $coupon12, $coupon13);
$coupons[0] = $coupon11;
$coupons[1] = $coupon12;
$coupons[2] = $coupon13;

//$section1 = array('shop_name' => '오이시 초밥!!', 'shop_point' => '21077', 'coupons' => $coupons);
$section1['shop_name']='오이시 초밥!?!';
$section1['shop_point']='21077';
$section1['coupons']=$coupons;


//$sections = array($section1, $section1, $section1);
$sections[0] = $section1;
$sections[1] = $section1;
$sections[2] = $section1;
*/
/*
$temp = array("1"=>"백두산","2"=>"한라산","3"=>"설악산");
foreach($temp as $key=>$val)
{
echo "key : $key  ~~~  val : $val<br>";
}


echo json_encode($sections);

*/
?>
