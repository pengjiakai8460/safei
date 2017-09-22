<?php if (!defined('THINK_PATH')) exit();?>

<div class="main">
<div class="main_title"><?php echo (get_user_name($credit["user_id"])); ?></div>
<div class="blank5"></div>
<form name="edit" action="__APP__" method="post" enctype="multipart/form-data">
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title"><?php echo ($credit_type["type_name"]); ?>:</td>
		<td class="item_input" id="passedBox">
			<select name="passed">
				<option value="0" <?php if($credit['passed'] == 0): ?>selected="selected"<?php endif; ?>>未审核</option>
				<option value="1" <?php if($credit['passed'] == 1): ?>selected="selected"<?php endif; ?>>审核通过</option>
				<option value="2" <?php if($credit['passed'] == 2): ?>selected="selected"<?php endif; ?>>审核失败</option>
			</select>
		</td>
	</tr>
	
	<tr>
		<td class="item_title">原因:</td>
		<td class="item_input"><textarea type="text" id="msgarea" disabled="disabled" class="textbox" name="msg" style="width:400px;height:100px" ><?php echo ($credit["msg"]); ?></textarea>
		</td>
	</tr>
	<tr>
		<td class="item_title">&nbsp;</td>
		<td class="item_input">
			<!--隐藏元素-->
			<input type="hidden" name="id" value="<?php echo ($credit["id"]); ?>" />
			<input type="hidden" name="<?php echo conf("VAR_MODULE");?>" value="Credit" />
			<input type="hidden" name="<?php echo conf("VAR_ACTION");?>" value="modify_passed" />
			<!--隐藏元素-->
			<input type="submit" class="button" value="<?php echo L("OK");?>" />
			<input type="reset" class="button" value="<?php echo L("RESET");?>" />
		</td>
	</tr>
	
	<tr>
		<td class="item_title">认证资料:</td>
		<td class="item_input">
			<?php if($credit['type'] == 'credit_identificationscanning'): ?>姓名:<?php echo ($user_info["real_name"]); ?><br>
			身份证号码:<?php echo ($user_info["idno"]); ?>&nbsp;<a href="javascript:void(0)" onclick="checkidcrad('<?php echo ($user_info["idno"]); ?>','<?php echo ($user_info["real_name"]); ?>')">查证</a><br>
			籍贯:<?php echo ($user_info["n_province"]); ?>&nbsp;<?php echo ($user_info["n_city"]); ?><br>
			户口所在地:<?php echo ($user_info["province"]); ?>&nbsp;<?php echo ($user_info["city"]); ?><br>
			出生日期：<?php echo ($user_info["byear"]); ?>-<?php echo ($user_info["bmonth"]); ?>-<?php echo ($user_info["bday"]); ?><br>
			性别:<?php if($user_info['sex'] == 0): ?>女<?php else: ?>男<?php endif; ?><br><?php endif; ?>
			<?php if($credit['type'] == 'credit_car'): ?>汽车品牌:<?php echo ($user_info["car_brand"]); ?><br/>
			购车年份:<?php echo ($user_info["car_year"]); ?><br/>
			车牌号码:<?php echo ($user_info["car_number"]); ?><br/><?php endif; ?>
			<?php if($credit['type'] == 'credit_graducation'): ?>最高学历:<?php echo ($user_info["graduation"]); ?><br/>
			入学年份:<?php echo ($user_info["graduatedyear"]); ?><br/>
			毕业院校:<?php echo ($user_info["university"]); ?><br/>
			12位在线验证码:<?php echo ($user_info["edu_validcode"]); ?><br/>
			<div>
				点击 <a href="http://www.chsi.com.cn/xlcx/" target="_blank">网上学历查询</a>。
            </div><?php endif; ?>
			<?php if($credit['type'] == 'credit_videoauth'): ?><?php if($user_info['has_send_video'] == 1): ?><span class="tip_span">资料已上传到邮箱:<?php echo C('REPLY_ADDRESS');?></span><?php endif; ?><?php endif; ?>
			<?php if($credit['type'] == 'credit_mobilereceipt'): ?>手机号码:<?php echo ($user_info["mobile"]); ?><br><?php endif; ?>
			<?php if($credit['type'] == 'credit_residence'): ?>居住地址:<?php echo ($user_info["address"]); ?><br><?php endif; ?>
			<?php if($credit['type'] == 'credit_contact'): ?>工作资料:<a href="javascript:user_work(<?php echo ($user_info["id"]); ?>);">工作资料</a><br><?php endif; ?>
			<?php if(is_array($credit["file_list"])): foreach($credit["file_list"] as $key=>$item): ?><a href="<?php echo ($item); ?>" target="_blank"><img src="<?php echo ($item); ?>" border="0" width="370"></a>
				<div class="blank5"></div><?php endforeach; endif; ?>
		</td>
	</tr>
	
	
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
</table>	 
</form>
</div>
<script type="text/javascript">
	jQuery(function(){
		$("#passedBox select").change(function(){
			if($(this).val()=="2"){
				$("#msgarea").attr("disabled",false);
			}
			else{
				$("#msgarea").attr("disabled",true);
			}
		});
	});
</script>