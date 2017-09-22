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

<!--提现银行列表-->
<div class="Menubox">
        <ul>
            <!-- ly修改 -->
            <!-- <li id="one1" onclick="setBkTabS('one',1,3)" class="hover">普通提现</li> -->
            <li id="one1" class="hover" style="width: 100%;">普通提现</li>
            <!-- <li id="one2" onclick="setBkTabS('one',2,3)">第三方提现</li> -->
          </ul>
</div>
<div id="con_one_1" class="uc_incharge"><!--普通提现-->	
	<div class="bank_bg">
		<ul>
		<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
			<li class="checkin">
				<img src="<?php echo $this->_var['item']['img']; ?>" title="<?php echo $this->_var['item']['bank_name']; ?>">
					<a href="<?php
echo parse_wap_url_tag("u:index|uc_carry_money|"."bid=".$this->_var['item']['id']."".""); 
?>">
						<div class="detail">
							<h6><?php echo $this->_var['item']['bank_name']; ?></h6>
							<span><?php echo $this->_var['item']['bankcard']; ?></span>
							<span><?php echo $this->_var['item']['real_name']; ?></span>
						</div>
					</a>
				<div>
					<!-- ly修改 -->
					<!-- <a class="delete" data-id="<?php echo $this->_var['item']['id']; ?>"><i class="fa fa-times"></i></a> -->
				</div>
			</li>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			
		</ul>
	</div>
	<!-- ly修改 -->
	<?php if ($this->_var['data']['item']): ?>
	<?php else: ?>
	<div class="bank_bg">
		<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_add_bank|"."".""); 
?>','#uc_add_bank',2);">
			<div class="add_bank_card">
				<span>添加银行卡</span>
				<i class="fa fa-chevron-right"></i>
			</div>
		</a>
	</div>
	<?php endif; ?>
</div>




<div id="con_one_2" class="uc_incharge"   style=" display:none;"><!--第三方提现-->
	<div class="figure">
			<input id="pTrdAmt" class="" type="text" style="height:39px;" placeholder="请输入金额">
	</div>
	<div class="balance_detail">
	
		<ul>
			<li>
				<span>可用资金</span>
				<font>
					<input type="hidden" name="ips_money" id="ips_money" value='<?php echo $this->_var['data']['ips_money']; ?>'>
					<?php if ($this->_var['data']['ips_money']): ?><?php echo $this->_var['data']['ips_money']; ?><?php else: ?>0<?php endif; ?>元
				</font>
			</li>
			<li>
				<span>提现费用</span>
				<font>
                    <a id="Jcarry_fee" class="f_l">0.00 元</a>
				</font>
			</li>
		
		</ul>
	</div>
	

<div class="w_b but_box_parent padding">
		<div class="w_b_f_1 but_box">
			<input type="hidden" name="json_fee" value='<?php echo $this->_var['data']['json_fee']; ?>'>
			<button class="uc_bank but_this">确认</button>
		</div>
	</div>

</div>


<?php echo $this->fetch('./inc/footer.html'); ?>