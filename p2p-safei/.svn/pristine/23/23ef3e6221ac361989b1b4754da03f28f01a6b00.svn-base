<?php
/**
 * 后台通知回调处理接口
 */

// 获得返回的数据
$mchnt_cd = $_POST['mchnt_cd'];
$order_id = $_POST['order_id'];
$order_date = $_POST['order_date'];
$order_amt = $_POST['order_amt'];
$order_st = $_POST['order_st'];
$order_pay_code = isset($_POST['order_pay_code']) ? $_POST['order_pay_code'] : '';
$order_pay_error = isset($_POST['order_pay_error']) ? $_POST['order_pay_error'] : '';
$user_id = $_POST['user_id'];
$fy_ssn = $_POST['fy_ssn'];
$card_no = $_POST['card_no'];
$RSA = $_POST['RSA'];

$fy_date = $order_date;
$data = $mchnt_cd . '|' . $user_id . '|' . $order_id . '|' . $order_amt . '|' . $fy_date . '|' . $card_no . '|' . $fy_ssn;

$dataGBK = iconv('UTF-8', 'GBK', $data);

// 测试用公钥，在正式环境时，更换为正式公钥
$rsaKey = 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCn26E6VU4mVfUlsaScZDuPyYTSszoFCS7ctk6K6kO4y6xZrrVSoGhrd6ej1PXa421uqvDEpmrrnZBaJO0y7S/6niWNzwZQ5ajWo929ZH0HrqsD4DENUEyBTj8U9etnxx7J1wZFtPzgHd3FrUSj1RVjpy5QA40ls29KD2DhJU/oFwIDAQAB';
$pemKey = chunk_split($rsaKey, 64, "\n");
$pem = "-----BEGIN PUBLIC KEY-----\n" . $pemKey . "-----END PUBLIC KEY-----\n";
$pubKey = openssl_pkey_get_public($pem);

$ret = openssl_verify($dataGBK, base64_decode($RSA), $pubKey, OPENSSL_ALGO_MD5);

// 记录一个回调日志
$fp = fopen('./fy.log', 'a');
fwrite($fp, date('Y-m-d H:i:s') . '-' . $data . "\r\n");
fwrite($fp, $ret . "\r\n");
fwrite($fp, json_encode($_POST) . "\r\n");
fclose($fp);

if ($ret==1) { // 说明验签成功
    echo 'SUC';
    
    // 对订单进行处理的逻辑
    if ($order_st=='11' && $order_pay_code=='0000') {
        // 支付成功，订单处理为成功，对用户账号加钱等操作
        
    } else {
        // 支付未成功，订单处理为失败
    }
    
} else {
    echo 'FAIL';
}
?>