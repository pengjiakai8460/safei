<?php

// +----------------------------------------------------------------------
$payment_lang = array(
    'name' => '富友wap支付',
    'fuiou_account' => '商户编号',
    'fuiou_key' => '商户密钥',
    'VALID_ERROR' => '支付验证失败',
    'PAY_FAILED' => '支付失败',
    'GO_TO_PAY' => '前往富友支付',
);
$config = array(
    'fuiou_account' => array(
        'INPUT_TYPE' => '0',
    ), //商户编号
    'fuiou_key' => array(
        'INPUT_TYPE' => '0'
    ), //商户密钥
);
/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == true) {
    $module['class_name'] = 'fuiouwap';
    /* 名称 */
    $module['name'] = $payment_lang['name'];
    /* 支付方式：1：在线支付；0：线下支付 */
    $module['online_pay'] = '2';
    /* 配送 */
    $module['config'] = $config;
    $module['lang'] = $payment_lang;
    $module['reg_url'] = '';
    return $module;
}

// 网银支付模型
require_once(APP_ROOT_PATH . 'system/libs/payment.php');
class fuiouwap_payment implements payment {

    /**
     * 手机支付
     *
     * @access  public
     * @param   int         $payment_notice_id      // 支付订单ID
     * @param   array       $user                   // 用户相关信息
     * @return
     */
    public function get_payment($payment_notice_id) {
		
        //$user = es_session::get('payInfo');
        $payment_notice = $GLOBALS['db']->getRow("select * from " . DB_PREFIX . "payment_notice where id = " . $payment_notice_id);
        $money = round($payment_notice['money'], 2);
        $payment_info = $GLOBALS['db']->getRow("select id,config,logo from " . DB_PREFIX . "payment where id=" . intval($payment_notice['payment_id']));
        $payment_info['config'] = unserialize($payment_info['config']);
        //获得用户的身份证姓名以及卡号  
        $user_identify = $GLOBALS['db']->getRow("SELECT real_name,idno FROM " . DB_PREFIX . "user where id = " . $payment_notice['user_id']);
        $bankcard= es_session::get("bankcard");
		$uname= es_session::get("fuyouname");
		$uidno= es_session::get("fuyouidno");
        $data = array();
        $data['enctp'] = '0';                    // 0：不对xml报文加密
        $data['version'] = '2.0';                  // 接口版本号
        //$_mchnt_cd=$data['mchntcd'] = trim($payment_info['config']['fuiou_account']);  // 商户代码
        $_mchnt_cd=$data['mchntcd']    = '0002900F0486447';  // 商户代码
        $data['mchntcd_key'] = trim($payment_info['config']['fuiou_key']);      // 密钥
        //$data['mchntcd_key']= 'd8n0dh23w2yzrnez52ocqb4ckzp7t0fs';      // 密钥

        $data['xml_mchntcd'] = $data['mchntcd'];
        $data['xml_type'] = '10';                             // 交易类型
        $data['xml_version'] = $data['version'];
        $data['xml_logotp'] = '0';
        $order_id=$data['xml_mchnt_order_id'] = $payment_notice['notice_sn'];     // 订单号
        $user_id = $data['xml_user_id'] = $payment_notice['user_id'];       // 用户ID
        $order_amt=$data['xml_amt'] = $money * 100;                     // 交易金额
        $card_no = $data['xml_bank_card'] = $bankcard;               // 银行卡号
	
        $data['xml_back_url'] = get_domain() . APP_ROOT . '/fuiouwap_notify.php';       // 后台回调
        
		if($payment_notice['memo'] == 'pc')
		{
			$_page_notify_url=$data['xml_re_url'] = get_domain() . APP_ROOT . '/fuioupc_k_response.php';   // 失败回调
			$_back_notify_url=$data['xml_home_url'] = get_domain() . APP_ROOT . '/fuioupc_k_notify.php';    // 页面回调
			$gateurl = "https://pay.fuiou.com/dirPayGate.do";
		}else
		{
			$data['xml_re_url'] = get_domain() . APP_ROOT . '/fuiouwap_notify.php';   // 失败回调
			$data['xml_home_url'] = get_domain() . APP_ROOT . '/fuiouwap_response.php';    // 页面回调
			$gateurl = "https://mpay.fuiou.com:16128/h5pay/payAction.pay";
		}
		
        $cardholder_name= $data['xml_name'] = $uname;                    // 用户真实姓名
        $cert_type = $data['xml_id_type'] = '0';                              // 0：证件类型默认身份证
        $cert_no = $data['xml_id_no'] = $uidno;                    // 身份证号
        $data['xml_signtp'] = 'md5';                            // 加密方式
        $RSA=$data['xml_sign'] = $this->WebMd5Sign($data);
		
        $data['xml'] = $this->WebXML($data);                                // XML报文
        //$data['en_xml']             = $this->WebEnXML($data['xml'], $data['mchntcd_key']); // 加密XML报文
        //var_dump($data['mchntcd'].'--'.$data['mchntcd_key']);exit;
        $test = 2;
      /*   if ($test == 2) {
            $gateurl = "https://mpay.fuiou.com:16128/h5pay/payAction.pay";
        } else {
            $gateurl = "http://www-1.fuiou.com:18670/mobile_pay/h5pay/payAction.pay";
        } */
          if($payment_notice['memo'] == 'pc')
        {
        	
        	 // rsa私钥，在正式环境时，更换为正式的私钥
         	$data2 = $_mchnt_cd . '|' . $user_id . '|' . $order_id . '|' . $order_amt . '|' . $card_no . '|' . $cardholder_name . '|' . $cert_type . '|'  . $cert_no . '|' . $_page_notify_url . '|' . $_back_notify_url;
	        $dataGBK = iconv('UTF-8', 'GBK', $data2);
			
			// rsa私钥，在正式环境时，更换为正式的私钥
			$rsaKey = 'MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAK8o0CT0NORmNrh2XpSL1nNYSy5eQZnokEFgs8bJ2eDICxBsAZh3hk5dN24BPszKLpjTC1X3GUZQrAUQkUxwzYb/a5NP+CP2CjpHx1CiD0fGgGN84yi+cVPcgsxn4HSnQQWVEcihxl/R0R3Qd44dHjKcK/SM5ShaGg6UsPT34VW9AgMBAAECgYEAjkkUFADAeozBhMS6/eY+VUJzB/6PQawWitU4FJJhx+QYgMWL4kOtuTilz1l5nzfZ9FDz02g/gswDgLW9oh+8A8V/Eg5NQnEukJiNGXa7qisjW/euyzLpegCXfpgF34mRErwCJMYjM9z4YeqrQ+aOxq70+RBBf5pGxqWMZZ8AqIECQQDmEWTS1tA2DR8qKyGm69UhtV+07pHK4P16Rj1La0zdOVX2XGPhsdjKCs/EKzUNpcskFsJKPOT+F8KCG8bIBifdAkEAwucI801Xn6Z2zp/EEzq3sBJYp3gWqq4c/KfOZo1sE0D1+HuFpmWo28/8PNTYMX0QCLXiHiMtuelCOkc52w73YQJBAN20t1digOUFghnN1LEZpJrGQQOHv2Elrb8OPvUV4s1w+kDdybbt/r686njdNlP/iCIv+G03/2hJFzzwbX/GRtUCQQClbkrXkP9eAIJ5cXyRQdamOXxMcY7zwqPSBHEZ9NIWKZ5eEiJoEYPZR9l2nMcAgoG4kwFhyURHt+jB5LED8dkhAkB10unlP0KDcbQKxYcnrE/UjLdT4VxIhyIhscO1qQv+WVYIEJycQA7edCGPxav/X9pw2I6mzSXYgWVZgY5CFbwS';
			$pemKey = chunk_split($rsaKey, 64, "\n");
			$pem = "-----BEGIN PRIVATE KEY-----\n" . $pemKey . "-----END PRIVATE KEY-----\n";
			$priKey = openssl_pkey_get_private($pem);
			
			openssl_sign($dataGBK, $encrypted, $priKey, OPENSSL_ALGO_MD5); // 对数据进行签名
			$RSA = base64_encode($encrypted);
        	$res = <<<EOF
            <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            </head>
			<style>
			.info_return{height:40px;line-height:40px;background-color:#004ca2;padding-left:15px}
			.info_return a{color:#fff;font-size:1rem;text-decoration:none}
			.info{margin:0 auto;text-align:center;width:100%}
			.info p{margin:0 auto;width:85%; color:#666666;font-family:"微软雅黑";font-size:1.3rem;text-align:left;margin-bottom:20px}
			.info_blank50{width:100%;height:50px}
			.info_sub{display:block;width:50%;margin:0 auto;height:40px;line-height:40px;color:#fff;background-color:#004ca2;font-size:1.3rem;border:0;}
			</style>
            <body style="margin:0">
		        <form name="form1" id="form1" method="post" action="{$gateurl}" target="_self">
					<div class="info_return"><a href="javascript:history.go(-1)">返回</a></div>
					<input type="hidden" name="mchnt_cd" value="{$_mchnt_cd}" />
					<input type="hidden" name="order_id" value="{$order_id}" />
					<input type="hidden" name="order_amt" value="{$order_amt}" />
					<input type="hidden" name="user_type" value="0" />
					<input type="hidden" name="page_notify_url" value="{$_page_notify_url}" />
					<input type="hidden" name="back_notify_url" value="{$_back_notify_url}" />
					<input type="hidden" name="card_no" value="{$card_no}" />
					<input type="hidden" name="cert_type" value="0" />
					<input type="hidden" name="cert_no" value="{$cert_no}" />
					<input type="hidden" name="cardholder_name" value="{$cardholder_name}" />
					<input type="hidden" name="user_id" value="{$user_id}" />
					<input type="hidden" name="RSA" value="{$RSA}" />
					<div class="info">
						<p>银行卡号：{$card_no}</p>
						<p>姓名：{$cardholder_name}</p>
						<p>身份证：{$cert_no}</p>
						<p>金额：{$money}元</p>
					</div>
					<div class="info_blank50"></div>
				    <input type="submit" value="提交" class="info_sub"></input>
					  
		        </form>
		    </body>
		    </html>
		   
EOF;
          }else{
        $res = $this->WebFormPost($data,$money, $gateurl);
        }
        return $res;
    }

    /**
     * 支付方式
     *
     * @access  public
     * @param
     * @return
     */
    public function get_payment_code($payment_notice_id) {
        $payment_notice = $GLOBALS['db']->getRow("select * from " . DB_PREFIX . "payment_notice where id = " . $payment_notice_id);
        $money = round($payment_notice['money'], 2);
        $payment_info = $GLOBALS['db']->getRow("select id,config,logo from " . DB_PREFIX . "payment where id=" . intval($payment_notice['payment_id']));
        $payment_info['config'] = unserialize($payment_info['config']);
        $subject = $payment_notice['order_sn'];
        $notify_url = SITE_DOMAIN . APP_ROOT . '/callback/fuiouwap.php?id=' . $payment_notice_id;
        $notify_url = str_replace(array("/mapi", "/wap"), "", $notify_url);

        $pay = array();
        $pay['subject'] = $subject;
        $pay['body'] = '会员充值';
        $pay['total_fee'] = $money;
        $pay['total_fee_format'] = format_price($money);
        $pay['out_trade_no'] = $payment_notice['notice_sn'];
        $pay['notify_url'] = $notify_url;
        $pay['partner'] = ''; //$payment_info['config']['alipay_partner'];//合作商户ID
        $pay['seller'] = ''; //$payment_info['config']['alipay_account'];//账户ID
        $pay['key'] = ''; //$payment_info['config']['alipay_key'];//支付宝(RSA)公钥
        $pay['is_wap'] = 1; //
        $pay['pay_code'] = 'fuiouwap'; //,支付宝;mtenpay,财付通;mcod,货到付款

        return $pay;
    }

    public function get_pay() {
        $payment_notice_id = intval($_REQUEST['id']);
        $payment_notice = $GLOBALS['db']->getRow("select * from " . DB_PREFIX . "payment_notice where id = " . $payment_notice_id);
        $money = round($payment_notice['money'], 2);
        $payment_info = $GLOBALS['db']->getRow("select id,config,logo from " . DB_PREFIX . "payment where id=" . intval($payment_notice['payment_id']));
        $payment_info['config'] = unserialize($payment_info['config']);

        $data_vid = trim($payment_info['config']['fuiou_account']);
        $data_orderid = $payment_notice['notice_sn'];
        $data_vamount = $money;
        $data_vmoneytype = 'CNY';
        $data_vpaykey = trim($payment_info['config']['fuiou_key']);

        $data_vreturnurl = SITE_DOMAIN . '/callback/fuiouwap_response.php';
        $data_notify_url = SITE_DOMAIN . '/callback/fuiouwap_notify.php';

        //支付校验
        $_order_id = $payment_notice['notice_sn']; //商户订单号
        $_order_amt = $money * 100;  //交易金额
        $_order_pay_type = "B2C"; //支付类型
        $_iss_ins_cd = "0000000000"; //银行
        $_page_notify_url = $data_vreturnurl; //页面跳转URL
        $_back_notify_url = $data_notify_url; //后台通知URL
        $_order_valid_time = ""; //超时时间
        $_mchnt_cd = trim($payment_info['config']['fuiou_account']); //商户代码
        $_mchnt_key = trim($payment_info['config']['fuiou_key']); //商户代码
        $_goods_name = ""; //商品名称
        $_goods_display_url = ""; //商品展示网址
        $_rem = ""; //备注
        $_ver = "1.0.1"; //版本号
        //拼接数据
        $_data = "";
        $_data .= $_mchnt_cd . "|";
        $_data .= $_order_id . "|";
        $_data .= $_order_amt . "|";
        $_data .= $_order_pay_type . "|";
        $_data .= $_page_notify_url . "|";
        $_data .= $_back_notify_url . "|";
        $_data .= $_order_valid_time . "|";
        $_data .= $_iss_ins_cd . "|";
        $_data .= $_goods_name . "|";
        $_data .= $_goods_display_url . "|";
        $_data .= $_rem . "|";
        $_data .= $_ver . "|";
        $_data .= $_mchnt_key;

        $_md5 = MD5($_data); //签名数据

        $test = "2";
        if ($test == "2") {
            $gateurl = "https://pay.fuiou.com/smpGate.do";
        } else {
            $gateurl = "http://www-1.fuiou.com:8888/wg1_run/smpGate.do";
        }
        $def_url = "<form name='form1' action='" . $gateurl . "' method=\"post\" >";
        $def_url .= "<input type=\"hidden\" name=\"md5\" value='" . $_md5 . "' />";
        $def_url .= "<input type=\"hidden\" name=\"mchnt_cd\" value='" . $_mchnt_cd . "' />";
        $def_url .= "<input type=\"hidden\" name=\"order_id\" value='" . $_order_id . "' />";
        $def_url .= "<input type=\"hidden\" name=\"order_amt\" value='" . $_order_amt . "' />";
        $def_url .= "<input type=\"hidden\" name=\"order_pay_type\" value='" . $_order_pay_type . "' />";
        $def_url .= "<input type=\"hidden\" name=\"page_notify_url\" value='" . $_page_notify_url . "' />";
        $def_url .= "<input type=\"hidden\" name=\"back_notify_url\" value='" . $_back_notify_url . "' />";
        $def_url .= "<input type=\"hidden\" name=\"order_valid_time\" value='" . $_order_valid_time . "' />";
        $def_url .= "<input type=\"hidden\" name=\"iss_ins_cd\" value='" . $_iss_ins_cd . "' />";
        $def_url .= "<input type=\"hidden\" name=\"goods_name\" value='" . $_goods_name . "' />";
        $def_url .= "<input type=\"hidden\" name=\"goods_display_url\" value='" . $_goods_display_url . "' />";
        $def_url .= "<input type=\"hidden\" name=\"rem\" value='" . $_rem . "' />";
        $def_url .= "<input type=\"hidden\" name=\"ver\" value='" . $_ver . "' />";

        if (!empty($payment_info['logo']))
            $def_url .= "<input type='image' src='" . APP_ROOT . $payment_info['logo'] . "' style='border:solid 1px #ccc;'><div class='blank'></div>";

        $def_url .= "<input type='submit' class='paybutton' value='前往在线支付'>";
        $def_url .= "</form>";
        $code = $def_url . '<script>document.form1.submit();</script><div style="text-align:center">' . $def_url . '</div>';

        return $code;
    }

    //http://peizi.bestysc.com/index.php?ctl=payment&act=response&class_name=ecpss
    public function response($request) {
        return 0;
    }

    /**
     * 后台回调
     *
     */
    public function notify($request) {
        return 0;
    }

    function get_display_code() {
        $payment_item = $GLOBALS['db']->getRow("select * from " . DB_PREFIX . "payment where class_name='fuiouwap'");
        if ($payment_item) {
            $html = "<label class='f_l ui-radiobox' rel='common_payment' style='background:url(" . APP_ROOT . $payment_item['logo'] . ")' title='" . $payment_item['name'] . "'>" .
                    "<input type='radio' name='payment' value='" . $payment_item['id'] . "' checked='checked' />&nbsp;";
            if ($payment_item['logo'] == "") {
                $html .= $payment_item['name'];
            }
            $html .= "</label>";
            return $html;
        } else {
            return '';
        }
    }

    /**
     * 手机支付签名生成方法
     *
     * @accecss  public
     * @param    array  $data       // 待签名数组
     * @return   string $sign
     */
    public function WebMd5Sign($data) {
        $md5 = '';
        $md5 .= $data['xml_type'] . '|';
        $md5 .= $data['xml_version'] . '|';
        $md5 .= $data['xml_mchntcd'] . '|';
        $md5 .= $data['xml_mchnt_order_id'] . '|';
        $md5 .= $data['xml_user_id'] . '|';
        $md5 .= $data['xml_amt'] . '|';
        $md5 .= $data['xml_bank_card'] . '|';
        $md5 .= $data['xml_back_url'] . '|';
        $md5 .= $data['xml_name'] . '|';
        $md5 .= $data['xml_id_no'] . '|';
        $md5 .= $data['xml_id_type'] . '|';
        $md5 .= $data['xml_logotp'] . '|';
        $md5 .= $data['xml_home_url'] . '|';
        $md5 .= $data['xml_re_url'] . '|';
        $md5 .= $data['mchntcd_key'];

        $sign = md5($md5);

        return $sign;
    }

    /**
     * 手机支付XML报文生成方法
     *
     * @access  public
     * @param   array   $data   待生成报文数据数组
     * @return  xml
     */
    public function WebXML($data) {
        $xml = <<<EOF
<ORDER>
    <VERSION>{$data['xml_version']}</VERSION>
    <LOGOTP>{$data['xml_logotp']}</LOGOTP>
    <MCHNTCD>{$data['xml_mchntcd']}</MCHNTCD>
    <TYPE>{$data['xml_type']}</TYPE>
    <MCHNTORDERID>{$data['xml_mchnt_order_id']}</MCHNTORDERID>
    <USERID>{$data['xml_user_id']}</USERID>
    <AMT>{$data['xml_amt']}</AMT>
    <BANKCARD>{$data['xml_bank_card']}</BANKCARD>
    <NAME>{$data['xml_name']}</NAME>
    <IDTYPE>{$data['xml_id_type']}</IDTYPE>
    <IDNO>{$data['xml_id_no']}</IDNO>
    <BACKURL>{$data['xml_back_url']}</BACKURL>
    <HOMEURL>{$data['xml_home_url']}</HOMEURL>
    <REURL>{$data['xml_re_url']}</REURL>
    <SIGNTP>{$data['xml_signtp']}</SIGNTP>
    <SIGN>{$data['xml_sign']}</SIGN>
</ORDER>
EOF;

        return $xml;
    }

    /**
     * 手机支付XML报文加密
     *
     * @access  public
     * @param   string  $xml
     * @param   string  $en_key
     * @return  string  enxml
     */
    public function WebEnXML($xml, $en_key) {

        $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
        $input = $this->pkcs5_pad($xml, $size);
        $key = str_pad($en_key, 8, '0'); //3DES加密将8改为24
        $td = mcrypt_module_open(MCRYPT_DES, '', MCRYPT_MODE_CBC, '');
        $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        @mcrypt_generic_init($td, $key, $iv);
        $data = mcrypt_generic($td, $input);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $en_xml = base64_encode($data); //如需转换二进制可改成  bin2hex 转换

        return $en_xml;
    }

    /**
     * DES加密辅助函数
     */
    function pkcs5_pad($text, $blocksize) {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    /**
     * 手机支付表单提交
     *
     * @access  public
     * @param   array   $data   // 需要提交的数据
     * @param   string  $url    // post地址
     * @return
     */
    public function WebFormPost($data,$money, $url) {
        $xml = $data['enctp'] == 1 ? $xml = $data['en_xml'] : $data['xml'];
        $html = <<<EOF
            <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            </head>
			<style>
			.info_return{height:40px;line-height:40px;background-color:#004ca2;padding-left:15px}
			.info_return a{color:#fff;font-size:1rem;text-decoration:none}
			.info{margin:0 auto;text-align:center;width:100%}
			.info p{margin:0 auto;width:85%; color:#666666;font-family:"微软雅黑";font-size:1.3rem;text-align:left;margin-bottom:20px}
			.info_blank50{width:100%;height:50px}
			.info_sub{display:block;width:50%;margin:0 auto;height:40px;line-height:40px;color:#fff;background-color:#004ca2;font-size:1.3rem;border:0;}
			</style>
            <body style="margin:0">
		        <form name="form1" id="form1" method="post" action="{$url}" target="_self">
					<div class="info_return"><a href="javascript:history.go(-1)">返回</a></div>
				    <input type="hidden" name="VERSION" value="{$data['xml_version']}" /><br>
				    <input type="hidden" name="ENCTP" value="{$data['enctp']}" /><br>
				    <input type="hidden" name="LOGOTP" value="{$data['xml_logotp']}" /><br>
				    <input type="hidden" name="MCHNTCD" value="{$data['mchntcd']}" /><br>
				    <input type="hidden" name="FM" value="{$xml}" /><br>
					<div class="info">
						<p>银行卡号：{$data['xml_bank_card']}</p>
						<p>姓名：{$data['xml_name']}</p>
						<p>身份证：{$data['xml_id_no']}</p>
						<p>金额：{$money}</p>
					</div>
					<div class="info_blank50"></div>
				    <input type="submit" value="提交" class="info_sub"></input>
					  
		        </form>
		    </body>
		    </html>
		   
EOF;

        return $html;
    }

    /**
     * 手机支付curl模拟表单提交
     *
     * @access  public
     * @param   array   $data   // 需要提交的数据
     * @param   string  $url    // post地址
     * @return
     */
    public function WebCurlPost($data, $url) {
        $curl_post = array();
        $curl_post['VERSION'] = $data['xml_version'];
        $curl_post['ENCTP'] = $data['emctp'];
        $curl_post['LOGOTP'] = $data['xml_logotp'];
        $curl_post['MCHNTCD'] = $data['mchntcd'];
        $curl_post['FM'] = $data['emctp'] == 1 ? $data['en_xml'] : $data['xml'];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_post);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

}

?>