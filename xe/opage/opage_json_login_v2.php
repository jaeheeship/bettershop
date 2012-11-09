<?PHP


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
				
				$info['error'] = 'error';
				$info['message'] = '로그인에 실패하였습니다. ('.$output->message.')';
				
				$result = 'failure';
				$error = 'cannot_login';
				$message = $info['message'];
			}
			else
			{
				$logged_info = Context::get('logged_info');

				$info['error'] = 'success';
				$info['message'] = $logged_info->nick_name.'님 환영합니다.';
				$info['member_srl'] = $logged_info->member_srl;
				$info['user_id'] = $logged_info->user_id;
				$info['user_name'] = $logged_info->user_name;
				$info['nick_name'] = $logged_info->nick_name;
				
				$result = 'success';
				$error = 'none';
				$message = $info['message'];
			}
		}
		else
		{
			$info['error'] = 'error';
			$info['message'] = '로그인에 실패하였습니다. (입력된 정보가 없습니다.)';
			
			$result = 'failure';
			$error = 'id_pass_error';
			$message = $info['message'];
		}
	}
	else
	{
		$logged_info = Context::get('logged_info');

		$info['error'] = 'logged';
		//$info['message'] = '이미 로그인 하였습니다.';
		$info['message'] = $logged_info->nick_name.'님 환영합니다.';
		$info['user_id'] = $logged_info->user_id;
		$info['user_name'] = $logged_info->user_name;
		$info['nick_name'] = $logged_info->nick_name;
		
		$result = 'success';
		$error = 'logged';
		$message = $info['message'];
	}

	$control = array('result' => $result, 'error' => $error, 'message' => $message);
	
	$data = array('info' => $info );

	$response = array('control' => $control, 'data' =>  $data);
	
	header('Content-type: application/json');
	
	echo json_encode($response);

	$oContext->close();
?>
