<?php
    $uri = "http://www.bettershop.co.kr/xe14/board/api";
    $body = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
    <methodCall>
    <methodName><![CDATA[metaWeblog.getPost]]></methodName>
    <params>
    <param><value><string><![CDATA[104]]></string></value></param>
    <param><value><string><![CDATA[admin]]></string></value></param>
    <param><value><string><![CDATA[xiirocks730814]]></string></value></param>
    <param>
    <value>
    <boolean>1</boolean>
    </value>
    </param>
    </params>
    </methodCall>";
 
    $buff = @FileHandler::getRemoteResource($uri, $body, 3, "POST", "application/xml");
    echo $buff;
?>