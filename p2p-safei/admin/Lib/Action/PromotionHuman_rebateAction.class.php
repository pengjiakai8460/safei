<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------

class PromotionHuman_rebateAction extends CommonAction{
	public function index()
	{	
		$user_name  = trim($_REQUEST['user_name']);
		$condition = "  user_type = 3 and is_delete = 0  ";
		
		if($user_name!=="" && $user_name!=0)
		$condition.=" and user_name like '%".$user_name."%' ";
		
		
		$count = $GLOBALS['db']->getOne("SELECT count(*) from ".DB_PREFIX."user where $condition ");
	
		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		
		$p = new Page ( $count, $listRows );
		if($count>0){
			$sql = "SELECT *,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,AES_DECRYPT(email_encrypt,'".AES_DECRYPT_KEY."') as email,AES_DECRYPT(idno_encrypt,'".AES_DECRYPT_KEY."') as idno,AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."') as money,AES_DECRYPT(mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile FROM ".DB_PREFIX."user  WHERE $condition order by id desc LIMIT ".($p->firstRow . ',' . $p->listRows);

			$list = $GLOBALS['db']->getAll($sql);
			
			foreach($list as $k=>$v){
				//邀请人数
				$list[$k]['p_count'] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user where pid = ".$list[$k]['id']);
				//投资借款
				$list[$k]['sta'] = $GLOBALS['db']->getRow("SELECT sum(load_count) as invest_count,sum(load_money) as invest_money,sum(deal_count) as borrow_count,sum(borrow_amount) as borrow_money FROM ".DB_PREFIX."user u left join ".DB_PREFIX."user_sta us on u.id = us.user_id  WHERE  u.pid = ".$list[$k]['id']);
				//投资返佣
				$list[$k]['invest_rebate'] = $GLOBALS['db']->getRow("select sum(manage_interest_money_rebate) as rebate_fee,sum(true_manage_interest_money_rebate) as true_rebate_fee from ".DB_PREFIX."deal_load_repay dlr left join ".DB_PREFIX."user u on dlr.user_id = u.id where has_repay =1 and u.pid = ".$list[$k]['id']);
				$list[$k]['borrow_rebate'] = $GLOBALS['db']->getRow("select sum(manage_money_rebate) as rebate_fee,sum(true_manage_money_rebate) as true_rebate_fee from ".DB_PREFIX."deal_repay dl left join ".DB_PREFIX."user u on dl.user_id = u.id where has_repay =1 and u.pid = ".$list[$k]['id']);
				//借款
				//$list[$k]['borrow'] = $GLOBALS['db']->getOne("select sum(repay_money-self_money+impose_money) from ".DB_PREFIX."deal_load_repay where user_id = ".$list[$k]['id']);	
			}
			$this->assign("list",$list);
		}
	
		$page = $p->show();
		$this->assign ( "page", $page );
		$this->display();
	}
	
}
?>