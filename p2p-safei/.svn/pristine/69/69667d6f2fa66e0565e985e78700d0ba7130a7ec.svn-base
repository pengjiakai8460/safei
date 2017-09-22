<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content infinite-scroll pull-to-refresh-content"  data-distance="<?php echo $this->_var['data']['rs_count']; ?>"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|uc_carry_money_log#index|"."".""); 
?>">
<!-- 这里是页面内容区 -->
<!--提现日志-->
<ul class="log_list invest">
	<?php endif; ?>
	 <!-- 默认的下拉刷新层 -->
<div class="pull-to-refresh-layer" all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" >
        <div class="preloader"></div>
        <div class="pull-to-refresh-arrow"></div>
    </div>
	<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
	<li>
		<dl class="clearfix">
			<dd><span class="name">提现金额</span><?php 
$k = array (
  'name' => 'format_price',
  'value' => $this->_var['item']['money'],
);
echo $k['name']($k['value']);
?></dd>
			<dd><span class="name">手续费</span><?php 
$k = array (
  'name' => 'format_price',
  'value' => $this->_var['item']['fee'],
);
echo $k['name']($k['value']);
?></dd>
			<dd><span class="name">提现银行</span><?php echo $this->_var['item']['bank_name']; ?></dd>
			<?php if ($this->_var['item']['msg']): ?>
			<dd><span class="name">失败原因</span><?php echo $this->_var['item']['msg']; ?></dd>
			<?php endif; ?>
			<dd class="y"><span class="name">银行资料</span><span class="c_ff4a4a">网点:<?php echo $this->_var['item']['bankzone']; ?>&nbsp;卡号:***<?php 
$k = array (
  'name' => 'msubstr',
  'v' => $this->_var['item']['bankcard'],
  's' => '-4',
  'l' => '4',
  'charset' => 'utf-8',
  'su' => 'false',
);
echo $k['name']($k['v'],$k['s'],$k['l'],$k['charset'],$k['su']);
?> &nbsp; 账户:<?php 
$k = array (
  'name' => 'utf_substr',
  'v' => $this->_var['item']['real_name'],
);
echo $k['name']($k['v']);
?></span></dd>
		</dl>
		<div class="clearfix results_block">
			<p class="f_l"><span class="name">处理结果</span>
			<?php if ($this->_var['item']['status'] == 0): ?>
			<span class="c_3b95d3">
			<?php elseif ($this->_var['item']['status'] == 1): ?>
			<span class="c_aad421">
			<?php elseif ($this->_var['item']['status'] == 4): ?>
			<span class="c_ff8800">
			<?php elseif ($this->_var['item']['status'] == 2): ?>
			<span class="c_878787">	
			<?php endif; ?>	
				<?php echo $this->_var['item']['status_format']; ?></span>
			</p>
			<p class="f_r">
				<input id="dltid_<?php echo $this->_var['item']['id']; ?>" type="hidden" value="<?php echo $this->_var['item']['id']; ?>" />
				<?php if ($this->_var['item']['status'] == 0): ?>
					<span class="Revocation_but c_3b95d3 bor_3b95d3">
						<a href="#" id="submita_<?php echo $this->_var['item']['id']; ?>" class="c_3b95d3">
						撤销申请
						</a>
					</span>
				<?php elseif ($this->_var['item']['status'] == 4): ?>
					<span class="Revocation_but c_ff8800 bor_ff8800">
						<a href="#" id="submitb_<?php echo $this->_var['item']['id']; ?>" class="c_ff8800">
						申请提现
						</a>
					</span>
				<?php else: ?>					
				<?php endif; ?>
				<script type="text/javascript">
				$("#submita_<?php echo $this->_var['item']['id']; ?>").click(function(){
					var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|uc_carry_revoke_apply|"."".""); 
?>';
					var dltid =  $.trim($("#dltid_<?php echo $this->_var['item']['id']; ?>").val());
					var query = newObject();
					query.dltid = $.trim($("#dltid_<?php echo $this->_var['item']['id']; ?>").val());
					query.status = 0;
					query.post_type = "json";
					$.ajax({
						url:ajaxurl,
						data:query,
						type:"Post",
						dataType:"json",
						success:function(data){
							$.alert(data.show_err);
								window.location.href = '<?php
echo parse_wap_url_tag("u:index|uc_carry_money_log|"."".""); 
?>';
						}
					
					});
					  
					$(this).parents(".float_block").hide();
				});
				
				$("#submitb_<?php echo $this->_var['item']['id']; ?>").click(function(){
					var ajaxurl = '<?php
echo parse_wap_url_tag("u:index|uc_carry_revoke_apply|"."".""); 
?>';
					var dltid =  $.trim($("#dltid_<?php echo $this->_var['item']['id']; ?>").val());
					var query = newObject();
					query.dltid = $.trim($("#dltid_<?php echo $this->_var['item']['id']; ?>").val());
					query.status = 4;
					query.post_type = "json";
					$.ajax({
						url:ajaxurl,
						data:query,
						type:"Post",
						dataType:"json",
						success:function(data){
							$.alert(data.show_err);
								window.location.href = '<?php
echo parse_wap_url_tag("u:index|uc_carry_money_log|"."".""); 
?>';
						}
					
					});
					  
					$(this).parents(".float_block").hide();
				});
				</script>
			</p>
		</div>
	</li>
	
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($_REQUEST['is_ajax'] != 1): ?>	
</ul>
   <div class="w_b but_box_parent padding">
		<div class="w_b_f_1 but_box">
			<a class="but_this" href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_bank|"."".""); 
?>','#uc_bank',2);">提现</a>
		</div>
	</div>
	<!-- 加载提示符 -->
<div class="infinite-scroll-preloader">
  <div class="preloader">
  </div>
</div>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>
