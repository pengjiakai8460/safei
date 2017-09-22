<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_setting#index");
	$this->_var['back_page'] = "#uc_setting";
    $this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_setting" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<!-- 这里是页面内容区 -->

<!--收货地址-->
<div class="blank15"></div>
<div class="list-block inset  ">
	<ul>
		<li >
			<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_address|"."".""); 
?>','#uc_address',2)" class="item-link item-content">
				<div class="item-inner">
					<div class="item-title-row">
						<div class="item-title">
							<i class="fa fa-plus-square-o"></i>
							<span>添加地址</span>
						</div>
					</div>
				</div>
			</a>
		</li>
	</ul>
	
</div>
<div class="blank15"></div>
<?php $_from = $this->_var['data']['user_address']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['item']):
?>
<div class="list-block media-list inset  <?php if ($this->_var['item']['is_default'] == 1): ?>y<?php endif; ?> address-box-<?php echo $this->_var['item']['id']; ?>">
	<ul>
		<li >
			<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_address|"."id=".$this->_var['item']['id']."".""); 
?>','#uc_address',2)" class="item-link item-content">
				<div class="item-inner">
					<div class="item-title-row">
						<div class="item-title">姓名:</div>
				        <div class="item-after"><?php echo $this->_var['item']['name']; ?></div>
				    </div>
			
					<div class="item-title-row">
						<div class="item-title">手机号码:</div>
			             <div class="item-after"><?php echo $this->_var['item']['phone']; ?></div>
					</div>
			
					<div class="item-title-row">
						<div class="item-title">省市:</div>
			            <div class="item-after"><?php echo $this->_var['item']['provinces_cities']; ?></div>
					</div>
			
					<div class="item-title-row">
						<div class="item-title">详细地址:</div>
			           <div class="item-after"><?php echo $this->_var['item']['address']; ?></div>
					</div>
			
					<div class="item-title-row">
						<div class="item-title">邮编:</div>
			            <div class="item-after"> <?php echo $this->_var['item']['zip_code']; ?></div>
					</div>
				</div>
			</a>
   		</li>
    </ul>
</div>
<div class="blank15 address-box-<?php echo $this->_var['item']['id']; ?>"></div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php echo $this->fetch('./inc/footer.html'); ?>






