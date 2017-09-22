<?php

/**
  后台通知
 */
require '../system/common.php';

$payment = $GLOBALS['db']->getRow("select id,config from " . DB_PREFIX . "payment where class_name='fuiouwap'");

$payment['config'] = unserialize($payment['config']);

$mchnt_key = $payment['config']['fuiou_key'];
// 测试密钥

$res = array();
$res['version'] = $_REQUEST['VERSION'];
$res['type'] = $_REQUEST['TYPE'];
$res['code'] = $_REQUEST['RESPONSECODE'];
$res['msg'] = $_REQUEST['RESPONSEMSG'];
$res['mchntcd'] = $_REQUEST['MCHNTCD'];
$res['order_id'] = $_REQUEST['MCHNTORDERID'];
$res['fuiou_order_id'] = $_REQUEST['ORDERID'];
$res['bank_card'] = $_REQUEST['BANKCARD'];
$res['amt'] = $_REQUEST['AMT'];
$res['sign'] = $_REQUEST['SIGN'];
$money = $res['amt'] / 100;

$_data = $res['type'] . "|" . $res['version'] . "|" . $res['code'] . "|" . $res['mchntcd'] . "|" . $res['order_id'] . "|" . $res['fuiou_order_id'] . "|" . $res['amt'] . "|" . $res['bank_card'] . "|" . $mchnt_key;
$_md5 = md5($_data);

//开始初始化参数
$payment_notice_sn = $res['order_id'];
//$money = $res['amt'];
//$payment_id = $payment['id'];
$outer_notice_sn = $res['fuiou_order_id'];
file_put_contents("fuionpay.txt", json_encode($_REQUEST) . "\r\n", FILE_APPEND);
file_put_contents("fuionpay.txt", $_data . "\r\n", FILE_APPEND);
file_put_contents("fuionpay.txt", $_md5 . '***' . $res['sign'] . "\r\n", FILE_APPEND);

if ($_md5 == $res['sign'] && $res['code'] == '0000') {
    file_put_contents("fuionpay.txt", "succ ok!\r\n", FILE_APPEND);
    $payment_notice = $GLOBALS['db']->getRow("select * from " . DB_PREFIX . "payment_notice where notice_sn = '" . $res['order_id'] . "'");
 
    require_once APP_ROOT_PATH . "system/libs/cart.php";
	 
    $rs = payment_paid($payment_notice['notice_sn'],$res['fuiou_order_id']);
	
    $url = APP_ROOT . "/../wap/member.php?ctl=uc_center";
    app_redirect($url);
} else {
	
    $url = APP_ROOT . "/../wap/member.php?ctl=uc_center";
    app_redirect($url);
	
}
?>