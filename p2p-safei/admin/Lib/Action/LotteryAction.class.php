<?php
// +----------------------------------------------------------------------
// | 抽奖
// +----------------------------------------------------------------------
// | Author: MuBai
// | Date: 2017.08.16
// +----------------------------------------------------------------------

class LotteryAction extends CommonAction
{
    /**
     * 活动列表
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

        $model = D("LotteryActivity");
        
        if (!empty($model)) {
            $this->_list($model, $map);
        }
        $list = $this->get("list");
        foreach ($list as $k => $v) {
            if ($list[$k]['status']==0) $list[$k]['status'] = "未开始";
            if ($list[$k]['status']==1) $list[$k]['status'] = "进行中";
            if ($list[$k]['status']==2) $list[$k]['status'] = "已结束";

            $list[$k]['time_start'] = date("Y-m-d H:i", $list[$k]['time_start']);
            $list[$k]['time_end'] = date("Y-m-d H:i", $list[$k]['time_end']);
            $list[$k]['time_modified'] = date("Y-m-d H:i", $list[$k]['time_modified']);
            $list[$k]['time_create'] = date("Y-m-d H:i", $list[$k]['time_create']);
        }
        $this->assign("list", $list);
        $this->display();

        return;
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

    /**
     * 编辑页面
     */
    public function edit()
    {
        $id = (int)$_REQUEST['id'];

        $condition['id'] = $id;
        $vo              = M("LotteryActivity")->where($condition)->find();
        $vo['time_start'] = date('Y-m-d H:i:s', $vo['time_start']);
        $vo['time_end']   = date('Y-m-d H:i:s', $vo['time_end']);
        $this->assign('vo', $vo);

        $this->display();
    }

    /**
     * 更新
     */
    public function update()
    {
        $data = M("LotteryActivity")->create();

        $data['time_start']    = strtotime($data['time_start']);
        $data['time_end']      = strtotime($data['time_end']);
        $data['time_modified'] = time();

        // 更新数据
        $list = M("LotteryActivity")->save($data);
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
            $list = M("LotteryActivity")->where($condition)->delete();
            if ($list !== false) {

                $this->success(l("FOREVER_DELETE_SUCCESS"), $ajax);
            } else {

                $this->error(l("FOREVER_DELETE_FAILED"), $ajax);
            }
        } else {
            $this->error(l("INVALID_OPERATION"), $ajax);
        }
    }

}
?>