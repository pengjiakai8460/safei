<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_center#index");
	$this->_var['back_page'] = "#uc_center";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_center" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content infinite-scroll" now_page="1"  data-distance="<?php echo $this->_var['data']['rs_count']; ?>"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|uc_interestrate#index|"."".""); 
?>">
<!-- 这里是页面内容区 -->
<!--我的加息券-->
<div class="blank15"></div>
<div class="doexchange_block">
	<div class="add_address">
		<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|uc_interestrate_exchange|"."".""); 
?>','#uc_interestrate_exchange',2);">
			<i class="fa fa-plus-square-o"></i>
			<span>兑换加息券</span>
		</a>
	</div>
	
</div>
<div class="blank15"></div>
<div class="invest">
	<?php endif; ?>
<?php $_from = $this->_var['data']['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'ecv');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['ecv']):
?>
<div class="voucher_block" id="ir_block_<?php echo $this->_var['key']; ?>" onclick="ItRexChageview('#ir_detail_<?php echo $this->_var['key']; ?>')">
	<ul>
		<li class="f_l ecv_name">
         	<?php echo $this->_var['ecv']['name']; ?> <span class="f_red">x<?php if ($this->_var['ecv']['use_limit'] == 0): ?>无限<?php else: ?><?php echo $this->_var['ecv']['use_limit']; ?><?php endif; ?></span> 	
		</li>
		<li class="exlimit">
			<span class="name">使用期限:</span>
            <?php echo $this->_var['ecv']['limit_time']; ?>
		</li>
		<li class="price-box price-box-<?php echo $this->_var['ecv']['status']; ?> f_r ">
			<span class="price">
			<?php echo $this->_var['ecv']['rate_format']; ?>
			</span>
			<span>已使用:<?php echo $this->_var['ecv']['use_count']; ?>次</span>
			<span class="status status_<?php echo $this->_var['ecv']['status']; ?>"></span>
		</li>
	</ul>
</div>
<div class='ir_detail' id="ir_detail_<?php echo $this->_var['key']; ?>">
	   <div class='ir_item'>
        	说明：<?php if ($this->_var['ecv']['detail']): ?><?php echo $this->_var['ecv']['detail']; ?><?php else: ?>无<?php endif; ?>
            <?php if ($this->_var['ecv']['to_user_id'] == 0): ?>
       		<a class='i_send' onclick="ItRexChageview1('#ir_detail_<?php echo $this->_var['key']; ?>')" href="#">转赠</a>
            <?php endif; ?>
       </div>
       <?php if ($this->_var['ecv']['to_user_id'] == 0): ?>
       <div class='ir_send '>
        	转赠用户名：<input name="user_name" class='f-input mainborder'/>
            <input type="hidden" name="id" value="<?php echo $this->_var['ecv']['i_id']; ?>"/>
            <a class='i_ok' href="#" onclick="ItRexChageview3(this,<?php echo $this->_var['key']; ?>);">确定</a>
       		<a class='i_send' rel="ir_detail_<?php echo $this->_var['key']; ?>" onclick="ItRexChageview2('#ir_detail_<?php echo $this->_var['key']; ?>');" href="#">取消</a>
       </div>
       <?php endif; ?>
</div>
<div class="blank15"></div>
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






