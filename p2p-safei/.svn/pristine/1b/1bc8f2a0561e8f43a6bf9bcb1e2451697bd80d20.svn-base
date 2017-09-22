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
	<?php endif; ?>
<!-- 这里是页面内容区 -->
<!--账户明细-->
<div class="uc_financial_statistics">
<div class="statistical_box">
		<ul class="record"> 
      	<li class="clearfix">
      		<div class="name">平台账户</div>
			<div class="con_50 f_l">
				<span class="name">账户金额</span>
				<span class="con"><?php echo $this->_var['data']['total_money_format']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">可用金额</span>
				<span class="con"><?php echo $this->_var['data']['money_format']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">冻结金额</span>
				<span class="con"><?php echo $this->_var['data']['lock_money_format']; ?></span>
			</div>
		</li>
		<?php if ($this->_var['data']['open_ips'] > 0): ?>
		<li class="clearfix">
      		<div class="name">托管账户<?php if ($this->_var['data']['ips_acct_no'] == ''): ?><span class="ea544a">未绑定！请登录电脑版绑定托管账户。</span><?php endif; ?></div>
			<?php if ($this->_var['data']['ips_acct_no'] != ''): ?>
			<div class="con_50 f_l">
				<span class="name">未结算金额</span>
				<span class="con"><?php echo $this->_var['data']['ips_needstl_format']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">可用金额</span>
				<span class="con"><?php echo $this->_var['data']['ips_balance_format']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">冻结金额</span>
				<span class="con"><?php echo $this->_var['data']['ips_lock_format']; ?></span>
			</div>
			<?php endif; ?>
		</li>
		<?php endif; ?>
		<li class="clearfix">
      		<div class="name">账户信息</div>
			<div class="con_50 f_l">
				<span class="name">我的等级</span>
				<span class="con"><?php echo $this->_var['data']['vip_grade']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">我的积分</span>
				<span class="con"><?php echo $this->_var['data']['score']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">信用额度</span>
				<span class="con"><?php echo $this->_var['data']['point']; ?></span>
			</div>
			<div class="con_50 f_l">
				<span class="name">可用额度</span>
				<span class="con"><?php echo $this->_var['data']['quota']; ?></span>
			</div>
		</li>
		</ul>
	</div>
	
</div>
<?php if ($_REQUEST['is_ajax'] != 1): ?>	
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>