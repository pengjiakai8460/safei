<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------

define(MODULE_NAME,"debit");
require APP_ROOT_PATH.'app/Lib/deal.php';
class debitModule extends SiteBaseModule
{
	public function index()
	{			
		$GLOBALS['tmpl']->caching = true;
		$GLOBALS['tmpl']->cache_lifetime = 600;  //首页缓存10分钟
		$cache_id  = md5(MODULE_NAME.ACTION_NAME);	
		if (!$GLOBALS['tmpl']->is_cached("page/index.html", $cache_id))
		{		
			change_deal_status();
			
			//获取首页显示白条
			//$deal_list =  get_deal_list(20,0,"publish_wait =0 AND deal_status in (1,2,4) and is_index_show = 1 "," deal_status ASC, is_recommend DESC,sort DESC,id DESC");
			
			$list = $GLOBALS["db"]->getAll("select * from ".DB_PREFIX."deal_show order by sort desc");
			foreach($list as $k => $v)
			{
				if($v["create_time"])
				{
					$list[$k]["l_time"] = floor ((TIME_UTC - $v["create_time"])/60)%30;
				}
			}

			$GLOBALS['tmpl']->assign("deal_list",$list);
			
			/*$list1 = $GLOBALS["db"]->getAll("select * from ".DB_PREFIX."deal_show where show_left = 0 order by sort desc");
			
			foreach($list1 as $k => $v)
			{
				$list1[$k]["l_time"] = floor ((TIME_UTC - $v["create_time"])/60);
			}
			$GLOBALS['tmpl']->assign("deal_list1",$list1);*/
			
			/*白条类型*/
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
			
			$GLOBALS['tmpl']->assign('loan_type_list',$loan_type_list);
			
			
			/*白条金额*/
			$debit_conf = $GLOBALS["db"]->getOne("select borrow_amount_cfg from ".DB_PREFIX."debit_conf");
			$debit_conf = unserialize($debit_conf);
			$GLOBALS['tmpl']->assign("debit",$debit_conf);
			
			/*月份*/
			$level_list = load_auto_cache("level");
			$replay_list = $level_list["repaytime_list"];
			$GLOBALS['tmpl']->assign("replay_list",reset($replay_list));
		}
		
		$GLOBALS['tmpl']->display("debit/debit_index.html",$cache_id);
	}
}	
?>