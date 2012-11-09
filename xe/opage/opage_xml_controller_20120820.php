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

	if($is_logged && ($act == 'dispLoginCheck' || $act == 'dispMemberLogout' || $act == 'procDocumentVoteUp' || $act == 'procDocumentVoteUpCancel' || $act == 'procMemberScrapDocument'))
	{
		include "opage_xml_model.php";

		$logged_info = Context::get('logged_info');

		$args->member_srl = $logged_info->member_srl;

		if($_GET['document_srl'])
		{
			$args->document_srl = $_GET['document_srl'];
		}

		// 로그인한 사용자의 해당 스티커 지원 여부 확인
		if($act == 'procDocumentVoteUp' || $act == 'procDocumentVoteUpCancel')
		{
			$output = getIsVotedDocument($args);

			if($output == 0 && $act == 'procDocumentVoteUp')
			{
				$is_voted = 'vote_up';
			}
			elseif($output > 0 && $act == 'procDocumentVoteUpCancel')
			{
				$is_voted = 'vote_cancel';
			}
			else
			{
				$is_voted = 'no';
			}
		}
		else
		{
			$is_voted = null;
		}



		if($act == 'dispLoginCheck')	// 로그인 확인
		{
			$result['error'] = 'logged';
			$result['message'] = '로그인 되어 있습니다.';
			$result['member_srl'] = $logged_info->member_srl;
			$result['user_id'] = $logged_info->user_id;
		}
		elseif($act == 'dispMemberLogout')	// 로그아웃
		{
			$output = xmlMemberLogout();

			$result['error'] = 'success';
			$result['message'] = $logged_info->nick_name.'님이 로그아웃 하였습니다.';
			$result['member_srl'] = $logged_info->member_srl;
			$result['user_id'] = $logged_info->user_id;
		}
		elseif($is_voted && $act == 'procDocumentVoteUp' && $args->document_srl)	// 지원 하기
		{
			if($is_voted == 'vote_up')
			{
				$output = xmlDocumentVoteUp($args);

				$result['error'] = 'success';
				$result['message'] = '해당 스티커에 지원 하셨습니다..';
			}
			else
			{
				$result['error'] = 'error';
				$result['message'] = '중복으로 지원 하실 수 없습니다.';
			}

			$result['member_srl'] = $logged_info->member_srl;
			$result['user_id'] = $logged_info->user_id;
			$result['document_srl'] = $args->document_srl;
		}
		elseif($is_voted && $act == 'procDocumentVoteUpCancel' && $args->document_srl)	// 지원 취소하기
		{
			if($is_voted == 'vote_cancel')
			{
				$output = xmlDocumentVoteUpCancel($args);

				$result['error'] = 'success';
				$result['message'] = '해당 스티커 지원을 취소 하셨습니다.';
			}
			else
			{
				$result['error'] = 'error';
				$result['message'] = '지원을 하지 않으셔서 취소 할 수 없습니다.';
			}

			$result['member_srl'] = $logged_info->member_srl;
			$result['user_id'] = $logged_info->user_id;
			$result['document_srl'] = $args->document_srl;
		}
		elseif($act == 'procMemberScrapDocument' && $args->document_srl)	// 찜 하기, 찜 취소 하기
		{
			$output_scrap_prev = getIsScrappedDocument($args);

			$output = xmlDocumentScrap($args);

			$output_scrap_next = getIsScrappedDocument($args);

			$is_scrapped = $output_scrap_next;

			if($output_scrap_prev == $is_scrapped)
			{
				$result['error'] = 'error';

				if($is_scrapped == 1)
				{
					$result['message'] = '찜 취소 하기에 실패 하였습니다.';
				}
				else
				{
					$result['message'] = '찜 하기에 실패 하였습니다.';
				}
			}
			elseif($is_scrapped == 1)
			{
				$result['error'] = 'success';
				$result['message'] = '해당 스티커를 찜했습니다.';
			}
			elseif($is_scrapped == 0)
			{
				$result['error'] = 'success';
				$result['message'] = '해당 스티커의 찜을 해제했습니다.';
			}

			$result['member_srl'] = $logged_info->member_srl;
			$result['user_id'] = $logged_info->user_id;
			$result['document_srl'] = $args->document_srl;
			$result['is_scrapped'] = $is_scrapped;
		}
	}
	elseif(!$is_logged && ($act == 'dispLoginCheck' || $act == 'dispMemberLogout' || $act == 'procDocumentVoteUp' || $act == 'procDocumentVoteUpCancel' || $act == 'procMemberScrapDocument'))
	{
		$result['error'] = 'not_login';
		$result['message'] = '로그인을 하지 않으셨습니다.';
	}
	else
	{
		$result['error'] = 'error';
		$result['message'] = '잘못된 접근 입니다.';
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
