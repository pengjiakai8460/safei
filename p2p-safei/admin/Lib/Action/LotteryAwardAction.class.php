<?php
// +----------------------------------------------------------------------
// | 抽奖记录
// +----------------------------------------------------------------------
// | Author: MuBai
// | Date: 2017.08.17
// +----------------------------------------------------------------------

class LotteryAwardAction extends CommonAction
{
    /**
     * 抽奖记录列表
     */
    public function index()
    {
        //列表过滤器，生成查询Map对象
        $map = $this->_search();
        //追加默认参数
        if ($this->get("default_map"))
            $map = array_merge($map, $this->get("default_map"));

        if (method_exists($this, '_filter')) {
            $this->_filter($map);
        }

        $model          = D("LotteryAwardLog");
        $activity       = M("LotteryActivity");
        $activity_goods = M("LotteryGoods");
        $user           = M("User");

        if (!empty($model)) {
            $this->_list($model, $map);
        }
        $list = $this->get("list");
        foreach ($list as $k => $v) {
            $list[$k]['activity_name'] = $activity->where('id='.$v['activity_id'])->getField('name');
            $list[$k]['user_name']     = $user->where('id='.$v['user_id'])->getField('user_name');
            $list[$k]['goods_name']    = $activity_goods->where('id='.$v['goods_id'])->getField('name');

            if ($list[$k]['status']==0) $list[$k]['status'] = "中奖";
            if ($list[$k]['status']==1) $list[$k]['status'] = "已发放";

            $list[$k]['time_modified'] = date("Y-m-d H:i", $list[$k]['time_modified']);
            $list[$k]['time_create'] = date("Y-m-d H:i", $list[$k]['time_create']);
        }
        $this->assign("list", $list);
        $this->display();

        return;
    }

    /**
     * 编辑页面
     */
    public function edit()
    {
        $id = (int)$_REQUEST['id'];

        $activity       = M("LotteryActivity");
        $activity_goods = M("LotteryGoods");
        $user           = M("User");

        $vo = M("LotteryAwardLog")->where('id='.$id)->find();
        $vo['activity_name'] = $activity->where('id='.$vo['activity_id'])->getField('name');
        $vo['user_name']     = $user->where('id='.$vo['user_id'])->getField('user_name');
        $vo['goods_name']    = $activity_goods->where('id='.$vo['goods_id'])->getField('name');
        $this->assign('vo', $vo);

        $this->display();
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = M("LotteryAwardLog")->create();

        $data['time_modified'] = time();

        // 更新数据
        $list = M("LotteryAwardLog")->save($data);
        if (false !== $list) {

            save_log($data['name'] . L("UPDATE_SUCCESS"), 1);
            $this->success(L("UPDATE_SUCCESS"));
        } else {
            //错误提示
            save_log($data['name'] . L("UPDATE_FAILED"), 0);
            $this->error(L("UPDATE_FAILED"));
        }
    }

    /**
     * 删除
     */
    public function delete()
    {
        //彻底删除指定记录
        $ajax = intval($_REQUEST['ajax']);
        $id   = $_REQUEST['id'];

        if (isset($id)) {
            $condition = array(
                'id' => array(
                    'in',
                    explode(',', $id)
                )
            );
            //删除的验证
            $list = M("LotteryAwardLog")->where($condition)->delete();
            if ($list !== false) {

                $this->success(l("FOREVER_DELETE_SUCCESS"), $ajax);
            } else {

                $this->error(l("FOREVER_DELETE_FAILED"), $ajax);
            }
        } else {
            $this->error(l("INVALID_OPERATION"), $ajax);
        }
    }

    /**
     * 活动添加界面
     */
    public function add()
    {
        $this->display();
    }

    /**
     * 活动插入
     */
    public function insert()
    {
        $data = M("LotteryActivity")->create();

        $data['time_start']    = strtotime($data['time_start']);
        $data['time_end']      = strtotime($data['time_end']);
        $data['time_modified'] = time();
        $data['time_create']   = time();
        $list = M("LotteryActivity")->add($data);

        if(false !== $list) $this->success("添加成功");
        else $this->error(L("INSERT_FAILED"));
    }

}
?>