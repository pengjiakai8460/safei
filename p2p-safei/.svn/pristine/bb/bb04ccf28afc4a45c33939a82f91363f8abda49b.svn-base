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
<?php function get_date_url($date){
		return "<a href=\"".__APP__."?m=WebsiteStatistics&a=website_extraction_cash_info&time=$date\">$date</a>";
	} ?>
<script type="text/javascript">	
	function export_csv_extraction_cash()
	{
		var query = $("#search_form").serialize();
		query = query.replace("&m=WebsiteStatistics","");
		query = query.replace("&a=website_extraction_cash","");
		var url= ROOT+"?"+VAR_MODULE+"="+MODULE_NAME+"&"+VAR_ACTION+"=export_csv_extraction_cash"+"&"+query;
		location.href = url;
	}
	
</script>
<link rel="stylesheet" type="text/css" href="__TMPL__Common/js/calendar/calendar.css" />
<script type="text/javascript" src="__TMPL__Common/js/calendar/calendar.js"></script>
<div class="main">
<div class="main_title">提现统计</div>
<div class="blank5"></div>

	<form name="search" id = "search_form"  action="__APP__" method="get">	
		<input type="hidden" value='<?php echo ($q_date_diff); ?>' name="q_date_diff" id="q_date_diff"  />
		<label id="start_time_item_title">开始日期:</label><input class = "require textbox" type="text" name="start_time" id="q_start_time" value="<?php echo ($start_time); ?>" style=""  onfocus="return showCalendar('q_start_time', '%Y-%m-%d', false, false, 'q_start_time');" />
		<label id="end_time_item_title">结束日期:</label><input class = "require textbox" type="text" name="end_time" id="q_end_time" value="<?php echo ($end_time); ?>" style=""  onfocus="return showCalendar('q_end_time', '%Y-%m-%d', false, false, 'q_end_time');" />
		
		<input type="hidden" value='<?php echo MODULE_NAME; ?>' name="m" />
		<input type="hidden" value='<?php echo ACTION_NAME; ?>' name="a" />
		<input type="submit" class="button" value="<?php echo L("SEARCH");?>" />
		<input type="button" class="button" value="<?php echo L("EXPORT");?>" onclick="export_csv_extraction_cash();" />
		<input type="button" id = "submit_date_0" class="button_none" value="今天" />
		<input type="button" id = "submit_date_1" class="button_none" value="昨天" />
		<input type="button" id = "submit_date_7" class="button_none" value="最近一周" />
		<input type="button" id = "submit_date_30" class="button_none" value="最近一月" />	
		<input type="button" id = "submit_date_365" class="button_none" value="最近一年" />	
	</form>
	
<div class="blank5"></div>

<div class="blank5"></div>
	<div class="line">
		<?php if(is_array($chart_list[0])): foreach($chart_list[0] as $key=>$chart_item): ?><label><input type="radio" onclick="javascript:load0_line<?php echo ($key); ?>();"  name="info_0_line" id="info_0_line_<?php echo ($key); ?>" value="<?php echo ($key); ?>" <?php if($key == 0): ?>checked="true"<?php endif; ?>><?php echo ($chart_item["title"]); ?></label><?php endforeach; endif; ?>
		
	</div>
	
	<div class="bar" style="display:none;">
		<?php if(is_array($chart_list[0])): foreach($chart_list[0] as $key=>$chart_item): ?><label><input type="radio" onclick="javascript:load0_bar<?php echo ($key); ?>();"  name="info_0_bar" id="info_0_bar_<?php echo ($key); ?>" value="<?php echo ($key); ?>"  <?php if($key == 0): ?>checked="true"<?php endif; ?>><?php echo ($chart_item["title"]); ?></label><?php endforeach; endif; ?>	
		
	</div>

	<div class="blank5">
	
		
	</div>
	<div class="blank5"></div>
	
	<script type="text/javascript" src="__TMPL__Common/js/flash/js/json/json2.js"></script>
<script type="text/javascript" src="__TMPL__Common/js/flash/js/swfobject.js"></script>
<script type="text/javascript">
var flashvars = {};
var params = {wmode:"opaque"};
<?php if(!empty($chart_list[0][0]['line'])){  ?>
swfobject.embedSWF("__TMPL__Common/js/flash/open-flash-chart.swf", "my_chart", "900", "300", "9.0.0" , "expressInstall.swf", flashvars,params);
<?php } ?>

function ofc_ready()
{
}


function open_flash_chart_data()
{
	var index = 0;
	if((!isNaN($("#conf_tab_index").val())) && $("#conf_tab_index").val() != ''){
		index = $("#conf_tab_index").val();
		//alert('open_flash_chart_data:' + $("#conf_tab_index").val());
	}
	
	var data_line_name = "data" + index + "_line0";
	var data_bar_name = "data" + index + "_bar0";
	
	var data_line;
	var data_bar;
	
	data_line = window.eval(data_line_name);
	data_bar = window.eval(data_bar_name); 
	//alert(data_line);
	$("#my_now").attr('line',JSON.stringify(data_line));
	$("#my_now").attr('bar',JSON.stringify(data_bar));
	//$("#my_now").attr('name','info_' + index + '_bar');
	//$("#my_now").attr('name_num','0');
	
	//$("#my_now").attr('line_bar_id','info_' + index + '_bar_0');
	//设置对应的：条形图 也有选择状态			
	$('#info_' + index + '_bar_0').attr('checked','checked');
	
	return JSON.stringify(data_line);
	
}


function findSWF(movieName) {
  if (navigator.appName.indexOf("Microsoft")!= -1) {
    return window[movieName];
  } else {
    return document[movieName];
  }
}

   <?php foreach($chart_list as $k=>$v){ ?>
	   <?php foreach($v as $k1=>$v1){ ?>
	  	 function load<?php echo $k; ?>_line<?php echo $k1; ?>()
		{
	  		 //alert('info_<?php echo $k; ?>_bar_<?php echo $k1; ?>');
			$("#my_now").attr('line',JSON.stringify(data<?php echo $k; ?>_line<?php echo $k1; ?>) );
			$("#my_now").attr('bar',JSON.stringify(data<?php echo $k; ?>_bar<?php echo $k1; ?>) );
			$("#my_now").attr('line_bar_id','info_<?php echo $k; ?>_bar_<?php echo $k1; ?>');
			//设置对应的：条形图 也有选择状态			
			$('#info_<?php echo $k; ?>_bar_<?php echo $k1; ?>').attr('checked','checked');
	 		 tmp = findSWF("my_chart");
	 		 x = tmp.load( JSON.stringify(data<?php echo $k; ?>_line<?php echo $k1; ?>) );
		}
	  	 
		function load<?php echo $k; ?>_bar<?php echo $k1; ?>()
		{
			//alert('info_<?php echo $k; ?>_line_<?php echo $k1; ?>');
			$("#my_now").attr('line',JSON.stringify(data<?php echo $k; ?>_line<?php echo $k1; ?>) );
			$("#my_now").attr('bar',JSON.stringify(data<?php echo $k; ?>_bar<?php echo $k1; ?>) );			
			//设置对应的：曲线图 也有选择状态
			$('#info_<?php echo $k; ?>_line_<?php echo $k1; ?>').attr('checked','checked');
	 		 tmp = findSWF("my_chart");
	 		 x = tmp.load( JSON.stringify(data<?php echo $k; ?>_bar<?php echo $k1; ?>) );			 
		}
	   var data<?php echo $k; ?>_line<?php echo $k1; ?> = <?php echo $v1['line']; ?>;
	   var data<?php echo $k; ?>_bar<?php echo $k1; ?> = <?php echo $v1['bar']; ?>;
	    <?php }  ?>
   <?php } ?>
   
	var pic = 0;
	    var line = 0;
	    var bar = 0;
	function updatechart(p){
	    	if(pic == p)
	    		return;
	    	pic = p;
	    	
	    	if(pic == 0){
	    		$("#chart_select").attr('val','0');
	    		$("#chart_line").css("background","url(__TMPL__Common/images/top_1/line_actived.gif)");
	    		$("#chart_column").css("background","url(__TMPL__Common/images/top_1/bar.gif)");
				$(".line").css('display','block');
				$(".bar").css('display','none');
				tmp = findSWF("my_chart");
 				x = tmp.load($("#my_now").attr('line'));
	    	}
	    	if(pic == 1){
	    		$("#chart_select").attr('val','1');
	    		$("#chart_column").css("background","url(__TMPL__Common/images/top_1/bar_actived.gif)");
	    		$("#chart_line").css("background","url(__TMPL__Common/images/top_1/line.gif)");
				$(".line").css('display','none');
				$(".bar").css('display','block');
				
				tmp = findSWF("my_chart");
 				x = tmp.load($("#my_now").attr('bar'));
	    	}
			
	    	line = 0;
	    	bar = 0;
	    }
	    function updateline(p){
	    	if(pic == p)
	    		return;
	    	if(line == 0){
	    		$("#chart_line").css("background","url(__TMPL__Common/images/top_1/line_hover.gif)");
	    		line = 1;
	    	}
	    	else{
	    		$("#chart_line").css("background","url(__TMPL__Common/images/top_1/line.gif)");
	    		line = 0;
	    	}
	    }
	    function updatebar(p){
	    	if(pic == p)
	    		return;
	    	if(bar == 0){
	    		$("#chart_column").css("background","url(__TMPL__Common/images/top_1/bar_hover.gif)");
	    		bar = 1;
	    	}
	    	else{
	    		$("#chart_column").css("background","url(__TMPL__Common/images/top_1/bar.gif)");
	    		bar = 0;
	    	}
	    	    
	    }
	    
	    
	    function load_data(tab){
	 	   
	 	   var load_fun;
	 	   var radio;
	 	   if ($("#chart_select").attr('val') == 1){
	 		 //bar
	 		   var index = 0;
	 		   radio = 'input:radio[name=info_'+tab+'_bar]:checked';
	 		   if ($(radio).val() != ''){
	 			   index = $(radio).val();
	 		   }
	 		   load_fun ="load" + tab + "_bar"+index+"()";

	 	   }else{
	 		   //line
	 		   var index = 0;
	 		  radio = 'input:radio[name=info_'+tab+'_line]:checked';
	 		   if ($(radio).val() != ''){
	 			   index = $(radio).val();
	 		   }
	 		   
	 		   load_fun = "load" + tab + "_line"+index+"()";
	 	   }
	 	   
	 	  if((!isNaN($(radio).val())) && $(radio).val() != ''){
	 		 window.eval(load_fun);
	 	  }
	 	  /*
	 	 //var load_fun_sender = window.setInterval(load_fun,1);
	 	    if(!!(window.attachEvent && !window.opera)){
	 	    	//ie
	 	    	execScript(load_fun); 
	 	    }else{
	 	    	//not ie
	 	    	window.eval(load_fun);
	 	    }
	 	    */
	    }	    
</script>
<style>
	.dataline_default .chart_column {
float: right;
border: 1px solid #DCE1E5;
font-size: 12px;
height: 20px;
line-height: 25px;
margin: 0px;
padding: 0px 14px 0px 10px;
background-repeat: no-repeat;
}
.dataline_default .chart_line {
float: right;
border: 1px solid #DCE1E5;
font-size: 12px;
height: 20px;
line-height: 25px;
margin: 0px;
padding: 0px 18px 0px 5px;
background-repeat: no-repeat;
}
</style>
<div class="dataline_default" style="position:relative;">
	<div class="main_title"><div class="main_title_content">统计图表<span class="main_title_span"></span></div></div>
	<span class="chart_select" id= "chart_select" style="position:absolute; right:0; top:0;">
		<a class="chart_column" id="chart_column" style="background-image: url(__TMPL__Common/images/top_1/bar.gif); background-position: initial initial; background-repeat: initial initial;" title="条形图" href="javascript:updatechart(1)" onmouseover="updatebar(1)" onmouseout="updatebar(1)"></a>
		<a class="chart_line" id="chart_line" style="background-image: url(__TMPL__Common/images/top_1/line_actived.gif); background-position: initial initial; background-repeat: initial initial;" title="曲线图" href="javascript:updatechart(0)" onmouseover="updateline(0)" onmouseout="updateline(0)"></a>
	</span>
</div>
<div class="blank5"></div>
<div class="blank5"></div>
<div id="my_chart"></div>
<?php if(is_array($chart_list)&&count($chart_list)>0){ ?>
<div id="my_now" style="display:none;" title=""></div>
<?php }else{ ?>
<div  title="">没有数据</div>
<?php } ?>
	
	<div class="blank5">
		
		
	</div>
	
<!-- Think 系统列表组件开始 -->
<table id="dataTable" class="dataTable" cellpadding=0 cellspacing=0 ><tr><td colspan="3" class="topTd" >&nbsp; </td></tr><tr class="row" ><th><a href="javascript:sortBy('时间','<?php echo ($sort); ?>','WebsiteStatistics','website_extraction_cash')" title="按照时间   <?php echo ($sortType); ?> ">时间   <?php if(($order)  ==  "时间"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('成功提现总额','<?php echo ($sort); ?>','WebsiteStatistics','website_extraction_cash')" title="按照成功提现总额   <?php echo ($sortType); ?> ">成功提现总额   <?php if(($order)  ==  "成功提现总额"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th><th><a href="javascript:sortBy('人次','<?php echo ($sort); ?>','WebsiteStatistics','website_extraction_cash')" title="按照人次   <?php echo ($sortType); ?> ">人次   <?php if(($order)  ==  "人次"): ?><img src="__TMPL__Common/images/<?php echo ($sortImg); ?>.gif" width="12" height="17" border="0" align="absmiddle"><?php endif; ?></a></th></tr><?php if(is_array($list)): $key = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$deal): ++$key;$mod = ($key % 2 )?><tr class="row <?php if($key % 2 == 0): ?>row1<?php endif; ?>" ><td>&nbsp;<?php echo (get_date_url($deal["时间"])); ?></td><td>&nbsp;<?php echo (format_price($deal["成功提现总额"])); ?></td><td>&nbsp;<?php echo ($deal["人次"]); ?></td></tr><?php endforeach; endif; else: echo "" ;endif; ?><tr><td colspan="3" class="bottomTd"> &nbsp;</td></tr></table>
<!-- Think 系统列表组件结束 -->
 
		
		

	
	
<div class="blank5"></div>
<div class="page"><?php echo ($page); ?></div>

</div>

</body>
</html>