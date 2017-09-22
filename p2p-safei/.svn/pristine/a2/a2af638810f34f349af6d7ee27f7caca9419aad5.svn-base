<?php if (!defined('THINK_PATH')) exit();?>

<div class="main">
<div class="main_title"><?php echo (get_user_name($vo["user_id"])); ?>的提现申请</div>
<div class="blank5"></div>
<form name="edit" action="__APP__" method="post">
<table class="form" cellpadding=0 cellspacing=0>
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title">开户行</td>
		<td class="item_input">
			<?php echo ($vo["bank_name"]); ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">开户行所在地</td>
		<td class="item_input">
			<?php echo ($vo["region_lv1_name"]); ?> &nbsp;<?php echo ($vo["region_lv2_name"]); ?> &nbsp;<?php echo ($vo["region_lv3_name"]); ?> &nbsp;<?php echo ($vo["region_lv4_name"]); ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">开户行网点</td>
		<td class="item_input">
			<?php echo ($vo["bankzone"]); ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">银行卡卡号</td>
		<td class="item_input">
			<?php echo ($vo["bankcard"]); ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">开户名</td>
		<td class="item_input">
			<?php echo ($vo["real_name"]); ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">处理结果</td>
		<td class="item_input" id="CarryStatusBox">
			<select name="status" <?php if($vo['status'] == 2 || $vo['status'] == 1 || $vo['status'] == 4): ?>disabled="disabled"<?php endif; ?>>
				<?php if($vo['status'] == 0): ?><option value="0" selected="selected">待审核</option><?php endif; ?>
				<?php if($vo['status'] == 0 || $vo['status'] == 3): ?><option value="3" <?php if($vo['status'] == 3): ?>selected="selected"<?php endif; ?>>待付款</option><?php endif; ?>
				<?php if($vo['status'] == 3 || $vo['status'] == 1): ?><option value="1" <?php if($vo['status'] == 1): ?>selected="selected"<?php endif; ?>>已付款</option><?php endif; ?>
				<?php if($vo['status'] == 0 || $vo['status'] == 2 || $vo['status'] == 3 ): ?><option value="2" <?php if($vo['status'] == 2): ?>selected="selected"<?php endif; ?>>未通过</option><?php endif; ?>
			</select>
		</td>
	</tr>
	
	<tr id="CarryPZBox"  <?php if($vo['status'] != 1): ?>style="display:none"<?php endif; ?>>
		<td class="item_title">打款凭证</td>
		<td class="item_input" >
			<?php if($vo['pingzheng'] != ''): ?><a href="<?php echo ($vo["pingzheng"]); ?>" target="_blank"><img src="<?php echo ($vo["pingzheng"]); ?>" height="50" /></a>
			<?php else: ?>
				<span>
        <div style='float:left; height:35px; padding-top:1px;'>
			<input type='hidden' value='' name='pingzheng' id='keimg_h_pingzheng_i' />
			<div class='buttonActive' style='margin-right:5px;'>
				<div class='buttonContent'>
					<button type='button' class='keimg ke-icon-upload_image' rel='pingzheng'>选择图片</button>
				</div>
			</div>
		</div>
		 <a href='./admin/Tpl/default/Common/images/no_pic.gif' target='_blank' id='keimg_a_pingzheng' ><img src='./admin/Tpl/default/Common/images/no_pic.gif' id='keimg_m_pingzheng' width=35 height=35 style='float:left; border:#ccc solid 1px; margin-left:5px;' /></a>
		 <div style='float:left; height:35px; padding-top:1px;'>
			 <div class='buttonActive'>
				<div class='buttonContent'>
					<img src='/admin/Tpl/default/Common/images/del.gif' style='display:none; margin-left:10px; float:left; border:#ccc solid 1px; width:35px; height:35px; cursor:pointer;' class='keimg_d' rel='pingzheng' title='删除'>
				</div>
			</div>
		</div>
		</span><?php endif; ?>
		</td>
	</tr>
	
	<tr>
		<td class="item_title">原因:</td>
		<td class="item_input"><textarea id="msgarea" <?php if($vo['status'] != 2 || $vo['msg'] != ''): ?>disabled="true"<?php endif; ?> class="textbox" name="msg" style="width:400px;height:80px" ><?php echo ($vo["msg"]); ?></textarea>
		</td>
	</tr>
	
	<tr>
		<td class="item_title">操作备注:</td>
		<td class="item_input"><textarea class="textbox" name="desc" <?php if($vo['status'] == 1 || $vo['status'] == 2 ): ?>disabled="true"<?php endif; ?> style="width:400px;height:80px" ><?php echo ($vo["desc"]); ?></textarea>
		</td>
	</tr>
	<?php if($vo['status'] == 0 || $vo['status'] == 3): ?><tr>
		<td class="item_title">&nbsp;</td>
		<td class="item_input">
			<!--隐藏元素-->
			<input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>" />
			<input type="hidden" name="<?php echo conf("VAR_MODULE");?>" value="UserCarry" />
			<input type="hidden" name="<?php echo conf("VAR_ACTION");?>" value="update" />
			<!--隐藏元素-->
			<input type="submit" class="button" value="<?php echo L("OK");?>" />
			<input type="reset" class="button" value="<?php echo L("RESET");?>" />
		</td>
	</tr><?php endif; ?>
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
</table>	 
</form>
</div>
<script type="text/javascript">
	jQuery(function(){
		$("#CarryStatusBox select").change(function(){
			if($(this).val()=="2"){
				$("#msgarea").attr("disabled",false);
			}
			else{
				$("#msgarea").attr("disabled",true);
			}
			$("#CarryPZBox").hide();
			if($(this).val()=="1"){
				$("#CarryPZBox").show();
				bindKdupload();
			}
		});
	});
</script>