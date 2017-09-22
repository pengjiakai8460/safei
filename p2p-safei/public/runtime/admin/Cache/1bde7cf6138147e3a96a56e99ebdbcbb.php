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

<link rel="stylesheet" type="text/css" href="__TMPL__Common/style/jquery.autocomplete.css" />
<script type="text/javascript" src="__TMPL__Common/js/jquery.autocomplete.min.js"></script>

<?php function get_del_referrals($user_id,$referrals){
		if($referrals['pid'] > 0){
			$str = '<a href="javascript:del_referrals('.$user_id.');">取消关联</a>&nbsp;';
		}
		return $str;
	} ?>
<script type="text/javascript">
	function edit(user_id)
	{
		$.weeboxs.open(ROOT+'?m=CreateRelevance_rebate&a=edit&id='+user_id, {contentType:'ajax',showButton:false,title:'开始关联',width:600,height:260});
	}
	
	function del_referrals(user_id)
	{
		var returnVal = window.confirm("是否取消关联");
		if(returnVal) {
			location.href = ROOT+'?m=CreateRelevance_rebate&a=del_referrals&id='+user_id; 
		}
	
	}
</script>
<div class="main">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="search_row">
	<form name="search" action="__APP__" method="get">	
		<?php echo L("USER_NAME");?>：<input type="text" class="textbox" name="user_name" value="<?php echo trim($_REQUEST['user_name']);?>" style="width:100px;" />
		<?php echo L("AUTHORIZED_NAME");?>：<input type="text" class="textbox" name="authorized_name" value="<?php echo trim($_REQUEST['authorized_name']);?>" style="width:100px;" />
        状态：<select name="status">
			<option value="all" <?php if($_REQUEST['status'] == 'all' || trim($_REQUEST['status']) == ''): ?>selected="selected"<?php endif; ?>>所有状态</option>
			<option value="0" <?php if($_REQUEST['status'] != 'all' && trim($_REQUEST['status']) != '' && intval($_REQUEST['status']) == 0): ?>selected="selected"<?php endif; ?>>未关联</option>
			<option value="1" <?php if(intval($_REQUEST['status']) == 1): ?>selected="selected"<?php endif; ?>>已关联</option>
		</select>
        <input type="hidden" value="CreateRelevance_rebate" name="m" />
		<input type="hidden" value="index" name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
	</form>
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="6" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="50px  "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','CreateRelevance_rebate','index')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('user_name','<?php echo ($sort); ?>','CreateRelevance_rebate','index')" title="按照用户名  <?php echo ($sortType); ?> ">用户名  <?php if(($order)  ==  "user_name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('email','<?php echo ($sort); ?>','CreateRelevance_rebate','index')" title="按照邮箱  <?php echo ($sortType); ?> ">邮箱  <?php if(($order)  ==  "email"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('status','<?php echo ($sort); ?>','CreateRelevance_rebate','index')" title="按照状态  <?php echo ($sortType); ?> ">状态  <?php if(($order)  ==  "status"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('humans','<?php echo ($sort); ?>','CreateRelevance_rebate','index')" title="按照授权服务机构<?php echo ($sortType); ?> ">授权服务机构<?php if(($order)  ==  "humans"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th class="op_action"><a href="javascript:void(0)" class="A_opration">操作</a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$referrals): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo ($referrals["id"]); ?></td><td>&nbsp;<?php echo ($referrals["user_name"]); ?></td><td>&nbsp;<?php echo ($referrals["email"]); ?></td><td>&nbsp;<?php echo ($referrals["status"]); ?></td><td>&nbsp;<?php echo ($referrals["humans"]); ?></td><td class="op_action"><div class="viewOpBox"><a href="javascript:edit('<?php echo ($referrals["id"]); ?>')">开始关联</a>&nbsp;<?php echo (get_del_referrals($referrals["id"],$referrals)); ?></div><a href="javascript:void(0);" class="opration">操作+</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="6" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>