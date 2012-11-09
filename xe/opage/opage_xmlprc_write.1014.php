<?php

	header("Content-Type: text/xml; charset=utf-8");
	
    //if(!defined("__ZBXE__")) exit();
    define('__ZBXE__', true);
    
    require('../config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();

	// act가 api가 아니면 그냥 리턴~
    //if($_REQUEST['act']!='api') return;

    // 관련 func 파일 읽음
    //require_once('./addons/blogapi/blogapi.func.php');
	//require_once('blogapi.func.php');
	include "blogapi.func.php";
	
	//$oXmlParser = new XmlParser();
	
    // xmlprc 파싱
    // 요청된 xmlrpc를 파싱
    $oXmlParser = new XmlParser();
    $xmlDoc = $oXmlParser->parse();

    $method_name = $xmlDoc->methodcall->methodname->body;
    $params = $xmlDoc->methodcall->params->param;
    if($params && !is_array($params)) $params = array($params);

    // user_id, password를 구해서 로그인 시도
    $params_0 = trim($params[0]->value->string->body);
    $params_1 = trim($params[1]->value->string->body);
    $params_2 = trim($params[2]->value->string->body);
    $params_3 = trim($params[3]->value->string->body);
    $params_4 = trim($params[4]->value->string->body);
    $params_5 = trim($params[5]->value->string->body);
    
    //if(!$user_id) $user_id = "null";
    //if(!$password) $password = "null";


	
/*    
    echo '<?xml version="1.0"?>
<items>
	<item>
		<document_title>
			this_is_title
		</document_title>
		<user_id>'.$user_id.'
		</user_id>
	</item>
	<item>
		<document_title>
			this_is_title_two
		</document_title>
	</item>
</items>
    '
  
  */
    
	$document_srl = $params_0;
	$user_id = $params_1;
	// 글쓰기 권한 체크 (권한명의 경우 약속이 필요할듯..)

	// 임시 파일 저장 장소 지정
	$tmp_uploaded_path = sprintf('./files/cache/blogapi/%s/%s/', $document_srl, $user_id);
	$uploaded_target_path = sprintf('/files/cache/blogapi/%s/%s/', $document_srl, $user_id);

	switch($method_name) {

		// 파일 업로드
		case 'metaWeblog.newMediaObject' :
		
				$oFileModel = &getModel('file');
		
				$fileinfo = $params[3]->value->struct->member;	// dictionary
				foreach($fileinfo as $key => $val) {
					$nodename = $val->name->body;
					if($nodename == 'bits') $filedata = base64_decode($val->value->string->body);
					elseif($nodename == 'name') $filename = $val->value->string->body;
				}
		
				$tmp_arr = explode('/',$filename);
				$filename = array_pop($tmp_arr);

				if(!is_dir($tmp_uploaded_path)) FileHandler::makeDir($tmp_uploaded_path);

				$target_filename = sprintf('%s%s', $tmp_uploaded_path, $filename);
				FileHandler::writeFile($target_filename, $filedata);
		
		
		    echo '
<?xml version="1.0"?>
<items>
	<item>
		<method_name>'.$method_name.'</method_name>
		<params_0>'.$params_0.'</params_0>
		<params_1>'.$params_1.'</params_1>
		<params_2>'.$params_2.'</params_2>
		<params_3>'.$params_3.'</params_3>
		<return1>'.$filename.'</return1>
		<return2>'.$target_filename.'</return2>
	</item>
	<item>
		<document_title>
			this_is_title_two
		</document_title>
	</item>
</items>
	';

			break;

		// 글작성
		case 'metaWeblog.newPost' :
		
				$info = $params[3];
				// Get information of post, title, and category
				for($i=0;$i<count($info->value->struct->member);$i++) {
					$val = $info->value->struct->member[$i];
					switch($val->name->body) {
						case 'title' :
								$title = $val->value->string->body;
							break;
						case 'description' :
								$content = $val->value->string->body;
							break;
					}

				}
		
			
			$document_srl = $params_4;
			$module_srl = $params_5;
			
			$oMemberController = &getController('member');
			
			$user_id2 = '371619526';
			$password2 = '371619526';
			
			$output2 = $oMemberController->doLogin($user_id2, $password2);
			
			if(!$output2->toBool()) {
				$login_error = 'error';
			}
			else{
				$login_error = 'none';
			}
		
			// 댓글 쓰기
			
			$arg->module_srl = $module_srl;		// 게시판 모듈
			$arg->document_srl = $document_srl;	// 대상 글
			$arg->content = $content; 			// 내용
			$arg->uploaded_count = 2;
			
			$oCommentController = &getController('comment');
			$output = $oCommentController->insertComment($arg);

	
			if(strcmp($output->message,'success') == 0){ // 성공했을때
	
				$comment_srl = $output->get('comment_srl');
				
				
				// 미리 올려둔 첨부화일 정리.
				$file_list = FileHandler::readDir($tmp_uploaded_path);
				$file_count = count($file_list);
				
				$return_count = 0;
				if($file_count) {
					$oFileController = &getController('file');
					for($i=0;$i<$file_count;$i++) {
						$file_info['tmp_name'] = sprintf('%s%s', $tmp_uploaded_path, $file_list[$i]);
						$file_info['name'] = $file_list[$i];
						
						//function insertFileBS($file_info, $module_srl, $upload_target_srl, $download_count = 0, $manual_insert = false, $member_srl) {
						//$fileOutput = $oFileController->insertFileBS($file_info, $module_srl, $comment_srl, 0, true, $member_srl);
						//$uploaded_filename = $fileOutput->get('uploaded_filename');
						//$source_filename = $fileOutput->get('source_filename');
						//$obj->content = str_replace($uploaded_target_path . $source_filename, sprintf('/files/attach/images/%s/%s%s', $this->module_srl, getNumberingPath($document_srl,3), $uploaded_filename), $obj->content);
						
						$return_value = $oFileController->insertFileBS2($file_info, $module_srl, $comment_srl, 0, true, $member_srl);
						if($return_value) $return_count += 1;
						
						
						/*
						
						echo '<file_info>'.$file_info['tmp_name'].'</file_info>';
						echo '<file_info>'.$file_info['name'].'</file_info>';
						
						$path = sprintf("./files/attach/images/%s/%s", $module_srl,getNumberingPath($comment_srl,3));
						
						echo '<path>'.$path.'</path>';
						
						// special character to '_'
						// change to md5 file name. because window php bug. window php is not recognize unicode character file name - by cherryfilter
						$ext = substr(strrchr($file_info['name'],'.'),1);
						//$_filename = preg_replace('/[#$&*?+%"\']/', '_', $file_info['name']);
						$_filename = md5(crypt(rand(1000000,900000), rand(0,100))).'.'.$ext;
						$filename  = $path.$_filename;
						$idx = 1;
						while(file_exists($filename)) {
							$filename = $path.preg_replace('/\.([a-z0-9]+)$/i','_'.$idx.'.$1',$_filename);
							$idx++;
						}
						$direct_download = 'Y';
						
						print '<filename>'.$filename.'</filename>';
						
						if(FileHandler::makeDir($path)) {
							print '<return>success</return>';
						}
						else {
							print '<return>fail</return>';
						}
						
						if(!is_dir($path)) FileHandler::makeDir($path);
						
						
						// 파일 이동
						
						print '<from>'.$file_info['tmp_name'].'</from>';
						print '<to>'.$filename.'</to>';


						copy('/var/www/html/xe14/'.$file_info['tmp_name'], '/var/www/html/xe14/'.$filename);
						
						*/
					}
					//$obj->uploaded_count = $file_count;
				}
			}
		

echo '
<?xml version="1.0"?>
<items>
	<item>
		<method_name>'.$method_name.'</method_name>
		<params_0>'.$params_0.'</params_0>
		<params_1>'.$params_1.'</params_1>
		<params_2>'.$params_2.'</params_2>
		<params_3>'.$params_3.'</params_3>
		<params_4>'.$params_4.'</params_4>
		<params_5>'.$params_5.'</params_5>
		<return1>'.$tmp_uploaded_path.'</return1>
		<return2>'.$uploaded_target_path.'</return2>
		<title>'.$title.'</title>
		<content>'.$content.'</content>
		<document_srl>'.$document_srl.'</document_srl>
		<module_srl>'.$module_srl.'</module_srl>
		<file_count>'.$file_count.'</file_count>
		<comment_srl>'.$comment_srl.'</comment_srl>
		<login_error>'.$login_error.'</login_error>
		<file_list>'.$file_list[0].'</file_list>
		<uploaded_filename>'.$uploaded_filename.'</uploaded_filename>
		<return_count>'.$return_count.'</return_count>
	</item>
</items>
	';



			break;
		// 글 수정
		case 'metaWeblog.editPost' :

			break;

		// 글삭제
		case 'blogger.deletePost' :

			break;

		// 최신글 받기
		case 'metaWeblog.getRecentPosts' :
		   
			break;

		// 아무런 요청이 없을 경우 RSD 출력
		default :


	}

    
    
    
?>
