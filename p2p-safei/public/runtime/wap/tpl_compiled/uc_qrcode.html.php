<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<!-- 这里是页面内容区 -->


<div>
	<div class="blank15"></div>
	
	 	<div style="padding-left:10px;padding-right:10px;">
	 	<table width="100%">
			<tr bgcolor="#fff">
				<td width="130" style="padding-left:10px;height:35px;">邀请好友总数</td>
				<td align="left"><?php echo $this->_var['data']['referral_user']; ?> 个</td>
			</tr>
			<tr bgcolor="#fff">
				<td width="130" style="padding-left:10px;height:35px;">邀请获得返利</td>
				<td align="left"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['total_referral_money'],
);
echo $k['name']($k['v']);
?></td>
			</tr>
			
		</table>
	 	</div>
		<div class="blank15"></div>
		<div class="im refers" style="padding:10px;">
			<div style="background-color:#fff;padding:10px;">
				<h4>我的邀请二维码：</h4>
				<div class="blank5"></div>
				<div align="center"><img src="<?php echo $this->_var['data']['share_url_img']; ?>" width="300" /></div>
				<div class="blank"></div>
				<div style="background-color:#fff;padding-left:10px;padding-right:10px;">
					<?php echo $this->_var['data']['activity_info']['content']; ?>
				</div>
			</div>
		</div>
			
	
	
	<div class="blank15"></div>
</div>

<?php echo $this->fetch('./inc/footer.html'); ?>