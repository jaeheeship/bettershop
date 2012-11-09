<?PHP

	// 사용자 로그아웃
	function xmlMemberLogout()	// member_srl 필요
	{
		$oMemberController = &getController('member');
		$result = $oMemberController->procMemberLogout();

		return $result;
	}

	// 지원 확인
	function getIsVotedDocument($args)	// member_srl, document_srl 필요
	{
		$result = executeQuery('document.getIsVotedDocument', $args);

		if(!$result->toBool())
		{
			return false;
		}

		return $result->data->count;
	}

	// 찜 확인
	function getIsScrappedDocument($args)	// member_srl, document_srl 필요
	{
		$result = executeQuery('document.getIsScrappedDocument', $args);

		if(!$result->toBool())
		{
			return false;
		}

		return $result->data->count;
	}

	// 지원 하기
	function xmlDocumentVoteUp($args)	// member_srl, document_srl 필요
	{
		$oDocumentController = &getController('document');

		Context::set('target_srl', $args->document_srl);

		$result = $oDocumentController->procDocumentVoteUp();

		return $result;
	}

	// 지원 취소 하기
	function xmlDocumentVoteUpCancel($args)	// member_srl, document_srl 필요
	{
		$oDocumentController = &getController('document');

		Context::set('target_srl', $args->document_srl);

		$result = $oDocumentController->procDocumentVoteUpCancel();

		return $result;
	}

	// 찜 하기, 찜 취소 하기
	function xmlDocumentScrap($args)	// member_srl, document_srl 필요
	{
		$oMemberController = &getController('member');

		Context::set('target_srl', $args->document_srl);

		$result = $oMemberController->procMemberScrapDocument();

		return $result;
	}

	// 내 스티커 목록
	function xmlMyStickerList($args)	// member_srl, module_srl, page 필요
	{
		$oDocumentModel = &getModel('document');

		$result = executeQuery('member.getDocumentList', $args);

		unset($result->variables);

		foreach($result->data as $key => $val)
		{
			$document_list[$key] = $oDocumentModel->getDocument($val->document_srl);
		}

		$result->data = $document_list;

		return $result;
	}

	// 내가 지원한 스티커 목록
	function xmlMyVotedList($args)	// member_srl, module_srl, page 필요
	{
		$oDocumentModel = &getModel('document');

		$result = executeQueryArray('member.getVotedDocumentList', $args);

		unset($result->variables);

		foreach($result->data as $key => $val)
		{
			$document_list[$key] = $oDocumentModel->getDocument($val->document_srl);
		}

		$result->data = $document_list;

		return $result;
	}

	// 내가 찜한 스티커 목록
	function xmlMyScrappedList($args)	// member_srl, module_srl, page 필요
	{
		$oDocumentModel = &getModel('document');

		$result = executeQuery('member.getScrapDocumentList', $args);

		unset($result->variables);

		foreach($result->data as $key => $val)
		{
			$document_list[$key] = $oDocumentModel->getDocument($val->document_srl);
		}

		$result->data = $document_list;

		return $result;
	}
?>
