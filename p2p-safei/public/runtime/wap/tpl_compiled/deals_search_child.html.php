<div class="sideToggle_parent">
<input type="checkbox" id="sideToggle_0">
<aside id="aside_0" index-value="0">
	<div class="aside_child_opacity"></div>
	<div class="aside_child_bg">
	<p class="title">
		等级
		<label class="complete" for="sideToggle_0">完成</label>
	</p>
	<dl>
		<dd class="active" data-type-name="不限" data-type-value="0">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe61b;</i>
				<span>不限</span>
			</div>
		</dd>
		<?php $_from = $this->_var['data']['level_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'level');if (count($_from)):
    foreach ($_from AS $this->_var['level']):
?>
		<dd data-type-name="<?php echo $this->_var['level']['name']; ?>以上" data-type-value="<?php echo $this->_var['level']['id']; ?>">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span><?php echo $this->_var['level']['name']; ?>以上</span>
			</div>
		</dd>
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</dl>
	</div>
</aside>
<input type="checkbox" id="sideToggle_1">
<aside id="aside_1" index-value="1">
	<div class="aside_child_opacity"></div>
	<div class="aside_child_bg">
	<p class="title">
		利率
		<label class="complete" for="sideToggle_1">完成</label>
	</p>
	<dl>
		<dd class="active" data-type-name="不限" data-type-value="0">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe61b;</i>
				<span>不限</span>
			</div>
		</dd>
		<dd data-type-name="10%以上" data-type-value="10">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>10%以上</span>
			</div>
		</dd>
		<dd data-type-name="12%以上" data-type-value="12">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>10%以上</span>
			</div>
		</dd>
		<dd data-type-name="15%以上" data-type-value="15">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>15%以上</span>
			</div>
		</dd>
		<dd data-type-name="18%以上" data-type-value="18">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>18%以上</span>
			</div>
		</dd>
	</dl>
	</div>
</aside>
<input type="checkbox" id="sideToggle_2">
<aside id="aside_2" index-value="2">
	<div class="aside_child_opacity"></div>
	<div class="aside_child_bg">
	<p class="title">
		借款状态
		<label class="complete" for="sideToggle_2">完成</label>
	</p>
	<dl>
		<dd class="active" data-type-name="不限" data-type-value="0">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe61b;</i>
				<span>不限</span>
			</div>
		</dd>
		<dd data-type-name="未开始" data-type-value="19">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>未开始</span>
			</div>
		</dd>
		<dd data-type-name="进行中" data-type-value="1">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>进行中</span>
			</div>
		</dd>
		<dd data-type-name="满标" data-type-value="2">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>满标</span>
			</div>
		</dd>
		<dd data-type-name="流标" data-type-value="3">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>流标</span>
			</div>
		</dd>
		<dd data-type-name="还款中" data-type-value="4">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>还款中</span>
			</div>
		</dd>
		<dd data-type-name="已还清" data-type-value="5">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>已还清</span>
			</div>
		</dd>
	</dl>
	</div>
</aside>
<input type="checkbox" id="sideToggle_3">
<aside id="aside_3" index-value="3">
	<div class="aside_child_opacity"></div>
	<div class="aside_child_bg">
	<p class="title">
		剩余时间
		<label class="complete" for="sideToggle_3">完成</label>
	</p>
	<dl>
		<dd class="active" data-type-name="不限" data-type-value="0">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe61b;</i>
				<span>不限</span>
			</div>
		</dd>
		<dd data-type-name="1天以内" data-type-value="1">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>1天以内</span>
			</div>
		</dd>
		<dd data-type-name="3天以内" data-type-value="3">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>3天以内</span>
			</div>
		</dd>
		<dd data-type-name="6天以内" data-type-value="6">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>6天以内</span>
			</div>
		</dd>
		<dd data-type-name="9天以内" data-type-value="9">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>9天以内</span>
			</div>
		</dd>
		<dd data-type-name="12天以内" data-type-value="12">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>12天以内</span>
			</div>
		</dd>		
	</dl>
	</div>
</aside>
<input type="checkbox" id="sideToggle_4">
<aside id="aside_4" index-value="4">
	<div class="aside_child_opacity"></div>
	<div class="aside_child_bg">
	<p class="title">
		期限
		<label class="complete" for="sideToggle_4">完成</label>
	</p>
	<dl>
		<dd class="active" data-type-name="不限" data-type-value="0">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe61b;</i>
				<span>不限</span>
			</div>
		</dd>
		<dd data-type-name="3个月以下" data-type-value="1">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>3个月以下</span>
			</div>
		</dd>
		<dd data-type-name="3-6个月" data-type-value="2">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>3-6个月</span>
			</div>
		</dd>
		<dd data-type-name="6-9个月" data-type-value="3">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>6-9个月</span>
			</div>
		</dd>
		<dd data-type-name="9-12个月" data-type-value="4">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>9-12个月</span>
			</div>
		</dd>
		<dd data-type-name="12个月以上" data-type-value="5">
			<div class="bb1 bor">
				<i class="icon iconfont icon_left">&#xe63d;</i>
				<span>12个月以上</span>
			</div>
		</dd>		
	</dl>
	</div>
</aside>
</div>