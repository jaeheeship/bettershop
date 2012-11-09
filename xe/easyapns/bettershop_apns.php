<?PHP

function findApnsIdByEmail($email)     
	{	
		$link = mysql_connect('localhost', 'root', 'root');
		if (!$link) {
			//die('Could not connect: ' . mysql_error());
			return FALSE;
		}
		//echo 'Connected successfully';
		
		// bs01 DB의 member_front TABLE의
		if(!mysql_select_db('bs01',$link)){
			//die('Could not select db: ' . mysql_error());
			return FALSE;
		}
		
		mysql_query("set session character_set_connection=utf8;");
		mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");
		

		
		// SELECT `deviceuuid` FROM `member_front` WHERE `mail`='kjy1973ss@hanmail.net'; <== OK
		/*
		$sql = 
			"
			INSERT INTO `member_front` (`from`, `name`, `user_id`, `pass`, `mail`, `user_tel`, `profile`, `sex`, `birth`, `deviceuuid`) VALUES
			('$from', '$name', '$user_id', '$pass', '$mail', '$user_tel', '$profile','$sex','$birth','$deviceuuid');
			";	
		*/
		$sql = 
			"
			SELECT `deviceuuid` FROM `member_front` WHERE `mail`='$email';
			";
		
		$result = mysql_query($sql,$link);
		
		if(!$result){
			//die('Could not query: ' . mysql_error());
			return FALSE;
		}
		
		$num_row = mysql_num_rows($result);
		
		if($num_row > 0) {
			$row = mysql_fetch_array($result, MYSQL_NUM);
			$deviceuuid = $row[0];
			//die('deviceuuid='.$deviceuuid);
		}
		else {
			return FALSE;
		}
		
		//  easyapns DB의 apns_devices TABLE의 pid 얻기
		
		
		// bs01 DB의 member_front TABLE의
		if(!mysql_select_db('easyapns',$link)){
			return FALSE;
		}
		
		mysql_query("set session character_set_connection=utf8;");
		mysql_query("set session character_set_results=utf8;");
		mysql_query("set session character_set_client=utf8;");

		//  SELECT `pid` FROM `apns_devices` WHERE `deviceuid`='3301a8ed1ac572199f49db1cf11a88156667ce7a';
		// field name이 deviceuid u자 1개 주의
		$sql = 
			"
			SELECT `pid` FROM `apns_devices` WHERE `deviceuid`='$deviceuuid';	
			";
		
		$result = mysql_query($sql,$link);
		
		if(!$result){
			//die('Could not query: ' . mysql_error());
			return FALSE;
		}
		
		$num_row = mysql_num_rows($result);
		
		if($num_row > 0) {
			$row = mysql_fetch_array($result, MYSQL_NUM);
			$pid = $row[0];
			//die('pid='.$pid);
		}
		else {
			return FALSE;
		}
		
		mysql_close($link);
		
		//return TRUE;
		return $pid;
	}



include("classes/class_APNS.php");
include("classes/class_DbConnect.php");

$apns_email = $_POST['email'];
$apns_whom = $_POST['whom'];

if($pid = findApnsIdByEmail($apns_email))
{
	$apns_whom = $pid;
}
else {
	die('Could not find pid by email address '); 
}

$apns_send_message = $_POST['send_message'];
$apns_send_option = $_POST['send_option'];
$apns_send_time = $_POST['send_time'];

/////////



/////////



$db = new DbConnect('localhost', 'root', 'root', 'easyapns');
$db->show_errors();

// FETCH $_GET OR CRON ARGUMENTS TO AUTOMATE TASKS
$apns = new APNS($db);


// APPLE APNS EXAMPLE 1
$apns->newMessage((int)$apns_whom);
$apns->addMessageAlert($apns_send_message);
$apns->addMessageBadge(9);
$apns->addMessageSound('chime');
$apns->addMessageCustom('acme2', array('bang', 'whiz'));
$apns->queueMessage();
// SEND ALL MESSAGES NOW
$apns->processQueue();

?>
