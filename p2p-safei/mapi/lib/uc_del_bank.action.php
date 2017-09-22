<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
//require APP_ROOT_PATH.'app/Lib/uc.php';
class uc_del_bank
{
	public function index(){
		
		$root = get_baseroot();
		
		$id = strim($GLOBALS['request']['id']);
		
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
		if ($user_id >0){

			/*ly修改*/
			$user = $GLOBALS['db']->getRow("SELECT bank_change_money,id FROM ".DB_PREFIX."user where id = ".intval($GLOBALS['user_info']['id']));
			if($user['bank_change_money'] > 0)
			{
				$root['response_code'] = 0;
				$root['show_err'] = "本卡充值的金额还未全部提出";
				output($root);
			}

			$root['user_login_status'] = 1;
			
			$GLOBALS['db']->query("DELETE FROM ".DB_PREFIX."user_bank where user_id=".$user_id." and id in (".$id.")");
			
			if($GLOBALS['db']->affected_rows()){

				/*ly修改*/
				$GLOBALS['db']->getRow("update ".DB_PREFIX."user set bank_change_money = 0 , is_bank = 0 where id = ".intval($GLOBALS['user_info']['id']));
				
				$root['response_code'] = 1;
				$root['show_err'] = $GLOBALS['lang']['DELETE_SUCCESS'];
			}else{
				$root['response_code'] = 0;
				$root['show_err'] = "删除失败";
			}		
		}else{
			$root['response_code'] = 0;
			$root['show_err'] ="未登录";
			$root['user_login_status'] = 0;
		}
		output($root);		
	}
}
?>
