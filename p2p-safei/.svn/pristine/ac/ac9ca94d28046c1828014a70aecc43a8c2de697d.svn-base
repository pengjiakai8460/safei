<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","init#index");
	$this->_var['back_page'] = "#init";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#init" : "#".$_REQUEST['epage'];
?>

<div class="content">
<!--注册页面-->
	<?php endif; ?>

<header class="bar bar-nav" style="background-color: #fff;">
	
	<a class="button  button-link button-nav  pull-right open-panel  nobar" data-panel='#panel-left-box' style="color:#1455A4;font-weight: bold;">
		 <i class="icon iconfont">&#xe650;</i>
	</a>
	
	<a class="button button-link button-nav pull-left" onclick="RouterBack('<?php echo $this->_var['back_url']; ?>','<?php echo $this->_var['back_page']; ?>','<?php echo $this->_var['back_epage']; ?>');" data-transition='slide-out'  style="color:#1455A4;font-weight: bold;">
	  <span class="icon icon-left"></span>
	</a>
	
	<h1 class="title pull-left"  style="color:#1455A4;font-weight: bold;">用户注册</h1>
</header> 
<link rel="stylesheet" type="text/css" href="./css/my.css">
<script type="text/javascript">
	$(function(){
		$("#mb_register > .r-div").each(function(){
			var obj = $(this);
			obj.find("input").focus(function(){
				obj.find(".clear-input").show();
				obj.css({"border-color":"#1455A4"});
				obj.find(".clear-input").click(function(){
					obj.find("input").val("");
				})
			});
			obj.blur(function(){
				obj.find(".clear-input").hide();
				obj.css({"border-color":"#C9C9C9"});
			});
			obj.find("input").blur(function(){
				
				obj.css({"border-color":"#C9C9C9"});
			});
			
		})
	})
</script>
<div class="register_login" id="mb_register" style="margin-top: 4em;">	
	<div class="r-div">
		<img src="./images/phone.png" >
		<input type="text" id="user_name" name="user_name" placeholder="请输入您的用户名">
		<div class="clear-input">
			x
		</div>
	</div>
	<div class="r-div">
		<img src="./images/locks.png" >
		<input id="user_pwd" name="user_pwd" type="password" placeholder="请输入您的密码">
		<div class="clear-input">
			x
		</div>
	</div>
	<div class="r-div">
		<img src="./images/pass.png" >
		<input id="user_pwd_confirm" name="user_pwd_confirm" type="password" placeholder="请再次输入您的密码">
		<div class="clear-input">
			x
		</div>
	</div>

	<div class="r-div">
		<img src="./images/phone.png" >
		<input id="phone" name="phone" type="text" placeholder="请输入您的手机号码">
		<div class="clear-input">
			x
		</div>
	</div>

	<div class="r-div">
		<img src="./images/codes.png" >
		<input id="mobile_code" name="mobile_code" type="text" placeholder="请输入验证码">
		<div class="get-code" id="getcode">
			验证码
		</div>
	</div>

	<div class="r-div">
		<img src="./images/users.png" >
		<input id="referer" name="referer" type="text"  value="<?php echo $this->_var['data']['wap_referer']; ?>" placeholder="推荐人手机号/用户名">
		<div class="clear-input">
			x
		</div>
	</div>

	<div class="r-div" >
		<button type="submit" name="commit" id="signup-submit" style="background-color: #3990FC;color: #fff;width: 100%;">注&nbsp;册</button>
	</div>
		<!-- <div class="bg_fff register_login_pd">
			
			<div class="bb1 bor height w_b r-div">
				 <div class="name">用 户 名</div>
				 <input class="r_l_input w_b_f_1" id="user_name" name="user_name" type="text" placeholder="请输入您的用户名">
			</div>
			<div class="bb1 bor height w_b r-div">
				 <div class="name">输入密码</div>
				 <input class="r_l_input w_b_f_1" id="user_pwd" name="user_pwd" type="password" placeholder="请输入您的密码">
			</div>
			<div class="bb1 bor height w_b r-div">
				 <div class="name">确认密码</div>
				 <input class="r_l_input w_b_f_1" id="user_pwd_confirm" name="user_pwd_confirm" type="password" placeholder="请再次输入您的密码">
			</div>
			<div class="bb1 bor height w_b r-div">
				 <div class="name">手 机 号</div>
				 <input class="r_l_input w_b_f_1" id="phone" name="phone" type="text" placeholder="请输入您的手机号码">
			</div>
			<div class="bb1 bor height w_b r-div">
				 <div class="name">验 证 码</div>
				 <input class="r_l_input w_b_f_1" id="mobile_code" name="mobile_code" type="text" placeholder="请输入验证码">
				 <div class="ui-button_getcode_parent" style="  width:6rem;"><input class="ui-button_getcode " id="getcode" type="button" value="获取验证码"></div>
			</div>
			<div class=" bor  r-div height w_b <?php if ($this->_var['data']['wap_referer']): ?>hide<?php endif; ?>">
				 <div class="name">推 荐 人</div>
				  <input class="r_l_input w_b_f_1" id="referer" name="referer" type="text"  value="<?php echo $this->_var['data']['wap_referer']; ?>" placeholder="请输入推荐人手机号/用户名">
			</div>
		</div>
		<div class="register_login_pd">
			<input class="ui-button_login r_l_but" type="submit" name="commit" id="signup-submit" value="注册">
		</div> -->
</div>

<p class="reg-logins">
	已有账号？<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|login|"."epage=".$this->_var['data']['act']."".""); 
?>','#login'<?php if ($this->_var['is_weixin']): ?>,1<?php else: ?>,2<?php endif; ?>);" style="color:#3990FC; ">登录</a>
</p>
<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>








