<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<?php
	$this->_var['back_url'] = wap_url("index","init#index");
	$this->_var['back_page'] = "#init";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#init" : "#".$_REQUEST['epage'];
?>

<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>

<div class="content register_login_content">
<?php endif; ?>
<header class="bar bar-nav" style="background-color: #fff;">
	
	<a class="button  button-link button-nav  pull-right open-panel  nobar" data-panel='#panel-left-box' style="color:#1455A4;font-weight: bold;">
		 <i class="icon iconfont">&#xe650;</i>
	</a>
	
	<a class="button button-link button-nav pull-left" onclick="RouterBack('<?php echo $this->_var['back_url']; ?>','<?php echo $this->_var['back_page']; ?>','<?php echo $this->_var['back_epage']; ?>');" data-transition='slide-out'  style="color:#1455A4;font-weight: bold;">
	  <span class="icon icon-left"></span>
	</a>
	
	<h1 class="title pull-left"  style="color:#1455A4;font-weight: bold;">用户登录</h1>
</header>

	<img src="./images/logo.png" style="width: 6em;height: 6em;margin:4em auto 2em auto;display: block;clear: both;">	


<!-- 这里是页面内容区 -->
<div class="register_login">
	<form>
		<div class="bg_fff register_login_pd">
			<div class="bb1 bor height w_b">
				 <img src="./images/phone.png" style="padding-top: 1em;">
				 <input class="r_l_input w_b_f_1" id="email" type="text" placeholder="请输入用户名/邮箱/手机"/>
			</div>
			<div class="bb1 bor height w_b">
				 <img src="./images/locks.png" style="padding-top: 1em;">
				 <input class="r_l_input w_b_f_1" type="password" id="pwd" placeholder="请输入您的密码" />
			</div>
		</div>
		<div class="register_login_pd">
			<input class="ui-button_login r_l_but" type="button" value="登&nbsp;录" style="background-color: #3990FC;" />
			<div class="clearfix" style="text-align: center;">
				<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|save_reset_pwd|"."".""); 
?>','#save_reset_pwd',2)">忘记密码？</a>
				&nbsp;|&nbsp;
				<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|register|"."".""); 
?>','#register',2)"">快速注册</a>
			</div>
		</div>	
	</form>
</div>
<br/><br/><br/>
<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>






