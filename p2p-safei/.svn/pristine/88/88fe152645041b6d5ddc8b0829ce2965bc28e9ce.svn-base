<?php
// +----------------------------------------------------------------------
// | Fanwe 方维p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 来来1号店(QQ:125050230)
// +----------------------------------------------------------------------


class save_deal_msgboard
{
	public function index()
	{	
	 
	$root = get_baseroot();
	$verify = addslashes(htmlspecialchars(trim($GLOBALS['request']['verify_code'])));//验证码		
	$money = addslashes(htmlspecialchars(trim($GLOBALS['request']['money'])));
	$mobile = addslashes(htmlspecialchars(trim($GLOBALS['request']['mobile'])));
	
		$root["user_name"] = trim($GLOBALS['request']['user_name']);
		$root["ID_NO"] = trim($GLOBALS['request']['ID_NO']);
		$root["mobile"] = addslashes(htmlspecialchars(trim($GLOBALS['request']['mobile'])));
		$root["money"] = addslashes(htmlspecialchars(trim($GLOBALS['request']['money'])));
		$root["time_limit"] = trim($GLOBALS['request']['time_limit']);
		$root["usefulness"] = $GLOBALS["db"]->getOne("select name from ".DB_PREFIX."deal_loan_type where id = ".intval($GLOBALS['request']['usefulness']));
		$root["create_time"] = to_date(TIME_UTC);
		$root["status"] = 0;
		$root["unit"] = trim($GLOBALS['request']['unit']);
	
	
	
	file_put_contents("data.txt",$root);  
	


		
		if($root["user_name"]==""){
			$root['response_code'] = 0;
			$root['show_err'] = "请填写您的真实姓名";
			output($root);
		}		
		
		
			if($verify==""){
			$root['response_code'] = 0;
			$root['show_err'] = $GLOBALS['lang']['BIND_MOBILE_VERIFY_ERROR'];
			output($root);
		}		
		
		
		
		
			if($root["money"] <= 0)
		{
			$root['response_code'] = 0;
			$root['show_err'] = "请填写贷款金额";
			output($root);
		}
		if($root["time_limit"]=="")
		{
			$root['response_code'] = 0;
			$root['show_err'] = "请填写贷款期限";
			output($root);
		}
		

  
  	$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		$root['user_id'] = $user_id;
		if ($user_id >0){


		$sql = "select id,code from ".DB_PREFIX."user where mobile_encrypt = AES_ENCRYPT('".$mobile."','".AES_DECRYPT_KEY."') and bind_verify = '".$verify."' and is_delete = 0";
		
		$user_info = $GLOBALS['db']->getRow($sql);
		$user_id = intval($user_info['id']);
		$code = $user_info['code'];
		
		if($user_id == 0)
		{
			$root['response_code'] = 0;
			$root['show_err'] = $GLOBALS['lang']['BIND_MOBILE_VERIFY_ERROR'];
			output($root);
		}else{
		
		
		
		$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msgboard",$root,'INSERT','','SILENT');
		$root['response_code'] = 1;
		$root['show_err'] = "提交成功,等待管理员审核";
		output($root);
		
		
		}
			
			
  
		}
  

		output($root);
		
		
	}
	
	
}
?>