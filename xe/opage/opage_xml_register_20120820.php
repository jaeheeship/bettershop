<?PHP

	function procMemberInsertBSDB($from, $name, $user_id, $password, $mail, $user_tel, $profile, $sex, $birth, $deviceuuid)     
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
		$sql = 
			"
			INSERT INTO `bs_member_front` (`from`, `name`, `user_id`, `pass`, `mail`, `user_tel`, `profile`, `sex`, `birth`, `deviceuuid`) VALUES
			('$from', '$name', '$user_id', '$password', '$mail', '$user_tel', '$profile','$sex','$birth','$deviceuuid');
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
			return FALSE;
		}
		
		
		mysql_close($link);
		
		return TRUE;
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
// <-- testing
/*
	$result['error'] = 'success';
	$result['message'] = 'this is test message';
*/	
// testing -->
//------

	$valid = true;	// true/false
	// 인자의 유효성 체크
	
	/*
	
	from = sns_type;
    name = sns_name;
    user_id = sns_id;
    pass = @"";
    mail = @"";
    user_tel = @"";
    profile = sns_picture;
    sex = sns_sex;
    birth = dtTextField.text;
    
    */
	
	
	$from = trim($_POST['from']);
    $name = trim($_POST['name']);
    $user_id = trim($_POST['user_id']);
    $password = $_POST['pass'];
    $mail = $_POST['mail'];
    $user_tel = $_POST['user_tel'];
    $profile = $_POST['profile'];
    $homepage = $_POST['profile'];
    $sex = $_POST['sex'];
    $birth = $_POST['birth'];
	$deviceuuid = $_POST['deviceuuid'];
	
	/*
	$from = 'Facebook';
	$name = '박찬호';
	$user_id = '100000111111';
	$pass = 'Facebook';
	$mail = '1111100000@facebook.com';
	$user_tel = '01075800889';
	$profile = 'http://www.bettershop.co.kr/image.jpg';
	$sex = 'male';
	$birth = '2012. 8. 20';
	*/
	
	/*
	$user_id = $_POST['user_id'];				// 3~20
	$password = $_POST['password'];				// < 6 ~ 20 >
	$user_name = $_POST['user_name'];			// 2~40
	$email_address = $_POST['email_address'];	// 1~200 email
	$nick_name = $_POST['nick_name'];			// 2~40
	*/
	
	/*
	$user_id = $user_id_xxx;				// 3~20
	$password = $pass;				// < 6 ~ 20 >
	$user_name = $name;			// 2~40
	$email_address = $mail;	// 1~200 email
	$nick_name = $name;			// 2~40
	
	*/
	
	// for xe14 register
	/*
	$user_id = $user_id_xxx;				// 3~20
	$password = $pass;				// < 6 ~ 20 >
	$user_name = $name;			// 2~40
	$email_address = $mail;	// 1~200 email
	$nick_name = $name;			// 2~40
	*/
	
	/*
	$user_id = $_POST['user_id'];				// 3~20
	$password = $_POST['pass'];				// < 6 ~ 20 >
	$user_name = $_POST['name'];			// 2~40
	$email_address = $_POST['mail'];	// 1~200 email
	$nick_name = $_POST['name'];			// 2~40
	*/
/*
	if( mb_strlen($user_id, "UTF-8") < 3 or mb_strlen($user_id, "UTF-8") > 20 ) $valid = false;
	if( mb_strlen($password, "UTF-8") < 6 or mb_strlen($password, "UTF-8") > 20 ) $valid = false; 
	if( mb_strlen($user_name, "UTF-8") < 2 or mb_strlen($user_name, "UTF-8") > 40 ) $valid = false;
	if( mb_strlen($email_address, "UTF-8") < 1 or mb_strlen($email_address, "UTF-8") > 200 ) $valid = false;
	if( mb_strlen($nick_name, "UTF-8") < 2 or mb_strlen($nick_name, "UTF-8") > 40 ) $valid = false;

*/	
	//$valid=false;
	
	if($valid){

		$oMemberController = &getController('member');
	
		//$output = $oMemberController->procMemberInsertApp();
		$output = $oMemberController->procMemberInsert();
	
		if(strcmp($output->message,'success') == 0){
		/*
			// bettershop db에 넣기.. db : bs01, table : member_front 
			$test_arg = 'FFacebook';
			
			if(procMemberInsertBSDB($test_arg)){
				$result['result'] = 'success';
				//$result['message'] = '회원등록이 완료되었습니다.';
				$result['message'] = 'register success!';
			}	
			else {
				$result['result'] = 'error';
				$result['message'] = 'bettershop db error!';
			}
		*/
		}
		else if(strcmp($output->message,'msg_exists_user_id') == 0){
			$result['result'] = 'error';
			//$result['message'] = '회원아이디가 중복되어, 회원등록이 실패하였습니다.';
			$result['message'] = 'msg_exists_user_id';
		}
		else if(strcmp($output->message,'msg_exists_nick_name') == 0){
			$result['result'] = 'error';
			//$result['message'] = '별명(닉네임)이 중복되어, 회원등록이 실패하였습니다.';
			$result['message'] = 'msg_exists_nick_name';
		}
		else if(strcmp($output->message,'msg_exists_email_address') == 0){
			$result['result'] = 'error';
			//$result['message'] = '이메일주소가 중복되어, 회원등록이 실패하였습니다.';
			$result['message'] = 'msg_exists_email_address';
		}
		else if(strcmp($output->message,'success_registed') == 0){
			$result['result'] = 'success';
			$result['message'] = 'success_registed';
		}
		else if(strcmp($output->message,'denied_user_id') == 0){
			$result['result'] = 'error';
			$result['message'] = 'denied_user_id';
		}
		else if(strcmp($output->message,'') == 0){		// xe 1.4 에서 응답이 없다.
			
			if(procMemberInsertBSDB($from, $name, $user_id, $password, $mail, $user_tel, $profile, $sex, $birth, $deviceuuid)){
				$result['result'] = 'success';
				//$result['message'] = '회원등록이 완료되었습니다.';
				$result['message'] = 'register success!?!';
				
				$logged_info = Context::get('logged_info');

				$result['member_srl'] = $logged_info->member_srl;
				$result['user_id'] = $logged_info->user_id;
				$result['user_name'] = $logged_info->user_name;
				$result['nick_name'] = $logged_info->nick_name;
			
				
			}	
			else {
				$result['result'] = 'error';
				$result['message'] = 'bettershop db error!';
			}
		}
		else {
			//$result['error'] = 'success';
			//$result['message'] = 'register success!';
		
			$result['result'] = 'unknown';
			$result['message'] = 'exception!('.$output->message.')';
		}

	} // end if
	else {
		$result['result'] = 'error';
		$result['message'] = 'post data is invalid '.mb_strlen($user_id, "UTF-8").'/'.mb_strlen($password, "UTF-8").'/'.mb_strlen($user_name, "UTF-8").'/'.mb_strlen($email_address, "UTF-8").'/'.mb_strlen($nick_name, "UTF-8");	
	}
	
	$result['from'] = $from;
	$result['name'] = $name;
	$result['user_id'] = $user_id;

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
