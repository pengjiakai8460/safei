<?php if (!defined('THINK_PATH')) exit();?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/style.css" />
<script type="text/javascript" src="__TMPL__Common/js/check_dog.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/IA300ClientJavascript.js"></script>
<script type="text/javascript">
 	var VAR_MODULE = "<?php echo conf("VAR_MODULE");?>";
	var VAR_ACTION = "<?php echo conf("VAR_ACTION");?>";
	var MODULE_NAME	=	'<?php echo MODULE_NAME; ?>';
	var ACTION_NAME	=	'<?php echo ACTION_NAME; ?>';
	var ROOT = '__APP__';
	var ROOT_PATH = '<?php echo APP_ROOT; ?>';
	var CURRENT_URL = '<?php echo trim($_SERVER['REQUEST_URI']);?>';
	var INPUT_KEY_PLEASE = "<?php echo L("INPUT_KEY_PLEASE");?>";
	var TMPL = '__TMPL__';
	var APP_ROOT = '<?php echo APP_ROOT; ?>';
	var FILE_UPLOAD_URL = ROOT   + "?m=file&a=do_upload";
	var EMOT_URL = '<?php echo APP_ROOT; ?>/public/emoticons/';
	var MAX_FILE_SIZE = "<?php echo (app_conf("MAX_IMAGE_SIZE")/1000000)."MB"; ?>";
	var LOGINOUT_URL = '<?php echo u("Public/do_loginout");?>';
	var WEB_SESSION_ID = '<?php echo es_session::id(); ?>';
	CHECK_DOG_HASH = '<?php $adm_session = es_session::get(md5(conf("AUTH_KEY"))); echo $adm_session["adm_dog_key"]; ?>';
	var IS_WATER_MARK = <?php echo app_conf("IS_WATER_MARK");?>;
	function check_dog_sender_fun()
	{
		window.clearInterval(check_dog_sender);
		check_dog2();
	}
	var check_dog_sender = window.setInterval("check_dog_sender_fun()",5000);
</script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.timer.js"></script>
<script type="text/javascript" src="__ROOT__/public/runtime/admin/lang.js"></script>
<script type='text/javascript'  src='__ROOT__/admin/public/kindeditor/kindeditor.js'></script>
<script type='text/javascript'  src='__ROOT__/admin/public/kindeditor/lang/zh_CN.js'></script>
<script type="text/javascript" src="__TMPL__Common/js/script.js"></script>
</head>
<body onLoad="javascript:DogPageLoad();">
<div id="info"></div>

<script type="text/javascript" src="__TMPL__Common/js/jquery.bgiframe.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/jquery.weebox.js"></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/weebox.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>

<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript">
	var is_do_lock = false;
	jQuery(function(){
		$("input[name='deal_status']").click(function(){
			var rel= parseInt($(this).val());
			switch(rel){
				case 0:
					$("#success_loans_box").show();
					$("#success_loans_pic_box").show();
					$("#bad_loans_box").hide();
					break;
				case 1:
					$("#success_loans_box").hide();
					$("#success_loans_pic_box").hide();
					$("#bad_loans_box").show();
					break;
			}
		});
	});
	
	function nothingdo(){
		$("input[name='deal_status']").attr("checked",false);
		$("#success_loans_box").hide();
		$("#bad_loans_box").hide();
	}
	/**
	 * 满标放款
	 */
	function do_loans(id){
		if(is_do_lock){
			alert("请等待处理！");
			return false;
		}
		is_do_lock = true;
		var query=new Object();
			query.repay_start_time = $("#repay_start_time").val();
			query.id = id;
			query.get_manage = $("#get_manage:checked").val();
			query.loans_pic = $("input[name=loans_pic]").val();
		$.ajax({
			url:ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=do_loans", 
			data:query,
			type:"post",
			dataType:"json",
			success:function(result){
				is_do_lock = true;
				if(result.status ==1)
				{
					alert(result.info);
					window.location.reload();
				}
				else if(result.status ==2){
					window.location.href = result.jump;
				}
				else if(result.status ==3){
					if(confirm(result.info)){
						window.location.href = result.jump;
					}
				}
				else{
					alert(result.info);
				}
			}
			,
			error:function(){
				alert("执行出错");
				is_do_lock = false;
			}
		});
	}
	
	/**
	 * 流标返还
	 */
	function do_received(id){
		if(is_do_lock){
			alert("请等待处理！");
		}
		is_do_lock = true;
		var query=new Object();
			query.bad_msg = $("#bad_msg").val();
			query.id = id;
			
		$.ajax({
			url:ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=do_received", 
			data:query,
			type:"post",
			dataType:"json",
			success:function(result){
				is_do_lock
				if(result.status ==1)
				{
					alert(result.info);
					window.location.reload();
				}
				else if(result.status ==2){
					window.location.href = result.jump;
				}
				else if(result.status ==3){
					if(confirm(result.info)){
						window.location.href = result.jump;
					}
				}
				else{
					alert(result.info);
				}
			},
			error:function(){
				alert("执行出错");
				is_do_lock = false;
			}
		});
	}
	
	/**
	*到导出投标列表
	**/
	function do_export_load(id){
		window.location.href = ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=do_export_load"+"&id="+id;
	}
</script>
<div class="main">

<table class="form conf_tab" cellpadding=0 cellspacing=0 rel="3">
	<tr>
		<td colspan=2 class="topTd"></td>
	</tr>
	<tr>
		<td class="item_title" style="width:200px;"><?php echo L("DEAL_NAME");?>:</td>
		<td class="item_input">
		<span title="<?php echo ($deal_info["name"]); ?>"><?php echo (msubstr($deal_info["name"],0,20)); ?></span>
		</td>
	</tr>
	<?php if($deal_info["start_time"] > 0): ?><tr>
		<td class="item_title">开始时间:</td>
		<td class="item_input">
			<?php echo (to_date($deal_info["start_time"])); ?>
		</td>
	</tr><?php endif; ?>
	
	<tr>
		<td class="item_title">总借款:</td>
		<td class="item_input">
			<?php echo (format_price($deal_info["borrow_amount"])); ?>
		</td>
	</tr>
	<tr>
		<td class="item_title">筹得款项:</td>
		<td class="item_input">
			<?php echo (format_price($deal_info["load_money"])); ?>
		</td>
	</tr>
	
	<tr>
		<td class="item_title">还需款多少:</td>
		<td class="item_input">
			<?php echo format_price($deal_info['borrow_amount']-$deal_info['load_money']);?>
		</td>
	</tr>
<!--  补还项目删除
	<tr>
		<td class="item_title">多少人投标:</td>
		<td class="item_input">
			<?php echo ($deal_info["buy_count"]); ?>
			<?php if($deal_info['deal_status'] == 4 || $deal_info['deal_status'] == 5): ?><?php if(round($true_repay_money,2) < $deal_info['repay_money'] &&  $deal_info['repay_money'] > 0): ?>&nbsp;&nbsp;<a href="__APP__?m=Deal&a=after_repay&id=<?php echo ($deal_info["id"]); ?>"><b>补还</b></a><?php endif; ?><?php endif; ?>
		</td>
	</tr>
	-->
	<tr>
		<td class="item_title">借款期限类型:</td>
		<td class="item_input">
			<?php if($deal_info['repay_time_type'] == 1): ?>按月还款
			<?php elseif($deal_info['repay_time_type'] == 0): ?>
				按天还款<?php endif; ?>
		</td>
	</tr>
	<?php if($deal_info['ips_bill_no'] != ''): ?><tr>
		<td colspan=2 style="color:red;font-size:16px;text-align:center">
			重要提示:第三方托管满标或流标需要回调时间，所以同一个标不要连续操作！
		</td>
	</tr><?php endif; ?>
	<tr>
		<td class="item_title">操作:</td>
		<td class="item_input">
			<?php if(($deal_info['deal_status'] >= 4 || $deal_info['deal_status'] == 2) && $deal_info['is_has_loans'] == 0): ?><label><input type="radio" name="deal_status" value="0" />满标放款</lable><?php endif; ?>	
			
			<?php if(($deal_info['deal_status'] == 3 || $deal_info['deal_status'] == 2  || ((($deal_info['start_time'] + $deal_info['enddate'] *24*3600 - 1) < TIME_UTC) && $deal_info['deal_status'] == 1) || $deal_info['deal_status'] == 1 || $deal_info['deal_status'] == 0) && $deal_info['is_has_received'] == 0 ): ?><label><input type="radio" name="deal_status" value="1" />流标<?php if($deal_info['buy_count'] > 0): ?>返还<?php endif; ?></lable><?php endif; ?>
			<?php if($loan_list): ?><input type="button" class="button" value="导出投标列表" onclick="do_export_load(<?php echo ($deal_info["id"]); ?>);"><?php endif; ?>
		</td>
	</tr>
	<tr id="success_loans_pic_box" style="display:none;">
		<td class="item_title">上传凭证：</td>
		<td class="item_input">
        		<span>
        <div style='float:left; height:35px; padding-top:1px;'>
			<input type='hidden' value='' name='loans_pic' id='keimg_h_loans_pic_i' />
			<div class='buttonActive' style='margin-right:5px;'>
				<div class='buttonContent'>
					<button type='button' class='keimg ke-icon-upload_image' rel='loans_pic'>选择图片</button>
				</div>
			</div>
		</div>
		 <a href='./admin/Tpl/default/Common/images/no_pic.gif' target='_blank' id='keimg_a_loans_pic' ><img src='./admin/Tpl/default/Common/images/no_pic.gif' id='keimg_m_loans_pic' width=35 height=35 style='float:left; border:#ccc solid 1px; margin-left:5px;' /></a>
		 <div style='float:left; height:35px; padding-top:1px;'>
			 <div class='buttonActive'>
				<div class='buttonContent'>
					<img src='/admin/Tpl/default/Common/images/del.gif' style='display:none; margin-left:10px; float:left; border:#ccc solid 1px; width:35px; height:35px; cursor:pointer;' class='keimg_d' rel='loans_pic' title='删除'>
				</div>
			</div>
		</div>
		</span>
	</tr>
	<tr id="success_loans_box" style="display:none;">
		<td class="item_title">确认时间：</td>
		<td class="item_input">
        		<input type="text" class="textbox require" name="repay_start_time" id="repay_start_time" value="" onfocus="this.blur(); return showCalendar('repay_start_time', '%Y-%m-%d', false, false, 'btn_repay_start_time');" readonly="readonly" style="width:100px" />
				<input type="button" class="button" id="btn_repay_start_time" value="<?php echo L("SELECT_TIME");?>" onclick="return showCalendar('repay_start_time', '%Y-%m-%d', false, false, 'btn_repay_start_time');" />
				<input type="button" class="button" value="确定" onclick="do_loans(<?php echo ($deal_info["id"]); ?>);">
				<input type="button" class="button" value="取消" onclick="nothingdo();">
				<div class="blank5"></div>
				<?php if($deal_info["ips_bill_no"] == ''): ?><label>直接收取管理费 <input type="checkbox" value="1" name="get_manage" id="get_manage" /></label><?php endif; ?>
				
				<br>
				<span class="tip_span">
					还款日：<br>
					天标按确认之日起算，如 设置为 2014.1.1，借款期限为2天，还款日为：2014.1.3<br>
					其他标从确认时间开始的起算，如 设置为 2014.1.1 即第一次还款日为：2014.2.1，确认时间不要设置为29,30,31号
				</span>
	</tr>

	<?php if($deal_info["repay_start_time"] > 0 && $deal_info["deal_status"] > 3): ?><tr>
		<td class="item_title">还款开始时间:</td>
		<td class="item_input">
			<?php echo (to_date($deal_info["repay_start_time"])); ?>
		</td>
	</tr><?php endif; ?>
	
	<?php if($deal_info["bad_time"] > 0 && $deal_info["deal_status"] == 3): ?><tr>
		<td class="item_title">流标时间:</td>
		<td class="item_input">
			<?php echo (to_date($deal_info["bad_time"])); ?>
		</td>
	</tr><?php endif; ?>
	
	<tr id="bad_loans_box" style="display:none">
		<td class="item_title">&nbsp;</td>
		<td class="item_input">
			<?php echo L("DEAL_STATUS_3");?>原因：
			<div class="blank1"></div>
			<textarea type="text" class="textarea" name="bad_msg" id="bad_msg" value="" rows="3" cols="50" style="height:auto"></textarea>
			<div class="blank1"></div>
			<input type="button" class="button" value="确定返款" onclick="do_received(<?php echo ($deal_info["id"]); ?>);">
			<input type="button" class="button" value="取消" onclick="nothingdo();">
		</td>
	</tr>
	
	
	<?php if($loan_list): ?><tr>
		<td class="item_title">投标列表:</td>
		<td class="item_input">
			<table id="dataTable" class="dataTable" cellpadding="0" cellspacing="0">
				<tr class="row">
					<th style="width:100px">投标人</th>
					<th>投标金额</th>
					<th style="width:130px">状态</th>
					<th style="width:130px">是否转账</th>
					<th style="width:130px">流标返还</th>
					<th style="width:130px">投标时间</th>
				</tr>
				<?php if(is_array($loan_list)): foreach($loan_list as $key=>$loan): ?><tr>
					<td><?php echo get_user_name($loan['user_id']);?></td>
					<td align="center"><?php echo (format_price($loan["money"])); ?></td>
					<td align="center"><?php if($loan['is_auto'] == 1): ?>自动<?php else: ?>手动<?php endif; ?></td>
					<td align="center">
							<?php if($loan['is_has_loans'] == 1): ?>已转账
							<?php else: ?>
							<font color=red>未转账</font><?php endif; ?>
					</td>
					<td align="center"><?php if($deal_info['deal_status'] != 3): ?>无返还<?php else: ?><?php if($loan['is_repay'] == 1): ?>已返还<?php else: ?><font color=red>未返还</font><?php endif; ?><?php endif; ?></td>
					<td align="center"><?php echo to_date($loan['create_time'],"Y-m-d H:i");?></td>
				</tr><?php endforeach; endif; ?>
				<tr>
					<td colspan="6">
						<div class="blank5"></div>
						<div class="page"><?php echo ($page); ?></div>
						</div><?php endif; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td colspan=2 class="bottomTd"></td>
	</tr>
</table>

</div>
</body>
</html>