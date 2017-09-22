<?php
// +----------------------------------------------------------------------
// | Fanwe 方维p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2011 http://www.fanwe.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 来来1号店(QQ:125050230)
// +----------------------------------------------------------------------


require APP_ROOT_PATH.'app/Lib/page.php';
require APP_ROOT_PATH.'app/Lib/uc.php';
class deal_msgboard
{
	public function index()
	{	
	
	$root = get_baseroot();
		$user =  $GLOBALS['user_info'];
		$root['session_id'] = es_session::id();
		$user_id  = intval($user['id']);
	
		
		if ($user_id >0){
			$root['user_login_status'] = 1;		
			$root['response_code'] = 1;
			$root['user_info'] = $user;
			$root['program_title'] = "申请贷款";
			
			
			$loan_type_list = load_auto_cache("deal_loan_type_list");
			
			
    	foreach($loan_type_list as $k=>$v){
    		if($v['credits']!=""){
    			$loan_type_list[$k]['credits'] = unserialize($v['credits']);
    			if(!is_array($loan_type_list[$k]['credits'])){
					$loan_type_list[$k]['credits'] = array();
				}
    		}
    		else
    			$loan_type_list[$k]['credits'] = array();
    	}
			
			$root['usefulness_type_list'] = $loan_type_list;
			
			
		

		}
	
	output($root);			
		
		
		
		
	}
	
	
}
?>