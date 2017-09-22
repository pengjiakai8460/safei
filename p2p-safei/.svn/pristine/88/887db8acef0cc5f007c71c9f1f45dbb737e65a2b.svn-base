<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
		<?php
	$this->_var['back_url'] = wap_url("index","uc_bank#index");
	$this->_var['back_page'] = "#uc_bank";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_bank" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<?php endif; ?>
<!-- 这里是页面内容区 -->

<!--添加提现银行列表-->
<div class="uc_add_bank">
			<div class="bank_bg">
				<ul>
					<?php if ($this->_var['data']['response_code'] == 0): ?>
					<li class="dl" style="height:auto;padding:10px" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_credit|"."".""); 
?>','#uc_credit',2);">
						<span style="font-size: 18px;color: red;"><?php echo $this->_var['data']['show_err']; ?></span>
					</div>
					<?php endif; ?>
					<li class="dl">
						<span class="name">开户名</span>
						<div class="info">
							<input type="text" value="<?php echo $this->_var['data']['real_name']; ?>" readonly="true"/>
						</div>
						
					</li>
					<li class="dl">
						<span class="name">开户行</span>
						<div class="info">
							<input id="bankzone" type="text" placeholder="请输入开户行"/>
						</div>
					</li>
					<li class="dl">
						<span class="name">银行卡号</span>
						<div class="info">
							<input id="bankcard" type="text" placeholder="请输入银行卡号"/>
						</div>
					</li>
					<li class="dl">
						<span class="name">选择银行</span>
						<div class="info bank_list">
							<div class="this_bank">查看银行列表<input type="hidden" value=""></div>
							<div class="seclet_but"><i class="fa fa-chevron-down"></i></div>
							
							
							<ul class="bank_seclet" style="display:none;">
								<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
									<li><?php echo $this->_var['item']['name']; ?><input id="bank_id" type="hidden" value="<?php echo $this->_var['item']['id']; ?>"  /></li>
								<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							</ul>							
						</div>
					</li>
					
					<li class="dl" style="height:auto; padding-right:0px;">
						<span class="name">所在地</span>
						<div class="info">
							<select name='region_lv1' id="region_lv1" style="display: none; margin-right:5px;">
								<option selected='selected' value='1'>中国</option>
							 </select>	
							 <select name='region_lv2' id="region_lv2" class="f_l"  style="height:32px;font-size:16px;line-height:32px;width:70px;margin-right:5px;">
								<option value='0'>选择省</option>
							</select>
												
							<select name='region_lv3' id="region_lv3" class="f_l"  style="height:32px;font-size:16px;line-height:32px ;width:70px;margin-right:5px;">
								<option value='0'>选择市</option>	
							 </select>									
							<select name='region_lv4' id="region_lv4" class="f_l"  style="height:32px;font-size:16px;line-height:32px;width:70px;margin-right:5px;">
								<option value='0'>选择区</option>
							</select>
						</div>
						<div style="height:0px; clear:both"></div>
					</li>
					<li class="dl">
						<span class="name">账户类型</span>
						<div class="info clearfix">
							<span class="card_type f_l">借记卡</span>
							<span class="no_type f_r">不支持信用卡</span>
						</div>
					</li>
					
				</ul>
			</div>			
            <div class="w_b but_box_parent padding">
				<div class="w_b_f_1 but_box">
					<button id="add_bank" class=" but_this">确认</button>
				</div>
				<div class="w_b_f_1 but_box">	
                    <a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_bank|"."".""); 
?>','#uc_bank',2);" class="bg_dbdbdb  but_this">取消</a>	
				</div>
			</div>

<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>




