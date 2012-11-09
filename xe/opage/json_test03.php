<?php

	include "opage_xml_model.php";
	
	//header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();
	
	$member_srl='2879';
	$document_scrap_document_title = array();
	
	$result_query = mysql_query("SELECT document_srl FROM xe_member_scrap WHERE member_srl='".$member_srl."' ORDER BY regdate DESC");
	
	$rows = mysql_num_rows($result_query);
	
	for($i=0; $i<$rows; $i++) 
	{ 
		$row=mysql_fetch_array($result_query); 
		//$document_scrap_member_homepage[$i] = $row["member_srl"];	
		
		
		$result_query2 = mysql_query("SELECT title FROM xe_documents WHERE document_srl='".$row["document_srl"]."'");
	  
		if(mysql_num_rows($result_query2)>0)
		{
			$row2 = mysql_fetch_array ($result_query2);
			$document_scrap_document_title[$i] = $row2["title"];
		}	
		else
		{
			$document_scrap_document_title[$i] = '';
		}
		
	}

/*
$result_query = mysql_query("SELECT member_srl FROM xe_member_scrap WHERE document_srl='".$args->document_srl."' ORDER BY regdate DESC LIMIT 6");
		
		$rows = mysql_num_rows($result_query);
		
		for($i=0; $i<$rows; $i++) 
		{ 
		  	$row=mysql_fetch_array($result_query); 
		  	//$document_scrap_member_homepage[$i] = $row["member_srl"];	
		  	
		  	
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
*/



	$oContext->close();
	
	
	

$output[0]='이것은';
$output[1]='테스트';
$output[2]='입니다';

$output[0]=$document_scrap_document_title[0];
$output[1]=$document_scrap_document_title[1];
$output[2]=$document_scrap_document_title[2];

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
