<?php
// +----------------------------------------------------------------------
// | easethink 易想商城系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
require APP_ROOT_PATH."system/wechat/CIpLocation.php";
require APP_ROOT_PATH."system/wechat/platform_wechat.class.php";
require APP_ROOT_PATH."system/libs/words.php";

class DealAction extends CommonAction{
	public function index()
	{
		
		//开始加载搜索条件
		$map['is_delete'] = 0;
		$map['publish_wait'] = 0;
		
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}
		
		if(trim($_REQUEST['user_id'])!='')
		{
			$_REQUEST['user_name'] = $GLOBALS["db"]->getOne("select user_name from ".DB_PREFIX."user where id = '".strim($_REQUEST['user_id'])."'");		
		}
		
		if(trim($_REQUEST['work_id'])!='')
		{
			$admin_id = $GLOBALS["db"]->getOne("select id from ".DB_PREFIX."admin where work_id = '".strim($_REQUEST['work_id'])."'");
			if($admin_id>0)
				$map['admin_id'] = array('eq',intval($admin_id));
		}

		$deal_status = isset($_REQUEST['deal_status']) ? trim($_REQUEST['deal_status']) : 'all';

		if(isset($_REQUEST['is_has_received']) && trim($_REQUEST['is_has_received']) != 'all'){
			$map['is_has_received'] = array("eq",intval($_REQUEST['is_has_received']));
			$map['buy_count'] = array("gt",0);
		}
		
		
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],$deal_status);
		
		$this->display ();
		return;
	}
	
	function ing(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,0,'',1);
		$this->display ("index");
		return;
	}
	
	function advance(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}
		$map['is_advance'] = 1;
		$map['publish_wait'] = 0;
		$this->getDeallist($map);
		$this->display ("index");
		return;
	}
	
	function news(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}
		$map['is_new'] = 1;
		$map['publish_wait'] = 0;
		$this->getDeallist($map);
		$this->display ("index");
		return;
	}
	
	
	function wait(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],'0');
		$this->display ("index");
		return;
	}
	function full(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],2);
		$this->display ("index");
		return;
	}
	
	function inrepay(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],4);
		$this->assign("show_rate",1);
		$this->display ("index");
		return;
	}
	
	function expire(){
				
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],6);
		$this->display ("index");
		return;		
	}
	
	function flow(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],3);
		$this->display ("index");
		return;
	}
	
	function over(){
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],5);
		$this->display ("index");
		return;
	}
	
	function penalty(){
		
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}
		
		$map['id'] = array("exp"," in (SELECT deal_id FROM ".DB_PREFIX."deal_inrepay_repay) ");

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],5);
		$this->display ("index");
		return;
	}
	
	public function publish()
	{
		$map['publish_wait'] = array("in","1,3");
		$map['is_delete'] = 0;
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ();
		return;
	}
	
	public function true_publish()
	{
		$map['publish_wait'] = array("eq",2);
		$map['is_delete'] = 0;
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$this->display ("Deal:publish");
		return;
	}
	
	
	function publish_edit(){
		$this->edit();
	}
	
	function publish_update(){
		B('FilterString');
		$data = M(MODULE_NAME)->create ();
		
		$log_info = M(MODULE_NAME)->where("id=".intval($data['id']))->getField("name");
		//开始验证有效性
		$this->assign("jumpUrl","javascript:history.back(-1);");
		if(!check_empty($data['name']))
		{
			$this->error(L("DEAL_NAME_EMPTY_TIP"));
		}	
		if(!check_empty($data['sub_name']))
		{
			$this->error(L("DEAL_SUB_NAME_EMPTY_TIP"));
		}		
		if($data['cate_id']==0)
		{
			$this->error(L("DEAL_CATE_EMPTY_TIP"));
		}
		if($data['uloadtype']==1)
		{
			if($data['portion']<1 || $data['portion']==1){
				$this->error("份额数需大于1，且为整数");
				exit;
			}else{
				if(ereg("^[0-9]*[1-9][0-9]*$",$data['portion'])!=1){
					$this->error("份额数需为整数!");
					exit;
				}
			}
		}
		
		if(D("Deal")->where("deal_sn='".$data['deal_sn']."' and id<>".$data['id'])->count() > 0){
			$this->error("借款编号已存在");
		}
		
		$loantype_list = load_auto_cache("loantype_list");
		if(!in_array($data['repay_time_type'],$loantype_list[$data['loantype']]['repay_time_type'])){
			$this->error("还款方式不支持当前借款期限类型");
		}
		
		$data['update_time'] = TIME_UTC;
		if($data['is_delete']==3){
			$data['publish_wait'] = 1;
		}
		else{
			$data['publish_wait'] = 2;
		}
		
		$data['start_time'] = trim($data['start_time'])==''?0:to_timespan($data['start_time']);
		if($data['start_time'] > 0)
			$data['start_date'] = to_date($data['start_time'],"Y-m-d");
		
		$user_info = M("User") -> getById($data['user_id']);
		$old_imgdata_str = unserialize($user_info['view_info']);

		
		$data['view_info'] = array();
		foreach($_REQUEST['key'] as $k=>$v){
			if(isset($old_imgdata_str[$v])){
				$data['view_info'][$v] = $old_imgdata_str[$v];
			}
		}
		$data['view_info'] = serialize($data['view_info']);
		
		if($data['deal_status'] == 4){
			if($GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load where deal_id=".$data['id']) <floatval($data['borrow_amount'])){
				$this->error("未满标无法设置为还款状态!");
				exit();
			}
		}
		
		if($data['agency_id']!=M("Deal")->where("id=".$data['id'])->getField("agency_id")){
			$data['agency_status'] = 0;
		}
		
		$data['mortgage_infos'] = $this->mortgage_info();
		$data['mortgage_contract'] = $this->mortgage_info("contract");
		// 更新数据
		$list=M(MODULE_NAME)->save($data);
		if (false !== $list) {
			
			M("DealCityLink")->where ("deal_id=".$data['id'])->delete();
			foreach($_REQUEST['city_id'] as $k=>$v){
				if(intval($v) > 0){
					$deal_city_link['deal_id'] = $data['id'];
					$deal_city_link['city_id'] = intval($v);
					M("DealCityLink")->add ($deal_city_link);
				}
				
			}
			
			require_once(APP_ROOT_PATH."app/Lib/common.php");
			if($data['is_delete']==3){
				//发送失败短信通知
				if(app_conf("SMS_ON")==1 && app_conf('SMS_DEAL_DELETE')==1){
					$user_info  = D("User")->where("id=".$data['user_id'])->find();
					$deal_info = D("Deal")->where("id=".$data['id'])->find();
						
					$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_DEAL_DELETE'");				
					$tmpl_content = $tmpl['content'];
									
					$notice['user_name'] = $user_info["user_name"];
					$notice['deal_name'] = $data['name'];
					$notice['site_name'] = app_conf("SHOP_TITLE");
					$notice['delete_msg'] = $data['delete_msg'];
					$notice['deal_publish_time'] = to_date($deal_info['create_time'],"Y年m月d日");
					
					$GLOBALS['tmpl']->assign("notice",$notice);
					
					$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
					
					$msg_data['dest'] = $user_info['mobile'];
					$msg_data['send_type'] = 0;
					$msg_data['title'] = "审核失败通知";
					$msg_data['content'] = addslashes($msg);;
					$msg_data['send_time'] = 0;
					$msg_data['is_send'] = 0;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['user_id'] = $user_info['id'];
					$msg_data['is_html'] = $tmpl['is_html'];
					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入	
				}
				
				//借款审核结果通知
				if(app_conf("WEIXIN_MSG")==1){
					$user_info = get_user_info("*","id = ".$data['user_id']);
					if($user_info['wx_openid']!='')
					{
						$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."weixin_tmpl where template_id_short='OPENTM204320762' ");
						$deal_info = D("Deal")->where("id=".$data['id'])->find();
						$deal_publish_time = to_date($deal_info['create_time'],"Y年m月d日");
						$weixin_data['first'] = array('value'=>$user_info["user_name"].'您于'.$deal_publish_time.'发布的借款'.$data['name'],'color'=>'#173177');
						$weixin_data['keyword1']=array('value'=>'失败','color'=>'#173177');
						$weixin_data['keyword2']=array('value'=>$data['delete_msg'],'color'=>'#173177');
						
						weixin_tmpl_send($tmpl['template_id'],$user_info['id'],$weixin_data);
					}
				}
			}
			
			//成功提示
			save_log("编号：".$data['id']."，".$log_info."初审更新成功",1);
			$this->assign("jumpUrl",u(MODULE_NAME."/publish"));
			$this->success("初审更新成功");
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log("编号：".$data['id']."，".$log_info."初审更新失败".$dbErr,0);
			$this->error("初审更新失败".$dbErr,0);
		}
	}
	
	function true_publish_update(){
		B('FilterString');
		
		$data['id'] = intval($_REQUEST['id']);
		
		$log_info = M(MODULE_NAME)->where("id=".intval($data['id']))->getField("name");
		
		$data['update_time'] = TIME_UTC;
		$data['publish_wait'] = intval($_REQUEST['publish']);
		if($data['publish_wait']==3){
			$data['publish_memo'] = trim($_REQUEST['publish_msg']);
		}
		
		// 更新数据
		$list=M(MODULE_NAME)->save($data);
		if (false !== $list) {
			if($data['publish_wait'] == 0){
				//成功提示
				syn_deal_status($data['id']);
				syn_deal_match($data['id']);
			}
			//成功提示
			save_log("编号：".$data['id']."，".$log_info."复审更新成功",1);
			$this->assign("jumpUrl",u(MODULE_NAME."/true_publish"));
			$this->success("复审更新成功");
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log("编号：".$data['id']."，".$log_info."复审更新失败".$dbErr,0);
			$this->error("复审更新失败".$dbErr,0);
		}
	}
	
	private function getDeallist($map,$cate_id=0,$user_name="",$deal_status="all"){
		$loantype_list = load_auto_cache("loantype_list");
    	$this->assign("loantype_list",$loantype_list);
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		$this->assign("cate_tree",$cate_tree);
		
		$type_tree = M("DealLoanType")->where('is_delete = 0')->findAll();
		$type_tree = D("DealLoanType")->toFormatTree($type_tree,'name');
		$this->assign("type_tree",$type_tree);
		
		$citys_tree = M("DealCity")->where('is_delete= 0 ')->findAll();
		$citys_tree = D("DealCity")->toFormatTree($citys_tree,'name');
		$this->assign("citys_tree",$citys_tree);
		
		if($cate_id>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds($cate_id);
			$cate_ids[] = $cate_id;
			$map['cate_id'] = array("in",$cate_ids);
		}
		
		if(intval($_REQUEST['type_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_loan_type");
			$type_ids = $child->getChildIds(intval($_REQUEST['type_id']));
			$type_ids[] = intval($_REQUEST['type_id']);
			$map['type_id'] = array("in",$type_ids);
		}
		
		
		if(intval($_REQUEST['city_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_city");
			$city_ids = $child->getChildIds(intval($_REQUEST['city_id']));
			$city_ids[] = intval($_REQUEST['city_id']);
			$deal_ids = $GLOBALS['db']->getOne("select group_concat(deal_id) from ".DB_PREFIX."deal_city_link where city_id in (".implode(",",$city_ids).")");
			$map['id'] = array("in",$deal_ids);
		}
		
		if(isset($_REQUEST['loantype']) && intval($_REQUEST['loantype']) != -1)
		{
			$map['loantype'] = array("eq",intval($_REQUEST['loantype']));
		}
		else{
			$_REQUEST['loantype'] = -1;
		}
		
		
		if(trim($user_name)!='')
		{
			$sql  ="select group_concat(id) from ".DB_PREFIX."user where user_name like '%".trim($user_name)."%'";
			
			$ids = $GLOBALS['db']->getOne($sql);
			$map['user_id'] = array("in",$ids);
		}
		
		if($deal_status != "all"){
			if($deal_status==6){
				$map['deal_status'] =  array("eq",1);
				$map['start_time'] = array("exp"," < ".TIME_UTC." - enddate *24 *3600 ");
			}
			elseif($deal_status==1){//进行中 +过期
				$sw['deal_status'] = array("eq",$deal_status);
				$sws['deal_status'] = array("eq",1);
				$sws['start_time'] = array("exp"," + enddate *24 *3600 > ".TIME_UTC." ");
				$sws['_logic'] = 'and';
				
				$sw['_complex'] = $sws;
				
				$sw['_logic'] = 'AND';
				
				$map['_complex'] = $sw;
			}
			else{
				$map['deal_status'] =  array("eq",$deal_status);
			}
			
		}
		
		if(intval($_REQUEST['repay_time'])!=0){
			$map['repay_time'] = array("eq",intval($_REQUEST['repay_time']));
			if(intval($_REQUEST['repay_time_type'])!=0){
				$map['repay_time_type'] = array("eq",intval($_REQUEST['repay_time_type']) - 1);
			}
		}
		
		if(floatval($_REQUEST['borrow_amount'])!=0){
			$map['borrow_amount'] = array("eq",floatval($_REQUEST['borrow_amount']));
		}
		
		if(floatval($_REQUEST['rate'])!=0){
			$map['rate'] = array("eq",floatval($_REQUEST['rate']));
		}
		
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		$name=$this->getActionName();
		$model = D ($name);
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		//echo M()->getLastSql();
	}
	
	public function three()
	{
		$this->assign("main_title",L("DEAL_THREE"));
		
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "name":
			case "cate_id":
					$order ="d.".$sorder;
				break;
			case "has_repay_status":
					$order ="dl.status";
				break;
			case "site_bad_status":
					$order ="dl.is_site_bad";
				break;
			case "is_has_send":
					$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
					$order ="dl.l_key";
				break;
			default : 
				$order ="dl.".$sorder;
				break;
		}
		
	
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "ASC";
		}
		
		
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		$this->assign("cate_tree",$cate_tree);
		
		//开始加载搜索条件
		$condition =" 1=1 ";
		
		if(isset($_REQUEST['status'])){
			$status = intval($_REQUEST['status']);
			if($status >0){
				if(($status-1)==0)
					$condition .= " AND dl.has_repay=0 ";
				else
					$condition .= " AND dl.has_repay=1 and dl.status=".($status-2);
			}
		}
		else{
			$condition .= " AND dl.has_repay=0 ";
			$_REQUEST['status'] = 1;
		}
		
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
		
		$begin_time  = !isset($_REQUEST['begin_time'])? to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d")  : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])?to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d") + 2*24*3600: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and dl.repay_time >= $begin_time ";	
			}
			else
				$condition .= " and dl.repay_time between  $begin_time and ".($end_time+24*3600-1)." ";	
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
		
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dl.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";			
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition ";
	
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time,u.user_name,u.mobile FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id left join ".DB_PREFIX."user u on u.id=dl.user_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);
			
			foreach($list as $k=>$v){
				$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
				if($v['send_three_msg_time'] == $v['repay_time']){
					$list[$k]['is_has_send'] = 1;
				}
				else{
					$list[$k]['is_has_send'] = 0;
				}
				if($v['has_repay']==1){
					switch($v['status']){
						case 0;
							$list[$k]['has_repay_status'] = "提前还款";
							break;
						case 1;
							$list[$k]['has_repay_status'] = "准时还款";
							break;
						case 2;
							$list[$k]['has_repay_status'] = "逾期还款";
							break;
						case 3;
							$list[$k]['has_repay_status'] = "严重逾期";
							break;
					}
				}
				else{
					$list[$k]['has_repay_status'] = "<span style='color:red'>未还</span>";
				}
				
				if($v['is_site_bad'] == 1){
					$list[$k]['site_bad_status'] = "<span style='color:red'>坏账</span>";
				}
				else{
					$list[$k]['site_bad_status'] = "正常";
				}
			}
			
			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display ();
		return;
	}
	
	public function three_msg(){
		//开始加载搜索条件
		//开始加载搜索条件
		$condition =" 1=1 ";
		
		$status = intval($_REQUEST['status']);
		if($status >0){
			if(($status-1)==0)
				$condition .= " AND dl.has_repay=0 ";
			else
				$condition .= " AND dl.has_repay=1 and dl.status=".($status-2);
		}
		
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
		
		$begin_time  = !isset($_REQUEST['begin_time'])? to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d")  : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])?to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d") + 2*24*3600 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and dl.repay_time >= $begin_time ";	
			}
			else
				$condition .= " and dl.repay_time between  $begin_time and ".($end_time+24*3600-1)." ";	
		}
		
		
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dl.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";			
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition ";
	
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id WHERE $condition ORDER BY dl.repay_time ASC LIMIT ".$p->firstRow . ',' . $p->listRows;
			$list = $GLOBALS['db']->getAll($sql_list);			
		}
		$deal_ids = array();
		//发送信息
		foreach($list as $k=>$v){
			if($v['send_three_msg_time'] != $v['repay_time']){
				
				$deal_ids[]=$v['id'];
				
				$repay_money = $v['repay_money'] + $v['manage_money'] + $v['manage_impose_money'] + $v['impose_money'];
				//站内信  ($content = "您在".."的借款 “<a href=\"".url("index","deal",array("id"=>$v['id']))."\">".$v['name']."</a>”，最近一期还款将于".to_date($v['repay_time'],"d")."日到期，需还金额".round($repay_money,2)."元。")
				
				$group_arr = array(0,$v['user_id']);
				sort($group_arr);
				$group_arr[] =  4;
				
				$sh_notice['shop_title'] = app_conf("SHOP_TITLE");																		//站点名称
				$sh_notice['deal_name'] = "“<a href=\"".url("index","deal",array("id"=>$v['id']))."\">".$v['name']."</a>”";				//借款名称
				$sh_notice['repay_time'] = to_date($v['repay_time'],"d");																//还款时间
				$sh_notice['money'] = round($repay_money,2);																			//需还金额
				$GLOBALS['tmpl']->assign("sh_notice",$sh_notice);
				$tmpl_sz_failed_content = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_INS_DEAL_REPAY_SMS'",false);
				$sh_content = $GLOBALS['tmpl']->fetch("str:".$tmpl_sz_failed_content['content']);
				
				
				$msg_data['content'] = $sh_content;
				$msg_data['to_user_id'] = $v['user_id'];
				$msg_data['create_time'] = TIME_UTC;
				$msg_data['type'] = 0;
				$msg_data['group_key'] = implode("_",$group_arr);
				$msg_data['is_notice'] = 12;
				$msg_data['fav_id'] = $v['id'];
				
				$GLOBALS['db']->autoExecute(DB_PREFIX."msg_box",$msg_data);
				$id = $GLOBALS['db']->insert_id();
				$GLOBALS['db']->query("update ".DB_PREFIX."msg_box set group_key = '".$msg_data['group_key']."_".$id."' where id = ".$id);
				
				$user_info  = D("User")->where("id=".$v['user_id'])->find();
				
				//邮件
				if(app_conf("MAIL_ON")==1)
				{
					$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_DEAL_THREE_EMAIL'");
					$tmpl_content = $tmpl['content'];
					
					$notice['user_name'] = $user_info['user_name'];
					$notice['deal_name'] = $v['name'];
					$notice['deal_url'] = SITE_DOMAIN.url("index","deal",array("id"=>$v['id']));
					$notice['repay_url'] = SITE_DOMAIN.url("index","uc_deal#refund");
					$notice['repay_time_y'] = to_date($v['repay_time'],"Y");
					$notice['repay_time_m'] = to_date($v['repay_time'],"m");
					$notice['repay_time_d'] = to_date($v['repay_time'],"d");
					$notice['site_name'] = app_conf("SHOP_TITLE");
					$notice['repay_money'] = round($repay_money,2);
					$notice['help_url'] = SITE_DOMAIN.url("index","helpcenter");
					$notice['msg_cof_setting_url'] = SITE_DOMAIN.url("index","uc_msg#setting");
					
					$GLOBALS['tmpl']->assign("notice",$notice);
						
					$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
					$msg_data['dest'] = $user_info['email'];
					$msg_data['send_type'] = 1;
					$msg_data['title'] = "催款邮件通知";
					$msg_data['content'] = addslashes($msg);
					$msg_data['send_time'] = 0;
					$msg_data['is_send'] = 0;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['user_id'] = $user_info['id'];
					$msg_data['is_html'] = $tmpl['is_html'];
					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入
				}
				
				//短信
				if(app_conf("SMS_ON")==1 && app_conf('DEAL_THREE_SMS')==1)
				{
					$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_DEAL_THREE_SMS'");				
					$tmpl_content = $tmpl['content'];
									
					$notice['user_name'] = $user_info["user_name"];
					$notice['deal_name'] = $v['name'];
					$notice['repay_time_y'] = to_date($v['repay_time'],"Y");
					$notice['repay_time_m'] = to_date($v['repay_time'],"m");
					$notice['repay_time_d'] = to_date($v['repay_time'],"d");
					$notice['site_name'] = app_conf("SHOP_TITLE");
					$notice['repay_money'] = round($repay_money,2);
					
					$GLOBALS['tmpl']->assign("notice",$notice);
						
					$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
					
					$msg_data['dest'] = $user_info['mobile'];
					$msg_data['send_type'] = 0;
					$msg_data['title'] = "催款短信通知";
					$msg_data['content'] = addslashes($msg);;
					$msg_data['send_time'] = 0;
					$msg_data['is_send'] = 0;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['user_id'] = $user_info['id'];
					$msg_data['is_html'] = $tmpl['is_html'];
					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入				
				}
				
				//贷款还款提醒
				if(app_conf("WEIXIN_MSG")==1){
					$user_info = get_user_info("*","id = ".$user_info['id']);
					if($user_info['wx_openid']!='')
					{
						$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."weixin_tmpl where template_id_short='OPENTM400811886' ");
						$repay_time_d = to_date($v['repay_time'],"d");
						$repay_money = round($repay_money,2);
						$weixin_data['first'] = array('value'=>$user_info["user_name"].'您的贷款还款提醒','color'=>'#173177');
						$weixin_data['keyword1']=array('value'=>$repay_time_d,'color'=>'#173177');
						$weixin_data['keyword2']=array('value'=>$repay_money,'color'=>'#173177');
						weixin_tmpl_send($tmpl['template_id'],$user_info['id'],$weixin_data);
					}
				}
				
				$GLOBALS['db']->autoExecute(DB_PREFIX."deal",array("send_three_msg_time"=>$v['repay_time']),"UPDATE","id=".$v['deal_id']); 
			}
		}
		
		//成功提示
		if($deal_ids){
			save_log(implode(",",$deal_ids)."发送催款提示",1);
		}
		$this->success("发送成功");
		
	}
	
	function repay_log(){
		$id = intval($_REQUEST['id']);
		$deal_repay = $GLOBALS['db']->getRow("SELECT dr.*,dr.l_key + 1 as l_key_index,d.name FROM  ".DB_PREFIX."deal_repay dr LEFT JOIN ".DB_PREFIX."deal d ON d.id=dr.deal_id WHERE  dr.id=".$id);
		if(!$deal_repay){
			$this->error("账单不存在");
		}
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_repay_log WHERE repay_id= ".$id;
	
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT * FROM ".DB_PREFIX."deal_repay_log WHERE repay_id= ".$id." ORDER BY id DESC LIMIT ".$p->firstRow . ',' . $p->listRows;
			$list = $GLOBALS['db']->getAll($sql_list);
			
			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		$this->assign("list",$list);
		$this->assign("deal_repay",$deal_repay);
		$this->display ();
		
	}
	
	function op_status(){
		$id = intval($_REQUEST['id']);
		$deal_repay = $GLOBALS['db']->getRow("SELECT dr.*,dr.l_key + 1 as l_key_index,d.name FROM  ".DB_PREFIX."deal_repay dr LEFT JOIN ".DB_PREFIX."deal d ON d.id=dr.deal_id WHERE  dr.id=".$id);
		if(!$deal_repay){
			$this->error("账单不存在");
		}
		if($deal_repay['has_repay']==1){
			switch($deal_repay['status']){
				case 0;
					$deal_repay['has_repay_status'] = "提前还款";
					break;
				case 1;
					$deal_repay['has_repay_status'] = "准时还款";
					break;
				case 2;
					$deal_repay['has_repay_status'] = "逾期还款";
					break;
				case 3;
					$deal_repay['has_repay_status'] = "严重逾期";
					break;
			}
		}
		else{
			$deal_repay['has_repay_status'] = "<span style='color:red'>未还</span>";
		}
		
		if($deal_repay['is_site_bad'] == 1){
			$deal_repay['site_bad_status'] = "<span style='color:red'>坏账</span>";
		}
		else{
			$deal_repay['site_bad_status'] = "正常";
		}
		
		$this->assign("deal_repay",$deal_repay);
		$this->display();
	}
	
	public function do_op_status(){
		$id = intval($_REQUEST['id']);
		
		$deal_repay = $GLOBALS['db']->getRow("SELECT dr.*,dr.l_key + 1 as l_key_index,d.name FROM  ".DB_PREFIX."deal_repay dr LEFT JOIN ".DB_PREFIX."deal d ON d.id=dr.deal_id WHERE  dr.id=".$id);
		if(!$deal_repay){
			$this->error("账单不存在");
		}
		if(intval($_REQUEST['is_site_bad'])==0){
			$this->success("操作完成");
			die();
		}
		$adm_session = es_session::get(md5(conf("AUTH_KEY")));
		$msg = strim($_REQUEST['desc']);
		
		//VIP 坏账降级 
		$condition['id'] = $id;		
		$voss = M(MODULE_NAME)->where($condition)->find();
		$user_id = $voss['user_id'];
		$type = 2;
		$type_info = 7;
		$resultdate = syn_user_vip($user_id,$type,$type_info);
		
		
		$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_repay SET is_site_bad=".(intval($_REQUEST['is_site_bad']) -1)." WHERE id=".$id);
		if($GLOBALS['db']->affected_rows()){
			
			save_log($deal_repay['name']." 第 ".($deal_repay['l_key_index'] + 1)."期，坏账操作",1);
			
			repay_log($id,$msg,$deal_repay['user_id'],$adm_session['adm_id']);
			$this->success("操作成功");
			
		}
		else{
			save_log($deal_repay['name']." 第 ".($deal_repay['l_key_index'] + 1)."期，坏账操作",0);
			
			$this->error("操作失败");
		}
	}
	
	/**
	 * 逾期账单
	 */
	public function yuqi()
	{
		$this->assign("main_title",L("DEAL_YUQI"));
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		
		switch($sorder){
			case "name":
			case "cate_id":
					$order ="d.".$sorder;
				break;
			case "has_repay_status":
					$order ="dl.status";
				break;
			case "site_bad_status":
					$order ="dl.is_site_bad";
				break;
			case "is_has_send":
					$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
					$order ="dl.l_key";
				break;
			default : 
				$order ="dl.".$sorder;
				break;
		}
		
	
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		$this->assign("cate_tree",$cate_tree);
		
		//开始加载搜索条件
		$condition .= "  (dl.repay_time + 24*3600 - 1) < ".TIME_UTC." AND dl.has_repay=0 ";	
		
		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d");
		if($begin_time > 0){
			if($begin_time > TIME_UTC)
			{
				$this->error("不能超过当前时间");
			}
			$condition .= " and dl.repay_time >= $begin_time ";	
		}
		
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
		
		
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dl.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";			
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
		
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d ON d.id=dl.deal_id WHERE $condition ";
	
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		if($rs_count > 0){
			
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time,u.user_name,u.mobile FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id left join ".DB_PREFIX."user u on u.id=dl.user_id WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			$list = $GLOBALS['db']->getAll($sql_list);
			foreach($list as $k=>$v){
				$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
				if($v['send_three_msg_time'] == $v['repay_time']){
					$list[$k]['is_has_send'] = 1;
				}
				else{
					$list[$k]['is_has_send'] = 0;
				}
				if($v['has_repay']==1){
					switch($v['status']){
						case 0;
							$list[$k]['has_repay_status'] = "提前还款";
							break;
						case 1;
							$list[$k]['has_repay_status'] = "准时还款";
							break;
						case 2;
							$list[$k]['has_repay_status'] = "逾期还款";
							break;
						case 3;
							$list[$k]['has_repay_status'] = "严重逾期";
							break;
					}
				}
				else{
					$list[$k]['has_repay_status'] = "<span style='color:red'>未还</span>";
				}
				
				if($v['is_site_bad'] == 1){
					$list[$k]['site_bad_status'] = "<span style='color:red'>坏账</span>";
				}
				else{
					$list[$k]['site_bad_status'] = "逾期还款";
				}
			}
			
			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display ();
		return;
	}
	
	/**
	 * 垫付账单
	 */
	function generation_repay(){
		$this->assign("main_title","垫付账单");
		
		//分类
		$cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$cate_tree = D("DealCate")->toFormatTree($cate_tree,'name');
		$this->assign("cate_tree",$cate_tree);
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "name":
			case "cate_id":
					$order ="d.".$sorder;
				break;
			case "site_bad_status":
					$order ="dr.is_site_bad";
				break;
			case "is_has_send":
					$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
					$order ="dr.l_key";
				break;
			default : 
				$order ="gr.".$sorder;
				break;
		}
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		
		$condition = " 1= 1 ";
		
		if(isset($_REQUEST['status'])){
			$status = intval($_REQUEST['status']);
			if($status >0){
				$condition .= " AND gr.status=".($status-1);
			}
		}
		else{
			$condition .= " AND gr.status=0";
			$_REQUEST['status'] = 1;
		}
		
		$begin_time  = trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d");
		$end_time  = trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d");
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and dr.repay_time >= $begin_time ";	
			}
			else
				$condition .= " and dr.repay_time between  $begin_time and ".($end_time+24*3600-1)." ";	
		}
		
		if($begin_time > 0)
			$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		if($end_time > 0)
			$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
		
		
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dr.is_site_bad=".($deal_status-1);
		}
		
		
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
		
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dr.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";			
		}
		
		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
		
		$sql_count = "SELECT count(*) FROM ".DB_PREFIX."generation_repay gr LEFT join ".DB_PREFIX."deal_repay dr ON dr.id=gr.repay_id LEFT JOIN ".DB_PREFIX."deal d ON d.id=gr.deal_id ";
		
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		$list = array();
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  " SELECT gr.*,dr.l_key + 1 as l_key_index,dr.l_key,d.name,d.cate_id,d.send_three_msg_time,dr.user_id,dr.repay_time,dr.is_site_bad,agc.user_name as agency_name,u.user_name,AES_DECRYPT(u.mobile_encrypt,'".AES_DECRYPT_KEY."') as mobile FROM ".DB_PREFIX."generation_repay gr LEFT join ".DB_PREFIX."deal_repay dr ON dr.id=gr.repay_id LEFT JOIN ".DB_PREFIX."deal d  ON d.id=gr.deal_id LEFT JOIN ".DB_PREFIX."user agc ON agc.id=gr.agency_id left join ".DB_PREFIX."user u on u.id = d.user_id   WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
		
			$list = $GLOBALS['db']->getAll($sql_list);
			foreach($list as $k=>$v){
				$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
				
				
				if($v['is_site_bad'] == 1){
					$list[$k]['site_bad_status'] = "<span style='color:red'>坏账</span>";
				}
				else{
					$list[$k]['site_bad_status'] = "正常";
				}
				
				$list[$k]['total_money'] = $v['repay_money'] + $v['manage_money'] + $v['impose_money']+ $v['manage_impose_money'] + $v['mortgage_fee'];
				
				if($v['status'] == 0){
					$list[$k]['status_format'] = "垫付待收款";
					$day = (to_timespan(to_date(TIME_UTC,"Y-m-d"),"Y-m-d") - to_timespan($v['create_date'],"Y-m-d"))/24/3600;
					if($day==0)
						$day = 1;
					$list[$k]['fee_day'] = $day;
					$list[$k]['total_money_fee'] = $list[$k]['total_money'] * floatval(trim(app_conf("GENERATION_REPAY_FEE"))) * 0.01 * $day;
				}
				else{
					$list[$k]['status_format'] = "垫付已收款";
				}
								
				$list[$k]['create_time_format'] = to_date($v['create_time'],"Y-m-d H:i");
			}
			
			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign ( 'list', $list );
		
		$this->display ();
	}
	
	
	/**
	 * 网站收益
	 */
	function site_money(){
		$this->assign("main_title","网站收益");
		/*$type_name = array(
				"1" => "充值手续费",
				"9" => "提现手续费",
				"10" => "借款管理费",
				"12" => "逾期管理费",
				
				"13" => "人工操作",
				"14" => "借款服务费",
				"17" => "债权转让管理费",
				"18" => "开户奖励",
				"20" => "投标管理费",
				"22" => "兑换",
				"23" => "邀请返利",
				"24" => "投标返利",
				"25" => "签到成功",
				
				"26" => "逾期罚金（垫付后）",
				"27" => "其他费用",
				"28" => "投资奖励",
				"29" => "红包奖励",
		);
		*/
		$type_name = load_auto_cache("cache_money_type",array("class"=>"site_money"));
		
		unset($type_name['100']);
		
		$this->assign('type_name',$type_name);
		
		
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		
		switch($sorder){
			case "user_id":
				$order ="user_id";
				break;
			case "money":
				$order ="money";
				break;
			default :
				$order = $sorder;
				break;
		}
		
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		
		$condition = " 1= 1 ";
		
		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		$status =!isset($_REQUEST['status'])?0 : (trim($_REQUEST['status'])== ""? 0 : intval($_REQUEST['status'])   );
		
		if($status >0){
			$condition .= " AND type=".$status;
		}
		
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and s.create_time >= $begin_time ";
			}
			else
				$condition .= " and s.create_time between  $begin_time and ".($end_time+24*3600-1)." ";
		}
		
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
		
	
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and u.user_name like '%".trim($_REQUEST['user_name'])."%'";
		}
		$sql_count = " SELECT count(*) FROM ".DB_PREFIX."site_money_log s  left join ".DB_PREFIX."user u on u.id=s.user_id  WHERE $condition ";
		
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		
		$list = array();
		if($rs_count > 0){
				
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
				
			$sql_list =  " select s.* ,u.user_name from ".DB_PREFIX."site_money_log s left join ".DB_PREFIX."user u on u.id=s.user_id  WHERE $condition ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
			
			$list = $GLOBALS['db']->getAll($sql_list);
			foreach($list as $k=>$v){
				$list[$k]['type_format'] = $type_name[$v['type']];
			}
			$page = $p->show();
			$this->assign ( "page", $page );
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign("list",$list);
		$this->display ();
		return; 
	}
	
	
	
	function op_generation_repay_status(){
		$id = intval($_REQUEST['id']);
		$deal_repay = $GLOBALS['db']->getRow("SELECT gr.*,dr.user_id,dr.l_key + 1 as l_key_index,dr.is_site_bad,d.name FROM ".DB_PREFIX."generation_repay gr LEFT JOIN  ".DB_PREFIX."deal_repay dr ON dr.id=gr.repay_id LEFT JOIN ".DB_PREFIX."deal d ON d.id=dr.deal_id WHERE  gr.id=".$id);
		if(!$deal_repay){
			$this->error("账单不存在");
		}
		
		
		
		
		if($deal_repay['is_site_bad'] == 1){
			$deal_repay['site_bad_status'] = "<span style='color:red'>坏账</span>";
		}
		else{
			$deal_repay['site_bad_status'] = "正常";
		}
		
		$deal_repay['total_money'] = $deal_repay['repay_money'] + $deal_repay['manage_money'] + $deal_repay['impose_money']+ $deal_repay['manage_impose_money'];
		
		switch($deal_repay['status']){
			case 0;
				$deal_repay['status_format'] = "垫付待收款";
				$day = (to_timespan(to_date(TIME_UTC,"Y-m-d"),"Y-m-d") - to_timespan($deal_repay['create_date'],"Y-m-d"))/24/3600;
				if($day==0)
					$day = 1;
				$deal_repay['fee_day'] = $day;
				$deal_repay['total_money_fee'] = $deal_repay['total_money'] * floatval(trim(app_conf("GENERATION_REPAY_FEE"))) * 0.01 * $day;
				break;
			case 1;
				$deal_repay['status_format'] = "垫付已收款";
				break;
		}
		
		$this->assign("deal_repay",$deal_repay);
		$this->display();
	}
	
	function do_op_generation_repay_status(){
		B('FilterString');
		$data = M("GenerationRepay")->create ();
		
		$id= intval($_REQUEST['id']);
		$data['status'] =  intval($data['status']) - 1;
		if($data['status'] < 0){
			unset($data['status']);
		}
		
		if((int)$data['status']==1){
			$deal_repay = $GLOBALS['db']->getRow("SELECT gr.*,dr.user_id,dr.l_key + 1 as l_key_index,dr.is_site_bad,d.name FROM ".DB_PREFIX."generation_repay gr LEFT JOIN  ".DB_PREFIX."deal_repay dr ON dr.id=gr.repay_id LEFT JOIN ".DB_PREFIX."deal d ON d.id=dr.deal_id WHERE  gr.id=".$id);
			$deal_repay['total_money'] = $deal_repay['repay_money'] + $deal_repay['manage_money'] + $deal_repay['impose_money']+ $deal_repay['manage_impose_money'];
			$day = (to_timespan(to_date(TIME_UTC,"Y-m-d"),"Y-m-d") - to_timespan($deal_repay['create_date'],"Y-m-d"))/24/3600;
			if($day==0)
				$day = 1;
			$data['fee_day'] = $day;
			$data['total_money_fee'] = $deal_repay['total_money'] * floatval(trim(app_conf("GENERATION_REPAY_FEE"))) * 0.01 * $day;
		}
	
		// 更新数据
		$list=M("GenerationRepay")->save ($data);
		if (false !== $list) {
			
			if($data['status']==1 && $data['total_money_fee']!=0){
				$site_money_data['user_id'] = $deal_repay['user_id'];
				$site_money_data['create_time'] = TIME_UTC;
				$site_money_data['create_time_ymd'] = to_date(TIME_UTC,"Y-m-d");
				$site_money_data['create_time_ym'] = to_date(TIME_UTC,"Ym");
				$site_money_data['create_time_y'] = to_date(TIME_UTC,"Y");
				$site_money_data['money'] = $data['total_money_fee'];
				$site_money_data['memo'] = "[<a href='".url("index","deal#index",array("id"=>$deal_repay['deal_id']))."' target='_blank'>".$deal_repay['name']."</a>],第".($deal_repay['l_key_index'])."期,垫付 ".$day." 天的罚息";
				$site_money_data['type'] = 26;
				$GLOBALS['db']->autoExecute(DB_PREFIX."site_money_log",$site_money_data,"INSERT");
			}
			//成功提示
			save_log($id.L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($id.L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"),0,$id.L("UPDATE_FAILED"));
		}
	}
	
	
	public function trash()
	{
		$condition['is_delete'] = 1;
		$this->assign("default_map",$condition);
		parent::index();
	}
	public function add()
	{
		$this->assign("new_sort", M("Deal")->where("is_delete=0")->max("sort")+1);
		
		$deal_cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$deal_cate_tree = D("DealCate")->toFormatTree($deal_cate_tree,'name');
		$this->assign("deal_cate_tree",$deal_cate_tree);
		
		$deal_sn = "MER".to_date(TIME_UTC,"Y")."".str_pad(D("Deal")->where()->max("id") + 1,7,0,STR_PAD_LEFT);
		
		$this->assign("deal_sn",$deal_sn);
		
		$citys = M("DealCity")->where('is_delete= 0 and is_effect=1 ')->findAll();
		$this->assign ( 'citys', $citys );
		
		$deal_agency = M("User")->where('is_effect = 1 and user_type = 2')->order('sort DESC')->findAll();
		$this->assign("deal_agency",$deal_agency);
		
		$deal_type_tree = M("DealLoanType")->findAll();
		$deal_type_tree = D("DealLoanType")->toFormatTree($deal_type_tree,'name');
		$this->assign("deal_type_tree",$deal_type_tree);
		
		$loantype_list = load_auto_cache("loantype_list");
    	$this->assign("loantype_list",$loantype_list);
    	
    	$contract_list = load_auto_cache("contract_cache");
    	$this->assign("contract_list",$contract_list);

		$this->display();
	}

	/**
     * 新建标
	 */
	public function insert()
    {
		B('FilterString');
		$ajax = intval($_REQUEST['ajax']);
		$data = M(MODULE_NAME)->create();
		$data['access_pwd'] = trim($_REQUEST['access_pwd']);

		//开始验证有效性
		$this->assign("jumpUrl","javascript:history.back(-1);");
		
		if(!check_empty($data['name'])) $this->error(L("DEAL_NAME_EMPTY_TIP"));
		if(!check_empty($data['sub_name'])) $this->error(L("DEAL_SUB_NAME_EMPTY_TIP"));
		if($data['cate_id']==0) $this->error(L("DEAL_CATE_EMPTY_TIP"));
		if($data['type_id']==0) $this->error(L("DEAL_TYPE_EMPTY_TIP"));
		if(D("Deal")->where("deal_sn='".$data['deal_sn']."'")->count() > 0) $this->error("借款编号已存在");

		$loantype_list = load_auto_cache("loantype_list");
		if(!in_array($data['repay_time_type'],$loantype_list[$data['loantype']]['repay_time_type'])) $this->error("还款方式不支持当前借款期限类型");

		// 更新数据
		$log_info = $data['name'];
		$data['create_time'] = TIME_UTC;
		$data['update_time'] = TIME_UTC;
		$data['start_time'] = trim($data['start_time'])==''?0:to_timespan($data['start_time']);
		if($data['start_time'] > 0) $data['start_date'] = to_date($data['start_time'],"Y-m-d");
		if($data['uloadtype']==1){
		    if((int)$data['portion'] > 0) $data['min_loan_money'] = $data['borrow_amount'] / $data['portion'];
		    else $data['min_loan_money'] = 0;
		}
		
		$data['mortgage_infos'] = $this->mortgage_info();
        $data['mortgage_contract'] = $this->mortgage_info("contract");

		$list=M(MODULE_NAME)->add($data);
		if (false !== $list) {
			foreach($_REQUEST['city_id'] as $k=>$v){
				if(intval($v) > 0){
					$deal_city_link['deal_id'] =$list;
					$deal_city_link['city_id'] = intval($v);
					M("DealCityLink")->add ($deal_city_link);
				}
			}
			
			require_once(APP_ROOT_PATH."app/Lib/common.php");
			//成功提示
			syn_deal_status($list);
			syn_deal_match($list);
			save_log("编号：$list，".$log_info.L("INSERT_SUCCESS"),1);
			$this->assign("jumpUrl",u(MODULE_NAME."/add"));
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log($log_info.L("INSERT_FAILED").$dbErr,0);
			$this->error(L("INSERT_FAILED").$dbErr);
		}
	}	
	
	public function edit() {		
		$id = intval($_REQUEST ['id']);
		$condition['is_delete'] = 0;
		$condition['id'] = $id;		
		$vo = M(MODULE_NAME)->where($condition)->find();

		$vo['start_time'] = $vo['start_time']!=0?to_date($vo['start_time']):'';
		
		if($vo['deal_status'] ==0){
			$level_list = load_auto_cache("level");
			$type_info = $GLOBALS['db']->getRow("SELECT * FROM ".DB_PREFIX."deal_loan_type WHERE id=".$vo['type_id']);
			$u_level = M("User")->where("id=".$vo['user_id'])->getField("level_id");
			$vip_id = M("User")->where("vip_state='1' and id=".$vo['user_id'])->getField("vip_id");
			
			if($type_info['costsetting']&&$vip_id>0){
				$vo_list = explode("\n",$type_info['costsetting']);
				foreach($vo_list as $k=>$v){
					$vo_list[$k] = explode("|",$v);
					if($vo_list[$k]['0'] == $vip_id){
						if($vo_list[$k]['1']>0||$vo_list[$k]['2']>0||$vo_list[$k]['3']>0||$vo_list[$k]['4']>0||$vo_list[$k]['5']>0||$vo_list[$k]['6']>0){
							$vo['services_fee']= $vo_list[$k]['1'];
							$vo['manage_fee'] = $vo_list[$k]['2'];
//							$vo['user_loan_manage_fee']= $vo_list[$k]['3'];
//							$vo['user_loan_interest_manage_fee']= $vo_list[$k]['4'];
//							$vo['user_bid_rebate']= $vo_list[$k]['5'];
//							$vo['user_bid_score_fee']= $vo_list[$k]['6'];
						}
					}
				}
			}else{
				if($type_info['levelsetting']){
					$vol_list = explode("\n",$type_info['levelsetting']);
					foreach($vol_list as $ks=>$vs){
						$vol_list[$ks] = explode("|",$vs);
						if($vol_list[$ks]['0'] == $u_level){
							if($vol_list[$ks]['1']>0||$vol_list[$ks]['2']>0||$vol_list[$ks]['3']>0||$vol_list[$ks]['4']>0||$vol_list[$ks]['5']>0||$vol_list[$ks]['6']>0){
								$vo['services_fee'] = $vol_list[$ks]['1'];
								$vo['manage_fee'] = $vol_list[$ks]['2'];
//								$vo['user_loan_manage_fee']= $vol_list[$ks]['3'];
//								$vo['user_loan_interest_manage_fee']= $vol_list[$ks]['4'];
//								$vo['user_bid_rebate']= $vol_list[$ks]['5'];
//								$vo['user_bid_score_fee']= $vol_list[$ks]['6'];
							}
						}
					}
				}
			}
			
		}
		
		if($vo['deal_sn']==""){
			$deal_sn = "MER".to_date(TIME_UTC,"Y")."".str_pad($id,7,0,STR_PAD_LEFT);
			$this->assign ( 'deal_sn', $deal_sn );
		}
		
		$user_info = M("User") -> getById($vo['user_id']);
		$old_imgdata_str = unserialize($user_info['view_info']);
	
		foreach($old_imgdata_str as $k=>$v){
			$old_imgdata_str[$k]['key'] = $k;  /*+一个key*/
		}
		$this->assign("user_info",$user_info);
		$this->assign("old_imgdata_str",$old_imgdata_str);

		
		$vo['view_info'] = unserialize($vo['view_info']);
		
		if($vo['publish_wait'] == 1){
			
			if($vo['manage_fee']=="")
				$vo['manage_fee'] = app_conf("MANAGE_FEE");
			if($vo['user_loan_manage_fee']=="")
				$vo['user_loan_manage_fee'] = app_conf("USER_LOAN_MANAGE_FEE");
			if($vo['manage_impose_fee_day1']=="")
				$vo['manage_impose_fee_day1'] = app_conf("MANAGE_IMPOSE_FEE_DAY1");
			if($vo['manage_impose_fee_day2']=="")
				$vo['manage_impose_fee_day2'] = app_conf("MANAGE_IMPOSE_FEE_DAY2");
			if($vo['impose_fee_day1']=="")
				$vo['impose_fee_day1'] = app_conf("IMPOSE_FEE_DAY1");
			if($vo['impose_fee_day2']=="")
				$vo['impose_fee_day2'] = app_conf("IMPOSE_FEE_DAY2");
			if($vo['user_load_transfer_fee']=="")
				$vo['user_load_transfer_fee'] = app_conf("USER_LOAD_TRANSFER_FEE");
			if($vo['compensate_fee']=="")
				$vo['compensate_fee'] = app_conf("COMPENSATE_FEE");
			if($vo['user_bid_rebate']=="")
				$vo['user_bid_rebate'] = app_conf("USER_BID_REBATE");
			if($vo['user_loan_interest_manage_fee']=="")
				$vo['user_loan_interest_manage_fee'] = app_conf("USER_LOAN_INTEREST_MANAGE_FEE");
			if($vo['generation_position']=="")
				$vo['generation_position'] = 100;
			if($vo['user_bid_score_fee']=="")
				$vo['user_bid_score_fee'] = app_conf("USER_BID_SCORE_FEE");
		}
		
		$mortgage_infos_json = json_encode(unserialize($vo['mortgage_infos']));
		$this->assign ( 'mortgage_infos_json', $mortgage_infos_json );
        
        $mortgage_contract_json = json_encode(unserialize($vo['mortgage_contract']));
        $this->assign ( 'mortgage_contract_json', $mortgage_contract_json );
		
		$this->assign ( 'vo', $vo );
		
		$citys = M("DealCity")->where('is_delete= 0 and is_effect=1 ')->findAll();
		$citys_link = M("DealCityLink")->where("deal_id=".$id)->findAll();
		foreach($citys as $k=>$v){
			foreach($citys_link as $kk=>$vv){
				if($vv['city_id'] == $v['id'])
					$citys[$k]['is_selected'] = 1;
			}
		}
		
		$this->assign ( 'citys', $citys );
		
		if(trim($_REQUEST['type'])=="deal_status"){
			$this->display ("Deal:deal_status");
			exit();
		}
				
		$deal_cate_tree = M("DealCate")->where('is_delete = 0')->findAll();
		$deal_cate_tree = D("DealCate")->toFormatTree($deal_cate_tree,'name');
		$this->assign("deal_cate_tree",$deal_cate_tree);
		
		$deal_agency = M("User")->where('is_effect = 1 and user_type =2')->order('sort DESC')->findAll();
		$this->assign("deal_agency",$deal_agency);
		
		$deal_type_tree = M("DealLoanType")->findAll();
		$deal_type_tree = D("DealLoanType")->toFormatTree($deal_type_tree,'name');
		$this->assign("deal_type_tree",$deal_type_tree);
		
		$loantype_list = load_auto_cache("loantype_list");
    	$this->assign("loantype_list",$loantype_list);
    	
    	$contract_list = load_auto_cache("contract_cache");
    	$this->assign("contract_list",$contract_list);
    	
		$this->display ();
	}
	
	
	public function update() {
		B('FilterString');
		$data = M(MODULE_NAME)->create ();
		
		$log_info = M(MODULE_NAME)->where("id=".intval($data['id']))->getField("name");
		//开始验证有效性
		$this->assign("jumpUrl","javascript:history.back(-1);");
		if(!check_empty($data['name']))
		{
			$this->error(L("DEAL_NAME_EMPTY_TIP"));
		}	
		if(!check_empty($data['sub_name']))
		{
			$this->error(L("DEAL_SUB_NAME_EMPTY_TIP"));
		}		
		if($data['cate_id']==0)
		{
			$this->error(L("DEAL_CATE_EMPTY_TIP"));
		}
		if($data['uloadtype']==1)
		{
			if($data['portion']<1 || $data['portion']==1){
				$this->error("份额数需大于1，且为整数");
				exit;
			}else{
				if(ereg("^[0-9]*[1-9][0-9]*$",$data['portion'])!=1){
					$this->error("份额数需为整数!");
					exit;
				}
			}
		}

		if(D("Deal")->where("deal_sn='".$data['deal_sn']."' and id<>".$data['id'])->count() > 0){
			$this->error("借款编号已存在");
		}
		
		$loantype_list = load_auto_cache("loantype_list");
		if(!in_array($data['repay_time_type'],$loantype_list[$data['loantype']]['repay_time_type'])){
			$this->error("还款方式不支持当前借款期限类型");
		}
		
		$data['update_time'] = TIME_UTC;
		$data['publish_wait'] = intval($_REQUEST['publish_wait']);
		
		$data['start_time'] = trim($data['start_time'])==''?0:to_timespan($data['start_time']);
		if($data['start_time'] > 0)
			$data['start_date'] = to_date($data['start_time'],"Y-m-d");
		
		if($data['uloadtype']==1){
		    if((int)$data['portion'] > 0)
		        $data['min_loan_money'] = $data['borrow_amount'] / $data['portion'];
		    else
		        $data['min_loan_money'] = 0;
		     
		}
		
		$user_info = M("User") -> getById($data['user_id']);
		$old_imgdata_str = unserialize($user_info['view_info']);

		
		$data['view_info'] = array();
		foreach($_REQUEST['key'] as $k=>$v){
			if(isset($old_imgdata_str[$v])){
				$data['view_info'][$v] = $old_imgdata_str[$v];
			}
		}
		$data['view_info'] = serialize($data['view_info']);
		
		if($data['deal_status'] == 4){
			if($GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."deal_load where deal_id=".$data['id']) <floatval($data['borrow_amount'])){
				$this->error("未满标无法设置为还款状态!");
				exit();
			}
		}
		
		if($data['agency_id']!=M("Deal")->where("id=".$data['id'])->getField("agency_id")){
			$data['agency_status'] = 0;
		}
		$data['mortgage_infos'] = $this->mortgage_info();
        $data['mortgage_contract'] = $this->mortgage_info("contract");
		// 更新数据
		$list=M(MODULE_NAME)->save($data);
		if (false !== $list) {
			
			M("DealCityLink")->where ("deal_id=".$data['id'])->delete();
			foreach($_REQUEST['city_id'] as $k=>$v){
				if(intval($v) > 0){
					$deal_city_link['deal_id'] = $data['id'];
					$deal_city_link['city_id'] = intval($v);
					M("DealCityLink")->add ($deal_city_link);
				}
				
			}
			
			require_once(APP_ROOT_PATH."app/Lib/common.php");
			if($data['is_delete']==3){
				//发送失败短信通知
				if(app_conf("SMS_ON")==1){
					$user_info  = D("User")->where("id=".$data['user_id'])->find();
					$deal_info = D("Deal")->where("id=".$data['id'])->find();
						
					$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_template where name = 'TPL_SMS_DEAL_DELETE'");				
					$tmpl_content = $tmpl['content'];
									
					$notice['user_name'] = $user_info["user_name"];
					$notice['deal_name'] = $data['name'];
					$notice['site_name'] = app_conf("SHOP_TITLE");
					$notice['delete_msg'] = $data['delete_msg'];
					$notice['deal_publish_time'] = to_date($deal_info['create_time'],"Y年m月d日");
					
					$GLOBALS['tmpl']->assign("notice",$notice);
					
					$msg = $GLOBALS['tmpl']->fetch("str:".$tmpl_content);
					
					$msg_data['dest'] = $user_info['mobile'];
					$msg_data['send_type'] = 0;
					$msg_data['title'] = "审核失败通知";
					$msg_data['content'] = addslashes($msg);;
					$msg_data['send_time'] = 0;
					$msg_data['is_send'] = 0;
					$msg_data['create_time'] = TIME_UTC;
					$msg_data['user_id'] = $user_info['id'];
					$msg_data['is_html'] = $tmpl['is_html'];
					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_msg_list",$msg_data); //插入	
				}
				
				//借款审核结果通知
				if(app_conf("WEIXIN_MSG")==1){
					$user_info = get_user_info("*","id = ".$data['user_id']);
					if($user_info['wx_openid']!='')
					{
						$tmpl = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."weixin_tmpl where template_id_short='OPENTM204320762' ");
						$deal_info = D("Deal")->where("id=".$data['id'])->find();
						$deal_publish_time = to_date($deal_info['create_time'],"Y年m月d日");
						$weixin_data['first'] = array('value'=>$user_info["user_name"].'您于'.$deal_publish_time.'发布的借款'.$data['name'],'color'=>'#173177');
						$weixin_data['keyword1']=array('value'=>'失败','color'=>'#173177');
						$weixin_data['keyword2']=array('value'=>$data['delete_msg'],'color'=>'#173177');
						
						weixin_tmpl_send($tmpl['template_id'],$user_info['id'],$weixin_data);
					}
				}
			
			}
			else{
				//成功提示
				syn_deal_status($data['id']);
				syn_deal_match($data['id']);
				//发送电子协议邮件
				require_once(APP_ROOT_PATH."app/Lib/deal.php");
				send_deal_contract_email($data['id'],array(),$data['user_id']);
			}
			//成功提示
			save_log("编号：".$data['id']."，".$log_info.L("UPDATE_SUCCESS"),1);
			$this->assign("jumpUrl",u(MODULE_NAME."/edit",array("id"=>$data['id'])));
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log("编号：".$data['id']."，".$log_info.L("UPDATE_FAILED").$dbErr,0);
			$this->error(L("UPDATE_FAILED").$dbErr,0);
		}
	}
	
	
	public function delete() {
		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) , 'buy_count'=> array('eq',0) );
				$condition1 = array ('id' => array ('in', explode ( ',', $id ) ) , 'buy_count'=> array('gt',0) );
				//无法删除的
				$rel_data = M(MODULE_NAME)->where($condition1)->findAll();				
				foreach($rel_data as $data)
				{
					$info1[] = "编号：".$data['id']."-".$data['name'];	
				}
				if($info1) $info1_list = implode(",",$info1);
				//可以删除的
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = "编号：".$data['id']."-".$data['name'];	
				}
				if($info) $info_list = implode(",",$info);
				
				$list = M(MODULE_NAME)->where ( $condition )->setField ( 'is_delete', 1 );
				if ($list!==false) {
					M("Topic")->where(array ('fav_id' => array ('in', explode ( ',', $id ) ) ,"type"=>array('in',array("deal_message","message","deal_message_reply","message_reply","deal_collect","deal_bad"))))->setField("is_effect",0);
					save_log($info_list.l("DELETE_SUCCESS"),1);
					$this->success ("除".$info1_list."外，".l("DELETE_SUCCESS"),$ajax);
				} else {
					save_log($info_list.l("DELETE_FAILED"),0);
					$this->error (l("DELETE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}		
	}
	
	
	/*
	 * 拆标
	 */
	function apart(){
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$id = intval($_REQUEST['id']);
		$deal = get_deal($id,0);
		if(!$deal){
			$this->error ("借款不存在");
		}
		
		
		if($deal['is_effect']==1){
			$this->error ("请将借款设置为无效状态");
		}
		
		if($deal['ips_bill_no']!=""){
			$this->error ("第三方标无法拆分");
		}
		
		if($deal['deal_status']!=1){
			$this->error ("该借款当前状态不是进行中");
		}
		
		if($deal['load_money']==0){
			$this->error ("该借款还没人投标无法拆标");
		}
		
		$this->assign("deal",$deal);
		
		if(!in_array((int)to_date(TIME_UTC,"d"),array(29,30,31))){
			$NOW_TIME = to_date(TIME_UTC,"Y-m-d");
		}
		else{
			$NOW_TIME = to_date(next_replay_month(TIME_UTC),"Y-m")."-01";
		}
		
		$this->assign("NOW_TIME",$NOW_TIME);
		
		$html = $this->fetch();
		$this->success($html);
	}
	
	function do_apart(){
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$id = intval($_REQUEST['id']);
		$deal = get_deal($id,0);
		
		if(!$deal){
			$this->error ("借款不存在");
		}
		
		
		if($deal['is_effect']==1){
			$this->error ("请将借款设置为无效状态");
		}
		
		if($deal['ips_bill_no']!=""){
			$this->error ("第三方标无法拆分");
		}
		
		if($deal['deal_status']!=1){
			$this->error ("该借款当前状态不是进行中");
		}
		
		if($deal['load_money']==0){
			$this->error ("该借款还没人投标无法拆标");
		}
		
		if($deal['borrow_amount']  -  $deal['load_money'] <= 0){
			$this->error ("该借款筹标金额已满无法拆标");
		}
		
		$d = explode('-',strim($_REQUEST['repay_start_time']));
		if (checkdate($d[1], $d[2], $d[0]) == false){
			$this->error("还款时间不是有效的时间格式:{$_REQUEST['repay_start_time']}(yyyy-mm-dd)");
			exit;
		}
		
		$data = $deal;
		
		//开始拆标
		//$data['apart_borrow_amount'] = $deal['borrow_amount'];
		$data['borrow_amount'] = $deal['load_money'];
		$data['repay_start_time'] = TIME_UTC;
		$data['repay_start_date'] = to_date(TIME_UTC,"Y-m-d");
		$data['is_effect'] = 1;
		
		$GLOBALS['db']->autoExecute(DB_PREFIX."deal",$data,"UPDATE","id=".$id);
		if($GLOBALS['db']->affected_rows() == 0){
			$this->error("拆分失败");
			die();
		}
		
		syn_deal_status($id);
		
		$repay_start_time = strim($_REQUEST['repay_start_time']);
		
		$result = do_loans($id,$repay_start_time);
		
		if($result['status'] == 1 && (int)$_REQUEST['make_new'] == 1){
			$new_data = $deal;
			unset($new_data['id']);
			unset($new_data['deal_sn']);
			$new_data['is_effect'] = 0;
			$new_data['borrow_amount'] = $deal['borrow_amount']  -  $deal['load_money'];
			$new_data['load_money'] = 0;
			$new_data['buy_count'] = 0;
			$new_data['deal_status'] = 1;
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal",$new_data,"INSERT");
			$new_id = $GLOBALS['db']->insert_id();
			if($new_id > 0){
				$deal_sn = "MER".to_date(TIME_UTC,"Y")."".str_pad($new_id,7,0,STR_PAD_LEFT);
				$GLOBALS['db']->query("update ".DB_PREFIX."deal SET deal_sn='".$deal_sn."' WHERE id=".$new_id);
				
				//更新城市
				$citys = M("DealCityLink")->where ("deal_id=".$id)->findAll();
				foreach($citys as $kk=>$vv){
					$new_city_link['deal_id'] = $new_id;
					$new_city_link['city_id'] = $vv['city_id'];
					$GLOBALS['db']->autoExecute(DB_PREFIX."deal_city_link",$new_city_link);
				}
			}
		}
		
		if($result['status'] == 2){
			ajax_return($result);
		}
		elseif($result['status'] == 1){
			
			$this->get_manage($id);
			
			$this->success("拆分成功");
		}
		else{
			$data['borrow_amount'] = $data['apart_borrow_amount'];
			$data['apart_borrow_amount'] = "";
			$data['repay_start_time'] = 0;
			$data['deal_status'] = 1;
			$data['is_effect'] = 0;
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."deal",$deal,"UPDATE","id=".$id);
			syn_deal_status($id);
			
			$this->error($result['info']);
		}
	}
	
	
	
	public function restore() {
		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = $data['name'];	
					rm_auto_cache("cache_deal_cart",array("id"=>$data['id']));					
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->setField ( 'is_delete', 0 );
				if ($list!==false) {
					
					M("Topic")->where(array ('fav_id' => array ('in', explode ( ',', $id ) ) ,"type"=>array('in',array("message","message_reply","deal_collect","deal_bad"))))->setField("is_effect",1);
										
					save_log($info.l("RESTORE_SUCCESS"),1);
					$this->success (l("RESTORE_SUCCESS"),$ajax);
				} else {
					save_log($info.l("RESTORE_FAILED"),0);
					$this->error (l("RESTORE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}		
	}
	
	public function foreverdelete() {
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
				$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
				//删除的验证
				if(M("DealOrder")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->count()>0)
				{
					$this->error(l("DEAL_ORDER_NOT_EMPTY"),$ajax);
				}
				M("DealPayment")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->delete();
				M("DealLoad")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->delete();
				M("DealLoadRepay")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->delete();
				M("DealRepay")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->delete();
				M("DealCollect")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->delete();
				M("Topic")->where(array ('fav_id' => array ('in', explode ( ',', $id ) ) ,"type"=>array('in',array("message","message_reply","deal_collect","deal_bad"))))->delete();
				M("DealCityLink")->where(array ('deal_id' => array ('in', explode ( ',', $id ) ) ))->delete();
				
				$rel_data = M(MODULE_NAME)->where($condition)->findAll();				
				foreach($rel_data as $data)
				{
					$info[] = $data['name'];	
				}
				if($info) $info = implode(",",$info);
				$list = M(MODULE_NAME)->where ( $condition )->delete();	
					
				if ($list!==false) {
					save_log($info.l("FOREVER_DELETE_SUCCESS"),1);
					$this->success (l("FOREVER_DELETE_SUCCESS"),$ajax);
				} else {
					save_log($info.l("FOREVER_DELETE_FAILED"),0);
					$this->error (l("FOREVER_DELETE_FAILED"),$ajax);
				}
			} else {
				$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}
	
	
	public function set_sort()
	{
		$id = intval($_REQUEST['id']);
		$sort = intval($_REQUEST['sort']);
		$log_info = M(MODULE_NAME)->where("id=".$id)->getField('name');
		if(!check_sort($sort))
		{
			$this->error(l("SORT_FAILED"),1);
		}
		M(MODULE_NAME)->where("id=".$id)->setField("sort",$sort);
		rm_auto_cache("cache_deal_cart",array("id"=>$id));
		save_log($log_info.l("SORT_SUCCESS"),1);
		$this->success(l("SORT_SUCCESS"),1);
	}
	
	public function set_effect()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		$c_is_effect = M(MODULE_NAME)->where("id=".$id)->getField("is_effect");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_effect",$n_is_effect);	
		M(MODULE_NAME)->where("id=".$id)->setField("update_time",TIME_UTC);	
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
		
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;	
	}
	
	public function set_new()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		$c_is_effect = M(MODULE_NAME)->where("id=".$id)->getField("is_new");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_new",$n_is_effect);	
		M(MODULE_NAME)->where("id=".$id)->setField("update_time",TIME_UTC);	
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
		
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;	
	}
	
	public function set_advance()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		$c_is_advance = M(MODULE_NAME)->where("id=".$id)->getField("is_advance");  //当前状态
		$n_is_advance = $c_is_advance == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_advance",$n_is_advance);	
		
		M(MODULE_NAME)->where("id=".$id)->setField("update_time",TIME_UTC);	
		save_log($info.l("SET_EFFECT_".$n_is_advance),1);
		
		$this->ajaxReturn($n_is_advance,l("SET_EFFECT_".$n_is_advance),1)	;	
	}
	
	public function set_hidden()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M(MODULE_NAME)->where("id=".$id)->getField("name");
		$c_is_advance = M(MODULE_NAME)->where("id=".$id)->getField("is_hidden");  //当前状态
		$n_is_advance = $c_is_advance == 0 ? 1 : 0; //需设置的状态
		M(MODULE_NAME)->where("id=".$id)->setField("is_hidden",$n_is_advance);	
		
		M(MODULE_NAME)->where("id=".$id)->setField("update_time",TIME_UTC);	
		save_log($info.l("SET_EFFECT_".$n_is_advance),1);
		
		$this->ajaxReturn($n_is_advance,l("SET_EFFECT_".$n_is_advance),1)	;	
	}
	
	public function show_detail()
	{
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$id = intval($_REQUEST['id']);
		syn_deal_status($id);
		$deal_info = M("Deal")->getById($id);
		$this->assign("deal_info",$deal_info);
		
		$true_repay_money  =  M("DealLoadRepay")->where("deal_id=".$id)->sum("repay_money");
		
		$this->assign("true_repay_money",floatval($true_repay_money) + 1);
		
		$count = D("DealLoad")->where('deal_id='.$id)->order("id ASC")->count();
		if (! empty ( $_REQUEST ['listRows'] )) {
			$listRows = $_REQUEST ['listRows'];
		} else {
			$listRows = '';
		}
		$p = new Page ( $count, $listRows );
		if($count>0){
			$loan_list = D("DealLoad")->where('deal_id='.$id)->order("id ASC")->limit($p->firstRow . ',' . $p->listRows)->findall();
			$this->assign("loan_list",$loan_list);
		}
		$page = $p->show();
		$this->assign ( "page", $page );
		
		$this->display();
	}
	
	public function filter_html()
	{
		$shop_cate_id = intval($_REQUEST['shop_cate_id']);
		$deal_id = intval($_REQUEST['deal_id']);
		$ids = $this->get_parent_ids($shop_cate_id);
		$filter_group = M("FilterGroup")->where(array("cate_id"=>array("in",$ids)))->findAll();
		foreach($filter_group as $k=>$v)
		{
			$filter_group[$k]['value'] = M("DealFilter")->where("filter_group_id = ".$v['id']." and deal_id = ".$deal_id)->getField("filter");
		}
		$this->assign("filter_group",$filter_group);
		$this->display();
	}
	
	//获取当前分类的所有父分类包含本分类的ID
	private $cate_ids = array();
	private function get_parent_ids($shop_cate_id)
	{
		$pid = $shop_cate_id;
		do{
			$pid = M("ShopCate")->where("id=".$pid)->getField("pid");
			if($pid>0)
			$this->cate_ids[] = $pid;
		}while($pid!=0);
		$this->cate_ids[] = $shop_cate_id;
		return $this->cate_ids;
	}
	
	
	public function load_user(){
		
		$return= array("status"=>0,"message"=>"");
		$id = intval($_REQUEST['id']);
		if($id==0){
			ajax_return($return);
			exit();
		}
		$user = $GLOBALS['db']->getRow("SELECT u.*,l.name,l.point as l_point,l.services_fee,u.view_info,enddate FROM ".DB_PREFIX."user u LEFT JOIN ".DB_PREFIX."user_level l ON u.level_id = l.id WHERE u.id=".$id);
		if(!$user){
			ajax_return($return);
			exit();
		}
		$user['old_imgdata_str'] = unserialize($user['view_info']);
		$user['deal_info'] = get_user_load_fee($user['id']);
		$return['status']=1;
		$return['user']=$user;
		ajax_return($return);
		exit();
	}

	
	/*
	 *回款计划
	 */
	public function repay_plan()
	{
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$id = intval($_REQUEST['id']);
		
		if($id==0){
			$this->success("数据错误");
		}
		$deal_info = get_deal($id,0);
		
		if(!$deal_info){
			$this->success("借款不存在");
		}
	
		$this->assign("deal_info",$deal_info);
		$repay_list  = get_deal_load_list($deal_info);
		if(intval($deal_info["admin_id"])> 0)
		{
			$money = $GLOBALS["db"]->getOne("select first_relief from ".DB_PREFIX."debit_conf");
			foreach($repay_list as $k => $v)
			{
				if($v["l_key"] == 0 && $v["has_repay"] == 0)
				{
					$repay_list[$k]["month_need_all_repay_money"] = $v["month_need_all_repay_money"] - $money;
					$repay_list[$k]["month_need_all_repay_money_format"] = format_price($repay_list[$k]["month_need_all_repay_money"]);
				}
				elseif($v["l_key"] == 0 && $v["has_repay"] == 1)
				{
					
					$repay_list[$k]["month_has_repay_money_all"] = $v["month_has_repay_money_all"] - $money;
					$repay_list[$k]["month_has_repay_money_all_format"] = format_price($repay_list[$k]["month_has_repay_money_all"]);
				}
			}
		}
		if(!$repay_list){
			$this->success("无还款信息");
		}
		
		foreach($repay_list as $k=>$v){
			$repay_list[$k]['idx'] = $k + 1;
		}
		$this->assign("repay_list",$repay_list);
		$this->assign("deal_id",$id);
		$this->assign("deal_info",$deal_info);
		$this->display();
	}
	
	

	function repay_plan_a(){
		$deal_id = intval($_REQUEST['deal_id']);
		$l_key = intval($_REQUEST['l_key']);
		$obj = strim($_REQUEST['obj']);
		
		if($deal_id==0){
			$this->error("数据错误");
		}
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		
		$deal_info = get_deal($deal_id,0);
	
		if(!$deal_info){
			$this->error("借款不存在");
		}
	
	
		//输出投标列表
		$page = intval($_REQUEST['p']);
		if($page==0)
			$page = 1;
		
		$page_size = 10;
		
		$limit = (($page-1)*$page_size).",".$page_size;
		
		$result = get_deal_user_load_list($deal_info,0,$l_key,-1,0,0,1,$limit);
		foreach ($result['item'] as $k=>$v)
		{
			$result['item'][$k]['interest_money_format']=format_price($v['expect_earnings']);
			$result['item'][$k]['true_interest_money_format']=format_price($v['true_earnings']);
		}
		
		$rs_count = $result['count'];
		$page_all = ceil($rs_count/$page_size);
	
		$this->assign("load_user",$result['item']);
		$this->assign("l_key",$l_key);
		$this->assign("page_all",$page_all);
		$this->assign("rs_count",$rs_count);
		$this->assign("page",$page);
		$this->assign("deal_id",$deal_id);
		
		$this->assign("obj",$obj);
		$this->assign("page_prev",$page - 1);
		$this->assign("page_next",$page + 1);
		$html = $this->fetch();
		
		$this->success($html);
	}
	
	
	/**
	 * 代还款
	 */
	 
	 function do_site_repay($page=1){
	 	require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$id = intval($_REQUEST['id']);
		$l_key = intval($_REQUEST['l_key']);
		
		$this->assign("jumpUrl",U("Deal/repay_plan",array("id"=>$id)));
		
		if($id==0){
			$this->success("数据错误");
		}
		$deal_info = get_deal($id);
		
		if(!$deal_info){
			$this->success("借款不存在");
		}
		
		/*if($deal_info['ips_bill_no'] !=""){
			$this->success("第三方同步暂无法代还款");
		}*/
		
		$user_id = $deal_info['user_id'];
		
		if($page==0)
			$page = 1;
		
		$page_size = 10;
		
		$limit = (($page-1)*$page_size).",".$page_size;
		
		$user_loan_list = get_deal_user_load_list($deal_info,  0 , $l_key , -1 , 0 , 0 , 1 , $limit);
		$rs_count = $user_loan_list['count'];
		
		$page_all = ceil($rs_count/$page_size);
		
		$get_manage = $GLOBALS['db']->getOne("SELECT get_manage FROM ".DB_PREFIX."deal_repay WHERE deal_id = ".$deal_info['id']." and l_key=".$l_key."  ");
		
		require_once(APP_ROOT_PATH."system/libs/user.php");
		foreach($user_loan_list['item'] as $kk=>$vv){
			if($vv['has_repay']==0 ){//借入者已还款，但是没打款到借出用户中心
				$user_load_data = array();

				$user_load_data['true_repay_time'] = TIME_UTC;
				$user_load_data['true_repay_date'] = to_date(TIME_UTC);
				$user_load_data['is_site_repay'] = 1;
				$user_load_data['status'] = 0;
					
				$user_load_data['true_repay_money'] = (float)$vv['month_repay_money'];
				$user_load_data['true_self_money'] = (float)$vv['self_money'];
				$user_load_data['true_interest_money'] = (float)$vv['interest_money'];
				$user_load_data['true_manage_money'] = (float)$vv['manage_money'];
				$user_load_data['true_manage_interest_money'] = (float)$vv['manage_interest_money'];
				$user_load_data['true_repay_manage_money'] = (float)$vv['repay_manage_money'];
				$user_load_data['true_manage_interest_money_rebate'] = (float)$vv['manage_interest_money_rebate'];
				$user_load_data['impose_money'] = (float)$vv['impose_money'];
				$user_load_data['repay_manage_impose_money'] = (float)$vv['repay_manage_impose_money'];
				$user_load_data['true_reward_money'] = (float)$vv['reward_money'];
                $user_load_data['true_mortgage_fee'] = (float)$vv['mortgage_fee'];
				
				if($vv['status']>0)
					$user_load_data['status'] = $vv['status'] - 1;
					
				$user_load_data['has_repay'] = 1;
				$GLOBALS['db']->autoExecute(DB_PREFIX."deal_load_repay",$user_load_data,"UPDATE","id=".$vv['id']." AND has_repay = 0 ","SILENT");
			
				if($GLOBALS['db']->affected_rows() > 0){
	
					//$content = "您好，您在".app_conf("SHOP_TITLE")."的投标 “<a href=\"".$deal_info['url']."\">".$deal_info['name']."</a>”成功还款".($user_load_data['true_repay_money']+$user_load_data['impose_money'])."元，";
					$unext_loan = $user_loan_list[$vv['u_key']][$vv["l_key"]+1];
					
					$load_repay_rs = $GLOBALS['db']->getRow("SELECT (sum(true_interest_money) + sum(impose_money)) as shouyi,sum(impose_money) as total_impose_money FROM ".DB_PREFIX."deal_load_repay WHERE deal_id=".$deal_info['id']." AND user_id=".$vv['user_id']);
					$all_shouyi_money= number_format($load_repay_rs['shouyi'],2);
					$all_impose_money = number_format($load_repay_rs['total_impose_money'],2);
					
					
					
					if($user_load_data['impose_money'] !=0 || $user_load_data['true_manage_money'] !=0 || $user_load_data['true_repay_money']!=0){
						$in_user_id  = $vv['user_id'];
						//如果是转让债权那么将回款打入转让者的账户
						if((int)$vv['t_user_id'] == 0){
							$loan_user_info['user_name'] = $vv['user_name'];
							$loan_user_info['email'] = $vv['email'];
							$loan_user_info['mobile'] = $vv['mobile'];
						}
						else{
							$in_user_id = $vv['t_user_id'];
							$loan_user_info['user_name'] = $vv['t_user_name'];
							$loan_user_info['email'] = $vv['t_email'];
							$loan_user_info['mobile'] = $vv['t_mobile'];
						}
	
						//更新用户账户资金记录
						modify_account(array("money"=>$user_load_data['true_repay_money']),$in_user_id,"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,回报本息",5);
						
						//更新用户账户加息券记录
						modify_account(array("money"=>$user_load_data['true_interestrate_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($vv["l_key"]+1)."期,加息券增加的利息",53);
						
						if($user_load_data['true_manage_money'] > 0)
							modify_account(array("money"=>-$user_load_data['true_manage_money']),$in_user_id,"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,投标管理费",20);
						
						//利息管理费
						modify_account(array("money"=>-$user_load_data['true_manage_interest_money']),$in_user_id,"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,投标利息管理费",20);
						
						if($user_load_data['impose_money']!=0)
							modify_account(array("money"=>$user_load_data['impose_money']),$in_user_id,"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,逾期罚息",21);
						
                        //投资者奖励
                        if($user_load_data['true_reward_money']!=0){
                            modify_account(array("money"=>$user_load_data['true_reward_money']),$in_user_id,"[<a href='".$deal['url']."' target='_blank'>".$deal['name']."</a>],第".($vv["l_key"]+1)."期,奖励收益",28);
                        }
                        
						//扣除体验金
						if($vv['learn_id'] > 0){
							$load_info = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_load where id=".$vv['load_id']);
							if($load_info){
								//还需回收多少
								$back_learn_money = 0;
								if(floatval($load_info['learn_money']) > floatval($load_info['back_learn_money'])){
									$back_learn_money = floatval($load_info['learn_money']) - floatval($load_info['back_learn_money']);
								}
								if($back_learn_money > 0){
									if(($user_load_data['true_repay_money'] -$user_load_data['true_manage_money'] -$user_load_data['true_manage_interest_money'] + $user_load_data['impose_money'] + $user_load_data['true_reward_money']) >= $back_learn_money){
										modify_account(array("money"=>-$back_learn_money),$in_user_id,"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,体验金回收",54);
									}
									else{
										$back_learn_money = $user_load_data['true_repay_money'] -$user_load_data['true_manage_money'] -$user_load_data['true_manage_interest_money'] + $user_load_data['impose_money'] + $user_load_data['true_reward_money'];
										modify_account(array("money"=>-$back_learn_money),$in_user_id,"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,体验金回收",54);
									}
									
									$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_load SET  back_learn_money = back_learn_money + ".$back_learn_money." where id=".$vv['load_id']);
								}
							}
						}
						
						//普通会员邀请返利
						get_referrals($vv['id']);
						
						//投资者返佣金
						if($user_load_data['true_manage_interest_money_rebate'] !=0){
							/*ok*/
							$reback_memo = sprintf($GLOBALS['lang']["INVEST_REBATE_LOG"],$deal_info["url"],$deal_info["name"],$loan_user_info["user_name"],intval($vv["l_key"])+1);
							reback_rebate_money($in_user_id,$user_load_data['true_manage_interest_money_rebate'],"invest",$reback_memo);
						}
						
						$msg_conf = get_user_msg_conf($in_user_id);
	
	
						//短信通知回款
						$loan_user_info['id'] = $in_user_id;
						send_repay_reback_sms_mail($deal_info,$loan_user_info,$unext_loan,$user_load_data,$all_shouyi_money,$all_impose_money);
					}
				}
			}
		}
		
		if($page >= $page_all){
			$s_count =  $GLOBALS['db']->getOne("SELECT count(*) FROM  ".DB_PREFIX."deal_load_repay where deal_id=".$id." AND l_key=".$l_key." and has_repay = 0");
			$adm_session = es_session::get(md5(conf("AUTH_KEY")));
			if($s_count == 0){
				
				$rs_sum = $GLOBALS['db']->getRow("SELECT sum(true_repay_money) as total_repay_money,sum(true_self_money) as total_self_money,sum(true_interest_money) as total_interest_money,sum(true_repay_manage_money) as total_manage_money,sum(impose_money) as total_impose_money,sum(repay_manage_impose_money) as total_repay_manage_impose_money,sum(true_mortgage_fee) as total_mortgage_fee FROM  ".DB_PREFIX."deal_load_repay where deal_id=".$id." AND l_key=".$l_key."  and has_repay = 1");
				
				$deal_load_list = get_deal_load_list($deal_info);
				
				//统计网站代还款
				$rs_site_sum = $GLOBALS['db']->getRow("SELECT sum(true_repay_money) as total_repay_money,sum(true_self_money) as total_self_money,sum(true_repay_manage_money) as total_manage_money,sum(impose_money) as total_impose_money,sum(repay_manage_impose_money) as total_repay_manage_impose_money,sum(true_mortgage_fee) as total_mortgage_fee FROM  ".DB_PREFIX."deal_load_repay where deal_id=".$id." AND l_key=".$l_key." and is_site_repay=1 and has_repay = 1");
				
				$repay_data['status'] = (int)$GLOBALS['db']->getOne("SELECT `status` FROM  ".DB_PREFIX."deal_load_repay where deal_id=".$id." AND l_key=".$l_key." and has_repay = 1 AND is_site_repay=1  ORDER BY l_key DESC");
				$repay_data['true_repay_time'] = TIME_UTC;
				$repay_data['true_repay_date'] = to_date(TIME_UTC);
				$repay_data['has_repay'] = 1;
				$repay_data['impose_money'] = floatval($rs_sum['total_impose_money']);
				$repay_data['true_self_money'] = floatval($rs_sum['total_self_money']);
				$repay_data['true_repay_money'] = floatval($rs_sum['total_repay_money']);
				if($get_manage==0)
					$repay_data['true_manage_money'] = floatval($rs_sum['total_manage_money']);
				$repay_data['true_mortgage_fee'] =  floatval($rs_sum['total_mortgage_fee']);
				$repay_data['true_interest_money'] = floatval($rs_sum['total_interest_money']);
				$repay_data['manage_impose_money'] = floatval($rs_sum['total_repay_manage_impose_money']);
				$rebate_rs = get_rebate_fee($user_id,"borrow");
				$repay_data['true_manage_money_rebate'] = $repay_data['true_manage_money']* floatval($rebate_rs['rebate'])/100;
				
				//借款者返佣
				if($repay_data['true_manage_money_rebate']!=0){
					/*ok*/
					$reback_memo = sprintf(L("BORROW_REBATE_LOG"),$deal_info["url"],$deal_info["name"],$deal_info["user"]["user_name"],intval($l_key)+1);
					reback_rebate_money($user_id,$repay_data['true_manage_money_rebate'],"borrow",$reback_memo);
				}
				
				
				$GLOBALS['db']->autoExecute(DB_PREFIX."deal_repay",$repay_data,"UPDATE"," deal_id=".$id." AND l_key=".$l_key." and has_repay in (0,2) ");
				
				$impose_day = ceil((to_timespan(to_date(TIME_UTC,"Y-m-d"),"Y-m-d") -  $deal_load_list[$l_key]['repay_day'])/24/3600);
				if($impose_day > 0){
					//VIP 逾期还款降级
					$type = 2;
					$type_info = 5;
					$resultdate = syn_user_vip($user_id,$type,$type_info);
					
					if($impose_day < app_conf('YZ_IMPSE_DAY')){
						modify_account(array("point"=>trim(app_conf('IMPOSE_POINT'))),$deal_info['user_id'],"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,逾期还款",11);
						
					}
					else{
						modify_account(array("point"=>trim(app_conf('YZ_IMPOSE_POINT'))),$deal_info['user_id'],"[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($vv["l_key"]+1)."期,严重逾期",11);
					}
				}
				else{
					//VIP 代还款降级 
					$type = 2;
					$type_info = 6;
					$resultdate = syn_user_vip($user_id,$type,$type_info);
				}
				
				if($rs_site_sum){
					$r_msg = "网站代还款";
					if($rs_site_sum['total_repay_money'] > 0){
						$r_msg .=",本息：".format_price($rs_site_sum['total_repay_money']);
					}
					if($rs_site_sum['total_impose_money'] > 0){
						$r_msg .=",逾期费用：".format_price($rs_site_sum['total_impose_money']);
					}
					if($rs_site_sum['total_manage_money'] > 0 && $get_manage ==0){
						$r_msg .=",管理费：".format_price($rs_site_sum['total_manage_money']);
					}
                    if($rs_site_sum['true_mortgage_fee'] > 0 ){
                        $r_msg .=",抵押物管理费：".format_price($rs_site_sum['total_mortgage_fee']);
                    }
					if($rs_site_sum['total_repay_manage_impose_money'] > 0){
						$r_msg .=",逾期管理费：".format_price($rs_site_sum['total_repay_manage_impose_money']);
					}
					repay_log($deal_load_list[$l_key]['repay_id'],$r_msg,$deal_info['user_id'],$adm_session['adm_id']);
				}
				
				if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."generation_repay WHERE deal_id=".$id." AND repay_id=".$deal_load_list[$l_key]['repay_id']."")==0){
					$generation_repay['deal_id'] = $id;
					$generation_repay['repay_id'] = $deal_load_list[$l_key]['repay_id'];
					
					$generation_repay['admin_id'] = $adm_session['adm_id'];
					$generation_repay['agency_id'] = $deal_info['agency_id'];
					$generation_repay['repay_money'] = $rs_site_sum['total_repay_money'];
					$generation_repay['self_money'] = $rs_site_sum['total_self_money'];
					$generation_repay['impose_money'] = $rs_site_sum['total_impose_money'];
					if($get_manage==0)
						$generation_repay['manage_money'] = $rs_site_sum['total_manage_money'];
                    $generation_repay['mortgage_fee'] = $rs_site_sum['total_mortgage_fee'];
					$generation_repay['manage_impose_money'] = $rs_site_sum['total_repay_manage_impose_money'];
					$generation_repay['create_time'] = TIME_UTC;
					$generation_repay['create_date'] = to_date(TIME_UTC,"Y-m-d");
					
					$GLOBALS['db']->autoExecute(DB_PREFIX."generation_repay",$generation_repay);
					
					$site_money_data['user_id'] = $user_id;
					$site_money_data['create_time'] = TIME_UTC;
					$site_money_data['create_time_ymd'] = to_date(TIME_UTC,"Y-m-d");
					$site_money_data['create_time_ym'] = to_date(TIME_UTC,"Ym");
					$site_money_data['create_time_y'] = to_date(TIME_UTC,"Y");
					if($rs_sum['total_manage_money']!=0 && $get_manage==0){
						$site_money_data['memo'] = "[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($l_key)."期,借款管理费";
						$site_money_data['type'] = 10;
						$site_money_data['money'] = $rs_sum['total_manage_money'];
						$GLOBALS['db']->autoExecute(DB_PREFIX."site_money_log",$site_money_data,"INSERT");
					}
					if($rs_sum['total_repay_manage_impose_money']!=0){
						$site_money_data['memo'] = "[<a href='".$deal_info['url']."' target='_blank'>".$deal_info['name']."</a>],第".($l_key)."期,逾期管理费";
						$site_money_data['type'] = 12;
						$site_money_data['money'] = $rs_sum['total_repay_manage_impose_money'];
						$GLOBALS['db']->autoExecute(DB_PREFIX."site_money_log",$site_money_data,"INSERT");
					}
					
				}
				
			}
			syn_deal_status($deal_info['id']);
			syn_transfer_status(0,$deal_info['id']);
			$this->success("代还款执行完毕!");
		}
		else{
			register_shutdown_function(array(&$this, 'do_site_repay'), $page+1);
		}
	 }
	
	 
	 /**
	  * 待收款
	  */
	 function user_loads_repay(){
	 	$this->assign("main_title","收款信息");
		
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		switch($sorder){
			case "name":
			case "user_name":
					$order ="dlr.user_id";
				break;
			case "l_key_index":
					$order ="dlr.l_key_index";
				break;
			case "repay_money_format":
					$order ="dlr.repay_money";
				break;
			case "yuqi_money":
					$order ="(dlr.repay_money + dlr.impose_money)";
				break;
			case "shiji_money":
					$order ="(dlr.repay_money + dlr.impose_money)";
				break;
			case "repay_time":
					$order ="dlr.repay_time";
				break;
			case "all_repay_time":
				$order ="d.repay_time";
				break;
			case "true_repay_time":
				$order ="dlr.true_repay_time";
				break;
			case "status_format":
				$order ="dlr.status";
				break;
		
			default : 
				$order =$sorder;
				break;
		}
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
		
		$condition = " 1= 1 ";
		
		
		
		if(isset($_REQUEST['status'])){
			$status = intval($_REQUEST['status']);
			if($status >1){
				$condition .= " AND status=".($status-2)." AND has_repay=1";
			}else{
				if($status==1){
					$condition .= " AND has_repay=0";}
				
			}
		}
		
		
		$begin_time  = trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d");
		$end_time  = trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d") + 24*3600 - 1;
		
		
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and dlr.repay_time >= $begin_time ";	
			}
			else
				$condition .= " and dlr.repay_time between  $begin_time and ".($end_time+24*3600-1)." ";	
		}
		
		$sbegin_time  = trim($_REQUEST['sbegin_time']) =="" ? 0 : to_timespan($_REQUEST['sbegin_time'],"Y-m-d");
		$send_time  = trim($_REQUEST['send_time']) =="" ? 0 : to_timespan($_REQUEST['send_time'],"Y-m-d") + 24*3600 - 1;
		
		
		if($sbegin_time > 0 || $send_time > 0){
			if($send_time==0)
			{
				$condition .= " and dlr.true_repay_time >= $sbegin_time ";	
			}
			else
				$condition .= " and dlr.true_repay_time between  $sbegin_time and $send_time ";	
		}
		
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
		
		$sql_count = "SELECT count(*) FROM ".DB_PREFIX."deal_load_repay dlr LEFT JOIN ".DB_PREFIX."deal d On d.id = dlr.deal_id where $extWhere $condition";
		$rs_count = $GLOBALS['db']->getOne($sql_count);
		
		$list = array();
		if($rs_count > 0){
			if (! empty ( $_REQUEST ['listRows'] )) {
				$listRows = $_REQUEST ['listRows'];
			} else {
				$listRows = '';
			}
			$p = new Page ( $rs_count, $listRows );
			
			$sql_list =  "SELECT dlr.*,dlr.l_key +1 as l_key_index ,dl.money,d.name,d.rate,d.repay_time_type,d.repay_time as all_repay_time FROM ".DB_PREFIX."deal_load_repay dlr LEFT JOIN  ".DB_PREFIX."deal_load dl  ON dl.id = dlr.load_id LEFT JOIN ".DB_PREFIX."deal d On d.id = dlr.deal_id WHERE $condition  ORDER BY $order $sort LIMIT ".$p->firstRow . ',' . $p->listRows;
		
			$list = $GLOBALS['db']->getAll($sql_list);
			
			foreach($list as $k=>$v){
				$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
				$list[$k]['user_name'] = $GLOBALS['db']->getOne("select user_name from ".DB_PREFIX."user where id=".$v['user_id']);
				//状态
				if($v['has_repay'] == 0){
					$list[$k]['status_format'] = '待还';
				}elseif($v['status'] == 0){
					$list[$k]['status_format'] = '提前还款';
				}elseif($v['status'] == 1){
					$list[$k]['status_format'] = '正常还款';
				}elseif($v['status'] == 2){
					$list[$k]['status_format'] = '逾期还款';
				}elseif($v['status'] == 3){
					$list[$k]['status_format'] = '严重逾期';
				}
				$list[$k]['yuqi_money'] = format_price($v['interest_money']-$v['manage_money'] - $v['manage_interest_money']);
				if($list[$k]['has_repay'] == 1){
					$list[$k]['shiji_money'] = format_price($v['true_interest_money']+$v['impose_money']-$v['true_manage_money'] - $v['true_manage_interest_money']);
				}else {$list[$k]['shiji_money'] = 0;}
				$list[$k]['repay_money_format'] = format_price($v['repay_money']);
				
				$list[$k]['all_repay_time'] = ($v['repay_time_type']==0? $list[$k]['all_repay_time']." 天" : $list[$k]['all_repay_time']." 期") ;
			}
			
			$page = $p->show();
			$this->assign ( "page", $page );
			
		}
		
		$sortImg = $sort; //排序图标
		$sortAlt = $sort == 'desc' ? l("ASC_SORT") : l("DESC_SORT"); //排序提示
		$sort = $sort == 'desc' ? 1 : 0; //排序方式
		
		$this->assign ( 'sort', $sort );
		$this->assign ( 'order', $sorder );
		$this->assign ( 'sortImg', $sortImg );
		$this->assign ( 'sortType', $sortAlt );
		
		$this->assign ( 'list', $list );
		
		$this->display ();
	 }
	 
	 
	/**
	 * 放款
	 */
	function do_loans(){
		$id = intval($_REQUEST['id']);
		$repay_start_time = strim($_REQUEST['repay_start_time']);
		require_once APP_ROOT_PATH.'system/libs/user.php';
		require_once APP_ROOT_PATH.'system/common.php';
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		
		$result = do_loans($id,$repay_start_time);
		
		//更新凭证
		$loan_data =  array();
		$loan_data['loans_pic'] = strim($_REQUEST["loans_pic"]); 
		
		$GLOBALS['db']->autoExecute(DB_PREFIX."deal",$loan_data,"UPDATE","id=".$id);
		
		//投标 收益奖励
		$list = array();
		

		
		if($result['status'] == 2){
			ajax_return($result);
		}
		elseif($result['status'] == 1){
			
			
			$this->get_manage($id);
			
			
			$this->success($result['info']);
		}
		else
			$this->error($result['info']);
	}
	
	//收取管理费
	private function get_manage($id){
		//是否直接收取管理费
		if(intval($_REQUEST['get_manage'])==1){
			require_once(APP_ROOT_PATH."system/libs/user.php");
			require_once(APP_ROOT_PATH."system/common.php");
			$deal_name = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal where id='$id' ");
			$deal_repay = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_repay where deal_id='$id' AND has_repay=0 ");
			if($deal_repay){
				foreach($deal_repay as $k=>$v){
					if($v['manage_money']!=0 && $v['get_manage'] == 0){
						$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_repay SET true_manage_money = manage_money,get_manage=1 WHERE id=".$v['id']);
						if($GLOBALS['db']->affected_rows() > 0){
							modify_account(array("money"=>-$v['manage_money']),$v['user_id'],"[<a href='".url("index","deal#index",array("id"=>$v['deal_id']))."' target='_blank'>".$deal_name."</a>],第".($v['l_key']+1)."期,借款管理费",10);
							$GLOBALS['db']->query("UPDATE ".DB_PREFIX."deal_load_repay SET true_repay_manage_money = repay_manage_money WHERE repay_id=".$v['id']);
							
							$r_msg = "管理员放款收取";
							if($v['manage_money'] > 0){
								$r_msg .=",管理费：".format_price($v['manage_money']);
							}
							
							$adm_session = es_session::get(md5(conf("AUTH_KEY")));
							repay_log($v['id'],$r_msg,$v['user_id'],$adm_session['adm_id']);
						}
					}
				}
			}
		}
			
	}
	
	/**
	 * 流标返还
	 */
	function do_received(){
		$id = intval($_REQUEST['id']);
		$bad_msg = strim($_REQUEST['bad_msg']);
		
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		$result = do_received($id,0,$bad_msg);
		if($result['status'] == 2){
			ajax_return($result);
		}
		elseif($result['status']==1){
			$this->success($result['info']);
		}
		else{
			$this->error($result['info']);
		}
	}
	
	function do_export_load($page = 1)
	{	
		
		$id = intval($_REQUEST['id']);
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		$list = M("DealLoad")->limit($limit)->where('deal_id ='.$id)->findAll();
	
		if($list)
		{
			register_shutdown_function(array(&$this, 'do_export_load'), $page+1);
				
			$user_value = array('id'=>'""','user_name'=>'""','money'=>'""','create_time'=>'""','is_repay'=>'""','is_has_loans'=>'""','msg'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,投标人,投标金额,投标时间,流标返还,是否转账,转账备注");
	
			if($page==1)
				$content = $content . "\n";
	
			foreach($list as $k=>$v)
			{
				$user_value = array();
				$user_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$user_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$user_value['money'] = iconv('utf-8','gbk','"' . $v['money'] . '"');
				$user_value['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
				
				$user_value['is_repay'] = iconv('utf-8','gbk','"'.($v['is_repay']==0 ? "否" : "是").'"');
							
				$user_value['is_has_loans'] = iconv('utf-8','gbk','"'.($v['is_has_loans']==0 ? "否" : "是").'"');
				$user_value['msg'] = iconv('utf-8','gbk','"' . $v['msg'] . '"');
	
	
				$content .= implode(",", $user_value) . "\n";
			}
				
				
			header("Content-Disposition: attachment; filename=user_deal_list.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	
	}
	

	function do_allrepay_plan_export_load($page = 1)
	{
		$id = intval($_REQUEST['id']);
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$deal_info = get_deal($id,0);
		$contents = "";
		if($page==1){
			$repay_list  = get_deal_load_list($deal_info);
			if($repay_list)
			{	register_shutdown_function(array(&$this, 'do_allrepay_plan_export_load'), $page+1);
				$repay_plan_value_s = array('l_key'=>'""','repay_day_format'=>'""','month_has_repay_money_all_format'=>'""','month_need_all_repay_money_format'=>'""','month_need_all_repay_money'=>'""','month_repay_money_format'=>'""','month_manage_money_format'=>'""','impose_money_format'=>'""','manage_money_impose_format'=>'""','status_format');
				if($page==1)
					$contents = iconv("utf-8","gbk","第几期,还款日,已还总额,待还总额,还需还金额,待还本息,管理费,逾期费用,逾期管理费,还款情况");
		
				if($page==1)
					$contents = $contents . "\n";
				
				foreach($repay_list as $k=>$v)
				{
					$repay_plan_value_s = array();
					$repay_plan_value_s['l_key'] = iconv('utf-8','gbk','"' . ($v['l_key'] + 1) . '"');
					$repay_plan_value_s['repay_day_format'] = iconv('utf-8','gbk','"' . $v['repay_day_format'] . '"');
					$repay_plan_value_s['month_has_repay_money_all_format'] = iconv('utf-8','gbk','"' . $v['month_has_repay_money_all_format'] . '"');
					$repay_plan_value_s['month_need_all_repay_money_format'] = iconv('utf-8','gbk','"' . $v['month_need_all_repay_money_format'] . '"');
					$repay_plan_value_s['month_need_all_repay_money'] = iconv('utf-8','gbk','"'. $v['month_need_all_repay_money_format'] .'"');
					$repay_plan_value_s['month_repay_money_format'] = iconv('utf-8','gbk','"'. $v['month_repay_money_format'] .'"');
					$repay_plan_value_s['month_manage_money_format'] = iconv('utf-8','gbk','"' . $v['month_manage_money_format'] . '"');
					$repay_plan_value_s['impose_money_format'] = iconv('utf-8','gbk','"' . $v['impose_money_format'] . '"');
					$repay_plan_value_s['manage_money_impose_format'] = iconv('utf-8','gbk','"' . $v['manage_money_impose_format'] . '"');
					$repay_plan_value_s['status_format'] = iconv('utf-8','gbk','"' . $v['status_format'] . '"');
					$contents .= implode(",", $repay_plan_value_s) . "\n";
				}
		
			}
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
		
		
		header("Content-Disposition: attachment; filename=".$deal_info['name']."-还款计划.csv");
		echo $contents;
				
	
	
	
	}
	
	function do_repay_plan_export_load($page = 1)
	{
		$pages=1;
		$id = intval($_REQUEST['id']);
		$l_key = intval($_REQUEST['l_key']);
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$deal_info = get_deal($id,0);
		$content = "";
		$contents = "";
		if($page==1){
			$repay_list  = get_deal_load_list($deal_info);
			
			if($repay_list)
			{
				$repay_plan_value_s = array('l_key'=>'""','repay_day_format'=>'""','month_has_repay_money_all_format'=>'""','month_need_all_repay_money_format'=>'""','month_need_all_repay_money'=>'""','month_repay_money_format'=>'""','month_manage_money_format'=>'""','impose_money_format'=>'""','manage_money_impose_format'=>'""','status_format');
				if($page==1)
				$contents = iconv("utf-8","gbk","借款期数,还款日,已还金额,待还金额,还需还金额,到期应还本息,管理费,逾期费用,逾期管理费,还款情况");
				
				if($page==1)
				$contents = $contents . "\n";
				$repay_plan_value_s = array();
				$repay_plan_value_s['l_key'] = iconv('utf-8','gbk','"' . ($repay_list[$l_key]['l_key'] + 1) . '"');
				$repay_plan_value_s['repay_day_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['repay_day_format'] . '"');
				$repay_plan_value_s['month_has_repay_money_all_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['month_has_repay_money_all_format'] . '"');
				$repay_plan_value_s['month_need_all_repay_money_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['month_need_all_repay_money_format'] . '"');
				
				$repay_plan_value_s['month_need_all_repay_money'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['month_need_all_repay_money_format'] . '"');
				$repay_plan_value_s['month_repay_money_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['month_repay_money_format'] . '"');
				$repay_plan_value_s['month_manage_money_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['month_manage_money_format'] . '"');
				$repay_plan_value_s['impose_money_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['impose_money_format'] . '"');
				$repay_plan_value_s['manage_money_impose_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['manage_money_impose_format'] . '"');
				
				$repay_plan_value_s['status_format'] = iconv('utf-8','gbk','"' . $repay_list[$l_key]['status_format'] . '"');
				$contents .= implode(",", $repay_plan_value_s) . "\n";
				
			}
		}
		
		
			
		$sqll = array(deal_id=>$id, l_key=>$l_key);
		
		$deal_info = get_deal($sqll['deal_id']);//($deal_info,0,$l_key,-1,0,0,1,$limit)
		$listss = get_deal_user_load_list($deal_info,0,$sqll['l_key'],-1,0,0,1,$limit);// get_deal_load_list($deal_info);
		
		foreach ($listss['item'] as $k=>$v)
		{
			$listss['item'][$k]['yuqi_money']=format_price($v['month_repay_money'] + $v['impose_money'] -$v['self_money'] - $v['manage_money']);
			if($v['has_repay']==1)
				$listss['item'][$k]['real_money']=format_price($v['month_repay_money'] + $v['impose_money']  -$v['self_money'] - $v['manage_money']);
			else
				$listss['item'][$k]['real_money']=format_price("0.00");
		}
		$lists = $listss['item'];
	
		if($lists)
		{
			register_shutdown_function(array(&$this, 'do_repay_plan_export_load'), $page+1);
			$repay_plan_value = array('id'=>'""','user_name'=>'""','month_repay_money_format'=>'""','impose_money_format'=>'""','yuqi_money'=>'""','real_money'=>'""','status_format'=>'""','site_repay_format'=>'""');
			if($page == 1)
			{
				$content = iconv("utf-8","gbk","借款编号,会员,还款金额,逾期罚息,预期收益,实际收益,状态,还款人");}
	
			if($page==1)
				$content = $content . "\n";
	
			foreach($lists as $k=>$v)
			{
				$repay_plan_value = array();
				$repay_plan_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$repay_plan_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$repay_plan_value['month_repay_money_format'] = iconv('utf-8','gbk','"' . $v['month_repay_money_format'] . '"');
				$repay_plan_value['impose_money_format'] = iconv('utf-8','gbk','"' .$v['impose_money_format']. '"');
				$repay_plan_value['yuqi_money'] = iconv('utf-8','gbk','"'.$v['yuqi_money'].'"');
				$repay_plan_value['real_money'] = iconv('utf-8','gbk','"'.$v['real_money'].'"');
				$repay_plan_value['status_format'] = iconv('utf-8','gbk','"' .$v['status_format']. '"');
				$repay_plan_value['site_repay_format'] = iconv('utf-8','gbk','"' .$v['site_repay_format']. '"');
				$content .= implode(",", $repay_plan_value) . "\n";
			}
			
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
		
		
		header("Content-Disposition: attachment; filename=".$deal_info['name']."-第".($l_key+1)."期还款计划.csv");
		echo $contents;
		echo $content;
		
	}
	
public function export_csv_three($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
	
		switch($sorder){
			case "name":
			case "cate_id":
				$order ="d.".$sorder;
				break;
			case "has_repay_status":
				$order ="dl.status";
				break;
			case "site_bad_status":
				$order ="dl.is_site_bad";
				break;
			case "is_has_send":
				$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
				$order ="dl.l_key";
				break;
			default :
				$order ="dl.".$sorder;
				break;
		}
	
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "ASC";
		}
	
		//开始加载搜索条件
		$condition =" 1=1 ";
	
		$status = intval($_REQUEST['status']);
	
		if($status >0){
			if(($status-1)==0)
				$condition .= " AND dl.has_repay=0 ";
			else
				$condition .= " AND dl.has_repay=1 and dl.status=".($status-2);
		}
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
	
		$begin_time  = !isset($_REQUEST['begin_time'])? to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d")  : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])?to_timespan(to_date(TIME_UTC ,"Y-m-d"),"Y-m-d") + 3*24*3600: (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and dl.repay_time >= $begin_time ";
			}
			else
				$condition .= " and dl.repay_time between  $begin_time and ".($end_time+24*3600-1)." ";
		}
	
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
	
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
	
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dl.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";
		}
	
		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
	
		$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time,u.user_name,u.mobile FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id left join ".DB_PREFIX."user u on u.id=dl.user_id WHERE $condition  ORDER BY $order $sort LIMIT ".$limit;
		$list = $GLOBALS['db']->getAll($sql_list);
			
		foreach($list as $k=>$v){
			$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
			if($v['send_three_msg_time'] == $v['repay_time']){
				$list[$k]['is_has_send'] = "已发送";
			}
			else{
				$list[$k]['is_has_send'] = "未发送";
			}
			if($v['has_repay']==1){
				switch($v['status']){
					case 0;
					$list[$k]['has_repay_status'] = "提前还款";
					break;
					case 1;
					$list[$k]['has_repay_status'] = "准时还款";
					break;
					case 2;
					$list[$k]['has_repay_status'] = "逾期还款";
					break;
					case 3;
					$list[$k]['has_repay_status'] = "严重逾期";
					break;
				}
			}
			else{
				$list[$k]['has_repay_status'] = "未还";
			}
	
			if($v['is_site_bad'] == 1){
				$list[$k]['site_bad_status'] = "坏账";
			}
			else{
				$list[$k]['site_bad_status'] = "正常";
			}
			$list[$k]['cate_id'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$list[$k]['cate_id']);
			
		}
		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv_three'), $page+1);
	
			$three_value = array('id'=>'""','name'=>'""','l_key_index'=>'""','user_name'=>'""','mobile'=>'""','repay_money'=>'""','manage_money'=>'""','impose_money'=>'""','manage_impose_money'=>'""','repay_time'=>'""','cate_id'=>'""','has_repay_status'=>'""','site_bad_status'=>'""','is_has_send'=>'""');
			if($page == 1)
				$content = iconv("utf-8","utf-8","编号,贷款名称,第几期,借款人,手机号码,还款金额,管理费,逾期费用,逾期管理费用,还款日,投标类型,还款状态 ,账单状态,发送提示");
	
			if($page==1)
				$content = $content . "\n";
	
			foreach($list as $k=>$v)
			{
				$three_value = array();
				$three_value['id'] = iconv('utf-8','utf-8','"' . $v['id'] . '"');
				$three_value['name'] = iconv('utf-8','utf-8','"' . $v['name'] . '"');
				$three_value['l_key_index'] = iconv('utf-8','utf-8','"' . $v['l_key_index'] . '"');
				$three_value['user_name'] = iconv('utf-8','utf-8','"' . $v['user_name'] . '"');
				$three_value['mobile'] = iconv('utf-8','utf-8','"' . $v['mobile'] . '"');
				$three_value['repay_money'] = iconv('utf-8','utf-8','"'.format_price( $v['repay_money'] ).'"');
				$three_value['manage_money'] = iconv('utf-8','utf-8','"' . format_price($v['manage_money']) . '"');
				$three_value['impose_money'] = iconv('utf-8','utf-8','"' . format_price($v['impose_money']) . '"');
				$three_value['manage_impose_money'] = iconv('utf-8','utf-8','"'.format_price($v['manage_impose_money']).'"');
				$three_value['repay_time'] = iconv('utf-8','utf-8','"' .  to_date($v['repay_time'],"Y-m-d"). '"');
				$three_value['cate_id'] = iconv('utf-8','utf-8','"' . $list[$k]['cate_id'] . '"');
				$three_value['has_repay_status'] = iconv('utf-8','utf-8','"' . $v['has_repay_status'] . '"');
				$three_value['site_bad_status'] = iconv('utf-8','utf-8','"' . $v['site_bad_status'] . '"');
				$three_value['is_has_send'] = iconv('utf-8','utf-8','"' . $v['is_has_send'] . '"');
				$content .= implode(",", $three_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=repayment_bills_list.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	
	}
	
	
	public function export_csv_yuqi($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
		switch($sorder){
			case "name":
			case "cate_id":
				$order ="d.".$sorder;
				break;
			case "has_repay_status":
				$order ="dl.status";
				break;
			case "site_bad_status":
				$order ="dl.is_site_bad";
				break;
			case "is_has_send":
				$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
				$order ="dl.l_key";
				break;
			default :
				$order ="dl.".$sorder;
				break;
		}
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
	
		//开始加载搜索条件
		$condition .= "  (dl.repay_time + 24*3600 - 1) < ".TIME_UTC." AND dl.has_repay=0 ";
	
		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d");
		if($begin_time > 0){
			if($begin_time > TIME_UTC)
			{
				$this->error("不能超过当前时间");
			}
			$condition .= " and dl.repay_time >= $begin_time ";
		}
	
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dl.is_site_bad=".($deal_status-1);
		}
	
	
		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}
	
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dl.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";
		}
	
		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}
		$list = array();
		$sql_list =  " SELECT dl.*,dl.l_key + 1 as l_key_index,d.name,d.cate_id,d.send_three_msg_time,u.user_name,u.mobile FROM ".DB_PREFIX."deal_repay dl LEFT JOIN ".DB_PREFIX."deal d  ON d.id=dl.deal_id left join ".DB_PREFIX."user u on dl.user_id=u.id WHERE $condition ORDER BY $order $sort  LIMIT ".$limit;
		$list = $GLOBALS['db']->getAll($sql_list);
		foreach($list as $k=>$v){
			$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
			if($v['send_three_msg_time'] == $v['repay_time']){
				$list[$k]['is_has_send'] = "已发送";
			}
			else{
				$list[$k]['is_has_send'] = "未发送";
			}
			/*aaa*/
			$list[$k]['cate_id'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$list[$k]['cate_id']);
			
			if($v['has_repay']==1){
				switch($v['status']){
					case 0;
					$list[$k]['has_repay_status'] = "提前还款";
					break;
					case 1;
					$list[$k]['has_repay_status'] = "准时还款";
					break;
					case 2;
					$list[$k]['has_repay_status'] = "逾期还款";
					break;
					case 3;
					$list[$k]['has_repay_status'] = "严重逾期";
					break;
				}
			}
			else{
				$list[$k]['has_repay_status'] = "未还";
			}
	
			if($v['is_site_bad'] == 1){
				$list[$k]['site_bad_status'] = "坏账";
			}
			else{
				$list[$k]['site_bad_status'] = "正常";
			}
		}
	
		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv_yuqi'), $page+1);
				
			$yuqi_value = array('id'=>'""','name'=>'""','l_key_index'=>'""','user_name'=>'""','mobile'=>'""','repay_money'=>'""','manage_money'=>'""','impose_money'=>'""','manage_impose_money'=>'""','repay_time'=>'""','cate_id'=>'""','has_repay_status'=>'""','site_bad_status'=>'""','is_has_send'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,贷款名称,第几期,借款人,手机号码,还款金额,管理费,逾期费用,逾期管理费用,还款日,投标类型,还款状态 ,账单状态,发送提示");
	
			if($page==1)
				$content = $content . "\n";
	
			foreach($list as $k=>$v)
			{
				$yuqi_value = array();
				$yuqi_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$yuqi_value['name'] = iconv('utf-8','gbk','"' . $v['name'] . '"');
				$yuqi_value['l_key_index'] = iconv('utf-8','gbk','"' . $v['l_key_index'] . '"');
				$yuqi_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$yuqi_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$yuqi_value['repay_money'] = iconv('utf-8','gbk','"'.format_price( $v['repay_money'] ).'"');
				$yuqi_value['manage_money'] = iconv('utf-8','gbk','"' . format_price($v['manage_money']) . '"');
				$yuqi_value['impose_money'] = iconv('utf-8','gbk','"' . format_price($v['impose_money']) . '"');
				$yuqi_value['manage_impose_money'] = iconv('utf-8','gbk','"'.format_price($v['manage_impose_money']).'"');
				$yuqi_value['repay_time'] = iconv('utf-8','gbk','"' .  to_date($v['repay_time'],"Y-m-d"). '"');
				$yuqi_value['cate_id'] = iconv('utf-8','gbk','"' . $v['cate_id'] . '"');
				$yuqi_value['has_repay_status'] = iconv('utf-8','gbk','"' . $v['has_repay_status'] . '"');
				$yuqi_value['site_bad_status'] = iconv('utf-8','gbk','"' . $v['site_bad_status'] . '"');
				$yuqi_value['is_has_send'] = iconv('utf-8','gbk','"' . $v['is_has_send'] . '"');
				$content .= implode(",", $yuqi_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=yuqi_list.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	
	}
	
	public function export_csv_generation($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		if (isset ( $_REQUEST ['_order'] )) {
			$sorder = $_REQUEST ['_order'];
		}
		else{
			$sorder = "id";
		}
	
		switch($sorder){
			case "name":
			case "cate_id":
				$order ="d.".$sorder;
				break;
			case "site_bad_status":
				$order ="dr.is_site_bad";
				break;
			case "is_has_send":
				$order ="d.send_three_msg_time";
				break;
			case "l_key_index":
				$order ="dr.l_key";
				break;
			default :
				$order ="gr.".$sorder;
				break;
		}
	
		//排序方式默认按照倒序排列
		//接受 sost参数 0 表示倒序 非0都 表示正序
		if (isset ( $_REQUEST ['_sort'] )) {
			$sort = $_REQUEST ['_sort'] ? 'asc' : 'desc';
		}
		else{
			$sort = "desc";
		}
	
		$condition = " 1= 1 ";
	
		if(isset($_REQUEST['status'])){
			$status = intval($_REQUEST['status']);
			if($status >0){
				$condition .= " AND gr.status=".($status-1);
			}
		}
		else{
			$condition .= " AND gr.status=0";
			$_REQUEST['status'] = 1;
		}
	
		$begin_time  = trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d");
		$end_time  = trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d");
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and dr.repay_time >= $begin_time ";
			}
			else
				$condition .= " and dr.repay_time between  $begin_time and ".($end_time+24*3600-1)." ";
		}
	
		if($begin_time > 0)
			$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		if($end_time > 0)
			$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
	
	
		$deal_status = intval($_REQUEST['deal_status']);
		if($deal_status >0){
			$condition .= " AND dr.is_site_bad=".($deal_status-1);
		}


		if(trim($_REQUEST['name'])!='')
		{
			$condition .= " and d.name like '%".trim($_REQUEST['name'])."%'";
		}

		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and dr.user_id in (select id from  ".DB_PREFIX."user WHERE user_name='".trim($_REQUEST['user_name'])."')";
		}

		if(intval($_REQUEST['cate_id'])>0)
		{
			require_once APP_ROOT_PATH."system/utils/child.php";
			$child = new Child("deal_cate");
			$cate_ids = $child->getChildIds(intval($_REQUEST['cate_id']));
			$cate_ids[] = intval($_REQUEST['cate_id']);
			$condition .=" and d.cate_id in (".implode(",",$cate_ids).") ";
		}

		$list = array();
		$sql_list =  " SELECT gr.*,dr.l_key + 1 as l_key_index,dr.is_site_bad,dr.l_key,d.name,d.cate_id,d.send_three_msg_time,dr.user_id,dr.repay_time,agc.user_name as agency_name,u.user_name,u.mobile FROM ".DB_PREFIX."generation_repay gr LEFT join ".DB_PREFIX."deal_repay dr ON dr.id=gr.repay_id LEFT JOIN ".DB_PREFIX."deal d  ON d.id=gr.deal_id LEFT JOIN ".DB_PREFIX."user agc ON agc.id=gr.agency_id left join ".DB_PREFIX."user u on u.id=d.user_id  WHERE $condition ORDER BY $order $sort LIMIT ".$limit;

		$list = $GLOBALS['db']->getAll($sql_list);
		foreach($list as $k=>$v){
			$list[$k]['l_key_index'] = "第 ".$v['l_key_index']." 期";
			$list[$k]['admin_id'] = $GLOBALS['db']->getOne("select adm_name from ".DB_PREFIX."admin where id=".$list[$k]['admin_id']);
			$list[$k]['cate_id'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."deal_cate where id=".$list[$k]['cate_id']);
			if($v['status'] == 0){
				$list[$k]['status_format'] = "垫付待收款";
			}
			else{
				$list[$k]['status_format'] = "垫付已收款";
			}
				
			if($v['is_site_bad'] == 1){
				$list[$k]['site_bad_status'] = "坏账";
			}
			else{
				$list[$k]['site_bad_status'] = "正常";
			}
				
			$list[$k]['total_money'] = $v['repay_money'] + $v['manage_money'] + $v['impose_money']+ $v['manage_impose_money'];
				
			$list[$k]['create_time_format'] = to_date($v['create_time'],"Y-m-d H:i");
		}
		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv_generation'), $page+1);
				
			$generation_value = array('id'=>'""','name'=>'""','l_key_index'=>'""','cate_id'=>'""','user_name'=>'""','mobile'=>'""','repay_money'=>'""', 'manage_money'=>'""','impose_money'=>'""','manage_impose_money'=>'""','total_money'=>'""','repay_time'=>'""','create_time_format'=>'""','admin_id'=>'""','agency_name'=>'""','site_bad_status'=>'""','status_format'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,贷款名称,第几期,投标类型,借款人,电话号码,金额[垫],管理费[垫],逾期费[垫],逾期管理费[垫],总垫付,还款日,垫付时间,操作管理员,操作机构,账单状态,收款状态");

			if($page==1)
				$content = $content . "\n";

			foreach($list as $k=>$v)
			{
				$generation_value = array();
				$generation_value['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$generation_value['name'] = iconv('utf-8','gbk','"' . $v['name'] . '"');
				$generation_value['l_key_index'] = iconv('utf-8','gbk','"' . $v['l_key_index'] . '"');
				$generation_value['cate_id'] = iconv('utf-8','gbk','"' . $v['cate_id'] . '"');
				$generation_value['user_name'] = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
				$generation_value['mobile'] = iconv('utf-8','gbk','"' . $v['mobile'] . '"');
				$generation_value['repay_money'] = iconv('utf-8','gbk','"'.format_price( $v['repay_money'] ).'"');
				$generation_value['manage_money'] = iconv('utf-8','gbk','"' . format_price($v['manage_money']) . '"');
				$generation_value['impose_money'] = iconv('utf-8','gbk','"' . format_price($v['impose_money']) . '"');
				$generation_value['manage_impose_money'] = iconv('utf-8','gbk','"'.format_price($v['manage_impose_money']).'"');
				$generation_value['total_money'] = iconv('utf-8','gbk','"'.format_price($v['total_money']).'"');
				$generation_value['repay_time'] = iconv('utf-8','gbk','"' .  to_date($v['repay_time'],"Y-m-d"). '"');
				$generation_value['create_time_format'] = iconv('utf-8','gbk','"' .  to_date($v['create_time_format'],"Y-m-d"). '"');
				$generation_value['admin_id'] = iconv('utf-8','gbk','"' . $v['admin_id'] . '"');
				$generation_value['agency_name'] = iconv('utf-8','gbk','"' . $v['agency_name'] . '"');
				$generation_value['site_bad_status'] = iconv('utf-8','gbk','"' . $v['site_bad_status'] . '"');
				$generation_value['status_format'] = iconv('utf-8','gbk','"' . $v['status_format'] . '"');
				$content .= implode(",", $generation_value) . "\n";
			}
			header("Content-Disposition: attachment; filename=generation_list.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	
	}
	
	public function export_csv_site_money($page = 1)
	{
		set_time_limit(0);
		$limit = (($page - 1)*intval(app_conf("BATCH_PAGE_SIZE"))).",".(intval(app_conf("BATCH_PAGE_SIZE")));
	
		//$type_name = array("9" => "提现手续费","10" => "借款管理费","12" => "逾期管理费","13" => "人工操作","14" => "借款服务费","17" => "债权转让管理费","18" => "开户奖励","20" => "投标管理费","23" => "邀请返利","24" => "投标返利","25" => "签到成功","26" => "逾期罚金（垫付后）","27" => "其他费用","28" => "投资奖励","29" => "红包奖励",);
		$type_name = load_auto_cache("cache_money_type",array("class"=>"site_money"));
		unset($type_name['100']);
		//定义条件
	
		$begin_time  = !isset($_REQUEST['begin_time'])? 0 : (trim($_REQUEST['begin_time']) =="" ? 0 : to_timespan($_REQUEST['begin_time'],"Y-m-d"));
		$end_time  = !isset($_REQUEST['end_time'])? 0 : (trim($_REQUEST['end_time']) =="" ? 0 : to_timespan($_REQUEST['end_time'],"Y-m-d"));
		$status =!isset($_REQUEST['status'])?0 : (trim($_REQUEST['status'])== ""? 0 : intval($_REQUEST['status'])   );
		$condition = " 1=1 ";
		if($status >0){
			$condition .= " AND type=".$status;
		}
	
		if($begin_time > 0 || $end_time > 0){
			if($end_time==0)
			{
				$condition .= " and s.create_time >= $begin_time ";
			}
			else
				$condition .= " and s.create_time between  $begin_time and ".($end_time+24*3600-1)." ";
		}
	
		$_REQUEST['begin_time'] = to_date($begin_time ,"Y-m-d");
		$_REQUEST['end_time'] = to_date($end_time ,"Y-m-d");
	
	
		if(trim($_REQUEST['user_name'])!='')
		{
			$condition .= " and u.user_name like '%".trim($_REQUEST['user_name'])."%'";
		}
	
	
		$sql_list =  " select s.* ,u.user_name
						from ".DB_PREFIX."site_money_log s left join ".DB_PREFIX."user u on u.id=s.user_id
							WHERE $condition ORDER BY id desc LIMIT ".$limit;
	
		$list = $GLOBALS['db']->getAll($sql_list);
		foreach($list as $k=>$v){
			$list[$k]['type_format'] = $type_name[$v['type']];
		}
	
		if($list)
		{
			register_shutdown_function(array(&$this, 'export_csv_site_money'), $page+1);
			$referrals_value = array('id'=>'""','type_format'=>'""','user_id'=>'""','money'=>'""','memo'=>'""','create_time'=>'""');
			if($page == 1)
				$content = iconv("utf-8","gbk","编号,类型,关联用户,操作金额,操作备注,操作时间");
			$content = $content . "\n";
			foreach($list as $k=>$v)
			{
				$site_money_list = array();
				$site_money_list['id'] = iconv('utf-8','gbk','"' . $v['id'] . '"');
				$site_money_list['type_format'] = iconv('utf-8','gbk','"' . $v['type_format'] . '"');
				$site_money_list['user_id'] = iconv('utf-8','gbk','"' . get_user_name_reals($v['user_id']) . '"');
				$site_money_list['money'] = iconv('utf-8','gbk','"' . $v['money'] . '"');
				$site_money_list['memo'] = iconv('utf-8','gbk','"' . $v['memo'] . '"');
				$site_money_list['create_time'] = iconv('utf-8','gbk','"' . to_date($v['create_time']) . '"');
				$content .= implode(",", $site_money_list) . "\n";
			}
			header("Content-Disposition: attachment; filename=site_money_list.csv");
			echo $content;
		}
		else
		{
			if($page==1)
				$this->error(L("NO_RESULT"));
		}
	}
	public function q_contract()
	{
		require_once(APP_ROOT_PATH."app/Lib/common.php");
		require_once(APP_ROOT_PATH."app/Lib/deal.php");
		$id = intval($_REQUEST['id']);
		if($id == 0){
			echo "操作失败";
			die();
		}
		
		$deal = get_deal($id,0);
		
		if(!$deal){
			echo "借款不存在";
			die();
		}

		$GLOBALS['tmpl']->assign('deal',$deal);
		
		$loan_list = $GLOBALS['db']->getAll("select * FROM ".DB_PREFIX."deal_load WHERE deal_id=".$id." ORDER BY create_time ASC");
		foreach($loan_list as $k=>$v){
			$vv_deal['borrow_amount'] = $v['money'];
			$vv_deal['rate'] = $deal['rate'];
			$vv_deal['repay_time'] = $deal['repay_time'];
			$vv_deal['loantype'] = $deal['loantype'];
			$vv_deal['repay_time_type'] = $deal['repay_time_type'];
			
			$deal_rs =  deal_repay_money($vv_deal);
			$loan_list[$k]['get_repay_money'] = $deal_rs['month_repay_money'];
			if(is_last_repay($deal['loantype'])==1)
				$loan_list[$k]['get_repay_money'] = $deal_rs['remain_repay_money'];
		}
		
		$GLOBALS['tmpl']->assign('loan_list',$loan_list);
		
		if($deal['user']['sealpassed'] == 1){
			$credit_file = get_user_credit_file($deal['user_id']);
			$this->assign('user_seal_url',$credit_file['credit_seal']['file_list'][0]);
		}
		
		
		$GLOBALS['tmpl']->assign('SITE_URL',str_replace(array("https://","http://"),"",SITE_DOMAIN));
		$GLOBALS['tmpl']->assign('SITE_TITLE',app_conf("SITE_TITLE"));
		$GLOBALS['tmpl']->assign('CURRENCY_UNIT',app_conf("CURRENCY_UNIT"));
		
		$contract = $GLOBALS['tmpl']->fetch("str:".get_contract($deal['contract_id']));
		
		$this->assign('contract',$contract);
		
		$this->display();	
	}
	
	private function mortgage_info($type="infos"){
		$mortgage_infos = array();
		for($i=1;$i<=20;$i++){
			if(strim($_REQUEST['mortgage_'.$type.'_img_'.$i])!=""){
				$vv['name'] = strim($_REQUEST['mortgage_'.$type.'_name_'.$i]);
				$vv['img'] = strim($_REQUEST['mortgage_'.$type.'_img_'.$i]);
				$mortgage_infos[] = $vv;
			}
				
		}
		
		return serialize($mortgage_infos);
	}
	function interestrate_send()
	{
		$id = intval($_REQUEST["id"]);
		$ajax = intval($_REQUEST["ajax"]);
		
		$deal_info = $GLOBALS["db"]->getRow("select * from ".DB_PREFIX."deal where id=".$id." and is_delete = 0 and publish_wait = 0 and deal_status >= 4");
		
		if($deal_info)
		{
			$deal_load = $GLOBALS["db"]->getAll("select * from ".DB_PREFIX."deal_load where deal_id =".$id);
			$error = "";
			foreach($deal_load as $k => $v)
			{
				if(floatval($v["interestrate_money"])==0 && intval($v["interestrate_id"]) > 0 )
				{
					$deal_load_repay = $GLOBALS["db"]->getAll("select * from ".DB_PREFIX."deal_load_repay where deal_id =".$id);
					foreach($deal_load_repay as $kk => $vv)
					{
						$GLOBALS['db']->query("update ".DB_PREFIX."deal_load_repay set true_total_interest_money = interestrate_money + interest_money where load_id = ".$v["id"]); //更新deal_load_repay 真实发放的利息（包含加息券产生的）
					}
					
					$total_interestrate_money = $GLOBALS["db"]->getOne("select sum(interestrate_money) from ".DB_PREFIX."deal_load_repay where load_id =".$v["id"]);		
					
					if($total_interestrate_money>0)
					{
						$result = $this->send_ecv($v["user_id"],$total_interestrate_money);
					
						if($result)
						{	
							$GLOBALS['db']->query("update ".DB_PREFIX."deal_load set interestrate_money = ".$total_interestrate_money." where id = ".$v["id"]); //更新deal_load 加息券金额
							
							save_log("投资账单编号：".$v['id'].$log_info."加息券红包发放成功",1);
						}
						else
						{
							save_log("投资账单编号：".$v['id']."加息券红包发放失败".$dbErr,0);
							$error .= $v["id"].",";
						}
					}
					else
					{
						save_log("投资账单编号：".$v['id']."加息券红包为0".$dbErr,0);
					}
				}
			}
			
			if($error!="")
			{
				$this->error("投资账单编号：".$error."发放失败",$ajax);
			}
			else
			{
				
				$this->success("发放成功",$ajax);
			}
		}
		else
		{
			$log_info = "订单不存在或者状态不正确";
			save_log("编号：".$id."，".$log_info.",加息券红包发放失败".$dbErr,0);
			$this->error("发放失败",$ajax);
		}
		
	}
	function send_ecv($user_id,$money)
	{
		if($money <= 0)
		{
			return false;
		}
		require_once APP_ROOT_PATH."system/libs/voucher.php";
		
		$ecv_type_id = $GLOBALS["db"]->getOne("select id from ".DB_PREFIX."ecv_type where name ='加息券红包'");
		
		if(!$ecv_type_id)
		{
			$ecv_data = array();
			$ecv_data['name'] = "加息券红包";
			$ecv_data['money'] = 0.01;
			$ecv_data['use_limit'] = 1;
			$ecv_data['send_type'] = 0;
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."ecv_type",$ecv_data);
			$ecv_type_id = $GLOBALS['db']->insert_id();
		}
		
		$user_info = M("User")->where("id = ".$user_id)->find();

		if($user_info)
		{
			send_voucher($ecv_type_id,$user_id,0,$money);
			return true;
		}
		else
		{
			return false;
		}

	}
	function send_interestrate()
	{
		$map['is_delete'] = 0;
		if(trim($_REQUEST['name'])!='')
		{
			$map['name'] = array('like','%'.trim($_REQUEST['name']).'%');		
		}

		$map['publish_wait'] = 0;
		$this->getDeallist($map,intval($_REQUEST['cate_id']),$_REQUEST['user_name'],4);
		
		$list = $this->get("list");
		
		$error = "";
		
		foreach($list as $tk => $tv)
		{
			$id = $tv["id"];
			
			$deal_info = $GLOBALS["db"]->getRow("select * from ".DB_PREFIX."deal where id=".$id." and is_delete = 0 and publish_wait = 0 and deal_status >= 4");
			
			if($deal_info)
			{
				$deal_load = $GLOBALS["db"]->getAll("select * from ".DB_PREFIX."deal_load where deal_id =".$id);
				foreach($deal_load as $k => $v)
				{
					if(floatval($v["interestrate_money"])==0 && intval($v["interestrate_id"]) > 0 )
					{
						$deal_load_repay = $GLOBALS["db"]->getAll("select * from ".DB_PREFIX."deal_load_repay where deal_id =".$id);
						foreach($deal_load_repay as $kk => $vv)
						{
							$GLOBALS['db']->query("update ".DB_PREFIX."deal_load_repay set true_total_interest_money = interestrate_money + interest_money where load_id = ".$v["id"]); //更新deal_load_repay 真实发放的利息（包含加息券产生的）
						}
						
						$total_interestrate_money = $GLOBALS["db"]->getOne("select sum(interestrate_money) from ".DB_PREFIX."deal_load_repay where load_id =".$v["id"]);		
						
						if($total_interestrate_money>0)
						{
							$result = $this->send_ecv($v["user_id"],$total_interestrate_money);
						
							if($result)
							{	
								$GLOBALS['db']->query("update ".DB_PREFIX."deal_load set interestrate_money = ".$total_interestrate_money." where id = ".$v["id"]); //更新deal_load 加息券金额
								
								save_log("投资账单编号：".$v['id'].$log_info."加息券红包发放成功",1);
							}
							else
							{
								save_log("投资账单编号：".$v['id']."加息券红包发放失败".$dbErr,0);
								$error .= $v["id"].",";
							}
						}
						else
						{
							save_log("投资账单编号：".$v['id']."加息券红包为0",1);
						}
					}
				}
			}
			else
			{
				$log_info = "订单不存在或者状态不正确";
				save_log("编号：".$id."，".$log_info.",加息券红包发放失败".$dbErr,0);
				//$this->error("发放失败",$ajax);
			}
		}
		
		if($error!="")
		{
			$result = array();
			$result["info"] = "投资账单编号：".$error."，加息券红包发放失败".$dbErr;
			$result["status"]="1";
			
			
		}
		else
		{
			$result = array();
			$result["info"] = "发放成功";
			$result["status"]="1";

			//$this->success("发放成功",$ajax);
		}
		
		return ajax_return($result);
	}
}

function get_time_type($time,$deal){
	if($deal['repay_time_type']==1){
		return $time."个月";
	}
	else{
		return $time."天";
	}
}

?>