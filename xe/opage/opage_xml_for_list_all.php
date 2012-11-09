<?PHP
	
	include "opage_xml_model.php";
	
	//header("Content-Type: text/xml; charset=utf-8");

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

	$args->list_count = '50';
	$args->sort_index = 'today';


	$result_query = mysql_query("SELECT module_srl FROM xe_modules WHERE mid='".$_GET['mid']."'");
	if(mysql_num_rows($result_query)>0){
		$row = mysql_fetch_array ($result_query);
		$args->module_srl = $row["module_srl"];
		$get_mid = $_GET['mid'];

	}	
	else
	{
	//	$args->module_srl = '66';
	//	$get_mid = 'notice';
	}

	if($_GET['page'] > 0 && ctype_digit($_GET['page']))
	{
		$args->page = $_GET['page'];
	}
	else
	{
		$args->page = '1';
	}
	
	// j.kim 2012.09.27
	
	if($_GET['act'])
	{
		$act = $_GET['act'];
	}
	
	/*
	if($is_logged)
	{
		$logged_info = Context::get('logged_info');
		$args->member_srl = $logged_info->member_srl;

		$items['member_srl'] = $logged_info->member_srl;
		$items['user_id'] = $logged_info->user_id;
		$items['nick_name'] = $logged_info->nick_name;
	}
	*/
	
	$document_output = $oDocumentModel->getDocumentList($args, false, true, true);
	
	
	if($is_logged && ($act =='getMyScrappedList'))	// 내가 찜한 게시물만 나오기.
	{
		$logged_info = Context::get('logged_info');
		
		$items['member_srl'] = $logged_info->member_srl;
		$items['user_id'] = $logged_info->user_id;
		$items['nick_name'] = $logged_info->nick_name;
		
		// 	shopinfo => 149
		$args->member_srl = $logged_info->member_srl;
		//$args->module_srl = '149';
		$args->page = '1';
		
		$document_output = xmlMyScrappedList($args);
	}
	else 	// 모든 게시물 나오게..
	{
		$document_output = $oDocumentModel->getDocumentList($args, false, true, true);
	}
	
	
	
	unset($document_output->variables);
	$page_navigation = $document_output->page_navigation;
	$document_list = $document_output->data;

//print_r($document_output);

	if($args->page > $page_navigation->last_page)
	{
		$args->page = $page_navigation->last_page;
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
			
			/*
			// 이것도 되고. 밑에 getIsScrappedDocument도 된다. 단 query에 해당 sql 을 추가해야함.
			// SELECT member_srl FROM xe_member_scrap WHERE document_srl='218' AND member_srl='1407'
			$result_query = mysql_query("SELECT member_srl FROM xe_member_scrap WHERE document_srl='".$document_srl."' AND member_srl='".$logged_info->member_srl."'");
			if(mysql_num_rows($result_query)>0){
				//$row = mysql_fetch_array ($result_query);
				$document_is_scrapped = '1';
			}	
			else
			{
				$document_is_scrapped = '0';
			}
			//$result['document_is_scrapped'] = $document_is_scrapped;
			*/
			
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
		
		// j.kim 2012/09/10
		
		$args->document_srl = $document_srl;
		$oDocument = $oDocumentModel->getDocument($args->document_srl, false, true);
		$document = $oDocument->variables;
		
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

		// j.kim
		
		$result['extravar_1']=$oDocument->getExtraValue(1);
		$result['extravar_2']=$oDocument->getExtraValue(2);
		$result['extravar_3']=$oDocument->getExtraValue(3);
		$result['extravar_4']=$oDocument->getExtraValue(4);
		$result['extravar_5']=$oDocument->getExtraValue(5);
		$result['extravar_6']=$oDocument->getExtraValue(6);
		$result['extravar_7']=$oDocument->getExtraValue(7);
		$result['extravar_8']=$oDocument->getExtraValue(8);
		$result['extravar_9']=$oDocument->getExtraValue(9);
		$result['extravar_10']=$oDocument->getExtraValue(10);
		$result['extravar_11']=$oDocument->getExtraValue(11);
		$result['extravar_12']=$oDocument->getExtraValue(12);
		$result['extravar_13']=$oDocument->getExtraValue(13);
		$result['extravar_14']=$oDocument->getExtraValue(14);
		$result['extravar_15']=$oDocument->getExtraValue(15);
		
		
		//$result['document_title'] = 'this is title';
		
		
		//$result['document_content'] = $oDocument->getContent(); 
		//$result['document_contenttext'] = $oDocument->getContentText();
		$result['document_summary'] = $oDocument->getSummary();
		//$result['document_transcontent'] = $oDocument->getTransContent();
		
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
		
		
		$result_query = mysql_query("SELECT member_srl FROM xe_member_scrap WHERE document_srl='".$document_srl."' ORDER BY regdate DESC LIMIT 1");
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

	$oContext->close();

	// 실제 출력부분

	header("Content-Type: text/xml; charset=utf-8");
	echo '<?xml version="1.0" encoding="utf-8"?>';
	echo $xmls;


?>
