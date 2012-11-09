<?PHP

include("classes/class_APNS.php");
include("classes/class_DbConnect.php");

$apns_whom = $_POST['whom'];
$apns_send_message = $_POST['send_message'];
$apns_send_option = $_POST['send_option'];
$apns_send_time = $_POST['send_time'];

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
