<?PHP
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
	
	$user_id = $_POST['user_id'];				// 3~20
	$password = $_POST['password'];				// < 6 ~ 20 >
	$user_name = $_POST['user_name'];			// 2~40
	$email_address = $_POST['email_address'];	// 1~200 email
	$nick_name = $_POST['nick_name'];			// 2~40

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
			$result['result'] = 'success';
			//$result['message'] = '회원등록이 완료되었습니다.';
			$result['message'] = 'register success!';
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
		else if(strcmp($output->message,'') == 0){
			$result['result'] = 'success';
			$result['message'] = 'register success!';
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
