<?php

$deviceToken = '024bb45e0f089dd16e507135cf38cbbce63b6a62d682d97cba22d924d8c356ab'; // 디바이스토큰ID
$message = 'Message received from eye'; // 전송할 메시지

// 개발용
$apnsHost = 'gateway.sandbox.push.apple.com';
$apnsCert = 'apns-dev.pem';

// 실서비스용
//$apnsHost = 'gateway.push.apple.com';
//$apnsCert = 'apns-production.pem';

$apnsPort = 2195;

$payload = array('aps' => array('alert' => $message, 'badge' => 0, 'sound' => 'default'));
$payload = json_encode($payload);

$streamContext = stream_context_create();
stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);

$apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);

if($apns)
{
  $apnsMessage = chr(0).chr(0).chr(32).pack('H*', str_replace(' ', '', $deviceToken)).chr(0).chr(strlen($payload)).$payload;
  fwrite($apns, $apnsMessage);
  fclose($apns);
}
?>
