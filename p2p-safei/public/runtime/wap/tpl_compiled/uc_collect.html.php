<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content infinite-scroll pull-to-refresh-content" now_page="1"  data-distance="<?php echo $this->_var['data']['rs_count']; ?>"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|uc_collect#index|"."".""); 
?>">
<!-- 这里是页面内容区 -->
<!--我关注的标列表-->
<div class="blank055"></div>
<ul class="detail_list invest">
	<?php endif; ?>
	<!-- 默认的下拉刷新层 -->
    <div class="pull-to-refresh-layer" all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" >
        <div class="preloader"></div>
        <div class="pull-to-refresh-arrow"></div>
    </div>
		<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'deal');if (count($_from)):
    foreach ($_from AS $this->_var['deal']):
?>
		<li>
			        <?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] > 0): ?><div class="h clearfix b_3b95d3"><?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] <= 0): ?><div class="h clearfix b_b0b0b0"><?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 2): ?><div class="h clearfix b_ff6f6f"><?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 3): ?><div class="h clearfix b_b0b0b0"><?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 4): ?><div class="h clearfix b_ff8800"><?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 5): ?><div class="h clearfix b_a4ce1c"><?php endif; ?>	
				<span class="Status">
					<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] > 0): ?>进行中<?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] <= 0): ?>已过期<?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 2): ?>满标<?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 3): ?>流标<?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 4): ?>还款中<?php endif; ?>
					<?php if ($this->_var['deal']['deal_status'] == 5): ?>已还款<?php endif; ?>
				</span>
				<div class="bor clearfix">
					<span class="name f_l"><?php echo $this->_var['deal']['name']; ?></span>
			        <a class="delete" rel="<?php echo $this->_var['deal']['id']; ?>">取消关注</a>
				</div>
			</div>
			
			<div class="bor_1">
				<div class="middle clearfix">
					<table>
						<tr>
							<td>
								<span class="name">金额</span>
								<span><?php echo $this->_var['deal']['borrow_amount_format']; ?></span>
							</td>
							<td>
								<span class="name">年利率</span>
								<span class="c_ff8800"><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['deal']['rate'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?>%</span>
							</td>
							<td>
								<span class="name" >期限</span>
								<span><?php echo $this->_var['deal']['repay_time']; ?><?php if ($this->_var['deal']['repay_time_type'] == 0): ?>天<?php else: ?>个月<?php endif; ?></span>
							</td>
							<td>				            								
								<div  class="progress-radial_parent ">
										<div class="progress-radial  progress-<?php 
$k = array (
  'name' => 'round',
  'v' => $this->_var['deal']['progress_point'],
  'f' => '0',
);
echo $k['name']($k['v'],$k['f']);
?>
										<?php if ($this->_var['deal']['is_wait'] == 1): ?> c999999
						            	<?php else: ?>
										<?php if ($this->_var['deal']['deal_status'] == 0): ?>  c999999 <?php endif; ?>
										<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] > 0): ?>  c56b1ea <?php endif; ?>
										<?php if ($this->_var['deal']['deal_status'] == 1 && $this->_var['deal']['remain_time'] <= 0): ?>  c999999 <?php endif; ?>
										<?php if ($this->_var['deal']['deal_status'] == 2): ?>  ea544a <?php endif; ?>
										<?php if ($this->_var['deal']['deal_status'] == 3): ?>  c999999  <?php endif; ?>
										<?php if ($this->_var['deal']['deal_status'] == 4): ?>  c66d191  <?php endif; ?>
										<?php if ($this->_var['deal']['deal_status'] == 5): ?>  c999999  <?php endif; ?>
										<?php endif; ?>
										"><b></b></div>
									</div>
								</div>
								</td>
						</tr>
					</table>
				</div>
				<div class="bottom clearfix">
					<span class="time">发布日期<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['deal']['start_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?></span>
					<?php if ($this->_var['deal']['has_transfer'] > 0 && $this->_var['deal']['t_user_id'] <> $this->_var['data']['user_id']): ?>
					<div class="f_r">
						<a href="#" class="but_b bor_b0b0b0 b_b0b0b0">已转让</a>
					</div>
					<?php else: ?>
					<div class="f_r">
						<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|deal_mobile|"."id=".$this->_var['deal']['id']."&epage=".$this->_var['data']['act']."".""); 
?>','#deal_mobile',2);" class="but_c c_aad421 bor_aad421">标的详情</a>
					<?php if ($this->_var['deal']['deal_status'] >= 4): ?>
						<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_invest_refdetail|"."id=".$this->_var['deal']['id']."&load_id=".$this->_var['deal']['load_id']."&epage=".$this->_var['data']['act']."".""); 
?>','#uc_invest_refdetail',2);" class="but_c bor_3b95d3 c_3b95d3">回款详情</a>
					<?php endif; ?>
					</div>
					<?php endif; ?>
					
					
			   </div>
			</div>
		</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>		
	<?php if ($_REQUEST['is_ajax'] != 1): ?>
		</ul>
		<!-- 加载提示符 -->
		<div class="infinite-scroll-preloader">
		  <div class="preloader">
		  </div>
		</div>
 <?php echo $this->fetch('./inc/footer.html'); ?>
    <?php endif; ?>






