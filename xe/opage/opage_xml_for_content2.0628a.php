<?PHP
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

		
		// 확장 변수 처리
		$result['extravar_count'] = count($oDocument->getExtraVars());	// count(Array)
		
		
		$extravars_list = $oDocument->getExtraVars();
		$extravars_count = count($extravars_list);
		
		foreach($extravars_list as $key => $extravar)
		{
			$extravars[$key]['extravar_no'] = $key;
			$extravars[$key]['extravar_value'] = $oDocument->getExtraValue($key);
			$extravars[$key]['extravar_value_html'] = $oDocument->getExtraValueHTML($key);
			//$extravars[$key]['extravar_key'] = $extravars_list[$key];
		}
		
		

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
			$comments[$key]['comment_content'] = $comment->getContent(false, false, false);
			$comments[$key]['comment_member_srl'] = $comment->getMemberSrl();
			$comments[$key]['comment_nick_name'] = $comment->getNickName();
			$comments[$key]['comment_regdate'] = $comment->getRegdate("Y.m.d");
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
