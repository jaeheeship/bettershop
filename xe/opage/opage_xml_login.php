<?PHP
	header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	$result = Array();
	$xml_data = '';
	$xmls = '';

	if(!Context::get('is_logged'))
	{
		if($_POST['user_id'] && $_POST['user_pass'])
		{
			$oMemberController = &getController('member');

			$user_id = trim($_POST[user_id]);
			$user_pass = trim($_POST[user_pass]);

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
