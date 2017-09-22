<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_bank#index");
	$this->_var['back_page'] = "#uc_bank";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_bank" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<!-- 这里是页面内容区 -->

<!--申请提现-->
<div class="uc_add_bank">
	
			<div class="bank_bg">
				<ul>
				<?php $_from = $this->_var['data']['bank_carry']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
					<li class="dl">
						<span class="name">卡号</span>
						<div class="info">
							<p class="info_num">
								<?php echo $this->_var['item']['bankcard']; ?>
							</p>
						</div>
						
					</li>
					<input id="band_id" type="hidden" value="<?php echo $this->_var['item']['id']; ?>">
					<li class="dl">
						<span class="name">银行</span>
						<div class="info">
							<img src="<?php echo $this->_var['item']['uimg']; ?>" width="142px;" height="40px;" title="银行图片展示">
						</div>
					</li>
					
					<li class="dl">
						<span class="name">姓名</span>
						<div class="info">
							<p class="info_num">
								<?php echo $this->_var['item']['real_name']; ?>
							</p>
						</div>
					</li>
					<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</ul>
			</div>
			
			<div class="bank_bg">
				<ul>
					<li class="dl">
						<span class="name">可用金额</span>
						<div id="Jcarry_totalAmount" class="info">
							<input id="Jcarry_totalAmount" type="hidden" value="<?php echo $this->_var['data']['money']; ?>">
							<p class="info_num">
								￥<?php echo $this->_var['data']['money']; ?>
							</p>
						</div>
						
					</li>
					<li class="dl">
                        <span class="name">不可提现</span>
                        <div id="nmc_amount" class="info">
                            <p class="info_num">
                                                                                            ￥<?php echo $this->_var['data']['nmc_amount']; ?>
								<input id="Jcarry_nmc_amount" type="hidden" value="<?php echo $this->_var['data']['nmc_amount']; ?>">															
                            </p>
                        </div>
                        
                    </li>
					
					<li class="dl">
						<span class="name">手续费</span>
						<div class="info">
							<p class="info_num">
								<span id="Jcarry_fee" class="f_l">0.00 元</span>
							</p>
						</div>
					</li>
					
					<li class="dl">
						<span class="name">实付金额</span>
						<div class="info">
							<p class="info_num specialfont">
								<span id="Jcarry_realAmount" class="f_l">0.00 元</span>
							</p>
						</div>
					</li>
					
				</ul>
			</div>
			
			<div class="bank_bg">
				<ul>
					<li class="dl">
						<span class="name">提取金额</span>
						<div class="info">
							<input id="Jcarry_amount" type="text" placeholder="请输入金额"/>
						</div>
					</li>
					<li>
						<div class="info">
							<span id="Jcarry_balance" class="info_num specialfont"></span>
						</div>
					</li>
					<li class="dl">
						<span class="name">支付密码</span>
						<div class="info">
							<input id="paypassword" type="password" placeholder="请输入密码"/>
						</div>
					</li>
				</ul>
			</div>
			<div class="specialfont presentation">
				提现时间约为3个工作日
			</div>

	         <div class="w_b but_box_parent padding">
					<div class="w_b_f_1 but_box">
					    <input type="hidden" name="json_fee" value='<?php echo $this->_var['data']['json_fee']; ?>' />
						<input type="hidden" name="money" value="<?php echo $this->_var['data']['money']; ?>" />
						<input type="hidden" name="nmc_amount" value="<?php echo $this->_var['data']['nmc_amount']; ?>" />
					    <button class="but_this">申请提现</button>
					</div>
			</div>
</div>

<?php echo $this->fetch('./inc/footer.html'); ?>




