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

<?php function get_send_types($type)
	{
		if($type==0)
		{
			return l("ADMIN_SEND");
		}
		elseif($type==2)
		{
			return "序列号领取";
		}
		elseif($type==3)
		{
			return '注册发放';
		}
		elseif($type==1)
		{
			return l("SCORE_EXCHANGE");
		}
	}
    function get_use_type($type)
	{
		if($type==0)
		{
			return "PC端使用";
		}
		elseif($type==1)
		{
			return "手机端使用";
		}
        elseif($type==2)
		{
			return "通用";
		}
	}
	function get_send($id)
	{
		if(M("InterestrateType")->where("id=".$id)->getField("send_type")==0)
		{
			return "<a href='".u("InterestrateType/send",array("id"=>$id))."'>".l("SEND_VOUCHER")."</a>";
		}
	}
    function format_rate($rate)
    {
    	return number_format($rate,2)."%";
    } ?>
<script type="text/javascript">
	function view(id)
	{
		location.href = ROOT+"?"+VAR_MODULE+"=Interestrate&"+VAR_ACTION+"=index&ecv_type_id="+id+"&";
	}
</script>
<div class="main">
<div class="main_title"><?php echo ($main_title); ?></div>
<div class="blank5"></div>
<div class="button_row">
	<input type="button" class="button" value="<?php echo L("ADD");?>" onclick="add();" />
	<input type="button" class="button" value="<?php echo L("FOREVERDEL");?>" onclick="foreverdel();" />
</div>
<div class="blank5"></div>
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="11" class="topTd" >&nbsp; </td></tr><tr class="row" ><th width="8"><input type="checkbox" id="check" onclick="CheckAll('dataTable')"></th><th width="50px  "><a href="javascript:sortBy('id','<?php echo ($sort); ?>','InterestrateType','index')" title="按照<?php echo L("ID");?><?php echo ($sortType); ?> "><?php echo L("ID");?><?php if(($order)  ==  "id"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('name','<?php echo ($sort); ?>','InterestrateType','index')" title="按照加息券名称  <?php echo ($sortType); ?> ">加息券名称  <?php if(($order)  ==  "name"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('rate','<?php echo ($sort); ?>','InterestrateType','index')" title="按照利率  <?php echo ($sortType); ?> ">利率  <?php if(($order)  ==  "rate"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('use_limit','<?php echo ($sort); ?>','InterestrateType','index')" title="按照<?php echo L("VOUCHER_LIMIT");?>  <?php echo ($sortType); ?> "><?php echo L("VOUCHER_LIMIT");?>  <?php if(($order)  ==  "use_limit"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('begin_time','<?php echo ($sort); ?>','InterestrateType','index')" title="按照<?php echo L("VOUCHER_BEGIN_TIME");?>  <?php echo ($sortType); ?> "><?php echo L("VOUCHER_BEGIN_TIME");?>  <?php if(($order)  ==  "begin_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('end_time','<?php echo ($sort); ?>','InterestrateType','index')" title="按照<?php echo L("VOUCHER_END_TIME");?>  <?php echo ($sortType); ?> "><?php echo L("VOUCHER_END_TIME");?>  <?php if(($order)  ==  "end_time"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('gen_count','<?php echo ($sort); ?>','InterestrateType','index')" title="按照<?php echo L("VOUCHER_GEN_COUNT");?>     <?php echo ($sortType); ?> "><?php echo L("VOUCHER_GEN_COUNT");?>     <?php if(($order)  ==  "gen_count"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('use_type','<?php echo ($sort); ?>','InterestrateType','index')" title="按照适用类型  <?php echo ($sortType); ?> ">适用类型  <?php if(($order)  ==  "use_type"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('send_type','<?php echo ($sort); ?>','InterestrateType','index')" title="按照<?php echo L("VOUCHER_SEND_TYPE");?><?php echo ($sortType); ?> "><?php echo L("VOUCHER_SEND_TYPE");?><?php if(($order)  ==  "send_type"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th class="op_action"><a href="javascript:void(0)" class="A_opration">操作</a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$article): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td><input type="checkbox" name="key" class="key" value="<?php echo ($article["id"]); ?>"></td><td>&nbsp;<?php echo ($article["id"]); ?></td><td>&nbsp;<?php echo ($article["name"]); ?></td><td>&nbsp;<?php echo (format_rate($article["rate"])); ?></td><td>&nbsp;<?php echo ($article["use_limit"]); ?></td><td>&nbsp;<?php echo (to_date($article["begin_time"],'Y-m-d')); ?></td><td>&nbsp;<?php echo (to_date($article["end_time"],'Y-m-d')); ?></td><td>&nbsp;<?php echo ($article["gen_count"]); ?></td><td>&nbsp;<?php echo (get_use_type($article["use_type"])); ?></td><td>&nbsp;<?php echo (get_send_types($article["send_type"])); ?></td><td class="op_action"><div class="viewOpBox"><a href="javascript:edit('<?php echo ($article["id"]); ?>')"><?php echo L("EDIT");?></a>&nbsp;<a href="javascript:foreverdel('<?php echo ($article["id"]); ?>')"><?php echo L("FOREVERDEL");?></a>&nbsp;<?php echo (get_send($article["id"])); ?><a href="javascript:view('<?php echo ($article["id"]); ?>')"><?php echo L("VIEW");?></a>&nbsp;</div><a href="javascript:void(0);" class="opration">操作+</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="11" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 

<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>
</div>
</body>
</html>