<?php if ($_REQUEST['is_ajax'] != 1): ?>		
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<!-- 这里是页面内容区 -->
<?php endif; ?>
<!--理财统计-->
<div class="uc_financial_statistics">
	<div class="w_b first_f tc">
		<div class="w_b_f_1 child">
			<p class="name">充值总额</p>
			<p class="num cec534b "><?php echo $this->_var['data']['incharge_count']; ?></p>
			<p class="unit">(元)</p>
		</div>
		<div class="w_b_f_1">
			<p class="name">提现总额</p>
			<p class="num c57b0e8 "><?php echo $this->_var['data']['carry_money']; ?></p>
			<p class="unit">(元)</p>
		</div>
	</div>
	
	<div class="blank055"></div>
	
	<div class="statistical_box">
		<ul class="record"> 
      	<li class="clearfix">
      		<div class="name">借款统计</div>
			<div class="con_50 f_l">
				<span class="name">贷款总额</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['borrow_amount'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">借款笔数</span>
				<span class="con"><?php echo $this->_var['data']['user_statistics']['success_deal_count']; ?>笔</span>
			</div>
			<div class="con_50 f_l">
				<span class="name">已还本息</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['repay_amount'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">待还本息</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['need_repay_amount'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">已付管理费</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['repay_manage_amount'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">待付管理费</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['need_manage_amount'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">逾期费用</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['yuqi_impose'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
		</li>
		<li class="clearfix">
      		<div class="name">投资统计</div>
			<div class="con_50 f_l">
				<span class="name">投资总额</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['load_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">投资笔数</span>
				<span class="con"><?php echo $this->_var['data']['user_statistics']['load_count']; ?>笔</span>
			</div>
			<div class="con_50 f_l">
				<span class="name">已挣利息</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['load_earnings'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">待收利息</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['load_wait_earnings'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">已回收本息</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['load_repay_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">待回收本息</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['load_wait_repay_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">已付管理费</span>
				<span class="con"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['data']['user_statistics']['load_manage_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></span>
			</div>
		</li>
		</ul>
	</div>
	
</div>
<?php if ($_REQUEST['is_ajax'] != 1): ?>		
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>