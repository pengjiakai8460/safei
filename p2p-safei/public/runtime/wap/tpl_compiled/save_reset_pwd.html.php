<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_setting#index");
	$this->_var['back_page'] = "#uc_setting";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_setting" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content register_login_content">
<?php endif; ?>	
<!-- 这里是页面内容区 -->
<!--修改密码-->
<div class="register_login" id="mb_re_pwd">	
		<div class="bg_fff register_login_pd">
			<div class="bor bb1 height w_b">
				 <div class="name">手 机 号</div>
				 <input class="r_l_input w_b_f_1" id="mobile" name="mobile" type="text" placeholder="请输入手机号">
			</div>
			<div class="bor bb1 height w_b">
				 <div class="name">验 证 码</div>
				 <input class="r_l_input w_b_f_1" id="mobile_code" name="mobile_code" type="text" placeholder="请输入验证码">
				 <div class="ui-button_getcode_parent" style="  width:6rem;"><input class="ui-button_getcode " id="getcode" type="button" value="获取验证码"></div>
			</div>
			<div class="bor bb1 height w_b">
				 <div class="name">新 密 码</div>
				 <input class="r_l_input w_b_f_1" id="user_pwd" name="user_pwd" type="password" placeholder="请输入新密码">
			</div>
			<div class="bor  height w_b">
				 <div class="name">确认密码</div>
				 <input class="r_l_input w_b_f_1" id="user_pwd_confirm" name="user_pwd_confirm" type="password" placeholder="请再次输入密码">
			</div>
		</div>
		<div class="register_login_pd">
			<input class="ui-button_login r_l_but" type="submit" name="commit" id="signup-submit" value="提交">
		</div>		
</div>
<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>








