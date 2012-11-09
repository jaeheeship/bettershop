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

	if($is_logged && ($act == 'getMyStickerList' || $act == 'getMyVotedList' || $act == 'getMyScrappedList'))
	{
		include "opage_xml_model.php";

		$logged_info = Context::get('logged_info');

		$oDocumentModel = &getModel('document');
		$oModuleModel = &getModel('module');
		$oAroundmapControl = &getController('aroundmap');

		$is_xml = true;
		$get_mid = '';
		$thumbnail_width = '160';
		$thumbnail_height = '120';
		$thumbnail_type = 'crop';
		$title_cut_size = '';

		$args->list_count = '10';
//		$args->sort_index = 'today';

		$args->member_srl = $logged_info->member_srl;

		if($_GET['mid'] == 'foryou')
		{
			$args->module_srl = '100';
			$get_mid = 'foryou';
		}
		elseif($_GET['mid'] == 'forme')
		{
			$args->module_srl = '163';
			$get_mid = 'forme';
		}
		else
		{
			$args->module_srl[0] = '100';
			$args->module_srl[1] = '163';
		}

		if($_GET['page'] > 0 && ctype_digit($_GET['page']))
		{
			$args->page = $_GET['page'];
		}
		else
		{
			$args->page = '1';
		}


//		$document_output = $oDocumentModel->getDocumentList($args, false, true, true);

		if($act == 'getMyStickerList')
		{
			$document_output = xmlMyStickerList($args);
		}
		elseif($act == 'getMyVotedList')
		{
			$document_output = xmlMyVotedList($args);
		}
		elseif($act == 'getMyScrappedList')
		{
			$document_output = xmlMyScrappedList($args);
		}

//print_r($document_output);

		$page_navigation = $document_output->page_navigation;
		$document_list = $document_output->data;


		if($args->page > $page_navigation->last_page)
		{
			$args->page = $page_navigation->last_page;
		}



		$items['member_srl'] = $logged_info->member_srl;
		$items['user_id'] = $logged_info->user_id;
		$items['nick_name'] = $logged_info->nick_name;

		$items['total_count'] = $document_output->total_count;
		$items['doc_list_count'] = count($document_list);
		$items['total_page'] = $document_output->total_page;
		$items['page'] = $document_output->page;
		$items['get_page'] = $args->page;
		$items['last_page'] = $page_navigation->last_page;
		$items['prev_page_url'] = '';
		$items['next_page_url'] = '';


		// 이전 페이지
		if($args->page > 1)
		{
	//		$items['prev_page_url'] = getFullUrl('page', $args->page - 1, 'document_srl', '', 'division', $division, 'last_division', $last_division, 'entry', '');

			$get_path = 'page='.($args->page - 1);

			if($act)
			{
				$get_path = 'act='.$act.'&'.$get_path;
			}

			if($get_mid != '')
			{
				$get_path = 'mid='.$get_mid.'&'.$get_path;
			}

			$items['prev_page_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$get_path;
		}

		// 다음 페이지
		if($args->page < $page_navigation->last_page)
		{
	//		$items['next_page_url'] = getFullUrl('page', $args->page + 1, 'document_srl', '', 'division', $division, 'last_division', $last_division, 'entry', '');

			$get_path = 'page='.($args->page + 1);

			if($act)
			{
				$get_path = 'act='.$act.'&'.$get_path;
			}

			if($get_mid != '')
			{
				$get_path = 'mid='.$get_mid.'&'.$get_path;
			}

			$items['next_page_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$get_path;
		}

		$xml_item = '';

		foreach($document_list as $no => $document)
		{
			if(!$document->isNotice())
			{
				$xml_data = '';

				$document_srl = $document->get('document_srl');
				$document_module_srl = $document->get('module_srl');

				$module_output = $oModuleModel->getModuleInfoByModuleSrl($document_module_srl);
				$document_mid = $module_output->mid;

	//			$document_url = getFullUrl('', 'mid', $document_mid, 'document_srl', $document->get('document_srl'));
				$document_url = 'http://'.$_SERVER['HTTP_HOST'].'/opage/opage_xml_for_content.php'.'?'.'mid='.$document_mid.'&'.'document_srl='.$document->get('document_srl');

				$document_member_srl = $document->getMemberSrl();
	//			$document_user_id = $document->getUserID();
				$document_nick_name = $document->getNickName();

				$document_thumbnail = $document->getThumbnail($thumbnail_width, $thumbnail_height, $thumbnail_type, $is_xml);

				if(!$document_thumbnail)
				{
					$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].'/images/none_thumb.png';
				}

				$document_price = $document->getExtraEidValue('price');
				$document_title = $document->getTitle($title_cut_size);

				$query_scrapped = mysql_query("SELECT * FROM xe_member_scrap WHERE document_srl=".$document->document_srl);
				$document_scrapped_count = mysql_num_rows($query_scrapped);

				$document_readed_count = $document->get('readed_count');
				$document_voted_count = $document->get('voted_count');

				if($document_readed_count < 1)
				{
					$document_readed_count = '0';
				}

				if($document_scrapped_count < 1)
				{
					$document_scrapped_count = '0';
				}

				if($document_voted_count < 1)
				{
					$document_voted_count = '0';
				}

				$document_map_output = $oAroundmapControl->setAroundmapValues($document->document_srl);

				$document_is_mysticker = '0';
				$document_is_scrapped = '0';
				$document_is_voted = '0';

				if($is_logged)
				{
					$args->member_srl = $logged_info->member_srl;
					$args->document_srl = $document_srl;

					// 내 스티커
					if($logged_info->member_srl == $document_member_srl)
					{
						$document_is_mysticker = '1';
					}

					// 내가 찜한 스티커
					if(getIsScrappedDocument($args))
					{
						$document_is_scrapped = '1';
					}

					// 내가 지원한 스티커
					if(getIsVotedDocument($args))
					{
						$document_is_voted = '1';
					}
				}

				$result['document_no'] = $no;

				$result['result'] = 'success';
				$result['message'] = 'ok';

				$result['document_srl'] = $document_srl;
				$result['document_url'] = $document_url;

				$result['document_module_srl'] = $document_module_srl;
				$result['document_mid'] = $document_mid;

				$result['document_member_srl'] = $document_member_srl;
	//			$result['document_user_id'] = $document_user_id;
				$result['document_nick_name'] = $document_nick_name;

				$result['document_thumbnail'] = $document_thumbnail;
				$result['document_price'] = $document_price;
				$result['document_title'] = $document_title;

				$result['document_readed_count'] = $document_readed_count;
				$result['document_scrapped_count'] = $document_scrapped_count;
				$result['document_voted_count'] = $document_voted_count;

				$result['document_map_x'] = $document_map_output->data->lat;
				$result['document_map_y'] = $document_map_output->data->lon;

				$result['document_is_mysticker'] = $document_is_mysticker;
				$result['document_is_scrapped'] = $document_is_scrapped;
				$result['document_is_voted'] = $document_is_voted;

				$result['document_end'] = '';

	/*
				$result['document_'] = 
				$result['document_'] = 
				$result['document_'] = 
				$result[''] = 
				$result[''] = 
	*/


				foreach($result as $key => $val)
				{
					if(!$val)
					{
						$val = '';
					}

					$xml_data = $xml_data.'<'.$key.'><![CDATA['.$val.']]></'.$key.'>';
				}

				$xml_item = $xml_item.'
			<item>
				'.$xml_data.'
			</item>';
			}
		}
	}
	elseif(!$is_logged && ($act == 'getMyStickerList' || $act == 'getMyVotedList' || $act == 'getMyScrappedList'))
	{
		$items['error'] = 'not_login';
		$items['message'] = '로그인을 하지 않으셨습니다.';
	}
	else
	{
		$items['error'] = 'error';
		$items['message'] = '잘못된 접근 입니다.';
	}




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
