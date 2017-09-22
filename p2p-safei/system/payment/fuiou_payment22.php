<?php
// +----------------------------------------------------------------------
// | Fanwe 方维p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 技术(1391990797@qq.com)
// +----------------------------------------------------------------------

$payment_lang = array(
	'name'	=>	'富友支付',
	'fuiou_account'	=>	'商户编号',
	'fuiou_key'	=>	'商户密钥',
	'VALID_ERROR'	=>	'支付验证失败',
	'PAY_FAILED'	=>	'支付失败',
	'GO_TO_PAY'	=>	'前往富友支付',
);
$config = array(
	'fuiou_account'	=>	array(
		'INPUT_TYPE'	=>	'0',
	), //商户编号
	'fuiou_key'	=>	array(
		'INPUT_TYPE'	=>	'0'
	), //商户密钥

);
/* 模块的基本信息 */
if (isset($read_modules) && $read_modules == true)
{
    $module['class_name']    = 'fuiou';

    /* 名称 */
    $module['name']    = $payment_lang['name'];


    /* 支付方式：1：在线支付；0：线下支付 */
    $module['online_pay'] = '1';

    /* 配送 */
    $module['config'] = $config;
    
    $module['lang'] = $payment_lang;
    $module['reg_url'] = '';
    return $module;
}

// 网银支付模型
require_once(APP_ROOT_PATH.'system/libs/payment.php');
class fuiou_payment implements payment {

	public function get_payment_code($payment_notice_id)
	{
		$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where id = ".$payment_notice_id);

		//$order_sn = $payment_notice['order_sn'];//$GLOBALS['db']->getOne("select order_sn from ".DB_PREFIX."deal_order where id = ".$payment_notice['order_id']);

		$money = round($payment_notice['money'],2);

		$payment_info = $GLOBALS['db']->getRow("select id,config,logo from ".DB_PREFIX."payment where id=".intval($payment_notice['payment_id']));

		$payment_info['config'] = unserialize($payment_info['config']);

		
		$data_vid           = trim($payment_info['config']['fuiou_account']);
        $data_orderid       = $payment_notice['notice_sn'];
        $data_vamount       = $money;
        $data_vmoneytype    = 'CNY';
        $data_vpaykey       = trim($payment_info['config']['fuiou_key']);
		$data_vreturnurl = get_domain().APP_ROOT.'/index.php?ctl=payment&act=response&class_name=fuiou';
		$data_notify_url = get_domain().APP_ROOT.'/index.php?ctl=payment&act=notify&class_name=fuiou';




   /*
     $MD5key = trim($data_vpaykey);	//MD5私钥
     $MerNo = trim($data_vid);					//商户号
     $BillNo =$payment_notice['notice_sn'].rand(1000,9999);	//[必填]订单号(商户自己产生：要求不重复)
     $Amount = sprintf('%.2f', $money); //round($money, 2);			//[必填]订单金额
  
     $ReturnURL = $data_vreturnurl; 			//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
     $Remark = $data_vid;  //[选填]升级。
     
     //$md5src = $MerNo."&".$BillNo."&".$Amount."&".$ReturnURL."&".$MD5key;		//校验源字符串
	

	 $AdviceURL =$data_notify_url;   //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
	 $OrderTime =date('YmdHis');   //[必填]交易时间yyyyymmddsshhss
	 $defaultBankNumber ="";   //[必填] s
     $payType ="";
     $products=$BillNo;// '------------------物品信息
	
	
      $md5src = "MerNo=$MerNo&BillNo=$BillNo&Amount=$Amount&OrderTime=$OrderTime&ReturnURL=$ReturnURL&AdviceURL=$AdviceURL&".$MD5KEY;
      $MD5info = strtoupper(md5($md5src));		//MD5检验结果
	  
	
	 
	 
	 $MD5KEY =  trim($payment_info['config']['ecpss_key']);		//MD5私钥
     $MerNo = trim($payment_info['config']['ecpss_account']);				//商户号
     $BillNo =$payment_notice['notice_sn'];	//[必填]订单号(商户自己产生：要求不重复)
     $Amount = sprintf('%.2f', $money);			//[必填]订单金额
     $ReturnURL = $data_vreturnurl;		//[必填]返回数据给商户的地址(商户自己填写):::注意请在测试前将该地址告诉我方人员;否则测试通不过
     $Remark = "";  //[选填]升级。
     
	 $AdviceURL =$data_notify_url;  //[必填]支付完成后，后台接收支付结果，可用来更新数据库值
	 $OrderTime =date('YmdHis');  //[必填]交易时间YYYYMMDDHHMMSS
	 $defaultBankNumber ="";   //[选填]银行代码s 
     $payType = '';
	 //送货信息(方便维护，请尽量收集！如果没有以下信息提供，请传空值:'')
	 //因为关系到风险问题和以后商户升级的需要，如果有相应或相似的内容的一定要收集，实在没有的才赋空值,谢谢。

    $products="";// '------------------物品信息
	
	
	$md5src = "MerNo=$MerNo&BillNo=$BillNo&Amount=$Amount&OrderTime=$OrderTime&ReturnURL=$ReturnURL&AdviceURL=$AdviceURL&".$MD5KEY;
	//echo $md5src;exit;
    $MD5info = strtoupper(md5($md5src));		//MD5检验结果
	*/

	    
		
			
	//支付校验
	$_order_id = $payment_notice['notice_sn']; //商户订单号
	$_order_amt = $money*100;	 //交易金额
	$_order_pay_type = "B2C"; //支付类型
	$_iss_ins_cd = "0000000000"; //银行

	$_page_notify_url = $data_vreturnurl;	//页面跳转URL
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
	$_data .= $_mchnt_cd."|";
	$_data .= $_order_id."|";
	$_data .= $_order_amt."|";
	$_data .= $_order_pay_type."|";
	$_data .= $_page_notify_url."|";
	$_data .= $_back_notify_url."|";
	$_data .= $_order_valid_time."|";
	$_data .= $_iss_ins_cd."|";
	$_data .= $_goods_name."|";
	$_data .= $_goods_display_url."|";
	$_data .= $_rem."|";
	$_data .= $_ver."|";
	$_data .= $_mchnt_key;

	$_md5 = MD5($_data); //签名数据
	
	$test ="2";
	if($test=="2"){
	  $gateurl = "https://pay.fuiou.com/smpGate.do";	
	}
	else{
	  $gateurl ="http://www-1.fuiou.com:8888/wg1_run/smpGate.do";	
    }
        $def_url="<form name='form1' action='".$gateurl."' method=\"post\" >";
		$def_url .= "<input type=\"hidden\" name=\"md5\" value='".$_md5."' />";
		$def_url .= "<input type=\"hidden\" name=\"mchnt_cd\" value='".$_mchnt_cd."' />";
		$def_url .= "<input type=\"hidden\" name=\"order_id\" value='".$_order_id."' />";
		$def_url .= "<input type=\"hidden\" name=\"order_amt\" value='".$_order_amt."' />";
		$def_url .= "<input type=\"hidden\" name=\"order_pay_type\" value='".$_order_pay_type."' />";
		$def_url .= "<input type=\"hidden\" name=\"page_notify_url\" value='".$_page_notify_url."' />";
		$def_url .= "<input type=\"hidden\" name=\"back_notify_url\" value='".$_back_notify_url."' />";
		$def_url .= "<input type=\"hidden\" name=\"order_valid_time\" value='".$_order_valid_time."' />";
		$def_url .= "<input type=\"hidden\" name=\"iss_ins_cd\" value='".$_iss_ins_cd."' />";
		$def_url .= "<input type=\"hidden\" name=\"goods_name\" value='".$_goods_name."' />";
		$def_url .= "<input type=\"hidden\" name=\"goods_display_url\" value='".$_goods_display_url."' />";
		$def_url .= "<input type=\"hidden\" name=\"rem\" value='".$_rem."' />";
		$def_url .= "<input type=\"hidden\" name=\"ver\" value='".$_ver."' />";


		
 

 
		if(!empty($payment_info['logo']))
			$def_url .= "<input type='image' src='".APP_ROOT.$payment_info['logo']."' style='border:solid 1px #ccc;'><div class='blank'></div>";
			
        $def_url .= "<input type='submit' class='paybutton' value='前往在线支付'>";
        $def_url .= "</form>";
        $code = '<div style="text-align:center">'.$def_url.'</div>';
		$code.="<br /><div style='text-align:center' class='red'>".$GLOBALS['lang']['PAY_TOTAL_PRICE'].":".format_price($money)."</div>";
        return $code;       
        
        
	}
	//http://peizi.bestysc.com/index.php?ctl=payment&act=response&class_name=ecpss
	public function response($request)
	{
		$return_res = array(
			'info'=>'',
			'status'=>false,
		);
		$payment = $GLOBALS['db']->getRow("select id,config from ".DB_PREFIX."payment where class_name='fuiou'");  
    	$payment['config'] = unserialize($payment['config']);
    	
    	
	$mchnt_key =$payment['config']['fuiou_key'];


    $mchnt_cd = $_REQUEST['mchnt_cd'];
	$order_id = $_REQUEST['order_id'];
	$order_date = $_REQUEST['order_date'];
	$order_amt = $_REQUEST['order_amt'];
	$order_st = $_REQUEST['order_st'];
    $order_pay_code = $_REQUEST['order_pay_code'];
    $order_pay_error = $_REQUEST['order_pay_error'];
	$resv1 = $_REQUEST['resv1'];
	$fy_ssn = $_REQUEST['fy_ssn'];
	$md5 = $_REQUEST['md5'];
    
	$_data = $mchnt_cd . "|" . $order_id . "|" . $order_date . "|" . $order_amt . "|" . $order_st . "|" . $order_pay_code . "|" . $order_pay_error . "|" . $resv1 . "|" . $fy_ssn . "|" . $mchnt_key ;
	
	$_md5 = md5($_data); 
	
 
		
        //开始初始化参数
        $payment_notice_id = $order_id;
    	$money = $order_amt;
    	$payment_id = $payment['id'];   
    	$outer_notice_sn = $order_id;

		//file_put_contents("2345.txt",json_encode($request),FILE_APPEND);
 
        if ($_md5==$md5&&$order_st == '11')
		{			
		

			$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where notice_sn = '".$payment_notice_id."'");
			$order_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_order where id = ".$payment_notice['order_id']);
			require_once APP_ROOT_PATH."system/libs/cart.php";
			$rs = payment_paid($payment_notice['id']);						
			if($rs)
			{
				$rs = order_paid($payment_notice['order_id']);				
				if($rs)
				{
					//开始更新相应的outer_notice_sn					
					$GLOBALS['db']->query("update ".DB_PREFIX."payment_notice set outer_notice_sn = '".$outer_notice_sn."' where id = ".$payment_notice['id']);
					//还款
					//$this->auto_do_deal_repay($payment_notice,$order_info);	
					
					//$this->auto_do_send_goods($payment_notice,$order_info);					
					if($order_info && $order_info['type']==0)
					app_redirect(url("index","payment#done",array("id"=>$payment_notice['order_id']))); //支付成功
					else
					app_redirect(url("index","payment#incharge_done",array("id"=>$payment_notice['order_id']))); //支付成功
				}
				else 
				{
					if($order_info['pay_status'] == 2)
					{				
						//还款
						//$this->auto_do_deal_repay($payment_notice,$order_info);	
						
						//$this->auto_do_send_goods($payment_notice,$order_info);		
						if($order_info['type']==0)
						app_redirect(url("index","payment#done",array("id"=>$payment_notice['order_id']))); //支付成功
						else
						app_redirect(url("index","payment#incharge_done",array("id"=>$payment_notice['order_id']))); //支付成功
					}
					else
					app_redirect(url("index","payment#pay",array("id"=>$payment_notice['id']))); 
				}
			}
			else
			{
				//还款
				//$this->auto_do_deal_repay($payment_notice,$order_info);	
				
				//$this->auto_do_send_goods($payment_notice,$order_info);		
				app_redirect(url("index","payment#pay",array("id"=>$payment_notice['id']))); 
			}
			
			
	     
		}else{
		    //showErr($GLOBALS['payment_lang']["PAY_FAILED"]);
			showErr("支付失败",0,url("index"),1);
		}   
	}
	
	public function notify($request)
	{
		$payment = $GLOBALS['db']->getRow("select id,config from ".DB_PREFIX."payment where class_name='fuiou'");  
    	$payment['config'] = unserialize($payment['config']);
    	
		
	$mchnt_key =$payment['config']['fuiou_key'];


    $mchnt_cd = $_REQUEST['mchnt_cd'];
	$order_id = $_REQUEST['order_id'];
	$order_date = $_REQUEST['order_date'];
	$order_amt = $_REQUEST['order_amt'];
	$order_st = $_REQUEST['order_st'];
    $order_pay_code = $_REQUEST['order_pay_code'];
    $order_pay_error = $_REQUEST['order_pay_error'];
	$resv1 = $_REQUEST['resv1'];
	$fy_ssn = $_REQUEST['fy_ssn'];
	$md5 = $_REQUEST['md5'];
    
	$_data = $mchnt_cd . "|" . $order_id . "|" . $order_date . "|" . $order_amt . "|" . $order_st . "|" . $order_pay_code . "|" . $order_pay_error . "|" . $resv1 . "|" . $fy_ssn . "|" .$mchnt_key ;
	
	$_md5 = md5($_data); 
	
 
		
        //开始初始化参数
        $payment_notice_id = $order_id;
    	$money = $order_amt;
    	$payment_id = $payment['id'];   
    	$outer_notice_sn = $order_id;

		file_put_contents("fuionpay.txt",json_encode($request)."\r\n",FILE_APPEND);
        file_put_contents("fuionpay.txt",$_data."\r\n",FILE_APPEND);
		file_put_contents("fuionpay.txt",$_md5.'***'.$md5."\r\n",FILE_APPEND);
        if ($_md5==$md5&&$order_st == '11')

		{	
		    file_put_contents("fuionpay.txt","succ ok!\r\n",FILE_APPEND);					
			
			$payment_notice = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment_notice where notice_sn = '".$payment_notice_id."'");
			$order_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_order where id = ".$payment_notice['order_id']);
			require_once APP_ROOT_PATH."system/libs/cart.php";
			$rs = payment_paid($payment_notice['id']);								
			if($rs)
			{			
				$GLOBALS['db']->query("update ".DB_PREFIX."payment_notice set outer_notice_sn = '".$outer_notice_sn."' where id = ".$payment_notice['id']);				
				order_paid($payment_notice['order_id']);	
				//还款
				//$this->auto_do_deal_repay($payment_notice,$order_info);	
				
				//$this->auto_do_send_goods($payment_notice,$order_info);					
				echo "200";
			}
			else
			{
				//还款
				//$this->auto_do_deal_repay($payment_notice,$order_info,0);	
				
				//$this->auto_do_send_goods($payment_notice,$order_info);		
				 echo 'error';
			}
			
		
			
		}else{
		    echo 'error';
		} 
	}
	
	
	function get_display_code(){
		$payment_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment where class_name='fuiou'");
		if($payment_item)
		{
			$html = "<label class='f_l ui-radiobox common_payment_checked' rel='common_payment' style='background:url(".APP_ROOT.$payment_item['logo'].")' title='".$payment_item['name']."'>".
					"<input type='radio' name='payment' value='".$payment_item['id']."' checked='checked' />&nbsp;";
					if($payment_item['logo']==""){
						$html .=$payment_item['name'];
					}
					$html .= "</label>";
			return $html;
		}
		else
		{
			return '';
		}
	}	
	
	public function get_display_code2()

	{

		$payment_item = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."payment where class_name='fuiou'");

		if($payment_item)

		{

			$html = "<div style='float:left;'>".

					"<input type='radio' name='payment' value='".$payment_item['id']."' /></div>";

			if($payment_item['logo']!='')

			{

				$html .= "<div style='float:left;border:solid 1px #efefef;margin-left:10px;padding-left:10px;'><img style='height:30px' src='".APP_ROOT.$payment_item['logo']."' /></div>";

			}

			$html .= "<div style='float:left; padding-left:10px;'>".nl2br($payment_item['description'])."</div>";

			return $html;

		}

		else

		{

			return '';

		}

	}

}
?>