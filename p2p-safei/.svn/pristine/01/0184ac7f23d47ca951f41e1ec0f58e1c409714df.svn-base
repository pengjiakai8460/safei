<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='uc_setting'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
	<?php endif; ?>
<!-- 这里是页面内容区 -->

<div class="uc_center">

	<div class="uc_c_middle">
		<ul class="uc_c_middle_content_list">
			<li>
				<a href="#" class="href_first w_b" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|save_reset_pwd|"."".""); 
?>','#save_reset_pwd',2);">				
					<i class="icon iconfont icon_left">&#xe627;</i>
					<p class="w_b_f_1">修改密码</p>
					<i class="icon iconfont icon_rigth">&#xe61a;</i>
				</a>
			</li>
			<li>
				<a href="#" class="href_first w_b" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|reset_pay_pwd|"."".""); 
?>','#reset_pay_pwd',2);">
					<i class="icon iconfont icon_left">&#xe629;</i>
					<p class="w_b_f_1">设置支付密码</p>
					<i class="icon iconfont icon_rigth">&#xe61a;</i>
				</a>	
			</li>
			<?php if ($this->_var['data']['credit_status'] == 0 || $this->_var['data']['credit_status'] == 3): ?>
			<li>
				<a href="#" class="href_first w_b" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_credit|"."".""); 
?>','#uc_credit',2);">
					<i class="icon iconfont icon_left">&#xe634;</i>
					<p class="w_b_f_1">身份认证</p>
					<i class="icon iconfont icon_rigth">&#xe61a;</i>
				</a>
				<a href="#" class="href_second" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_credit|"."".""); 
?>','#uc_credit',2);"><?php echo $this->_var['data']['credit_show']; ?></a>
			</li>
				<?php else: ?>
			<li>
				<span  class="href_first w_b">
					<i class="icon iconfont icon_left">&#xe634;</i>
					<p class="w_b_f_1">身份认证</p>
					<i class="icon iconfont icon_rigth">&#xe61a;</i>
				</span>
				<span  class="href_second pass"><?php echo $this->_var['data']['credit_show']; ?></span>
			</li>
			<?php endif; ?>
			<li>
				<a href="#" class="href_first w_b" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|goods_address|"."".""); 
?>','#goods_address',2);">
					<i class="icon iconfont icon_left">&#xe633;</i>
					<p class="w_b_f_1">设置地址</p>
					<i class="icon iconfont icon_rigth">&#xe61a;</i>
				</a>
			</li>
		</ul>
		<a href="#" data-url="<?php
echo parse_wap_url_tag("u:index|login_out|"."".""); 
?>" onclick="loginout();" id="login-out-btn"  class="out_login">退出当前账户</a>
</div>
</div>
<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>



