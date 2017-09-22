<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
//require APP_ROOT_PATH.'app/Lib/uc.php';
class integral_mall
{
	public function index(){
		
		$root = get_baseroot();
		
		$email = strim($GLOBALS['request']['email']);//用户名或邮箱
		$pwd = strim($GLOBALS['request']['pwd']);//密码
		
		$page = intval($GLOBALS['request']['page']);
		$cates = intval($GLOBALS['request']['cates']);
		$integral = intval($GLOBALS['request']['integral']);
		$sort = intval($GLOBALS['request']['sort']); 
		
		
		//检查用户,用户密码
//		$user = user_check($email,$pwd);
//		$user_id  = intval($user['id']);
//		if ($user_id >0){
			require APP_ROOT_PATH.'app/Lib/deal.php';
			
			$root['user_login_status'] = 1;
			$root['response_code'] = 1;
			
			//输出投标列表
			//$page = intval($_REQUEST['p']);
			if($page==0)
				$page = 1;
			$limit = (($page-1)*app_conf("DEAL_PAGE_SIZE")).",".app_conf("DEAL_PAGE_SIZE"); 
			$condition = " 1=1";
		    if($sort == 1){
				$condition .= " AND is_new = 1";
			}elseif($sort == 2)
			{
				$condition .= " AND is_hot = 1 ";
			}elseif ($sort == 3)
			{
				$orderby = " score desc";
			}
			
			if($cates>0){
				$cates_id = $GLOBALS['db']->getAll("select id from ".DB_PREFIX."goods_cate where pid = ".$cates);
				$flatmap = array_map("array_pop",$cates_id);
				$cates_ids=implode(',',$flatmap);
				if($cates_ids=="") 
				{
					$condition .= " AND cate_id in (".$cates.") ";
				}else{
					$condition .= " AND cate_id in (".$cates.",".$cates_ids.") ";
				}
				
			}
			
			if($integral==0){
				$condition .= "";
			}elseif ($integral==1){
				$condition .= " AND score  <= 500";
			}elseif ($integral==2){
				$condition .= " AND score  between 500 and 1000";
			}elseif ($integral==3){
				$condition .= " AND score  between 1000 and 3000";
			}elseif ($integral==4){
				$condition .= " AND score  between 3000 and 5000";
			}else{
				$condition .= " AND score  >= 5000";
			}
			

			$count_sql = "select count(*) from ".DB_PREFIX."goods where 1=1  ";
			$sql = "select * from ".DB_PREFIX."goods where 1=1 ";
			$where = $condition;
			if($where != '')
			{
				$sql.=" and ".$where;
				$count_sql.=" and ".$where;
			}
		
			if($orderby=='')
				$sql.=" order by sort desc ";
			else
				$sql.=" order by ".$orderby;
		
			if($limit!=""){
				$sql .=" limit ".$limit;
			}
			
			$goods_count = $GLOBALS['db']->getOne($count_sql);
            $adv_list = array();
			if($goods_count > 0){
				$goods = $GLOBALS['db']->getAll($sql);
				
				foreach($goods as $k=>$v){
					if ($v['img'] != '')
						$v['img'] = get_abs_wap_url_root(get_abs_img_root($v['img']));
					$adv_list[] = $v;
				}
				
			}
			//return array('list'=>$goods,'count'=>$goods_count);
			
						
			$root['goods_list'] = $adv_list;

			$root['page'] = array("page"=>$page,"page_total"=>ceil($goods_count/app_conf("DEAL_PAGE_SIZE")),"page_size"=>app_conf("DEAL_PAGE_SIZE"));
			
			$page_args['cates'] =  $cates;
			$page_args['integral'] =  $integral;
			$page_args['sort'] =  $sort;
			
			//商品类别
			$cates_urls =load_auto_cache("score_cates");
			$cates_url = array();
			
			$cates_url[0]['id'] = 0;
			$cates_url[0]['name'] = "不限";
			$tmp_args = $page_args;
			$tmp_args['cates'] = 0;
			$cates_url[0]['url'] = wap_url("index","integral_mall",$tmp_args);
			foreach($cates_urls as $k=>$v){
				$cates_url[$k+1]['id'] = $v['id'];
				$cates_url[$k+1]['name'] = $v['name'];
				$tmp_args = $page_args;
				$tmp_args['cates'] = $v['id'];
				$cates_url[$k+1]['url'] = wap_url("index","integral_mall",$tmp_args);
			}
			$root['cates_url'] = $cates_url;
			
			//积分范围
			$integral_url = array(
					array(
							"id" => 0,
							"name" => "不限",
					),
					array(
							"id" => 1,
							"name" => "500积分以下",
					),
					array(
							"id" => 2,
							"name" => "500-1000积分",
					),
					array(
							"id" => 3,
							"name" => "1000-3000积分",
					),
					array(
							"id" => 4,
							"name" => "3000-5000积分",
					),
					array(
							"id" => 5,
							"name" => "5000积分以上",
					),
			);
			foreach($integral_url as $k=>$v){
				$tmp_args = $page_args;
				$tmp_args['integral'] = $k;
				$integral_url[$k]['url'] = wap_url("index","integral_mall",$tmp_args);
			}
			
			$root['integral_url'] = $integral_url;
			
			$sort_url = array(
					array(
							"id" => 0,
							"name" => "默认排序",
					),
					array(
							"id" => 1,
							"name" => "最新",
					),
					array(
							"id" => 2,
							"name" => "热门",
					),
					array(
							"id" => 3,
							"name" => "积分",
					),
			);
			foreach($sort_url as $k=>$v){
				$tmp_args = $page_args;
				$tmp_args['sort'] = $k;
				$sort_url[$k]['url'] = wap_url("index","integral_mall",$tmp_args);
			}
			$root['sort_url'] = $sort_url;
			
			$cates = intval($GLOBALS['request']['cates']);
			$root['cates'] = $cates;
			$integral = intval($GLOBALS['request']['integral']);
			$root['integral'] = $integral;
			$sort = intval($GLOBALS['request']['sort']); 
			$root['sort'] = $sort;
//		}else{
//			$root['response_code'] = 0;
//			$root['show_err'] ="未登录";
//			$root['user_login_status'] = 0;
//		}
		$root['program_title'] = "积分商城";
		output($root);		
	}
}
?>
