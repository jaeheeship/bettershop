<?PHP

	// output 만들기 시작.....

	$dom = new DOMDocument("1.0","UTF-8");
	
	$response = $dom->createElement("response");
	$dom->appendChild($response);
	
	$control = $dom->createElement("control");
	$response->appendChild($control);
	
		$control_value = $dom->createTextNode("ThisIsControl");
		$control->appendChild($control_value);
	
	$data = $dom->createElement("data");
	$response->appendChild($data);
	
		$data_value = $dom->createTextNode("ThisIsData");
		$data->appendChild($data_value);
	
	// 출력
	header("Content-Type: text/xml; charset=utf-8");
	echo $dom->saveXML();
	
?>
