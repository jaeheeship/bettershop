<?PHP

	include "opage_xml_model.php";

	function save($time, $type, $point, $member_srl, $shop_code, $sales_time, $total_num, $coupon_srl)
	{
	
			$link = mysql_connect('localhost', 'root', 'root');
			if (!$link) {
				//die('Could not connect: ' . mysql_error());
				return FALSE;
			}
			//echo 'Connected successfully';
			
			// bs01 DB의 member_front TABLE의
			if(!mysql_select_db('xe14',$link)){
				//die('Could not select db: ' . mysql_error());
				return FALSE;
			}
			
			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");
			/*
			INSERT INTO `point` (`time`, `type`, `point`, `member_srl`, `shop_code`, `sales_time`, `total_num`, `coupon_srl`) 
			VALUE ('1111-11-11 22:22:22', 'save', '12000', '1407', '0014', '20120920115959', '33', '2');
			*/
			
			/*
			
			$sql = 
				"
				INSERT INTO `point_log` (`time`, `type`, `point`, `member_srl`, `shop_code`, `sales_time`, `total_num`, `coupon_srl`) 
				VALUE ('$time', '$type', '$point', '$member_srl', '$shop_code', '$sales_time', '$total_num', '$coupon_srl');
				";
			
			*/
			
			
			$sql = 
				"
				INSERT INTO `bs_point_log` (`time`, `type`, `point`, `member_srl`, `shop_code`, `sales_time`, `total_num`, `coupon_srl`) 
				VALUE ('$time', '$type', '$point', '$member_srl', '$shop_code', '$sales_time', '$total_num', '$coupon_srl');
				";
			
			/*
			$sql = 
			"
			SELECT `time` FROM `point_log`;
			";
			*/
			$result = mysql_query($sql,$link);
			
			if(!$result){
				//die('Could not query: ' . mysql_error());
				mysql_close($link);
				return FALSE;
			}
			else{
				mysql_close($link);
				return TRUE;
			}
	
	}
	
	function save2($time, $type, $point, $member_srl, $shop_code, $sales_time, $total_num, $coupon_srl)
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
	
	function getDocumentSrlByShopCode($shop_code)
	{
	
			$link = mysql_connect('localhost', 'root', 'root');
			if (!$link) {
				//die('Could not connect: ' . mysql_error());
				return FALSE;
			}
			//echo 'Connected successfully';
			
			// bs01 DB의 member_front TABLE의
			if(!mysql_select_db('xe14',$link)){
				//die('Could not select db: ' . mysql_error());
				return FALSE;
			}
			
			mysql_query("set session character_set_connection=utf8;");
			mysql_query("set session character_set_results=utf8;");
			mysql_query("set session character_set_client=utf8;");


			$sql = 
			"
			SELECT `document_srl` FROM `bs_shop_info` WHERE `shop_code`='$shop_code';
			";
			
			$result = mysql_query($sql,$link);
			
			if(!$result){
				//die('Could not query: ' . mysql_error());
				mysql_close($link);
				return FALSE;
			}
			else{
				$num_row = mysql_num_rows($result);
		
				if($num_row > 0) {
					$row = mysql_fetch_array($result, MYSQL_NUM);
					$shop_code = $row[0];
					return $shop_code;
				}
			}
			return FALSE; // never reached!
	}
	
	function getDocumentSrlByShopCode2($shop_code)
	{

		// 가게 제목 얻어내기.
		/*
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
	*/



			$sql = 
			"
			SELECT `document_srl` FROM `bs_shop_info` WHERE `shop_code`='$shop_code';
			";
			
			$result = mysql_query($sql);
			
			if(!$result){

				return FALSE;
			}
			else{
				$num_row = mysql_num_rows($result);
		
				if($num_row > 0) {
					$row = mysql_fetch_array($result);
					$document_srl = $row[0];
					return $document_srl;
				}
			}
			return FALSE; // never reached!
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
	
	// http://www.bettershop.co.kr/xe14/opage/opage_xml_save.php
	// http://www.bettershop.co.kr/xe14/opage/opage_xml_save.php?time=20120920115959&type=save&point=12000&shop_code=0014&sales_time=20120920115959&total_num=32&coupon_srl=-1;
	
	if($is_logged){
		
		$logged_info = Context::get('logged_info');
		
		//$time = $_GET['time'];
		/*
		$time = date('Y-m-d H:i:s');	// MySQL의 Datetime 형에 맞게.
		$type = $_GET['type'];
		$point = $_GET['point'];
		$member_srl = $logged_info->member_srl;
		$shop_code = $_GET['shop_code'];
		$sales_time = $_GET['sales_time'];
		$total_num = $_GET['total_num'];
	 	$coupon_srl = $_GET['coupon_srl'];
	 	*/
	 	
	 	$time = date('Y-m-d H:i:s');	// MySQL의 Datetime 형에 맞게.
		$type = $_POST['type'];
		$point = $_POST['point'];
		$member_srl = $logged_info->member_srl;
		$shop_code = $_POST['shop_code'];
		$sales_time = $_POST['sales_time'];
		$total_num = $_POST['total_num'];
	 	$coupon_srl = $_POST['coupon_srl'];
	 	
	 	//MySQL의 Datetime 형태일때..
	 	
	 	/*
	 	$time = '1111-11-11 22:22:22';
		$type = 'save';
		$point = '12000';
		$member_srl = $logged_info->member_srl;
		$shop_code = '0014';
		$sales_time = '20120920115959';
		$total_num = '32';
	 	$coupon_srl = '2';
	 	*/
	 	/*
			INSERT INTO `point` (`time`, `type`, `point`, `member_srl`, `shop_code`, `sales_time`, `total_num`, `coupon_srl`) 
			VALUE ('1111-11-11 22:22:22', 'save', '12000', '1407', '0014', '20120920115959', '33', '2');
		*/
		if($document_srl = getDocumentSrlByShopCode2($shop_code)){
			if(save2($time, $type, $point, $member_srl, $shop_code, $sales_time, $total_num, $coupon_srl)){
	 			$result['result'] = 'success';
				$result['error'] = 'none';	// notlogin?
				$result['message'] = '적립내역을 기록하였습니다.';
				$result['document_srl'] = $document_srl;
				
				// scrap 하자.
				
				// 찜하기
				$args->document_srl = $document_srl;
				$args->member_srl = $logged_info->member_srl;
				$scrap_output = xmlDocumentScrap($args);
				$result['scrapped'] = $scrap_output->message;
	 		}
			else {
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
		$result['result'] = 'error';
		$result['error'] = 'not_login';	// notlogin?
		$result['message'] = '로그인하지 않았습니다.';
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
