<?PHP
	header("Content-Type: text/xml; charset=utf-8");

	define('__ZBXE__', true);
	require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	$is_logged = Context::get('is_logged');

	$oDocumentModel = &getModel('document');
	$oModuleModel = &getModel('module');
	$oAroundmapControl = &getController('aroundmap');

	$is_xml = true;
	$get_mid = '';
	$thumbnail_width = '100';
	$thumbnail_height = '100';
	$thumbnail_type = 'crop';
	$title_cut_size = '';

	$args->list_count = '10';
	$args->sort_index = 'today';

	if($_GET['mid'] == 'notice')
	{
		$args->module_srl = '66';
		$get_mid = 'notice';
	}
	elseif($_GET['mid'] == 'shopinfo')
	{
		$args->module_srl = '149';
		$get_mid = 'shopinfo';
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

	$document_output = $oDocumentModel->getDocumentList($args, false, true, true);
	unset($document_output->variables);
	$page_navigation = $document_output->page_navigation;
	$document_list = $document_output->data;

//print_r($document_output);

	if($args->page > $page_navigation->last_page)
	{
		$args->page = $page_navigation->last_page;
	}

	if($is_logged)
	{
		include "opage_xml_model.php";

		$logged_info = Context::get('logged_info');

		$items['member_srl'] = $logged_info->member_srl;
		$items['user_id'] = $logged_info->user_id;
		$items['nick_name'] = $logged_info->nick_name;
	}

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

		if($get_mid != '')
		{
			$get_path = 'mid='.$get_mid.'&'.$get_path;
		}

		$items['next_page_url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$get_path;
	}

	$xml_item = '';
	
	

	
	foreach($document_list as $no => $document)
	{
	
		$xml_data='';
	
		$document_srl = $document->get('document_srl');
		$document_module_srl = $document->get('module_srl');
	
		$module_output = $oModuleModel->getModuleInfoByModuleSrl($document_module_srl);
		$document_mid = $module_output->mid;
	
		//$document_url = 'http://'.$_SERVER['HTTP_HOST'].'/opage/opage_xml_for_content.php'.'?'.'mid='.$document_mid.'&'.'document_srl='.$document->get('document_srl');
	
		//$document_member_srl = $document->getMemberSrl();
		//$document_nick_name = $document->getNickName();
		
		$document_title = $document->getTitle($title_cut_size);
		$document_srl = $document->get('document_srl');
		$document_module_srl = $document->get('module_srl');
		$document_url = 'http://'.$_SERVER['HTTP_HOST'].'/xe14/opage/opage_xml_for_content.php'.'?'.'mid='.$document_mid.'&'.'document_srl='.$document->get('document_srl');
		$document_member_srl = $document->getMemberSrl();
		$document_nick_name = $document->getNickName();
		
		$document_readed_count = $document->get('readed_count');
			$query_scrapped = mysql_query("SELECT * FROM xe_member_scrap WHERE document_srl=".$document->document_srl);
		$document_scrapped_count = mysql_num_rows($query_scrapped);
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
		
		$document_thumbnail = $document->getThumbnail2($thumbnail_width, $thumbnail_height, $thumbnail_type);

		if(!$document_thumbnail)
		{
			$document_thumbnail = 'http://'.$_SERVER['HTTP_HOST'].'/xe14/images/none_thumb.png';
		}
		
		//$result['document_title'] = 'this is title';
		
		$result['document_title'] = $document_title;
		$result['document_srl'] = $document_srl;
		$result['document_url'] = $document_url;
		$result['document_module_srl'] = $document_module_srl;
		$result['document_member_srl'] = $document_member_srl;
		$result['document_nick_name'] = $document_nick_name;
		
		$result['document_readed_count'] = $document_readed_count;
		$result['document_scrapped_count'] = $document_scrapped_count;
		$result['document_voted_count'] = $document_voted_count;
		
		$result['document_is_mysticker'] = $document_is_mysticker;
		$result['document_is_scrapped'] = $document_is_scrapped;
		$result['document_is_voted'] = $document_is_voted;
		$result['document_thumbnail'] = $document_thumbnail;
		
		$result['document_end'] = '';
		
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
