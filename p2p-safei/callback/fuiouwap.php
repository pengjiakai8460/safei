<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=0,minimum-scale=0.5">
	<title>确认信息</title>
</head>
<body>
<?php
require '../system/common.php';
//$payment_notice_id = intval($_REQUEST['payment_notice_id']);
$payment_notice_id = intval($_REQUEST['id']);
require_once APP_ROOT_PATH."system/payment/fuiouwap_payment.php";
$payment_object = new fuiouwap_payment();
$html = $payment_object->get_payment($payment_notice_id);

echo $html;
?>
</body>
</html>