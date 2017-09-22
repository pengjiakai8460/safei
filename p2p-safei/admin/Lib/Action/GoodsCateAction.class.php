<?php
// +----------------------------------------------------------------------
// | easethink 方维借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------

class GoodsCateAction extends CommonAction{
	public function index()
	{	
		$condition['is_delete'] = 0;
		$condition['pid'] = 0;
		$this->assign("default_map",$condition);
		
		//列表过滤器，生成查询Map对象
		$map = $this->_search ();
		//追加默认参数
		if($this->get("default_map"))
		$map = array_merge($map,$this->get("default_map"));
		
		if (method_exists ( $this, '_filter' )) {
			$this->_filter ( $map );
		}
		
		$model = D ("GoodsCate");
		if (! empty ( $model )) {
			$this->_list ( $model, $map );
		}
		$list = $this->get("list");
		
		$result = array();
		$row = 0;
		foreach($list as $k=>$v)
		{
			$v['level'] = -1;
			$v['name'] = $v['name'];
			$result[$row] = $v;
			$row++;
			$sub_cate = M("GoodsCate")->where(array("id"=>array("in",D("GoodsCate")->getChildIds($v['id'])),'is_delete'=>0))->findAll();
			$sub_cate = D("GoodsCate")->toFormatTree($sub_cate,'name');
			
			foreach($sub_cate as $kk=>$vv)
			{
				$vv['name']	=	$vv['title_show'];
				$vv['pname']	= M("GoodsCate")->where("id=".$vv['pid'])->getField("name");
				$result[$row] = $vv;
				$row++;
			}
		}
		//dump($result);exit;
		$this->assign("list",$result);
		$this->display ();
		return;
	}
	/*
	public function trash()
	{
		$goods_cate = M("GoodsCate")->where('is_delete = 1')->findAll();
		
		$this->assign("goods_cate",$goods_cate);
		$this->display ();
	}*/
	
	public function edit()
	{
		$id = intval($_REQUEST ['id']);
		
		$condition['id'] = $id;
		$vo = M("GoodsCate")->where($condition)->find();
		$this->assign ( 'vo', $vo );
		
		$list = M("GoodsCate")->where('pid=0 and is_delete= 0 and is_effect=1 AND id <> '.$id)->findAll();
		
		$this->assign ( 'list', $list );
		$this->display ();
		
	}
	
	public function update()
	{
		$data = M("GoodsCate")->create();
		// 更新数据
		$list=M("GoodsCate")->save($data);
		
		
		if (false !== $list) {
			//成功提示
			save_log($data['name'].L("UPDATE_SUCCESS"),1);
			$this->success(L("UPDATE_SUCCESS"));
		} else {
			//错误提示
			save_log($data['name'].L("UPDATE_FAILED"),0);
			$this->error(L("UPDATE_FAILED"),0,$data['name'].L("UPDATE_FAILED"));
		}
	}
	/*
	public function delete() {
		//删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {

			$condition = array ();
			$condition['id'] = array ('in', explode ( ',', $id ) );
			$condition['is_delete'] = 0;
			
			$rel_data = M("GoodsCate")->where($condition)->findAll();
			foreach($rel_data as $k=>$v){
				$info[] =$v['name'];
			}
			if($info) $info = implode(",",$info);
			$list = M("GoodsCate")->where ( $condition )->setField ( 'is_delete', 1 );
			if ($list!==false) {
				save_log($info.l("DELETE_SUCCESS"),1);
				$this->success (l("DELETE_SUCCESS"),$ajax);
			} else {
				save_log($info.l("DELETE_FAILED"),0);
				$this->error (l("DELETE_FAILED"),$ajax);
			}
			
		} else {
			$this->error (l("INVALID_OPERATION"),$ajax);
		}
	}
	
	public function restore(){
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
		
			$condition = array ();
			$condition['id'] = array ('in', explode ( ',', $id ) );
			$condition['is_delete'] = 1;
				
			$rel_data = M("GoodsCate")->where($condition)->findAll();
			foreach($rel_data as $k=>$v){
				$info[] =$v['name'];
			}
			if($info) $info = implode(",",$info);
			$list = M("GoodsCate")->where ( $condition )->setField ( 'is_delete', 0);
			if ($list!==false) {
				
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
	*/
	public function delete(){
		//彻底删除指定记录
		$ajax = intval($_REQUEST['ajax']);
		$id = $_REQUEST ['id'];
		if (isset ( $id )) {
			$condition = array ('id' => array ('in', explode ( ',', $id ) ) );
			//删除的验证
			
			$rel_data = M("GoodsCate")->where($condition)->findAll();
			foreach($rel_data as $data)
			{
				$info[] = $data['name'];
			}
			if($info) $info = implode(",",$info);
			$list = M("GoodsCate")->where ( $condition )->delete();
				
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
	
	public function add() {
		
		$condition['is_delete'] = 0;
		$condition['pid'] = 0;
		
		$list = M("GoodsCate") ->where($condition) -> findAll();
		
		$sort = M("GoodsCate") -> max("sort");
		
		$this->assign ( 'list', $list );
		$this->assign ( 'newsort', $sort  + 1);
		
		
		$this->display ();
	}
	
	
	public function insert()
	{
		
		$data = M("GoodsCate")->create ();
	
		// 更新数据
		$list=M("GoodsCate")->add ($data);
	
		if (false !== $list) {
			
			save_log($data['name'].L("INSERT_SUCCESS"),1);
			$this->assign("jumpUrl",u(MODULE_NAME."/add"));
			$this->success(L("INSERT_SUCCESS"));
		} else {
			//错误提示
			$dbErr = M()->getDbError();
			save_log($data['name'].L("INSERT_FAILED").$dbErr,0);
			$this->error(L("INSERT_FAILED").$dbErr);
		}
		
	}
	
	public function set_effect()
	{
		$id = intval($_REQUEST['id']);
		$ajax = intval($_REQUEST['ajax']);
		$info = M("GoodsCate")->where("id=".$id)->getField("name");
		$c_is_effect = M("GoodsCate")->where("id=".$id)->getField("is_effect");  //当前状态
		$n_is_effect = $c_is_effect == 0 ? 1 : 0; //需设置的状态
		M("GoodsCate")->where("id=".$id)->setField("is_effect",$n_is_effect);	
		save_log($info.l("SET_EFFECT_".$n_is_effect),1);
		
		$this->ajaxReturn($n_is_effect,l("SET_EFFECT_".$n_is_effect),1)	;	
	}
	
	
}
?>