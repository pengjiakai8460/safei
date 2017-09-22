<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php
$this->_var['search_url'] = wap_url("index","deals_search");
$this->_var['search_act'] = "deals_search";

$this->_var['back_url'] = wap_url("index","deals#index");
$this->_var['back_page'] = "#deals";
$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#deals" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content infinite-scroll deals_search_content"  data-distance="<?php echo $this->_var['data']['rs_count']; ?>"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|deals#index|"."".""); 
?>">
<?php endif; ?>	


<ul class="deals_search_list">
	<li data-type="level" data-type-name="不限" data-type-value="0" class="top_bor">
		<label  class="w_b" for="sideToggle_0">
		    <i class="icon iconfont icon_left">&#xe60a;</i>
			<p class="name w_b_f_1 ">等级</p>
			<span class="conditions w_b_f_1 tr ">不限</span>
			<i class="icon iconfont icon_rigth tr">&#xe61a;</i>
		</label>
	</li>
	<li data-type="interest" data-type-name="不限" data-type-value="0" class="top_bor">
		<label  class="w_b" for="sideToggle_1">
			<i class="icon iconfont icon_left">&#xe611;</i>
			<p class="name w_b_f_1 ">利率</p>
			<span class="conditions w_b_f_1 tr">不限</span>
			<i class="icon iconfont icon_rigth tr">&#xe61a;</i>
		</label>
	</li>
	<li data-type="deal_status" data-type-name="不限" data-type-value="0" class="top_bor">
		<label  class="w_b" for="sideToggle_2">
			<i class="icon iconfont icon_left">&#xe620;</i>
			<p class="name w_b_f_1 ">借款状态</p>
			<span class="conditions w_b_f_1 tr">不限</span>
			<i class="icon iconfont icon_rigth tr">&#xe61a;</i>
		</label>
	</li>
	<li data-type="lefttime" data-type-name="不限" data-type-value="0" class="top_bor">
		<label  class="w_b" for="sideToggle_3">
			<i class="icon iconfont icon_left">&#xe612;</i>
			<p class="name w_b_f_1 ">剩余时间</p>
			<span class="conditions w_b_f_1 tr">不限</span>
			<i class="icon iconfont icon_rigth tr">&#xe61a;</i>
		</label>
	</li>
	<li data-type="months_type" data-type-name="不限" data-type-value="0" class="top_bor">
		<label  class="w_b" for="sideToggle_4">
			<i class="icon iconfont icon_left">&#xe610;</i>
			<p class="name w_b_f_1 ">期限</p>
			<span class="conditions w_b_f_1 tr">不限</span>
			<i class="icon iconfont icon_rigth tr">&#xe61a;</i>
		</label>
	</li>
</ul>
<div class="d_search_box w_b">
	<a href="#" class="reset">重置</a>
	<a href="#" class="click_search w_b_f_1">点击搜索</a>
</div>
<?php echo $this->fetch('./inc/deals_search_child.html'); ?>
<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>