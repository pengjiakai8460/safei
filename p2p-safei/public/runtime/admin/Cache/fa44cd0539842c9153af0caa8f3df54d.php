<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="Generator" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
	.dialog-content{line-height:30px; color:#000;}
</style>
<title>电子合同</title>
</head>

<body style="padding:8px;margin:0">
	<div style="font-size:12px">
	    <div style="background-color: #FFFFFF; border:#dfe6ea solid 1px; padding: 5px 12px;">
			<?php echo ($contract); ?>
			<div style="text-align: center">
	            <input type="button" value="关 闭" align="center" onclick="callPClose()">
	        </div>
	    </div>
	    <div class="bt">
	    </div>
	</div>
	<script type="text/javascript">
		function callPClose(){
			window.parent.frames["main"].closeWeeboxs();
		}
	</script>
</body>
</html>