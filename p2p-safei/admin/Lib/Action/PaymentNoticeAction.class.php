<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------

class PaymentNoticeAction extends CommonAction
{
    public function com_search()
    {
        $map = array();
        
        if (!isset($_REQUEST['end_time']) || $_REQUEST['end_time'] == '') {
            $_REQUEST['end_time'] = to_date(get_gmtime(), 'Y-m-d');
        }
        
        
        if (!isset($_REQUEST['start_time']) || $_REQUEST['start_time'] == '') {
            $_REQUEST['start_time'] = dec_date($_REQUEST['end_time'], 7); // $_SESSION['q_start_time_7'];
        }
        
        $map['start_time'] = trim($_REQUEST['start_time']);
        $map['end_time']   = trim($_REQUEST['end_time']);
        
        $this->assign("start_time", $map['start_time']);
        $this->assign("end_time", $map['end_time']);
        
        
        if ($map['start_time'] == '') {
            $this->error('开始时间 不能为空');
            exit;
        }
        
        if ($map['end_time'] == '') {
            $this->error('结束时间 不能为空');
            exit;
        }
        
        $d = explode('-', $map['start_time']);
        if (checkdate($d[1], $d[2], $d[0]) == false) {
            $this->error("开始时间不是有效的时间格式:{$map['start_time']}(yyyy-mm-dd)");
            exit;
        }
        
        $d = explode('-', $map['end_time']);
        if (checkdate($d[1], $d[2], $d[0]) == false) {
            $this->error("结束时间不是有效的时间格式:{$map['end_time']}(yyyy-mm-dd)");
            exit;
        }
        
        if (to_timespan($map['start_time']) > to_timespan($map['end_time'])) {
            $this->error('开始时间不能大于结束时间:' . $map['start_time'] . '至' . $map['end_time']);
            exit;
        }
        
        $q_date_diff = 31;
        $this->assign("q_date_diff", $q_date_diff);
        //echo abs(to_timespan($map['end_time']) - to_timespan($map['start_time'])) / 86400 + 1;
        if ($q_date_diff > 0 && (abs(to_timespan($map['end_time']) - to_timespan($map['start_time'])) / 86400 + 1 > $q_date_diff)) {
            $this->error("查询时间间隔不能大于  {$q_date_diff} 天");
            exit;
        }
        
        return $map;
    }
    
    public function index()
    {
        $map = $this->com_search();

        if(trim($_REQUEST['order_sn']) != '') $condition['order_id'] = M("DealOrder")->where("order_sn='" . trim($_REQUEST['order_sn']) . "'")->getField("id");
        if(intval($_REQUEST['no_payment_id']) > 0) $condition['payment_id'] = array("neq", intval($_REQUEST['no_payment_id']));
        if (trim($_REQUEST['notice_sn']) != '') $condition['notice_sn'] = $_REQUEST['notice_sn'];
        
        if ($map['start_time'] != '' && $map['end_time'] && (!isset($_REQUEST['is_paid']) || intval($_REQUEST['is_paid']) == -1 || intval($_REQUEST['is_paid']) == 1)) {
            if (intval($_REQUEST['is_paid']) == 1)
                $condition['pay_date'] = array(
                    "between",
                    array(
                        $map['start_time'],
                        $map['end_time']
                    )
                );
            else
                $condition['create_date'] = array(
                    "between",
                    array(
                        $map['start_time'],
                        $map['end_time']
                    )
                );
        }
        
        if(intval($_REQUEST['is_paid']) == 0) $condition['create_date'] = array("between", array($map['start_time'], $map['end_time']));

        $payment_id = M("Payment")->where("class_name = 'Otherpay' ")->getField("id");
        $condition['payment_id'] = array("neq", intval($payment_id));
        
        if (intval($_REQUEST['payment_id']) == 0) unset($_REQUEST['payment_id']);
        else $condition['payment_id'] = array("eq", intval($_REQUEST['payment_id']));
        if (intval($_REQUEST['is_paid']) == -1 || !isset($_REQUEST['is_paid'])) unset($_REQUEST['is_paid']);

        $this->assign("default_map", $condition);
        $this->assign("payment_list", M("Payment")->findAll());
        parent::index();
    }

    /**
     * 导出列表-在线充值
     */
    public function export_csv()
    {
		$type = $_REQUEST['type'];
		if($type == 2)
		{
			set_time_limit(0);

			$start      = strtotime($_REQUEST['start_time']);
			$end        = strtotime($_REQUEST['end_time']);
			$notice_sn  = trim($_REQUEST['notice_sn']);
			$payment_id = 5;
			$is_paid    = (int)$_REQUEST['is_paid'];

			$condition = array();
			$condition[DB_PREFIX.'payment_notice.create_time'] = array(array('egt', $start), array('elt', $end));
			if(!empty($notice_sn)) $condition[DB_PREFIX.'payment_notice.notice_sn'] = array('like', '%'.$notice_sn.'%');
			if(!empty($payment_id)) $condition[DB_PREFIX.'payment_notice.payment_id'] = array('eq', $payment_id);
			if($is_paid>-1) $condition[DB_PREFIX.'payment_notice.is_paid'] = array('eq', $is_paid);

			$list = M("PaymentNotice")
				->where($condition)
				->join(DB_PREFIX.'user ON '.DB_PREFIX.'user.id = '.DB_PREFIX.'payment_notice.user_id')
				->join(DB_PREFIX.'payment ON '.DB_PREFIX.'payment.id = '.DB_PREFIX.'payment_notice.payment_id')
				->field(DB_PREFIX.'payment_notice.*, '.DB_PREFIX.'user.user_name, '.DB_PREFIX.'payment.name AS payment_name')
				->findAll();

			if($list)
			{
				$content = iconv("utf-8","gbk","编号,付款单号,创建时间,支付时间,是否已支付,会员名称,付款单金额,银行流水号,银行账户,付款单备注");
				$content = $content . "\n";

				foreach($list as $k=>$v)
				{
					if($v['is_paid']==0) $is_paid = '未支付';
					if($v['is_paid']==1) $is_paid = '已支付';
					
					$pay_time = $v['pay_time'] > 0 ? date('Y-m-d H:i:s',$v['pay_time']) : '';
					
					$carry_value = array();
					$carry_value['id']              = iconv('utf-8','gbk','"' . $v['id'] . '"');
					$carry_value['notice_sn']       = iconv('utf-8','gbk',"'" . $v['notice_sn']);
					$carry_value['create_time']     = iconv('utf-8','gbk','"' . date('Y-m-d H:i:s', $v['create_time']).' "');
					$carry_value['pay_time']        = iconv('utf-8','gbk','"' . $pay_time.' "');
					$carry_value['is_paid']         = iconv('utf-8','gbk','"' . $is_paid. '"');
					$carry_value['user_name']       = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
					$carry_value['money']           = iconv('utf-8','gbk','"' . number_format($v['money'],2) . '"');
					$carry_value['outer_notice_sn'] = iconv('utf-8','gbk',"'" . $v['outer_notice_sn']);
					$carry_value['bank_id'] = iconv('utf-8','gbk',"'" . $v['bank_id']);
					$carry_value['memo']            = iconv('utf-8','gbk','"' . $v['memo'] . '"');
					$content .= implode(",", $carry_value) . "\n";
					
					unset($pay_time);
				}

				header("Content-Disposition: attachment; filename=payment_notice_list.csv");
				echo $content;
			}
			else
			{
				$this->error(L("NO_RESULT"));
			}
			
		}else
		{
			set_time_limit(0);

			$start      = strtotime($_REQUEST['start_time']);
			$end        = strtotime($_REQUEST['end_time']);
			$notice_sn  = trim($_REQUEST['notice_sn']);
			$payment_id = (int)$_REQUEST['payment_id'];
			$is_paid    = (int)$_REQUEST['is_paid'];

			$condition = array();
			$condition[DB_PREFIX.'payment_notice.create_time'] = array(array('egt', $start), array('elt', $end));
			if(!empty($notice_sn)) $condition[DB_PREFIX.'payment_notice.notice_sn'] = array('like', '%'.$notice_sn.'%');
			if(!empty($payment_id)) $condition[DB_PREFIX.'payment_notice.payment_id'] = array('eq', $payment_id);
			if($is_paid>-1) $condition[DB_PREFIX.'payment_notice.is_paid'] = array('eq', $is_paid);

			$list = M("PaymentNotice")
				->where($condition)
				->join(DB_PREFIX.'user ON '.DB_PREFIX.'user.id = '.DB_PREFIX.'payment_notice.user_id')
				->join(DB_PREFIX.'payment ON '.DB_PREFIX.'payment.id = '.DB_PREFIX.'payment_notice.payment_id')
				->field(DB_PREFIX.'payment_notice.*, '.DB_PREFIX.'user.user_name, '.DB_PREFIX.'payment.name AS payment_name')
				->findAll();

			if($list)
			{
				$content = iconv("utf-8","gbk","编号,付款单号,创建时间,支付时间,是否已支付,会员名称,收款方式,付款单金额,收手续费,支出手续费,支付平台交易号,付款单备注");
				$content = $content . "\n";

				foreach($list as $k=>$v)
				{
					if($v['is_paid']==0) $is_paid = '未支付';
					if($v['is_paid']==1) $is_paid = '已支付';
					
					$pay_time = $v['pay_time'] > 0 ? date('Y-m-d H:i:s',$v['pay_time']) : '';
					
					$carry_value = array();
					$carry_value['id']              = iconv('utf-8','gbk','"' . $v['id'] . '"');
					$carry_value['notice_sn']       = iconv('utf-8','gbk',"'" . $v['notice_sn']);
					$carry_value['create_time']     = iconv('utf-8','gbk','"' . date('Y-m-d H:i:s', $v['create_time']).' "');
					$carry_value['pay_time']        = iconv('utf-8','gbk','"' . $pay_time.' "');
					$carry_value['is_paid']         = iconv('utf-8','gbk','"' . $is_paid. '"');
					$carry_value['user_name']       = iconv('utf-8','gbk','"' . $v['user_name'] . '"');
					$carry_value['payment_name']    = iconv('utf-8','gbk','"' . $v['payment_name'] . '"');
					$carry_value['money']           = iconv('utf-8','gbk','"' . number_format($v['money'],2) . '"');
					$carry_value['fee_amount']      = iconv('utf-8','gbk','"' . number_format($v['fee_amount'],2) . '"');
					$carry_value['pay_fee_amount']  = iconv('utf-8','gbk','"' . number_format($v['pay_fee_amount'],2) . '"');
					$carry_value['outer_notice_sn'] = iconv('utf-8','gbk',"'" . $v['outer_notice_sn']);
					$carry_value['memo']            = iconv('utf-8','gbk','"' . $v['memo'] . '"');
					$content .= implode(",", $carry_value) . "\n";
					
					unset($pay_time);
				}

				header("Content-Disposition: attachment; filename=payment_notice_list.csv");
				echo $content;
			}
			else
			{
				$this->error(L("NO_RESULT"));
			}
		}
    }
    
    public function online()
    {
        $map = $this->com_search();
        if (trim($_REQUEST['order_sn']) != '') {
            $condition['order_id'] = M("DealOrder")->where("order_sn='" . trim($_REQUEST['order_sn']) . "'")->getField("id");
        }
        if (intval($_REQUEST['no_payment_id']) > 0) {
            $condition['payment_id'] = array(
                "neq",
                intval($_REQUEST['no_payment_id'])
            );
        }
        if (trim($_REQUEST['notice_sn']) != '') {
            $condition['notice_sn'] = $_REQUEST['notice_sn'];
        }
        $payment_id              = M("Payment")->where("class_name = 'Otherpay'")->getField("id");
        $condition['payment_id'] = $payment_id;
        
        if ($map['start_time'] != '' && $map['end_time']) {
            $condition['create_time'] = array(
                "between",
                array(
                    to_timespan($map['start_time'], "Y-m-d"),
                    to_timespan(dec_date($map['end_time'], -1), "Y-m-d")
                )
            );
        }
        
        if (intval($_REQUEST['is_paid']) == -1 || !isset($_REQUEST['is_paid']))
            unset($_REQUEST['is_paid']);
        $this->assign("default_map", $condition);
        parent::index();
        
    }
    
    //管理员收款
    public function update()
    {
        $notice_id       = intval($_REQUEST['id']);
        $outer_notice_sn = strim($_REQUEST['outer_notice_sn']);
        $bank_id         = strim($_REQUEST['bank_id']);
        
        //开始由管理员手动收款
        require_once APP_ROOT_PATH . "system/libs/cart.php";
        $payment_notice = $GLOBALS['db']->getRow("select * from " . DB_PREFIX . "payment_notice where id = " . $notice_id);
        
        if ($payment_notice['is_paid'] == 0) {
            if ($bank_id) {
                $GLOBALS['db']->query("update " . DB_PREFIX . "payment_notice set  bank_id = " . $bank_id . " where id = " . $notice_id . " and is_paid = 0");
            } else {
                $this->error("请输入直联银行编号");
            }
            payment_paid($notice_id, "银行流水号 " . ':' . $outer_notice_sn); //对其中一条款支付的付款单付款
            $msg = sprintf(l("ADMIN_PAYMENT_PAID"), $payment_notice['notice_sn']);
            save_log($msg, 1);
            $this->success(l("ORDER_PAID_SUCCESS"));
        } else {
            $this->error(l("INVALID_OPERATION"));
        }
    }
    
    public function gathering()
    {
        $id = intval($_REQUEST['id']);
        $this->assign("id", $id);
        $this->display();
    }
    
    
    
}
?>