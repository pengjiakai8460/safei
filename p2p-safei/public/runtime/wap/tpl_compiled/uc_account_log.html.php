<?php if ($_REQUEST['is_ajax'] != 1): ?>	
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content infinite-scroll "  data-distance="<?php echo $this->_var['data']['rs_count']; ?>" now_page="1">
<!-- 这里是页面内容区 -->
<!--账户日志-->
<div class="<?php echo $this->_var['data']['act']; ?>-box"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|uc_account_log#index|"."status=".$this->_var['data']['status']."".""); 
?>">

	<div class="blank15"></div>
	<div class="choose">
		<table>
			<tr>
				<th <?php if ($this->_var['data']['status'] == 0): ?>class="y"<?php endif; ?>><a href="#" onclick="now_page = 1;reloadpage('<?php
echo parse_wap_url_tag("u:index|uc_account_log|"."status=0".""); 
?>','#uc_account_log','.<?php echo $this->_var['data']['act']; ?>-box');">资金日志</a></th>
				<th <?php if ($this->_var['data']['status'] == 1): ?>class="y"<?php endif; ?>><a href="#" onclick="now_page = 1;reloadpage('<?php
echo parse_wap_url_tag("u:index|uc_account_log|"."status=1".""); 
?>','#uc_account_log','.<?php echo $this->_var['data']['act']; ?>-box');">冻结资金日志</a></th>
				<th <?php if ($this->_var['data']['status'] == 2): ?>class="y"<?php endif; ?>><a href="#" onclick="now_page = 1;reloadpage('<?php
echo parse_wap_url_tag("u:index|uc_account_log|"."status=2".""); 
?>','#uc_account_log','.<?php echo $this->_var['data']['act']; ?>-box');">信用积分日志</a></th>
				<th <?php if ($this->_var['data']['status'] == 3): ?>class="y"<?php endif; ?>><a href="#" onclick="now_page = 1;reloadpage('<?php
echo parse_wap_url_tag("u:index|uc_account_log|"."status=3".""); 
?>','#uc_account_log','.<?php echo $this->_var['data']['act']; ?>-box');">积分日志</a></th>				
			</tr>
		</table>
	</div>
	<div class="blank15"></div>	
	<div class="b_white">
		<ul class="n_version_ul_1 invest">
			
<?php endif; ?>			 
			<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
		    <li class="clearfix">
		    	   <div class="f_l">
		    	   	   <?php if ($this->_var['data']['status'] == 1): ?>
							<?php if ($this->_var['item']['lock_money'] > 0): ?>
							<p class="c_aad421 ">
								操作金额：+<?php echo $this->_var['item']['lock_money']; ?>
								<?php elseif ($this->_var['item']['lock_money'] == 0): ?>
							<p>
								操作金额：<?php echo $this->_var['item']['lock_money']; ?>
								<?php else: ?>
							<p class="c_ff4a4a ">
								操作金额：<?php echo $this->_var['item']['lock_money']; ?>
						<?php endif; ?>
					</p>
			<?php elseif ($this->_var['data']['status'] == 2): ?>
				<?php if ($this->_var['item']['point'] > 0): ?>
				<p class="c_aad421 ">
					操作金额：+<?php echo $this->_var['item']['point']; ?>
					<?php elseif ($this->_var['item']['point'] == 0): ?>
					<p>
					操作金额：<?php echo $this->_var['item']['point']; ?>
					<?php else: ?>
					<p class="c_ff4a4a ">
					操作金额：<?php echo $this->_var['item']['point']; ?><?php endif; ?>
					</p>
				
			<?php elseif ($this->_var['data']['status'] == 3): ?>
				<?php if ($this->_var['item']['score'] > 0): ?>
				<p class="c_aad421 ">
					操作金额：+<?php echo $this->_var['item']['score']; ?>
				<?php elseif ($this->_var['item']['score'] == 0): ?>
				<p>
				操作金额：<?php echo $this->_var['item']['score']; ?>
				<?php else: ?><p class="c_ff4a4a ">
				操作金额：<?php echo $this->_var['item']['score']; ?>
				<?php endif; ?>
				</p>
				
			<?php else: ?>
				<?php if ($this->_var['item']['money'] > 0): ?>
				<p class="c_aad421 ">
					操作金额：+<?php echo $this->_var['item']['money']; ?>
					<?php elseif ($this->_var['item']['money'] == 0): ?>
					<p>
					操作金额：<?php echo $this->_var['item']['money']; ?>
					<?php else: ?><p class="c_ff4a4a ">
					操作金额：<?php echo $this->_var['item']['money']; ?>
						<?php endif; ?>
						</p>
				
			<?php endif; ?>
						<p>操作类型：<?php echo $this->_var['item']['title']; ?></p>
						<p>操作时间：<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['item']['create_time'],
);
echo $k['name']($k['v']);
?></p>
					</div>
					<div class=" f_r relative">
						<span class="absolute top0 rig10">余额</span>
						<?php if ($this->_var['data']['status'] == 1): ?>
							<p class="n_v_mnoney"><?php echo $this->_var['item']['account_lock_money']; ?></p>
						<?php elseif ($this->_var['data']['status'] == 2): ?>
							<p class="n_v_mnoney"><?php echo $this->_var['item']['account_point']; ?></p>
						<?php elseif ($this->_var['data']['status'] == 3): ?>
							<p class="n_v_mnoney"><?php echo $this->_var['item']['account_score']; ?></p>
						<?php else: ?>
							<p class="n_v_mnoney"><?php echo $this->_var['item']['account_money']; ?></p>
						<?php endif; ?>
					</div>
		    </li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($_REQUEST['is_ajax'] != 1): ?>	
		</ul>
	</div>
	<div class="blank15"></div>
</div>
<!-- 加载提示符 -->
<div class="infinite-scroll-preloader">
  <div class="preloader">
  </div>
</div>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>






