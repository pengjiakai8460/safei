<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
//执行正常还款
class uc_do_quick_refund
{
	public function index(){
		
		$root = array();
		
		$id = intval($GLOBALS['request']['id']);
		$ids = strim($GLOBALS['request']['ids']);
		$paypassword = strim($GLOBALS['request']['paypassword']);	
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
			require APP_ROOT_PATH.'app/Lib/deal.php';
			
			$root['user_login_status'] = 1;
			
			if($paypassword==""){
				$root['response_code'] = 0;
				$root["show_err"] = $GLOBALS['lang']['PAYPASSWORD_EMPTY'];
				output($root);
			}
		
			if(md5($paypassword)!=$GLOBALS['user_info']['paypassword']){
				$root['response_code'] = 0;
				$root["show_err"] = $GLOBALS['lang']['PAYPASSWORD_ERROR'];
				output($root);
			}
									
			$result = getUcRepayBorrowMoney($id,$ids);
			
			$root['status'] = $result['status'];
			if($result['status'] == 2){				
				$root['response_code'] = 1;
				$root['app_url'] = $result['jump'];
				$root["show_err"] = "还款中，请稍后";
			}else{
				$root['response_code'] = $result['status'];
				$root['app_url'] = "";
				$root['show_err'] = $result['show_err'];
			}
			
			output($root);
			
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		output($root);
	}
}
?>
