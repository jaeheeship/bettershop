<?PHP

	function procMemberInsertBSDB($from, $name, $user_id, $pass, $mail, $user_tel, $profile, $sex, $birth)     
	{	
		$link = mysql_connect('localhost', 'root', 'root');
		if (!$link) {
			//die('Could not connect: ' . mysql_error());
			return FALSE;
		}
		//echo 'Connected successfully';
		
		
		if(!mysql_select_db('xe14',$link)){
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
		/*
		$sql = 
			"
			INSERT INTO `member_front` (`from`, `name`, `user_id`, `pass`, `mail`, `user_tel`, `profile`, `sex`, `birth`) VALUES
			('$from', '$name', '$user_id', '$pass', '$mail', '$user_tel', '$profile','$sex','$birth');
			";	
		*/
		
		/*
		$sql = 
			"
			INSERT INTO `member_front` (`from`, `name`, `user_id`, `pass`, `mail`, `user_tel`, `profile`, `sex`, `birth`) VALUES
			('"+$from+"', '"+$name+"', '"+$user_id+"', '"+$pass+"', '"+$mail+"', '"+$user_tel+"', '"+$profile+"','"+$sex+"','"+$birth+"');
			
			";
		*/
		
		$sql = 
			"
			SELECT `user_id` FROM `bs_member_front` WHERE `
			('$from', '$name', '$user_id', '$pass', '$mail', '$user_tel', '$profile','$sex','$birth');
			";	
		
		
		$db_result = mysql_query($sql,$link);
		
		if(!db_result){
			//die('Could not query: ' . mysql_error());
			return FALSE;
		}
		
		
		mysql_close($link);
		
		return $user_id;
	}



	header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	$result = Array();
	$xml_data = '';
	$xmls = '';
	
	// common
	
	$sns_type = $_POST['sns_type'];	// Facebook or Twitter or Bettershop 대문자 시작 주의 
	
	// facebook & twitter
	
	//$sns_id = $_POST['sns_id'];
	//--> sns_id를 통해서...bs01 DB의 member_front TABLE 에서 user_id / pass 를 가져온다. (여기서 user_id = pass 로 설정되어 있다. 변경가능)
	
	// bettershop
	
	// $email id로 받아서. 
	
	if($sns_type == 'Facebook' or $sns_type == 'Twitter')
	{
		//================================
		$user_id = trim($_POST[user_id]);
		$user_pass = trim($_POST[user_pass]);
		
	}
	else	// Bettershop 일경우
	{
		$user_id = trim($_POST[user_id]);
		$user_pass = trim($_POST[user_pass]);
	}
	

	if(!Context::get('is_logged'))
	{
		if($_POST['user_id'] && $_POST['user_pass'])
		{
			$oMemberController = &getController('member');

			//$user_id = trim($_POST[user_id]);
			//$user_pass = trim($_POST[user_pass]);

			$output = $oMemberController->procMemberLogin($user_id, $user_pass);

			if($output->error)
			{
				$result['error'] = 'error';
				$result['message'] = '로그인에 실패하였습니다. ('.$output->message.')';
			}
			else
			{
				$logged_info = Context::get('logged_info');

				$result['error'] = 'success';
				$result['message'] = $logged_info->nick_name.'님 환영합니다.';
				$result['member_srl'] = $logged_info->member_srl;
				$result['user_id'] = $logged_info->user_id;
				$result['user_name'] = $logged_info->user_name;
				$result['nick_name'] = $logged_info->nick_name;
			}
		}
		else
		{
			$result['error'] = 'error';
			$result['message'] = '로그인에 실패하였습니다. (입력된 정보가 없습니다.)';
		}
	}
	else
	{
		$logged_info = Context::get('logged_info');

		$result['error'] = 'logged';
		$result['message'] = '이미 로그인 하였습니다.';
		$result['user_id'] = $logged_info->user_id;
		$result['user_name'] = $logged_info->user_name;
		$result['nick_name'] = $logged_info->nick_name;
	}

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
