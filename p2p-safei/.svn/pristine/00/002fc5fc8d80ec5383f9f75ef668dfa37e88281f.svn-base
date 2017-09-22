<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=640" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="">
<meta name="format-detection" content="telephone=no">
<title>首页</title>
    <link href="./css/css2.css" rel="stylesheet" />
    <script src="./js/jquery-1.9.1.min.js"></script>
<script>
	$(document).ready(function(){

		/*注册页面*/

		$("#register #signup-submit").click(function(){
			var sname;
			sname=$.trim($("#register #user_pwd").val());
			var reg=/^[a-zA-z0-9]{6,}$/;  
			var regs=/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,16}$/;
			if(reg.test(sname)){	
				if(regs.test(sname)){	
				}
				else{
					alert("密码安全等级低，请用数字+字母");
					return false;
				}
			}
			else{
				alert("密码长度在6~16之间，只能包含字符、数字和下划线。");
				return false;
			}
		//$.showIndicator();
			var ajaxurl = '/wap/index.php?ctl=register';
			var query = new Object();
			query.user_name = $.trim($("#register #user_name").val());
			query.user_pwd = $.trim($("#register #user_pwd").val());
			query.user_pwd_confirm = $.trim($("#register #user_pwd").val());
			query.mobile = $.trim($("#register #phone").val());
			query.mobile_code = $.trim($("#register #mobile_code").val());
			query.referer = "liuliangbao2";
			query.post_type = "json";
			$.ajax({
				url:ajaxurl,
				data:query,
				type:"Post",
				dataType:"json",
				success:function(data){
					//$.hideIndicator();
					if(data.user_login_status)
					{	
						alert(data.show_err);
						window.location.href ='/wap/index.php?ctl=login';
					}else{
						alert(data.show_err);
					}
				}
				,error:function(){
					//$.hideIndicator();
					//$.toast("通信失败");
					alert("通信失败");
				}
			});
		});
		
		var is_lock_send_vy = null;
		$("#register #getcode").click(function(){
			if(localStorage.sendtime !="undefined" &&  parseInt(new Date().getTime()/1000) - localStorage.sendtime < 60){
				alert("发送中，请稍后");
				return false;
			}
			if(is_lock_send_vy || $(this).hasClass(".btn_disable")){
				return false;
			}
			var ajaxurl = '/wap/index.php?ctl=send_register_code';
			var query = new Object();
			query.mobile = $.trim($("#register #phone").val());
			query.post_type = "json";
			//$.showIndicator();
			$.ajax({
				url:ajaxurl,
				data:query,
				type:"Post",
				dataType:"json",
				success:function(data){
					//$.hideIndicator();
					if(data.response_code == 1){
						localStorage.sendtime = parseInt(new Date().getTime()/1000);
						left_rg_time = 60;
						//left_time_to_send_regvy($("#register #getcode"),left_rg_time);
					}
					alert(data.show_err);
				},error:function(){
					//$.hideIndicator();
					//$.toast("通信失败");
					alert("通信失败");
				}
			});
		});
		
		
		function left_time_to_send_regvy(obj,left_rg_time){
			left_rg_time2=left_rg_time;
			if(left_rg_time > 0){
				obj.val(left_rg_time+"秒");
				obj.addClass("btn_disable");
				setTimeout(left_time_to_send_regvy($("#register #getcode"),left_rg_time2-1),1000);
			}
			else{
				is_lock_send_vy = false;
				obj.removeClass("btn_disable");
				obj.val("发送");
				left_rg_time = 0;
			}
			
		}
		
		$("#register #user_name").bind("blur",function(){
			var obj = $(this);
			var ajaxurl = "/index.php?ctl=ajax&act=check_field";
			var query = new Object();
			query.field_name = "user_name";
			query.field_data = $.trim(obj.val());
			query.is_pc = 1;
			$.ajax({ 
				url: ajaxurl,
				data:query,
				type: "POST",
				dataType: "json",
				success: function(data){
					if(data.status!=1)
					{
						alert(data.info);
					}
				}
			});	
		}); /*用户名验证*/
	});
	</script>
</head>
<body>
<?php
	$this->_var['back_url'] = wap_url("index","init#index");
	$this->_var['back_page'] = "#init";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#init" : "#".$_REQUEST['epage'];
?>
<div class="layout" id="register">
	<div class="top">

    </div>
    <div class="con">
    	<dd>活动参与流程:</dd>
        <p>1、填写手机号、密码、验证码，点击“立即注册”，完成注册；</p>
        <p>2、登录之后点击“我要投资”；</p>
        <p>3、选择喜欢的项目进行投资。</p>
    </div>
    <ul class="nav">
        <li class="fl on">点我注册</li>
        <a href="index.php?ctl=login"><li class="fr">已有账号</li></a>
    </ul>
    <div class="tab">
        <div class="box" style="display:block;">
    <ul>
				<li>
					<input type="text" placeholder="用户名,3-15个字符"  id="user_name" name="user_name"/>
				</li>
				<li>
					<input type="password" placeholder="请输入密码"  id="user_pwd" name="user_pwd" />
				</li>
				<li>
					<input type="text" placeholder="请输入手机号码"  id="phone" name="phone" />
				</li>
    <li>
					<input type="text" id="mobile_code" name="mobile_code" placeholder="请输入短信验证码" style="width:214px; float:left;" />
     <input class="ui-button_getcode fr" id="getcode" type="button" value="发送">
				</li>
				<li>
					<button type="submit" value="" id="signup-submit">
					注&nbsp;&nbsp;&nbsp;&nbsp;册
					</button>
				</li>
    </ul>
   </div>
        <div class="box">
            <ul>
				<li>
					<input type="text" placeholder="请输入手机号码" />
				</li>
				<li>
					<input type="password" placeholder="请输入密码" />
				</li>
				<li>
					<button type="submit" value="">
					登&nbsp;&nbsp;&nbsp;&nbsp;录
					</button>
				</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>