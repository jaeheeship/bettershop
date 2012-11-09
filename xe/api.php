<?php
    // _XE_PATH_ 생성
    define("_XE_PATH_", str_replace("api.php", "", str_replace("\\", "/", __FILE__)));
    // FileHandler(PEAR,Socket) 등을 사용하기 위해서 XE 정보를 선언
    define("__ZBXE__", true);
    require_once(_XE_PATH_."config/config.inc.php");
 
    $uri = "http://127.0.0.1/xe14/";
    $body = '<?xml version="1.0" encoding="utf-8" ?>
             <methodCall>
             <params>
             <module><![CDATA[bodex]]></module>
             <act><![CDATA[dispBoardContent]]></act>
             <mid><![CDATA[free]]></mid>
             <document_srl><![CDATA[104]]></document_srl>
             </params>
             </methodCall>';
 
    $buff = @FileHandler::getRemoteResource($uri, $body, 3, "POST", "application/xml");
    echo $buff;
?>