<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content infinite-scroll" data-distance="<?php echo $this->_var['data']['rs_count']; ?>"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|uc_voucher#index|"."".""); 
?>">
<!-- 这里是页面内容区 -->

<!--我的红包-->
<div class="blank055"></div>
<div class="doexchange_block">
	<div class="add_address">
		<a href="<?php
echo parse_wap_url_tag("u:index|uc_voucher_exchange|"."".""); 
?>">
			<i class="icon iconfont">&#xe643;</i>
			<span>兑换红包</span>
		</a>
	</div>	
</div>
<div class="blank055"></div>
<div class="invest">
<?php endif; ?>
<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ecv');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['ecv']):
?>
<div class="voucher_block ">
	<ul>
		<li class="f_l ecv_name">
         	<?php echo $this->_var['ecv']['name']; ?> 
		</li>
		<li class="exlimit">
			<span class="name">使用期限:</span>
            <?php echo $this->_var['ecv']['limit_time']; ?>
		</li>
		
		<li class="price-box price-box-<?php echo $this->_var['ecv']['status']; ?> f_r ">
			<span class="price">
			<?php 
$k = array (
  'name' => 'number_format',
  'value' => $this->_var['ecv']['money'],
  'f' => '1',
);
echo $k['name']($k['value'],$k['f']);
?>
			</span>
			<span class="used">已使用:<?php echo $this->_var['ecv']['use_count']; ?>次</span>
			<span class="status status_<?php echo $this->_var['ecv']['status']; ?>"></span>
			<span class="border-img"></span>
		</li>
		
	</ul>
</div>

<div class="blank055"></div>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
<?php if ($_REQUEST['is_ajax'] != 1): ?>
</div>
<!-- 加载提示符 -->
<div class="infinite-scroll-preloader">
  <div class="preloader">
  </div>
</div>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>





