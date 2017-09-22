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

<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.php?lang=zh-cn" ></script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<script type="text/javascript">

</script>
<div class="main">
<div class="main_title">
		<?php echo ($user_info["user_name"]); ?> 
		<?php echo L("USER_ACCOUNT_DETAIL");?>
</div>
<div class="blank5"></div>
<div class="main_title">
	<div class="sub_nav">
		<input class="button conf_btn <?php if($t == money): ?>currentbtn<?php endif; ?>" type="button" onclick="location.href='__APP__?m=User&a=account_detail&id=<?php echo ($user_id); ?>&t=money'" value="资金日志">
		<input class="button conf_btn <?php if($t == point): ?>currentbtn<?php endif; ?>" type="button" onclick="location.href='__APP__?m=User&a=account_detail&id=<?php echo ($user_id); ?>&t=point'" value="信用积分日志">
		<input class="button conf_btn <?php if($t == score): ?>currentbtn<?php endif; ?>" type="button" onclick="location.href='__APP__?m=User&a=account_detail&id=<?php echo ($user_id); ?>&t=score'" value="积分日志">
		<input class="button conf_btn <?php if($t == freeze): ?>currentbtn<?php endif; ?>" type="button" onclick="location.href='__APP__?m=User&a=account_detail&id=<?php echo ($user_id); ?>&t=freeze'" value="冻结资金">
		<input class="button conf_btn <?php if($t == nmc_amount): ?>currentbtn<?php endif; ?>" type="button" onclick="location.href='__APP__?m=User&a=account_detail&id=<?php echo ($user_id); ?>&t=nmc_amount'" value="不可提现资金">
		<input class="button conf_btn <?php if($t == quota): ?>currentbtn<?php endif; ?>" type="button" onclick="location.href='__APP__?m=User&a=account_detail&id=<?php echo ($user_id); ?>&t=quota'" value="额度">
	</div>
</div>

<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("KEYWORD");?>：<input type="text" class="textbox" name="log_info" value="<?php echo trim($_REQUEST['log_info']);?>" />		
		
		<?php echo L("LOG_TIME");?>：
		<input type="text" class="textbox" name="log_begin_time" id="log_begin_time" value="<?php echo trim($_REQUEST['log_begin_time']);?>" onfocus="return showCalendar('log_begin_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_log_begin_time');" />
		<input type="button" class="button" id="btn_log_begin_time" value="<?php echo L("SELECT_TIME");?>" onclick="return showCalendar('log_begin_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_log_begin_time');" />	
		-
		<input type="text" class="textbox" name="log_end_time" id="log_end_time" value="<?php echo trim($_REQUEST['log_end_time']);?>" onfocus="return showCalendar('log_end_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_log_end_time');" />
		<input type="button" class="button" id="btn_log_end_time" value="<?php echo L("SELECT_TIME");?>" onclick="return showCalendar('log_end_time', '%Y-%m-%d %H:%M:%S', false, false, 'btn_log_end_time');" />	
		
		<input type="hidden" value="User" name="m" />
		<input type="hidden" value="account_detail" name="a" />
		<input type="hidden" value="<?php echo ($user_info["id"]); ?>" name="id" />
		<input type="hidden" value="<?php echo ($t); ?>" name="t" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
	</form>
</div>
<div class="blank5"></div>
<div class="blank5"></div>
<?php if($t == money): ?><!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="5" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','account_detail')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','User','account_detail')" title="按照操作金额   <?php echo ($sortType); ?> ">操作金额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('account_money','<?php echo ($sort); ?>','User','account_detail')" title="按照结余   <?php echo ($sortType); ?> ">结余   <?php if(($order)  ==  "account_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('memo','<?php echo ($sort); ?>','User','account_detail')" title="按照操作备注   <?php echo ($sortType); ?> ">操作备注   <?php if(($order)  ==  "memo"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time_ymd','<?php echo ($sort); ?>','User','account_detail')" title="按照操作时间<?php echo ($sortType); ?> ">操作时间<?php if(($order)  ==  "create_time_ymd"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo (format_price($log["money"])); ?></td><td>&nbsp;<?php echo (format_price($log["account_money"])); ?></td><td>&nbsp;<?php echo ($log["memo"]); ?></td><td>&nbsp;<?php echo ($log["create_time_ymd"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="5" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 
<?php elseif($t == point): ?>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="5" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','account_detail')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('point','<?php echo ($sort); ?>','User','account_detail')" title="按照操作积分   <?php echo ($sortType); ?> ">操作积分   <?php if(($order)  ==  "point"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('account_point','<?php echo ($sort); ?>','User','account_detail')" title="按照结余   <?php echo ($sortType); ?> ">结余   <?php if(($order)  ==  "account_point"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('memo','<?php echo ($sort); ?>','User','account_detail')" title="按照操作备注   <?php echo ($sortType); ?> ">操作备注   <?php if(($order)  ==  "memo"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time_ymd','<?php echo ($sort); ?>','User','account_detail')" title="按照操作时间   <?php echo ($sortType); ?> ">操作时间   <?php if(($order)  ==  "create_time_ymd"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo ($log["point"]); ?></td><td>&nbsp;<?php echo ($log["account_point"]); ?></td><td>&nbsp;<?php echo ($log["memo"]); ?></td><td>&nbsp;<?php echo ($log["create_time_ymd"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="5" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<?php elseif($t == score): ?>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="5" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','account_detail')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('score','<?php echo ($sort); ?>','User','account_detail')" title="按照操作积分   <?php echo ($sortType); ?> ">操作积分   <?php if(($order)  ==  "score"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('account_score','<?php echo ($sort); ?>','User','account_detail')" title="按照结余   <?php echo ($sortType); ?> ">结余   <?php if(($order)  ==  "account_score"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('memo','<?php echo ($sort); ?>','User','account_detail')" title="按照操作备注   <?php echo ($sortType); ?> ">操作备注   <?php if(($order)  ==  "memo"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time_ymd','<?php echo ($sort); ?>','User','account_detail')" title="按照操作时间   <?php echo ($sortType); ?> ">操作时间   <?php if(($order)  ==  "create_time_ymd"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo ($log["score"]); ?></td><td>&nbsp;<?php echo ($log["account_score"]); ?></td><td>&nbsp;<?php echo ($log["memo"]); ?></td><td>&nbsp;<?php echo ($log["create_time_ymd"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="5" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->

<?php elseif($t == freeze): ?>
	<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="5" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','account_detail')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('lock_money','<?php echo ($sort); ?>','User','account_detail')" title="按照操作金额   <?php echo ($sortType); ?> ">操作金额   <?php if(($order)  ==  "lock_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('account_lock_money','<?php echo ($sort); ?>','User','account_detail')" title="按照冻结资金   <?php echo ($sortType); ?> ">冻结资金   <?php if(($order)  ==  "account_lock_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('memo','<?php echo ($sort); ?>','User','account_detail')" title="按照操作备注   <?php echo ($sortType); ?> ">操作备注   <?php if(($order)  ==  "memo"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time_ymd','<?php echo ($sort); ?>','User','account_detail')" title="按照操作时间   <?php echo ($sortType); ?> ">操作时间   <?php if(($order)  ==  "create_time_ymd"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo ($log["lock_money"]); ?></td><td>&nbsp;<?php echo ($log["account_lock_money"]); ?></td><td>&nbsp;<?php echo ($log["memo"]); ?></td><td>&nbsp;<?php echo ($log["create_time_ymd"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="5" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 
<?php elseif($t == nmc_amount): ?>
	<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="5" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','account_detail')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('money','<?php echo ($sort); ?>','User','account_detail')" title="按照操作金额   <?php echo ($sortType); ?> ">操作金额   <?php if(($order)  ==  "money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('account_money','<?php echo ($sort); ?>','User','account_detail')" title="按照结余   <?php echo ($sortType); ?> ">结余   <?php if(($order)  ==  "account_money"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('memo','<?php echo ($sort); ?>','User','account_detail')" title="按照操作备注   <?php echo ($sortType); ?> ">操作备注   <?php if(($order)  ==  "memo"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('create_time_ymd','<?php echo ($sort); ?>','User','account_detail')" title="按照操作时间<?php echo ($sortType); ?> ">操作时间<?php if(($order)  ==  "create_time_ymd"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo (format_price($log["money"])); ?></td><td>&nbsp;<?php echo (format_price($log["account_money"])); ?></td><td>&nbsp;<?php echo ($log["memo"]); ?></td><td>&nbsp;<?php echo ($log["create_time_ymd"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="5" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 	 
<?php elseif($t == quota): ?>

	<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="4" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px   "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','User','account_detail')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('quota','<?php echo ($sort); ?>','User','account_detail')" title="按照额度   <?php echo ($sortType); ?> ">额度   <?php if(($order)  ==  "quota"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_info','<?php echo ($sort); ?>','User','account_detail')" title="按照操作类型   <?php echo ($sortType); ?> ">操作类型   <?php if(($order)  ==  "log_info"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('log_time','<?php echo ($sort); ?>','User','account_detail')" title="按照操作时间<?php echo ($sortType); ?> ">操作时间<?php if(($order)  ==  "log_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$log): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($log["id"]); ?></td><td>&nbsp;<?php echo ($log["quota"]); ?></td><td>&nbsp;<?php echo ($log["log_info"]); ?></td><td>&nbsp;<?php echo (to_date($log["log_time"])); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="4" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 --><?php endif; ?>

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>