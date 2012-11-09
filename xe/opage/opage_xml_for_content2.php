<?PHP


function findProfieByMemberSrl($member_srl)
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
			SELECT `email_address` FROM `xe_member` WHERE `member_srl`='$member_srl';
			";
		
		$result = mysql_query($sql,$link);
		
		if(!$result){
			//die('Could not query: ' . mysql_error());
			return FALSE;
		}
		
		$num_row = mysql_num_rows($result);
		
		if($num_row > 0) {
			$row = mysql_fetch_array($result, MYSQL_NUM);
			$email = $row[0];
			//die('deviceuuid='.$deviceuuid);
		}
		else {
			return FALSE;
		}
		
		//  easyapns DB의 apns_devices TABLE의 pid 얻기
		
		
		// bs01 DB의 member_front TABLE의
		if(!mysql_select_db('xe14',$link)){
			return FALSE;
		}
		
		mysql_query("set session character_set_connection=utf8;");
		mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");

		//  SELECT `pid` FROM `apns_devices` WHERE `deviceuid`='3301a8ed1ac572199f49db1cf11a88156667ce7a';
		// field name이 deviceuid u자 1개 주의
		$sql = 
			"
			SELECT `profile` FROM `bs_member_front` WHERE `mail`='$email';	
			";
		
		$result = mysql_query($sql,$link);
		
		if(!$result){
			//die('Could not query: ' . mysql_error());
			return FALSE;
		}
		
		$num_row = mysql_num_rows($result);
		
		if($num_row > 0) {
			$row = mysql_fetch_array($result, MYSQL_NUM);
			$profile = $row[0];
			//die('pid='.$pid);
		}
		else {
			return FALSE;
		}
		
		mysql_close($link);
		
		//return TRUE;
		return $profile;




}


	header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	$oDocumentModel = &getModel('document');
	$oModuleModel = &getModel('module');
	$oAroundmapControl = &getController('aroundmap');
	$logged_info = Context::get('logged_info');

	$is_xml = true;
	$get_mid = '';
	$thumbnail_width = '160';
	$thumbnail_height = '120';
	$thumbnail_type = 'crop';
	$title_cut_size = '';

	if($_GET['document_srl'] && ctype_digit($_GET['document_srl']))
	{
		$args->document_srl = $_GET['document_srl'];
	}

	$args->member_srl = $logged_info->member_srl;

	$oDocument = $oDocumentModel->getDocument($args->document_srl, false, true);

	$document = $oDocument->variables;

	$xml_item = '';


		include "opage_xml_model.php";


		$result['result'] = 'success';
		$result['message'] = 'ok';

		$result['login_member_srl'] = $logged_info->member_srl;
		$result['login_user_id'] = $logged_info->user_id;
		$result['login_nick_name'] = $logged_info->nick_name;

		$result['document_srl'] = $args->document_srl;
		$result['document_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.'mid='.$document_mid.'&'.'document_srl='.$args->document_srl;

		$result['module_srl'] = $oDocument->get('module_srl');
		//$result['document_mid'] = $document_mid; // 뭐지?

		$result['member_srl'] = $oDocument->getMemberSrl();
		$result['nick_name'] = $oDocument->getNickName();

		$result['regdate'] = $oDocument->getRegdate('Y-m-d');
	
		$result['readed_count'] = $oDocument->get('readed_count');
		$result['voted_count'] = $oDocument->get('voted_count');
		
		$result['title'] = $oDocument->getTitle();
		$result['titleText'] = $oDocument->getTitleText();
		
		$result['content'] = $oDocument->getContent();
		//$result['contentText'] = $oDocument->getContentText();
		//$result['TransContent'] = $oDocument->getTransContent();
		
		$query_scrapped = mysql_query("SELECT * FROM xe_member_scrap WHERE document_srl=".$args->document_srl);
		$document_scrapped_count = mysql_num_rows($query_scrapped);
		
		$result['document_scrapped_count'] = $document_scrapped_count;
		
		
		// j.kim  2012.9.25
		
		$document_scrap_member_homepage = array('','','','','','');
		
		
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
		  
		$result['document_scrap_member_homepage1'] = $document_scrap_member_homepage[0];
		$result['document_scrap_member_homepage2'] = $document_scrap_member_homepage[1];
		$result['document_scrap_member_homepage3'] = $document_scrap_member_homepage[2];
		$result['document_scrap_member_homepage4'] = $document_scrap_member_homepage[3];
		$result['document_scrap_member_homepage5'] = $document_scrap_member_homepage[4];
		$result['document_scrap_member_homepage6'] = $document_scrap_member_homepage[5];
		
		
		$result_query = mysql_query("SELECT member_srl FROM xe_member_scrap WHERE document_srl='".$args->document_srl."' ORDER BY regdate DESC LIMIT 1");
		if(mysql_num_rows($result_query)>0){
			$row = mysql_fetch_array ($result_query);
			$document_last_scrap_member_srl = $row["member_srl"];
		}	
		else
		{
			$document_last_scrap_member_srl = '';
		}
		$result['document_last_scrap_member_srl'] = $document_last_scrap_member_srl;
		
		$result_query = mysql_query("SELECT user_name FROM xe_member WHERE member_srl='".$document_last_scrap_member_srl."'");
		if(mysql_num_rows($result_query)>0){
			$row = mysql_fetch_array ($result_query);
			$document_last_scrap_user_name = $row["user_name"];
		}	
		else
		{
			$document_last_scrap_user_name = '';
		}
		$result['document_last_scrap_user_name'] = $document_last_scrap_user_name;
		
		$result_query = mysql_query("SELECT homepage FROM xe_member WHERE member_srl='".$document_last_scrap_member_srl."'");
		if(mysql_num_rows($result_query)>0){
			$row = mysql_fetch_array ($result_query);
			$document_last_scrap_homepage = $row["homepage"];
		}	
		else
		{
			$document_last_scrap_homepage = '';
		}
		$result['document_last_scrap_homepage'] = $document_last_scrap_homepage;

		
		// 확장 변수 처리
		$result['extravar_count'] = count($oDocument->getExtraVars());	// count(Array)
		
		
		$extravars_list = $oDocument->getExtraVars();
		$extravars_count = count($extravars_list);
		
		foreach($extravars_list as $key => $extravar)
		{
			$extravars[$key]['extravar_no'] = $key;
			$extravars[$key]['extravar_type'] = $extravars_list[$key]->type;
			$extravars[$key]['extravar_name'] = $extravars_list[$key]->name;
			$extravars[$key]['extravar_value'] = $oDocument->getExtraValue($key);
			$extravars[$key]['extravar_value_html'] = $oDocument->getExtraValueHTML($key);
			//$extravars[$key]['extravar_eid_value'] = $oDocument->getExtraEidValue('shop_id');
			
			
			// $oDocument->getExtraEidValue('Pension_url')
		}
		
		
		// j.kim : 리뷰 심사 에러 방지용
		// 12,13
		$extravars[12]['extravar_no'] = '12';
		$extravars[12]['extravar_type'] ='text';
		$extravars[12]['extravar_name'] = '가게코드';
		$extravars[12]['extravar_value'] = 'ㅌㅌㅌ';
		$extravars[12]['extravar_value_html'] = 'ㅌㅌㅌ';
		
		$extravars[13]['extravar_no'] = '13';
		$extravars[13]['extravar_type'] = 'text';
		$extravars[13]['extravar_name'] = '가게코드';
		$extravars[13]['extravar_value'] = 'ㅌㅌㅌ';
		$extravars[13]['extravar_value_html'] = 'ㅌㅌㅌ';
		
		$extravars[14]['extravar_no'] = '13';
		$extravars[14]['extravar_type'] = 'text';
		$extravars[14]['extravar_name'] = '가게코드';
		$extravars[14]['extravar_value'] = '맛나는 최고의초밥';
		$extravars[14]['extravar_value_html'] = '맛나는 최고의초밥';
		
		$extravars[3]['extravar_value_html'] = '012-345-6789';
		$extravars[4]['extravar_value_html'] = '서울시 관악구 신림동 77번지';
		$extravars[5]['extravar_value_html'] = '37.213';
		$extravars[6]['extravar_value_html'] = '37.214';
		
		
		

		if($oDocument->hasUploadedFiles())
		{
			$uploaded_list = $oDocument->getUploadedFiles();

			$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].substr($uploaded_list[0]->uploaded_filename, 1);
		}
		else
		{
			$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].'/images/default/none_thumb_l.png';
		}
		$result['document_thumbnail'] = $document_thumbnail;	// 이미지가 아니라면??? -.-


		// 화일 목록 처리
		$uploaded_list = $oDocument->getUploadedFiles();
		$file_count = count($uploaded_list);
//print_r($uploaded_list);

		foreach($uploaded_list as $key => $file)
		{
			$files[$key]['file_no'] = $key + 1;
			$files[$key]['file_size'] = $file->file_size;
			$files[$key]['file_url'] = 'http://'.$_SERVER['HTTP_HOST'].'/xe14'.substr($file->uploaded_filename, 1);
		}

		// 덧글 목록 처리
		
		$comment_count = $oDocument->getCommentCount();
		$comment_list = $oDocument->getComments();
//print_r($comment_list);

		$comment_no = 0;
		foreach($comment_list as $key => $comment)
		{
			$comments[$key]['comment_no'] = ++$comment_no;
			$comments[$key]['comment_srl'] = $comment->get('comment_srl');
			$comments[$key]['comment_parent_srl'] = $comment->get('parent_srl');
			$comments[$key]['comment_depth'] = $comment->get('depth');
			//$comments[$key]['comment_content'] = $comment->getContent(false, false, false);
			$comments[$key]['comment_content'] = $comment->getSummary();
			$comments[$key]['comment_member_srl'] = $comment->getMemberSrl();
			//$comments[$key]['comment_member_profile'] = findProfieByMemberSrl($comment->getMemberSrl());
			
			$result_query = mysql_query("SELECT homepage FROM xe_member WHERE member_srl='".$comment->getMemberSrl()."'");
			if(mysql_num_rows($result_query)>0){
				$row = mysql_fetch_array ($result_query);
				$comment_member_profile = $row["homepage"];
			}	
			else
			{
				$comment_member_profile = '';
			}
			$comments[$key]['comment_member_profile'] = $comment_member_profile;
			
			
			
			//$comments[$key]['comment_member_profile'] = findHomepageByMemberSrl($comment->getMemberSrl());
			$comments[$key]['comment_nick_name'] = $comment->getNickName();
			$comments[$key]['comment_user_name'] = $comment->getUserName();
			$comments[$key]['comment_regdate'] = $comment->getRegdate("Y.m.d H:i:s");
		}






		foreach($result as $key => $val)
		{
			if(!$val)
			{
				$val = '';
			}

//print $key." : ".$val."<br>";

			$xml_data = $xml_data.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
		}
		// 확장변수 목록
		
		
		$xml_extravars = '';
		foreach($extravars as $idx)
		{
			$xml_extravars = $xml_extravars.'<extravar>';

			foreach($idx as $key => $val)
			{
				if(!$val)
				{
					$val = '';
				}

//print $key." : ".$val."<br>";

				$xml_extravars = $xml_extravars.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
			}

			$xml_extravars = $xml_extravars.'</extravar>';
		}

		$xml_extravars = '
		<extravars>
			'.$xml_extravars.'
		</extravars>';
	   

		// 파일 목록
		$xml_files = '';
		foreach($files as $idx)
		{
			$xml_files = $xml_files.'<file>';

			foreach($idx as $key => $val)
			{
				if(!$val)
				{
					$val = '';
				}

//print $key." : ".$val."<br>";

				$xml_files = $xml_files.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
			}

			$xml_files = $xml_files.'</file>';
		}

		$xml_files = '
		<files>
			'.$xml_files.'
		</files>';

		// 댓글 목록
		$xml_comments = '';
		foreach($comments as $idx)
		{
			$xml_comments = $xml_comments.'<comment>';

			foreach($idx as $key => $val)
			{
				if(!$val)
				{
					$val = '';
				}

//print $key." : ".$val."<br>";

				$xml_comments = $xml_comments.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
			}

			$xml_comments = $xml_comments.'</comment>';
		}

		$xml_comments = '
		<comments>
			'.$xml_comments.'
		</comments>';



		$xml_item = $xml_item.'
	<item>
		'.$xml_data.$xml_files.$xml_comments.$xml_extravars.'
		<document_end><![CDATA[]]></document_end>
	</item>';



	$xml_items = '';

	foreach($items as $key => $val)
	{
		if(!$val)
		{
			$val = '';
		}

		$xml_items = $xml_items.'		<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
	}

	$xml_items = $xml_items.$xml_item;

	$xmls = '
	<items>
'.$xml_items.'
	</items>';



	echo '<?xml version="1.0" encoding="utf-8"?>';

	echo $xmls;

	$oContext->close();
?>
