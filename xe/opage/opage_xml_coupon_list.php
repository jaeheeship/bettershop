<?PHP
	
	// include
	
	include "opage_xml_model.php";

	// xe 필수 초기화

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	// output 만들기 시작.....
	
	// control 부분
	
	$result_value = 'success';
	$result = '<result><![CDATA['.$result_value.']]></result>';
	
	$error_value = 'none';
	$error = '<error><![CDATA['.$error_value.']]></error>';
	
	$message_value = '성공하였습니다.';
	$message = '<message><![CDATA['.$message_value.']]></message>';
	
	$control = '<control>'.$result.$error.$message.'</control>';
	
	// data 부분
	
	
	$shop_name_value = '오이시 초밥';
	$shop_name = '<shop_name><![CDATA['.$shop_name_value.']]></shop_name>';
	
	$shop_point_value = '21000';
	$shop_point = '<shop_point><![CDATA['.$shop_point_value.']]></shop_point>';
	
	
	
	$coupons1
	
	$coupons = '<coupons></coupons>';
	
	$section1 = '<section>'.$shop_name.$shop_point.$coupons.'</section>';
	
	$section2 = '<section>'.$shop_name.$shop_point.$coupons.'</section>';
	
	$sections = '<sections>'.$section1.$section2.'</sections>';
	
	
	$data = '<data>'.$sections.'</data>';
	
	// response 생성
	
	$response = '<response>'.$control.$data.'</response>';

	// oContext 닫기
	
	$oContext->close();

	// xml 최종 출력

	header("Content-Type: text/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo $response;
	
?>
