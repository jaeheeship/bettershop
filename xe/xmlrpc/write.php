<?php
//requires xmlrpc.inc from http://phpxmlrpc.sourceforge.net/
//!!중요!! xmlrpc파일이 필요함, 위 주소로 가서 zip파일을 다운로드, 압축해제후 lib폴더에 있는 xmlrpc.inc파일을 넣어주세요.
//아 그리고, xe에서 애드온 메뉴에서 블로그api 기능의 기본설정이 off되어있는데 그걸 on 해주셔야 작동되겠죠?

require_once('./xmlrpc.inc');

$g_blog_url = "http://www.bettershop.co.kr/xe14/?mid=notice&act=api";
$g_id = "admin";
$g_passwd = "ddxiirocks730814";

$GLOBALS['xmlrpc_internalencoding'] = 'UTF-8';

function metaWeblog_newPost( $blogid, $title, $content)
{
  global $g_id;
  global $g_passwd;
  global $g_blog_url;
  
  $client = new xmlrpc_client( "{$g_blog_url}");
  $f = new xmlrpcmsg("metaWeblog.newPost", // metaWeblog.newPost method
    array( 
      new xmlrpcval("{$blogid}", "string"), // blogid.
      new xmlrpcval($g_id, "string"), // user ID.
      new xmlrpcval($g_passwd, "string"), // password
      new xmlrpcval( // body
          array(
            'title'        => new xmlrpcval($title, "string"),
            'description'    => new xmlrpcval($content, "string"),
            
        ), "struct"),
      new xmlrpcval(true, "boolean") // publish
    )
  );

  $f->request_charset_encoding = 'UTF-8';

  $response = $client->send($f);
  echo  $blogid.$title.$content.$tags.$category;
 
}

$blogid="admin";
$title="제목입니다.";
$content="내용입니다내용입니다";


metaWeblog_newPost( $blogid, $title, $content);

?>
