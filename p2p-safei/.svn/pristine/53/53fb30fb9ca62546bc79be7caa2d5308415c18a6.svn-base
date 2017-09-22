<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_invest#index",array("id"=>$this->_var['data']['status']));
	$this->_var['back_page'] = "#uc_invest";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_invest" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<!-- 这里是页面内容区 -->

<!--回款详情-->
<div class="blank15"></div>
<div class="Repayment_block_0 r-b">
	 <?php $_from = $this->_var['data']['user_load_ids']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'user_load');$this->_foreach['user_load'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['user_load']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['user_load']):
        $this->_foreach['user_load']['iteration']++;
?> 
	<h5 class="clearfix">
			<span class="f_l"><?php echo $this->_var['data']['deal']['name']; ?></span>
			<a class="f_r"  href="#" onclick="RouterURL('<?php echo $this->_var['data']['agree_url']; ?>','#deal_contract',2);" >查看电子协议</a>

	</h5>
	
	<table>
		<tr>
			<td class="name">借款金额：</td>
			<td><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">年利率：</td>
			<td class="specialfont "><?php echo $this->_var['data']['deal']['rate_foramt_w']; ?></td>
		</tr>
		<tr>
			<td class="name">期限：</td>
			<td><?php echo $this->_var['data']['deal']['repay_time']; ?><?php if ($this->_var['data']['deal']['repay_time_type'] == 0): ?>天<?php else: ?>个月<?php endif; ?></td>
		</tr>
		<tr>
			<td class="name">已还本息：</td>
			<td><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['repay_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">管理费：</td>
			<td><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['manage_fee'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">利息管理费：</td>
			<td><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['manage_interest_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">逾期/违约：</td>
			<td><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['impose_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">还款方式：</td>
			<td><?php 
$k = array (
  'name' => 'loantypename',
  'v' => $this->_var['data']['deal']['loantype'],
);
echo $k['name']($k['v']);
?></td>
		</tr>
	</table>

</div>
<div class="blank15"></div>
<div class="Repayment_block_1">
	<div class="left_h">
		<ul>
			<li>期数</li>
			<li>还款日</li>
			<li>实际还款日</li>
			<li>待收款</li>
			<li>管理费</li>
			<li>利息管理费</li>
			<li>逾期/违约金</li>
			<li>预期收益</li>
			<li>实际收益</li>
			<li>状态</li>
		</ul>
	</div>
	<div class="r_content_list" id="r_content_list">
		<ul>
			<?php $_from = $this->_var['user_load']['load']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'loan');$this->_foreach['loans'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loans']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['loan']):
        $this->_foreach['loans']['iteration']++;
?>
			<li>
				<dl>
					<dd>第<?php echo $this->_var['loan']['l_key_index']; ?>期</dd>
					<dd>
					<?php if ($this->_var['deal']['loantype'] == 0 || $this->_var['deal']['loantype'] == 1 || ($this->_foreach['loans']['iteration'] == $this->_foreach['loans']['total'])): ?>
                	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['loan']['repay_day'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
					<?php else: ?>
					&nbsp;
					<?php endif; ?>
					</dd>
					<dd><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['loan']['true_repay_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>&nbsp;</dd>
					<dd><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['loan']['month_repay_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?>&nbsp;</dd>
					<dd><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['loan']['manage_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?>&nbsp;</dd>
					<dd><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['loan']['manage_interest_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?>&nbsp;</dd>
					<dd><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php if ($this->_var['loan']['impose_money'] != 0): ?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['loan']['impose_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?><?php else: ?>0.00<?php endif; ?>&nbsp;</dd>
					<dd><?php echo $this->_var['loan']['yuqi_money']; ?>&nbsp;</dd>
					<dd><?php echo $this->_var['loan']['real_money']; ?>&nbsp;</dd>
					<dd><?php echo $this->_var['loan']['status_format']; ?>&nbsp;</dd>
				</dl>
			</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<div class="pre"><i class="fa fa-chevron-left"></i></div>
		<div class="next"><i class="fa fa-chevron-right"></i></div>
	</div>
</div>
<div class="blank15"></div>
<div class="Repayment_block_2 r-b">
	<?php if ($this->_var['data']['inrepay_info']): ?>
	<h5>因借款者在<span class="c_ff4a4a"><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['inrepay_info']['true_repay_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?></span>提前还款，故计算方式改变</h5>
	<?php endif; ?>
	<table>
		<tr>
			<td class="name">管理费：</td>
			<td class="c_ff4a4a"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['manage_fee'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">利息管理费：</td>
			<td class="c_ff4a4a"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['manage_interest_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">逾期/违约：</td>
			<td class="c_ff4a4a"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['impose_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
		<tr>
			<td class="name">本息还款：</td>
			<td class="c_ff4a4a"><?php 
$k = array (
  'name' => 'app_conf',
  'v' => 'CURRENCY_UNIT',
);
echo $k['name']($k['v']);
?><?php 
$k = array (
  'name' => 'number_format',
  'v' => $this->_var['user_load']['repay_money'],
  'f' => '2',
);
echo $k['name']($k['v'],$k['f']);
?></td>
		</tr>
	</table>
</div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
<script>
	$(document).ready(function(){
		var window_width=window.innerWidth;
		var x=(window_width-20)*0.76;	
		var y=x*0.33;
		var length=$(".Repayment_block_1 .r_content_list ul li").length*(y+1);
		var length_0=$(".Repayment_block_1 .r_content_list ul li").length;
		var img=$(".Repayment_block_1 .r_content_list ul");
      
		
		$(".Repayment_block_1 .r_content_list ul li").width(y);
		$(".Repayment_block_1 .r_content_list ul").width(length);


		
		if (length_0>3) 
		{
             $(".Repayment_block_1 .r_content_list .pre").show();
			 $(".Repayment_block_1 .r_content_list .next").show();

             $(".Repayment_block_1 .r_content_list .pre").click(function()
             {
             	img.animate({'margin-left':-y},function()           
                  {
                   img.find('li').eq(0).appendTo(img);      
                   img.css({'margin-left':0});              
                   });
             });

              $(".Repayment_block_1 .r_content_list .next").click(function()
             {
             	img.find('li:last').prependTo(img);                
		        img.css({'margin-left':-y});                       
		        img.animate({'margin-left':0});  
             });
		}
		else
		{
			$(".Repayment_block_1 .r_content_list .pre").hide();
			$(".Repayment_block_1 .r_content_list .next").hide();
		};
	});
</script>

<?php echo $this->fetch('./inc/footer.html'); ?>
