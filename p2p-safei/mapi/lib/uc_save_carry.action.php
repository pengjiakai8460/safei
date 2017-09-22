<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
//require APP_ROOT_PATH.'app/Lib/uc.php';
class uc_save_carry
{
	public function index(){
		
		$root = array();
		
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){
			require APP_ROOT_PATH.'app/Lib/uc_func.php';
			
			$root['user_login_status'] = 1;
									
			$paypassword = strim($GLOBALS['request']['paypassword']);
			$amount = floatval($GLOBALS['request']['amount']);
			$bid = intval($GLOBALS['request']['bid']);
			
			$region_lv1 = intval($GLOBALS['request']['region_lv1']);
			$region_lv2 = intval($GLOBALS['request']['region_lv2']);
			$region_lv3 = intval($GLOBALS['request']['region_lv3']);
			$region_lv4 = intval($GLOBALS['request']['region_lv4']);
				
			$bankzone = trim($GLOBALS['request']['bankzone']);
			
			$result = getUcSaveCarry2($amount,$region_lv1,$region_lv2,$region_lv3,$region_lv4,$bankzone,$paypassword,$bid);
			 
			$root['response_code'] = $result['status'];
			$root['show_err'] = $result['show_err'];
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		output($root);		
	}
}
?>